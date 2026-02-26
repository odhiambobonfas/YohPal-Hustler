/**
 * My Jobs Map - Full tracking and location detection
 */

let myJobs = [];
let selectedJob = null;
let map = null;
let userMarker = null;
let jobMarker = null;
let hustlerMarkers = {};
let userPosition = null;
let userWatchId = null;

const deviceInfo = new window.DeviceInfoService();
const locationService = new window.LocationService();
const realtimeService = new window.RealtimeLocationService();
const distanceCalculator = window.DistanceCalculator;
let polylineRenderer = null;

// Initialize on page load
document.addEventListener('DOMContentLoaded', async function() {
    console.log('My Jobs page loaded');
    
    // Log device info
    deviceInfo.logDeviceInfo();
    const fullReport = await deviceInfo.getFullDeviceReport();
    console.log('Full device report:', fullReport);
    
    // Request and verify location permissions
    await initializeLocation();
    
    // Wait for Google Maps
    if (typeof google === 'undefined') {
        setTimeout(() => window.location.reload(), 1000);
        return;
    }
    
    // Initialize map
    await initMap();
    
    // Load jobs
    await loadMyJobs();
    
    // Setup search
    setupSearch();
    
    // Center map button
    document.getElementById('centerMapBtn').addEventListener('click', centerOnUser);
});

async function initializeLocation() {
    console.log('Initializing location services...');
    
    if (!navigator.geolocation) {
        alert('Your browser does not support location services');
        return false;
    }
    
    const permission = await locationService.hasLocationPermission();
    console.log('Location permission:', permission);
    
    if (permission === 'denied') {
        alert('Location permission denied. Please enable location access in your browser settings.');
        return false;
    }
    
    if (permission === 'prompt') {
        const granted = await locationService.requestLocationPermission();
        if (granted !== 'granted') {
            alert('Location permission is required to use this feature');
            return false;
        }
    }
    
    try {
        userPosition = await locationService.getCurrentLocation();
        console.log('✓ User position acquired:', userPosition);
        return true;
    } catch (error) {
        console.error('✗ High accuracy failed, trying low accuracy:', error);
        try {
            userPosition = await new Promise((resolve, reject) => {
                navigator.geolocation.getCurrentPosition(
                    (pos) => resolve({ lat: pos.coords.latitude, lng: pos.coords.longitude, accuracy: pos.coords.accuracy }),
                    reject,
                    { enableHighAccuracy: false, timeout: 30000, maximumAge: 60000 }
                );
            });
            console.log('✓ Low accuracy position acquired:', userPosition);
            return true;
        } catch (err) {
            console.error('✗ All location attempts failed:', err);
            alert('Unable to get your location. Please check device settings and reload.');
            return false;
        }
    }
}

