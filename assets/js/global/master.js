/**
 * Master Class
 * ----------------------------------------------
 * Global JS class - master sits in here.
 * Use this class to group shared, reusable utility methods
 * for frontend site-wide behavior (e.g. restrictions, UI controls, etc).
 *
 * Here for YohPal forever!
 */

// Wait for Google Maps to load
window.googleMapsReady = function() {
  console.log('Google Maps ready for use');
  
  // Initialize services that depend on Google Maps
  if (typeof window.GeocodingService !== 'undefined') {
    window.geocodingService = new window.GeocodingService();
    console.log('GeocodingService initialized');
  }
  
  if (typeof window.PolylineRenderer !== 'undefined') {
    console.log('PolylineRenderer available');
  }
  
  // Dispatch custom event for other components
  window.dispatchEvent(new Event('googleMapsLoaded'));
};

class Master {
  constructor() {
    // Any constructor logic applicable
    this.debounceTimer;
    this.overlay = null;

    this.authRole =
      document.querySelector("meta[name='role']")?.content || "client";

    this.proceedNextBtn = document.querySelector(".proceed-next");
    this.goBackwardBtn = document.querySelector(".go-backward");

    this.stepperSections = Array.from(
      document.querySelectorAll(".stepper-section"),
    );
    this.stepDots = Array.from(document.querySelectorAll(".dot"));

    this.currentStepIndex = this.stepperSections.findIndex(
      (section) => !section.classList.contains("d-none"),
    );

    this.proceedNextBtn?.addEventListener("click", () => {
      this.navigateStepper("next");
    });
    this.goBackwardBtn?.addEventListener("click", () =>
      this.navigateStepper("back"),
    );

    this.updateStepperUI();

    this.verifyOtpBtn = document.querySelectorAll(".verify-otp-submit-btn");

    // Map & Mappings
    this.refreshMapBtn = document.querySelectorAll(".refresh-map-btn");
    
    // Initialize mobile menu
    this.initMobileMenu();
  }

  navigateStepper(direction = "next") {
    // if (this.authRole === "client") return;
    this.stepperSections.forEach((section) => section.classList.add("d-none"));

    if (
      direction === "next" &&
      this.currentStepIndex < this.stepperSections.length - 1
    ) {
      this.currentStepIndex++;
    } else if (direction === "back" && this.currentStepIndex > 0) {
      this.currentStepIndex--;
    }

    this.stepperSections[this.currentStepIndex].classList.remove("d-none");
    this.updateStepperUI();
    this.updateStepperSectionBg();
    enableElement(this.proceedNextBtn);
  }

  updateStepperUI() {
    // if (this.authRole === "client") return;
    this.stepDots.forEach((dot, index) => {
      dot.classList.toggle("active-dot", index === this.currentStepIndex);
    });

    if (this.goBackwardBtn) {
      this.goBackwardBtn.classList.toggle(
        "d-none",
        this.currentStepIndex === 0,
      );
    }

    if (this.proceedNextBtn) {
      this.proceedNextBtn.classList.toggle(
        "d-none",
        this.currentStepIndex === this.stepperSections.length - 1,
      );
    }
  }

  updateStepperSectionBg() {
    const bgObject = {
      "two-fa-section": "two-fa-section.jpeg",
      "ratings-section": "ratings.jpg",
      "uploads-section": "uploads-section.jpeg",
      "success-section": "onboarding-success.jpeg",
    };

    const currentStep = this.stepperSections.find(
      (section) => !section.classList.contains("d-none"),
    );
    if (!currentStep) return;

    const matchingKey = Object.keys(bgObject).find((key) =>
      currentStep.classList.contains(key),
    );
    if (!matchingKey) return;

    const stepperBgCard = document.querySelector(".stepper-section-bg");
    if (!documentContains(stepperBgCard)) return;

    const imageUrl = `/assets/store/images/bg/${bgObject[matchingKey]}`;
    stepperBgCard.style.backgroundImage = `url('${imageUrl}')`;
  }

  /**
   * Creates and appends a reusable overlay element to the given container.
   * If no container is provided, it defaults to document.body.
   *
   * @param {HTMLElement} [container=document.body] - The DOM element to contain the overlay.
   */
  initOverlay(container = document.body) {
    this.overlay = document.createElement("div");
    this.overlay.classList.add("global-overlay");

    __append_html(
      `<div class="loading-message text-center">
                <div class="spinner-border text-danger mb-2" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div>Loading...</div>
            </div>`,
      this.overlay,
    );

    container.appendChild(this.overlay);
    this.hideOverlay();
  }

  /**
   * Displays the global overlay by adding the 'active' class.
   * Useful for blocking UI and showing a loading state.
   */
  showOverlay() {
    this.overlay = document.querySelector(".global-overlay");
    if (this.overlay) {
      this.overlay.classList.add("active");
    }
  }

