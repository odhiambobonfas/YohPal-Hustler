class HustleMap extends Master {
  constructor(
    mapInstance,
    travelMode = "Walking",
    clientLabel = "Client",
    targetLabel = "Hustler",
    icons = {
      targetDestinationIcon:
        "http://maps.google.com/mapfiles/ms/icons/green-dot.png",
      startLocationIcon: "http://maps.google.com/mapfiles/ms/icons/blue.png",
    },
    stepsCount = 50,
  ) {
    super();
    this.mapInstance = mapInstance;
    this.travelMode = travelMode; // or WALKING, BICYCLING, TRANSIT
    this.targetLabel = targetLabel;
    this.clientLabel = clientLabel;
    this.targetDestinationIcon = icons.targetDestinationIcon;
    this.startLocationIcon = icons.startLocationIcon;
    this.stepsCount = stepsCount;
    this.totalDistance = 0;
    this.totalMinutes = 0;
    this.marker = null;
    this.targetMarker = null;
    this.clientMarker = null;
    this.clientPointOfWorkLocation = {};
    this.path = [];
    this.currentIndex = 0;
    this.directionsService = undefined;
    this.directionsRenderer = undefined;
    this.intGoogleMapApiDirectionService();
    this.currentInfoWindow = null;
    this.allHustlerMarkers = null;
  }

  /**
   * This function uses the Google MAP API to set up and lay out the Client
   * Directions and Mark and map the routes to be taken.
   *
   * @param {Object} locales
   * @param {String} targetMarker
   */
  layOutMapMarker(
    locales = undefined,
    targetMarker = "Hustler",
    hustlerData = undefined,
  ) {
    this.targetMarker =
      targetMarker == undefined ? this.targetMarker : targetMarker;
    let clientPointOfWorkLocation = locales || {};

    if (!clientPointOfWorkLocation) return;

    this.clientPointOfWorkLocation = new google.maps.LatLng(
      clientPointOfWorkLocation.latitude,
      clientPointOfWorkLocation.longitude,
    );

    this.targetMarker = new google.maps.Marker({
      position: this.clientPointOfWorkLocation,
      map: this.mapInstance,
      // label: this.targetMarker,
    });

    // save it for cleanup
    this.addHustlerMarker(this.targetMarker);

    if (this.clientStartLocation) {
      this.clientMarker = new google.maps.Marker({
        position: this.clientStartLocation,
        map: this.mapInstance,
        label: this.clientLabel,
        icon: this.startLocationIcon,
        title: "You",
      });
    }

    const skillRatingsHtml = Object.entries(hustlerData?.skillRatings || {})
      .map(([key, val]) => {
        return `
      <div style="min-width: 80px;">
        <div class="text-muted small mb-1">${key.charAt(0).toUpperCase() + key.slice(1)}</div>
        <div>${"⭐".repeat(val)}</div>
      </div>
    `;
      })
      .join("");

    const targetInfoWindow = new google.maps.InfoWindow({
      content: `
    <div class="card shadow-sm border-0" style="width: 300px;">
      <!-- Header -->
      <div
        class="card-header text-center border-bottom position-relative text-white"
        style="background-image: url('${hustlerData?.uploads?.images[1]}');
              background-size: cover; background-position: center;
              height: 120px;min-height: 120px;">
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background-color: rgba(0,0,0,0.5); z-index: 1;"></div>

        <div class="position-relative" style="z-index: 2;">
          <img src="${hustlerData?.uploads?.images[0]}" class="img-fluid rounded-circle mb-2 border border-white"
               style="width: 60px; height: 60px; object-fit: cover;" />
          <h3 class="h6 mb-0 fw-bold">${hustlerData?.displayName || targetMarker}</h3>
          <p class="small mb-0">${hustlerData?.primarySkill || "N/A"}</p>
        </div>
      </div>

      <!-- Content -->
      <div class="card-body">
        <div class="mb-2 text-muted"><b>Rate</b></div>
        <div class="text-dark mb-3">
          ${hustlerData?.pricing || "N/A"}
          <span class="small">(${hustlerData?.pricingType})</span>
        </div>

        <!-- Ratings -->
        <div class="mb-3">
          <div class="fw-semibold text-dark small mb-2">Ratings</div>
          <div class="d-flex flex-wrap gap-2 small">
            ${skillRatingsHtml}
          </div>
        </div>

        <!-- Button -->
        <button id="select-hustler-${hustlerData?.id}" class="btn btn-primary w-100 btn-sm fw-medium">
          Request Hustler
        </button>
      </div>
    </div>
  `,
    });

    targetInfoWindow.addListener("domready", () => {
      const selectBtn = document.getElementById(
        `select-hustler-${hustlerData?.id}`,
      );
      if (selectBtn) {
        selectBtn.addEventListener("click", () => {
          this.clientDestinationLocation = this.clientPointOfWorkLocation;
          this.getRoadRoute();
          this.selectHustler(hustlerData.id);
          this.clearHustlerMarkers();
          targetInfoWindow.close();
        });
      }
    });

    this.targetMarker.addListener("click", () => {
      if (this.currentInfoWindow) {
        this.currentInfoWindow.close();
      }
      this.currentInfoWindow = targetInfoWindow;
      targetInfoWindow.open(this.mapInstance, this.targetMarker);
      this.clientDestinationLocation = this.clientPointOfWorkLocation; // hustler's location
    });
  }

  /**
   * Calculates latitude and longitude step after a step, & returns an array
   * of points respectively.
   *
   * @param {Object} startLocation
   * @param {Object} endLocation
   * @param {int} stepsCount
   * @returns {Array} points - mapped points per step
   */
  calculateIntermediatePoints(startLocation, endLocation, stepsCount) {
    const latitudeStep =
      (endLocation.lat() - startLocation.lat()) / (stepsCount - 1);
    const longitudeStep =
      (endLocation.lng() - startLocation.lng()) / (stepsCount - 1);

    const points = [];
    for (let i = 0; i <= stepsCount; i++) {
      points.push({
        lat: startLocation.lat() + latitudeStep * i,
        lng: startLocation.lng() + longitudeStep * i,
      });
    }

    return points;
  }

  /**
   * Animates, sets position for a client marker, and uses google map computeDistanceBetween function
   * to compute the distance taken per step taken.
   *
   * @returns {void} void
   */
  animateMovement() {
    if (this.currentIndex >= this.path.length) return;

    const nextPos = this.path[this.currentIndex];

    if (nextPos.lat && nextPos.lng) {
      this.clientMarker.setPosition(
        new google.maps.LatLng(nextPos.lat, nextPos.lng),
      );

      const distance = google.maps.geometry.spherical.computeDistanceBetween(
        this.clientMarker.getPosition(),
        this.targetMarker.getPosition(),
      );

      this.currentIndex++;
      setTimeout(() => this.animateMovement(), 300);
    }
  }

  /**
   * Initializes the Direction service as well as direction renderer API.
   * The instances are supposed to be used globally but internally(this class)
   *
   * @returns {void} void
   */
  intGoogleMapApiDirectionService() {
    this.directionsService = new google.maps.DirectionsService();
    this.directionsRenderer = new google.maps.DirectionsRenderer({
      map: this.mapInstance,
      suppressMarkers: true,
      polylineOptions: {
        strokeColor: "#4285F4",
        strokeOpacity: 0.8,
        strokeWeight: 6,
      },
    });
  }

  /**
   * Gets the route of both the Client and the Target(Me), & Computes the time and distance between
   * the starting point and the destination.
   *
   * @returns {void} void
   */
  getRoadRoute() {
    this.directionsService.route(
      {
        origin: this.clientStartLocation,
        destination: this.clientDestinationLocation,
        travelMode: google.maps.TravelMode[this.travelMode.toUpperCase()],
      },
      (response, status) => {
        if (status === "OK") {
          this.directionsRenderer.setDirections(response);
          this.calculateTimeToBeTaken(response);
          this.calculateDistanceTimeToBeTaken(response);
          __append_html(
            `${this.totalDistance.toFixed(2)} M`,
            document.querySelector(".client-distance-remaining"),
          );
          __append_html(
            `${this.totalMinutes.toFixed(2)} Minutes`,
            document.querySelector(".client-time-to-take"),
          );
        } else {
          console.error("Directions request failed due to " + status);
        }
      },
    );
  }

  /***
   * Utilizes the get route function response to calculate the time to be taken
   * on the respective two points, starting point and the destination point.
   *
   * @returns {void} void
   */
  calculateTimeToBeTaken(response) {
    const duration = response.routes[0].legs[0].duration;
    this.totalMinutes = duration.value / 60;
  }

  /***
   * Utilizes the get route function response to calculate the distance between the starting point
   * and the destination point.
   *
   * @returns {void} void
   */
  calculateDistanceTimeToBeTaken(response) {
    const totalDistance = response.routes[0].legs[0].distance;
    this.totalDistance = parseFloat(totalDistance.text);
  }

  /**
   * Stores a hustler marker in the array for later cleanup
   */
  addHustlerMarker(marker) {
    this.allHustlerMarkers = this.allHustlerMarkers || [];
    this.allHustlerMarkers.push(marker);
  }

  clearHustlerMarkers() {
    if (!this.allHustlerMarkers) return;
    this.allHustlerMarkers.forEach((hm) => {
      if (hm !== this.targetMarker) {
        hm.setMap(null);
      }
    });
  }

  /**
   * Adds functionality on the selected hustler
   * @param {string} hustlerId
   */
  selectHustler(hustlerId) {
    this.clientDestinationLocation = this.clientPointOfWorkLocation;
    this.getRoadRoute();
    this.updateJob([hustlerId]);
  }

  updateJob(hustlerIds) {
    $.ajax({
      type: "POST",
      url: "/job/completeCreation",
      data: {
        "locationDetails[longitude]": this.clientStartLocation.lng(),
        "locationDetails[latitude]": this.clientStartLocation.lat(),
        hustlerIds: hustlerIds,
      },
      success: function (res) {
        toast(res.status, "Job Created Successfully", 2000);
        return;
      },
      error: function (xhr, status, err) {
        toast("error", "Failed to create job", 2000);
      },
    });
  }
}
