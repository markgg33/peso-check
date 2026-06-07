<?php

require 'api_session_check.php';
require 'connection.php';

$user_id = $_SESSION['user_id'];

$theme_name =
    $_POST['theme_name'] ?? 'custom';

$theme_mode =
    $_POST['theme_mode'];

$primary_color =
    $_POST['primary_color'];

$secondary_color =
    $_POST['secondary_color'];

$sql = "
INSERT INTO user_settings
(
    user_id,
    theme_mode,
    theme_name,
    primary_color,
    secondary_color
)
VALUES
(
    ?, ?, ?, ?, ?
)
ON DUPLICATE KEY UPDATE

theme_mode = VALUES(theme_mode),
theme_name = VALUES(theme_name),
primary_color = VALUES(primary_color),
secondary_color = VALUES(secondary_color)
";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "issss",
    $user_id,
    $theme_mode,
    $theme_name,
    $primary_color,
    $secondary_color
);

$success = $stmt->execute();

echo json_encode([
    "success" => $success,
    "message" => $success
        ? "Settings updated."
        : "Failed to update settings."
]);
