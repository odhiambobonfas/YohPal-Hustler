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
            <div class="card bg-transparent border-0 mt-5 p-3">
                <!-- Profile start -->
                <div class="card bg-white border-0 rounded mb-3">
                    <div class="profile-container">
                        <?php if (auth()->user()->hustlerStatus): ?>
                        <div class="switch-c">
                            <label class="switch">
                                <input type="checkbox" <?= auth()->hustlerStatus()->isHustler ? 'checked' : '' ?> onchange="toggleAccount(this)">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <?php endif; ?>
                        <div class="profile-links">
                            <a href="/client/activities">Jobs</a>
                            <a href="#">Transactions</a>
                            <a href="#">Reviews</a>
                        </div>
                        <div class="profile-info">
                            <img class="profile-img" src="<?= isset(auth()->user()->profile_picture)
                                ? auth()->user()->profile_picture
                                : asset_url('store/images/avatars/default-avatar.jpg') ?>"/>
                            <div class="user-info">
                                <h3><b><?= isset(auth()->user()->firstName) ? auth()->user()->firstName : 'John' ?> <?= isset(auth()->user()->lastName) ? auth()->user()->lastName : 'Doe' ?></b></h3>
                                <p> <i class="fas fa-street-view"></i> <?= isset(auth()->user()->Country) ? auth()->user()->Country : 'location not available' ?></p>
                            </div>
                            <div class="profile-btns">
                                <button class="profile-settings">Edit profile</button>
                            </div>
                        </div>
                        <div class="personal-info">
                            <h4><b>Personal Information</b></h4>
                            <div class="info">
                                <div class="info-input">
                                    <label for="firstName">First Name</label>
                                    <input disabled  name="firstName" readonly value="<?=  isset(auth()->user()->firstName) ? auth()->user()->firstName : 'John' ?>"/>
                                </div>

                                <div class="info-input">
                                    <label for="lastName">Last Name</label>
                                    <input disabled name="lastName" readonly value="<?=  isset(auth()->user()->lastName) ? auth()->user()->lastName : 'Doe' ?>"/>
                                </div>

                                <div class="info-input">
                                    <label for="email">Email</label>
                                    <input disabled name="email" readonly value="<?=  isset(auth()->user()->email) ? auth()->user()->email : 'user@domain.com' ?>"/>
                                </div>

                                <div class="info-input">
                                    <label for="phone">Phone No:</label>
                                    <input disabled name="phone" readonly value="<?=  isset(auth()->user()->phoneNumber) ? auth()->user()->phoneNumber : '+254-70-000-000' ?>"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
<script type="text/javascript" src="<?= asset_url('js/app/crm/account.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/crm/auth.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/crm/dashboard.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/crm/profile.js') ?>"></script>
<!-- xtra scripts -->

<!-- closure -->
<?php include 'partials/layout/global/closure.php'; ?>
<!-- /closure -->
