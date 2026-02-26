(function() {
    'use strict';
    
    function initSidebarToggle() {
        const sidebar = document.querySelector('.sidebar');
        const menuToggle = document.querySelector('.menu-toggle');
        
        if (!sidebar || !menuToggle) {
            console.warn('Sidebar or menu toggle not found');
            return false;
        }
        
        function toggleSidebar(e) {
            if (e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            const isActive = sidebar.classList.contains('active');
            
            if (isActive) {
                sidebar.classList.remove('active');
                document.body.classList.remove('sidebar-open');
            } else {
                sidebar.classList.add('active');
                document.body.classList.add('sidebar-open');
            }
        }
        
        // Multiple event listeners for maximum compatibility
        menuToggle.addEventListener('click', toggleSidebar, { passive: false });
        menuToggle.addEventListener('touchstart', function(e) {
            e.preventDefault();
            toggleSidebar(e);
        }, { passive: false });
        
        function closeOnOutsideClick(e) {
            if (sidebar.classList.contains('active') && 
                !sidebar.contains(e.target) && 
                !menuToggle.contains(e.target)) {
                sidebar.classList.remove('active');
                document.body.classList.remove('sidebar-open');
            }
        }
        
        document.addEventListener('click', closeOnOutsideClick);
        document.addEventListener('touchstart', closeOnOutsideClick);
        
        // Close sidebar when clicking links
        sidebar.querySelectorAll('a, .sidebar-item').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 992) {
                    setTimeout(() => {
                        sidebar.classList.remove('active');
                        document.body.classList.remove('sidebar-open');
                    }, 100);
                }
            });
        });
        
        console.log('Sidebar toggle initialized');
        return true;
    }
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSidebarToggle);
    } else {
        initSidebarToggle();
    }
})();
