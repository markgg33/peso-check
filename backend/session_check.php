<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header(
        "Location: errors/401.php"
    );
    exit;
}