/**
 * Distance Calculator Utility
 * Calculates distances between coordinates using Haversine formula
 * Mirrors Flutter distance calculation functionality
 */

class DistanceCalculator {
    /**
     * Calculate distance between two points in meters
     * @param {number} lat1 - Latitude of point 1
     * @param {number} lng1 - Longitude of point 1
     * @param {number} lat2 - Latitude of point 2
     * @param {number} lng2 - Longitude of point 2
     * @returns {number} Distance in meters
     */
    static calculateDistanceInMeters(lat1, lng1, lat2, lng2) {
        // Use Google Maps geometry library for more accurate distance
        if (typeof google !== 'undefined' && google.maps && google.maps.geometry) {
            const startLatLng = new google.maps.LatLng(lat1, lng1);
            const endLatLng = new google.maps.LatLng(lat2, lng2);
            return google.maps.geometry.spherical.computeDistanceBetween(startLatLng, endLatLng);
        }
        
        // Fallback to Haversine formula
        const R = 6371000; // Earth's radius in meters
        const dLat = this.toRadians(lat2 - lat1);
        const dLng = this.toRadians(lng2 - lng1);
        
        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                  Math.cos(this.toRadians(lat1)) * Math.cos(this.toRadians(lat2)) *
                  Math.sin(dLng / 2) * Math.sin(dLng / 2);
        
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        
        return R * c;
    }

    /**
     * Calculate distance in kilometers
     * @param {number} lat1 
     * @param {number} lng1 
     * @param {number} lat2 
     * @param {number} lng2 
     * @returns {number} Distance in kilometers
     */
    static calculateDistanceInKilometers(lat1, lng1, lat2, lng2) {
        return this.calculateDistanceInMeters(lat1, lng1, lat2, lng2) / 1000;
    }

    /**
     * Calculate distance between two Google Maps LatLng objects
     * @param {Object} start - Google Maps LatLng {lat(), lng()}
     * @param {Object} end - Google Maps LatLng {lat(), lng()}
     * @returns {number} Distance in meters
     */
    static calculateDistanceBetweenLatLng(start, end) {
        const lat1 = typeof start.lat === 'function' ? start.lat() : start.lat;
        const lng1 = typeof start.lng === 'function' ? start.lng() : start.lng;
        const lat2 = typeof end.lat === 'function' ? end.lat() : end.lat;
        const lng2 = typeof end.lng === 'function' ? end.lng() : end.lng;
        
        return this.calculateDistanceInMeters(lat1, lng1, lat2, lng2);
    }

    /**
     * Calculate distance using Google Maps geometry (more accurate)
     * @param {Object} start - {lat, lng}
     * @param {Object} end - {lat, lng}
     * @returns {number} Distance in meters
     */
    static calculateDistanceWithGoogleMaps(start, end) {
        if (typeof google !== 'undefined' && google.maps && google.maps.geometry) {
            const startLatLng = new google.maps.LatLng(start.lat, start.lng);
            const endLatLng = new google.maps.LatLng(end.lat, end.lng);
            return google.maps.geometry.spherical.computeDistanceBetween(startLatLng, endLatLng);
        }
        
        // Fallback to Haversine
        return this.calculateDistanceInMeters(start.lat, start.lng, end.lat, end.lng);
    }

    /**
     * Check if within radius
     * @param {Object} currentPosition - {lat, lng}
     * @param {Object} destination - {lat, lng}
     * @param {number} radiusMeters - Radius in meters
     * @returns {boolean}
     */
    static isWithinRadius(currentPosition, destination, radiusMeters = 50) {
        const distance = this.calculateDistanceInMeters(
            currentPosition.lat,
            currentPosition.lng,
            destination.lat,
            destination.lng
        );
        
        return distance <= radiusMeters;
    }

    /**
     * Format distance for display
     * @param {number} meters - Distance in meters
     * @returns {string} Formatted string
     */
    static formatDistance(meters) {
        if (meters < 1000) {
            return Math.round(meters) + ' m';
        } else {
            return (meters / 1000).toFixed(1) + ' km';
        }
    }

    /**
     * Format duration for display (based on walking speed)
     * @param {number} meters - Distance in meters
     * @param {number} walkingSpeedMps - Walking speed in meters per second (default: 1.4 m/s)
     * @returns {string} Formatted duration string
     */
    static calculateWalkingTime(meters, walkingSpeedMps = 1.4) {
        const seconds = meters / walkingSpeedMps;
        return this.formatDuration(seconds);
    }

    /**
     * Format driving time (based on average speed)
     * @param {number} meters - Distance in meters
     * @param {number} averageSpeedKmh - Average speed in km/h (default: 30 km/h for city)
     * @returns {string} Formatted duration string
     */
    static calculateDrivingTime(meters, averageSpeedKmh = 30) {
        const metersPerSecond = (averageSpeedKmh * 1000) / 3600;
        const seconds = meters / metersPerSecond;
        return this.formatDuration(seconds);
    }

