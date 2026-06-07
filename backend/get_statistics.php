<?php


require 'api_session_check.php';
require 'connection.php';


// =====================================
// USER
// =====================================

$user_id = $_SESSION['user_id'];


// =====================================
// TODAY
// =====================================

$today_sql = "
SELECT
    COALESCE(SUM(amount), 0) AS total
FROM expenses
WHERE user_id = ?
AND DATE(expense_date) = CURDATE()
";

$today_stmt = $conn->prepare(
    $today_sql
);

$today_stmt->bind_param(
    "i",
    $user_id
);

$today_stmt->execute();

$today_result =
    $today_stmt
    ->get_result()
    ->fetch_assoc();

$daily_total =
    $today_result['total'];


// =====================================
// WEEKLY
// =====================================

$weekly_sql = "
SELECT
    COALESCE(SUM(amount), 0) AS total
FROM expenses
WHERE user_id = ?
AND YEARWEEK(expense_date, 1)
= YEARWEEK(CURDATE(), 1)
";

$weekly_stmt = $conn->prepare(
    $weekly_sql
);

$weekly_stmt->bind_param(
    "i",
    $user_id
);

$weekly_stmt->execute();

$weekly_result =
    $weekly_stmt
    ->get_result()
    ->fetch_assoc();

$weekly_total =
    $weekly_result['total'];


// =====================================
// MONTHLY
// =====================================

$monthly_sql = "
SELECT
    COALESCE(SUM(amount), 0) AS total
FROM expenses
WHERE user_id = ?
AND MONTH(expense_date)
= MONTH(CURDATE())
AND YEAR(expense_date)
= YEAR(CURDATE())
";

$monthly_stmt = $conn->prepare(
    $monthly_sql
);

$monthly_stmt->bind_param(
    "i",
    $user_id
);

$monthly_stmt->execute();

$monthly_result =
    $monthly_stmt
    ->get_result()
    ->fetch_assoc();

$monthly_total =
    $monthly_result['total'];


// =====================================
// YEARLY
// =====================================

$yearly_sql = "
SELECT
    COALESCE(SUM(amount), 0) AS total
FROM expenses
WHERE user_id = ?
AND YEAR(expense_date)
= YEAR(CURDATE())
";

$yearly_stmt = $conn->prepare(
    $yearly_sql
);

$yearly_stmt->bind_param(
    "i",
    $user_id
);

$yearly_stmt->execute();

$yearly_result =
    $yearly_stmt
    ->get_result()
    ->fetch_assoc();

$yearly_total =
    $yearly_result['total'];


// =====================================
// RESPONSE
// =====================================

echo json_encode([

    "success" => true,

    "daily_total" =>
    $daily_total,

    "weekly_total" =>
    $weekly_total,

    "monthly_total" =>
    $monthly_total,

    "yearly_total" =>
    $yearly_total

]);
