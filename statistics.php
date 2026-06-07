<?php
require 'backend/session_check.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Statistics</title>
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#FFC507">

    <!-- FONT AWESOME -->
    <script src="https://kit.fontawesome.com/92cde7fc6f.js"
        crossorigin="anonymous"></script>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" type="image/x-icon" href="images/peso-check.ico">

    <!-- FONT -->
    <link rel="preconnect"
        href="https://fonts.googleapis.com">

    <link rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap"
        rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="css/theme.css">
    <link rel="stylesheet" href="css/statistics.css">

    <!-- APPLE SUPPORT -->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Peso Check">

    <link
        rel="apple-touch-icon"
        href="images/icon-192.png">

</head>

<body>

    <!-- HEADER -->

    <div class="statistics-header">

        <h4>
            Statistics
        </h4>

        <p>
            Track your spending insights
        </p>

    </div>

    <!-- CONTENT -->

    <div class="statistics-layout">

        <!-- SUMMARY -->

        <div class="container-fluid">

            <div class="row g-3">
                <div class="col-6">
                    <div class="stat-card">
                        <i class="fa-solid fa-sun"></i>
                        <div class="stat-label">
                            Today
                        </div>
                        <div id="dailyTotal"
                            class="stat-value">
                            ₱0.00
                        </div>
                    </div>

                </div>

                <div class="col-6">
                    <div class="stat-card">
                        <i class="fa-solid fa-calendar-week"></i>
                        <div class="stat-label">
                            This Week
                        </div>
                        <div id="weeklyTotal"
                            class="stat-value">
                            ₱0.00
                        </div>
                    </div>

                </div>

                <div class="col-6">

                    <div class="stat-card">
                        <i class="fa-solid fa-calendar-days"></i>
                        <div class="stat-label">
                            This Month
                        </div>
                        <div id="monthlyTotal"
                            class="stat-value">
                            ₱0.00
                        </div>
                    </div>

                </div>

                <div class="col-6">

                    <div class="stat-card">
                        <i class="fa-solid fa-chart-line"></i>
                        <div class="stat-label">
                            This Year
                        </div>
                        <div id="yearlyTotal"
                            class="stat-value">
                            ₱0.00
                        </div>

                    </div>
                </div>

            </div>

        </div>

        <!-- TOP CATEGORY -->

        <div class="section-title">
            Top Category
        </div>

        <div id="topCategoryCard"
            class="insight-card">

            Loading...

        </div>

        <!-- CATEGORY BREAKDOWN -->

        <div class="section-title">
            Spending Breakdown
        </div>

        <div id="categoryBreakdown">

        </div>

        <!-- CHART PLACEHOLDER -->

        <div class="section-title">
            Spending Trends
        </div>

        <div class="chart-placeholder">

            Charts Coming Soon

        </div>

    </div>

    <!-- BOTTOM NAV -->

    <div class="bottom-nav">

        <a href="dashboard.php"
            class="nav-item-custom">

            <i class="fa-solid fa-house"></i>

            Home

        </a>

        <a href="expenses.php"
            class="nav-item-custom">

            <i class="fa-solid fa-receipt"></i>

            Expenses

        </a>

        <a href="statistics.php"
            class="nav-item-custom nav-active">

            <i class="fa-solid fa-chart-pie"></i>

            Stats

        </a>

        <a href="profile.php"
            class="nav-item-custom">

            <i class="fa-solid fa-user"></i>

            Profile

        </a>

    </div>

    <script src="js/theme_loader.js"></script>
    <script src="js/utils/expense_helpers.js"></script>
    <script src="js/utils/alerts.js"></script>
    <script src="js/statistics.js"></script>
    <script src="js/pwa.js"></script>
</body>

</html>