  /**
   * Hides the global overlay by removing the 'active' class.
   */
  hideOverlay() {
    this.overlay = document.querySelector(".global-overlay");
    if (this.overlay) {
      this.overlay.classList.remove("active");
    }
  }

  /**
   * Parses and handles modal actions triggered from DataTables UI elements.
   *
   * Typically used when clicking a button/link inside a DataTable row to open a modal
   * (e.g. edit, view, or delete). Supports invoking an action (e.g. AJAX call), then
   * optionally runs one or more callbacks after the action is completed.
   *
   * @param {Event} event - The event triggered from a DataTable element (e.g. button click).
   * @param {string} action - The URL or route to fetch or post data to (usually tied to the modal's content).
   * @param {string} [method='GET'] - HTTP method to use when performing the action (e.g., 'GET', 'POST').
   * @param {Function[]|undefined} [callbackFuncs=undefined] - Optional array of callback functions to run after action completes.
   * @param {string} [attribute='.target-modal'] - Selector for the modal element to show (default: '.target-modal').
   */
  assistiveModalActionParser(
    event,
    action,
    method = "GET",
    callbackFuncs = undefined,
    attribute = "target-modal",
  ) {
    $.ajax({
      type: `${method}`,
      url: `${action}`,
      dataType: "json",
      headers: {
        "X-Requested-With": "XMLHttpRequest",
      },
      success: function (response) {
        event.target.disabled = false;
        toggleLoadingOverlay(false);

        if (!response) {
          toast("error", 5000, lang.undefined_error);
          return;
        }

        if (response.status && response.status == "error") {
          toast(response.status, 5000, response.message);
          return;
        }

        let target_modal = event.target.getAttribute(attribute); // .store-view-modal, store-edit-modal, etc...

        if (!target_modal?.length) {
          toast("error", 5000, lang.undefined_error);
          return;
        }

        let modal = document.querySelector(`${target_modal}`);

        if (!response.modal) {
          toast("error", 5000, lang.undefined_error);
          return;
        }

        __append_html(response.modal, modal);
        __show_modal(target_modal);

        setTimeout(() => {
          if (callbackFuncs !== undefined) {
            if (Array.isArray(callbackFuncs)) {
              callbackFuncs.forEach((item) => {
                if (typeof item === "function" && item.callback) {
                  item(...(item.params?.length ? item.params : []));
                } else if (typeof item === "object" && item.callback) {
                  item.callback(...(item.params?.length ? item.params : []));
                }
              });
            }
          }
        }, 1000); // Avoid Race conditions
      },
      error: (error) => {
        console.log(error);
        event.target.disabled = false;
        toast("error", 5000, error.message || lang.undefined_error);
      },
    });
  }

  getActiveJobsAssigned() {
    $(".table-active-jobs-assigned").DataTable({
      destroy: true,
      paging: true,
      searching: true,
      ordering: true,
      info: true,
      lengthChange: true,
    });
  }

  /**
   * Select every tab element and apply navigation logic
   * Activation is binded by use of 'active' class.
   *
   * @param {String} [selector] HTML selector
   * @param {Object} [callbackFuncs] Callback functions object
   */
  bindTabClicks(selector, callbackFuncs = {}) {
    let subCategoryTabs = document.querySelectorAll(`${selector}`);
    subCategoryTabs.forEach((tab) => {
      if (!documentContains(tab)) return;
      tab = cloneNodeElement(tab);
      tab.addEventListener("click", () => {
        subCategoryTabs = document.querySelectorAll(`${selector}`);
        subCategoryTabs.forEach((sct) => sct.classList.remove("active"));
        tab.classList.add("active");

        // Fire up the callback functions here...
      });
    });
  }

  /**
   * Accepts selector string to clone and duplicate...
   *
   * @param {string} selector
   */
  addNewUploadSection(selector) {
    if (!selector || typeof selector !== 'string') {
      console.warn("Invalid selector passed to addNewUploadSection");
      return;
    }

    const btn = document.querySelector(selector);

    if (!btn || !documentContains(btn)) {
      return;
    }

    btn.addEventListener("click", (event) => {
      event.preventDefault();

      const dropZoneWrapper = btn
        .closest(".mb-3")
        ?.querySelector(".drop-zone-wrapper");
      if (!documentContains(dropZoneWrapper)) return;

      const lastContainer = dropZoneWrapper.querySelectorAll(
        ".drop-zone-container",
      );
      if (!lastContainer.length) return;

      const elementClone =
        lastContainer[lastContainer.length - 1].cloneNode(true);

      dropZoneWrapper.appendChild(elementClone);
      setupUploadSection();
    });
  }

