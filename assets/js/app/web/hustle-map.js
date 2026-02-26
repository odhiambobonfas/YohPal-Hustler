/**
 * HustleMap - Complete Map Management Class
 * Combines all location services for the web application
 * Mirrors the Flutter homePage.dart functionality
 */

class HustleMap {
    constructor(mapElementId, options = {}) {
        this.mapElementId = mapElementId;
        this.map = null;
        this.markers = {};
        this.polylines = [];
        this.infoWindows = [];
        
        // Default options
        this.defaultOptions = {
            zoom: 14,
            center: { lat: -1.286389, lng: 36.817223 }, // Nairobi
            mapTypeId: 'roadmap',
            mapId: 'hustle-map'
        };
        
        // Services
        this.locationService = new window.LocationService();
        this.geocodingService = new window.GeocodingService();
        this.realtimeService = new window.RealtimeLocationService();
        this.distanceCalculator = window.DistanceCalculator;
        this.polylineRenderer = new window.PolylineRenderer(); // Ensure PolylineRenderer is initialized
        
        // State
        this.myPosition = null;
        this.isMapLoading = true;
        this.selectedMarkerId = null;
        this.selectedMarkerPosition = null;
        this.arrivalWatcher = null;
        
        // Initialize
        this.init(options);
    }

    /**
     * Initialize the map
     */
    async init(options = {}) {
        const mergedOptions = { ...this.defaultOptions, ...options };
        
        // Wait for Google Maps to load
        await this.waitForGoogleMaps();
        
        // Get user's current location
        this.myPosition = await this.locationService.getCurrentLocation();
        mergedOptions.center = { 
            lat: this.myPosition.lat, 
            lng: this.myPosition.lng 
        };
        
        // Create map
        const mapElement = document.getElementById(this.mapElementId);
        if (!mapElement) {
            console.error('Map element not found:', this.mapElementId);
            return;
        }
        
        this.map = new google.maps.Map(mapElement, mergedOptions);
        
        // Add my position marker
        this.addMyPositionMarker();
        
        this.isMapLoading = false;
        
        console.log('HustleMap initialized at:', mergedOptions.center);
    }

    /**
     * Wait for Google Maps to load
     */
    waitForGoogleMaps() {
        return new Promise((resolve) => {
            if (typeof google !== 'undefined' && google.maps) {
                resolve();
                return;
            }
            
            const checkMaps = setInterval(() => {
                if (typeof google !== 'undefined' && google.maps) {
                    clearInterval(checkMaps);
                    resolve();
                }
            }, 100);
        });
    }

    /**
     * Add marker for user's position
     */
    addMyPositionMarker() {
        const myMarker = new google.maps.Marker({
            position: { lat: this.myPosition.lat, lng: this.myPosition.lng },
            map: this.map,
            title: 'My Location',
            icon: {
                path: google.maps.SymbolPath.CIRCLE,
                scale: 10,
                fillColor: '#2563eb',
                fillOpacity: 1,
                strokeColor: '#ffffff',
                strokeWeight: 2
            }
        });
        
        this.markers['myPosition'] = myMarker;
    }

    /**
     * Add a marker on the map
     */
    addMarker(id, position, title = '', icon = null, data = {}) {
        const markerOptions = {
            position: new google.maps.LatLng(position.lat, position.lng),
            map: this.map,
            title: title
        };
        
        if (icon) markerOptions.icon = icon;
        
        const marker = new google.maps.Marker(markerOptions);
        marker.metadata = { id, ...data };
        
        marker.addListener('click', () => {
            this.onMarkerClick(id, position, data);
        });
        
        this.markers[id] = marker;
        return marker;
    }

    /**
     * Handle marker click
     */
    onMarkerClick(id, position, data) {
        this.selectedMarkerId = id;
        this.selectedMarkerPosition = position;
        this.showInfoWindow(id, data);
        this.updateSelectedOverlayPosition(position);
    }

    /**
     * Show info window for marker
     */
    showInfoWindow(id, data) {
        this.closeAllInfoWindows();
        const marker = this.markers[id];
        if (!marker) return;
        
        const content = `
            <div class="p-2">
                <h6>${data.displayName || 'Location'}</h6>
                ${data.description ? `<p class="mb-1">${data.description}</p>` : ''}
                ${data.distance ? `<p class="mb-0 text-muted">${this.distanceCalculator.formatDistance(data.distance)} away</p>` : ''}
            </div>
        `;
        
        const infoWindow = new google.maps.InfoWindow({
            content: content,
            position: marker.getPosition()
        });
        
        infoWindow.open(this.map);
        this.infoWindows.push(infoWindow);
    }

