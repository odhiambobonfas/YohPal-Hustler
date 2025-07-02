<!-- header -->
<?php include 'partials/layout/web/header.php'; ?>
<!-- /header -->

<!-- styles -->
<link type="text/css" rel="stylesheet" href="<?= asset_url('/css/app/crm/main.css') ?>">
<link type="text/css" rel="stylesheet" href="<?= asset_url('/css/app/crm/profile.css') ?>">
<!-- /styles -->

<!-- navbar -->
<?php include 'partials/layout/crm/navbar.php'; ?>
<!-- /navbar -->

<!-- Main CRM Section -->
<div class="crm-section">
    <div class="d-flex gap-3">
        <!-- Sidebar -->
        <aside class="col-md-2 d-none d-md-block" id="sidebar">
            <div class="card bg-transparent border-0">
                <?php include 'partials/layout/crm/sidebar.php'; ?>
            </div>
        </aside>

        <!-- CRM Content -->
        <main class="col-md-9 flex-grow-1 bg-light">
            <div class="card bg-transparent border-0 m-3">

                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center rounded p-2 mb-3 m-2">
                    <h4 class="m-0">
                        <span id="sidebarToggleBtn" class="me-2"><i class="fas fa-bars fw-bold"></i></span>
                        Profile
                    </h4>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="/dashboard" class="text-dark me-2">
                            Home
                        </a>
                        <span><i class="bi bi-arrow-right me-2"></i></span>
                        <span class="text-dark">Profile</span>
                    </div>
                </div>

                <!-- Profile start -->
                <div class="card bg-white border-0 rounded mb-3">
                    <div class="profile-container">
                        <!-- Left Section -->
                        <div class="left-section">
                            <div class="profile-card">
                                <div class="profile-header">
                                    <div class="profile-info">
                                        <img src="<?= asset_url('store/images/avatars/default-avatar.jpg') ?>" alt="" class="profile-img">
                                        <div class="profile-details">
                                            <h2>
                                                <?= !empty(auth()->user()) ? auth()->user()->firstName : 'JANE DOE' ?>
                                                <?= !empty(auth()->user()) ?  auth()->user()->lastName : null ?>
                                            </h2>
                                            <p>FRONT-END DEVELOPER</p>
                                            <p>NAIROBI, KENYA</p>
                                        </div>
                                    </div>
                                    <div>
                                        <a href="#" class="edit-profile mobile-only">Edit Profile</a>
                                        <a href="#" class="edit-profile desktop-only">Edit Profile</a>
                                    </div>
                                </div>
                                <div class="welcome-message">
                                    Welcome back, 
                                    <?= !empty(auth()->user()) ? auth()->user()->firstName : 'Jane Doe' ?>
                                    <?= !empty(auth()->user()) ?  auth()->user()->lastName : null ?>
                                </div>
                                <div class="profile-metrics">
                                    <div class="metric-item">
                                        <p>EMAIL:</p>
                                        <span><?= !empty(auth()->user()) ? auth()->user()->email : 'jane.doe@example.com' ?></span>
                                    </div>
                                    <div class="metric-item">
                                        <p>JOBS:</p>
                                        <span>4</span>
                                    </div>
                                    <div class="metric-item">
                                        <p>RATE:</p>
                                        <span>Ksh 200,000 - 300,000</span>
                                    </div>
                                    <div class="metric-item">
                                        <p>HOURS WORKED:</p>
                                        <span>Not specified</span>
                                    </div>
                                    <div class="metric-item">
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
                                <div class="nav-tabs">
                                    <div class="tab active" data-tab="overview">BASIC</div>
                                    <div class="tab" data-tab="skills">SKILLS</div>
                                    <div class="tab" data-tab="employment">EMPLOYMENT HISTORY</div>
                                    <div class="tab" data-tab="portfolio">PORTFOLIO</div>
                                    <div class="tab" data-tab="education">EDUCATION</div>
                                    <div class="tab" data-tab="work">WORK</div>
                                </div>

                                <div class="panel-content active" id="overview">
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

                                <div class="panel-content" id="skills">
                                    <h3>SKILLS</h3>
                                    <div class="skills-list">
                                        <span class="skill">Accessibility</span>
                                        <span class="skill">React.js</span>
                                        <span class="skill">Vue.js</span>
                                        <span class="skill">SASS/SCSS</span>
                                        <span class="skill">Redux</span>
                                    </div>
                                </div>

                                <div class="panel-content" id="employment">
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

                                <div class="panel-content" id="portfolio">
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

                                <div class="panel-content" id="education">
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

                                <div class="panel-content" id="work">
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
                                    <span><?= !empty(auth()->user()) ? auth()->user()->firstName : 'Jane Doe' ?> <?= !empty(auth()->user()) ?  auth()->user()->lastName : null ?> updated his/her profile</span>
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
                                    <h4>PROFILE METRICS</h4>
                                    <a href="#">View Detailed Analytics</a>
                                </div>
                                <div class="metrics-grid">
                                    <div class="metric-card">
                                        <p>Profile views</p>
                                        <span>15,320 <span class="text-green-500">+45%</span></span>
                                    </div>
                                    <div class="metric-card">
                                        <p>Project invitations</p>
                                        <span>8 <span class="text-green-500">+3%</span></span>
                                    </div>
                                    <div class="metric-card">
                                        <p>Applications</p>
                                        <span>18</span>
                                    </div>
                                    <div class="metric-card">
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
                            <div class="activity-card desktop-only">
                                <h4>SEARCHING FOR WORK</h4>
                                <button class="Register-btn" id="statusButton">REGISTER</button>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /Profile start -->
            </div>
        </main>
    </div>
</div>

<!-- modals -->
<!-- /modals -->

<!-- footer -->
<?php include 'partials/layout/crm/footer.php'; ?>
<!-- /footer -->

<!-- xtra scripts -->
<script type="text/javascript" src="<?= asset_url('js/app/crm/auth.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/crm/dashboard.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/crm/profile.js') ?>"></script>
<!-- xtra scripts -->

<!-- closure -->
<?php include 'partials/layout/global/closure.php'; ?>
<!-- /closure -->