  /**
   * Verify OTP received to the given contact: email or phone
   *
   * @returns {void} void
   */
  verifyOtp() {
    let btns = this.verifyOtpBtn;

    btns.forEach((btn) => {
      if (!documentContains(btn)) return;
      btn = cloneNodeElement(btn); // counter race conditions
      btn.addEventListener("click", (event) => {
        event.preventDefault();
        toggleButtonContent(btn);
        disableElement(btn);

        let form = btn.closest("form");
        let data = serializeFormToArray(form);

        $.ajax({
          type: form.getAttribute("method"),
          url: form.action,
          data: data,
          dataType: "json",
          success: function (response) {
            toggleButtonContent(btn, "", true);
            new Master().verifyOtp();
            enableElement(btn);

            if (response && response.status && response.status == "success") {
              disableElement(btn);
              resetFormAndCloseModal(form);

              if (response.route) {
                if (response.route) route(response.route);
              }

              if (!response.route) {
                new Master().navigateStepper("next");
                new Master().activateAccount();
              }

              toast(
                response.status,
                5000,
                response.message || lang.undefined_error,
              );
              return;
            }

            if (response && response.status && response.status == "error") {
              enableElement(btn);
              toast(
                response.status,
                5000,
                response.message || lang.undefined_error,
              );
              return;
            }

            toast("error", 5000, lang.undefined_error);
          },
          error: (error) => {
            console.log(error.message || error);
            toggleButtonContent(btn, "", true);
            enableElement(btn);
            toast("error", 5000, lang.undefined_error);
          },
        });
      });
    });
  }

  refreshMap() {
    const btns = this.refreshMapBtn;
    btns.forEach((btn) => {
      if (!documentContains(btn)) return;
      btn = cloneNodeElement(btn);
      btn.addEventListener("click", (event) => {
        event.preventDefault();
        this.getActiveHustlers();
      });
    });
  }

  /**
   * Get all active hustlers for map layout.
   * Map each hustler and create markers accordingly using the mapAndCreateHustlerMarkers() function.
   */
  getActiveHustlers() {
    $.ajax({
      type: "GET",
      url: "/crm/users/hustlers",
      dataType: "json",
      contentType: false,
      processData: false,
      headers: {
        "X-Requested-With": "XMLHttpRequest",
      },
      success: function (response) {
        if (response && response.hustlers) {
          new Master().mapAndCreateHustlerMarkers(response.hustlers);
        }
      },
      error: (jqXHR, textStatus, errorThrown) => {
        console.error("AJAX Error:", {
          status: jqXHR.status,
          statusText: jqXHR.statusText,
          responseText: jqXHR.responseText,
          errorThrown: errorThrown,
          textStatus: textStatus,
        });
      },
    });
  }

  /**
   * Add markers on the map...
   */
  mapAndCreateHustlerMarkers(hustlerData) {
    this.setMapOnPage(hustlerData);
  }

  /**
   * Gets the current location positions to use on the further end of laying the map
   * and the realtime parsing of clients & hustlers accordingly...
   * The function accepts - Geolocation navigator API possible params
   *
   * @param {params} params
   * @returns
   */
  getGeolocationPositions(params = undefined) {
    return new Promise((resolve, reject) => {
      if (!navigator.geolocation) {
        console.warn("Browser does not support geolocation");
        resolve({ lat: -1.286389, lng: 36.817223, accuracy: 1000 });
        return;
      }

      const options = {
        enableHighAccuracy: false,
        timeout: 10000,
        maximumAge: 60000
      };

      navigator.geolocation.getCurrentPosition(
        (position) => {
          console.log(`Location acquired: ${position.coords.latitude}, ${position.coords.longitude}`);
          resolve({
            lat: position.coords.latitude,
            lng: position.coords.longitude,
            accuracy: position.coords.accuracy
          });
        },
        (error) => {
          console.warn('Using fallback location due to:', error.code, error.message);
          resolve({ lat: -1.286389, lng: 36.817223, accuracy: 1000 });
        },
        options
      );
    });
  }

