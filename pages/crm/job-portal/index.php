<!-- header -->
<?php include 'partials/layout/crm/header.php'; ?>
<!-- /header -->

<!-- styles -->
<link type="text/css" rel="stylesheet" href="<?= asset_url('/css/app/crm/main.css') ?>">
<link type="text/css" rel="stylesheet" href="<?= asset_url('/css/app/crm/job-portal.css') ?>">
<!-- /styles -->

<!-- navbar -->
<?php include 'partials/layout/crm/navbar.php'; ?>
<!-- /navbar -->

<!-- Main CRM Section -->
<div class="crm-section">
    <div class="d-flex gap-3">
        <!-- Sidebar - Always present, toggleable on mobile -->
        <aside class="col-md-2" id="sidebar">
            <div class="card bg-transparent border-0">
                <?php include 'partials/layout/crm/sidebar.php'; ?>
            </div>
        </aside>

        <!-- CRM Content -->
        <main class="col-md-9 flex-grow-1 mt-5">
            <div class="card bg-transparent border-0 mt-5">

                <div class="job-search-c p-2 p-md-0">
                    <h1>Let's find you a <span style="color: #ff0000;">Hustler</span></h1>
                    <div class="job-search p-2 border border-secondary rounded-pill d-flex align-items-center">
                      <input type="search"
                        class="form-control border-0 shadow-none flex-grow-1"
                        autofocus
                        placeholder="Search for a skill..."
                        id="job-search-val" />
                      <button class="btn fs-5 w-50 w-md-25 p-2 rounded-pill">Find skill</button>
                    </div>
                </div>

                <!-- Portal start -->
                <div class="card bg-transparent border-0 rounded p-3">
                    <div class="content-section">
                        <div class="jobs" id="jobs"></div>

                            <div class="job-portal-step-section jobs-listing d-none">
                                <?php include "partials/job-portal/jobs-listing.php"; ?>
                            </div>
                        <div class="job-portal-step-section mapping-section d-none">
                                <!-- Header -->
                                <div class="d-flex justify-content-between align-items-center rounded p-2 mb-1 m-2">
                                    <div class="aside-content">
                                        <button class="btn btn-md btn-link me-2 text-nowrap backBtn float-start text-start" id="backBtn">
                                            <i class="fas fa-arrow-left"></i>
                                        </button>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <!-- Refresh Button -->
                                        <button type="button" id="refreshMapBtn" class="btn btn-link p-1 border-gray rounded-0 refresh-map-btn">
                                            <i class="bi bi-arrow-clockwise fa-2x text-success"></i>
                                        </button>
                                    </div>
                                </div>
                            <?php include "partials/job-portal/mapping-map.php"; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Portal start -->
            </div>
        </main>
    </div>
</div>

<!-- modals -->
<div class="modal fade create-job-modal" id="create-job-modal">
    <?php include "partials/job-portal/create-job-modal.php" ?>
</div>
<!-- /modals -->


<!-- footer -->
<?php include 'partials/layout/crm/footer.php'; ?>
<!-- /footer -->

<!-- Load new location services for advanced features -->
<script type="text/javascript" src="<?= asset_url('js/app/web/services/hustler-loader-api.js') ?>"></script>
<script type="module" src="<?= asset_url('js/app/web/services/hustler-loader.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/web/services/location-service.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/web/services/geocoding-service.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/web/services/realtime-location.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/web/utils/distance-calculator.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/web/utils/polyline-renderer.js') ?>"></script>

<!-- xtra scripts -->
<script type="text/javascript" src="<?= asset_url('js/app/crm/auth.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/crm/dashboard.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/crm/hustle-map.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/crm/job-portal.js') ?>"></script>


<!-- closure -->
<?php include 'partials/layout/global/closure.php'; ?>
<!-- /closure -->
