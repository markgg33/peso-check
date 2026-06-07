// =====================================
// SUCCESS ALERT
// =====================================

function showSuccess(message) {
  Swal.fire({
    icon: "success",
    title: "Success",
    text: message,
    confirmButtonColor: "#65a70f",
  });
}

// =====================================
// ERROR ALERT
// =====================================

function showError(message) {
  Swal.fire({
    icon: "error",
    title: "Oops...",
    text: message,
    confirmButtonColor: "#ffc507",
  });
}

// =====================================
// LOADING ALERT
// =====================================

function showLoading(message = "Please wait...") {
  Swal.fire({
    title: message,
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading();
    },
  });
}

// =====================================
// CLOSE LOADING
// =====================================

function closeLoading() {
  Swal.close();
}

// =====================================
// CONFIRM ALERT
// =====================================

async function showConfirm(title, text) {
  return await Swal.fire({
    title: title,

    text: text,

    icon: "warning",

    showCancelButton: true,

    confirmButtonColor: "#65a70f",

    cancelButtonColor: "#d33",

    confirmButtonText: "Yes",

    cancelButtonText: "Cancel",
  });
}