  /**
   * Initializes the map on the profile page where applicable
   *
   * @param {HTMLSelectElement} domSection HTML DOM element where the map should get appended
   * @param {Object} hustlerData Hustler/User data inclusive of Locations
   * @returns {void} void
   */
  async setMapOnPage(hustlerData = [], domSection = ".geomap") {
    try {
      // Check if Google Maps is loaded
      if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
        console.warn('Google Maps API not loaded yet');
        return;
      }

      let locations = undefined;
      let mapHtmlSelectors = document.querySelectorAll(domSection);

      mapHtmlSelectors.forEach((selector) => {
        if (!documentContains(selector)) return;

        this.getGeolocationPositions().then((positions) => {
          let map = new google.maps.Map(selector, {
            zoom: 12,
            center: {
              lat: positions.lat,
              lng: positions.lng,
            },
            mapId: "hustle-map",
          });
          let mapInstance = null;

          if (!hustlerData[0]) return;
          const jobInfo = hustlerData[0];

          if (hustlerData.length === 1 && jobInfo?.client) {
            let mapInstance = new ClientMap(map, "WALKING", "JobSite");
            mapInstance.clientStartLocation = new google.maps.LatLng(
              jobInfo.jobSite._latitude ?? positions.lat,
              jobInfo.jobSite._longitude ?? positions.lng,
            );

            const acceptedHustler = Object.entries(jobInfo.hustlers).find(
              ([_, hustler]) => hustler.accepted && hustler.requested,
            )?.[0];

            this.getHustlerLocation(acceptedHustler).then((loc) => {
              let marker = "Hustler";
              const _locations = {
                latitude: loc._latitude,
                longitude: loc._longitude,
              };
              mapInstance.layOutMapMarker(_locations, marker, jobInfo);
              return;
            });
          } else if (hustlerData.length === 1 && jobInfo?.jobSite) {
            let mapInstance = new ClientMap(map);
            mapInstance.clientStartLocation = new google.maps.LatLng(
              positions.lat,
              positions.lng,
            );

            let marker = "";
            const _locations = {
              latitude: jobInfo.jobSite._latitude,
              longitude: jobInfo.jobSite._longitude,
            };
            mapInstance.layOutMapMarker(_locations, marker, jobInfo);
          } else {
            mapInstance = new HustleMap(map, "WALKING", "You");

            mapInstance.clientStartLocation = new google.maps.LatLng(
              positions.lat,
              positions.lng,
            );

            hustlerData.forEach((hustler) => {
              locations = hustler.liveLocation;
              let marker = hustler.displayName || "You";
              const _locations = {
                latitude: locations._latitude,
                longitude: locations._longitude,
              };
              mapInstance.layOutMapMarker(
                _locations || undefined,
                marker,
                hustler,
              );
            });
          }
        });
      });

      this.refreshMap();
    } catch (error) {
      console.error("Geolocation JS API error: ", error.message);
    }
  }

  /** @param{string} hustlerId */
  async getHustlerLocation(hustlerId) {
    try {
      const res = await fetch(`/crm/hustler/get_location/${hustlerId}`);
      const location = await res.json();
      return location;
    } catch (e) {
      console.error(e);
    }
  }

  /**
   * Initialize mobile menu toggle functionality
   */
  initMobileMenu() {
    const hamburger = document.querySelector('.hamburger');
    const interactions = document.querySelector('.interactions');
    const body = document.body;

    if (hamburger && interactions) {
      hamburger.addEventListener('click', (e) => {
        e.stopPropagation();
        interactions.classList.toggle('mobile-open');
        hamburger.classList.toggle('active');
        body.classList.toggle('menu-open');
      });

      // Close menu when clicking outside
      document.addEventListener('click', (e) => {
        if (!hamburger.contains(e.target) && !interactions.contains(e.target)) {
          interactions.classList.remove('mobile-open');
          hamburger.classList.remove('active');
          body.classList.remove('menu-open');
        }
      });

      // Close menu when clicking a link
      const menuLinks = interactions.querySelectorAll('a');
      menuLinks.forEach(link => {
        link.addEventListener('click', () => {
          interactions.classList.remove('mobile-open');
          hamburger.classList.remove('active');
          body.classList.remove('menu-open');
        });
      });
    }

    // Toggle sidebar on mobile (CRM)
    const menuToggle = document.querySelector('.menu-toggle');
    const sidebar = document.querySelector('.sidebar');

    if (menuToggle && sidebar) {
      menuToggle.addEventListener('click', (e) => {
        e.stopPropagation();
        sidebar.classList.toggle('active');
        body.classList.toggle('sidebar-open');
      });

      // Close sidebar when clicking outside or on overlay
      document.addEventListener('click', (e) => {
        if (window.innerWidth <= 768 && 
            sidebar.classList.contains('active') &&
            !menuToggle.contains(e.target) && 
            !sidebar.contains(e.target)) {
          sidebar.classList.remove('active');
          body.classList.remove('sidebar-open');
        }
      });

      // Close sidebar when clicking on a link
      const sidebarLinks = sidebar.querySelectorAll('a, .sidebar-item');
      sidebarLinks.forEach(link => {
        link.addEventListener('click', () => {
          if (window.innerWidth <= 768) {
            sidebar.classList.remove('active');
            body.classList.remove('sidebar-open');
          }
        });
      });
    }
  }
}
