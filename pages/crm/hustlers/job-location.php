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
        <aside class="col-md-2" id="sidebar">
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
<script type="text/javascript" src="<?= asset_url('js/app/web/services/device-info.js') ?>"></script>
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
    
    // Initialize device info
    const deviceInfo = new window.DeviceInfoService();
    deviceInfo.logDeviceInfo();
    const deviceReport = await deviceInfo.getFullDeviceReport();
    console.log('Device capabilities:', deviceReport);
    
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
    
    // Get user's location with continuous updates
    let userPosition = null;
    
    try {
        userPosition = await new Promise((resolve, reject) => {
            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    console.log('✓ User location obtained:', pos.coords.latitude, pos.coords.longitude);
                    resolve({ lat: pos.coords.latitude, lng: pos.coords.longitude });
                },
                (error) => {
                    console.error('✗ Location error:', error.code, error.message);
                    reject(error);
                },
                { enableHighAccuracy: false, timeout: 30000, maximumAge: 60000 }
            );
        });
    } catch (error) {
        console.error('Location failed:', error);
        userPosition = await new Promise((resolve) => {
            navigator.geolocation.getCurrentPosition(
                (pos) => resolve({ lat: pos.coords.latitude, lng: pos.coords.longitude }),
                () => resolve(null),
                { enableHighAccuracy: false, timeout: 30000, maximumAge: 300000 }
            );
        });
        
        if (!userPosition) {
            alert('Unable to get your location. Please check browser settings.');
            return;
        }
    }
    
    console.log('User position:', userPosition);
    
    // Initialize map
    const map = new google.maps.Map(mapElement, {
        zoom: 14,
        center: { lat: userPosition.lat, lng: userPosition.lng },
        mapId: "hustle-map"
    });
    
    polylineRenderer.setMap(map);
    
    // Add user marker with Google Maps native style
    console.log('Creating user marker at:', userPosition);
    
    // Create accuracy circle (like Google Maps)
    const accuracyCircle = new google.maps.Circle({
        map: map,
        center: { lat: userPosition.lat, lng: userPosition.lng },
        radius: 50,
        fillColor: '#4285F4',
        fillOpacity: 0.2,
        strokeColor: '#4285F4',
        strokeOpacity: 0.4,
        strokeWeight: 1,
        zIndex: 1
    });
    
    // Create pulsing outer circle
    const pulseCircle = new google.maps.Circle({
        map: map,
        center: { lat: userPosition.lat, lng: userPosition.lng },
        radius: 20,
        fillColor: '#4285F4',
        fillOpacity: 0.3,
        strokeColor: 'transparent',
        strokeWeight: 0,
        zIndex: 2
    });
    
    // Create blue dot marker
    const userMarker = new google.maps.Marker({
        position: new google.maps.LatLng(userPosition.lat, userPosition.lng),
        map: map,
        title: 'Your Location',
        icon: {
            path: google.maps.SymbolPath.CIRCLE,
            scale: 8,
            fillColor: '#4285F4',
            fillOpacity: 1,
            strokeColor: '#FFFFFF',
            strokeWeight: 2
        },
        zIndex: 10000
    });
    console.log('✓ User marker created');
    
    // Animate pulse effect
    let pulseRadius = 20;
    let pulseDirection = 1;
    setInterval(() => {
        pulseRadius += pulseDirection * 2;
        if (pulseRadius >= 40 || pulseRadius <= 20) pulseDirection *= -1;
        pulseCircle.setRadius(pulseRadius);
    }, 100);
    
    // Watch user position continuously
    console.log('Starting continuous location watch...');
    const userWatchId = realtimeService.startWatchingMyLocation((location) => {
        console.log('User position updated:', location);
        userPosition = location;
        const newPos = new google.maps.LatLng(location.lat, location.lng);
        userMarker.setPosition(newPos);
        accuracyCircle.setCenter(newPos);
        pulseCircle.setCenter(newPos);
        if (location.accuracy) {
            accuracyCircle.setRadius(location.accuracy);
        }
    });
    console.log('Watch ID:', userWatchId);
    
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
