<?php

require 'api_session_check.php';
require 'connection.php';

$user_id = $_SESSION['user_id'];

$sql = "
SELECT
    category,
    SUM(amount) AS total
FROM expenses
WHERE user_id = ?
GROUP BY category
ORDER BY total DESC
";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "i",
    $user_id
);

$stmt->execute();

$result = $stmt->get_result();

$categories = [];

while ($row = $result->fetch_assoc()) {

    $categories[] = [
        "category" => $row['category'],
        "total" => (float)$row['total']
    ];
}

$top_category = null;

if (!empty($categories)) {

    $top_category = $categories[0];
}

echo json_encode([

    "success" => true,

    "top_category" => $top_category,

    "categories" => $categories

]);
