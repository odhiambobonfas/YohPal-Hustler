let activities = []; // Global variable to store fetched activities data
let filteredActivities = []; // Filtered activities for display
let currentStatusFilter = "all"; // Status filter
const userRatings = {};

// Initialize the modal once
const invoiceModalElement = document.getElementById("invoiceModal");
const invoiceModal = new bootstrap.Modal(invoiceModalElement, {});

// Clean up the modal when it is hidden
invoiceModalElement.addEventListener("hidden.bs.modal", function () {
  console.log("Modal hidden, cleaning up backdrop");
  document
    .querySelectorAll(".modal-backdrop")
    .forEach((backdrop) => backdrop.remove());
  document.body.classList.remove("modal-open");
  invoiceModalElement.removeAttribute("aria-modal");
  invoiceModalElement.style.display = "none";
});

// Fetch activities data
async function loadActivitiesData() {
  try {
    const response = await fetch("/crm/client-activities");
    if (!response.ok) {
      throw new Error(`Failed to fetch activities data: ${response.status}`);
    }

    const data = await response.json();
    activities = data.jobHistory;
    filteredActivities = [...activities]; // Initialize filtered activities

    // Create filter controls after data is loaded
    createFilterControls();

    // Apply initial filtering and populate list
    applyFilters();

    // Initialize with the first activity if available and has an id
    if (filteredActivities.length > 0 && filteredActivities[0].id != null) {
      showDetails(filteredActivities[0].id);
    } else {
      document.getElementById("jobs-no-activities").style.display = "block";
    }
  } catch (error) {
    console.error("Error loading activities:", error);
  }
}

function createFilterControls() {
  // Get unique statuses
  const uniqueStatuses = [
    ...new Set(activities.map((activity) => activity.status)),
  ];

  // Create search and filter controls HTML - NO ICON, CLEAN INPUT
  const controlsHTML = `
    <div class="mb-3">
      <input type="text" class="form-control" id="activitiesSearch" placeholder="Search activities, descriptions, companies...">
    </div>

    <div class="d-flex flex-wrap gap-2 mb-3">
      <span class="badge rounded-pill ${currentStatusFilter === "all" ? "text-bg-primary" : "text-bg-secondary"} status-filter-pill"
            data-status="all" style="cursor: pointer;">
        All
      </span>
      ${uniqueStatuses
        .map(
          (status) => `
        <span class="badge rounded-pill ${currentStatusFilter === status.toLowerCase() ? getStatusBadgeClass(status) : "text-bg-secondary"} status-filter-pill"
              data-status="${status.toLowerCase()}" style="cursor: pointer;">
          ${status}
        </span>
      `,
        )
        .join("")}
    </div>
  `;

  // Put controls in YOUR filterControls container
  const filterControlsContainer = document.getElementById("filterControls");
  if (filterControlsContainer) {
    filterControlsContainer.innerHTML = controlsHTML;
    setupFilterEventListeners();
  } else {
    console.error("filterControls container not found!");
  }
}

function setupFilterEventListeners() {
  // Search input
  document
    .getElementById("activitiesSearch")
    .addEventListener("input", function (e) {
      applyFilters();
    });

  // Status filter pills
  document.querySelectorAll(".status-filter-pill").forEach((pill) => {
    pill.addEventListener("click", function () {
      const status = this.getAttribute("data-status");
      currentStatusFilter = status;

      // Update pill appearances
      document.querySelectorAll(".status-filter-pill").forEach((p) => {
        const pillStatus = p.getAttribute("data-status");
        if (pillStatus === status) {
          if (status === "all") {
            p.className =
              "badge rounded-pill text-bg-primary status-filter-pill";
          } else {
            p.className = `badge rounded-pill ${getStatusBadgeClass(status)} status-filter-pill`;
          }
        } else {
          p.className =
            "badge rounded-pill text-bg-secondary status-filter-pill";
        }
      });

      applyFilters();
    });
  });
}

