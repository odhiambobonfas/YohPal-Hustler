document.addEventListener("DOMContentLoaded", function () {
  const sidebar = document.querySelector(".sidebar");
  const menuToggle = document.querySelector(".menu-toggle");
  const pageHeader = document.querySelector(".page-header");
  const pageTitle = pageHeader ? pageHeader.querySelector(".page-title") : null;
  const breadcrumb = pageHeader
    ? pageHeader.querySelector(".breadcrumb")
    : null;
  const chartBars = document.querySelectorAll(".chart-bar");
  const copyButtons = document.querySelectorAll(".copy-btn");
  const selectAllCheckbox = document.getElementById("select-all-checkbox");
  const deleteButton = document.querySelector(".delete");
  const viewMoreButton = document.querySelector(".view-more");
  let rowCheckboxes = document.querySelectorAll(".row-checkbox");
  let originalContent = document.querySelector(".main-content")?.innerHTML;
  let activeTabId =
    document.querySelector(".sidebar-item.active")?.getAttribute("data-tab") ||
    "dashboard";

  // Function to bind sidebar event listeners
  function bindSidebarEvents() {
    if (menuToggle && sidebar) {
      menuToggle.addEventListener("click", () => {
        sidebar.classList.toggle("active");
      });
    }

    sidebar.addEventListener("click", function (e) {
      const sidebarItem = e.target.closest(".sidebar-item");
      if (!sidebarItem) return;

      const tabId = sidebarItem.getAttribute("data-tab");
      if (sidebarItem.classList.contains("logout")) {
        if (confirm("Are you sure you want to log out?")) {
          window.location.href = "./index.php?url=log_in&client_id=";
        }
        return;
      }

      const tabContent = document.getElementById(tabId);
      if (!tabContent) {
        console.error(`Tab content with ID "${tabId}" not found.`);
        return;
      }

      document.querySelectorAll(".sidebar-item").forEach((item) => {
        item.classList.remove("active");
        item.setAttribute("aria-selected", "false");
      });
      document.querySelectorAll(".tab-content").forEach((content) => {
        content.classList.remove("active");
        content.style.display = "none";
      });

      sidebarItem.classList.add("active");
      sidebarItem.setAttribute("aria-selected", "true");
      tabContent.classList.add("active");
      tabContent.style.display = "block";

      activeTabId = tabId;
      if (pageTitle && breadcrumb) {
        tabName = sidebarItem.textContent.trim();
        pageTitle.textContent = tabName;
        breadcrumb.textContent = `Home → ${tabName.toLowerCase()}`;
      }

      if (window.innerWidth <= 768 && sidebar.classList.contains("active")) {
        sidebar.classList.remove("active");
      }
    });

    sidebar.addEventListener("keydown", function (e) {
      const sidebarItem = e.target.closest(".sidebar-item");
      if (!sidebarItem) return;

      if (e.key === "Enter" || e.key === "Space") {
        e.preventDefault();
        sidebarItem.click();
      }
    });
  }

  // Initialize sidebar events
  bindSidebarEvents();

  // Set initial active tab
  const activeItem = document.querySelector(".sidebar-item.active");
  if (activeItem) {
    const tabId = activeItem.getAttribute("data-tab");
    const tabContent = document.getElementById(tabId);
    if (tabContent && pageTitle && breadcrumb) {
      tabContent.classList.add("active");
      tabContent.style.display = "block";
      pageTitle.textContent = activeItem.textContent.trim();
      breadcrumb.textContent = `Home → ${activeItem.textContent.trim().toLowerCase()}`;
    }
  }

  chartBars.forEach((bar, index) => {
    const height = bar.style.height || "50px";
    bar.style.setProperty("--target-height", height);
    bar.style.animationDelay = `${index * 0.1}s`;
    bar.style.animation = "growUp 0.8s ease-out forwards";
  });

  copyButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const widget = this.closest(".widget-card");
      const input = widget.querySelector("input, textarea");
      if (input) {
        input.select();
        document.execCommand("copy");
        this.textContent = "Copied!";
        setTimeout(() => {
          this.textContent = "Copy";
        }, 2000);
      }
    });
  });

  function updateButtonStates() {
    if (!rowCheckboxes.length) return;
    const someChecked = Array.from(rowCheckboxes).some((cb) => cb.checked);
    const allChecked = Array.from(rowCheckboxes).every((cb) => cb.checked);
    if (deleteButton) deleteButton.disabled = !someChecked;
    if (selectAllCheckbox) {
      selectAllCheckbox.indeterminate = someChecked && !allChecked;
      selectAllCheckbox.checked = allChecked;
    }
  }

  if (selectAllCheckbox) {
    selectAllCheckbox.addEventListener("change", function () {
      rowCheckboxes.forEach((checkbox) => {
        checkbox.checked = this.checked;
      });
      updateButtonStates();
    });
  }

  document.addEventListener("change", function (e) {
    if (e.target.classList.contains("row-checkbox")) {
      updateButtonStates();
    }
  });

  if (deleteButton) {
    deleteButton.addEventListener("click", function () {
      rowCheckboxes.forEach((checkbox) => {
        if (checkbox.checked) {
          checkbox.closest("tr").remove();
        }
      });
      rowCheckboxes = document.querySelectorAll(".row-checkbox");
      if (selectAllCheckbox) {
        selectAllCheckbox.checked = false;
        selectAllCheckbox.indeterminate = false;
      }
      if (deleteButton) deleteButton.disabled = true;
      const jobTableSection = document.querySelector(".job-table-section");
      if (jobTableSection) jobTableSection.style.height = "auto";
    });
  }

  if (viewMoreButton) {
    viewMoreButton.addEventListener("click", function (e) {
      e.preventDefault();
      fetch("./index.php?url=activity&client_id=")
        .then((response) => response.text())
        .then((data) => {
          const parser = new DOMParser();
          const doc = parser.parseFromString(data, "text/html");
          let content =
            doc.querySelector(".activity-container")?.innerHTML || data;

          // Ensure the activity tab content exists
          let activityTab = document.getElementById("activity");
          if (!activityTab) {
            activityTab = document.createElement("div");
            activityTab.id = "activity";
            activityTab.classList.add("tab-content");
            activityTab.style.display = "none";
            document.querySelector(".main-content").appendChild(activityTab);
          }

          // Update activity tab content
          activityTab.innerHTML = `<div class="back-button-container"><button class="back-to-dashboard" style="background: none; color: black; border: none; margin-top: 20px; margin-left: 20px; font-size: 20px;"><i class="fas fa-chevron-left"></i></button></div>${content}`;

          // Switch to activity tab
          document.querySelectorAll(".tab-content").forEach((content) => {
            content.classList.remove("active");
            content.style.display = "none";
          });
          activityTab.classList.add("active");
          activityTab.style.display = "block";

          // Update sidebar active state
          document.querySelectorAll(".sidebar-item").forEach((item) => {
            item.classList.remove("active");
            item.setAttribute("aria-selected", "false");
          });
          const activitySidebarItem = document.querySelector(
            '.sidebar-item[data-tab="activity"]',
          );
          if (activitySidebarItem) {
            activitySidebarItem.classList.add("active");
            activitySidebarItem.setAttribute("aria-selected", "true");
          }
          activeTabId = "activity";

          // Update page header
          if (pageTitle && breadcrumb) {
            pageTitle.textContent = "Activity";
            breadcrumb.textContent = "Home → activity";
          }

          // Re-bind sidebar events
          bindSidebarEvents();

          // Bind back button
          const backButton = document.querySelector(".back-to-dashboard");
          if (backButton) {
            backButton.addEventListener("click", function () {
              // Restore original dashboard content
              document.querySelector(".main-content").innerHTML =
                originalContent;

              // Switch to dashboard tab
              document.querySelectorAll(".tab-content").forEach((content) => {
                content.classList.remove("active");
                content.style.display = "none";
              });
              const dashboardTab = document.getElementById("dashboard");
              if (dashboardTab) {
                dashboardTab.classList.add("active");
                dashboardTab.style.display = "block";
              }

              // Update sidebar active state
              document.querySelectorAll(".sidebar-item").forEach((item) => {
                item.classList.remove("active");
                item.setAttribute("aria-selected", "false");
              });
              const dashboardSidebarItem = document.querySelector(
                '.sidebar-item[data-tab="dashboard"]',
              );
              if (dashboardSidebarItem) {
                dashboardSidebarItem.classList.add("active");
                dashboardSidebarItem.setAttribute("aria-selected", "true");
              }
              activeTabId = "dashboard";

              // Update page header
              if (pageTitle && breadcrumb) {
                pageTitle.textContent = "Dashboard";
                breadcrumb.textContent = "Home → dashboard";
              }

              // Re-bind all event listeners
              rebindEventListeners();
            });
          }

          // Execute any scripts from the fetched content
          const scripts = doc.querySelectorAll("script");
          scripts.forEach((script) => {
            const newScript = document.createElement("script");
            if (script.src) {
              newScript.src = script.src;
            } else {
              newScript.textContent = script.textContent;
            }
            document.body.appendChild(newScript);
          });

          // Re-bind table and widget events
          rebindEventListeners();
        })
        .catch((error) => {
          console.error("Error loading activity.php:", error);
          document.querySelector(".main-content").innerHTML =
            "<p>Error loading content.</p>";
        });
    });
  }

  function rebindEventListeners() {
    rowCheckboxes = document.querySelectorAll(".row-checkbox");
    const newSelectAllCheckbox = document.getElementById("select-all-checkbox");
    const newDeleteButton = document.querySelector(".delete");
    const newViewMoreButton = document.querySelector(".view-more");
    const newCopyButtons = document.querySelectorAll(".copy-btn");

    // Re-bind sidebar events
    bindSidebarEvents();

    if (newSelectAllCheckbox) {
      newSelectAllCheckbox.addEventListener("change", function () {
        rowCheckboxes.forEach((checkbox) => {
          checkbox.checked = this.checked;
        });
        updateButtonStates();
      });
    }

    if (newDeleteButton) {
      newDeleteButton.addEventListener("click", function () {
        rowCheckboxes.forEach((checkbox) => {
          if (checkbox.checked) {
            checkbox.closest("tr").remove();
          }
        });
        rowCheckboxes = document.querySelectorAll(".row-checkbox");
        if (newSelectAllCheckbox) {
          newSelectAllCheckbox.checked = false;
          newSelectAllCheckbox.indeterminate = false;
        }
        if (newDeleteButton) newDeleteButton.disabled = true;
        const jobTableSection = document.querySelector(".job-table-section");
        if (jobTableSection) jobTableSection.style.height = "auto";
      });
    }

    if (newViewMoreButton) {
      newViewMoreButton.addEventListener("click", function (e) {
        e.preventDefault();
        fetch("./index.php?url=activity&client_id=")
          .then((response) => response.text())
          .then((data) => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(data, "text/html");
            let content =
              doc.querySelector(".activity-container")?.innerHTML || data;

            // Ensure the activity tab content exists
            let activityTab = document.getElementById("activity");
            if (!activityTab) {
              activityTab = document.createElement("div");
              activityTab.id = "activity";
              activityTab.classList.add("tab-content");
              activityTab.style.display = "none";
              document.querySelector(".main-content").appendChild(activityTab);
            }

            // Update activity tab content
            activityTab.innerHTML = `<div class="back-button-container"><button class="back-to-dashboard" style="background: none; color: black; border: none; margin-top: 20px; margin-left: 20px; font-size: 20px;"><i class="fas fa-chevron-left"></i></button></div>${content}`;

            // Switch to activity tab
            document.querySelectorAll(".tab-content").forEach((content) => {
              content.classList.remove("active");
              content.style.display = "none";
            });
            activityTab.classList.add("active");
            activityTab.style.display = "block";

            // Update sidebar active state
            document.querySelectorAll(".sidebar-item").forEach((item) => {
              item.classList.remove("active");
              item.setAttribute("aria-selected", "false");
            });
            const activitySidebarItem = document.querySelector(
              '.sidebar-item[data-tab="activity"]',
            );
            if (activitySidebarItem) {
              activitySidebarItem.classList.add("active");
              activitySidebarItem.setAttribute("aria-selected", "true");
            }
            activeTabId = "activity";

            // Update page header
            if (pageTitle && breadcrumb) {
              pageTitle.textContent = "Activity";
              breadcrumb.textContent = "Home → activity";
            }

            // Re-bind sidebar events
            bindSidebarEvents();

            // Bind back button
            const backButton = document.querySelector(".back-to-dashboard");
            if (backButton) {
              backButton.addEventListener("click", function () {
                // Restore original dashboard content
                document.querySelector(".main-content").innerHTML =
                  originalContent;

                // Switch to dashboard tab
                document.querySelectorAll(".tab-content").forEach((content) => {
                  content.classList.remove("active");
                  content.style.display = "none";
                });
                const dashboardTab = document.getElementById("dashboard");
                if (dashboardTab) {
                  dashboardTab.classList.add("active");
                  dashboardTab.style.display = "block";
                }

                // Update sidebar active state
                document.querySelectorAll(".sidebar-item").forEach((item) => {
                  item.classList.remove("active");
                  item.setAttribute("aria-selected", "false");
                });
                const dashboardSidebarItem = document.querySelector(
                  '.sidebar-item[data-tab="dashboard"]',
                );
                if (dashboardSidebarItem) {
                  dashboardSidebarItem.classList.add("active");
                  dashboardSidebarItem.setAttribute("aria-selected", "true");
                }
                activeTabId = "dashboard";

                // Update page header
                if (pageTitle && breadcrumb) {
                  pageTitle.textContent = "Dashboard";
                  breadcrumb.textContent = "Home → dashboard";
                }

                // Re-bind all event listeners
                rebindEventListeners();
              });
            }

            // Execute any scripts from the fetched content
            const scripts = doc.querySelectorAll("script");
            scripts.forEach((script) => {
              const newScript = document.createElement("script");
              if (script.src) {
                newScript.src = script.src;
              } else {
                newScript.textContent = script.textContent;
              }
              document.body.appendChild(newScript);
            });

            // Re-bind table and widget events
            rebindEventListeners();
          })
          .catch((error) => {
            console.error("Error loading activity.php:", error);
            document.querySelector(".main-content").innerHTML =
              "<p>Error loading content.</p>";
          });
      });
    }

    newCopyButtons.forEach((button) => {
      button.addEventListener("click", function () {
        const widget = this.closest(".widget-card");
        const input = widget.querySelector("input, textarea");
        if (input) {
          input.select();
          document.execCommand("copy");
          this.textContent = "Copied!";
          setTimeout(() => {
            this.textContent = "Copy";
          }, 2000);
        }
      });
    });

    updateButtonStates();
  }

  let resizeTimer;
  window.addEventListener("resize", () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
      if (window.innerWidth > 768 && sidebar.classList.contains("active")) {
        sidebar.classList.remove("active");
      }
    }, 200);
  });

  updateButtonStates();
  getUserJobHistory();
});

function getUserJobHistory() {
  $.ajax({
    url: "/crm/user-job-history",
    method: "GET",
    success: function (data) {
      // TODO(7d91210a1f91): should not work as data being sent back is json encoded
      const tableCard = document.getElementById("client-activities-preview");
      if (!tableCard) return;
      tableCard.innerHTML = data;
    },
    error: function (xhr, status, error) {
      console.error("User job history AJAX error:", error);
    },
  });
}
