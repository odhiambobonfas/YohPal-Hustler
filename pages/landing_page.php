<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YohPal - Hire the Top 3% of Talent</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #ff4757 0%, #ff3742 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .banner {
            background: rgba(255, 255, 255);
            color: black;
            text-align: center;
            padding: 10px;
            font-size: 14px;
        }

        .banner a {
            color: red;
            text-decoration: underline;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 50px;
            background: gray;
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 1000;
            /* Ensure navbar stays above hero section */
        }

        .logo {
            color: white;
            display: flex;
            font-size: 22px;
            gap: 10px;
            font-weight: bold;
        }

        .logo img {
            margin-top: -10px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 30px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.3s;
        }

        .nav-links a:hover {
            opacity: 0.8;
        }

        .nav-right {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: #ff4757;
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(255, 255, 255, 0.2);
        }

        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-secondary:hover {
            background: white;
            color: #ff4757;
        }

        .hero-section {
            display: flex;
            align-items: center;
            padding: 80px 50px;
            min-height: 80vh;
            position: relative;
            background-color: white;
            z-index: 1;
            /* Lower z-index than navbar */
        }

        .hero-content {
            flex: 1;
            color: black;
            z-index: 2;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: bold;
            line-height: 1.1;
            margin-bottom: 30px;
        }

        .hero-title .highlight {
            text-decoration: underline;
            text-decoration-color: white;
            text-decoration-thickness: 4px;
            text-underline-offset: 8px;
        }

        .hero-description {
            font-size: 1.2rem;
            line-height: 1.6;
            margin-bottom: 40px;
            opacity: 0.9;
            max-width: 600px;
        }

        .hero-visual {
            flex: 1;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .profile-card {
            background: rgba(153, 150, 151, 0.4);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            transform: translateY(20px);
            width: 400px;
            height: 460px;
            top: -20%;
            position: relative;
            clip-path: polygon(0 0, 100% 0, 100% 100%, 20% 100%, 0 80%);
        }

        .profile-card::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            clip-path: polygon(0 80%, 20% 100%, 0 100%);
            background: #ff4757;
            z-index: -1;
        }

        .profile-image {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        .profile-image img {
            height: 100%;
            width: 100%;
        }

        .profile-name {
            font-size: 1rem;
            font-weight: bold;
            color: white;
            margin-bottom: 2px;
        }

        .profile-title {
            color: white;
            font-size: 0.9rem;
            margin-bottom: 4px;
        }

        .profile-badge {
            background: #10ac84;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            display: inline-block;
        }

        .profile-company {
            color: #333;
            font-weight: 300;
            margin-bottom: 26px !important;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(20px);
            }

            50% {
                transform: translateY(0px);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.5;
                transform: scale(1.2);
            }
        }

        .stats {
            position: absolute;
            bottom: 50px;
            left: 50px;
            display: flex;
            gap: 40px;
            color: white;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            display: block;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        /* Hamburger Menu Styles */
        .hamburger {
            display: none;
            flex-direction: column;
            justify-content: space-between;
            width: 30px;
            height: 20px;
            cursor: pointer;
        }

        .hamburger span {
            width: 100%;
            height: 3px;
            background: white;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .hamburger.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -7px);
        }

        .nav-container {
            display: none;
            /* Hidden in desktop view */
        }

        /* Mobile */
        @media (max-width: 768px) {
            .navbar {
                padding: 15px 20px;
                flex-wrap: wrap;
                justify-content: space-between;
            }
            .banner {
                font-size: 10px;
            }
            .banner a {
                color: red;
                text-decoration: none;
            }

            .logo {
                font-size: 18px;
                flex-direction: row;
                align-items: center;
            }

            .hamburger {
                display: flex;
                z-index: 1001;
            }

            .nav-links {
                display: none;
            }

            .nav-right {
                display: none;
            }

            .nav-container {
                display: none;
                flex-direction: column;
                width: 100%;
                gap: 15px;
                background: rgba(0, 0, 0, 0.9);
                padding: 20px;
                position: absolute;
                top: 60px;
                left: 0;
                z-index: 1000;
            }

            .nav-container.active {
                display: flex;
            }

            .nav-container .nav-links {
                display: flex;
                flex-direction: column;
                width: 100%;
                gap: 15px;
            }

            .nav-container .nav-links a {
                font-size: 16px;
                padding: 10px;
                display: block;
            }

            .nav-container .nav-right {
                display: flex;
                flex-direction: column;
                width: 100%;
                gap: 15px;
                align-items: flex-start;
            }

            .nav-container .nav-right .btn {
                width: 100%;
                text-align: center;
                font-size: 14px;
                padding: 12px;
            }

            .nav-container .login {
                font-size: 14px;
                padding: 10px;
                color: white;
                text-decoration: none;
                display: block;
            }

            .hero-section {
                flex-direction: column;
                text-align: center;
               height: 110vh;
            }

            .hero-title {
                font-size: 2.0rem!important;
                line-height: 1.2;
            }

            .hero-description {
                font-size: 1.0rem;
                max-width: 100%;
            }

            .hero-visual {
                margin-top: 30px;
            }

            .profile-card {
                display: none;
            }

            .profile-image {
                width: 100%;
                height: 100%;
                font-size: 18px;
            }

            .profile-name {
                font-size: 1.1rem;
            }
            .btn {
                padding: 10px 20px;
                font-size: 14px!important;
                border-radius: 10px;
                margin-bottom: 20px!important;
            }

            .stats {
                position: static;
                flex-direction: column;
                align-items: center;
                gap: 20px;
                margin-top: 40px;
                bottom: auto;
                left: auto;
            }

            .stat-item {
                width: 100%;
            }

            .decorative-elements {
                display: none;
            }

            .world-map {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 2rem;
            }

            .btn {
                padding: 10px 20px;
                font-size: 0.9rem;
            }

            .stats .stat-number {
                font-size: 1.5rem;
            }

            .stats .stat-label {
                font-size: 0.8rem;
            }
        }
    </style>
