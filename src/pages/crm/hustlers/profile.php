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
                        <div class="switch-c">
                            <label class="switch">
                                <input type="checkbox" <?= auth()->hustlerStatus()->isHustler ? "checked" : "" ?> onchange="toggleAccount(this)" value="true">
                                <span class="slider round"></span>
                            </label>
                            </div>
                        <div class="profile-links">
                            <a href="#">Jobs</a>
                            <a href="#">Transactions</a>
                            <a href="#">Reviews</a>
                        </div>
                        <div class="profile-info">
                            <img class="profile-img" src="<?= isset(auth()->hustler()->profile_picture)
                                ? auth()->hustler()->profile_picture
                                : asset_url('store/images/avatars/default-avatar.jpg') ?>"/>
                            <div class="user-info">
                                <h3><b><?= isset(auth()->hustler()->firstName) ? auth()->hustler()->firstName : 'John' ?> <?= isset(auth()->hustler()->lastName) ? auth()->hustler()->lastName : 'Doe' ?></b></h3>
                                <p> <i class="fas fa-street-view"></i> <?= isset(auth()->hustler()->primaryLocation) ? auth()->hustler()->primaryLocation : 'location not available' ?></p>
                            </div>
                            <div class="profile-btns">
                                <button class="profile-public">See public view</button>
                                <button class="profile-settings">Profile settings</button>
                            </div>
                        </div>
                        <div class="personal-info">
                            <h4><b>Personal Information</b></h4>
                            <div class="info">
                                <div class="info-input">
                                    <label for="firstName">First Name</label>
                                    <input disabled  name="firstName" readonly value="<?=  isset(auth()->hustler()->firstName) ? auth()->hustler()->firstName : 'John' ?>"/>
                                </div>

                                <div class="info-input">
                                    <label for="lastName">Last Name</label>
                                    <input disabled name="lastName" readonly value="<?=  isset(auth()->hustler()->lastName) ? auth()->hustler()->lastName : 'Doe' ?>"/>
                                </div>

                                <div class="info-input">
                                    <label for="email">Email</label>
                                    <input disabled name="email" readonly value="<?=  isset(auth()->hustler()->email) ? auth()->hustler()->email : 'user@domain.com' ?>"/>
                                </div>

                                <div class="info-input">
                                    <label for="phone">Phone No:</label>
                                    <input disabled name="phone" readonly value="<?=  isset(auth()->hustler()->phoneNumber) ? auth()->hustler()->phoneNumber : '+254-70-000-000' ?>"/>
                                </div>
                                <div class="info-textarea">
                                    <label for="work-bio">Work Bio:</label>
                                    <textarea disabled name="work-bio" readonly>
                                        <?=  isset(auth()->hustler()->workBio) ? auth()->hustler()->workBio : 'No work bio set' ?>
                                    </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="work-info">
                            <h4><b>Work profile</b></h4>
                            <div class="info">
                                <div class="info-input">
                                    <label for="primarySkill">Primary Skill</label>
                                    <input disabled  name="primarySkill" readonly value="<?=  isset(auth()->hustler()->firstName) ? auth()->hustler()->primarySkill : 'Skill-1' ?>"/>
                                </div>

                                <div class="info-input">
                                    <label for="pricing">
                                        <i class="fas fa-dollar-sign"></i>
                                        Pricing(<?= isset(auth()->hustler()->pricingType) ? auth()->hustler()->pricingType : 'hr' ?>)</label>
                                    <input disabled type="number" name="pricing" readonly value="<?=  isset(auth()->hustler()->pricing) ? auth()->hustler()->pricing : '0' ?>"/>
                                </div>

                                <div class="info-skills">
                                    <label for="email">Skills</label>
                                    <?php if (!empty(auth()->hustler()->skills) && is_array(auth()->hustler()->skills)): ?>
                                        <?php foreach (auth()->hustler()->skills as $skill): ?>
                                            <span class="info-skill"><?= htmlspecialchars($skill) ?></span>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>

                                <div class="info-images-c">
                                    <label>Portfolio Images</label>
                                    <div class="info-imgs">
                                        <?php if (!empty(auth()->hustler()->uploads["images"]) && is_array(auth()->hustler()->uploads["images"])): ?>
                                            <?php foreach (auth()->hustler()->uploads["images"] as $image): ?>
                                                <img src="<?= htmlspecialchars($image) ?>" class="info-img"/>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
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
<script type="text/javascript" src="<?= asset_url('js/app/crm/auth.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/crm/account.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/crm/dashboard.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/crm/profile.js') ?>"></script>
<!-- xtra scripts -->

<!-- closure -->
<?php include 'partials/layout/global/closure.php'; ?>
<!-- /closure -->