    closeAllInfoWindows() {
        this.infoWindows.forEach(iw => iw.close());
        this.infoWindows = [];
    }

    updateSelectedOverlayPosition(position) {
        console.log('Selected marker at:', position);
    }

    /**
     * Add hustler markers
     */
    addHustlerMarkers(hustlers) {
        hustlers.forEach(hustler => {
            if (hustler.liveLocation) {
                const position = {
                    lat: hustler.liveLocation._latitude || hustler.liveLocation.lat,
                    lng: hustler.liveLocation._longitude || hustler.liveLocation.lng
                };
                
                const distance = this.myPosition ? 
                    this.distanceCalculator.calculateDistanceInMeters(
                        this.myPosition.lat,
                        this.myPosition.lng,
                        position.lat,
                        position.lng
                    ) : null;
                
                this.addMarker(
                    hustler.uid || hustler.id,
                    position,
                    hustler.displayName || 'Hustler',
                    null,
                    { ...hustler, distance, type: 'hustler' }
                );
            }
        });
    }

    /**
     * Add job site marker
     */
    addJobSiteMarker(jobSite, title = 'Job Site') {
        return this.addMarker(
            'jobSite',
            { lat: jobSite.lat, lng: jobSite.lng },
            title,
            { url: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png', scaledSize: new google.maps.Size(40, 40) },
            { type: 'jobSite' }
        );
    }

    /**
     * Draw route to destination
     */
    async drawRouteToDestination(destination, travelMode = 'DRIVING') {
        if (!this.myPosition) return null;
        try {
            const routeInfo = await this.polylineRenderer.drawRoute(
                { lat: this.myPosition.lat, lng: this.myPosition.lng },
                destination,
                travelMode
            );
            return routeInfo;
        } catch (error) {
            console.error('Failed to draw route:', error);
            return null;
        }
    }

    /**
     * Start tracking a hustler's location
     */
    startTrackingHustler(hustlerId, destination) {
        this.realtimeService.subscribe((id, location) => {
            if (id === hustlerId) this.updateMarkerPosition(hustlerId, location);
        });
        
        this.realtimeService.startPolling([hustlerId], null, 5000);
        
        this.realtimeService.watchArrival(
            hustlerId,
            destination,
            50,
            () => { this.onHustlerArrived(hustlerId); },
            (id, location, distance) => {
                console.log(`Hustler is ${this.distanceCalculator.formatDistance(distance)} away`);
            }
        );
    }

    stopTrackingHustler() {
        this.realtimeService.stopPolling();
        this.realtimeService.clearLocations();
    }

    updateMarkerPosition(id, newPosition) {
        const marker = this.markers[id];
        if (marker) marker.setPosition(new google.maps.LatLng(newPosition.lat, newPosition.lng));
    }

    onHustlerArrived(hustlerId) {
        console.log('Hustler arrived:', hustlerId);
    }

    centerOnPosition(position, zoom = null) {
        const newCenter = new google.maps.LatLng(position.lat, position.lng);
        this.map.setCenter(newCenter);
        if (zoom) this.map.setZoom(zoom);
    }

    fitBoundsToMarkers() {
        const bounds = new google.maps.LatLngBounds();
        Object.values(this.markers).forEach(marker => bounds.extend(marker.getPosition()));
        this.map.fitBounds(bounds);
    }

    getCenter() {
        const center = this.map.getCenter();
        return { lat: center.lat(), lng: center.lng() };
    }

    clearMarkers() {
        Object.keys(this.markers).forEach(id => {
            if (id !== 'myPosition') {
                this.markers[id].setMap(null);
                delete this.markers[id];
            }
        });
    }

    getDistanceToTarget(targetPosition) {
        if (!this.myPosition) return null;
        return this.distanceCalculator.calculateDistanceInMeters(
            this.myPosition.lat,
            this.myPosition.lng,
            targetPosition.lat,
            targetPosition.lng
        );
    }

    dispose() {
        this.stopTrackingHustler();
        this.polylineRenderer.dispose();
        this.closeAllInfoWindows();
        this.clearMarkers();
        if (this.markers['myPosition']) this.markers['myPosition'].setMap(null);
    }
}

// Export
window.HustleMap = HustleMap;