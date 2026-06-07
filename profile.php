<?php

require 'backend/session_check.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile</title>
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
    <!---CSS--->
    <link rel="stylesheet" href="css/theme.css">
    <link rel="stylesheet" href="css/profile.css">
    <!---SWEETALERT--->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    <div class="profile-header">

        <h4>
            Profile & Settings
        </h4>

        <p>
            Customize your experience
        </p>

    </div>

    <ul class="nav nav-pills profile-tabs mb-3" id="profileTabs">

        <li class="nav-item">

            <button
                class="nav-link active"
                data-bs-toggle="pill"
                data-bs-target="#accountTab">

                Account

            </button>

        </li>

        <li class="nav-item">

            <button
                class="nav-link"
                data-bs-toggle="pill"
                data-bs-target="#appearanceTab">

                Appearance

            </button>

        </li>

    </ul>

    <!-- CONTENT -->

    <div class="profile-layout">

        <div class="tab-content">
            <div
                class="tab-pane fade show active"
                id="accountTab">

                <!-- PROFILE CARD -->

                <div class="settings-card profile-card">

                    <div class="profile-avatar">

                        <i class="fa-solid fa-user"></i>

                    </div>

                    <h5 id="profileName">
                        Loading...
                    </h5>

                    <p id="profileEmail">
                        Loading...
                    </p>

                </div>

                <!-- PERSONAL INFORMATION -->

                <div class="settings-card">

                    <h6>
                        Personal Information
                    </h6>

                    <div class="mb-3">

                        <label class="form-label">
                            First Name
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="firstName">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Middle Name
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="middleName">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Last Name
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="lastName">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Email
                        </label>

                        <input
                            type="email"
                            class="form-control"
                            id="email">

                    </div>

                    <button
                        id="saveProfileBtn"
                        class="btn-save-settings">

                        Save Profile

                    </button>

                </div>

                <!-- SECURITY -->

                <div class="settings-card">

                    <h6>
                        Security
                    </h6>

                    <div class="mb-3">

                        <label class="form-label">
                            Current Password
                        </label>

                        <div class="password-wrapper">

                            <input
                                type="password"
                                class="form-control"
                                id="currentPassword">

                            <i
                                class="fa-solid fa-eye password-toggle"
                                toggle-target="currentPassword">
                            </i>

                        </div>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            New Password
                        </label>

                        <div class="password-wrapper">

                            <input
                                type="password"
                                class="form-control"
                                id="newPassword">

                            <i
                                class="fa-solid fa-eye password-toggle"
                                toggle-target="newPassword">
                            </i>

                        </div>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Confirm Password
                        </label>

                        <div class="password-wrapper">

                            <input
                                type="password"
                                class="form-control"
                                id="confirmPassword">

                            <i
                                class="fa-solid fa-eye password-toggle"
                                toggle-target="confirmPassword">
                            </i>

                        </div>

                    </div>

                    <div class="settings-card profile-card mt-3">

                        Minimum 8 characters,
                        uppercase, lowercase,
                        number and special character.

                    </div>

                    <button
                        id="changePasswordBtn"
                        class="btn-save-settings mt-3">

                        Update Password

                    </button>

                </div>

            </div>

            <div
                class="tab-pane fade"
                id="appearanceTab">

                <!-- APPEARANCE -->

                <div class="settings-card">

                    <h6>
                        Appearance
                    </h6>

                    <label class="form-label">
                        Theme Mode
                    </label>

                    <select
                        class="form-select"
                        id="themeMode">

                        <option value="light">
                            Light
                        </option>

                        <option value="dark">
                            Dark
                        </option>

                    </select>

                </div>

                <!-- PRESET THEMES -->

                <div class="settings-card">

                    <h6>
                        Preset Themes
                    </h6>

                    <div class="theme-grid">

                        <button
                            class="theme-btn"
                            data-theme="default">

                            Default

                        </button>

                        <button
                            class="theme-btn"
                            data-theme="sunset">

                            Sunset

                        </button>

                        <button
                            class="theme-btn"
                            data-theme="ocean">

                            Ocean

                        </button>

                        <button
                            class="theme-btn"
                            data-theme="aurora">

                            Aurora

                        </button>

                        <button
                            class="theme-btn"
                            data-theme="emerald">

                            Emerald

                        </button>

                        <button
                            class="theme-btn"
                            data-theme="rose">

                            Rose

                        </button>

                    </div>

                </div>

                <!-- CUSTOM COLORS -->

                <div class="settings-card">

                    <h6>
                        Custom Colors
                    </h6>

                    <div class="mb-3">

                        <label class="form-label">
                            Primary Color
                        </label>

                        <input
                            type="color"
                            id="primaryColor"
                            class="form-control form-control-color">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Secondary Color
                        </label>

                        <input
                            type="color"
                            id="secondaryColor"
                            class="form-control form-control-color">

                    </div>

                </div>

                <!-- PREVIEW -->

                <div class="settings-card">

                    <h6>
                        Preview
                    </h6>

                    <div class="theme-preview">

                        Budget Tracker

                    </div>

                </div>

                <!-- INSTALL APP -->

                <div class="settings-card">

                    <h6>
                        Mobile App
                    </h6>

                    <p class="mb-3">

                        Install Peso Check on your device for a faster,
                        app-like experience with home screen access.

                    </p>

                    <button
                        id="installBtn"
                        class="btn-save-settings d-none">

                        <i class="fa-solid fa-download me-2"></i>

                        Install App

                    </button>

                </div>

                <!-- SAVE SETTINGS -->

                <button
                    id="saveSettingsBtn"
                    class="btn-save-settings">

                    Save Settings

                </button>

            </div>

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
            class="nav-item-custom">

            <i class="fa-solid fa-chart-pie"></i>

            Stats

        </a>

        <a href="profile.php"
            class="nav-item-custom nav-active">

            <i class="fa-solid fa-user"></i>

            Profile

        </a>

    </div>

    <script src="js/theme_loader.js"></script>
    <script src="js/utils/alerts.js"></script>
    <script src="js/profile.js"></script>
    <script src="js/pwa.js"></script>

</body>

</html>