class ClientMap extends Master {
  constructor(
    mapInstance,
    travelMode = "WALKING",
    clientLabel = "You",
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
      title: "You",
    });
  }

  /* ---------------- JOB MARKER ---------------- */

  layOutMapMarker(locales, targetMarker, jobData) {
    if (!locales || !jobData) return;

    this.clientDestinationLocation = new google.maps.LatLng(
      locales.latitude,
      locales.longitude,
    );

    this.targetMarker = new google.maps.Marker({
      position: this.clientDestinationLocation,
      map: this.mapInstance,
      label: targetMarker || this.targetLabel,
      icon: this.targetDestinationIcon,
    });

    const targetInfoWindow = new google.maps.InfoWindow({
      content: this.buildJobCard(jobData),
    });

    targetInfoWindow.addListener("domready", () => {
      const btn = document.getElementById("show-job-direction");
      if (btn) {
        btn.onclick = () => {
          if (!this.clientStartLocation) {
            alert("Client location not set");
            return;
          }
          this.getRoadRoute();
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

  buildJobCard(jobData) {
    const startDate = new Date(jobData.startTime._seconds * 1000);
    const endDate = new Date(jobData.endTime._seconds * 1000);

    return `
<div class="card shadow-sm border-0" style="width: 320px;">
  <div class="card-body p-4">
    <div class="text-center mb-3">
      <h5 class="fw-bold">${jobData.name}</h5>
      <p class="text-muted mb-0">by ${jobData.ownerName}</p>
    </div>

    <p class="text-dark">${jobData.description || ""}</p>

    <div class="text-secondary mb-3">
      ${startDate.toLocaleString()} - ${endDate.toLocaleString()}
    </div>

    <button id="show-job-direction" class="btn btn-outline-primary w-100">
      Show Route
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
}

/* ---------------- PAGE INIT ---------------- */

document.addEventListener("DOMContentLoaded", function () {
  const url = new URL(window.location.href);
  const fromClient = !!url.searchParams.get("client");
  const jobId = url.pathname.split("/").filter(Boolean).pop();

  if (!jobId) return console.error("Expected JobId");

  fetch(`/crm/job/details/${jobId}`)
    .then((r) => r.json())
    .then((d) => {
      const master = new Master();
      master.setMapOnPage([{ ...d.job, client: fromClient }]);
    })
    .catch(console.error);
});