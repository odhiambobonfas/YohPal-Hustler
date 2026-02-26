/**
 * Mobile Responsive JavaScript Enhancements
 * Handles touch events, viewport adjustments, and mobile-specific functionality
 */

(function() {
    'use strict';

    // Detect mobile device
    const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    const isTouch = 'ontouchstart' in window || navigator.maxTouchPoints > 0;

    // Add mobile class to body
    if (isMobile || isTouch) {
        document.body.classList.add('is-mobile');
    }

    // Prevent zoom on input focus (iOS)
    function preventZoom() {
        const viewportMeta = document.querySelector('meta[name="viewport"]');
        if (viewportMeta && isMobile) {
            const inputs = document.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                input.addEventListener('focus', () => {
                    viewportMeta.setAttribute('content', 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no');
                });
                input.addEventListener('blur', () => {
                    viewportMeta.setAttribute('content', 'width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes');
                });
            });
        }
    }

    // Handle hamburger menu toggle
    function initMobileMenu() {
        const hamburger = document.querySelector('.hamburger');
        const interactions = document.querySelector('.interactions');
        
        if (!hamburger || !interactions) return;
        
        hamburger.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            this.classList.toggle('active');
            interactions.classList.toggle('mobile-open');
            document.body.classList.toggle('menu-open');
        });

        // Close menu when clicking a link
        const menuLinks = interactions.querySelectorAll('a');
        menuLinks.forEach(link => {
            link.addEventListener('click', function() {
                hamburger.classList.remove('active');
                interactions.classList.remove('mobile-open');
                document.body.classList.remove('menu-open');
            });
        });

        // Close menu when clicking overlay
        document.addEventListener('click', function(e) {
            if (document.body.classList.contains('menu-open') && 
                !hamburger.contains(e.target) && 
                !interactions.contains(e.target)) {
                hamburger.classList.remove('active');
                interactions.classList.remove('mobile-open');
                document.body.classList.remove('menu-open');
            }
        });
    }

    // Add touch event support for buttons
    function enhanceTouchEvents() {
        const buttons = document.querySelectorAll('.btn, button, a[href]');
        
        buttons.forEach(button => {
            // Add active state on touch
            button.addEventListener('touchstart', function() {
                this.classList.add('touch-active');
            }, { passive: true });
            
            button.addEventListener('touchend', function() {
                setTimeout(() => {
                    this.classList.remove('touch-active');
                }, 150);
            }, { passive: true });
        });
    }

    // Smooth scroll for anchor links
    function initSmoothScroll() {
        const links = document.querySelectorAll('a[href^="#"]');
        
        links.forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href === '#') return;
                
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    const offsetTop = target.offsetTop - 60; // Account for fixed navbar
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }

    // Handle scroll wrapper touch scrolling
    function initScrollWrapper() {
        const scrollWrappers = document.querySelectorAll('.scroll-wrapper');
        
        scrollWrappers.forEach(wrapper => {
            let isDown = false;
            let startX;
            let scrollLeft;

            wrapper.addEventListener('touchstart', (e) => {
                isDown = true;
                startX = e.touches[0].pageX - wrapper.offsetLeft;
                scrollLeft = wrapper.scrollLeft;
            }, { passive: true });

            wrapper.addEventListener('touchend', () => {
                isDown = false;
            }, { passive: true });

            wrapper.addEventListener('touchmove', (e) => {
                if (!isDown) return;
                const x = e.touches[0].pageX - wrapper.offsetLeft;
                const walk = (x - startX) * 2;
                wrapper.scrollLeft = scrollLeft - walk;
            }, { passive: true });
        });
    }

    // Fix viewport height for mobile browsers
    function setVH() {
        const vh = window.innerHeight * 0.01;
        document.documentElement.style.setProperty('--vh', `${vh}px`);
    }

    // Handle orientation change
    function handleOrientationChange() {
        setVH();
        
        // Force reflow
        setTimeout(() => {
            window.scrollTo(0, window.scrollY + 1);
            window.scrollTo(0, window.scrollY - 1);
        }, 100);
    }

    // Lazy load images
    function initLazyLoad() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.removeAttribute('data-src');
                        }
                        observer.unobserve(img);
                    }
                });
            });

            const images = document.querySelectorAll('img[data-src]');
            images.forEach(img => imageObserver.observe(img));
        }
    }

    // Debounce function for resize events
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Initialize all mobile enhancements
    function init() {
        preventZoom();
        initMobileMenu();
        enhanceTouchEvents();
        initSmoothScroll();
        initScrollWrapper();
        setVH();
        initLazyLoad();

        // Handle resize and orientation change
        window.addEventListener('resize', debounce(setVH, 100));
        window.addEventListener('orientationchange', handleOrientationChange);

        // Log device info for debugging
        if (window.location.hostname !== 'localhost' && window.location.hostname !== '127.0.0.1') {
            console.log('Device Info:', {
                isMobile,
                isTouch,
                userAgent: navigator.userAgent,
                screenWidth: window.screen.width,
                screenHeight: window.screen.height,
                viewportWidth: window.innerWidth,
                viewportHeight: window.innerHeight
            });
        }
    }

    // Run on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