function applyFilters() {
  const searchTerm =
    document.getElementById("activitiesSearch")?.value.toLowerCase() || "";

  // Start with all activities
  let filtered = [...activities];

  // Apply status filter
  if (currentStatusFilter !== "all") {
    filtered = filtered.filter(
      (activity) => activity.status.toLowerCase() === currentStatusFilter,
    );
  }

  // Apply search filter
  if (searchTerm) {
    filtered = filtered.filter(
      (activity) =>
        activity.name.toLowerCase().includes(searchTerm) ||
        (activity.description &&
          activity.description.toLowerCase().includes(searchTerm)) ||
        (activity.company &&
          activity.company.toLowerCase().includes(searchTerm)) ||
        (activity.location &&
          activity.location.toLowerCase().includes(searchTerm)),
    );
  }

  // Always sort by date, newest first
  filtered.sort((a, b) => {
    return (b.startTime._seconds || 0) - (a.startTime._seconds || 0);
  });

  filteredActivities = filtered;
  populateActivitiesList();

  // Update selection if current selection is no longer visible
  const currentlySelected = document.querySelector(
    "#jobs-list li.active, .activity-card.border-success",
  );
  if (currentlySelected) {
    const selectedId =
      currentlySelected.getAttribute("data-id") ||
      currentlySelected.getAttribute("data-index");
    const isStillVisible = filteredActivities.some(
      (activity) => String(activity.id) === selectedId,
    );

    if (!isStillVisible && filteredActivities.length > 0) {
      showDetails(filteredActivities[0].id);
    }
  }
}

function getStatusBadgeClass(status) {
  const statusLower = status.toLowerCase();
  switch (statusLower) {
    case "completed":
      return "text-bg-success";
    case "ongoing":
    case "open":
      return "text-bg-info";
    case "cancelled":
      return "text-bg-danger";
    case "pending":
      return "text-bg-warning";
    default:
      return "text-bg-secondary";
  }
}

function populateActivitiesList() {
  const jobsList = document.getElementById("jobs-list");
  const noActivitiesMessage = document.getElementById("jobs-no-activities");
  jobsList.innerHTML = ""; // Clear existing items

  if (filteredActivities.length === 0) {
    noActivitiesMessage.style.display = "block";
    noActivitiesMessage.innerHTML = `
      <div class="text-center p-4">
        <i class="fas fa-search fa-3x text-muted mb-3"></i>
        <h5 class="text-muted">No activities found</h5>
        <p class="text-muted">Try adjusting your search or filter criteria.</p>
      </div>
    `;
    return;
  }

  noActivitiesMessage.style.display = "none";

  let html = "";
  filteredActivities.forEach((activity, index) => {
    const isActive = index === 0 ? "border-success" : "";

    html += `<div data-index=${activity.id} class="border card ${isActive} d-flex flex-column gap-2 rounded-3 p-3 activity-card w-100" style="cursor: pointer;margin-bottom: 1rem;">
                <h2 class="fs-5 fw-semibold mb-0">${activity.name}</h2>
                <span>by <small><b>${activity.company ?? "Unknown Company"}</b></small></span>
                <div class="d-flex flex-row gap-3" style="font-size:0.9rem;">
                    <span><i class="far fa-calendar"></i> ${new Date(activity.startTime._seconds * 1000).toLocaleDateString()}</span>
                    <span><i class="far fa-clock"></i> ${getDuration(activity.startTime, activity.endTime)}</span>
                    <span><i class="fas fa-map-pin"></i> ${activity.location ?? "Unknown Location"}</span>
                </div>
                <span><i class="fas fa-file-alt"></i> ${trim(activity.description) || "No description available"}</span>
                <span class="badge ${getStatusBadgeClass(activity.status)} rounded-pill" style="max-width:30%"> ${activity.status}</span>
            </div>`;
  });

  jobsList.innerHTML = html;

  // Add click event listeners to activity cards
  document.querySelectorAll(".activity-card").forEach((card) => {
    card.addEventListener("click", function () {
      const activityId = this.getAttribute("data-index");
      const activity = filteredActivities.find(
        (a) => String(a.id) === String(activityId),
      );
      if (activity) {
        // Remove border-success from all cards
        document
          .querySelectorAll(".activity-card")
          .forEach((c) => c.classList.remove("border-success"));
        // Add border-success to clicked card
        this.classList.add("border-success");
        showDetails(activity.id);
      }
    });
  });
}

function getDuration(start, end) {
  const seconds = end._seconds - start._seconds;

  const minutes = Math.floor(seconds / 60);
  const hours = Math.floor(seconds / 3600);
  const days = Math.floor(seconds / 86400);

  if (days >= 1) return `${days} day${days > 1 ? "s" : ""}`;
  if (hours >= 1) return `${hours} hour${hours > 1 ? "s" : ""}`;
  if (minutes >= 1) return `${minutes} minute${minutes > 1 ? "s" : ""}`;
  return `${seconds} second${seconds !== 1 ? "s" : ""}`;
}

