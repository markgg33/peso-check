// =====================================
// CURRENT THEME
// =====================================

let selectedTheme = "default";

// =====================================
// APPLY THEME
// =====================================

function applyTheme(primaryColor, secondaryColor, mode) {
  primaryColor = primaryColor || "#ffc507";
  secondaryColor = secondaryColor || "#65a70f";
  mode = mode || "light";

  document.documentElement.style.setProperty("--primary-color", primaryColor);

  document.documentElement.style.setProperty(
    "--secondary-color",
    secondaryColor,
  );

  document.documentElement.setAttribute("data-theme", mode);
}

// =====================================
// LOAD SETTINGS
// =====================================

async function loadSettings() {
  try {
    const response = await fetch("backend/get_user_settings.php");

    const result = await response.json();

    if (!result.success) {
      return;
    }

    document.getElementById("themeMode").value = result.theme_mode;

    document.getElementById("primaryColor").value = result.primary_color;

    document.getElementById("secondaryColor").value = result.secondary_color;

    selectedTheme = result.theme_name || "custom";

    applyTheme(result.primary_color, result.secondary_color, result.theme_mode);
  } catch (error) {
    console.error(error);
  }
}

// =====================================
// SAVE SETTINGS
// =====================================

async function saveSettings() {
  const confirmResult = await showConfirm(
    "Save Theme?",
    "Your appearance settings will be updated.",
  );

  if (!confirmResult.isConfirmed) {
    return;
  }

  const formData = new FormData();

  formData.append("theme_mode", document.getElementById("themeMode").value);

  formData.append("theme_name", selectedTheme || "custom");

  formData.append(
    "primary_color",
    document.getElementById("primaryColor").value,
  );

  formData.append(
    "secondary_color",
    document.getElementById("secondaryColor").value,
  );

  try {
    showLoading("Saving Settings...");

    const response = await fetch("backend/update_user_settings.php", {
      method: "POST",
      body: formData,
    });

    const result = await response.json();

    closeLoading();

    if (result.success) {
      showSuccess(result.message);

      applyTheme(
        formData.get("primary_color"),
        formData.get("secondary_color"),
        formData.get("theme_mode"),
      );
    } else {
      showError(result.message);
    }
  } catch (error) {
    closeLoading();

    console.error(error);

    showError("Failed to save settings.");
  }
}

// =====================================
// LIVE PREVIEW
// =====================================

function initializePreview() {
  const primary = document.getElementById("primaryColor");

  const secondary = document.getElementById("secondaryColor");

  const mode = document.getElementById("themeMode");

  primary.addEventListener("input", () => {
    selectedTheme = "custom";
  });

  secondary.addEventListener("input", () => {
    selectedTheme = "custom";
  });

  document.querySelectorAll(".theme-btn").forEach((btn) => {
    btn.classList.remove("active");
  });

  [primary, secondary, mode].forEach((element) => {
    element.addEventListener("input", () => {
      applyTheme(primary.value, secondary.value, mode.value);
    });
  });
}

// =====================================
// PRESET THEME BUTTONS
// =====================================

function initializePresetThemes() {
  document.querySelectorAll(".theme-btn").forEach((button) => {
    button.addEventListener("click", () => {
      const themeName = button.dataset.theme;

      selectedTheme = themeName;

      const theme = presetThemes[themeName];

      if (!theme) {
        return;
      }

      // UPDATE COLOR PICKERS

      document.getElementById("primaryColor").value = theme.primary;

      document.getElementById("secondaryColor").value = theme.secondary;

      // APPLY THEME

      applyTheme(
        theme.primary,
        theme.secondary,
        document.getElementById("themeMode").value,
      );

      // ACTIVE BUTTON

      document.querySelectorAll(".theme-btn").forEach((btn) => {
        btn.classList.remove("active");
      });

      button.classList.add("active");
    });
  });
}

