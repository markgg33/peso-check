<?php


require 'api_session_check.php';
require 'connection.php';

// =====================================
// GET USER
// =====================================

$user_id = $_SESSION['user_id'];


// =====================================
// FETCH ALL EXPENSES
// =====================================

$sql = "
SELECT
    *
FROM expenses
WHERE user_id = ?
ORDER BY expense_date DESC
";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "i",
    $user_id
);

$stmt->execute();

$result =
    $stmt->get_result();

$expenses = [];

while (
    $row =
    $result->fetch_assoc()
) {

    $expenses[] = $row;
}

// =====================================
// RESPONSE
// =====================================

echo json_encode([
    "success" => true,
    "expenses" => $expenses
]);
