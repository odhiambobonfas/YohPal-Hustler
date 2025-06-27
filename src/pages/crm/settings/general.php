<!-- header -->
<?php include 'partials/layout/web/header.php'; ?>
<!-- /header -->

<!-- styles -->
<link type="text/css" rel="stylesheet" href="<?= asset_url('/css/app/crm/main.css') ?>">
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
            <div class="card bg-transparent border-0 m-3">

                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center bg-white rounded p-2 mb-3">
                    <h4 class="m-0">
                        <span id="sidebarToggleBtn" class="me-2"><i class="fas fa-bars fw-bold"></i></span>
                        General Settings
                    </h4>
                    <div>
                        <a href="/dashboard" class="text-dark me-2"><i class="fas fa-home"></i></a>
                        <button class="btn btn-sm border-info rounded-pill">
                            <span class="badge text-dark">Settings Management</span>
                        </button>
                    </div>
                </div>

                <div class="card bg-white border-0 rounded mb-3">
                    <div class="row g-0">
                        <div class="col-3">
                            <div class="card border-0">
                                <div class="card-body"> 
                                    <div class="list-group">
                                        <a href="#" class="list-group-item list-group-item-action active">General Settings</a>
                                        <a href="#" class="list-group-item list-group-item-action">Tax Settings</a>
                                        <a href="#" class="list-group-item list-group-item-action">Receipt Settings</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="card border-0">
                                <div class="card-body">
                                    <h4 class="card-title">General Settings</h4> 
                                    <hr>
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
<script type="text/javascript" src="<?= asset_url('js/app/crm/dashboard.js') ?>"></script>
<!-- xtra scripts -->

<!-- closure -->
<?php include 'partials/layout/global/closure.php'; ?>
<!-- /closure -->