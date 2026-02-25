<!-- header -->
<?php include 'partials/layout/web/header.php'; ?>
<!-- /header -->

<!-- styles -->
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link type="text/css" rel="stylesheet" href="<?= asset_url('/css/app/crm/main.css') ?>">
<link type="text/css" rel="stylesheet" href="<?= asset_url('/css/app/crm/dashboard.css') ?>">
<!-- /styles -->

<!-- navbar -->
<?php include 'partials/layout/crm/navbar.php'; ?>
<!-- /navbar -->


<!-- Main CRM Section -->
<div class="crm-section">
    <div class="d-flex gap-3">
        <!-- Sidebar -->
        <aside class="col-md-2 d-none d-md-block" id="sidebar">
            <div class="card bg-transparent border-0">
                <?php include 'partials/layout/crm/sidebar.php'; ?>
            </div>
        </aside>

        <!-- CRM Content -->
        <main class="col-md-9 flex-grow-1">

            <div class="card vh-100 bg-transparent border-0 m-3 p-0 d-flex flex-column justify-content-center">
                <div class="position-relative rounded overflow-hidden border" style="height: 90%;background-color: #f2f2f2;">
                    <div id="job-location-map" class="geomap h-100 w-100"></div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- modals -->
<!-- /modals -->

<!-- footer -->
<?php include 'partials/layout/crm/footer.php'; ?>
<!-- /footer -->

<!-- Load new location services -->
<script type="text/javascript" src="<?= asset_url('js/app/web/services/location-service.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/web/services/geocoding-service.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/web/services/realtime-location.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/web/utils/distance-calculator.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/web/utils/polyline-renderer.js') ?>"></script>

<script type="text/javascript" src="<?= asset_url('js/app/crm/client-map.js') ?>"></script>

<!-- xtra scripts -->
<script type="text/javascript" src="<?= asset_url('js/app/crm/auth.js') ?>"></script>
<!-- <script type="text/javascript" src="<?= asset_url('js/app/crm/dashboard.js') ?>"></script> -->
<script type="text/javascript" src="<?= asset_url('js/app/crm/onboarding.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/crm/hustle-map.js') ?>"></script>

<!-- Job Location Tracking Script -->
<script>
document.addEventListener('DOMContentLoaded', async function() {
    console.log('Job Location Page Loaded');
    
    // Wait for Google Maps
    if (typeof google === 'undefined') {
        console.log('Waiting for Google Maps...');
        setTimeout(initJobTracking, 500);
        return;
    }
    
    await initJobTracking();
});

