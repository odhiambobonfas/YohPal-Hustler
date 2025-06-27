<!-- header -->
<?php include 'partials/layout/web/header.php'; ?>
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
        <!-- Sidebar -->
        <aside class="col-md-2 d-none d-md-block" id="sidebar">
            <div class="card bg-transparent border-0">
                <?php include 'partials/layout/crm/sidebar.php'; ?>
            </div>
        </aside>

        <!-- CRM Content -->
        <main class="col-md-9 flex-grow-1 bg-light">
            <div class="card bg-transparent border-0 m-1">

                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center bg-white rounded p-2 mb-3 m-2">
                    <h4 class="m-0">
                        <span id="sidebarToggleBtn" class="me-2"><i class="fas fa-bars fw-bold"></i></span>
                        Job Portal
                    </h4>
                    <div>
                        <a href="/dashboard" class="text-dark me-2"><i class="fas fa-home"></i></a>
                        <button class="btn btn-sm border-info rounded-pill">
                            <span class="badge text-dark">Job Portal Panel</span>
                        </button>
                    </div>
                </div>

                <!-- Portal start -->
                <div class="card bg-transparent border-0 rounded mb-3">
                    <div class="container-sm py-3">
                        <div class="category-listing">
                            <div style="background-image: url('<?= asset_url('store/images/banners/banner.png') ?>')" class="top-banner mb-3 text-dark" id="top-banner">
                                <h1>7,000+ Browse Jobs</h1>
                            </div>
                            <div class="row row-cols-2 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
                                <?php foreach ($hustleSuperCategories as $category): ?>
                                    <div class="col d-flex">
                                        <a href="javascript:void(0)" class="category-card-tag w-100 text-decoration-none" data-id="<?= $category['id'] ?>">
                                            <div class="card category-card shadow-sm w-100 h-100">
                                                <div class="card-body text-center p-4 d-flex flex-column justify-content-center align-items-center">
                                                    <div class="card-icon mb-3">
                                                        <i class="<?= htmlspecialchars($category['icon']) ?>"></i>
                                                    </div>
                                                    <h3 class="card-title h5 mb-0"><?= htmlspecialchars($category['name']) ?></h3>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="jobs-listing d-none">
                            <?php include "partials/job-portal/jobs-listing.php"; ?>
                        </div>
                    </div>
                </div>
                <!-- /Portal start -->
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
<script type="text/javascript" src="<?= asset_url('js/app/crm/job-portal.js') ?>"></script>
<!-- xtra scripts -->

<!-- closure -->
<?php include 'partials/layout/global/closure.php'; ?>
<!-- /closure -->