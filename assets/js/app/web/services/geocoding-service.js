/**
 * Geocoding Service
 * Handles address to coordinates conversion and reverse geocoding
 * Mirrors the Flutter location_service.dart functionality
 */

class GeocodingService {
    constructor() {
        this.geocoder = null;
        this.apiKey = null;
        
        // Initialize geocoder if Google Maps is available
        if (typeof google !== 'undefined' && google.maps) {
            this.geocoder = new google.maps.Geocoder();
        }
    }

    /**
     * Initialize with Google Maps API key
     * @param {string} apiKey - Google Maps API key
     */
    init(apiKey) {
        this.apiKey = apiKey;
    }

    /**
     * Get address from coordinates (reverse geocoding)
     * @param {number} latitude 
     * @param {number} longitude 
     * @returns {Promise<string>} Address string
     */
    async getAddressFromCoordinates(latitude, longitude) {
        return new Promise((resolve, reject) => {
            if (!this.geocoder) {
                console.warn("Geocoder not initialized");
                resolve("");
                return;
            }

            const latlng = { lat: latitude, lng: longitude };

            this.geocoder.geocode({ location: latlng }, (results, status) => {
                if (status === 'OK' && results[0]) {
                    resolve(results[0].formatted_address);
                } else {
                    console.warn('Geocoding failed: ' + status);
                    resolve("");
                }
            });
        });
    }

    /**
     * Get coordinates from address (forward geocoding)
     * @param {string} address - Address string
     * @returns {Promise<Object>} Object with lat and lng
     */
    async getCoordinatesFromAddress(address) {
        return new Promise((resolve, reject) => {
            if (!this.geocoder) {
                console.warn("Geocoder not initialized");
                resolve({ lat: 0, lng: 0 });
                return;
            }

            this.geocoder.geocode({ address: address }, (results, status) => {
                if (status === 'OK' && results[0]) {
                    const location = results[0].geometry.location;
                    resolve({
                        lat: location.lat(),
                        lng: location.lng(),
                        formattedAddress: results[0].formatted_address,
                        placeId: results[0].place_id
                    });
                } else {
                    console.warn('Geocoding failed: ' + status);
                    resolve({ lat: 0, lng: 0 });
                }
            });
        });
    }

    /**
     * Get current address using device location
     * @returns {Promise<string>} Current address
     */
    async getCurrentAddress() {
        return new Promise(async (resolve, reject) => {
            if (typeof window.LocationService !== 'undefined') {
                const locationService = new window.LocationService();
                const position = await locationService.getCurrentLocation();
                
                const address = await this.getAddressFromCoordinates(
                    position.lat,
                    position.lng
                );
                
                resolve(address);
            } else {
                console.warn("LocationService not available");
                resolve("");
            }
        });
    }

    /**
     * Get place details from place ID
     * @param {string} placeId - Google Places place ID
     * @returns {Promise<Object>} Place details
     */
    async getPlaceDetails(placeId) {
        return new Promise((resolve, reject) => {
            if (!this.geocoder) {
                resolve(null);
                return;
            }

            const request = {
                placeId: placeId,
                fields: ['name', 'formatted_address', 'geometry', 'address_components', 'place_id']
            };

            this.geocoder.geocode(request, (results, status) => {
                if (status === 'OK' && results[0]) {
                    resolve({
                        address: results[0].formatted_address,
                        name: results[0].name,
                        location: {
                            lat: results[0].geometry.location.lat(),
                            lng: results[0].geometry.location.lng()
                        },
                        placeId: results[0].place_id,
                        addressComponents: results[0].address_components
                    });
                } else {
                    resolve(null);
                }
            });
        });
    }

    /**
     * Search for places matching query
     * @param {string} query - Search query
     * @returns {Promise<Array>} Array of place predictions
     */
    async searchPlaces(query) {
        return new Promise((resolve) => {
            if (typeof google === 'undefined' || !google.maps.places) {
                resolve([]);
                return;
            }

            const autocompleteService = new google.maps.places.AutocompleteService();
            
            autocompleteService.getPlacePredictions(
                {
                    input: query,
                    componentRestrictions: { country: 'ke' }, // Kenya
                    types: ['address', 'establishment']
                },
                (predictions, status) => {
                    if (status === google.maps.places.PlacesServiceStatus.OK && predictions) {
                        resolve(predictions.map(prediction => ({
                            description: prediction.description,
                            placeId: prediction.place_id,
                            structuredFormatting: prediction.structured_formatting
                        })));
                    } else {
                        resolve([]);
                    }
                }
            );
        });
    }

    /**
     * Get location components (city, county, country) from coordinates
     * @param {number} latitude 
     * @param {number} longitude 
     * @returns {Promise<Object>} Location components
     */
    async getLocationComponents(latitude, longitude) {
        return new Promise((resolve) => {
            if (!this.geocoder) {
                resolve({});
                return;
            }

            const latlng = { lat: latitude, lng: longitude };

            this.geocoder.geocode({ location: latlng }, (results, status) => {
                if (status === 'OK' && results[0]) {
                    const components = {
                        country: '',
                        county: '',
                        city: '',
                        sublocality: '',
                        street: '',
                        formattedAddress: results[0].formatted_address
                    };

                    results[0].address_components.forEach(component => {
                        if (component.types.includes('country')) {
                            components.country = component.long_name;
                        }
                        if (component.types.includes('administrative_area_level_1')) {
                            components.county = component.long_name;
                        }
                        if (component.types.includes('locality')) {
                            components.city = component.long_name;
                        }
                        if (component.types.includes('sublocality')) {
                            components.sublocality = component.long_name;
                        }
                        if (component.types.includes('route')) {
                            components.street = component.long_name;
                        }
                    });

                    resolve(components);
                } else {
                    resolve({});
                }
            });
        });
    }

    /**
     * Format location for display
     * @param {Object} location - {lat, lng}
     * @returns {Promise<string>} Formatted location string
     */
    async formatLocation(location) {
        if (!location || !location.lat || !location.lng) {
            return 'Location unavailable';
        }

        const components = await this.getLocationComponents(location.lat, location.lng);
        
        if (components.city) {
            return components.city + (components.county ? ', ' + components.county : '');
        }
        
        if (components.sublocality) {
            return components.sublocality;
        }

        return await this.getAddressFromCoordinates(location.lat, location.lng);
    }
}

// Export for use in other modules
window.GeocodingService = GeocodingService;