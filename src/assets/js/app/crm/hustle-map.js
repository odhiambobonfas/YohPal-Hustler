class HustleMap extends Master { 
    constructor(
        mapInstance, 
        travelMode = 'Walking', 
        clientLabel="Client", 
        targetLabel='Hustler', 
        icons={
            targetDestinationIcon: "http://maps.google.com/mapfiles/ms/icons/green-dot.png",
            startLocationIcon: "http://maps.google.com/mapfiles/ms/icons/red-dot.png"
        }, 
        stepsCount=50
    ) {
        super();
        this.mapInstance = mapInstance; 
        this.travelMode = travelMode;  // or WALKING, BICYCLING, TRANSIT
        this.targetLabel = targetLabel;
        this.clientLabel = clientLabel;
        this.targetDestinationIcon = icons.targetDestinationIcon;
        this.startLocationIcon = icons.startLocationIcon;
        this.stepsCount = stepsCount;
        this.totalDistance = 0;
        this.totalMinutes = 0; 
        this.targetMarker = null;
        this.clientMarker = null; 
        this.path = [];
        this.currentIndex = 0; 
        this.directionsService = undefined;
        this.directionsRenderer = undefined;
        this.intGoogleMapApiDirectionService();
    }

    /**
     * This function uses the Google MAP API to set up and lay out the Client 
     * Directions and Mark and map the routes to be taken.
     * 
     * @param {Object} locales 
     */
    layOutMap(locales) {
        let {clientStartLocation, clientDestinationLocation} = locales; 

        this.clientStartLocation = new google.maps.LatLng(clientStartLocation.latitude, clientStartLocation.longitude);
        this.clientDestinationLocation = new google.maps.LatLng(clientDestinationLocation.latitude, clientDestinationLocation.longitude);
        
        this.targetMarker = new google.maps.Marker({
            position: this.clientDestinationLocation,
            map: this.mapInstance,
            label: this.targetLabel, 
        }); 
    }

    /**
     * Calculates latitude and longitude step after a step, & returns an array
     * of points respectively.
     * 
     * @param {Object} startLocation 
     * @param {Object} endLocation 
     * @param {int} stepsCount 
     * @returns {Array} points - mapped points per step
     */
    calculateIntermediatePoints(startLocation, endLocation, stepsCount) {  
        const latitudeStep = (endLocation.lat() - startLocation.lat()) / (stepsCount - 1);
        const longitudeStep = (endLocation.lng() - startLocation.lng()) / (stepsCount - 1);

        const points = [];
        for (let i = 0; i <= stepsCount; i++) {
            points.push({
                lat: startLocation.lat() + (latitudeStep * i),
                lng: startLocation.lng() + (longitudeStep * i)
            });
        }
        
        return points;
    }

    /**
     * Animates, sets position for a client marker, and uses google map computeDistanceBetween function
     * to compute the distance taken per step taken.
     * 
     * @returns {void} void  
     */
    animateMovement() {
        if (this.currentIndex >= this.path.length) return;

        const nextPos = this.path[this.currentIndex];
        
        if (nextPos.lat && nextPos.lng) {
            this.clientMarker.setPosition(new google.maps.LatLng(nextPos.lat, nextPos.lng)); 
        
            const distance = google.maps.geometry.spherical.computeDistanceBetween(
                this.clientMarker.getPosition(),
                this.targetMarker.getPosition()
            ); 
    
            this.currentIndex++;
            setTimeout(() => this.animateMovement(), 300);
        }
    }

    /**
     * Initializes the Direction service as well as direction renderer API.
     * The instances are supposed to be used globally but internally(this class)
     * 
     * @returns {void} void
     */
    intGoogleMapApiDirectionService() {
        this.directionsService = new google.maps.DirectionsService();
        this.directionsRenderer = new google.maps.DirectionsRenderer({
            map: this.mapInstance,
            suppressMarkers: true,
            polylineOptions: {
                strokeColor: '#dc3545',
                strokeOpacity: 0.8,
                strokeWeight: 6
            }
        }); 
    }

    /**
     * Gets the route of both the Client and the Target(Me), & Computes the time and distance between
     * the starting point and the destination.
     * 
     * @returns {void} void
     */
    getRoadRoute() {  
        this.directionsService.route({
            origin: this.clientStartLocation,
            destination: this.clientDestinationLocation,
            travelMode: google.maps.TravelMode[this.travelMode.toUpperCase()]
        }, (response, status) => {
            if (status === 'OK') {
                this.directionsRenderer.setDirections(response);
                this.calculateTimeToBeTaken(response);
                this.calculateDistanceTimeToBeTaken(response);
                __append_html(
                    `${(this.totalDistance).toFixed(2)} M`, 
                    document.querySelector('.client-distance-remaining')
                ); 
                __append_html(
                    `${(this.totalMinutes).toFixed(2)} Minutes`, 
                    document.querySelector('.client-time-to-take')
                ); 
            } else {
                console.error('Directions request failed due to ' + status);
            }
        });
    }

    /***
     * Utilizes the get route function response to calculate the time to be taken
     * on the respective two points, starting point and the destination point.
     * 
     * @returns {void} void
     */
    calculateTimeToBeTaken(response) {
        const duration = response.routes[0].legs[0].duration;   
        this.totalMinutes = duration.value / 60; 
    }
        
    /***
     * Utilizes the get route function response to calculate the distance between the starting point
     * and the destination point.
     * 
     * @returns {void} void
     */
    calculateDistanceTimeToBeTaken(response) {
        const totalDistance = response.routes[0].legs[0].distance;;
        this.totalDistance = parseFloat(totalDistance.text);  
    }
}

document.addEventListener('DOMContentLoaded', () => {
    let hustleMapInstance = new HustleMap();
    hustleMapInstance.setMapOnPage(); 
});