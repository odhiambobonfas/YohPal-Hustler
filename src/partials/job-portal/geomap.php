<!-- Map Placeholder -->
<div class="position-relative rounded overflow-hidden border" style="height: 100vh; background-color: #f2f2f2;">
    <div id="services-map" class="d-flex align-items-center justify-content-center h-100 text-muted geomap">
        Map Placeholder (Google Maps API not included)
    </div>

    <div class="position-absolute top-50 start-50 translate-middle text-dark bg-white px-3 py-1 rounded shadow-sm">
        <small>
        <!-- 📍 Current Location -->
        </small>
    </div>

    <div class="position-absolute bottom-0 start-0 m-3">
        <button class="btn btn-outline-dark btn-sm d-flex align-items-center gap-1">
            <i class="material-icons">my_location</i> Locate
        </button>
    </div>

    <div class="position-absolute bottom-0 end-0 m-3 d-flex flex-column gap-2">
        <button class="btn btn-outline-dark btn-sm"><i class="material-icons">zoom_in</i></button>
        <button class="btn btn-outline-dark btn-sm"><i class="material-icons">zoom_out</i></button>
    </div>

    <div class="position-absolute bottom-0 start-50 translate-middle-x mb-2 text-muted small">
        © 2025 Map Provider
    </div>
</div>