async function initMap() {
    if (!userPosition) {
        console.error('✗ No user position available');
        return;
    }
    
    console.log('Initializing map with user position:', userPosition);
    const mapElement = document.getElementById('jobMap');
    
    map = new google.maps.Map(mapElement, {
        zoom: 14,
        center: { lat: userPosition.lat, lng: userPosition.lng },
        mapId: 'my-jobs-map'
    });
    
    polylineRenderer = new window.PolylineRenderer(map);
    
    // Create accuracy circle
    const accuracyCircle = new google.maps.Circle({
        map: map,
        center: { lat: userPosition.lat, lng: userPosition.lng },
        radius: userPosition.accuracy || 50,
        fillColor: '#4285F4',
        fillOpacity: 0.2,
        strokeColor: '#4285F4',
        strokeOpacity: 0.4,
        strokeWeight: 1,
        zIndex: 1
    });
    
    // Create pulsing circle
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
    
    // Create blue dot
    console.log('Creating user marker...');
    userMarker = new google.maps.Marker({
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
    
    // Animate pulse
    let pulseRadius = 20;
    let pulseDirection = 1;
    const pulseInterval = setInterval(() => {
        pulseRadius += pulseDirection * 2;
        if (pulseRadius >= 40 || pulseRadius <= 20) pulseDirection *= -1;
        pulseCircle.setRadius(pulseRadius);
    }, 100);
    
    // Watch position
    console.log('Starting location watch...');
    userWatchId = realtimeService.startWatchingMyLocation((location) => {
        console.log('Position update:', location);
        userPosition = location;
        const newPos = new google.maps.LatLng(location.lat, location.lng);
        userMarker.setPosition(newPos);
        accuracyCircle.setCenter(newPos);
        pulseCircle.setCenter(newPos);
        if (location.accuracy) {
            accuracyCircle.setRadius(location.accuracy);
        }
        
        if (selectedJob && selectedJob.jobSite) {
            updateDistanceInfo();
        }
    });
    console.log('Watch ID:', userWatchId);
    
    console.log('✓ Map initialized');
}

async function loadMyJobs() {
    try {
        const response = await fetch('/crm/hustler/my-jobs');
        const data = await response.json();
        
        myJobs = data.jobs || [];
        console.log('Loaded jobs:', myJobs.length);
        
        displayJobsList(myJobs);
        
        if (myJobs.length > 0) {
            selectJob(myJobs[0]);
        }
    } catch (error) {
        console.error('Failed to load jobs:', error);
        document.getElementById('jobsList').innerHTML = 
            '<div class="alert alert-danger">Failed to load jobs</div>';
    }
}

function displayJobsList(jobs) {
    const container = document.getElementById('jobsList');
    
    if (jobs.length === 0) {
        container.innerHTML = '<div class="alert alert-info">No jobs found</div>';
        return;
    }
    
    let html = '';
    jobs.forEach(job => {
        const isActive = selectedJob && selectedJob.id === job.id;
        const statusColor = job.status === 'active' ? 'success' : 
                           job.status === 'completed' ? 'secondary' : 'warning';
        
        html += `
            <div class="card job-card mb-2 ${isActive ? 'active' : ''}" onclick="selectJobById('${job.id}')">
                <div class="card-body">
                    <h6 class="card-title mb-2">${job.name || 'Untitled Job'}</h6>
                    <p class="card-text small text-muted mb-2">${job.description || 'No description'}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-${statusColor}">${job.status || 'pending'}</span>
                        <small class="text-muted">
                            <i class="fas fa-map-marker-alt"></i> ${job.region || 'Unknown'}
                        </small>
                    </div>
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
}

function selectJobById(jobId) {
    const job = myJobs.find(j => j.id === jobId);
    if (job) selectJob(job);
}

async function selectJob(job) {
    selectedJob = job;
    console.log('Selected job:', job);
    
    // Update UI
    displayJobsList(myJobs);
    
    // Clear existing markers
    if (jobMarker) jobMarker.setMap(null);
    Object.values(hustlerMarkers).forEach(m => m.setMap(null));
    hustlerMarkers = {};
    
    // Show job info
    document.getElementById('jobInfo').style.display = 'block';
    document.getElementById('jobTitle').textContent = job.name || 'Untitled Job';
    
    // Add job location marker
    if (job.jobSite) {
        const jobLocation = {
            lat: job.jobSite._latitude || job.jobSite.latitude,
            lng: job.jobSite._longitude || job.jobSite.longitude
        };
        
        jobMarker = new google.maps.Marker({
            position: jobLocation,
            map: map,
            title: 'Job Location',
            icon: {
                url: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png',
                scaledSize: new google.maps.Size(40, 40)
            },
            zIndex: 999
        });
        
        // Draw route
        if (userPosition) {
            await polylineRenderer.drawRoute(userPosition, jobLocation, 'DRIVING');
        }
        
        // Fit bounds
        const bounds = new google.maps.LatLngBounds();
        bounds.extend(userMarker.getPosition());
        bounds.extend(jobMarker.getPosition());
        map.fitBounds(bounds);
        
        updateDistanceInfo();
    }
    
    // Track other hustlers if any
    if (job.hustlers && Object.keys(job.hustlers).length > 0) {
        trackHustlers(job.hustlers);
    }
}

function trackHustlers(hustlers) {
    const hustlerIds = Object.keys(hustlers);
    console.log('Tracking hustlers:', hustlerIds);
    
    // Stop previous polling
    realtimeService.stopPolling();
    
    // Start polling for hustler locations
    realtimeService.startPolling(hustlerIds, null, 5000);
    
    // Subscribe to updates
    realtimeService.subscribe((hustlerId, location) => {
        console.log('Hustler location update:', hustlerId, location);
        
        const hustlerPos = { lat: location.lat, lng: location.lng };
        
        if (hustlerMarkers[hustlerId]) {
            hustlerMarkers[hustlerId].setPosition(new google.maps.LatLng(location.lat, location.lng));
        } else {
            hustlerMarkers[hustlerId] = new google.maps.Marker({
                position: hustlerPos,
                map: map,
                title: `Hustler ${hustlerId}`,
                icon: {
                    url: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png',
                    scaledSize: new google.maps.Size(35, 35)
                },
                zIndex: 500
            });
        }
    });
}

function updateDistanceInfo() {
    if (!userPosition || !selectedJob || !selectedJob.jobSite) return;
    
    const jobLocation = {
        lat: selectedJob.jobSite._latitude || selectedJob.jobSite.latitude,
        lng: selectedJob.jobSite._longitude || selectedJob.jobSite.longitude
    };
    
    const distance = distanceCalculator.calculateDistanceInMeters(
        userPosition.lat, userPosition.lng,
        jobLocation.lat, jobLocation.lng
    );
    
    const formattedDistance = distanceCalculator.formatDistance(distance);
    
    document.getElementById('jobDetails').innerHTML = `
        <i class="fas fa-route"></i> Distance: ${formattedDistance} from job location<br>
        <i class="fas fa-map-marker-alt"></i> Your location: ${userPosition.lat.toFixed(6)}, ${userPosition.lng.toFixed(6)}
    `;
}

function centerOnUser() {
    if (userPosition && map) {
        map.setCenter({ lat: userPosition.lat, lng: userPosition.lng });
        map.setZoom(16);
    }
}

function setupSearch() {
    document.getElementById('jobSearch').addEventListener('input', function(e) {
        const term = e.target.value.toLowerCase();
        
        const filtered = myJobs.filter(job => 
            (job.name && job.name.toLowerCase().includes(term)) ||
            (job.description && job.description.toLowerCase().includes(term)) ||
            (job.region && job.region.toLowerCase().includes(term))
        );
        
        displayJobsList(filtered);
    });
}

// Cleanup on page unload
window.addEventListener('beforeunload', () => {
    if (userWatchId) {
        realtimeService.stopWatchingMyLocation(userWatchId);
    }
    realtimeService.stopPolling();
});
