<?php

session_start();

header('Content-Type: application/json');

require '../connection.php';

$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');


// =====================================
// VALIDATION
// =====================================

if (
    empty($email) ||
    empty($password)
) {

    echo json_encode([
        "success" => false,
        "message" => "All fields are required."
    ]);

    exit;
}


// =====================================
// FIND USER
// =====================================

$sql = "
SELECT *
FROM users
WHERE email = ?
";

$stmt = $conn->prepare($sql);

$stmt->bind_param("s", $email);

$stmt->execute();

$result = $stmt->get_result();


// =====================================
// CHECK USER
// =====================================

if ($result->num_rows === 0) {

    echo json_encode([
        "success" => false,
        "message" => "Invalid email or password."
    ]);

    exit;
}

$user = $result->fetch_assoc();


// =====================================
// VERIFY PASSWORD
// =====================================

if (
    !password_verify(
        $password,
        $user['password']
    )
) {

    echo json_encode([
        "success" => false,
        "message" => "Invalid email or password."
    ]);

    exit;
}


// =====================================
// CREATE SESSION
// =====================================

$_SESSION['user_id'] =
    $user['id'];

$_SESSION['first_name'] =
    $user['first_name'];

$_SESSION['middle_name'] =
    $user['middle_name'];

$_SESSION['last_name'] =
    $user['last_name'];

$middleInitial = '';

if (!empty($user['middle_name'])) {

    $middleInitial =
        strtoupper(substr($user['middle_name'], 0, 1)) . '. ';
}

$_SESSION['fullname'] =
    $user['first_name'] . ' ' .
    $middleInitial .
    $user['last_name'];

$_SESSION['email'] =
    $user['email'];

$_SESSION['avatar'] =
    $user['avatar'];


// =====================================
// RESPONSE
// =====================================

echo json_encode([
    "success" => true,
    "message" => "Login successful."
]);
