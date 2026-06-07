<?php

require 'api_session_check.php';
require 'connection.php';

$user_id = $_SESSION['user_id'];

$sql = "
SELECT
    first_name,
    middle_name,
    last_name,
    email
FROM users
WHERE id = ?
";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "i",
    $user_id
);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

echo json_encode([
    "success" => true,
    "user" => $user
]);
