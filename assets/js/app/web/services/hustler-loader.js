import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
import { getFirestore, collection, getDocs, query, where } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-firestore.js";
import { firebaseConfig } from "../config/firebase-config.js";

let app = null;
let db = null;

try {
    app = initializeApp(firebaseConfig);
    db = getFirestore(app);
} catch (error) {
    console.error("Firebase initialization error:", error);
}

class HustlerLoaderService {
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
            if (!db) {
                throw new Error("Firebase not initialized. Please check firebase-config.js");
            }

            const hustlersRef = collection(db, "hustle", "userIds");
            const snapshot = await getDocs(hustlersRef);
            this.hustlers = [];

            snapshot.forEach((doc) => {
                const data = doc.data();
                const location = data.liveLocation;
                
                if (location && location.latitude && location.longitude && data.accountStatus === 'approved') {
                    this.hustlers.push({
                        id: doc.id,
                        displayName: data.displayName || data.name || 'Hustler',
                        name: data.name || data.displayName || 'Hustler',
                        profilePicture: data.profilePicture || data.photoURL || data.avatar,
                        lat: location.latitude,
                        lng: location.longitude,
                        primarySkill: data.primarySkill || 'General',
                        skills: data.skills || [],
                        averageRating: data.averageRating || data.rating || 0,
                        pricing: data.pricing || 'N/A',
                        pricingType: data.pricingType || 'Hourly',
                        workBio: data.workBio || '',
                        primaryLocation: data.primaryLocation || '',
                        isDocumentsVerified: data.isDocumentsVerified || false,
                        availability: data.availability || {}
                    });
                }
            });

            console.log(`Loaded ${this.hustlers.length} hustlers from Firebase`);
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

            const marker = new google.maps.Marker({
                position: { lat: hustler.lat, lng: hustler.lng },
                map: this.map,
                title: hustler.displayName || hustler.name || "Hustler",
                icon: {
                    url: hustler.profilePicture || hustler.photoURL || "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
                    scaledSize: new google.maps.Size(40, 40),
                    anchor: new google.maps.Point(20, 40)
                },
                animation: google.maps.Animation.DROP
            });

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
        const rating = hustler.averageRating || hustler.rating || 0;
        const profilePic = hustler.profilePicture || hustler.photoURL || "/assets/store/images/avatars/default-avatar.jpg";
        
        return `
            <div class="card border-0" style="width: 250px;">
                <div class="card-body p-2">
                    <div class="d-flex align-items-center mb-2">
                        <img src="${profilePic}" 
                             class="rounded-circle me-2" 
                             style="width: 50px; height: 50px; object-fit: cover;"
                             onerror="this.src='/assets/store/images/avatars/default-avatar.jpg'">
                        <div>
                            <h6 class="mb-0">${hustler.displayName || hustler.name || "Hustler"}</h6>
                            <small class="text-muted">${hustler.primarySkill || "General"}</small>
                        </div>
                    </div>
                    <div class="mb-1">
                        <span class="text-warning">${"⭐".repeat(Math.floor(rating))}</span>
                        <span class="text-muted">${rating.toFixed(1)}</span>
                    </div>
                    <div class="mb-1 small text-muted">
                        <i class="fas fa-road"></i> ${this.formatDistance(distance)} away
                    </div>
                    <div class="mb-2 small text-muted">
                        <i class="fas fa-walking"></i> ~${eta} min walk
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

        const rating = hustler.averageRating || hustler.rating || 0;
        const profilePic = hustler.profilePicture || hustler.photoURL || "/assets/store/images/avatars/default-avatar.jpg";

        document.getElementById("overlay-avatar").src = profilePic;
        document.getElementById("overlay-name").textContent = hustler.displayName || hustler.name || "Hustler";
        document.getElementById("overlay-skill").textContent = hustler.primarySkill || "General";
        document.getElementById("overlay-rating-value").textContent = rating.toFixed(1);
        document.getElementById("overlay-distance").textContent = this.formatDistance(distance);
        document.getElementById("overlay-eta").textContent = `${eta} min`;

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

window.HustlerLoaderService = HustlerLoaderService;
export default HustlerLoaderService;
