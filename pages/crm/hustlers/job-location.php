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
        <!-- Sidebar -->
        <aside class="col-md-2 d-none d-md-block" id="sidebar">
            <div class="card bg-transparent border-0">
                <?php include 'partials/layout/crm/sidebar.php'; ?>
            </div>
        </aside>

        <!-- CRM Content -->
        <main class="col-md-9 flex-grow-1">

            <div class="card vh-100 bg-transparent border-0 m-3 p-0 d-flex flex-column justify-content-center">
                <div class="position-relative rounded overflow-hidden border" style="height: 90%;background-color: #f2f2f2;">
                    <div class="d-flex align-items-center justify-content-center h-100 text-muted geomap">
                        <!-- Map render sits in here -->
                    </div>
                    <div class="position-absolute bottom-0 start-50 translate-middle-x mb-2 text-muted small">
                        © <?= date("Y") ?> Map Provider
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
<script type="text/javascript" src="<?= asset_url('js/app/crm/client-map.js') ?>"></script>

<!-- xtra scripts -->
<script type="text/javascript" src="<?= asset_url('js/app/crm/auth.js') ?>"></script>
<!-- <script type="text/javascript" src="<?= asset_url('js/app/crm/dashboard.js') ?>"></script> -->
<script type="text/javascript" src="<?= asset_url('js/app/crm/onboarding.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/crm/hustle-map.js') ?>"></script>
<!-- xtra scripts -->

<!-- closure -->
<?php include 'partials/layout/global/closure.php'; ?>
<!-- /closure -->
