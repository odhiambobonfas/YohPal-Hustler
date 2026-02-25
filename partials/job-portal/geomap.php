<!-- Map Container with Overlay Support -->
<div class="position-relative rounded overflow-hidden border" style="height: 100vh; background-color: #f2f2f2;">
    <!-- Map render sits in here -->
    <div id="services-map" class="d-flex align-items-center justify-content-center h-100 text-muted geomap"></div>
    
    <!-- Hustler Overlay Container - positioned above markers when selected -->
    <div id="hustler-overlay" class="position-absolute d-none" style="z-index: 1000; top: 20px; left: 50%; transform: translateX(-50%);">
        <div class="card shadow-lg border-0" style="width: 280px; min-height: 100px;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center mb-2">
                    <img id="overlay-avatar" src="" class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;" alt="">
                    <div>
                        <h6 class="mb-0" id="overlay-name">Hustler Name</h6>
                        <small class="text-muted" id="overlay-skill">Primary Skill</small>
                    </div>
                </div>
                <div class="mb-2" id="overlay-rating">
                    <span class="text-warning">⭐</span> <span id="overlay-rating-value">0.0</span>
                </div>
                <div class="mb-2 text-muted small">
                    <i class="fas fa-road"></i> <span id="overlay-distance">0 m</span> away
                </div>
                <div class="mb-2 text-muted small">
                    <i class="fas fa-walking"></i> <span id="overlay-eta">0 min</span> walking time
                </div>
                <button class="btn btn-primary btn-sm w-100" id="overlay-request-btn">Request</button>
            </div>
        </div>
    </div>
    
    <!-- Loading Indicator -->
    <div id="map-loading" class="position-absolute top-50 start-50 translate-middle text-center">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-2 text-muted small">Loading map...</p>
    </div>
    
    <!-- Map Controls -->
    <div class="position-absolute" style="top: 10px; right: 10px; z-index: 999;">
        <button class="btn btn-light btn-sm shadow-sm mb-1" id="map-zoom-in" title="Zoom In">
            <i class="fas fa-plus"></i>
        </button>
        <button class="btn btn-light btn-sm shadow-sm" id="map-zoom-out" title="Zoom Out">
            <i class="fas fa-minus"></i>
        </button>
    </div>
    
    <!-- My Location Button -->
    <div class="position-absolute" style="bottom: 80px; right: 10px; z-index: 999;">
        <button class="btn btn-primary btn-sm shadow-sm rounded-circle" style="width: 40px; height: 40px;" id="map-my-location" title="My Location">
            <i class="fas fa-crosshairs"></i>
        </button>
    </div>
    
    <div class="position-absolute bottom-0 start-50 translate-middle-x mb-2 text-muted small">
        © <?= date("Y") ?> Map Provider
    </div>
</div>

<script>
    // Map control functionality
    document.addEventListener('googleMapsLoaded', function() {
        const zoomInBtn = document.getElementById('map-zoom-in');
        const zoomOutBtn = document.getElementById('map-zoom-out');
        const myLocationBtn = document.getElementById('map-my-location');
        const loadingIndicator = document.getElementById('map-loading');
        
        // Hide loading when map is ready
        if (loadingIndicator) {
            setTimeout(() => {
                loadingIndicator.style.display = 'none';
            }, 1000);
        }
        
        // Zoom controls will be connected when map is initialized
        window.mapZoomControls = {
            zoomIn: function() {
                const map = window._currentMap;
                if (map) {
                    map.setZoom(map.getZoom() + 1);
                }
            },
            zoomOut: function() {
                const map = window._currentMap;
                if (map) {
                    map.setZoom(map.getZoom() - 1);
                }
            },
            goToMyLocation: async function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const map = window._currentMap;
                        if (map) {
                            map.setCenter({
                                lat: position.coords.latitude,
                                lng: position.coords.longitude
                            });
                            map.setZoom(16);
                        }
                    });
                }
            }
        };
        
        if (zoomInBtn) {
            zoomInBtn.addEventListener('click', window.mapZoomControls.zoomIn);
        }
        if (zoomOutBtn) {
            zoomOutBtn.addEventListener('click', window.mapZoomControls.zoomOut);
        }
        if (myLocationBtn) {
            myLocationBtn.addEventListener('click', window.mapZoomControls.goToMyLocation);
        }
    });
</script>