</head>

<body>
    <div class="banner">
        YohpaL launches <a href="#">Hire</a> 🚀 The most competitively priced workforce.
    </div>

    <nav class="navbar">
        <div class="logo"><img src="./assets/logos/logo_circular.png" alt="YohPal Logo"> YohPal Hustle</div>
        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <ul class="nav-links">
            <li><a href="#">Top 3%</a></li>
            <li><a href="#">Hire Talent</a></li>
            <li><a href="#">Consulting & Services</a></li>
            <li><a href="#">Clients</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">About Us</a></li>
        </ul>
        <div class="nav-right">
            <a href="#" class="btn btn-secondary">Apply for work</a>
            <a href="#" class="btn btn-primary">Hire Top Talent</a>
            <a href="./index.php?url=log_in" class="login" style="color: white; text-decoration: none;">LogIn</a>
        </div>
        <div class="nav-container">
            <ul class="nav-links">
                <li><a href="#">Top 3%</a></li>
                <li><a href="#">Hire Talent</a></li>
                <li><a href="#">Consulting & Services</a></li>
                <li><a href="#">Clients</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">About Us</a></li>
            </ul>
            <div class="nav-right">
                <a href="#" class="btn btn-secondary">Apply for work</a>
                <a href="#" class="btn btn-primary">Hire Top Talent</a>
                <a href="./index.php?url=log_in" class="login">LogIn</a>
            </div>
        </div>
    </nav>

    <main class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">
                Hire the <span class="highlight">Top 3%</span><br>
                of Talent™
            </h1>
            <p class="hero-description">
                YohPal is an exclusive network of the middle and high class talents including developers, designers,
                marketing experts, management consultants, carpenters, plumbers, electricians and more in the world.
                Top companies and talented people hire YohPal talent for their most important projects.
            </p>
            <a href="#" class="btn btn-primary" style="font-size: 1.1rem; padding: 15px 30px;">
                Hire Top Talent
            </a>
        </div>

        <div class="hero-visual">
            <div class="profile-card">
                <div class="profile-image"><img src="./assets/images/businessman.png" alt=""></div>
            </div>
        </div>
    </main>

    <script>
        // Add smooth scrolling and interactive elements
        document.addEventListener('DOMContentLoaded', function () {
            // Hamburger menu toggle
            const hamburger = document.querySelector('.hamburger');
            const navContainer = document.querySelector('.nav-container');

            hamburger.addEventListener('click', () => {
                hamburger.classList.toggle('active');
                navContainer.classList.toggle('active');
            });

            // Close menu when a link is clicked
            navContainer.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    hamburger.classList.remove('active');
                    navContainer.classList.remove('active');
                });
            });

            // Smooth hover effects for buttons
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(btn => {
                btn.addEventListener('mouseenter', function () {
                    this.style.transform = 'translateY(-2px)';
                });
                btn.addEventListener('mouseleave', function () {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Profile card interaction
            const profileCard = document.querySelector('.profile-card');
            profileCard.addEventListener('mouseenter', function () {
                this.style.transform = 'translateY(10px) scale(1.05)';
                this.style.boxShadow = '0 30px 80px rgba(0, 0, 0, 0.15)';
            });
            profileCard.addEventListener('mouseleave', function () {
                this.style.transform = 'translateY(20px) scale(1)';
                this.style.boxShadow = '0 20px 40px rgba(0, 0, 0, 0.1)';
            });

            // Add parallax effect to decorative elements
            document.addEventListener('mousemove', function (e) {
                const mouseX = e.clientX / window.innerWidth;
                const mouseY = e.clientY / window.innerHeight;

                const rocket = document.querySelector('.rocket');
                const person = document.querySelector('.person-working');

                if (rocket) {
                    rocket.style.transform = `translate(${mouseX * 20}px, ${mouseY * 20}px) rotate(-5deg)`;
                }
                if (person) {
                    person.style.transform = `translate(${mouseX * -15}px, ${mouseY * -15}px)`;
                }
            });

            // Animate stats on scroll
            const animateStats = () => {
                const stats = document.querySelectorAll('.stat-number');
                stats.forEach(stat => {
                    const finalValue = parseInt(stat.textContent);
                    const suffix = stat.textContent.replace(/[0-9]/g, '');
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
    </script>
</body>

</html>