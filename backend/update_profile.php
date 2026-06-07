<?php

require 'api_session_check.php';
require 'connection.php';

$user_id = $_SESSION['user_id'];

$first_name =
    trim($_POST['first_name'] ?? '');

$middle_name =
    trim($_POST['middle_name'] ?? '');

$last_name =
    trim($_POST['last_name'] ?? '');

$email =
    trim($_POST['email'] ?? '');

if (
    empty($first_name) ||
    empty($last_name) ||
    empty($email)
) {

    echo json_encode([
        "success" => false,
        "message" => "Required fields are missing."
    ]);

    exit;
}

/* CHECK DUPLICATE EMAIL */

$checkSql = "
SELECT id
FROM users
WHERE email = ?
AND id != ?
";

$checkStmt = $conn->prepare($checkSql);

$checkStmt->bind_param(
    "si",
    $email,
    $user_id
);

$checkStmt->execute();

if (
    $checkStmt
    ->get_result()
    ->num_rows > 0
) {

    echo json_encode([
        "success" => false,
        "message" => "Email already exists."
    ]);

    exit;
}

/* UPDATE */

$sql = "
UPDATE users
SET
    first_name = ?,
    middle_name = ?,
    last_name = ?,
    email = ?
WHERE id = ?
";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ssssi",
    $first_name,
    $middle_name,
    $last_name,
    $email,
    $user_id
);

$success = $stmt->execute();

/* UPDATE SESSION */

if ($success) {

    $_SESSION['email'] = $email;

    $middleInitial = '';

    if (!empty($middle_name)) {
        $middleInitial =
            strtoupper(substr($middle_name, 0, 1)) . '. ';
    }

    $_SESSION['fullname'] =
        $first_name . ' ' .
        $middleInitial .
        $last_name;
}

echo json_encode([
    "success" => $success,
    "message" =>
    $success
        ? "Profile updated successfully."
        : "Failed to update profile."
]);
