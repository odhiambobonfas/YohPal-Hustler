/**
 * Polyline Renderer Utility
 * Handles drawing routes on Google Maps
 * Mirrors Flutter flutter_polyline_points functionality
 */

class PolylineRenderer {
    constructor(map) {
        this.map = map;
        this.polylines = [];
        this.directionsService = null;
        this.directionsRenderer = null;
        this.routeListeners = [];
        
        // Initialize if Google Maps is available
        if (typeof google !== 'undefined' && google.maps) {
            this.initDirections();
        }
    }

    /**
     * Initialize Google Maps Directions service and renderer
     */
    initDirections() {
        this.directionsService = new google.maps.DirectionsService();
        this.directionsRenderer = new google.maps.DirectionsRenderer({
            map: this.map,
            suppressMarkers: true,
            suppressPolylines: false,
            preserveViewport: false,
            polylineOptions: {
                strokeColor: '#2563eb',
                strokeWeight: 4,
                strokeOpacity: 0.8
            }
        });
    }

    /**
     * Set the map for this renderer
     * @param {Object} map - Google Maps instance
     */
    setMap(map) {
        this.map = map;
        if (this.directionsRenderer) {
            this.directionsRenderer.setMap(map);
        }
    }

    /**
     * Draw route between two points using Google Directions API
     * @param {Object} origin - Origin {lat, lng}
     * @param {Object} destination - Destination {lat, lng}
     * @param {string} travelMode - 'DRIVING', 'WALKING', 'BICYCLING', 'TRANSIT'
     * @returns {Promise<Object>} Route information
     */
    async drawRoute(origin, destination, travelMode = 'DRIVING') {
        return new Promise((resolve, reject) => {
            if (!this.directionsService) {
                console.error('Directions service not initialized');
                reject(new Error('Directions service not initialized'));
                return;
            }

            const request = {
                origin: new google.maps.LatLng(origin.lat, origin.lng),
                destination: new google.maps.LatLng(destination.lat, destination.lng),
                travelMode: google.maps.TravelMode[travelMode],
                unitSystem: google.maps.UnitSystem.METRIC,
                provideRouteAlternatives: false
            };

            this.directionsService.route(request, (result, status) => {
                if (status === 'OK') {
                    // Draw the route
                    this.directionsRenderer.setDirections(result);
                    
                    // Extract route information
                    const route = result.routes[0];
                    const leg = route.legs[0];
                    
                    const routeInfo = {
                        distance: leg.distance.value, // in meters
                        duration: leg.duration.value, // in seconds
                        startAddress: leg.start_address,
                        endAddress: leg.end_address,
                        steps: leg.steps.map(step => ({
                            distance: step.distance.value,
                            duration: step.duration.value,
                            instructions: step.instructions,
                            startLocation: {
                                lat: step.start_location.lat(),
                                lng: step.start_location.lng()
                            },
                            endLocation: {
                                lat: step.end_location.lat(),
                                lng: step.end_location.lng()
                            }
                        })),
                        overviewPath: route.overview_path.map(point => ({
                            lat: point.lat(),
                            lng: point.lng()
                        }))
                    };
                    
                    // Notify listeners
                    this.routeListeners.forEach(listener => listener(routeInfo));
                    
                    resolve(routeInfo);
                } else {
                    console.error('Directions request failed:', status);
                    reject(new Error('Directions request failed: ' + status));
                }
            });
        });
    }

    /**
     * Draw route with custom options
     * @param {Object} origin 
     * @param {Object} destination 
     * @param {Object} options - Custom polyline options
     * @returns {Promise<Object>}
     */
    async drawRouteWithOptions(origin, destination, options = {}) {
        const defaultOptions = {
            strokeColor: '#2563eb',
            strokeWeight: 4,
            strokeOpacity: 0.8,
            travelMode: 'DRIVING'
        };

        const mergedOptions = { ...defaultOptions, ...options };
        
        // Create custom polyline
        const route = await this.drawRoute(origin, destination, mergedOptions.travelMode);
        
        // Apply custom styles
        if (mergedOptions.polylineOptions) {
            this.directionsRenderer.setOptions({
                polylineOptions: mergedOptions.polylineOptions
            });
        }
        
        return route;
    }

