<?php

require 'api_session_check.php';
require 'connection.php';

$user_id = $_SESSION['user_id'];

$sql = "
SELECT *
FROM user_settings
WHERE user_id = ?
";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "i",
    $user_id
);

$stmt->execute();

$settings =
    $stmt->get_result()->fetch_assoc();

echo json_encode([
    "success" => true,

    "theme_mode" =>
    $settings['theme_mode'] ?? 'light',

    "primary_color" =>
    $settings['primary_color'] ?? '#FFC507',

    "secondary_color" =>
    $settings['secondary_color'] ?? '#65A70F',

    "theme_name" =>
    $settings['theme_name'] ?? 'sunset'
]);

