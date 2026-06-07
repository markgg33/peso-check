<?php


require 'api_session_check.php';
require 'connection.php';

$user_id = $_SESSION['user_id'];

$expense_id = $_POST['expense_id'] ?? '';
$item_name = trim($_POST['item_name'] ?? '');
$category = trim($_POST['category'] ?? '');
$amount = trim($_POST['amount'] ?? '');
$notes = trim($_POST['notes'] ?? '');
$expense_date =
    trim($_POST['expense_date'] ?? '');

// VALIDATION

if (
    empty($expense_id) ||
    empty($item_name) ||
    empty($category) ||
    empty($amount) ||
    empty($expense_date)
) {

    echo json_encode([
        "success" => false,
        "message" => "All required fields must be filled."
    ]);

    exit;
}

// UPDATE

$sql = "
UPDATE expenses
SET
    item_name = ?,
    category = ?,
    amount = ?,
    notes = ?,
    expense_date = ?
WHERE id = ?
AND user_id = ?
";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ssdssii",
    $item_name,
    $category,
    $amount,
    $notes,
    $expense_date,
    $expense_id,
    $user_id
);

if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "Expense updated successfully."
    ]);
} else {

    echo json_encode([
        "success" => false,
        "message" => "Failed to update expense."
    ]);
}
