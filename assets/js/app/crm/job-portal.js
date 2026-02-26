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
    this.hustlerLoader = null;
    this.currentMap = null;
    this.userLocation = null;
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
            dashboardInstance.getActiveHustlers();
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

  async getActiveHustlers() {
    try {
      // Wait for Google Maps
      if (typeof google === 'undefined' || !google.maps) {
        toast("info", 3000, "Waiting for Google Maps...");
        await this.waitForGoogleMaps();
      }

      if (!this.hustlerLoader) {
        // Try API version first (no Firebase needed)
        if (typeof HustlerLoaderServiceAPI !== 'undefined') {
          this.hustlerLoader = new HustlerLoaderServiceAPI();
        } else {
          // Load API version
          await this.loadScript('/assets/js/app/web/services/hustler-loader-api.js');
          this.hustlerLoader = new HustlerLoaderServiceAPI();
        }
      }

      if (!this.userLocation) {
        toast("info", 2000, "Getting your location...");
        this.userLocation = await this.getUserLocation();
      }

      if (!this.currentMap) {
        toast("info", 2000, "Initializing map...");
        this.currentMap = await this.initializeMap();
      }

      this.hustlerLoader.setMap(this.currentMap);
      this.hustlerLoader.setUserLocation(this.userLocation.lat, this.userLocation.lng);

      toast("info", 2000, "Loading available hustlers...");
      await this.hustlerLoader.loadAllHustlers();
      this.hustlerLoader.displayHustlersOnMap();

      toast("success", 3000, `Found ${this.hustlerLoader.hustlers.length} available hustlers`);
    } catch (error) {
      console.error("Error loading hustlers:", error);
      toast("error", 5000, error.message || "Failed to load available hustlers");
    }
  }

  waitForGoogleMaps() {
    return new Promise((resolve, reject) => {
      let attempts = 0;
      const maxAttempts = 20;
      
      const checkGoogle = setInterval(() => {
        attempts++;
        if (typeof google !== 'undefined' && google.maps) {
          clearInterval(checkGoogle);
          resolve();
        } else if (attempts >= maxAttempts) {
          clearInterval(checkGoogle);
          reject(new Error("Google Maps failed to load"));
        }
      }, 500);
    });
  }

  loadScript(src) {
    return new Promise((resolve, reject) => {
      const script = document.createElement('script');
      script.src = src;
      script.onload = resolve;
      script.onerror = reject;
      document.head.appendChild(script);
    });
  }

  async getUserLocation() {
    return new Promise((resolve, reject) => {
      if (!navigator.geolocation) {
        reject(new Error("Geolocation not supported"));
        return;
      }

      navigator.geolocation.getCurrentPosition(
        (position) => {
          resolve({
            lat: position.coords.latitude,
            lng: position.coords.longitude
          });
        },
        (error) => reject(error),
        { enableHighAccuracy: true, timeout: 10000, maximumAge: 60000 }
      );
    });
  }

  async initializeMap() {
    const mapElement = document.getElementById("services-map");
    if (!mapElement) throw new Error("Map element not found");

    // Hide loading indicator
    const loadingIndicator = document.getElementById("map-loading");
    if (loadingIndicator) loadingIndicator.style.display = "none";

    const map = new google.maps.Map(mapElement, {
      zoom: 14,
      center: { lat: this.userLocation.lat, lng: this.userLocation.lng },
      mapId: "hustle-map",
      disableDefaultUI: false,
      zoomControl: true,
      mapTypeControl: false,
      streetViewControl: false,
      fullscreenControl: true
    });

    // Add user marker
    new google.maps.Marker({
      position: { lat: this.userLocation.lat, lng: this.userLocation.lng },
      map: map,
      title: "Your Location",
      icon: {
        path: google.maps.SymbolPath.CIRCLE,
        scale: 10,
        fillColor: "#4285F4",
        fillOpacity: 1,
        strokeColor: "#FFFFFF",
        strokeWeight: 3
      },
      zIndex: 10000
    });

    return map;
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
    localStorage.setItem("updated", true);
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

// Global function to select hustler
window.selectHustler = function(hustlerId) {
  const hustler = dashboardInstance.hustlerLoader?.getHustlerById(hustlerId);
  if (!hustler) {
    toast("error", 3000, "Hustler not found");
    return;
  }

  console.log("Selected hustler:", hustler);
  toast("success", 3000, `Requesting ${hustler.displayName || hustler.name}...`);
  
  // Hide overlay
  const overlay = document.getElementById("hustler-overlay");
  if (overlay) overlay.classList.add("d-none");
  
  // TODO: Implement job request logic
  // This should create a job request with the selected hustler
};

(async () => {
  await loadJobCategories();
  dashboardInstance.setupPage();
  
  // Refresh map button
  const refreshBtn = document.getElementById("refreshMapBtn");
  if (refreshBtn) {
    refreshBtn.addEventListener("click", async () => {
      refreshBtn.disabled = true;
      refreshBtn.querySelector("i").classList.add("fa-spin");
      
      try {
        await dashboardInstance.getActiveHustlers();
      } catch (error) {
        console.error("Refresh error:", error);
      } finally {
        refreshBtn.disabled = false;
        refreshBtn.querySelector("i").classList.remove("fa-spin");
      }
    });
  }
})();
