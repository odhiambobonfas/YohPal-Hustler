// Add smooth scrolling and interactive elements
document.addEventListener("DOMContentLoaded", function () {
  // Hamburger menu toggle
  const hamburger = document.querySelector(".hamburger");
  const navContainer = document.querySelector(".nav-container");

  hamburger.addEventListener("click", () => {
    hamburger.classList.toggle("active");
    navContainer.classList.toggle("active");
  });

  // Close menu when a link is clicked
  navContainer.querySelectorAll("a").forEach((link) => {
    link.addEventListener("click", () => {
      hamburger.classList.remove("active");
      navContainer.classList.remove("active");
    });
  });

  // Smooth hover effects for buttons
  const buttons = document.querySelectorAll(".btn");
  buttons.forEach((btn) => {
    btn.addEventListener("mouseenter", function () {
      this.style.transform = "translateY(-2px)";
    });
    btn.addEventListener("mouseleave", function () {
      this.style.transform = "translateY(0)";
    });
  });

  // Profile card interaction
  const profileCard = document.querySelector(".profile-card");
  profileCard.addEventListener("mouseenter", function () {
    this.style.transform = "translateY(10px) scale(1.05)";
    this.style.boxShadow = "0 30px 80px rgba(0, 0, 0, 0.15)";
  });
  profileCard.addEventListener("mouseleave", function () {
    this.style.transform = "translateY(20px) scale(1)";
    this.style.boxShadow = "0 20px 40px rgba(0, 0, 0, 0.1)";
  });

  // Add parallax effect to decorative elements
  document.addEventListener("mousemove", function (e) {
    const mouseX = e.clientX / window.innerWidth;
    const mouseY = e.clientY / window.innerHeight;

    const rocket = document.querySelector(".rocket");
    const person = document.querySelector(".person-working");

    if (rocket) {
      rocket.style.transform = `translate(${mouseX * 20}px, ${
        mouseY * 20
      }px) rotate(-5deg)`;
    }
    if (person) {
      person.style.transform = `translate(${mouseX * -15}px, ${
        mouseY * -15
      }px)`;
    }
  });

  // Animate stats on scroll
  const animateStats = () => {
    const stats = document.querySelectorAll(".stat-number");
    stats.forEach((stat) => {
      const finalValue = parseInt(stat.textContent);
      const suffix = stat.textContent.replace(/[0-9]/g, "");
      let currentValue = 0;
      const increment = finalValue / 100;

      const counter = setInterval(() => {
        currentValue += increment;
        if (currentValue >= finalValue) {
          currentValue = finalValue;
          clearInterval(counter);
        }
        stat.textContent = Math.floor(currentValue) + suffix;
      }, 20);
    });
  };

  // Trigger stats animation after a delay
  setTimeout(animateStats, 1000);
});
document.addEventListener("DOMContentLoaded", () => {
  const links = document.querySelectorAll(".nav-links a");

  links.forEach((link) => {
    link.addEventListener("click", (e) => {
      e.preventDefault(); // Prevent default anchor behavior (remove if you want navigation)

      // Remove active class from all links
      links.forEach((l) => l.classList.remove("active"));

      // Add active class to the clicked link
      link.classList.add("active");
    });
  });
});
