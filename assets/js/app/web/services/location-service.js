/**
 * Location Service
 * Handles browser geolocation, permissions, and position tracking
 * Mirrors the Flutter location package functionality
 */

class LocationService {
    constructor() {
        this.watchId = null;
        this.locationListeners = [];
    }

    /**
     * Check if location services are enabled
     * @returns {Promise<boolean>}
     */
    async isLocationServiceEnabled() {
        return new Promise((resolve) => {
            if (!navigator.geolocation) {
                resolve(false);
                return;
            }
            
            navigator.geolocation.getCurrentPosition(
                () => resolve(true),
                (error) => {
                    if (error.code === error.POSITION_UNAVAILABLE) {
                        resolve(false);
                    } else {
                        resolve(true);
                    }
                },
                { enableHighAccuracy: false }
            );
        });
    }

    /**
     * Request location service to be enabled
     * @returns {Promise<boolean>}
     */
    async requestLocationService() {
        // Browser handles this via permission prompt
        return await this.isLocationServiceEnabled();
    }

    /**
     * Check if location permission is granted
     * @returns {Promise<string>} 'granted', 'denied', or 'prompt'
     */
    async hasLocationPermission() {
        return new Promise(async (resolve) => {
            if (!navigator.geolocation) {
                resolve('denied');
                return;
            }

            try {
                const permissionStatus = await navigator.permissions.query({
                    name: 'geolocation'
                });
                resolve(permissionStatus.state);
            } catch (e) {
                resolve('prompt'); // fallback
            }
        });
    }

    /**
     * Request location permission
     * @returns {Promise<string>} 'granted' or 'denied'
     */
    async requestLocationPermission() {
        return new Promise((resolve) => {
            if (!navigator.geolocation) {
                resolve('denied');
                return;
            }

            navigator.geolocation.getCurrentPosition(
                () => resolve('granted'),
                () => resolve('denied'),
                { enableHighAccuracy: false, timeout: 10000 }
            );
        });
    }

    /**
     * Get current location once
     * @param {Object} options - Geolocation options
     * @returns {Promise<Object>} Location object
     */
    async getCurrentLocation(options = {}) {
        const defaultOptions = {
            enableHighAccuracy: false,
            timeout: 30000,
            maximumAge: 60000
        };

        const mergedOptions = { ...defaultOptions, ...options };

        return new Promise((resolve, reject) => {
            if (!navigator.geolocation) {
                reject(new Error("Browser does not support geolocation"));
                return;
            }

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    resolve({
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                        accuracy: position.coords.accuracy,
                        altitude: position.coords.altitude,
                        heading: position.coords.heading,
                        speed: position.coords.speed,
                        timestamp: position.timestamp
                    });
                },
                reject,
                mergedOptions
            );
        });
    }

    /**
     * Fallback method with lower accuracy
     */
    async getLocationWithLowAccuracy() {
        return new Promise((resolve, reject) => {
            if (!navigator.geolocation) {
                reject(new Error("No geolocation support"));
                return;
            }

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    resolve({
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                        accuracy: position.coords.accuracy,
                        altitude: position.coords.altitude,
                        heading: position.coords.heading,
                        speed: position.coords.speed,
                        timestamp: position.timestamp
                    });
                },
                reject,
                { enableHighAccuracy: false, timeout: 30000, maximumAge: 300000 }
            );
        });
    }

    /**
     * Watch location changes continuously
     * @param {Function} callback - Handles location updates
     * @param {Object} options - Geolocation options
     * @returns {number} Watch ID
     */
    watchLocation(callback, options = {}) {
        const defaultOptions = {
            enableHighAccuracy: true,
            timeout: 30000,
            maximumAge: 10000
        };

        const mergedOptions = { ...defaultOptions, ...options };

        if (!navigator.geolocation) {
            console.warn("Browser does not support geolocation");
            return null;
        }

        const watchId = navigator.geolocation.watchPosition(
            (position) => {
                const locationData = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                    accuracy: position.coords.accuracy,
                    altitude: position.coords.altitude,
                    heading: position.coords.heading,
                    speed: position.coords.speed,
                    timestamp: position.timestamp
                };
                
                this.locationListeners.forEach(listener => listener(locationData));
                callback(locationData);
            },
            (error) => console.error('Watch error:', error.message),
            mergedOptions
        );

        this.watchId = watchId;
        return watchId;
    }

    /**
     * Stop watching location
     */
    clearWatch(watchId) {
        if (watchId !== null && watchId !== undefined) {
            navigator.geolocation.clearWatch(watchId);
        }
        if (this.watchId !== null) {
            navigator.geolocation.clearWatch(this.watchId);
            this.watchId = null;
        }
    }

    /**
     * Add/remove location listeners
     */
    addLocationListener(listener) {
        this.locationListeners.push(listener);
    }

    removeLocationListener(listener) {
        const index = this.locationListeners.indexOf(listener);
        if (index > -1) this.locationListeners.splice(index, 1);
    }

    /**
     * Google Maps LatLng object
     */
    createLatLng(lat, lng) {
        return new google.maps.LatLng(lat, lng);
    }

    /**
     * Distance between two points in meters
     */
    calculateDistance(lat1, lng1, lat2, lng2) {
        const R = 6371000;
        const dLat = this.toRadians(lat2 - lat1);
        const dLng = this.toRadians(lng2 - lng1);
        const a = Math.sin(dLat/2)**2 + Math.cos(this.toRadians(lat1)) * Math.cos(this.toRadians(lat2)) * Math.sin(dLng/2)**2;
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c;
    }

    toRadians(degrees) {
        return degrees * (Math.PI / 180);
    }

    /**
     * Check if within radius
     */
    isWithinRadius(currentPosition, destination, radiusMeters = 50) {
        const distance = this.calculateDistance(
            currentPosition.lat,
            currentPosition.lng,
            destination.lat,
            destination.lng
        );
        return distance <= radiusMeters;
    }
}

// Export for use in other modules
window.LocationService = LocationService;