// =====================================
// LOAD USER THEME
// =====================================

async function loadUserTheme() {
  try {
    const response = await fetch("backend/get_user_settings.php");

    const result = await response.json();

    if (!result.success) {
      return;
    }

    document.documentElement.style.setProperty(
      "--primary-color",
      result.primary_color || "#ffc507",
    );

    document.documentElement.style.setProperty(
      "--secondary-color",
      result.secondary_color || "#65a70f",
    );

    document.documentElement.setAttribute(
      "data-theme",
      result.theme_mode || "light",
    );
  } catch (error) {
    console.error("Theme load failed:", error);
  }
}

// =====================================
// INIT
// =====================================

loadUserTheme();
