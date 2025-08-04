<!-- header -->
<?php include 'partials/layout/web/header.php'; ?>
<!-- /header -->

<!-- styles -->
<link type="text/css" rel="stylesheet" href="<?= asset_url('/css/app/crm/main.css') ?>">
<link type="text/css" rel="stylesheet" href="<?= asset_url('/css/app/crm/job-portal.css') ?>">
<!-- /styles -->

<!-- navbar -->
<?php include 'partials/layout/crm/navbar.php'; ?>
<!-- /navbar -->

<!-- Main CRM Section -->
<div class="crm-section">
    <div class="d-flex gap-3">
        <!-- Sidebar -->
        <aside class="col-md-2 d-none d-md-block" id="sidebar">
            <div class="card bg-transparent border-0">
                <?php include 'partials/layout/crm/sidebar.php'; ?>
            </div>
        </aside>

        <!-- CRM Content -->
        <main class="col-md-9 flex-grow-1 mt-5">
            <div class="card bg-transparent border-0 mt-5">

                <div class="job-search-c p-2 p-md-0">
                    <h1>Let's find you a <span style="color: #ff0000;">Hustler</span></h1>
                    <div class="job-search p-2 border border-secondary rounded-pill d-flex align-items-center">
                      <input type="search"
                        class="form-control border-0 shadow-none flex-grow-1"
                        autofocus
                        placeholder="Search for a skill..."
                        id="job-search-val" />
                      <button class="btn fs-5 w-50 w-md-25 p-2 rounded-pill">Find skill</button>
                    </div>
                </div>

                <!-- Portal start -->
                <div class="card bg-transparent border-0 rounded p-3">
                    <div class="content-section">
                        <div class="jobs" id="jobs"></div>

                            <div class="job-portal-step-section jobs-listing d-none">
                                <?php include "partials/job-portal/jobs-listing.php"; ?>
                            </div>
                        <div class="job-portal-step-section mapping-section d-none">
                                <!-- Header -->
                                <div class="d-flex justify-content-between align-items-center rounded p-2 mb-1 m-2">
                                    <div class="aside-content">
                                        <button class="btn btn-md btn-link me-2 text-nowrap backBtn float-start text-start" id="backBtn">
                                            <i class="fas fa-arrow-left"></i>
                                        </button>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <!-- Refresh Button -->
                                        <button type="button" id="refreshMapBtn" class="btn btn-link p-1 border-gray rounded-0 refresh-map-btn">
                                            <i class="bi bi-arrow-clockwise fa-2x text-success"></i>
                                        </button>
                                    </div>
                                </div>
                            <?php include "partials/job-portal/mapping-map.php"; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Portal start -->
            </div>
        </main>
    </div>
</div>

<!-- modals -->
<div class="modal fade create-job-modal" id="create-job-modal">
    <?php include "partials/job-portal/create-job-modal.php" ?>
</div>
<!-- /modals -->

<!-- footer -->
<?php include 'partials/layout/crm/footer.php'; ?>
<!-- /footer -->

<!-- xtra scripts -->
<script type="text/javascript" src="<?= asset_url('js/app/crm/auth.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/crm/dashboard.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/crm/hustle-map.js') ?>"></script>

<!-- TODO:: (b1e70595885b) -->
<script>
class JobPortal extends Master {
  constructor() {
    super();
    this.stepperSections = document.querySelectorAll(
      ".job-portal-step-section",
    );
    this.contentSection = document.querySelector(".content-section");
    this.categoryListing = document.querySelector(".jobs");
    this.jobsListing = document.querySelector(".jobs-listing");
    this.mapSection = document.querySelector(".mapping-section");
    this.selected_job = undefined;
  }

  setupPage() {
    this.initOverlay(this.contentSection);
    this.bindCategories();
  }

  bindCategories() {
    document.querySelectorAll(".job-category").forEach((el) => {
      el.addEventListener("click", () => {
        document.querySelector(".job-search").classList.add("d-none");
        const categoryId = el.getAttribute("data-id");
        const all = JSON.parse(localStorage.getItem("categories") || "[]");
        const category = all.find((c) => c.slug === categoryId);
        if (!category) return toast("error", 5000, "No cached category found.");

        this.categoryListing.classList.add("d-none");
        const html = this.renderCategoryHtmlFromCache(category);
        __append_html(html, this.jobsListing);
        this.jobsListing.classList.remove("d-none");

        this.bindBackBtnClick();
        enableToggleHighlight(".job-list-group", [
          this.createJobDraft.bind(this),
        ]);
      });
    });
  }

  bindBackBtnClick() {
    document.querySelectorAll(".backBtn").forEach((backBtn) => {
      backBtn.addEventListener("click", () => {
        document.querySelector(".job-search").classList.remove("d-none");
        this.stepperSections.forEach((s) => s.classList.add("d-none"));
        this.categoryListing.classList.remove("d-none");
        this.jobsListing.innerHTML = "";
      });
    });
  }

