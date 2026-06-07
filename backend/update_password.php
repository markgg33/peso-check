<?php

require 'api_session_check.php';
require 'connection.php';

$user_id = $_SESSION['user_id'];

$current_password =
    $_POST['current_password'] ?? '';

$new_password =
    $_POST['new_password'] ?? '';

$confirm_password =
    $_POST['confirm_password'] ?? '';

if (
    empty($current_password) ||
    empty($new_password) ||
    empty($confirm_password)
) {

    echo json_encode([
        "success" => false,
        "message" => "All fields are required."
    ]);

    exit;
}

if (
    $new_password !== $confirm_password
) {

    echo json_encode([
        "success" => false,
        "message" => "Passwords do not match."
    ]);

    exit;
}

if (
    !preg_match(
        '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/',
        $new_password
    )
) {

    echo json_encode([
        "success" => false,
        "message" =>
        "Password must contain uppercase, lowercase, number and special character."
    ]);

    exit;
}

/* GET CURRENT PASSWORD */

$sql = "
SELECT password
FROM users
WHERE id = ?
";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "i",
    $user_id
);

$stmt->execute();

$user =
    $stmt->get_result()
    ->fetch_assoc();

if (
    !password_verify(
        $current_password,
        $user['password']
    )
) {

    echo json_encode([
        "success" => false,
        "message" => "Current password is incorrect."
    ]);

    exit;
}

/* UPDATE */

$hashedPassword =
    password_hash(
        $new_password,
        PASSWORD_DEFAULT
    );

$updateSql = "
UPDATE users
SET password = ?
WHERE id = ?
";

$updateStmt =
    $conn->prepare($updateSql);

$updateStmt->bind_param(
    "si",
    $hashedPassword,
    $user_id
);

$success =
    $updateStmt->execute();

echo json_encode([
    "success" => $success,
    "message" =>
    $success
        ? "Password updated successfully."
        : "Failed to update password."
]);