function getStatusClass(status) {
  const statusMap = {
    Completed: "completed",
    Ongoing: "ongoing",
    Pending: "pending",
    Cancelled: "cancelled",
    Open: "open",
  };
  return statusMap[status] || "";
}

async function loadInvoiceContent(jobId) {
  const modalBody = document.getElementById("invoiceModalBody");
  const activity = activities.find((a) => String(a.id) === String(jobId));
  try {
    modalBody.innerHTML = `
        <div class="card border-0">
          <div class="card-header  text-black">
            <h4 class="mb-0"><i class="fas fa-file-invoice me-2"></i>Job Summary</h4>
          </div>
          <div class="card-body">
            <div class="row mb-4">
              <div class="col-md-8">
                <h6 class="text-muted">Job Information</h6>
                <p class="mb-1"><strong>Job Title:</strong> ${activity.name}</p>
                <p class="mb-1"><strong>Freelancer Name:</strong> David</p>
                <p class="mb-1"><strong>Email:</strong> kamaudavid60@gmail.com</p>
                <p class="mb-0"><strong>Job ID:</strong> ${activity.id}</p>
              </div>
              <div class="col-md-4 text-end">
                <span class="badge ${getStatusBadgeClass(activity.status)} rounded-pill fs-6">${activity.status}</span>
              </div>
            </div>

            <div class="mb-4">
              <h6 class="text-muted mb-3"><i class="fas fa-clock me-2"></i>Work Timeline</h6>
              <div class="row">
                <div class="col-sm-6">
                  <div class="border rounded p-3 text-center">
                    <small class="text-muted d-block">Start Time</small>
                    <strong>${new Date(activity.startTime._seconds * 1000).toLocaleString()}</strong>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="border rounded p-3 text-center">
                    <small class="text-muted d-block">End Time</small>
                    <strong>${new Date(activity.endTime._seconds * 1000).toLocaleString()}</strong>
                  </div>
                </div>
              </div>
            </div>

            <div class="mb-4">
              <h6 class="text-muted mb-3"><i class="fas fa-money-bill-wave me-2"></i>Payment Breakdown</h6>
              <div class="card">
                <div class="card-body p-0">
                  <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                      <div>
                        <i class="far fa-square me-2"></i>
                        <span>Job Fee</span>
                      </div>
                      <span class="fw-semibold">KES 2,250</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                      <div>
                        <i class="far fa-check-square me-2 text-success"></i>
                        <span>Transport Fee</span>
                      </div>
                      <span class="fw-semibold">KES 250</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                      <div>
                        <i class="far fa-square me-2"></i>
                        <span>Tax Fee</span>
                      </div>
                      <span class="fw-semibold">KES 250</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center bg-light">
                      <div>
                        <i class="far fa-square me-2"></i>
                        <strong>Total Payment</strong>
                      </div>
                      <span class="fw-bold fs-5 text-success">KES 2,750</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="mb-0">
              <h6 class="text-muted mb-3"><i class="fas fa-file-alt me-2"></i>Job Description</h6>
              <div class="card">
                <div class="card-body">
                  <p class="mb-0">${activity.description}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
    `;
  } catch (error) {
    console.error("Error loading invoice:", error);
    modalBody.innerHTML = `
      <div class="alert alert-danger" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        Error loading invoice details. Please try again.
      </div>
    `;
  }
}

