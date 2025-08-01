let requestList = [];
let filteredRequests = [];
let selectedRequestId = null;

// Show loading states initially
requestsLoading.style.display = "block";
detailsLoading.style.display = "block";
if (acceptBtn) acceptBtn.disabled = true;
if (rejectBtn) rejectBtn.disabled = true;

function acceptRequest() {
  if (selectedRequestId) {
    fetch("/crm/job/accept-req", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ jobId: selectedRequestId }),
    })
      .then((r) => r.json())
      .then((d) => console.log(d))
      .catch((e) => console.error("Failed to accept Job: ", e));
  }
}

function rejectRequest() {
  if (selectedRequestId) {
    fetch("/crm/job/reject-req", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ jobId: selectedRequestId }),
    })
      .then((r) => r.json())
      .then((d) => console.log(d))
      .catch((e) => console.error("Failed to accept Job: ", e));
  }
}

fetch("/crm/hustler/job-requests")
  .then((r) => r.json())
  .then((d) => {
    requestList = d.jobRequests;
    filteredRequests = d.jobRequests;

    displayRequestsList(filteredRequests);

    if (d.jobHistory.length > 0) {
      selectedRequestId = d.jobHistory[0].id;
      displayDetails(d.jobHistory[0]);
    }
  })
  .catch((e) => {
    console.error("ERR: ", e);
  })
  .finally(() => {
    requestsLoading.style.display = "none";
    detailsLoading.style.display = "none";
    if (acceptBtn) acceptBtn.disabled = false;
    if (rejectBtn) rejectBtn.disabled = false;
  });

requestSearch.addEventListener("input", function (e) {
  const searchTerm = e.target.value.toLowerCase();

  if (searchTerm === "") {
    filteredRequests = requestList;
  } else {
    filteredRequests = requestList.filter((request) => {
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

  displayRequestsList(filteredRequests);
});

function displayRequestsList(requests) {
  let html = "";
  if (requests.length === 0) {
    html = `<div class="border card h-25 justify-content-center d-flex flex-column gap-2 rounded-3 p-3 text-center">
            <h2 class="fs-4 mb-0 text-muted">No jobs found</h2>
        </div>`;

    if (acceptBtn) acceptBtn.disabled = true;
    if (rejectBtn) rejectBtn.disabled = true;
  } else {
    requests.forEach((r) => {
      const isActive = selectedRequestId === r.id ? "border-success" : "";

      html += `<div data-index=${r.id} class="border card ${isActive} d-flex flex-column gap-2 rounded-3 p-3 request-card" style="cursor: pointer;">
                <h2 class="fs-5 fw-semibold mb-0">${r.name}</h2>
                <span>by <small><b>${r.ownerName ?? "yohpal user"}</b></small></span>
                <div class="d-flex flex-row gap-3" style="font-size:0.9rem;">
                    <span><i class="far fa-calendar"></i> ${new Date(r.startTime._seconds * 1000).toLocaleDateString()}</span>
                    <span><i class="far fa-clock"></i> ${getDuration(r.startTime, r.endTime)}</span>
                    <span><i class="fas fa-users"></i> ${r.hustlersCount}</span>
                </div>
                <span><i class="fas fa-map-pin"></i> ${r.region ?? "Unknown"}</span>
                <span class="badge text-bg-success rounded-pill" style="max-width:30%"> ${r.status}</span>
            </div>`;
    });
  }

  requestsList.innerHTML = html;

  // Add click event listeners to request cards
  document.querySelectorAll(".request-card").forEach((card) => {
    card.addEventListener("click", function () {
      const requestId = this.getAttribute("data-index");
      const request = filteredRequests.find((r) => r.id == requestId);
      if (request) {
        selectedRequestId = request.id;
        displayDetails(request);
        displayRequestsList(filteredRequests);
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
        <span class="badge rounded-pill text-bg-success">${r.status}</span>
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
  requestDetails.innerHTML = html;
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