    /**
     * Format seconds to human readable duration
     * @param {number} seconds 
     * @returns {string}
     */
    static formatDuration(seconds) {
        if (seconds < 60) {
            return Math.round(seconds) + ' sec';
        } else if (seconds < 3600) {
            const minutes = Math.round(seconds / 60);
            return minutes + ' min';
        } else {
            const hours = Math.floor(seconds / 3600);
            const minutes = Math.round((seconds % 3600) / 60);
            return hours + ' hr ' + minutes + ' min';
        }
    }

    /**
     * Calculate bearing between two points
     * @param {number} lat1 
     * @param {number} lng1 
     * @param {number} lat2 
     * @param {number} lng2 
     * @returns {number} Bearing in degrees
     */
    static calculateBearing(lat1, lng1, lat2, lng2) {
        const dLng = this.toRadians(lng2 - lng1);
        const lat1Rad = this.toRadians(lat1);
        const lat2Rad = this.toRadians(lat2);
        
        const y = Math.sin(dLng) * Math.cos(lat2Rad);
        const x = Math.cos(lat1Rad) * Math.sin(lat2Rad) - 
                  Math.sin(lat1Rad) * Math.cos(lat2Rad) * Math.cos(dLng);
        
        let bearing = Math.atan2(y, x);
        bearing = bearing * (180 / Math.PI);
        
        return (bearing + 360) % 360;
    }

    /**
     * Get cardinal direction from bearing
     * @param {number} bearing - Bearing in degrees
     * @returns {string} Cardinal direction
     */
    static getCardinalDirection(bearing) {
        const directions = ['N', 'NE', 'E', 'SE', 'S', 'SW', 'W', 'NW'];
        const index = Math.round(bearing / 45) % 8;
        return directions[index];
    }

    /**
     * Calculate midpoint between two coordinates
     * @param {number} lat1 
     * @param {number} lng1 
     * @param {number} lat2 
     * @param {number} lng2 
     * @returns {Object} Midpoint {lat, lng}
     */
    static calculateMidpoint(lat1, lng1, lat2, lng2) {
        const lat1Rad = this.toRadians(lat1);
        const lng1Rad = this.toRadians(lng1);
        const lat2Rad = this.toRadians(lat2);
        const dLng = this.toRadians(lng2 - lng1);
        
        const bx = Math.cos(lat2Rad) * Math.cos(dLng);
        const by = Math.cos(lat2Rad) * Math.sin(dLng);
        
        const lat3 = Math.atan2(
            Math.sin(lat1Rad) + Math.sin(lat2Rad),
            Math.sqrt((Math.cos(lat1Rad) + bx) * (Math.cos(lat1Rad) + bx) + by * by)
        );
        
        const lng3 = lng1Rad + Math.atan2(by, Math.cos(lat1Rad) + bx);
        
        return {
            lat: lat3 * (180 / Math.PI),
            lng: lng3 * (180 / Math.PI)
        };
    }

    /**
     * Convert degrees to radians
     * @param {number} degrees 
     * @returns {number}
     */
    static toRadians(degrees) {
        return degrees * (Math.PI / 180);
    }

    /**
     * Convert radians to degrees
     * @param {number} radians 
     * @returns {number}
     */
    static toDegrees(radians) {
        return radians * (180 / Math.PI);
    }

    /**
     * Sort locations by distance from a reference point
     * @param {Object} reference - Reference point {lat, lng}
     * @param {Array} locations - Array of locations with lat/lng
     * @returns {Array} Sorted array with distance property added
     */
    static sortByDistance(reference, locations) {
        return locations.map(location => ({
            ...location,
            distance: this.calculateDistanceInMeters(
                reference.lat,
                reference.lng,
                location.lat,
                location.lng
            )
        })).sort((a, b) => a.distance - b.distance);
    }

    /**
     * Filter locations within radius from reference point
     * @param {Object} reference - Reference point {lat, lng}
     * @param {Array} locations - Array of locations
     * @param {number} radiusMeters - Radius in meters
     * @returns {Array} Filtered locations with distance property
     */
    static filterWithinRadius(reference, locations, radiusMeters) {
        return locations
            .map(location => ({
                ...location,
                distance: this.calculateDistanceInMeters(
                    reference.lat,
                    reference.lng,
                    location.lat,
                    location.lng
                )
            }))
            .filter(location => location.distance <= radiusMeters)
            .sort((a, b) => a.distance - b.distance);
    }
}

// Export for use in other modules
window.DistanceCalculator = DistanceCalculator;
