<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peso Check Login</title>
    <link rel="manifest" href="/manifest.json">
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
    <link rel="stylesheet" href="css/main.css">
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
    <!--LOGIN FORM TEMPLATE (MOBILE-USER FRIENDLY)-->
    <div class="login-container">
        <div class="card p-4 shadow">
            <div class="image-center">
                <img class="cdp-bt-logo" src="images/peso-check-v2.png" alt="Budget Tracker Logo Temporary">
            </div>
            <form id="cdp-bt-login">
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="login_email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">
                        Password:
                    </label>

                    <div class="password-wrapper">
                        <input type="password" class="form-control" id="login_password" required>
                        <i class="fa-solid fa-eye password-toggle" toggle-target="login_password"></i>
                    </div>

                </div>
                <button type="submit" class="btn-login w-100">Submit</button>
            </form>
            <div class="text-center mt-3">
                <span>
                    Don't have an account?
                </span>

                <button class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#registerModal">
                    Register
                </button>
            </div>
        </div>
    </div>

    <!-- REGISTER MODAL -->
    <div class="modal fade" id="registerModal" tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <form id="registerForm">
                        <!-- FULLNAME  >
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="register_fullname" required>
                        </div-->

                        <!-- FIRST NAME -->
                        <div class="mb-3">
                            <label class="form-label">First Name</label>
                            <input
                                type="text"
                                class="form-control"
                                id="register_first_name"
                                required>
                        </div>

                        <!-- MIDDLE NAME -->
                        <div class="mb-3">
                            <label class="form-label">Middle Name</label>
                            <input
                                type="text"
                                class="form-control"
                                id="register_middle_name">
                        </div>

                        <!-- LAST NAME -->
                        <div class="mb-3">
                            <label class="form-label">Last Name</label>
                            <input
                                type="text"
                                class="form-control"
                                id="register_last_name"
                                required>
                        </div>

                        <!-- EMAIL -->
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="register_email" required>
                        </div>

                        <!-- PASSWORD -->
                        <div class="mb-3">

                            <label class="form-label">
                                Password
                            </label>

                            <div class="password-wrapper">

                                <input
                                    type="password"
                                    class="form-control"
                                    id="register_password"
                                    required>

                                <i class="fa-solid fa-eye password-toggle"
                                    toggle-target="register_password"></i>

                            </div>

                            <small class="text-muted">
                                Minimum 8 characters with uppercase,
                                lowercase, number and special character.
                            </small>

                        </div>

                        <!-- SUBMIT -->
                        <button type="submit" class="btn-login w-100">Register</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script src="js/utils/alerts.js"></script>
    <script src="js/app.js"></script>
    <script src="js/pwa.js"></script>

</body>

</html>