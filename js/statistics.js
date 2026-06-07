// =====================================
// LOAD SUMMARY STATISTICS
// =====================================

async function loadStatistics() {
  try {
    const response = await fetch("backend/get_statistics.php");

    const result = await response.json();

    if (!result.success) {
      return;
    }

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
  }
}

// =====================================
// LOAD CATEGORY STATISTICS
// =====================================

async function loadCategoryStatistics() {
  try {
    const response = await fetch("backend/get_category_statistics.php");

    const result = await response.json();

    if (!result.success) {
      return;
    }

    renderTopCategory(result.top_category);

    renderCategoryBreakdown(result.categories);
  } catch (error) {
    console.error(error);
  }
}

// =====================================
// RENDER TOP CATEGORY
// =====================================

function renderTopCategory(category) {
  const container = document.getElementById("topCategoryCard");

  if (!category) {
    container.innerHTML = `

      <div class="empty-state">

        No expenses yet.

      </div>

    `;

    return;
  }

  container.innerHTML = `

    <div class="top-category-icon">

      <i class="${getCategoryIcon(category.category)}"></i>

    </div>

    <div class="top-category-name">

      ${category.category}

    </div>

    <div class="top-category-total">

      ${formatPeso(category.total)}

    </div>

  `;
}

// =====================================
// RENDER CATEGORY BREAKDOWN
// =====================================

function renderCategoryBreakdown(categories) {
  const container = document.getElementById("categoryBreakdown");

  container.innerHTML = "";

  if (!categories || categories.length === 0) {
    container.innerHTML = `

      <div class="empty-state">

        No category data available.

      </div>

    `;

    return;
  }

  categories.forEach((category) => {
    container.innerHTML += `

        <div class="breakdown-card">

          <div
            class="breakdown-left"
          >

            <div
              class="breakdown-icon"
            >

              <i class="${getCategoryIcon(category.category)}"></i>

            </div>

            <div>

              <div
                class="breakdown-category"
              >

                ${category.category}

              </div>

            </div>

          </div>

          <div
            class="breakdown-total"
          >

            ${formatPeso(category.total)}

          </div>

        </div>

      `;
  });
}

// =====================================
// LOAD EVERYTHING
// =====================================

document.addEventListener("DOMContentLoaded", () => {
  loadStatistics();

  loadCategoryStatistics();
});
