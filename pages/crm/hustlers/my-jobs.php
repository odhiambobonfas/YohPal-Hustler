<!-- header -->
<?php include 'partials/layout/web/header.php'; ?>
<!-- /header -->

<!-- styles -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link type="text/css" rel="stylesheet" href="<?= asset_url('/css/app/crm/main.css') ?>">
<link type="text/css" rel="stylesheet" href="<?= asset_url('/css/app/crm/dashboard.css') ?>">
<style>
.job-card { cursor: pointer; transition: all 0.3s; }
.job-card:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
.job-card.active { border: 2px solid #28a745 !important; background: #f0fff4; }
#jobMap { height: 100%; min-height: 500px; }
</style>
<!-- /styles -->

<!-- navbar -->
<?php include 'partials/layout/crm/navbar.php'; ?>
<!-- /navbar -->

<!-- Main CRM Section -->
<div class="crm-section">
    <div class="d-flex gap-3">
        <!-- Sidebar -->
        <aside class="col-md-2" id="sidebar">
            <div class="card bg-transparent border-0">
                <?php include 'partials/layout/crm/sidebar.php'; ?>
            </div>
        </aside>

        <!-- CRM Content -->
        <main class="col-md-10 flex-grow-1">
            <div class="card bg-transparent border-0 m-3 p-3">
                <h2 class="mb-4"><i class="fas fa-briefcase"></i> My Jobs</h2>
                
                <div class="row">
                    <!-- Jobs List -->
                    <div class="col-md-4">
                        <input type="search" id="jobSearch" class="form-control mb-3" placeholder="Search jobs...">
                        <div id="jobsList" style="max-height: 70vh; overflow-y: auto;">
                            <div class="text-center p-4">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Map View -->
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><i class="fas fa-map-marked-alt"></i> Job Location & Tracking</h5>
                                <button id="centerMapBtn" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-crosshairs"></i> Center on Me
                                </button>
                            </div>
                            <div class="card-body p-0">
                                <div id="jobMap"></div>
                            </div>
                            <div class="card-footer" id="jobInfo" style="display: none;">
                                <h6 id="jobTitle" class="mb-2"></h6>
                                <div id="jobDetails" class="small text-muted"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- footer -->
<?php include 'partials/layout/crm/footer.php'; ?>
<!-- /footer -->

<!-- Load location services -->
<script type="text/javascript" src="<?= asset_url('js/app/web/services/device-info.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/web/services/location-service.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/web/services/geocoding-service.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/web/services/realtime-location.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/web/utils/distance-calculator.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/web/utils/polyline-renderer.js') ?>"></script>

<script type="text/javascript" src="<?= asset_url('js/app/crm/my-jobs-map.js') ?>"></script>

<!-- closure -->
<?php include 'partials/layout/global/closure.php'; ?>
<!-- /closure -->
