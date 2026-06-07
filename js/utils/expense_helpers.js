// =====================================
// OPEN EXPENSE DETAILS
// =====================================

function openExpenseDetails(expense) {
  // ICON
  document.getElementById("detailsIcon").innerHTML = `
    <i class="${getCategoryIcon(expense.category)}"></i>
  `;

  // ID
  document.getElementById("editExpenseId").value = expense.id;

  // ITEM
  document.getElementById("editItemName").value = expense.item_name;

  // CATEGORY
  document.getElementById("editCategory").value = expense.category;

  // AMOUNT
  document.getElementById("editAmount").value = expense.amount;

  //EXPENSE DATE
  document.getElementById("editExpenseDate").value = expense.expense_date;

  // NOTES
  document.getElementById("editNotes").value = expense.notes || "";

  // OPEN MODAL
  const modal = new bootstrap.Modal(
    document.getElementById("expenseDetailsModal"),
  );

  modal.show();
}

// =====================================
// FORMAT PESO
// =====================================

function formatPeso(amount) {
  return (
    "₱" +
    parseFloat(amount).toLocaleString(undefined, {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    })
  );
}

// =====================================
// FORMAT DATE
// =====================================

function formatExpenseDate(dateString) {
  const date = new Date(dateString);

  return date.toLocaleString("en-PH", {
    month: "short",
    day: "numeric",
    year: "numeric",
    //hour: "numeric",
    //minute: "2-digit",
  });
}

// =====================================
// CATEGORY ICONS
// =====================================

function getCategoryIcon(category) {
  switch (category) {
    case "Food":
      return "fa-solid fa-burger";

    case "Transportation":
      return "fa-solid fa-gas-pump";

    case "Shopping":
      return "fa-solid fa-cart-shopping";

    case "Bills":
      return "fa-solid fa-file-invoice-dollar";

    case "Entertainment":
      return "fa-solid fa-film";

    default:
      return "fa-solid fa-wallet";
  }
}

// =====================================
// HANDLE CLICK
// =====================================

function handleExpenseClick(expense, element) {
  if (element.dataset.swiped === "true") {
    return;
  }

  openExpenseDetails(expense);
}

// =====================================
// SWIPE ACTIONS
// =====================================

function initializeSwipeActions(loadFunction = null) {
  const cards = document.querySelectorAll(".swipe-card");

  cards.forEach((card) => {
    let startX = 0;
    let currentTranslate = 0;
    let isDragging = false;
    let moved = false;

    // TOUCH START
    card.addEventListener("touchstart", (e) => {
      startX = e.touches[0].clientX;

      isDragging = true;

      moved = false;

      card.style.transition = "none";
    });

    // TOUCH MOVE
    card.addEventListener("touchmove", (e) => {
      if (!isDragging) return;

      const currentX = e.touches[0].clientX;

      let diffX = currentX - startX;

      if (diffX < 0) {
        moved = true;

        if (diffX < -90) {
          diffX = -90;
        }

        currentTranslate = diffX;

        card.style.transform = `translateX(${diffX}px)`;
      }
    });

    // TOUCH END
    card.addEventListener("touchend", () => {
      isDragging = false;

      card.style.transition = "transform 0.25s ease";

      if (currentTranslate < -45) {
        document.querySelectorAll(".swipe-card").forEach((c) => {
          c.style.transform = "translateX(0px)";
        });

        card.style.transform = "translateX(-90px)";
      } else {
        card.style.transform = "translateX(0px)";
      }

      if (moved) {
        card.dataset.swiped = "true";

        setTimeout(() => {
          card.dataset.swiped = "false";
        }, 150);
      }

      currentTranslate = 0;
    });
  });

  // =====================================
  // DELETE BUTTONS
  // =====================================

  const deleteButtons = document.querySelectorAll(".delete-expense-btn");

  deleteButtons.forEach((button) => {
    button.addEventListener("click", async (e) => {
      e.stopPropagation();

      const expense_id = button.dataset.id;

      const confirmResult = await showConfirm(
        "Delete Expense?",
        "This cannot be undone.",
      );

      if (!confirmResult.isConfirmed) {
        return;
      }

      try {
        showLoading("Deleting Expense...");

        const formData = new FormData();

        formData.append("expense_id", expense_id);

        const response = await fetch("backend/delete_expense.php", {
          method: "POST",
          body: formData,
        });

        const result = await response.json();

        closeLoading();

        if (result.success) {
          showSuccess(result.message);

          if (loadFunction) {
            loadFunction();
          }
        } else {
          showError(result.message);
        }
      } catch (error) {
        closeLoading();

        showError("Failed to delete expense.");

        console.error(error);
      }
    });
  });
}
