class HustleMap extends Master {
  constructor(
    mapInstance,
    travelMode = "WALKING",
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
    this.travelMode = travelMode;
    this.targetLabel = targetLabel;
    this.clientLabel = clientLabel;

    this.targetDestinationIcon = icons.targetDestinationIcon;
    this.startLocationIcon = icons.startLocationIcon;

    this.stepsCount = stepsCount;
    this.totalDistance = 0;
    this.totalMinutes = 0;

    this.targetMarker = null;
    this.clientMarker = null;

    this.clientStartLocation = null;
    this.clientDestinationLocation = null;

    this.path = [];
    this.currentIndex = 0;

    this.currentInfoWindow = null;
    this.allHustlerMarkers = [];

    this.initGoogleMapApiDirectionService();
  }

  /* ---------------- INIT DIRECTION SERVICE ---------------- */

  initGoogleMapApiDirectionService() {
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

  /* ---------------- CLIENT START LOCATION ---------------- */

  setClientStartLocation(lat, lng) {
    this.clientStartLocation = new google.maps.LatLng(lat, lng);

    this.clientMarker = new google.maps.Marker({
      position: this.clientStartLocation,
      map: this.mapInstance,
      label: this.clientLabel,
      icon: this.startLocationIcon,
      title: "Client",
    });
  }

  /* ---------------- HUSTLER MARKER ---------------- */

  layOutMapMarker(locales, targetMarker = "Hustler", hustlerData) {
    if (!locales || !hustlerData) return;

    this.clientDestinationLocation = new google.maps.LatLng(
      locales.latitude,
      locales.longitude,
    );

    this.targetMarker = new google.maps.Marker({
      position: this.clientDestinationLocation,
      map: this.mapInstance,
      icon: this.targetDestinationIcon,
    });

    this.addHustlerMarker(this.targetMarker);

    const skillRatingsHtml = Object.entries(hustlerData?.skillRatings || {})
      .map(
        ([key, val]) => `
        <div style="min-width:80px;">
          <div class="text-muted small">${key}</div>
          <div>${"⭐".repeat(val)}</div>
        </div>
      `,
      )
      .join("");

    const targetInfoWindow = new google.maps.InfoWindow({
      content: this.buildHustlerCard(hustlerData, skillRatingsHtml),
    });

    targetInfoWindow.addListener("domready", () => {
      const btn = document.getElementById(`select-hustler-${hustlerData.id}`);
      if (btn) {
        btn.onclick = () => {
          this.selectHustler(hustlerData.id);
          this.clearHustlerMarkers();
          targetInfoWindow.close();
        };
      }
    });

    this.targetMarker.addListener("click", () => {
      if (this.currentInfoWindow) this.currentInfoWindow.close();
      this.currentInfoWindow = targetInfoWindow;
      targetInfoWindow.open(this.mapInstance, this.targetMarker);
    });
  }

  buildHustlerCard(hustlerData, skillRatingsHtml) {
    return `
<div class="card shadow-sm border-0" style="width:300px;">
  <div class="card-header text-white text-center" style="background:#0d6efd;">
    <h6 class="mb-0">${hustlerData.displayName || "Hustler"}</h6>
    <small>${hustlerData.primarySkill || ""}</small>
  </div>

  <div class="card-body">
    <div class="mb-2"><b>Rate:</b> ${hustlerData.pricing || "N/A"} (${hustlerData.pricingType || ""})</div>

    <div class="mb-3">
      <div class="fw-semibold small mb-1">Ratings</div>
      <div class="d-flex flex-wrap gap-2">
        ${skillRatingsHtml}
      </div>
    </div>

    <button id="select-hustler-${hustlerData.id}" class="btn btn-primary w-100 btn-sm">
      Request Hustler
    </button>
  </div>
</div>`;
  }

  /* ---------------- ROUTING ---------------- */

  getRoadRoute() {
    if (!this.clientStartLocation || !this.clientDestinationLocation) return;

    this.directionsService.route(
      {
        origin: this.clientStartLocation,
        destination: this.clientDestinationLocation,
        travelMode: google.maps.TravelMode[this.travelMode],
      },
      (response, status) => {
        if (status !== "OK") {
          console.error("Directions failed:", status);
          return;
        }

        this.directionsRenderer.setDirections(response);

        this.calculateTimeToBeTaken(response);
        this.calculateDistanceToBeTaken(response);

        __append_html(
          `${this.totalDistance.toFixed(2)} km`,
          document.querySelector(".client-distance-remaining"),
        );

        __append_html(
          `${this.totalMinutes.toFixed(1)} Minutes`,
          document.querySelector(".client-time-to-take"),
        );

        this.prepareAnimationPath(response);
        this.animateMovement();
      },
    );
  }

  /* ---------------- DISTANCE + TIME ---------------- */

  calculateTimeToBeTaken(response) {
    const seconds = response.routes[0].legs[0].duration.value;
    this.totalMinutes = seconds / 60;
  }

  calculateDistanceToBeTaken(response) {
    const meters = response.routes[0].legs[0].distance.value;
    this.totalDistance = meters / 1000;
  }

  /* ---------------- ANIMATION ---------------- */

  prepareAnimationPath(response) {
    const overviewPath = response.routes[0].overview_path;
    this.path = overviewPath.map((p) => ({
      lat: p.lat(),
      lng: p.lng(),
    }));
    this.currentIndex = 0;
  }

  animateMovement() {
    if (!this.clientMarker || this.currentIndex >= this.path.length) return;

    const pos = this.path[this.currentIndex];
    this.clientMarker.setPosition(new google.maps.LatLng(pos.lat, pos.lng));
    this.currentIndex++;

    setTimeout(() => this.animateMovement(), 300);
  }

  /* ---------------- MARKER MANAGEMENT ---------------- */

  addHustlerMarker(marker) {
    this.allHustlerMarkers.push(marker);
  }

  clearHustlerMarkers() {
    this.allHustlerMarkers.forEach((m) => m.setMap(null));
    this.allHustlerMarkers = [];
  }

  /* ---------------- HUSTLER SELECTION ---------------- */

  selectHustler(hustlerId) {
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
      success: function () {
        toast("success", "Job Created Successfully", 2000);
      },
      error: function () {
        toast("error", "Failed to create job", 2000);
      },
    });
  }
}