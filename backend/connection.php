<?php

date_default_timezone_set('Asia/Manila');

$host = "localhost";
$username = "root";
$password = "P@ssword3309807";
$database = "expense_tracker";

$conn = new mysqli(
    $host,
    $username,
    $password,
    $database
);

$conn->query("SET time_zone = '+08:00'");

if ($conn->connect_error) {

    die("Database Connection Failed: " .
        $conn->connect_error);
}
