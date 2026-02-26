// Google Maps Error Handler and Fallback
(function() {
    'use strict';
    
    // Handle Google Maps loading errors
    window.gm_authFailure = function() {
        console.error('Google Maps authentication failed');
        showMapError('Google Maps API key issue. Using fallback mode.');
    };
    
    // Check if Google Maps loaded after timeout
    setTimeout(function() {
        if (typeof google === 'undefined' || !google.maps) {
            console.error('Google Maps failed to load');
            showMapError('Google Maps failed to load. Check your connection.');
        }
    }, 5000);
    
    function showMapError(message) {
        const mapElements = document.querySelectorAll('[id*="map"], [class*="map"]');
        mapElements.forEach(function(el) {
            if (el.offsetHeight > 100) {
                el.innerHTML = '<div style="display:flex;flex-direction:column;align-items:center;justify-content:center;height:100%;background:#f5f5f5;padding:20px;text-align:center;">' +
                    '<div style="font-size:48px;margin-bottom:20px;">🗺️</div>' +
                    '<h3 style="color:#333;margin-bottom:10px;">Map Unavailable</h3>' +
                    '<p style="color:#666;margin-bottom:20px;">' + message + '</p>' +
                    '<button onclick="location.reload()" style="background:#4CAF50;color:white;border:none;padding:12px 24px;border-radius:4px;cursor:pointer;font-size:16px;">Retry</button>' +
                    '</div>';
            }
        });
    }
    
    // Get user location without map
    window.getUserLocationFallback = function(callback) {
        if (!navigator.geolocation) {
            alert('Geolocation is not supported by your browser');
            return;
        }
        
        navigator.geolocation.getCurrentPosition(
            function(position) {
                callback({
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                    accuracy: position.coords.accuracy
                });
            },
            function(error) {
                alert('Location error: ' + error.message);
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
        );
    };
})();
