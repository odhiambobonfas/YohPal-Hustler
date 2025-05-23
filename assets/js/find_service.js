document.addEventListener("DOMContentLoaded", function () {
  const sidebarToggle = document.getElementById("sidebar-toggle");
  const sidebar = document.getElementById("sidebar");

  // Toggle sidebar visibility
  if (sidebarToggle && sidebar) {
    sidebarToggle.addEventListener("click", function () {
      sidebar.classList.toggle("show");
    });
  }

  // Optional: Close sidebar when clicking outside
  document.addEventListener("click", function (event) {
    if (sidebar && sidebarToggle && sidebar.classList.contains("show")) {
      // Check if the click is outside the sidebar AND not on the toggle button itself
      if (
        !sidebar.contains(event.target) &&
        !sidebarToggle.contains(event.target)
      ) {
        sidebar.classList.remove("show");
      }
    }
  });

  // You would initialize the Google Map here
  // For a static replica, this part is commented out or a placeholder.
  function initMap() {
    const mapOptions = {
      center: { lat: -1.286389, lng: 36.817223 }, // Example: Nairobi, Kenya
      zoom: 12,
      disableDefaultUI: true, // Disable default Google Maps UI to use our custom one
    };
    const map = new google.maps.Map(document.getElementById("map"), mapOptions);
    // Add markers, layers, etc. here
  }

  // Make initMap globally accessible if using the Google Maps API script tag
  window.initMap = initMap;
});
