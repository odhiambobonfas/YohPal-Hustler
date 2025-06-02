<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freelancer Profile</title>
    <link rel="stylesheet" href="./assets/css/profile.css">
</head>

<body>
    <div class="container">
        <!-- Left Section -->
        <div class="left-section">
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-info">
                        <img src="./assets/images/people/img1.jpg" alt="" class="profile-img">
                        <div class="profile-details">
                            <h2>JANE DOE</h2>
                            <p>FRONT-END DEVELOPER</p>
                            <p>NAIROBI, KENYA</p>
                           
                        </div>
                        
                    </div>
                    <a href="#" class="edit-profile mobile-only">Edit Profile</a>
                    <a href="#" class="edit-profile desktop-only">Edit Profile</a>
                </div>
                <div class="welcome-message">Welcome back, Jane Doe</div>
                <div class="profile-stats">
                    <div class="stat-item">
                        <p>EMAIL:</p>
                        <span>jane.doe@example.com</span>
                    </div>
                    <div class="stat-item">
                        <p>JOBS:</p>
                        <span>4</span>
                    </div>
                    <div class="stat-item">
                        <p>RATE:</p>
                        <span>Ksh 200,000 - 300,000</span>
                    </div>
                    <div class="stat-item">
                        <p>HOURS WORKED:</p>
                        <span>Not specified</span>
                    </div>
                    <div class="stat-item">
                        <p>SKILLS:</p>
                        <span>Accessibility, React.js, Vue.js, SASS/SCSS, Redux</span>
                    </div>
                </div>
                <div class="status-container mobile-only">
                    <h4>CURRENT STATUS:</h4>
                    <button class="status-btn" id="statusButton">AVAILABLE NOW</button>
                </div>
            </div>

            <div class="profile-card">
                <div class="tabs">
                    <div class="tab active" data-tab="overview">BASIC</div>
                    <div class="tab" data-tab="skills">SKILLS</div>
                    <div class="tab" data-tab="employment">EMPLOYMENT HISTORY</div>
                    <div class="tab" data-tab="portfolio">PORTFOLIO</div>
                    <div class="tab" data-tab="education">EDUCATION</div>
                    <div class="tab" data-tab="work">WORK</div>
                </div>

                <div class="tab-content active" id="overview">
                    <h3>ADDITIONAL OVERVIEW</h3>
                    <div class="overview-section">
                        <div class="overview-item">
                            <h4>BIO:</h4>
                            <p>My strongest skill as a front-end developer is my ability to work magic with responsive
                                design, making websites look great on any device.</p>
                        </div>
                        <div class="overview-item">
                            <h4>EXPERIENCE:</h4>
                            <p>5yrs</p>
                        </div>
                        <div class="overview-item">
                            <h4>WORKPLACE:</h4>
                            <p>Remote</p>
                        </div>
                        <div class="overview-item">
                            <h4>WORKING HOURS:</h4>
                            <p>8:00 AM - 5:00 PM</p>
                        </div>
                        <div class="overview-item">
                            <h4>FLUENT IN:</h4>
                            <p>English</p>
                            <p>French</p>
                            <p>Kiswahili</p>
                        </div>
                        <div class="overview-item">
                            <h4>LOCATION:</h4>
                            <p>Nairobi, Kenya</p>
                        </div>
                        <div class="overview-item">
                            <h4>EARNINGS:</h4>
                            <p>Available Funds: KSH 105,000</p>
                            <p>Total Income: KSH 1,200,000</p>
                            <button class="transfer-btn">Transfer</button>
                        </div>
                    </div>
                </div>

                <div class="tab-content" id="skills">
                    <h3>SKILLS</h3>
                    <div class="skills-list">
                        <span class="skill">Accessibility</span>
                        <span class="skill">React.js</span>
                        <span class="skill">Vue.js</span>
                        <span class="skill">SASS/SCSS</span>
                        <span class="skill">Redux</span>
                    </div>
                </div>

                <div class="tab-content" id="employment">
                    <h3>EMPLOYMENT HISTORY</h3>
                    <div class="overview-item">
                        <h4>Senior Front-End Developer - TechTrend Innovations</h4>
                        <p>January 2022 - Present | Remote</p>
                        <p>Led the development of responsive web applications using React.js and Tailwind CSS, improving
                            user engagement by 30%. Implemented accessibility standards (WCAG 2.1) for client projects.
                        </p>
                    </div>
                    <div class="overview-item">
                        <h4>Front-End Developer - Nairobi Web Solutions</h4>
                        <p>June 2019 - December 2021 | Nairobi, Kenya</p>
                        <p>Developed and maintained e-commerce websites using SASS/SCSS and Redux, enhancing page load
                            times by 25%. Collaborated with UX designers to create intuitive user interfaces.</p>
                    </div>
                </div>

                <div class="tab-content" id="portfolio">
                    <h3>PORTFOLIO</h3>
                    <div class="overview-item">
                        <h4>E-Commerce Platform Redesign</h4>
                        <p>2023 | <a href="https://example.com/ecommerce" class="section-link">View Project</a></p>
                        <p>Revamped an e-commerce platform using React.js and Tailwind CSS, improving mobile
                            responsiveness and increasing conversion rates by 20%.</p>
                    </div>
                    <div class="overview-item">
                        <h4>Accessible E-Learning Dashboard</h4>
                        <p>2022 | <a href="https://example.com/elearning" class="section-link">View Project</a></p>
                        <p>Designed and developed an accessible e-learning dashboard compliant with WCAG 2.1, using
                            Redux for state management and SASS for styling.</p>
                    </div>
                </div>

                <div class="tab-content" id="education">
                    <h3>EDUCATION</h3>
                    <div class="overview-item">
                        <h4>Bachelor of Science in Computer Science</h4>
                        <p>University of Nairobi | 2015 - 2019</p>
                        <p>Graduated with First Class Honours, specializing in web development and human-computer
                            interaction.</p>
                    </div>
                    <div class="overview-item">
                        <h4>Certified Professional in Web Accessibility</h4>
                        <p>International Association of Accessibility Professionals (IAAP) | 2020</p>
                        <p>Completed certification focusing on WCAG 2.1 standards and inclusive design practices.</p>
                    </div>
                </div>

                <div class="tab-content" id="work">
                    <h3>WORK</h3>
                    <p>Jobs you might like:</p>
                    <ul>
                        <li class="job-item">
                            <span>Front-End Developer for SaaS Platform - React.js & Tailwind CSS - Remote - Hiring 2
                                Freelancers</span>
                            <a href="client-profile.html" class="view-client-profile" data-client-id="client1">View
                                Client Profile</a>
                        </li>
                        <li class="job-item">
                            <span>Accessibility Consultant for E-Learning Website - Nairobi, Kenya - Part-time</span>
                            <a href="client-profile.html" class="view-client-profile" data-client-id="client2">View
                                Client Profile</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Right Section -->
        <div class="right-section">
            <div class="activity-card desktop-only">
                <h4>CURRENT STATUS:</h4>
                <button class="status-btn" id="statusButton">AVAILABLE NOW</button>
                <div class="activity-item">
                    <span>Jane Doe updated her profile</span>
                    <span>10:33 AM EAT, Monday, June 02, 2025</span>
                </div>
            </div>
            <div class="activity-card mobile-only">
                <h4>ACTIVITY:</h4>
                <div class="activity-item">
                    <span>Jane Doe updated her profile</span>
                    <span>10:33 AM EAT, Monday, June 02, 2025</span>
                </div>
            </div>

            <div class="review-card">
                <div class="review-header">
                    <h4>PROFILE STATS</h4>
                    <a href="#">View Detailed Analytics</a>
                </div>
                <div class="stats-grid">
                    <div class="stat-card">
                        <p>Profile views</p>
                        <span>15,320 <span class="text-green-500">+45%</span></span>
                    </div>
                    <div class="stat-card">
                        <p>Project invitations</p>
                        <span>8 <span class="text-green-500">+3%</span></span>
                    </div>
                    <div class="stat-card">
                        <p>Applications</p>
                        <span>18</span>
                    </div>
                    <div class="stat-card">
                        <p>Hired projects</p>
                        <span>4</span>
                    </div>
                </div>
                <h4>INDUSTRIES OF INTEREST</h4>
                <ul style="list-style-type: none; padding-left: 0;">
                    <li>Technology</li>
                    <li>E-commerce</li>
                    <li>E-learning</li>
                </ul>
                <a href="#" class="section-link">Show More Industries</a>
            </div>
        </div>
    </div>

    <script src="./assets/js/profile.js"></script>
</body>

</html>