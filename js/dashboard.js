// =====================================
// LOAD EXPENSES FUNCTION
// =====================================

async function loadExpenses() {
  try {
    const response = await fetch("backend/get_expenses.php");

    const result = await response.json();

    const expenseList = document.getElementById("expenseList");

    // CLEAR OLD DATA
    expenseList.innerHTML = "";

    // =====================================
    // EMPTY STATE
    // =====================================

    if (result.expenses.length === 0) {
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
    // RENDER EXPENSES
    // =====================================

    result.expenses.forEach((expense) => {
      const expenseCard = `

    <div class="expense-wrapper">

        <!-- DELETE ACTION -->
        <div class="expense-actions">

            <button
                class="delete-expense-btn"
                data-id="${expense.id}">

                <i class="fa-solid fa-trash"></i>

            </button>

        </div>

        <!-- SLIDING CARD -->
       <div class="expense-card swipe-card d-flex justify-content-between align-items-center" 
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

        • ${formatExpenseDate(expense.expense_date)}

    </span>
</div>

                </div>

            </div>

            <div class="expense-price">

                - ₱${parseFloat(expense.amount).toLocaleString(undefined, {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2,
                })}

            </div>

        </div>

    </div>

`;

      expenseList.innerHTML += expenseCard;
    });

    // INITIALIZE SWIPER
    initializeSwipeActions(loadExpenses);
  } catch (error) {
    console.error(error);

    showError("Failed to load expenses.");
  }
}

// =====================================
// LOAD STATISTICS FUNCTION
// =====================================

async function loadStatistics() {
  try {
    const response = await fetch("backend/get_statistics.php");

    const result = await response.json();

    // =====================================
    // UPDATE UI
    // =====================================

    document.getElementById("dailyTotal").innerText = formatPeso(
      result.daily_total,
    );

    document.getElementById("weeklyTotal").innerText = formatPeso(
      result.weekly_total,
    );

    document.getElementById("monthlyTotal").innerText = formatPeso(
      result.monthly_total,
    );

    document.getElementById("yearlyTotal").innerText = formatPeso(
      result.yearly_total,
    );
  } catch (error) {
    console.error(error);

    showError("Failed to load statistics.");
  }
}

document.addEventListener("DOMContentLoaded", () => {
  // == LOAD EXPENSES ==
  loadExpenses();
  // == LOAD STATISTICS ==
  loadStatistics();

  // =====================================
  // LOGOUT
  // =====================================

  const logoutBtn = document.getElementById("logoutBtn");

  logoutBtn.addEventListener("click", async () => {
    const result = await showConfirm(
      "Logout?",
      "Your current session will end.",
    );

    if (!result.isConfirmed) {
      return;
    }

    showLoading("Logging out...");

    setTimeout(() => {
      window.location.href = "backend/auth/logout.php";
    }, 800);
  });

  // =====================================
  // ADD EXPENSE
  // =====================================

  const expenseForm = document.getElementById("expenseForm");

  expenseForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    // =====================================
    // GET VALUES
    // =====================================

    const item_name = document.getElementById("item_name").value;

    const category = document.getElementById("category").value;

    const amount = document.getElementById("amount").value;

    const expense_date = document.getElementById("expense_date").value;

    const notes = document.getElementById("notes").value;

    // =====================================
    // CONFIRM
    // =====================================

    const confirmResult = await showConfirm(
      "Add Expense?",
      "This expense will be saved.",
    );

    if (!confirmResult.isConfirmed) {
      return;
    }

    // =====================================
    // FORM DATA
    // =====================================

    const formData = new FormData();

    formData.append("item_name", item_name);

    formData.append("category", category);

    formData.append("amount", amount);

    formData.append("notes", notes);

    formData.append("expense_date", expense_date);

    try {
      // =====================================
      // LOADING
      // =====================================

      showLoading("Saving Expense...");

      const response = await fetch("backend/add_expense.php", {
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

        expenseForm.reset();

        // CLOSE MODAL
        const modal = bootstrap.Modal.getInstance(
          document.getElementById("expenseModal"),
        );

        modal.hide();

        // LATER:
        // refresh expenses
        // refresh statistics
        loadExpenses();
        loadStatistics();
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
