/**
 * Standalone Hamburger Menu Script
 * Simple, lightweight solution for mobile navigation
 */

document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.querySelector('.hamburger');
    const interactions = document.querySelector('.interactions');
    
    if (!hamburger || !interactions) {
        console.warn('Hamburger menu elements not found');
        return;
    }

    // Toggle menu on hamburger click
    hamburger.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const isOpen = interactions.classList.contains('mobile-open');
        
        if (isOpen) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    // Close menu when clicking a link
    const menuLinks = interactions.querySelectorAll('a');
    menuLinks.forEach(function(link) {
        link.addEventListener('click', function() {
            closeMenu();
        });
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        if (document.body.classList.contains('menu-open')) {
            if (!hamburger.contains(e.target) && !interactions.contains(e.target)) {
                closeMenu();
            }
        }
    });

    // Close menu on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && document.body.classList.contains('menu-open')) {
            closeMenu();
        }
    });

    function openMenu() {
        hamburger.classList.add('active');
        interactions.classList.add('mobile-open');
        document.body.classList.add('menu-open');
    }

    function closeMenu() {
        hamburger.classList.remove('active');
        interactions.classList.remove('mobile-open');
        document.body.classList.remove('menu-open');
    }
});
