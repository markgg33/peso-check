<?php

require 'backend/session_check.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Expense History</title>
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#FFC507">
    <!---ICON--->
    <script src="https://kit.fontawesome.com/92cde7fc6f.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="images/peso-check.ico">
    <!---BOOTSTRAP--->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <!---FONTS--->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <!-- SWEETALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="css/theme.css">
    <link rel="stylesheet" href="css/expenses.css">
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
    <div class="expenses-header">

        <div class="header-top">
            <div>
                <h4>
                    Expenses
                </h4>
                <p>
                    Manage your spending history
                </p>
            </div>

        </div>

        <!-- SEARCH -->
        <div class="search-container">

            <div class="search-input-wrapper">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="expenseSearch" placeholder="Search expenses...">
            </div>

            <button class="filter-btn">
                <i class="fa-solid fa-sliders"></i>
            </button>

        </div>

    </div>

    <!-- EXPENSE HISTORY -->
    <div class="expenses-layout">

        <div class="expenses-history">
            <div id="expenseList"></div>
        </div>

    </div>

    <!-- BOTTOM NAV -->
    <div class="bottom-nav">

        <!-- HOME -->
        <a href="dashboard.php" class="nav-item-custom">
            <i class="fa-solid fa-house"></i>
            Home
        </a>

        <!-- EXPENSES -->
        <a href="expenses.php" class="nav-item-custom nav-active">
            <i class="fa-solid fa-receipt"></i>
            Expenses
        </a>

        <!-- STATS -->
        <a href="statistics.php" class="nav-item-custom">
            <i class="fa-solid fa-chart-pie"></i>
            Stats
        </a>

        <!-- PROFILE -->
        <a href="profile.php"
            class="nav-item-custom">

            <i class="fa-solid fa-user"></i>

            Profile

        </a>

    </div>

    <!-- EXPENSE DETAILS MODAL -->
    <div class="modal fade" id="expenseDetailsModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Expense Details
                    </h5>
                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form id="editExpenseForm">
                        <!-- HIDDEN ID -->
                        <input type="hidden"
                            id="editExpenseId">

                        <!-- ICON -->
                        <div class="details-icon"
                            id="detailsIcon">

                            <i class="fa-solid fa-wallet"></i>
                        </div>

                        <!-- ITEM -->
                        <div class="mb-3">
                            <label class="form-label">
                                Item Name
                            </label>

                            <input type="text"
                                class="form-control"
                                id="editItemName"
                                required>
                        </div>

                        <!-- CATEGORY -->
                        <div class="mb-3">
                            <label class="form-label">
                                Category
                            </label>

                            <select class="form-select"
                                id="editCategory"
                                required>

                                <option value="Food">
                                    Food
                                </option>

                                <option value="Transportation">
                                    Transportation
                                </option>

                                <option value="Shopping">
                                    Shopping
                                </option>

                                <option value="Bills">
                                    Bills
                                </option>

                                <option value="Entertainment">
                                    Entertainment
                                </option>

                                <option value="Others">
                                    Others
                                </option>

                            </select>
                        </div>

                        <!-- AMOUNT -->
                        <div class="mb-3">
                            <label class="form-label">
                                Amount
                            </label>

                            <input type="number"
                                class="form-control"
                                id="editAmount"
                                required>
                        </div>

                        <!-- EXPENSE DATE -->

                        <div class="mb-3">

                            <label class="form-label">
                                Expense Date
                            </label>

                            <input
                                type="date"
                                class="form-control"
                                id="editExpenseDate"
                                required>

                        </div>

                        <!-- NOTES -->
                        <div class="mb-3">
                            <label class="form-label">
                                Notes
                            </label>

                            <textarea class="form-control"
                                id="editNotes"
                                rows="3"></textarea>
                        </div>

                        <!-- SAVE -->
                        <button type="submit" class="btn-login w-100">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTER MODAL -->

    <div class="modal fade" id="filterModal" tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Filter Expenses
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <!-- CATEGORY -->

                    <div class="mb-3">

                        <label class="form-label">
                            Category
                        </label>

                        <select
                            id="filterCategory"
                            class="form-select">

                            <option value="">
                                All Categories
                            </option>

                            <option value="Food">Food</option>
                            <option value="Transportation">Transportation</option>
                            <option value="Shopping">Shopping</option>
                            <option value="Bills">Bills</option>
                            <option value="Entertainment">Entertainment</option>
                            <option value="Others">Others</option>

                        </select>

                    </div>

                    <!-- DATE RANGE -->

                    <div class="mb-3">

                        <label class="form-label">
                            From Date
                        </label>

                        <input
                            type="date"
                            id="filterFromDate"
                            class="form-control">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            To Date
                        </label>

                        <input
                            type="date"
                            id="filterToDate"
                            class="form-control">

                    </div>

                    <!-- SORT -->

                    <div class="mb-3">

                        <label class="form-label">
                            Sort By
                        </label>

                        <select
                            id="filterSort"
                            class="form-select">

                            <option value="newest">
                                Newest First
                            </option>

                            <option value="oldest">
                                Oldest First
                            </option>

                            <option value="highest">
                                Highest Amount
                            </option>

                            <option value="lowest">
                                Lowest Amount
                            </option>

                        </select>

                    </div>

                    <button
                        id="applyFilterBtn"
                        class="btn-login w-100">

                        Apply Filters

                    </button>

                </div>

            </div>

        </div>

    </div>

    <!-- ALERTS -->
    <script src="js/theme_loader.js"></script>
    <script src="js/utils/alerts.js"></script>
    <script src="js/utils/expense_helpers.js"></script>
    <!-- JS -->
    <script src="js/expenses.js"></script>
    <script src="js/pwa.js"></script>

</body>

</html>