async function initJobTracking() {
    // Get job ID from URL
    const urlParams = new URLSearchParams(window.location.search);
    const pathParts = window.location.pathname.split('/');
    const jobId = pathParts[pathParts.length - 1] || urlParams.get('jobId');
    
    console.log('Job ID:', jobId);
    
    if (!jobId) {
        console.error('No job ID found');
        return;
    }
    
    // Get map element
    const mapElement = document.getElementById('job-location-map');
    if (!mapElement) {
        console.error('Map element not found');
        return;
    }
    
    // Initialize services
    const realtimeService = new window.RealtimeLocationService();
    const geocodingService = new window.GeocodingService();
    const distanceCalculator = window.DistanceCalculator;
    const polylineRenderer = new window.PolylineRenderer(null);
    
    // Get user's location
    let userPosition = { lat: -1.286389, lng: 36.817223 };
    
    if (navigator.geolocation) {
        userPosition = await new Promise((resolve) => {
            navigator.geolocation.getCurrentPosition(
                (pos) => resolve({ lat: pos.coords.latitude, lng: pos.coords.longitude }),
                () => resolve(userPosition),
                { enableHighAccuracy: true }
            );
        });
    }
    
    console.log('User position:', userPosition);
    
    // Initialize map
    const map = new google.maps.Map(mapElement, {
        zoom: 14,
        center: { lat: userPosition.lat, lng: userPosition.lng },
        mapId: "hustle-map"
    });
    
    polylineRenderer.setMap(map);
    
    // Add user marker
    const userMarker = new google.maps.Marker({
        position: userPosition,
        map: map,
        title: 'Your Location',
        icon: {
            path: google.maps.SymbolPath.CIRCLE,
            scale: 10,
            fillColor: '#2563eb',
            fillOpacity: 1,
            strokeColor: '#ffffff',
            strokeWeight: 2
        },
        zIndex: 1000
    });
    
    // Fetch job details
    let jobData = null;
    try {
        const response = await fetch(`/crm/job/details/${jobId}`);
        const result = await response.json();
        
        if (result.data) {
            jobData = result.data;
            console.log('Job data:', jobData);
        }
    } catch (e) {
        console.error('Error fetching job:', e);
    }
    
    // Add job site marker if available
    let jobSiteMarker = null;
    let jobSiteLocation = null;
    
    if (jobData && jobData.jobSite) {
        jobSiteLocation = {
            lat: jobData.jobSite._latitude || jobData.jobSite.latitude,
            lng: jobData.jobSite._longitude || jobData.jobSite.longitude
        };
        
        jobSiteMarker = new google.maps.Marker({
            position: jobSiteLocation,
            map: map,
            title: 'Job Location',
            icon: {
                url: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png',
                scaledSize: new google.maps.Size(40, 40)
            },
            zIndex: 999
        });
        
        // Draw route from user to job site
        try {
            await polylineRenderer.drawRoute(userPosition, jobSiteLocation, 'WALKING');
        } catch (e) {
            console.error('Error drawing route:', e);
        }
    }
    
    // Track hustlers if available
    let hustlerMarker = null;
    let hustlerId = null;
    
    if (jobData && jobData.hustlers) {
        // Get first accepted hustler
        const hustlerIds = Object.keys(jobData.hustlers);
        if (hustlerIds.length > 0) {
            hustlerId = hustlerIds[0];
            console.log('Tracking hustler:', hustlerId);
            
            // Start polling for hustler location
            realtimeService.startPolling([hustlerId], null, 5000);
            
            // Subscribe to location updates
            realtimeService.subscribe((id, location) => {
                console.log('Hustler location update:', location);
                
                const hustlerPos = { lat: location.lat, lng: location.lng };
                
                if (hustlerMarker) {
                    hustlerMarker.setPosition(new google.maps.LatLng(location.lat, location.lng));
                } else {
                    hustlerMarker = new google.maps.Marker({
                        position: hustlerPos,
                        map: map,
                        title: 'Hustler',
                        animation: google.maps.Animation.DROP
                    });
                }
                
                // Calculate distance
                const distance = distanceCalculator.calculateDistanceInMeters(
                    userPosition.lat, userPosition.lng,
                    location.lat, location.lng
                );
                
                console.log('Distance to hustler:', distance);
                
                // Draw route to hustler
                polylineRenderer.drawRoute(userPosition, hustlerPos, 'WALKING').then(() => {
                    console.log('Route drawn to hustler');
                });
            });
            
            // Set up arrival watcher
            if (jobSiteLocation) {
                realtimeService.watchArrival(
                    hustlerId,
                    jobSiteLocation,
                    50, // 50 meters
                    () => {
                        // Arrived!
                        console.log('Hustler has arrived!');
                        alert('The hustler has arrived at the job location!');
                    },
                    (id, loc, dist) => {
                        console.log(`Hustler is ${distanceCalculator.formatDistance(dist)} away`);
                    }
                );
            }
        }
    }
    
    // Fit bounds
    const bounds = new google.maps.LatLngBounds();
    bounds.extend(userMarker.getPosition());
    if (jobSiteMarker) bounds.extend(jobSiteMarker.getPosition());
    if (hustlerMarker) bounds.extend(hustlerMarker.getPosition());
    map.fitBounds(bounds);
    
    console.log('Job tracking initialized successfully');
}
</script>

<!-- closure -->
<?php include 'partials/layout/global/closure.php'; ?>
<!-- /closure -->
