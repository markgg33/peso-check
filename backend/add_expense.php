<?php

require 'api_session_check.php';
require 'connection.php';

// =====================================
// GET USER
// =====================================

$user_id = $_SESSION['user_id'];


// =====================================
// GET FORM DATA
// =====================================

$item_name =
    trim($_POST['item_name'] ?? '');

$category =
    trim($_POST['category'] ?? '');

$amount =
    trim($_POST['amount'] ?? '');

$notes =
    trim($_POST['notes'] ?? '');

$expense_date =
    trim($_POST['expense_date'] ?? '');


// =====================================
// VALIDATION
// =====================================

if (
    empty($item_name) ||
    empty($category) ||
    empty($amount) ||
    empty($expense_date)
) {

    echo json_encode([
        "success" => false,
        "message" => "Please fill in all required fields."
    ]);

    exit;
}


// =====================================
// VALIDATE AMOUNT
// =====================================

if (!is_numeric($amount)) {

    echo json_encode([
        "success" => false,
        "message" => "Invalid amount."
    ]);

    exit;
}


// =====================================
// INSERT EXPENSE
// =====================================

$sql = "
INSERT INTO expenses
(
    user_id,
    item_name,
    category,
    amount,
    notes,
    expense_date
)
VALUES (?, ?, ?, ?, ?, ?)
";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "issdss",
    $user_id,
    $item_name,
    $category,
    $amount,
    $notes,
    $expense_date
);

$success = $stmt->execute();


// =====================================
// RESPONSE
// =====================================

if ($success) {

    echo json_encode([
        "success" => true,
        "message" => "Expense added successfully."
    ]);
} else {

    echo json_encode([
        "success" => false,
        "message" => "Failed to add expense."
    ]);
}