function showDetails(id) {
  const activity = filteredActivities.find((a) => String(a.id) === String(id));
  const details = document.getElementById("jobs-details-content");

  if (!activity) {
    details.innerHTML = `
      <div class="alert alert-info" role="alert">
        <i class="fas fa-info-circle me-2"></i>
        No details available for this activity.
      </div>
    `;
    return;
  }

  // Build hustler reviews content with Bootstrap styling
  let hustlersReviewsContent = "";
  if (activity.hustlers) {
    hustlersReviewsContent = `
      <div class="mt-4">
        <h5 class="mb-4"><i class="fas fa-star me-2"></i>Reviews</h5>

        <!-- Reviews You Gave -->
        <div class="card mb-4">
          <div class="card-header">
            <h6 class="mb-0"><i class="fas fa-thumbs-up me-2"></i>Reviews You Gave to Hustlers</h6>
          </div>
          <div class="card-body">
            ${
              Object.entries(activity.hustlers)
                .filter(
                  ([_, hustler]) => hustler.reviews && hustler.reviews.received,
                )
                .map(([hustlerId, hustler]) => {
                  const received = hustler.reviews.received;
                  const starFields = Object.entries(received).filter(
                    ([key, _]) =>
                      key !== "comment" && received[key].type === "star",
                  );
                  const overallRating =
                    starFields.length > 0
                      ? Math.round(
                          starFields.reduce(
                            (sum, [_, value]) => sum + value.value,
                            0,
                          ) / starFields.length,
                        )
                      : 0;

                  return `
                  <div class="border rounded p-3 mb-3">
                    <div class="row">
                      ${starFields
                        .map(
                          ([key, value]) => `
                        <div class="col-sm-6 col-md-3 mb-2">
                          <small class="text-muted d-block">${key.charAt(0).toUpperCase() + key.slice(1)}</small>
                          <div class="text-warning">
                            ${Array(5)
                              .fill()
                              .map(
                                (_, i) =>
                                  `<i class="fas fa-star${i < value.value ? "" : " text-muted"}"></i>`,
                              )
                              .join("")}
                          </div>
                        </div>
                      `,
                        )
                        .join("")}
                    </div>
                    <div class="mt-3 pt-3 border-top">
                      <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">Overall Rating:</span>
                        <div class="text-warning">
                          ${Array(5)
                            .fill()
                            .map(
                              (_, i) =>
                                `<i class="fas fa-star${i < overallRating ? "" : " text-muted"}"></i>`,
                            )
                            .join("")}
                          <span class="ms-2 text-dark">(${overallRating}/5)</span>
                        </div>
                      </div>
                      ${
                        received.comment
                          ? `
                        <div class="mt-2">
                          <small class="text-muted">Comment:</small>
                          <p class="mb-0 mt-1">${received.comment.value || "No comment provided."}</p>
                        </div>
                      `
                          : ""
                      }
                    </div>
                  </div>
                `;
                })
                .join("") ||
              '<div class="text-muted text-center py-3">No reviews given to hustlers.</div>'
            }
          </div>
        </div>

        <!-- Reviews You Received -->
        <div class="card">
          <div class="card-header">
            <h6 class="mb-0"><i class="fas fa-thumbs-up me-2"></i>Reviews You Received from Hustlers</h6>
          </div>
          <div class="card-body">
            ${
              Object.entries(activity.hustlers)
                .filter(
                  ([_, hustler]) => hustler.reviews && hustler.reviews.sent,
                )
                .map(([hustlerId, hustler]) => {
                  const sent = hustler.reviews.sent;
                  const starFields = Object.entries(sent).filter(
                    ([key, _]) =>
                      key !== "comment" && sent[key].type === "star",
                  );
                  const overallRating =
                    starFields.length > 0
                      ? Math.round(
                          starFields.reduce(
                            (sum, [_, value]) => sum + value.value,
                            0,
                          ) / starFields.length,
                        )
                      : 0;

                  return `
                  <div class="border rounded p-3 mb-3">
                    <div class="row">
                      ${starFields
                        .map(
                          ([key, value]) => `
                        <div class="col-sm-6 col-md-3 mb-2">
                          <small class="text-muted d-block">${key.charAt(0).toUpperCase() + key.slice(1)}</small>
                          <div class="text-warning">
                            ${Array(5)
                              .fill()
                              .map(
                                (_, i) =>
                                  `<i class="fas fa-star${i < value.value ? "" : " text-muted"}"></i>`,
                              )
                              .join("")}
                          </div>
                        </div>
                      `,
                        )
                        .join("")}
                    </div>
                    <div class="mt-3 pt-3 border-top">
                      <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">Overall Rating:</span>
                        <div class="text-warning">
                          ${Array(5)
                            .fill()
                            .map(
                              (_, i) =>
                                `<i class="fas fa-star${i < overallRating ? "" : " text-muted"}"></i>`,
                            )
                            .join("")}
                          <span class="ms-2 text-dark">(${overallRating}/5)</span>
                        </div>
                      </div>
                      ${
                        sent.comment
                          ? `
                        <div class="mt-2">
                          <small class="text-muted">Comment:</small>
                          <p class="mb-0 mt-1">${sent.comment.value || "No comment provided."}</p>
                        </div>
                      `
                          : ""
                      }
                    </div>
                  </div>
                `;
                })
                .join("") ||
              '<div class="text-muted text-center py-3">No reviews received from hustlers.</div>'
            }
          </div>
        </div>
      </div>
    `;
  }

  let content = `
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
          <img src="../assets/store/images/app/company.png" alt="${activity.company || "Company"}"
               class="rounded-circle" width="48" height="48">
          <div>
            <h5 class="mb-1 fw-semibold">${activity.name}</h5>
            <small class="text-muted">${activity.company || ""}</small>
          </div>
        </div>
        <button class="btn btn-danger rate-client fw-semibold"
                data-bs-toggle="modal" data-bs-target="#invoiceModal" data-job-id="${id}">
          <i class="fas fa-file-invoice me-2"></i>Invoice
        </button>
      </div>

      <div class="card-body">
        <div class="row mb-4">
          <div class="col-md-4">
            <small class="text-muted d-block">Posted Date</small>
            <span class="fw-semibold">
              ${new Date(activity.startTime._seconds * 1000)
                .toLocaleDateString("en-GB", {
                  day: "2-digit",
                  month: "short",
                  year: "numeric",
                })
                .replace(/^(\d{2}) (\w{3}) (\d{4})$/, "$1 $2, $3")}
            </span>
          </div>
          <div class="col-md-4">
            <small class="text-muted d-block">Status</small>
            <span class="badge ${getStatusBadgeClass(activity.status)} rounded-pill">${activity.status}</span>
          </div>
          <div class="col-md-4">
            <small class="text-muted d-block">Location</small>
            <span class="fw-semibold">
              <i class="fas fa-map-marker-alt me-1"></i>
              ${activity.location || "No location specified"}
            </span>
          </div>
        </div>

        <div class="mb-4">
          <h6 class="mb-3"><i class="fas fa-file-alt me-2"></i>Description</h6>
          <div class="card bg-light border-0">
            <div class="card-body">
              <p class="mb-0">${activity.description || "No description available."}</p>
            </div>
          </div>
        </div>

        ${hustlersReviewsContent}
      </div>
    </div>
  `;

  details.innerHTML = content;
  details.scrollTop = 0;

  // Use event delegation for .rate-client buttons
  document.getElementById("jobs-details-content").addEventListener(
    "click",
    function (event) {
      if (event.target.closest(".rate-client")) {
        const button = event.target.closest(".rate-client");
        const jobId = button.getAttribute("data-job-id");
        console.log("Invoice button clicked for job ID:", jobId);
        loadInvoiceContent(jobId);
        invoiceModal.show();
      }
    },
    {
      once: true,
    },
  );
}

