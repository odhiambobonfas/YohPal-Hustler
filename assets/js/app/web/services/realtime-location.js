/**
 * Realtime Location Service
 * Handles live location streaming from server/polling for real-time updates
 * Mirrors the Flutter StreamSubscription functionality
 */

class RealtimeLocationService {
    constructor() {
        this.pollInterval = null;
        this.listeners = [];
        this.hustlerLocations = {};
        this.arrivalWatchers = {};
        this.pollingUrl = '/crm/hustler/get_location';
        this.pollIntervalMs = 5000; // 5 seconds default
        this.isPolling = false;
    }

    /**
     * Start polling for hustler locations
     * @param {Array} hustlerIds - Array of hustler IDs to track
     * @param {Function} callback - Callback for location updates
     * @param {number} intervalMs - Polling interval in milliseconds
     */
    startPolling(hustlerIds, callback, intervalMs = 5000) {
        if (this.isPolling) {
            console.warn('Already polling for locations');
            return;
        }

        this.pollIntervalMs = intervalMs;
        this.isPolling = true;

        const poll = async () => {
            try {
                for (const hustlerId of hustlerIds) {
                    const location = await this.fetchHustlerLocation(hustlerId);
                    if (location) {
                        this.hustlerLocations[hustlerId] = location;
                        
                        // Notify all listeners
                        this.listeners.forEach(listener => listener(hustlerId, location));
                        
                        if (callback) {
                            callback(hustlerId, location);
                        }

                        // Check arrival watchers
                        this.checkArrivalWatchers(hustlerId, location);
                    }
                }
            } catch (error) {
                console.error('Error polling location:', error);
            }
        };

        // Initial fetch
        poll();

        // Set up interval
        this.pollInterval = setInterval(poll, this.pollIntervalMs);
    }

    /**
     * Stop polling for locations
     */
    stopPolling() {
        if (this.pollInterval) {
            clearInterval(this.pollInterval);
            this.pollInterval = null;
        }
        this.isPolling = false;
    }

    /**
     * Fetch a single hustler's location from server
     * @param {string} hustlerId - Hustler ID
     * @returns {Promise<Object>} Location object
     */
    async fetchHustlerLocation(hustlerId) {
        try {
            const response = await fetch(`${this.pollingUrl}/${hustlerId}`);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            
            if (data.error) {
                console.error('Error fetching location:', data.message);
                return null;
            }

            return {
                lat: data.latitude || data.lat || data._latitude,
                lng: data.longitude || data.lng || data._longitude,
                accuracy: data.accuracy || 100,
                timestamp: data.timestamp || Date.now()
            };
        } catch (error) {
            console.error('Failed to fetch hustler location:', error);
            return null;
        }
    }

    /**
     * Get all tracked hustler locations
     * @returns {Object} Object with hustler IDs as keys
     */
    getAllLocations() {
        return { ...this.hustlerLocations };
    }

    /**
     * Get a specific hustler's location
     * @param {string} hustlerId - Hustler ID
     * @returns {Object|null} Location object or null
     */
    getHustlerLocation(hustlerId) {
        return this.hustlerLocations[hustlerId] || null;
    }

    /**
     * Subscribe to location updates
     * @param {Function} listener - Function to call on updates
     * @returns {Function} Unsubscribe function
     */
    subscribe(listener) {
        this.listeners.push(listener);
        return () => {
            const index = this.listeners.indexOf(listener);
            if (index > -1) this.listeners.splice(index, 1);
        };
    }

    /**
     * Set up arrival watcher for a hustler
     * @param {string} hustlerId - Hustler ID
     * @param {Object} destination - Destination {lat, lng}
     * @param {number} thresholdMeters - Distance threshold in meters
     * @param {Function} onArrival - Callback when arrived
     * @param {Function} onApproaching - Callback when approaching
     */
    watchArrival(hustlerId, destination, thresholdMeters = 50, onArrival, onApproaching) {
        this.arrivalWatchers[hustlerId] = {
            destination,
            threshold: thresholdMeters,
            hasArrived: false,
            onArrival,
            onApproaching
        };
    }

