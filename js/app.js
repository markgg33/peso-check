document.addEventListener("DOMContentLoaded", () => {
  // =====================================
  // PASSWORD TOGGLE
  // =====================================

  const passwordToggles = document.querySelectorAll(".password-toggle");

  passwordToggles.forEach((toggle) => {
    toggle.addEventListener("click", () => {
      const targetId = toggle.getAttribute("toggle-target");

      const input = document.getElementById(targetId);

      // SHOW PASSWORD
      if (input.type === "password") {
        input.type = "text";

        toggle.classList.remove("fa-eye");

        toggle.classList.add("fa-eye-slash");
      }

      // HIDE PASSWORD
      else {
        input.type = "password";

        toggle.classList.remove("fa-eye-slash");

        toggle.classList.add("fa-eye");
      }
    });
  });

  // =====================================
  // REGISTER (1)
  // =====================================

  const registerForm = document.getElementById("registerForm");

  registerForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    //const fullname = document.getElementById("register_fullname").value;

    const first_name = document
      .getElementById("register_first_name")
      .value.trim();

    const middle_name = document
      .getElementById("register_middle_name")
      .value.trim();

    const last_name = document
      .getElementById("register_last_name")
      .value.trim();

    const email = document.getElementById("register_email").value;

    const password = document.getElementById("register_password").value;

    // =====================================
    // CONFIRMATION
    // =====================================

    const confirmResult = await showConfirm(
      "Create Account?",
      "Your account will be registered.",
    );

    if (!confirmResult.isConfirmed) {
      return;
    }

    // PASSWORD VALIDATION REQUIREMENTS

    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

    if (!passwordRegex.test(password)) {
      showError(
        "Password must contain uppercase, lowercase, number and special character.",
      );

      return;
    }

    const formData = new FormData();

    //formData.append("fullname", fullname);

    // NEW FIELDS REPLACING FULL NAME

    formData.append("first_name", first_name);

    formData.append("middle_name", middle_name);

    formData.append("last_name", last_name);

    formData.append("email", email);

    formData.append("password", password);

    try {
      // =====================================
      // LOADING
      // =====================================

      showLoading("Creating Account...");

      const response = await fetch("backend/auth/register.php", {
        method: "POST",
        body: formData,
      });

      const result = await response.json();

      closeLoading();

      // =====================================
      // SUCCESS
      // =====================================

      if (result.success) {
        showSuccess(result.message);

        registerForm.reset();

        const modal = bootstrap.Modal.getInstance(
          document.getElementById("registerModal"),
        );

        modal.hide();
      }

      // =====================================
      // ERROR
      // =====================================
      else {
        showError(result.message);
      }
    } catch (error) {
      // =====================================
      // SERVER ERROR
      // =====================================

      closeLoading();

      showError("Server error occurred.");

      console.error(error);
    }
  });

  // =====================================
  // LOGIN (2)
  // =====================================

  const loginForm = document.getElementById("cdp-bt-login");

  loginForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    const email = document.getElementById("login_email").value;

    const password = document.getElementById("login_password").value;

    const formData = new FormData();

    formData.append("email", email);

    formData.append("password", password);

    try {
      // =====================================
      // LOADING
      // =====================================

      showLoading("Logging in...");

      const response = await fetch("backend/auth/login.php", {
        method: "POST",
        body: formData,
      });

      const result = await response.json();

      closeLoading();

      // =====================================
      // SUCCESS
      // =====================================

      if (result.success) {
        await Swal.fire({
          icon: "success",

          title: "Welcome Back!",

          text: result.message,

          confirmButtonColor: "#65a70f",
        });

        // =====================================
        // REDIRECT
        // =====================================

        window.location.href = "dashboard.php";
      }

      // =====================================
      // ERROR
      // =====================================
      else {
        showError(result.message);
      }
    } catch (error) {
      // =====================================
      // SERVER ERROR
      // =====================================

      closeLoading();

      showError("Server error occurred.");

      console.error(error);
    }
  });
});
