// =====================================
// SERVICE WORKER
// =====================================

if ("serviceWorker" in navigator) {
  window.addEventListener("load", () => {
    navigator.serviceWorker
      .register("sw.js")
      .then(() => {
        console.log("Service Worker Registered");
      })
      .catch((error) => {
        console.error(error);
      });
  });
}

// =====================================
// INSTALL PROMPT
// =====================================

let deferredPrompt;

window.addEventListener("beforeinstallprompt", (event) => {
  event.preventDefault();

  deferredPrompt = event;

  const installBtn = document.getElementById("installBtn");

  if (installBtn) {
    installBtn.classList.remove("d-none");
  }
});

// =====================================
// INSTALL APP
// =====================================

async function installPWA() {
  if (!deferredPrompt) {
    return;
  }

  deferredPrompt.prompt();

  await deferredPrompt.userChoice;

  deferredPrompt = null;
}

// =====================================
// BUTTON CLICK
// =====================================

document.addEventListener("DOMContentLoaded", () => {
  const installBtn = document.getElementById("installBtn");

  if (installBtn) {
    installBtn.addEventListener("click", installPWA);
  }
});
