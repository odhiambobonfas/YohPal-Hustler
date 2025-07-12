<!-- header -->
<?php include 'partials/layout/web/header.php'; ?>
<!-- /header -->

<!-- styles -->
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link type="text/css" rel="stylesheet" href="<?= asset_url('/css/app/crm/main.css') ?>">
<link type="text/css" rel="stylesheet" href="<?= asset_url('/css/app/crm/dashboard.css') ?>">
<!-- /styles -->

<!-- navbar -->
<?php include 'partials/layout/crm/navbar.php'; ?>
<!-- /navbar -->

<!-- Main CRM Section -->
<div class="crm-section">
    <div class="d-flex gap-3">
        <aside class="col-md-2 d-none" id="sidebar">
            <div class="card bg-transparent border-0">
                <?php include 'partials/layout/crm/sidebar.php'; ?>
            </div>
        </aside>

        <!-- CRM Content -->
        <main class="col-md-5 flex-grow-1 main">
            <p class="greeting d-block d-md-none">We wish you a great day</p>
            <h2 class="welcome d-block d-md-none">Welcome back, David Kamau</h2>
            <div class="left vh-100 bg-transparent border-0 m-3 p-0">
                <div class="left-header d-flex flex-row justify-content-between">
                    <h2 class="text-left">About me</h2>
                    <p class="text-right"><i class="fas fa-arrow-right"></i>edit profile</p>
                </div>
                <div class="profile d-flex flex-row justify-content-md-start align-items-start text-center align-content-start">
                    <img src="<?= asset_url('/store/images/avatars/default-avatar.jpg') ?>" alt="">
                    <div class="content-texts">
                        <h3>David Kamau</h3>
                        <p>Web Developer</p>
                    </div>
                </div>
                <p class="wallet-title">Earnings<i class="fas fa-dollar-sign icon"></i></p>
                <div class="wallet">
                    <p>Available Funds</p>
                    <h2>$0</h2>
                </div>
                <div class="wallet-actions d-flex flex-row" style="align-items: center;text-align: center; justify-content: center!important; gap: 40px;">
                    <button style="color: var(--gray-600);">This Month<br> <b>0$</b></button>
                    <button style="color: var(--gray-600);">Total Income<br> <b>0$</b></button>

                </div>
                <!-- Transaction section for desktop view -->
                <?php include_once 'partials/dashboard/active-projects-md.php'; ?>

            </div>
            <!-- Transaction section for mobile and tablet views -->
            <?php include_once 'partials/dashboard/active-projects-sm.php'; ?>

            <div class="right vh-100 bg-transparent border-0 m-3 p-0">
                <p class="greeting d-none d-md-block">We wish you a great day</p>
                <h2 class="welcome d-none d-md-block">Welcome back, David Kamau</h2>
                <div class="head d-none d-md-block">
                    <div class="paragraph">
                        <p class="setup">Update your profile</p>
                        <p class="clarity">Employers love complete profile</p>
                    </div>
                    <a href="#">→ Setup Your Profile</a>
                </div>
                <div class="profile-actions d-none d-md-flex">
                    <button><i class="fas fa-camera"></i> Upload Photos</button>
                    <button><i class="fas fa-globe"></i> Add Location</button>
                    <button><i class="fas fa-file"></i>Bio</button>
                    <button><i class="fas fa-star"></i> Top Services</button>
                    <button><i class="fas fa-users"></i> Past Clients</button>
                </div>
                <div class="video-card d-none d-md-block">
                    <i class="fas fa-video-camera icon"></i>
                    <h2>Add a profile video</h2>
                    <p>Get more views,<br> project invites and <br>hires</p>
                </div>


                <div class="metrics">
                    <div class="metric">
                        <div class="title">
                            <p>Profile views</p>
                            <i class="fas fa-eye d-none d-md-block"></i>
                        </div>
                        <h3>21,523 <span class="down"><i class="fas fa-arrow-up arrow"></i> 60%</span></h3>
                    </div>
                    <div class="metric">
                        <div class="title">
                            <p>Project Invitations</p>
                            <i class="fas fa-folder d-none d-md-block"></i>
                        </div>
                        <h3>10 <span class="up"><i class="fas fa-arrow-down arrow"></i> 5%</span></h3>
                    </div>
                    <div class="metric">
                        <div class="title">
                            <p>Applications</p>
                            <i class="fas fa-user-check d-none d-md-block"></i>
                        </div>
                        <h3>25</h3>
                    </div>
                    <div class="metric">
                        <div class="title">
                            <p>Hired Projects</p>
                            <i class="fas fa-folder-plus d-none d-md-block"></i>
                        </div>
                        <h3>6</h3>
                    </div>
                </div>
                <?php include_once 'partials/dashboard/jobs.php'; ?>
            </div>
        </main>
    </div>
</div>

<!-- modals -->
<!-- verify profile details modal -->
<div class="modal fade verify-profile-details-modal pt-5" id="verifyProfileModalId" data-bs-keyboard="false" data-bs-backdrop="false" tabindex="-1" aria-labelledby="verifyProfileModalIdLabel" aria-hidden="true"></div>
<!-- /verify profile details modal -->
<!-- /modals -->

<!-- footer -->
<?php include 'partials/layout/crm/footer.php'; ?>
<!-- /footer -->

<!-- xtra scripts -->
<script type="text/javascript" src="<?= asset_url('js/app/crm/auth.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/crm/dashboard.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/crm/onboarding.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/crm/hustle-map.js') ?>"></script>
<!-- xtra scripts -->

<!-- closure -->
<?php include 'partials/layout/global/closure.php'; ?>
<!-- /closure -->