// landing.js

// Hamburger Menu Toggle
document.addEventListener('DOMContentLoaded', () => {
    const hamburger = document.querySelector('.hamburger');
    const navLinks = document.querySelector('.nav-links');

    if (hamburger && navLinks) {
        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            navLinks.classList.toggle('active');
        });
    }
});

// Smooth Scroll for Scroll Down Link
document.querySelector('.scroll-down').addEventListener('click', (e) => {
    e.preventDefault();
    const targetSection = document.querySelector('.top-section');
    if (targetSection) {
        targetSection.scrollIntoView({ behavior: 'smooth' });
    }
});

// Progress Ring Animation (Dynamic Update Example)
function updateProgressRing(percentage) {
    const circle = document.querySelector('.progress-ring__circle-fg');
    const text = document.querySelector('.progress-ring__text');
    if (circle && text) {
        const radius = circle.r.baseVal.value;
        const circumference = 2 * Math.PI * radius;
        const offset = circumference - (percentage / 100) * circumference;
        circle.style.strokeDasharray = `${circumference} ${circumference}`;
        circle.style.strokeDashoffset = offset;
        text.textContent = `${percentage}%`;
    }
}

// Example: Update progress ring to 75% on load
document.addEventListener('DOMContentLoaded', () => {
    updateProgressRing(75); // Matches the 75% in the HTML
});

// Optional: Form Submission Handling for Action Zone
document.querySelector('.action-zone button').addEventListener('click', (e) => {
    e.preventDefault();
    const emailInput = document.querySelector('.action-zone input');
    if (emailInput && emailInput.value) {
        alert(`Email submitted: ${emailInput.value}`);
        emailInput.value = ''; // Clear input after submission
    } else {
        alert('Please enter a valid email address.');
    }
});

// Category Grid Horizontal Scrolling with Drag
document.addEventListener('DOMContentLoaded', () => {
    const categoryGrid = document.querySelector('.scroll-wrapper');
    const leftArrow = document.querySelector('.fa-angle-left');
    const rightArrow = document.querySelector('.fa-angle-right');
    const dragIcon = document.querySelector('.decorative-elements');

    if (categoryGrid && leftArrow && rightArrow && dragIcon) {
        // Arrow click handlers
        leftArrow.addEventListener('click', () => {
            categoryGrid.scrollBy({ left: -200, behavior: 'smooth' });
            updateDragIconState();
        });

        rightArrow.addEventListener('click', () => {
            categoryGrid.scrollBy({ left: 200, behavior: 'smooth' });
            updateDragIconState();
        });

        // Drag functionality
        let isDragging = false;
        let startX;
        let scrollLeft;

        categoryGrid.addEventListener('mousedown', (e) => {
            isDragging = true;
            startX = e.pageX - categoryGrid.offsetLeft;
            scrollLeft = categoryGrid.scrollLeft;
            categoryGrid.style.cursor = 'grabbing';
            dragIcon.classList.add('active'); // Highlight drag icon during drag
        });

        categoryGrid.addEventListener('mouseleave', () => {
            isDragging = false;
            categoryGrid.style.cursor = 'grab';
            dragIcon.classList.remove('active');
        });

        categoryGrid.addEventListener('mouseup', () => {
            isDragging = false;
            categoryGrid.style.cursor = 'grab';
            dragIcon.classList.remove('active');
            updateDragIconState();
        });

        categoryGrid.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            e.preventDefault();
            const x = e.pageX - categoryGrid.offsetLeft;
            const walk = (x - startX) * 2; // Adjust drag speed
            categoryGrid.scrollLeft = scrollLeft - walk;
        });

        // Touch support for mobile
        categoryGrid.addEventListener('touchstart', (e) => {
            isDragging = true;
            startX = e.touches[0].pageX - categoryGrid.offsetLeft;
            scrollLeft = categoryGrid.scrollLeft;
            dragIcon.classList.add('active');
        });

        categoryGrid.addEventListener('touchend', () => {
            isDragging = false;
            dragIcon.classList.remove('active');
            updateDragIconState();
        });

        categoryGrid.addEventListener('touchmove', (e) => {
            if (!isDragging) return;
            const x = e.touches[0].pageX - categoryGrid.offsetLeft;
            const walk = (x - startX) * 2;
            categoryGrid.scrollLeft = scrollLeft - walk;
        });

        // Update drag icon state based on scroll position
        function updateDragIconState() {
            const maxScroll = categoryGrid.scrollWidth - categoryGrid.clientWidth;
            if (categoryGrid.scrollLeft <= 0) {
                leftArrow.style.opacity = '0.5';
                leftArrow.style.pointerEvents = 'none';
            } else {
                leftArrow.style.opacity = '1';
                leftArrow.style.pointerEvents = 'auto';
            }
            if (categoryGrid.scrollLeft >= maxScroll) {
                rightArrow.style.opacity = '0.5';
                rightArrow.style.pointerEvents = 'none';
            } else {
                rightArrow.style.opacity = '1';
                rightArrow.style.pointerEvents = 'auto';
            }
            dragIcon.classList.add('active'); // Keep drag icon active when arrows are used
        }

        // Initialize drag icon state
        categoryGrid.style.cursor = 'grab';
        updateDragIconState();

        // Update state on scroll
        categoryGrid.addEventListener('scroll', updateDragIconState);
    }
});