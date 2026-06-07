<?php


require 'api_session_check.php';
require 'connection.php';


// =====================================
// USER
// =====================================

$user_id = $_SESSION['user_id'];


// =====================================
// EXPENSE ID
// =====================================

$expense_id =
    intval($_POST['expense_id'] ?? 0);


// =====================================
// VALIDATION
// =====================================

if ($expense_id <= 0) {

    echo json_encode([
        "success" => false,
        "message" => "Invalid expense ID."
    ]);

    exit;
}


// =====================================
// DELETE ONLY USER'S EXPENSE
// =====================================

$sql = "
DELETE FROM expenses
WHERE id = ?
AND user_id = ?
";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ii",
    $expense_id,
    $user_id
);

$success = $stmt->execute();


// =====================================
// RESPONSE
// =====================================

if ($success) {

    echo json_encode([
        "success" => true,
        "message" => "Expense deleted successfully."
    ]);
} else {

    echo json_encode([
        "success" => false,
        "message" => "Failed to delete expense."
    ]);
}
