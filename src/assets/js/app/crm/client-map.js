class ClientMap extends Master {
  constructor(
    mapInstance,
    travelMode = "Walking",
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
    targetMarker = undefined,
    jobData = undefined,
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

    if (this.clientStartLocation) {
      this.clientMarker = new google.maps.Marker({
        position: this.clientStartLocation,
        map: this.mapInstance,
        label: this.clientLabel,
        icon: this.startLocationIcon,
        title: "You",
      });
    }

    const targetInfoWindow = new google.maps.InfoWindow({
      content: `
<div class="card shadow-sm border-0" style="width: 320px;">
  <!-- Content -->
  <div class="card-body p-4">
    <div class="text-center mb-4">
      <h4 class="mb-2 fw-bold text-dark">${jobData.name}</h4>
      <p class="mb-0 text-secondary">by ${jobData.ownerName}</p>
    </div>
    <div class="mb-4">
      <p class="text-dark mb-0" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">${jobData.description}</p>
    </div>
    <div class="mb-4">
      <div class="text-secondary">
        ${(() => {
          const startDate = new Date(jobData.startTime._seconds * 1000);
          const endDate = new Date(jobData.endTime._seconds * 1000);
          const startDateStr = startDate.toLocaleDateString("en-US", {
            month: "short",
            day: "numeric",
            year: "numeric",
          });
          const endDateStr = endDate.toLocaleDateString("en-US", {
            month: "short",
            day: "numeric",
            year: "numeric",
          });
          const startTime = startDate.toLocaleTimeString([], {
            hour: "2-digit",
            minute: "2-digit",
          });
          const endTime = endDate.toLocaleTimeString([], {
            hour: "2-digit",
            minute: "2-digit",
          });
          return startDateStr === endDateStr
            ? `${startDateStr} ${startTime} - ${endTime}`
            : `${startDateStr} ${startTime} - ${endDateStr} ${endTime}`;
        })()}
      </div>
    </div>
    <!-- Button -->
    <button id="show-job-direction" class="btn btn-outline-primary w-100 py-2 fw-medium">
      Show Route
    </button>
  </div>
</div>
  `,
    });

    targetInfoWindow.addListener("domready", () => {
      const selectBtn = document.getElementById("show-job-direction");
      if (selectBtn) {
        selectBtn.addEventListener("click", () => {
          this.clientDestinationLocation = this.clientPointOfWorkLocation;
          this.getRoadRoute();
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
}

document.addEventListener("DOMContentLoaded", function () {
  const path = window.location.href;
  const jobId = path.split("/").pop();
  if (!jobId) {
    console.error("Expected JobId");
  }
  fetch(`/crm/job/details/${jobId}`)
    .then((r) => r.json())
    .then((d) => {
      const master = new Master();
      master.setMapOnPage([d.job]);
    })
    .catch((e) => console.error(e));
});
