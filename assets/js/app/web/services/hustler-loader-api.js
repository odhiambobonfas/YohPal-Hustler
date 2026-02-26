class HustlerLoaderServiceAPI {
    constructor() {
        this.hustlers = [];
        this.map = null;
        this.userLocation = null;
        this.markers = [];
        this.infoWindows = [];
    }

    setMap(mapInstance) {
        this.map = mapInstance;
        window._currentMap = mapInstance;
    }

    setUserLocation(lat, lng) {
        this.userLocation = { lat, lng };
    }

    async loadAllHustlers(category = null) {
        try {
            const url = '/crm/users/hustlers';
            const response = await fetch(url);
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }

            const data = await response.json();
            
            if (data.error || data.status === 'error') {
                throw new Error(data.message || 'Failed to load hustlers');
            }

            const hustlersList = data.hustlers || data.data || data.users || [];
            
            this.hustlers = hustlersList.filter(h => 
                h.location && (h.location.latitude || h.location._latitude || h.latitude)
            ).map(h => ({
                id: h.id || h.userId || h.user_id,
                displayName: h.displayName || h.name || (h.firstName ? h.firstName + ' ' + (h.lastName || '') : 'Hustler'),
                name: h.name || h.firstName || 'Hustler',
                profilePicture: h.profilePicture || h.photoURL || h.profile_picture || h.avatar,
                lat: h.location?.latitude || h.location?._latitude || h.latitude,
                lng: h.location?.longitude || h.location?._longitude || h.longitude,
                primarySkill: h.primarySkill || h.skill || h.category || 'General',
                averageRating: h.averageRating || h.rating || h.rate || 0,
                pricing: h.pricing || h.rate || h.hourlyRate || 'N/A',
                pricingType: h.pricingType || 'hourly'
            }));

            console.log(`Loaded ${this.hustlers.length} hustlers from API`);
            return this.hustlers;
        } catch (error) {
            console.error("Error loading hustlers:", error);
            throw error;
        }
    }

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

    toRadians(degrees) {
        return degrees * (Math.PI / 180);
    }

    formatDistance(meters) {
        if (meters < 1000) {
            return `${Math.round(meters)} m`;
        }
        return `${(meters / 1000).toFixed(1)} km`;
    }

    calculateETA(distanceMeters, speedKmh = 5) {
        const hours = (distanceMeters / 1000) / speedKmh;
        const minutes = Math.round(hours * 60);
        return minutes;
    }

    displayHustlersOnMap() {
        if (!this.map || !this.userLocation) {
            console.error("Map or user location not set");
            return;
        }

        this.clearMarkers();

        this.hustlers.forEach((hustler) => {
            const distance = this.calculateDistance(
                this.userLocation.lat,
                this.userLocation.lng,
                hustler.lat,
                hustler.lng
            );

            const eta = this.calculateETA(distance);

            // Create custom marker with circular profile photo
            const markerIcon = {
                url: hustler.profilePicture || "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
                scaledSize: new google.maps.Size(50, 50),
                anchor: new google.maps.Point(25, 50)
            };

            const marker = new google.maps.Marker({
                position: { lat: hustler.lat, lng: hustler.lng },
                map: this.map,
                title: hustler.displayName || hustler.name || "Hustler",
                icon: markerIcon,
                animation: google.maps.Animation.DROP,
                label: {
                    text: hustler.displayName || hustler.name || "H",
                    color: "#FFFFFF",
                    fontSize: "0px",
                    fontWeight: "bold"
                }
            });

            // Add name label below marker
            const labelOverlay = new google.maps.OverlayView();
            labelOverlay.onAdd = function() {
                const div = document.createElement('div');
                div.style.position = 'absolute';
                div.style.backgroundColor = 'rgba(0, 0, 0, 0.7)';
                div.style.color = 'white';
                div.style.padding = '2px 6px';
                div.style.borderRadius = '3px';
                div.style.fontSize = '11px';
                div.style.fontWeight = 'bold';
                div.style.whiteSpace = 'nowrap';
                div.textContent = hustler.displayName || hustler.name || "Hustler";
                this.div = div;
                const panes = this.getPanes();
                panes.overlayLayer.appendChild(div);
            };
            
            labelOverlay.draw = function() {
                const projection = this.getProjection();
                const position = projection.fromLatLngToDivPixel(marker.getPosition());
                if (this.div) {
                    this.div.style.left = (position.x - this.div.offsetWidth / 2) + 'px';
                    this.div.style.top = (position.y + 5) + 'px';
                }
            };
            
            labelOverlay.onRemove = function() {
                if (this.div) {
                    this.div.parentNode.removeChild(this.div);
                    this.div = null;
                }
            };
            
            labelOverlay.setMap(this.map);

            const infoContent = this.createInfoWindowContent(hustler, distance, eta);
            const infoWindow = new google.maps.InfoWindow({
                content: infoContent
            });

            marker.addListener("click", () => {
                this.closeAllInfoWindows();
                infoWindow.open(this.map, marker);
                this.showHustlerOverlay(hustler, distance, eta);
            });

            this.markers.push(marker);
            this.infoWindows.push(infoWindow);
        });

        this.fitMapBounds();
    }

    createInfoWindowContent(hustler, distance, eta) {
        const rating = hustler.averageRating || 0;
        const profilePic = hustler.profilePicture || "/assets/store/images/avatars/default-avatar.jpg";
        
        // Calculate ETA for different modes
        const walkingETA = this.calculateETA(distance, 5); // 5 km/h
        const bikeETA = this.calculateETA(distance, 15); // 15 km/h
        const carETA = this.calculateETA(distance, 40); // 40 km/h
        const busETA = this.calculateETA(distance, 25); // 25 km/h
        
        return `
            <div class="card border-0" style="width: 280px;">
                <div class="card-body p-2">
                    <div class="d-flex align-items-center mb-2">
                        <img src="${profilePic}" 
                             class="rounded-circle me-2" 
                             style="width: 50px; height: 50px; object-fit: cover; border: 2px solid #4285F4;"
                             onerror="this.src='/assets/store/images/avatars/default-avatar.jpg'">
                        <div>
                            <h6 class="mb-0">${hustler.displayName || "Hustler"}</h6>
                            <small class="text-muted">${hustler.primarySkill}</small>
                        </div>
                    </div>
                    <div class="mb-2">
                        <span class="text-warning">${"⭐".repeat(Math.floor(rating))}</span>
                        <span class="text-muted">${rating.toFixed(1)}</span>
                    </div>
                    <div class="mb-2 small">
                        <div class="text-muted mb-1"><strong>Distance:</strong> ${this.formatDistance(distance)}</div>
                        <div class="d-flex align-items-center mb-1">
                            <i class="fas fa-walking text-primary" style="width: 20px;"></i>
                            <span class="text-muted ms-1">${walkingETA} min</span>
                        </div>
                        <div class="d-flex align-items-center mb-1">
                            <i class="fas fa-motorcycle text-danger" style="width: 20px;"></i>
                            <span class="text-muted ms-1">${bikeETA} min</span>
                        </div>
                        <div class="d-flex align-items-center mb-1">
                            <i class="fas fa-car text-success" style="width: 20px;"></i>
                            <span class="text-muted ms-1">${carETA} min</span>
                        </div>
                        <div class="d-flex align-items-center mb-1">
                            <i class="fas fa-bus text-warning" style="width: 20px;"></i>
                            <span class="text-muted ms-1">${busETA} min</span>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-sm w-100" onclick="window.selectHustler('${hustler.id}')">
                        Request Hustler
                    </button>
                </div>
            </div>
        `;
    }

    showHustlerOverlay(hustler, distance, eta) {
        const overlay = document.getElementById("hustler-overlay");
        if (!overlay) return;

        const rating = hustler.averageRating || 0;
        const profilePic = hustler.profilePicture || "/assets/store/images/avatars/default-avatar.jpg";

        // Calculate all transport modes
        const walkingETA = this.calculateETA(distance, 5);
        const bikeETA = this.calculateETA(distance, 15);
        const carETA = this.calculateETA(distance, 40);
        const busETA = this.calculateETA(distance, 25);

        document.getElementById("overlay-avatar").src = profilePic;
        document.getElementById("overlay-name").textContent = hustler.displayName || "Hustler";
        document.getElementById("overlay-skill").textContent = hustler.primarySkill;
        document.getElementById("overlay-rating-value").textContent = rating.toFixed(1);
        document.getElementById("overlay-distance").textContent = this.formatDistance(distance);
        document.getElementById("overlay-eta").textContent = `Walk: ${walkingETA}m | Bike: ${bikeETA}m | Car: ${carETA}m | Bus: ${busETA}m`;

        const requestBtn = document.getElementById("overlay-request-btn");
        requestBtn.onclick = () => window.selectHustler(hustler.id);

        overlay.classList.remove("d-none");
    }

    closeAllInfoWindows() {
        this.infoWindows.forEach(iw => iw.close());
    }

    clearMarkers() {
        this.markers.forEach(marker => marker.setMap(null));
        this.markers = [];
        this.infoWindows = [];
    }

    fitMapBounds() {
        if (!this.map || this.markers.length === 0) return;

        const bounds = new google.maps.LatLngBounds();
        
        if (this.userLocation) {
            bounds.extend(new google.maps.LatLng(this.userLocation.lat, this.userLocation.lng));
        }

        this.markers.forEach(marker => {
            bounds.extend(marker.getPosition());
        });

        this.map.fitBounds(bounds);
    }

    getHustlerById(hustlerId) {
        return this.hustlers.find(h => h.id === hustlerId);
    }
}

window.HustlerLoaderServiceAPI = HustlerLoaderServiceAPI;
