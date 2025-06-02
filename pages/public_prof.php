<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Profile</title>
    <link rel="stylesheet" href="./assets/css/public_prof.css">
</head>

<body>
    <div class="container">
        <!-- Left Section -->
        <div class="left-section">
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-info">
                        <img src="./assets/logos/logo_circular.png" alt="Company Logo" class="profile-img">
                        <div class="profile-details">
                            <h2>Yohpal</h2>
                            <p>Monitizing Creativity</p>
                            <p>NAIROBI, KENYA</p>
                        </div>
                    </div>
                    <a href="#" class="contact-client mobile-only">Contact Client</a>
                    <a href="#" class="contact-client desktop-only">Contact Client</a>
                </div>
                <div class="welcome-message">Yohpal int</div>
                <div class="profile-stats">
                    <div class="stat-item">
                        <p>EMAIL:</p>
                        <span>contact@yohpal.com</span>
                    </div>
                    <div class="stat-item">
                        <p>ACTIVE JOBS:</p>
                        <span>3</span>
                    </div>
                    <div class="stat-item">
                        <p>FOUNDED:</p>
                        <span>2010</span>
                    </div>
                    <div class="stat-item">
                        <p>EMPLOYEES:</p>
                        <span>50-100</span>
                    </div>
                    <div class="stat-item">
                        <p>INDUSTRY:</p>
                        <span>Social interraction</span>
                    </div>
                </div>
            </div>

            <div class="profile-card">
                <div class="tabs">
                    <div class="tab active" data-tab="overview">OVERVIEW</div>
                    <div class="tab" data-tab="jobs">CURRENT JOBS</div>
                    <div class="tab" data-tab="about">ABOUT</div>
                    <div class="tab" data-tab="applications">APPLICATIONS</div>
                </div>

                <div class="tab-content active" id="overview">
                    <h3>COMPANY OVERVIEW</h3>
                    <div class="overview-section">
                        <div class="overview-item">
                            <h4>DESCRIPTION:</h4>
                            <p>YohPal connects top talent in tech, design, and trades with leading companies for key projects.</p>
                        </div>
                        <div class="overview-item">
                            <h4>LOCATION:</h4>
                            <p>Nairobi, Kenya</p>
                        </div>
                        <div class="overview-item">
                            <h4>WEBSITE:</h4>
                            <p><a href="https://yohpal.com" class="section-link">yohpal.com</a></p>
                        </div>
                        <div class="overview-item">
                            <h4>CONTACT:</h4>
                            <p>+254 712 345 678</p>
                        </div>
                        <div class="overview-item">
                            <h4>SECTORS:</h4>
                            <p>Tech, E-commerce, Education</p>
                        </div>
                        <div class="overview-item">
                            <h4>BUDGET RANGE:</h4>
                            <p>KSH 50K - 500K</p>
                        </div>
                    </div>
                </div>

                <div class="tab-content" id="jobs">
                    <h3>CURRENT JOB OPENINGS</h3>
                    <ul class="job-list">
                        <li class="job-item">
                            <strong>Web Developer</strong>
                            <p>KSH 200K/project | Remote | React, Laravel | 3 months</p>
                        </li>
                        <li class="job-item">
                            <strong>UI/UX Designer</strong>
                            <p>KSH 150K/project | Nairobi | Figma, XD | 2 months</p>
                        </li>
                    </ul>
                </div>

                <div class="tab-content" id="about">
                    <h3>ABOUT Yohpal</h3>
                    <div class="overview-item">
                        <p>YohPal networks top tech, design, and trade talent globally.</p>
                    </div>
                    <div class="overview-item">
                        <h4>MISSION:</h4>
                        <p>Empower businesses with scalable solutions.</p>
                    </div>
                    <div class="overview-item">
                        <h4>KEY PROJECTS:</h4>
                        <p>E-commerce (2023), Education system (2022).</p>
                    </div>
                </div>

                <div class="tab-content" id="applications">
                    <h3>JOB APPLICATIONS</h3>
                    <ul class="application-list">
                        <li class="application-item">
                            <span>Jane Doe - Front-End Developer</span>
                            <a href="./index.php?url=public_prof&applicant_id=applicant1" class="view-applicant-profile" data-applicant-id="applicant1">View Applicant Profile</a>
                        </li>
                        <li class="application-item">
                            <span>John Smith - UI/UX Designer</span>
                            <a href="./index.php?url=public_prof&applicant_id=applicant2" class="view-applicant-profile" data-applicant-id="applicant2">View Applicant Profile</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Right Section -->
        <div class="right-section">
            <div class="activity-card">
                <h4>RECENT ACTIVITY</h4>
                <div class="activity-item">
                    <span>Posted new job</span>
                    <span>9:15 AM, Jun 02, 2025</span>
                </div>
                <div class="activity-item">
                    <span>Updated profile</span>
                    <span>3:45 PM, Jun 01, 2025</span>
                </div>
            </div>

            <div class="stats-card">
                <h4>COMPANY STATS</h4>
                <div class="stats-grid">
                    <div class="stat-card">
                        <p>Jobs Posted</p>
                        <span>12 <span class="text-green-500">+20%</span></span>
                    </div>
                    <div class="stat-card">
                        <p>Hired</p>
                        <span>8 <span class="text-green-500">+10%</span></span>
                    </div>
                    <div class="stat-card">
                        <p>Projects Done</p>
                        <span>15</span>
                    </div>
                    <div class="stat-card">
                        <p>Rating</p>
                        <span>4.8/5</span>
                    </div>
                </div>
                <h4>PRIMARY NEEDS</h4>
                <ul style="list-style-type: none; padding-left: 0;">
                    <li>Front-End Dev</li>
                    <li>UI/UX Design</li>
                    <li>Accessibility</li>
                </ul>
                <a href="#" class="section-link">View All Jobs</a>
            </div>
        </div>
    </div>

    <script src="./assets/js/public_prof.js"></script>
</body>

</html>