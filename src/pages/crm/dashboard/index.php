<!-- header -->
<?php include 'partials/layout/web/header.php'; ?>
<!-- /header -->

<!-- styles -->
<link type="text/css" rel="stylesheet" href="<?= asset_url('/css/app/crm/main.css') ?>">
<link type="text/css" rel="stylesheet" href="<?= asset_url('/css/app/crm/onboarding.css') ?>">
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
        <main class="col-md-9 flex-grow-1">
            <div  class="card vh-100 bg-transparent border-0 m-3 p-0">
                <div class="onboarding-stepper <?= $clientHustleStatus == 'active' ? 'd-none' : null ?>">
                    <?php include "partials/dashboard/onboarding.php"; ?>
                </div>
                <div class="dashboard <?= $clientHustleStatus != 'active' ? 'd-none' : null  ?>">
                    <?php include "partials/dashboard/dashboard.php"; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- modals --> 
<!-- verify profile details modal -->
<div class="modal fade verify-profile-details-modal" id="verifyProfileModalId" data-bs-keyboard="false" data-bs-backdrop="false" tabindex="-1" aria-labelledby="verifyProfileModalIdLabel" aria-hidden="true"></div>
<!-- /verify profile details modal -->
<!-- /modals -->

<!-- footer -->
<?php include 'partials/layout/crm/footer.php'; ?>
<!-- /footer -->

<!-- xtra scripts -->
<script type="text/javascript" src="<?= asset_url('js/app/crm/auth.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/crm/onboarding.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/crm/dashboard.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/crm/hustle-map.js') ?>"></script>
<!-- xtra scripts -->

<!-- closure -->
<?php include 'partials/layout/global/closure.php'; ?>
<!-- /closure -->