    /**
     * Draw a simple polyline between points
     * @param {Array} points - Array of {lat, lng} objects
     * @param {Object} options - Polyline options
     * @returns {Object} The polyline object
     */
    drawPolyline(points, options = {}) {
        const defaultOptions = {
            path: points.map(p => new google.maps.LatLng(p.lat, p.lng)),
            geodesic: true,
            strokeColor: '#2563eb',
            strokeWeight: 4,
            strokeOpacity: 0.8
        };

        const polylineOptions = { ...defaultOptions, ...options };
        const polyline = new google.maps.Polyline(polylineOptions);
        
        polyline.setMap(this.map);
        this.polylines.push(polyline);
        
        return polyline;
    }

    /**
     * Draw animated polyline (progressive drawing)
     * @param {Array} points - Array of {lat, lng}
     * @param {number} animationSpeed - Delay between points in ms
     * @param {Object} options - Polyline options
     * @returns {Promise<void>}
     */
    async drawAnimatedPolyline(points, animationSpeed = 50, options = {}) {
        return new Promise((resolve) => {
            const path = [];
            let currentIndex = 0;

            const defaultOptions = {
                strokeColor: '#2563eb',
                strokeWeight: 4,
                strokeOpacity: 0.8
            };

            const polylineOptions = { ...defaultOptions, ...options, path: path };
            const polyline = new google.maps.Polyline(polylineOptions);
            polyline.setMap(this.map);
            
            const animate = () => {
                if (currentIndex >= points.length) {
                    this.polylines.push(polyline);
                    resolve();
                    return;
                }

                path.push(new google.maps.LatLng(points[currentIndex].lat, points[currentIndex].lng));
                polyline.setPath(path);
                
                // Update map to fit bounds
                const bounds = new google.maps.LatLngBounds();
                path.forEach(point => bounds.extend(point));
                this.map.fitBounds(bounds);
                
                currentIndex++;
                setTimeout(animate, animationSpeed);
            };

            animate();
        });
    }

    /**
     * Clear all polylines from map
     */
    clearPolylines() {
        this.polylines.forEach(polyline => {
            polyline.setMap(null);
        });
        this.polylines = [];
        
        if (this.directionsRenderer) {
            this.directionsRenderer.setDirections({ routes: [] });
        }
    }

    /**
     * Clear a specific polyline
     * @param {Object} polyline - Polyline to remove
     */
    removePolyline(polyline) {
        const index = this.polylines.indexOf(polyline);
        if (index > -1) {
            polyline.setMap(null);
            this.polylines.splice(index, 1);
        }
    }

    /**
     * Add listener for route updates
     * @param {Function} listener 
     */
    addRouteListener(listener) {
        this.routeListeners.push(listener);
    }

    /**
     * Remove route listener
     * @param {Function} listener 
     */
    removeRouteListener(listener) {
        const index = this.routeListeners.indexOf(listener);
        if (index > -1) {
            this.routeListeners.splice(index, 1);
        }
    }

    /**
     * Get total distance of drawn route
     * @returns {number} Distance in meters
     */
    getTotalDistance() {
        let total = 0;
        this.polylines.forEach(polyline => {
            const path = polyline.getPath();
            for (let i = 0; i < path.getLength() - 1; i++) {
                total += google.maps.geometry.spherical.computeDistanceBetween(
                    path.getAt(i),
                    path.getAt(i + 1)
                );
            }
        });
        return total;
    }

    /**
     * Update polyline color
     * @param {string} color - Hex color
     */
    setStrokeColor(color) {
        this.polylines.forEach(polyline => {
            polyline.setOptions({ strokeColor: color });
        });
        
        if (this.directionsRenderer) {
            this.directionsRenderer.setOptions({
                polylineOptions: { strokeColor: color }
            });
        }
    }

    /**
     * Dispose of all resources
     */
    dispose() {
        this.clearPolylines();
        this.routeListeners = [];
        if (this.directionsRenderer) {
            this.directionsRenderer.setMap(null);
        }
    }
}

// Export for use in other modules
window.PolylineRenderer = PolylineRenderer;