  createJobDraft(subCategoryId, extra_params = []) {
    __show_modal(".create-job-modal");
    const createJobForm = document.querySelector(".create-job-modal-form");
    if (!createJobForm) return;
    createJobForm.setAttribute("action", `/job/create/${subCategoryId}`);
    createJobForm.querySelector(".job-title").value =
      extra_params["job_name"] || "";
    flatpickrUtil();

    let btn = document.querySelector(".create-job-submit-btn");
    if (!btn) return;
    btn = cloneNodeElement(btn);
    btn.addEventListener("click", (event) => {
      event.preventDefault();
      toggleButtonContent(btn);
      disableElement(btn);
      const form = btn.closest("form");
      const data = serializeFormToArray(form);

      $.ajax({
        type: "POST",
        url: `${form.action}/${subCategoryId}`,
        data,
        dataType: "json",
        headers: { "X-Requested-With": "XMLHttpRequest" },
        success: function (res) {
          toggleButtonContent(btn, "", true);
          enableElement(btn);

          if (res?.status === "success") {
            toast("success", 5000, res.message);
            resetFormAndCloseModal(form);
            dashboardInstance.showOverlay();
            dashboardInstance.stepperSections.forEach((s) =>
              s.classList.add("d-none"),
            );
            dashboardInstance.mapSection.classList.remove("d-none");
            dashboardInstance.hideOverlay();
            dashboardInstance.getActiveHustlers?.();
          } else {
            toast("error", 5000, res.message || lang.undefined_error);
          }
        },
        error: (err) => {
          console.error(err);
          toggleButtonContent(btn, "", true);
          enableElement(btn);
          toast("error", 5000, lang.undefined_error);
        },
      });
    });
  }

  renderCategoryHtmlFromCache(category) {
    const subCategories = category.subcategory || [];

    let listItems = subCategories
      .map((subCat, index) => {
        const slug = subCat.slug;
        const jobs = Object.entries(subCat.sampleFields || {})
          .map(
            ([key, job]) => `
                <li data-id="${key}" class="list-group-item job-list-group bg-transparent d-flex align-items-center ps-5 py-2">
                    <span class="subcat-symbol d-flex align-items-center justify-content-center me-2 ${!job.icon ? "d-none" : ""}">
                        <i class="${job.icon || ""} actual-icon m-0"></i>
                    </span>
                    <span class="text-dark job-title-inner-html">${job}</span>
                </li>`,
          )
          .join("");

        return `
            <li class="list-group-item p-0 border-0 mb-3">
                <button class="btn btn-link text-decoration-none w-100 text-start d-flex justify-content-between align-items-center p-3" data-bs-toggle="collapse" data-bs-target="#subcat-${slug}">
                    <div class="d-flex align-items-center justify-content-center">
                        <span class="subcat-symbol d-flex align-items-center justify-content-center me-2 ${!subCat.icon ? "d-none" : ""}">
                            <i class="${subCat.icon || ""} actual-icon m-0"></i>
                        </span>
                        <strong class="text-dark">${subCat.name}</strong>
                    </div>
                    <div class="col-2 d-flex justify-content-around align-items-center text-dark">
                        <span class="job-roles-count">${Object.keys(subCat.sampleFields || {}).length} Job Roles</span>
                        <i class="fas fa-chevron-down collapse-icon"></i>
                    </div>
                </button>
                <div class="collapse dropdown-content" id="subcat-${slug}">
                    <ul class="list-group list-group-flush">${jobs}</ul>
                </div>
            </li>`;
      })
      .join("");

    return `
        <div class="card bg-transparent border-0 mb-4">
            <div class="card-header bg-white d-flex align-items-center justify-content-between border-0">
                <div class="d-flex align-items-center justify-content-between w-100">
                    <button class="btn btn-md btn-link me-2 text-nowrap backBtn">
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                    <h5 class="mb-0 text-capitalize">${category.name}</h5>
                </div>
            </div>
            <div class="card-body p-0 m-0 g-0 mt-3">
                <ul class="list-group bg-transparent mb-2">${listItems}</ul>
            </div>
        </div>`;
  }
}

function getCategories() {
  const cached = localStorage.getItem("categories");
  if (cached) return JSON.parse(cached);

  fetch("/crm/services")
    .then((r) => r.json())
    .then((d) => localStorage.setItem("categories", JSON.stringify(d.services)))
    .catch(console.error);

  return [];
}

function loadJobCategories() {
  const jobsEl = document.getElementById("jobs");
  const searchInput = document.getElementById("job-search-val");
  const allCategories = getCategories();

  if (!allCategories.length) return;

  const render = (list) => {
    jobsEl.innerHTML = list
      .map(
        (c) => `
            <div class="job-category" data-id="${c.slug}">
                <div class="job-bg"><p>${c.name}</p></div>
                <p>${c.subcategory.length} job categories</p>
            </div>`,
      )
      .join("");
  };

  render(allCategories);

  const filterAndRender = () => {
    const q = searchInput.value.trim().toLowerCase();
    if (!q) return render(allCategories);

    const filtered = allCategories.filter((c) =>
      c.subcategory.some((sub) =>
        sub.sampleFields?.some((field) => field.toLowerCase().includes(q)),
      ),
    );
    render(filtered);
    dashboardInstance.bindCategories();
  };

  searchInput.addEventListener("input", filterAndRender);
  searchInput.addEventListener("keypress", (e) => {
    if (e.key === "Enter") {
      e.preventDefault();
      filterAndRender();
    }
  });
}

const dashboardInstance = new JobPortal();
loadJobCategories();
dashboardInstance.setupPage();
</script>
<!-- xtra scripts -->

<!-- closure -->
<?php include 'partials/layout/global/closure.php'; ?>
<!-- /closure -->
