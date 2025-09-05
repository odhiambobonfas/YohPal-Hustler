let jobHistoryList = [];
let filteredJobHistory = [];
let selectedJobId = null;
let activeStatusFilter = "all"; // Track active status filter

// Show loading states initially
historyLoading.style.display = "block";
jobDetailsLoading.style.display = "block";
viewInvoice.disabled = true;
viewOnMap.disabled = true;

fetch("/crm/hustler/job-history")
  .then((r) => r.json())
  .then((d) => {
    jobHistoryList = d?.jobHistory ?? [];
    filteredJobHistory = d?.jobHistory ?? [];

    // Create status filter pills after data is loaded
    createStatusFilterPills();
    displayJobHistoryList(filteredJobHistory);

    if (jobHistoryList.length > 0) {
      selectedJobId = jobHistoryList[0].id;
      displayDetails(jobHistoryList[0]);
      displayJobHistoryList(filteredJobHistory);
    }
  })
  .catch((e) => {
    console.error("ERR: ", e);
  })
  .finally(() => {
    if (filteredJobHistory != 0) {
      viewInvoice.disabled = false;
    }
    jobDetailsLoading.style.display = "none";
  });

// Enhanced search with status filtering
requestSearch.addEventListener("input", function (e) {
  applyFilters();
});

function applyFilters() {
  const searchTerm = requestSearch.value.toLowerCase();

  // Start with all jobs
  let filtered = jobHistoryList;

  // Apply status filter first
  if (activeStatusFilter !== "all") {
    filtered = filtered.filter(
      (job) => job.status.toLowerCase() === activeStatusFilter.toLowerCase(),
    );
  }

  // Then apply search filter
  if (searchTerm !== "") {
    filtered = filtered.filter((request) => {
      return (
        request.name.toLowerCase().includes(searchTerm) ||
        (request.ownerName &&
          request.ownerName.toLowerCase().includes(searchTerm)) ||
        (request.description &&
          request.description.toLowerCase().includes(searchTerm)) ||
        (request.region && request.region.toLowerCase().includes(searchTerm))
      );
    });
  }

  filteredJobHistory = filtered;
  displayJobHistoryList(filteredJobHistory);

  // If current selected job is not in filtered results, select first available
  if (filteredJobHistory.length > 0) {
    const isSelectedJobVisible = filteredJobHistory.some(
      (job) => job.id === selectedJobId,
    );
    if (!isSelectedJobVisible) {
      selectedJobId = filteredJobHistory[0].id;
      displayDetails(filteredJobHistory[0]);
    }
  }
}

function createStatusFilterPills() {
  // Get unique statuses from job history
  const uniqueStatuses = [...new Set(jobHistoryList.map((job) => job.status))];

  // Create filter pills container
  let statusFiltersHTML = `
    <div class="d-flex flex-row gap-2 mb-3 flex-wrap">
      <span class="badge rounded-pill ${activeStatusFilter === "all" ? "text-bg-primary" : "text-bg-secondary"} status-filter-pill"
            data-status="all" style="cursor: pointer;">
        All
      </span>
  `;

  uniqueStatuses.forEach((status) => {
    const isActive = activeStatusFilter === status.toLowerCase();
    const badgeClass = getBadgeClass(status);
    statusFiltersHTML += `
      <span class="badge rounded-pill ${isActive ? badgeClass : "text-bg-secondary"} status-filter-pill"
            data-status="${status.toLowerCase()}" style="cursor: pointer;">
        ${status}
      </span>
    `;
  });

  statusFiltersHTML += `</div>`;

  // Insert the filter pills before the job history list
  const filtersContainer =
    document.getElementById("statusFilters") || document.createElement("div");
  filtersContainer.innerHTML = statusFiltersHTML;

  // If the container doesn't exist, insert it before the job history
  if (!document.getElementById("statusFilters")) {
    filtersContainer.id = "statusFilters";
    jobHistoriesSide.parentNode.insertBefore(
      filtersContainer,
      jobHistoriesSide,
    );
  }

  // Add click event listeners to filter pills
  document.querySelectorAll(".status-filter-pill").forEach((pill) => {
    pill.addEventListener("click", function () {
      const status = this.getAttribute("data-status");
      activeStatusFilter = status;

      // Update pill appearances
      document.querySelectorAll(".status-filter-pill").forEach((p) => {
        const pillStatus = p.getAttribute("data-status");
        if (pillStatus === status) {
          if (status === "all") {
            p.className =
              "badge rounded-pill text-bg-primary status-filter-pill";
          } else {
            p.className = `badge rounded-pill ${getBadgeClass(status)} status-filter-pill`;
          }
        } else {
          p.className =
            "badge rounded-pill text-bg-secondary status-filter-pill";
        }
      });

      // Apply filters
      applyFilters();
    });
  });
}

