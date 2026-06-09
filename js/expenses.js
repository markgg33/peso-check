let allExpenses = [];

// =====================================
// LOAD ALL EXPENSES
// =====================================

async function loadAllExpenses() {
  try {
    const response = await fetch("backend/get_all_expenses.php");

    const result = await response.json();

    if (!result.success) {
      showError(result.message);

      return;
    }

    allExpenses = result.expenses;

    renderExpenses(result.expenses);
  } catch (error) {
    console.error(error);

    showError("Failed to load expenses.");
  }
}

// =====================================
// RENDER EXPENSES
// =====================================

function renderExpenses(expenses) {
  const expenseList = document.getElementById("expenseList");

  expenseList.innerHTML = "";

  // =====================================
  // EMPTY STATE
  // =====================================

  if (expenses.length === 0) {
    expenseList.innerHTML = `

      <div class="empty-expense">

        <i class="fa-solid fa-wallet"></i>

        <p>
          No expenses yet.
        </p>

      </div>

    `;

    return;
  }

  // =====================================
  // GROUP EXPENSES
  // =====================================

  const groupedExpenses = groupExpensesByDate(expenses);

  // =====================================
  // RENDER GROUPS
  // =====================================

  Object.keys(groupedExpenses).forEach((dateLabel, index) => {
    const safeId = "group-" + dateLabel.replace(/[^a-zA-Z0-9]/g, "");

    const expensesInGroup = groupedExpenses[dateLabel];

    const totalAmount = expensesInGroup.reduce(
      (sum, expense) => sum + parseFloat(expense.amount),
      0,
    );

    expenseList.innerHTML += `
  
    <div class="expense-group">

      <div
        class="expense-group-header ${index === 0 ? "expanded" : ""}"
        data-target="${safeId}">

        <div>

          <div class="expense-group-title">
            ${dateLabel}
          </div>

          <div class="expense-group-summary">
            ${formatPeso(totalAmount)}
            •
            ${expensesInGroup.length}
            Expense${expensesInGroup.length > 1 ? "s" : ""}
          </div>

        </div>

        <i class="fa-solid fa-chevron-down accordion-icon"></i>

      </div>

      <div
        id="${safeId}"
        class="expense-group-content ${index === 0 ? "show" : ""}">

      </div>

    </div>

  `;

    const groupContainer = document.getElementById(safeId);

    expensesInGroup.forEach((expense) => {
      groupContainer.innerHTML += createExpenseCard(expense);
    });
  });

  // =====================================
  // REINITIALIZE SWIPES
  // =====================================

  initializeExpenseAccordion();

  initializeSwipeActions(loadAllExpenses);
}

// =====================================
// SEARCH FUNCTION
// =====================================

function searchExpenses(keyword) {
  keyword = keyword.toLowerCase();

  const filtered = allExpenses.filter((expense) => {
    return (
      expense.item_name.toLowerCase().includes(keyword) ||
      expense.category.toLowerCase().includes(keyword) ||
      (expense.notes || "").toLowerCase().includes(keyword)
    );
  });

  renderExpenses(filtered);
}

// =====================================
// APPLY FLITER
// =====================================

function applyFilters() {
  let filtered = [...allExpenses];

  const category = document.getElementById("filterCategory").value;

  const fromDate = document.getElementById("filterFromDate").value;

  const toDate = document.getElementById("filterToDate").value;

  const sort = document.getElementById("filterSort").value;

  if (category) {
    filtered = filtered.filter((expense) => expense.category === category);
  }

  if (fromDate) {
    filtered = filtered.filter(
      (expense) => expense.expense_date.substring(0, 10) >= fromDate,
    );
  }

  if (toDate) {
    filtered = filtered.filter(
      (expense) => expense.expense_date.substring(0, 10) <= toDate,
    );
  }

  switch (sort) {
    case "oldest":
      filtered.sort(
        (a, b) => new Date(a.expense_date) - new Date(b.expense_date),
      );
      break;

    case "highest":
      filtered.sort((a, b) => parseFloat(b.amount) - parseFloat(a.amount));
      break;

    case "lowest":
      filtered.sort((a, b) => parseFloat(a.amount) - parseFloat(b.amount));
      break;

    default:
      filtered.sort(
        (a, b) => new Date(b.expense_date) - new Date(a.expense_date),
      );
  }

  renderExpenses(filtered);
}

// =====================================
// INITIALIZE EXPENSE ACCORDION
// =====================================

function initializeExpenseAccordion() {
  document.querySelectorAll(".expense-group-header").forEach((header) => {
    header.addEventListener("click", () => {
      const target = document.getElementById(header.dataset.target);

      header.classList.toggle("expanded");

      target.classList.toggle("show");
    });
  });
}

// =====================================
// GROUP EXPENSES BY DATE
// =====================================

