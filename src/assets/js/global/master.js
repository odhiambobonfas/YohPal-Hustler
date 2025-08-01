/**
 * Master Class
 * ----------------------------------------------
 * Global JS class - master sits in here.
 * Use this class to group shared, reusable utility methods
 * for frontend site-wide behavior (e.g. restrictions, UI controls, etc).
 *
 * Here for YohPal forever!
 */
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

    this.proceedNextBtn?.addEventListener("click", () =>
      this.navigateStepper("next"),
    );
    this.goBackwardBtn?.addEventListener("click", () =>
      this.navigateStepper("back"),
    );

    this.updateStepperUI();

    this.verifyOtpBtn = document.querySelectorAll(".verify-otp-submit-btn");

    // Map & Mappings
    this.refreshMapBtn = document.querySelectorAll(".refresh-map-btn");
  }

  navigateStepper(direction = "next") {
    if (this.authRole === "client") return;
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
    if (this.authRole === "client") return;
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

    const imageUrl = `assets/store/images/bg/${bgObject[matchingKey]}`;
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
   * Accepts selector element to clone and duplicate...
   *
   * @param {HTMLElement} selector
   */
  addNewUploadSection(selector) {
    const btn = document.querySelector(selector);

    if (!documentContains(btn)) {
      console.warn("Invalid selector element passed to addNewUploadSection");
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
      url: "/users/hustlers",
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
        alert("Your browser does not support geolocation.");
        reject("unsupported");
        return;
      }

      navigator.geolocation.getCurrentPosition(
        (position) => {
          resolve({
            lat: position.coords.latitude,
            lng: position.coords.longitude,
          });
        },
        (error) => {
          if (error.code === error.PERMISSION_DENIED) {
            alert(
              "Location access is required to continue.\n\n" +
                "Please enable location permissions in your browser settings and reload the page.",
            );
            reject("denied");
          } else {
            alert("Error getting location: " + error.message);
            reject("error");
          }
        },
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
      let locations = undefined;
      let mapHtmlSelectors = document.querySelectorAll(domSection);

      mapHtmlSelectors.forEach((selector) => {
        if (!documentContains(selector)) return;

        this.getGeolocationPositions().then((positions) => {
          // console.log(locations.latitude);
          let map = new google.maps.Map(selector, {
            zoom: 12,
            center: {
              lat: positions.lat,
              lng: positions.lng,
            },
            mapId: "hustle-map",
          });

          let mapInstance = new HustleMap(map, "WALKING", "You");

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
        });
      });

      this.refreshMap();
    } catch (error) {
      console.error("Geolocation JS API error: ", error.message);
    }
  }
}