    /**
     * Remove arrival watcher
     * @param {string} hustlerId - Hustler ID
     */
    removeArrivalWatcher(hustlerId) {
        delete this.arrivalWatchers[hustlerId];
    }

    /**
     * Check arrival status for a hustler
     * @param {string} hustlerId 
     * @param {Object} currentLocation 
     */
    checkArrivalWatchers(hustlerId, currentLocation) {
        const watcher = this.arrivalWatchers[hustlerId];
        if (!watcher) return;

        const distance = this.calculateDistance(
            currentLocation.lat,
            currentLocation.lng,
            watcher.destination.lat,
            watcher.destination.lng
        );

        if (distance <= watcher.threshold && !watcher.hasArrived) {
            watcher.hasArrived = true;
            if (watcher.onArrival) watcher.onArrival(hustlerId, currentLocation);
        } else if (distance > watcher.threshold) {
            watcher.hasArrived = false;
            if (watcher.onApproaching && distance <= watcher.threshold * 3) {
                watcher.onApproaching(hustlerId, currentLocation, distance);
            }
        }
    }

    /**
     * Calculate distance between two points
     * @param {number} lat1 
     * @param {number} lng1 
     * @param {number} lat2 
     * @param {number} lng2 
     * @returns {number} Distance in meters
     */
    calculateDistance(lat1, lng1, lat2, lng2) {
        if (typeof google !== 'undefined' && google.maps && google.maps.geometry) {
            const start = new google.maps.LatLng(lat1, lng1);
            const end = new google.maps.LatLng(lat2, lng2);
            return google.maps.geometry.spherical.computeDistanceBetween(start, end);
        }
        const R = 6371000;
        const dLat = this.toRadians(lat2 - lat1);
        const dLng = this.toRadians(lng2 - lng1);
        const a = Math.sin(dLat / 2) ** 2 +
                  Math.cos(this.toRadians(lat1)) * Math.cos(this.toRadians(lat2)) *
                  Math.sin(dLng / 2) ** 2;
        return 2 * R * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    }

    /**
     * Convert degrees to radians
     * @param {number} degrees 
     * @returns {number}
     */
    toRadians(degrees) {
        return degrees * (Math.PI / 180);
    }

    /**
     * Update location on server
     * @param {Object} location - {lat, lng}
     * @returns {Promise<boolean>}
     */
    async updateLocationOnServer(location) {
        try {
            const response = await fetch('/hustler/update_location', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ latitude: location.lat, longitude: location.lng, timestamp: Date.now() })
            });
            return response.ok;
        } catch (error) {
            console.error('Failed to update location on server:', error);
            return false;
        }
    }

    /**
     * Clear all tracked locations
     */
    clearLocations() {
        this.hustlerLocations = {};
    }

    /**
     * Check if currently polling
     * @returns {boolean}
     */
    isActive() {
        return this.isPolling;
    }

    /**
     * Start watching user's own location
     * @param {Function} callback - Callback for location updates
     * @returns {number} Watch ID
     */
    startWatchingMyLocation(callback) {
        if (!navigator.geolocation) {
            console.error('Geolocation not supported');
            return null;
        }
        
        const watchId = navigator.geolocation.watchPosition(
            (position) => {
                const location = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                    accuracy: position.coords.accuracy,
                    timestamp: position.timestamp
                };
                callback(location);
            },
            (error) => console.error('Watch error:', error.message),
            { enableHighAccuracy: true, timeout: 30000, maximumAge: 10000 }
        );
        
        return watchId;
    }

    /**
     * Stop watching user's location
     * @param {number} watchId
     */
    stopWatchingMyLocation(watchId) {
        if (watchId && navigator.geolocation) {
            navigator.geolocation.clearWatch(watchId);
        }
    }

    /**
     * Dispose of service
     */
    dispose() {
        this.stopPolling();
        this.listeners = [];
        this.hustlerLocations = {};
        this.arrivalWatchers = {};
    }
}

// Export for use in other modules
window.RealtimeLocationService = RealtimeLocationService;