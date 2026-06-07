<?php

session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {

    echo json_encode([
        "success" => false,
        "session_expired" => true,
        "message" => "Session expired."
    ]);

    exit;
}