function getBadgeClass(status) {
  const statusLower = status.toLowerCase();
  switch (statusLower) {
    case "completed":
      return "text-bg-success";
    case "open":
    case "active":
      return "text-bg-info";
    case "cancelled":
    case "canceled":
      return "text-bg-danger";
    case "pending":
      return "text-bg-warning";
    default:
      return "text-bg-secondary";
  }
}

function displayJobHistoryList(jobHistories) {
  let html = "";
  if (jobHistories.length == 0) {
    html = `<div class="border card h-25 justify-content-center d-flex flex-column gap-2 rounded-3 p-3 text-center">
            <h2 class="fs-4 mb-0 text-muted">No jobs found</h2>
        </div>`;
  } else {
    jobHistories.forEach((r) => {
      const isActive = selectedJobId === r.id ? "border-success" : "";

      html += `<div data-index=${r.id} class="border card ${isActive} d-flex flex-column gap-2 rounded-3 p-3 job-history-card" style="cursor: pointer;">
                <h2 class="fs-5 fw-semibold mb-0">${r.name}</h2>
                <span>by <small><b>${r.ownerName ?? "yohpal user"}</b></small></span>
                <div class="d-flex flex-row gap-3" style="font-size:0.9rem;">
                    <span><i class="far fa-calendar"></i> ${new Date(r.startTime._seconds * 1000).toLocaleDateString()}</span>
                    <span><i class="far fa-clock"></i> ${getDuration(r.startTime, r.endTime)}</span>
                    <span><i class="fas fa-users"></i> ${r.hustlersCount}</span>
                </div>
                <span><i class="fas fa-map-pin"></i> ${r.region ?? "Unknown"}</span>
                <span class="badge ${getBadgeClass(r.status)} rounded-pill" style="max-width:30%"> ${r.status}</span>
            </div>`;
    });
  }

  jobHistoriesSide.innerHTML = html;

  // Add click event listeners to jobHistory cards
  document.querySelectorAll(".job-history-card").forEach((card) => {
    card.addEventListener("click", function () {
      const jobId = this.getAttribute("data-index");
      const request = filteredJobHistory.find((r) => r.id == jobId);
      if (request) {
        selectedJobId = request.id;
        displayDetails(request);
        displayJobHistoryList(filteredJobHistory);
      }
    });
  });
}

function displayDetails(r) {
  html = `
    <h1 class="fs-3 fw-semibold">${r.name}</h1>
    <p>Posted By <b>${r.ownerName ?? "yohpal user"}</b></p>
    <div class="d-flex flex-row flex-wrap gap-3">
        <span><i class="fas fa-map-pin"></i> ${r.region ?? "Unknown"}</span>
        <span><i class="far fa-clock"></i> ${getDuration(r.startTime, r.endTime)}</span>
        <span><i class="far fa-calendar"></i> ${new Date(r.startTime._seconds * 1000).toLocaleDateString()}</span>
        <span><i class="fas fa-clock"></i> ${new Date(r.startTime._seconds * 1000).toLocaleTimeString()}</span>
    </div>
    <div class="d-flex flex-row w-100 gap-2 my-2">
        <span class="badge rounded-pill ${getBadgeClass(r.status)}">${r.status}</span>
        <span><i class="fas fa-users"></i> ${r.hustlersCount}</span>
    </div>
    <hr/>
    <div class="d-flex flex-column gap-2">
        <h2 class="fs-3 fw-semibold">Job Description</h2>
        <p>${r.description}</p>
        </div>
        <hr/>
        <div class="d-flex flex-column gap-2">
        <h2 class="fs-3 fw-semibold">Job Details</h2>
        <div class="d-flex flex-row justify-content-between">
            <span class="fw-semibold">Job ID</span>
            <span>${r.id}</span>
        </div>

        <div class="d-flex flex-row justify-content-between">
            <span class="fw-semibold">Start Date</span>
            <span>${new Date(r.startTime._seconds * 1000).toLocaleDateString()}</span>
        </div>

        <div class="d-flex flex-row justify-content-between">
            <span class="fw-semibold">End Date</span>
            <span>${new Date(r.endTime._seconds * 1000).toLocaleDateString()}</span>
        </div>
    </div>
    `;

  if (r.status.toLowerCase() === "accepted") {
    viewOnMap.disabled = false;
    const eventCallback = function () {
      window.location.href = `/job/location/${r.id}`;
    };
    viewOnMap.removeEventListener("click", eventCallback);
    viewOnMap.addEventListener("click", eventCallback);
  } else {
    viewOnMap.disabled = true;
  }

  jobHistoryDetails.innerHTML = html;
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
