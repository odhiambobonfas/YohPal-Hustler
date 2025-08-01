<!-- header -->
<?php include 'partials/layout/web/header.php'; ?>
<!-- /header -->

<!-- Bootstrap CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<!-- Font Awesome CDN for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- styles -->
<link rel="stylesheet" href="<?= asset_url('css/app/web/landing.css') ?>">
<!-- /styles -->

<!-- navbar -->
<?php include 'partials/layout/web/navbar.php'; ?>
<!-- /navbar -->

<!-- build main -->
<main class="main">
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <h1 class="hero-title">
                        Find A Job That<br>Matches Your<br>Passion.
                    </h1>
                    <p class="hero-description">
                        YohPal Hustle is a job search for people with passionate. Easily and quickly search thousands of jobs from worldwide side scene.
                    </p>
                    <div class="cont">
                        <a href="/get-started" class="btn btn-primary">Get Started</a>
                        <a href="#" class="scroll-down">
                            <span class="arrow-circle">
                                <span class="arrow"></span>
                            </span> Scroll down
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 hero-visual d-none d-md-flex">
                    <div class="profile-card"></div>
                    <div class="profile-image"><img src="<?= asset_url('/store/images/banners/banner2.png') ?>" alt=""></div>
                    <div class="profile-cad"></div>
                    <div class="job-posting developer">
                        <i class="fas fa-code icon"></i>
                        <div class="span">
                            <span class="profile-name">Hiring Developer</span><br>
                            <span class="profile-title">5 Days ago</span>
                        </div>
                    </div>
                    <div class="job-posting england">
                        <i class="fas fa-map-marker-alt icon"></i>
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
            </div>
        </div>
    </section>
    <div class="main-wrapper">
        <section class="top-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 explore">
                        <h1>Explore <br>by category</h1>
                    </div>
                    <div class="decoration-elements col-md-4 left justify-content-md-end ms-6">
                        <i class="fas fa-angle-left icon"></i>
                        <div class="decorative-elements">Drag</div>
                        <i class="fas fa-angle-right icon"></i>
                    </div>
                </div>
            </div>
        </section>
        <section class="category-grid">
            <div class="container">
                <div class="scroll-wrapper">
                    <div class="row g-4">
                        <div class="job col-6 col-md-3">
                            <div class="job-type">
                                <span class="job-icon ui-ux"></span>
                                <h3>UI/UX Design</h3>
                                <p>215 Vacancy</p>
                            </div>
                        </div>
                        <div class="job col-6 col-md-3">
                            <div class="job-type">
                                <span class="job-icon web-design"></span>
                                <h3>Web Design</h3>
                                <p>220 Vacancy</p>
                            </div>
                        </div>
                        <div class="job col-6 col-md-3">
                            <div class="job-type">
                                <span class="job-icon web-dev"></span>
                                <h3>Web Development</h3>
                                <p>625 Vacancy</p>
                            </div>
                        </div>
                        <div class="job col-6 col-md-3">
                            <div class="job-type">
                                <span class="job-icon digital-marketing"></span>
                                <h3>Digital Marketing</h3>
                                <p>780 Vacancy</p>
                            </div>
                        </div>
                        <div class="job col-6 col-md-3">
                            <div class="job-type">
                                <span class="job-icon web-design"></span>
                                <h3>Web Design</h3>
                                <p>220 Vacancy</p>
                            </div>
                        </div>
                        <div class="job col-6 col-md-3">
                            <div class="job-type">
                                <span class="job-icon web-dev"></span>
                                <h3>Web Development</h3>
                                <p>625 Vacancy</p>
                            </div>
                        </div>
                        <div class="job col-6 col-md-3">
                            <div class="job-type">
                                <span class="job-icon digital-marketing"></span>
                                <h3>Digital Marketing</h3>
                                <p>780 Vacancy</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="user-info-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 profile-container d-none d-md-flex">
                        <div class="main-profile-circle">
                            <img src="<?= asset_url('/store/images/banners/banner2.png') ?>" alt="">
                        </div>
                        <div class="floating-box visitors-box">
                            <i class="fas fa-user icon"></i>
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
                            <i class="fas fa-chart-pie icon"></i>
                        </div>
                    </div>
                    <div class=" col-md-6 user-info-text ms-auto">
                        <h3>Make a very good <br>qualified profile.</h3>
                        <p>Create an account so you can start building your profile and boost it. Enter all your experience and skills and we will matched it with the jobs vacancy.</p>
                        <button class="btn btn-primary">Learn More</button>
                    </div>
                </div>
            </div>
        </section>
        <section class="job-path-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 path-info">
                        <h3>Amazing roadmap for <br>finding job.</h3>
                        <p>We are providing easy way to find your dream job. It's easy, flexible and faster. Find your dream and suitable job with us and build your career</p>
                        <button class="btn btn-outline-primary">Learn More</button>
                    </div>
                    <div class="col-md-6 job-profile-container d-none d-md-flex ms-auto">
                        <div class="job-main-profile-circle">
                            <div class="job-floating-box job-profile-info-box">
                                <div class="content-box">
                                    <div class="name">You have an unread message from stokes</div>
                                    <div class="profile-title">Senior hr manager Baxon agency</div>
                                    <div class="profile-greating">Greatings Marsh<img src="<?= asset_url('/store/images/banners/banner2.png') ?>" alt=""></div>
                                </div>
                            </div>
                            <div class="job-floating-box job-visitors-box">
                                <img src="<?= asset_url('/store/images/banners/banner2.png') ?>" alt="">
                                <div class="content-box">
                                    <div class="name">Uploading<br> your CV</div>
                                    <div class="profile-title">80% Complete</div>
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
                </div>
            </div>
        </section>
        <section class="feedback-area position-relative">
            <div class="container">
                <h2 class="text-center">What job seekers says about us</h2>
                <div class="review-card">
                    <img src="<?= asset_url('/store/images/banners/banner2.png') ?>" alt="">
                    <p>This is the great and best platform to finding the job. I got a very good job by using this platform. I am very grateful to them.</p>
                    <p>They are providing a great service for job seeker</p>
                    <p>Trent Bout</p>
                    <p>Web Designer</p>
                    <div class="decoration-circle" style="top: -60px; left: -50px;"></div>
                    <div class="decoration-circle" style="bottom: -10px; right: 50px;"></div>
                    <div class="decoration-line feedback-top-left"></div>
                    <div class="decoration-line feedback-bottom-right"></div>
                </div>
            </div>
        </section>
        <section class="action-zone">
            <div class="container">
                <h3>Job for me</h3>
                <p>We are providing the easiest way to find your dream job.</p>
                    <input type="email" placeholder="Enter your email" />
                    <button>Send Link</button>
                </div>
            </div>
        </section>
        <section class="bottom-section">
            <div class="container">
                <div class="row2 g-4">
                    <div class="col-6 col-md-3 footer-block">
                        <h4>Employ</h4>
                        <p>We are helping people to find their suitable jobs by using our platform</p>
                        <div class="social-media">
                            <a href="#" class="icon"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="icon"><i class="fab fa-x-twitter"></i></a>
                            <a href="#" class="icon"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 footer-block">
                        <h4>About us</h4>
                        <p>Teams</p>
                        <p>Profile</p>
                        <p>Career</p>
                    </div>
                    <div class="col-6 col-md-3 footer-block">
                        <h4>Resources</h4>
                        <p>Application</p>
                        <p>Blog</p>
                    </div>
                    <div class="col-6 col-md-3 footer-block">
                        <h4>Stay up to date</h4>
                        <div class="deff d-flex gap-2">
                            <input type="email" placeholder="Make a difference" />
                            <i class="fas fa-angle-right icon"></i>
                        </div>
                    </div>
                </div>
                <p class="footer-copyright mt-4">© 2022 All Rights Reserved - <a href="#">website.com</a></p>
            </div>
        </section>
    </div>
</main>
<!-- /main -->

<!-- modals -->
<!-- /modals -->

<!-- footer -->
<?php include 'partials/layout/web/footer.php'; ?>
<!-- /footer -->

<!-- Bootstrap JS and Popper.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

<!-- xtra scripts -->
<script type="text/javascript" src="<?= asset_url('js/app/web/landing.js') ?>"></script>
<!-- /xtra scripts -->

<!-- closure -->
<?php include 'partials/layout/global/closure.php'; ?>
<!-- /closure -->
