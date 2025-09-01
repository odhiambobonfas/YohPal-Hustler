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
    const subCategories = category.subcategories || [];

    let listItems = subCategories
      .map((subCat, index) => {
        const slug = subCat.toLowerCase().replace(/\s+/g, "-");
        return `
          <li data-id="${index}" class="list-group-item job-list-group bg-transparent d-flex align-items-center ps-5 py-2">
            <span class="text-dark job-title-inner-html">${subCat}</span>
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

async function getCategories() {
  const updated = localStorage.getItem("updated") ?? null;
  if (updated) {
    const cached = localStorage.getItem("categories");
    if (cached) return JSON.parse(cached);
  }

  try {
    const response = await fetch("/crm/services");
    const d = await response.json();
    localStorage.setItem("categories", JSON.stringify(d.services));
    return d.services;
  } catch (e) {
    console.error(`Fetch Services Err: ${e}`);
    return [];
  }
}

async function loadJobCategories() {
  const jobsEl = document.getElementById("jobs");
  const searchInput = document.getElementById("job-search-val");
  const allCategories = await getCategories();

  if (!allCategories.length) return;

  const pastelColors = [
    "#FFD6D6",
    "#FFEBCC",
    "#D5E8D4",
    "#CCE5FF",
    "#FFF2CC",
    "#FADBD8",
    "#E8DAEF",
    "#D6F5D6",
    "#D6EAF8",
    "#FDEBD0",
    "#D1F2EB",
    "#F5CBA7",
    "#F6DDCC",
    "#E8F8F5",
  ];

  const render = (list) => {
    jobsEl.innerHTML = list
      .map((c, i) => {
        const color =
          pastelColors[Math.floor(Math.random() * pastelColors.length)];

        return `
            <div class="job-category" data-id="${c.slug}">
                <div class="job-bg" style="background-color: ${color}"><p>${c.name}</p></div>
                <p>${c.subcategories.length} job categories</p>
            </div>`;
      })
      .join("");
  };

  render(allCategories);

  const filterAndRender = () => {
    const q = searchInput.value.trim().toLowerCase();
    if (!q) return render(allCategories);

    const filtered = allCategories.filter((c) =>
      c.subcategories.some((sub) => sub.toLowerCase().includes(q)),
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
(async () => {
  await loadJobCategories();
  dashboardInstance.setupPage();
})();