// =====================================
// LOAD PROFILE INFO
// =====================================
async function loadProfile() {
  try {
    const response = await fetch("backend/get_profile.php");

    const result = await response.json();

    if (!result.success) {
      return;
    }

    const user = result.user;

    document.getElementById("firstName").value = user.first_name || "";

    document.getElementById("middleName").value = user.middle_name || "";

    document.getElementById("lastName").value = user.last_name || "";

    document.getElementById("email").value = user.email || "";

    let displayName = user.first_name;

    if (user.middle_name) {
      displayName += " " + user.middle_name.charAt(0).toUpperCase() + ".";
    }

    displayName += " " + user.last_name;

    document.getElementById("profileName").textContent = displayName;

    document.getElementById("profileEmail").textContent = user.email;
  } catch (error) {
    console.error(error);
  }
}

// =====================================
// UPDATE PROFILE INFO
// =====================================

async function saveProfile() {
  const confirmResult = await showConfirm(
    "Update Profile?",
    "Your account information will be updated.",
  );

  if (!confirmResult.isConfirmed) {
    return;
  }

  const formData = new FormData();

  formData.append("first_name", document.getElementById("firstName").value);

  formData.append("middle_name", document.getElementById("middleName").value);

  formData.append("last_name", document.getElementById("lastName").value);

  formData.append("email", document.getElementById("email").value);

  try {
    showLoading("Updating Profile...");

    const response = await fetch("backend/update_profile.php", {
      method: "POST",
      body: formData,
    });

    const result = await response.json();

    closeLoading();

    if (result.success) {
      showSuccess(result.message);

      loadProfile();
    } else {
      showError(result.message);
    }
  } catch (error) {
    closeLoading();

    console.error(error);

    showError("Failed to update profile.");
  }
}

// =====================================
// UPDATE PASSWORD
// =====================================

async function updatePassword() {
  const confirmResult = await showConfirm(
    "Change Password?",
    "You will need to use the new password on your next login.",
  );

  if (!confirmResult.isConfirmed) {
    return;
  }

  const formData = new FormData();

  formData.append(
    "current_password",
    document.getElementById("currentPassword").value,
  );

  formData.append("new_password", document.getElementById("newPassword").value);

  formData.append(
    "confirm_password",
    document.getElementById("confirmPassword").value,
  );

  try {
    showLoading("Updating Password...");

    const response = await fetch("backend/update_password.php", {
      method: "POST",
      body: formData,
    });

    const result = await response.json();

    closeLoading();

    if (result.success) {
      showSuccess(result.message);

      document.getElementById("currentPassword").value = "";

      document.getElementById("newPassword").value = "";

      document.getElementById("confirmPassword").value = "";
    } else {
      showError(result.message);
    }
  } catch (error) {
    closeLoading();

    console.error(error);

    showError("Failed to update password.");
  }
}

// =====================================
// PASSWORD TOGGLE
// =====================================

function initializePasswordToggles() {
  const passwordToggles = document.querySelectorAll(".password-toggle");

  passwordToggles.forEach((toggle) => {
    toggle.addEventListener("click", () => {
      const targetId = toggle.getAttribute("toggle-target");

      const input = document.getElementById(targetId);

      if (input.type === "password") {
        input.type = "text";

        toggle.classList.remove("fa-eye");
        toggle.classList.add("fa-eye-slash");
      } else {
        input.type = "password";

        toggle.classList.remove("fa-eye-slash");
        toggle.classList.add("fa-eye");
      }
    });
  });
}

// =====================================
// PRESET THEMES
// =====================================

const presetThemes = {
  default: {
    primary: "#FFC507",
    secondary: "#65A70F",
  },

  sunset: {
    primary: "#ff7b54",
    secondary: "#ffb26b",
  },

  ocean: {
    primary: "#2196f3",
    secondary: "#00bcd4",
  },

  aurora: {
    primary: "#7f5af0",
    secondary: "#2cb67d",
  },

  emerald: {
    primary: "#16a34a",
    secondary: "#4ade80",
  },

  rose: {
    primary: "#e11d48",
    secondary: "#fb7185",
  },
};

// =====================================
// DOM READY
// =====================================

document.addEventListener("DOMContentLoaded", () => {
  loadSettings();

  initializePreview();

  initializePresetThemes();

  loadProfile();

  initializePasswordToggles();

  document
    .getElementById("saveProfileBtn")
    .addEventListener("click", saveProfile);

  document
    .getElementById("changePasswordBtn")
    .addEventListener("click", updatePassword);

  document
    .getElementById("saveSettingsBtn")
    .addEventListener("click", saveSettings);
});