// Event listeners for modal buttons
document
  .getElementById("reportIssueBtn")
  .addEventListener("click", function () {
    console.log("Report Issue button clicked");
    bootstrap.Modal.getInstance(invoiceModalElement).hide();
  });

document
  .getElementById("downloadReceiptBtn")
  .addEventListener("click", function () {
    console.log("Download Receipt button clicked");
    bootstrap.Modal.getInstance(invoiceModalElement).hide();
  });

document.addEventListener("DOMContentLoaded", function () {
  loadActivitiesData();

  window.addEventListener("message", function (event) {
    if (event.data.type === "submitRating") {
      const { jobId, ratings, comment } = event.data;
      const total = Math.round(
        (ratings.Competence +
          ratings.Quality +
          ratings.Timeliness +
          ratings.Reliability) /
          4,
      );
      userRatings[jobId] = {
        categories: [
          {
            label: "Competence",
            stars: ratings.Competence,
          },
          {
            label: "Quality",
            stars: ratings.Quality,
          },
          {
            label: "Timeliness",
            stars: ratings.Timeliness,
          },
          {
            label: "Reliability",
            stars: ratings.Reliability,
          },
        ],
        total,
        comment,
      };

      const activeCard = document.querySelector(
        ".activity-card.border-success",
      );
      if (
        activeCard &&
        String(activeCard.getAttribute("data-index")) === String(jobId)
      ) {
        showDetails(jobId);
      }
    }
  });
});

function trim(content) {
  const maxLen = 60; // Increased for better display
  if (!content || content.length < maxLen) return content;

  return content.substring(0, maxLen) + "...";
}
