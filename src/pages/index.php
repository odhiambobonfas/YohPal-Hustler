<!-- header -->
<?php include 'partials/layout/web/header.php'; ?>
<!-- /header -->

<!-- navbar -->
<?php include 'partials/layout/web/navbar.php'; ?>
<!-- /navbar -->

<!-- styles -->
<link type="text/css" rel="stylesheet" href="<?= asset_url('/css/app/web/landing.css') ?>">
<!-- /styles -->

<!-- build main -->
<main class="main">
    <main class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">
                Find A Job That<br>Matches Your<br>Passion.
            </h1>
            <p class="hero-description">
                YohPal Hustle is a job search for people with passionate. Easily and quickly search thousands of jobs from worldwide side scene.
            </p>
            <div class="cont">
                <a href="#" class="btn btn-primary">Get Started</a>
                <a href="#" class="scroll-down">
                    <span class="arrow-circle">
                        <span class="arrow"></span>
                    </span> Scroll down
                </a>
            </div>
        </div>
        <div class="hero-visual">
            <div class="profile-card"></div>
            <div class="profile-image"><img src="<?= asset_url('/store/images/banners/banner2.png') ?>" alt=""></div>
            <div class="profile-cad"></div>
            <div class="job-posting developer">
                <i class="fas fa-code icon" class="icon"></i>
                <div class="span">
                    <span class="profile-name">Hiring Developer</span><br>
                    <span class="profile-title">5 Days ago</span>
                </div>

            </div>
            <div class="job-posting england">
                <i class="fas fa-map-marker-alt icon" class="icon"></i>
                <div class="span">
                    <span class="text">England</span><br>
                    <span class="details">Visual Design</span><br>
                    <span class="time">2 Days Ago</span>
                    <span class="duration">Fulltime</span>
                </div>

            </div>
            <!-- Decorative Elements -->
            <div class="decoration-line top-right"></div>
            <div class="decoration-line bottom-right"></div>
            <div class="decoration-line bottom-left"></div>
            <div class="decoration-pie"> <i class="fas fa-chart-pie"></i></div>
        </div>
    </main>
    <div class="main-wrapper">
        <div class="top-section">
            <h1>Explore <br>by category</h1>
            <div class="left">
                <i class="fas fa-angle-left"></i>
                <div class="decorative-elements">Drag</div>
                <i class="fas fa-angle-right"></i>
            </div>
        </div>
        <div class="category-grid">
            <div class="job-type">
                <span class="job-icon ui-ux"></span>
                <h3>UI/UX Design</h3>
                <p>215 Vacancy</p>
            </div>
            <div class="job-type">
                <span class="job-icon web-design"></span>
                <h3>Web Design</h3>
                <p>220 Vacancy</p>
            </div>
            <div class="job-type">
                <span class="job-icon web-dev"></span>
                <h3>Web Development</h3>
                <p>625 Vacancy</p>
            </div>
            <div class="job-type">
                <span class="job-icon digital-marketing"></span>
                <h3>Digital Marketing</h3>
                <p>780 Vacancy</p>
            </div>
        </div>
        <div class="user-info-area">
            <div class="profile-container">
                <div class="main-profile-circle"></div>
                <div class="floating-box visitors-box">
                    <i class="fas fa-user"></i>
                    <div class="visitor">
                        <div class="visitors-number">26.8K</div>
                        <div class="visitors-label">Visitors</div>
                    </div>
                </div>
                <div class="floating-box profile-info-box">
                    <img src="<?= asset_url('/store/images/banners/banner2.png') ?>" alt="">
                    <div class="content-box">
                        <div class="name">Mitchell Marsh</div>
                        <div class="profile-title">Freelance Designer</div>
                        <div class="profile-country"><i class="fas fa-map-marker-alt icon"></i>Australia</div>
                        <div class="quote-text">
                            <h4>Quote</h4>
                            <p>It always seems</p>
                        </div>
                    </div>
                    <button>Upgrade</button>
                </div>
                <div class="floating-box upgrade-box">
                    <i class="fas fa-chart-pie"></i>
                </div>
            </div>
            <div class="user-info-text">
                <h3>Make a very good <br>qualified profile.</h3>
                <p>Create an account so you can start building your profile and boost it. Enter all your experience and skills and we will matched it with the jobs vacancy.</p>
                <button class="btn btn-primary">Learn More</button>
            </div>
        </div>
        <div class="job-path-area">
            <div class="path-info">
                <h3>Amazing roadmap for <br>finding job.</h3>
                <p>We are providing easy way to find your dream job. It's easy, flexible and faster. Find your dream and suitable job with us and build your career</p>
                <button>Learn More</button>
            </div>
            <div class="job-profile-container">
                <div class="job-main-profile-circle">
                    <div class="job-floating-box job-profile-info-box">
                        <div class="content-box">
                            <div class="name">You have an unread message from stokes</div>
                            <div class="profile-title">Senior hr manager Baxon agency</div>
                            <div class="profile-greating"><img src="<?= asset_url('/store/images/banners/banner2.png') ?>" alt=""> Greatings Marsh</div>
                        </div>
                    </div>
                    <div class="job-floating-box job-visitors-box">
                        <img src="<?= asset_url('/store/images/banners/banner2.png') ?>" alt="">
                        <div class="content-box">
                            <div class="name">Uploading<br> your CV</div>
                            <div class="profile-title">80% Complete</div>
                        </div>
                    </div>
                </div>
                <div class="job-floating-box job-visitors-box2">
                    <svg class="progress-ring" width="50" height="50">
                        <circle class="progress-ring__circle progress-ring__circle-bg" cx="25" cy="25" r="20" />
                        <circle class="progress-ring__circle progress-ring__circle-fg" cx="25" cy="25" r="20" style="stroke-dasharray: 125.6 125.6; stroke-dashoffset: 31.4;" />
                        <text class="progress-ring__text" x="25" y="25">75%</text>
                    </svg>
                    <div class="job-cont">
                        <div class="visitor-label-h">Your Jobs</div><br>
                        <div class="visitor-label">Applied Jobs</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="feedback-area">
            <h2>What job seekers says about us</h2>
            <div class="review-card">
                <img src="<?= asset_url('/store/images/banners/banner2.png') ?>" alt="">
                <p>This is the great and best platform to finding the job. I got a very good job by using this platform. I am very grateful to them.</p>
                <p>They are providing a great service for job seeker</p>
                <p>Trent Bout</p>
                <p>Web Designer</p>
                <div class="decoration-circle" style=" top: -60px ;left: -50px;"></div>
                <div class="decoration-circle" style="bottom: -10px; right: 50px;"></div>
                <div class="decoration-line feedback-top-left"></div>
                <div class="decoration-line feedback-bottom-right"></div>
            </div>
        </div>
        <div class="action-zone">
            <h3>Job for me</h3>
            <p>We are providing the easiest way to find your dream job. It's easy, flexible <br>and faster. Find your dream and suitable job with us and build your career</p>
            <div class="input">
                <input type="email" placeholder="Enter your email" />
                <button>Send Link</button>
            </div>
        </div>
        <div class="bottom-section">
            <div class="footer-block">
                <h4>Employ</h4>
                <p>We are helping people to find their suitable jobs by using our platform</p>
                <div class="social-media">
                    <i class="fab fa-facebook-f" class="icon" style="background-color:rgb(54, 94, 180); width: 25px; height: 25px; border-radius: 4px; font-size: 4px;padding: 2px"></i>
                    <i class="fab fa-twitter" class="icon" style="background-color:rgb(54, 94, 180); width: 25px; height: 25px; border-radius: 4px; font-size: 4px;padding: 2px"></i>
                    <i class="fab fa-linkedin-in" class="icon" style="background-color:rgb(54, 94, 180); width: 25px; height: 25px; border-radius: 4px; font-size: 4px;padding: 2px"></i>
                </div>
            </div>
            <div class="footer-block">
                <h4>About us</h4>
                <p>Teams</p>
                <p>Profile</p>
                <p>Career</p>
            </div>
            <div class="footer-block">
                <h4>Resources</h4>
                <p>Application</p>
                <p>Blog</p>
            </div>
            <div class="footer-block">
                <h4>Stay up to date</h4>
                <div class="deff">
                    <input type="email" placeholder="Make a difference" />
                    <i class="fas fa-angle-right" style="background-color: #f00000; border-radius: 50px; width: 30px; height: 30px; color: #fff; font-size: 12px;"></i>
                </div>
            </div>
        </div>
        <p class="footer-copyright">© 2022 All Rights Reserved - <a href="#">website.com</a></p>
    </div>
</main>
<!-- /main -->

<!-- modals -->
<!-- /modals -->

<!-- footer -->
<?php include 'partials/layout/web/footer.php'; ?>
<!-- /footer -->

<!-- xtra scripts -->
<script type="text/javascript" src="<?= asset_url('js/app/web/landing.js') ?>"></script>
<!-- xtra scripts -->

<!-- closure -->
<?php include 'partials/layout/global/closure.php'; ?>
<!-- /closure -->