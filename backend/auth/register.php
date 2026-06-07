<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

require '../connection.php';

//$fullname = trim($_POST['fullname'] ?? '');

$first_name =
    trim($_POST['first_name'] ?? '');

$middle_name =
    trim($_POST['middle_name'] ?? '');

$last_name =
    trim($_POST['last_name'] ?? '');

$email =
    trim($_POST['email'] ?? '');

$password =
    trim($_POST['password'] ?? '');


// =====================================
// VALIDATION
// =====================================

if (
    //empty($fullname) ||
    empty($first_name) ||
    empty($last_name) ||
    empty($email) ||
    empty($password)
) {

    echo json_encode([
        "success" => false,
        "message" => "All fields are required."
    ]);

    exit;
}

// VALIDATE PASSWORD

if (
    !preg_match(
        '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/',
        $password
    )
) {

    echo json_encode([
        "success" => false,
        "message" =>
        "Password must contain uppercase, lowercase, number and special character."
    ]);

    exit;
}


// =====================================
// CHECK IF EMAIL EXISTS
// =====================================

$check_sql = "
SELECT id
FROM users
WHERE email = ?
";

$check_stmt = $conn->prepare($check_sql);

$check_stmt->bind_param("s", $email);

$check_stmt->execute();

$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {

    echo json_encode([
        "success" => false,
        "message" => "Email already exists."
    ]);

    exit;
}


// =====================================
// HASH PASSWORD
// =====================================

$hashed_password =
    password_hash(
        $password,
        PASSWORD_DEFAULT
    );


// =====================================
// INSERT USER
// =====================================

$insert_sql = "
INSERT INTO users
(
    first_name,
    middle_name,
    last_name,
    email,
    password
)
VALUES
(
    ?, ?, ?, ?, ?
)
";

$insert_stmt = $conn->prepare($insert_sql);

$insert_stmt->bind_param(
    "sssss",
    $first_name,
    $middle_name,
    $last_name,
    $email,
    $hashed_password
);

$success = $insert_stmt->execute();


// =====================================
// RESPONSE
// =====================================

if ($success) {

    echo json_encode([
        "success" => true,
        "message" => "Registration successful."
    ]);
} else {

    echo json_encode([
        "success" => false,
        "message" => "Registration failed."
    ]);
}
