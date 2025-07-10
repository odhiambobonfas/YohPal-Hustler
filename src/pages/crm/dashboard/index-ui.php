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
            <div class="left vh-100 bg-transparent border-0 m-3 p-0">
                <div class="left-header d-flex flex-row justify-content-between">
                    <h2 class="text-left">About me</h2>
                    <p class="text-right"><i class="fas fa-arrow-right"></i>edit profile</p>
                </div>
                <div class="profile d-flex flex-row justify-content-space-between justify-content-md-start align-items-start text-center align-content-start">
                    <img src="<?= asset_url('/store/images/avatars/default-avatar.jpg') ?>" alt="">
                    <div class="content-texts">
                        <h3>David Kamau</h3>
                        <p>Web Developer</p>
                    </div>
                </div>
                <div class="wallet">
                    <p>Total Wallet Balance</p>
                    <div class="view">
                        <h2>$30,000.00</h2>
                        <i class="fas fa-eye"></i>
                    </div>
                </div>
                <div class="wallet-actions">
                    <button><i class="fas fa-upload"></i> Send</button>
                    <button><i class="fas fa-download"></i> Withdraw</button>
                    <button><i class="fas fa-plus"></i> TopUp</button>
                    <button><i class="fas fa-arrow-down"></i> Deposit</button>
                </div>
                <!-- Transaction section for desktop view -->
                <?php include_once 'partials/dashboard/transaction-section-md.php'; ?>

            </div>
            <!-- Transaction section for mobile and tablet views -->
            <?php include_once 'partials/dashboard/transaction-section-sm.php'; ?>

            <div class="right vh-100 bg-transparent border-0 m-3 p-0">
                <p1 class="greeting">We wish you a great day</p>
                    <h2>Welcome back, David Kamau</h2>
                    <div class="head">
                        <div class="paragraph">
                            <p class="setup">Update your profile</p>
                            <p class="clarity">Employers love complete profile</p>
                        </div>
                        <a href="#">→ Setup Your Profile</a>
                    </div>
                    <div class="profile-actions">
                        <button><i class="fas fa-camera"></i> Upload Photos</button>
                        <button><i class="fas fa-globe"></i> Add Location</button>
                        <button><i class="fas fa-file"></i>Bio</button>
                        <button><i class="fas fa-star"></i> Top Services</button>
                        <button><i class="fas fa-users"></i> Past Clients</button>
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
                                <i class="fas fa-folder-plus"></i>
                            </div>
                            <h3>6</h3>
                        </div>
                    </div>
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