function groupExpensesByDate(expenses) {
  const grouped = {};

  expenses.forEach((expense) => {
    const date = new Date(expense.expense_date);

    const today = new Date();

    const yesterday = new Date();

    yesterday.setDate(yesterday.getDate() - 1);

    let label = "";

    // =====================================
    // TODAY
    // =====================================

    if (isSameDate(date, today)) {
      label = "Today";
    }

    // =====================================
    // YESTERDAY
    // =====================================
    else if (isSameDate(date, yesterday)) {
      label = "Yesterday";
    }

    // =====================================
    // OLDER DATE
    // =====================================
    else {
      label = date.toLocaleDateString("en-PH", {
        month: "long",
        day: "numeric",
        year: "numeric",
      });
    }

    // =====================================
    // CREATE ARRAY
    // =====================================

    if (!grouped[label]) {
      grouped[label] = [];
    }

    grouped[label].push(expense);
  });

  return grouped;
}

// =====================================
// CREATE EXPENSE CARD
// =====================================
function createExpenseCard(expense) {
  return `

    <div class="expense-wrapper">

      <!-- DELETE ACTION -->

      <div class="expense-actions">

        <button
          class="delete-expense-btn"
          data-id="${expense.id}">

          <i class="fa-solid fa-trash"></i>

        </button>

      </div>

      <!-- CARD -->

      <div
        class="expense-card swipe-card d-flex justify-content-between align-items-center"

        onclick='handleExpenseClick(
          ${JSON.stringify(expense)},
          this
        )'
      >

        <div class="d-flex align-items-center">

          <div class="expense-icon">

            <i class="${getCategoryIcon(expense.category)}"></i>

          </div>

          <div class="ms-3">

            <p class="expense-name">

              ${expense.item_name}

            </p>

            <div class="expense-meta">

              <span class="expense-category">

                ${expense.category}

              </span>

              <span class="expense-date">

                ${formatExpenseDate(expense.expense_date)}

              </span>

            </div>

          </div>

        </div>

        <div class="expense-price">

          - ${formatPeso(expense.amount)}

        </div>

      </div>

    </div>

  `;
}

function isSameDate(date1, date2) {
  return (
    date1.getFullYear() === date2.getFullYear() &&
    date1.getMonth() === date2.getMonth() &&
    date1.getDate() === date2.getDate()
  );
}

document.addEventListener("DOMContentLoaded", () => {
  loadAllExpenses();

  // =====================================
  // SEARCH
  // =====================================

  document.getElementById("expenseSearch").addEventListener("input", (e) => {
    searchExpenses(e.target.value);
  });

  // =====================================
  // FILTER BUTTON
  // =====================================

  document.querySelector(".filter-btn").addEventListener("click", () => {
    new bootstrap.Modal(document.getElementById("filterModal")).show();
  });

  // =====================================
  // APPLY FILTERS
  // =====================================

  document.getElementById("applyFilterBtn").addEventListener("click", () => {
    applyFilters();

    bootstrap.Modal.getInstance(document.getElementById("filterModal")).hide();
  });

  // =====================================
  // EDIT EXPENSE
  // =====================================

  const editExpenseForm = document.getElementById("editExpenseForm");

  if (editExpenseForm) {
    editExpenseForm.addEventListener("submit", async (e) => {
      e.preventDefault();

      const confirmResult = await showConfirm(
        "Save Changes?",
        "Expense will be updated.",
      );

      if (!confirmResult.isConfirmed) {
        return;
      }

      const formData = new FormData();

      formData.append(
        "expense_id",
        document.getElementById("editExpenseId").value,
      );

      formData.append(
        "item_name",
        document.getElementById("editItemName").value,
      );

      formData.append(
        "category",
        document.getElementById("editCategory").value,
      );

      formData.append("amount", document.getElementById("editAmount").value);

      formData.append(
        "expense_date",
        document.getElementById("editExpenseDate").value,
      );

      formData.append("notes", document.getElementById("editNotes").value);

      try {
        showLoading("Updating Expense...");

        const response = await fetch("backend/update_expense.php", {
          method: "POST",
          body: formData,
        });

        const result = await response.json();

        closeLoading();

        if (result.success) {
          showSuccess(result.message);

          // CLOSE MODAL
          const modal = bootstrap.Modal.getInstance(
            document.getElementById("expenseDetailsModal"),
          );

          modal.hide();

          // LIVE REFRESH
          if (typeof loadExpenses === "function") {
            loadExpenses();
          }

          if (typeof loadAllExpenses === "function") {
            loadAllExpenses();
          }

          if (typeof loadStatistics === "function") {
            loadStatistics();
          }
        } else {
          showError(result.message);
        }
      } catch (error) {
        closeLoading();

        showError("Failed to update expense.");

        console.error(error);
      }
    });
  }
});
