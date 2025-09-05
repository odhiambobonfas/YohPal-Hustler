<!-- header -->
<?php include 'partials/layout/crm/header.php'; ?>
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
                <!-- Preferences -->
                <div class="mb-4">
                    <h5 class="mb-3">Preferences</h5>
                    <form>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="darkMode">
                            <label class="form-check-label" for="darkMode">Enable Dark Mode</label>
                        </div>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="emailNotif" checked>
                            <label class="form-check-label" for="emailNotif">Email Notifications</label>
                        </div>
                    </form>
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
<script type="text/javascript" src="<?= asset_url('js/app/crm/profile.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/crm/dashboard.js') ?>"></script>
<!-- xtra scripts -->

<!-- closure -->
<?php include 'partials/layout/global/closure.php'; ?>
<!-- /closure -->
