// Fix mobile menu dropdown issues
document.addEventListener('DOMContentLoaded', function() {
    // Fix Bootstrap dropdown on mobile
    const mobileDropdownToggle = document.getElementById('navbarDropdownToggle');
    
    if (mobileDropdownToggle) {
        // Remove any existing listeners
        const newToggle = mobileDropdownToggle.cloneNode(true);
        mobileDropdownToggle.parentNode.replaceChild(newToggle, mobileDropdownToggle);
        
        // Add touch-friendly click handler
        newToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const dropdown = this.nextElementSibling;
            const isShown = dropdown.classList.contains('show');
            
            // Close all other dropdowns
            document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                menu.classList.remove('show');
            });
            
            // Toggle this dropdown
            if (!isShown) {
                dropdown.classList.add('show');
            }
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                    menu.classList.remove('show');
                });
            }
        });
    }
    
    // Fix all dropdown toggles
    document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(toggle => {
        toggle.addEventListener('touchstart', function(e) {
            e.preventDefault();
            this.click();
        }, { passive: false });
    });
});
