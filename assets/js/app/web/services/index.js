/**
 * Web Location Services Index
 * Central export point for all location-related services
 */

// Services
window.LocationServices = {
    LocationService: window.LocationService,
    GeocodingService: window.GeocodingService,
    RealtimeLocationService: window.RealtimeLocationService,
    DistanceCalculator: window.DistanceCalculator,
    PolylineRenderer: window.PolylineRenderer
};

// Create convenience instances
window.locationService = new window.LocationService();
window.geocodingService = new window.geocodingService || new window.GeocodingService();
window.realtimeLocationService = new window.RealtimeLocationService();

console.log('Location services loaded successfully');
