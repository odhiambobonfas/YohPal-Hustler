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
        <main class="col-md-9 flex-grow-1 bg-transparent">
            <div class="card bg-transparent border-0 m-1">

                <!-- Portal start -->
                <div class="card bg-transparent border-0 rounded mb-3">
                    <div class="container-sm py-3">
                        <div class="content-section">
                            <div class="job-portal-step-section category-listing">
                                <?php include "partials/job-portal/generic-topbar.php" ?>
                                <div style="background-image: url('<?= asset_url('store/images/banners/banner.png') ?>')" class="top-banner mb-3 text-dark" id="top-banner">
                                    <h1>7,000+ Browse Jobs</h1>
                                </div>
                                <div class="row row-cols-2 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
                                    <?php foreach ($hustleSuperCategories as $category): ?>
                                        <div class="col d-flex">
                                            <a href="javascript:void(0)" class="category-card-tag w-100 text-decoration-none" data-id="<?= $category['id'] ?>">
                                                <div class="card category-card shadow-sm w-100 h-100" id="cat-grid">
                                                    <div class="card-body text-center p-4 d-flex flex-column justify-content-center align-items-center">
                                                        <div class="card-icon mb-3 subcat-symbol d-flex align-items-center justify-content-center">
                                                            <i class="<?= htmlspecialchars($category['icon']) ?>"></i>
                                                        </div>
                                                        <h3 class="card-title h5 mb-0"><?= htmlspecialchars($category['name']) ?></h3>
                                                        <span class="mx-auto"><?= count($category['subcategories']) ?> job categories</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="job-portal-step-section jobs-listing d-none">
                                <?php include "partials/job-portal/jobs-listing.php"; ?>
                            </div>

                            <div class="job-portal-step-section mapping-section d-none">
                                <!-- Header -->
                                <div class="d-flex justify-content-between align-items-center rounded p-2 mb-1 m-2">
                                    <div class="aside-content">
                                        <button class="btn btn-md btn-link me-2 text-nowrap backBtn float-start text-start" id="backBtn">
                                            <i class="bi bi-arrow-left"></i>
                                        </button>
                                    </div>
                                    <div class="input-group me-3">
                                        <input type="text" class="form-control border-gray input-search-bar p-2 rounded-0" name="inputSearch" id="inputSearch" aria-describedby="helpId" placeholder="Enter address here...">
                                    </div>
                                    <div class="job-filters">
                                        <button type="button" name="filtersValue" id="filtersValue" class="btn btn-link p-1 border-gray rounded-0"><i class="fas fa-filter fa-3x text-dark"></i></button>
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

<!-- xtra scripts -->
<script type="text/javascript" src="<?= asset_url('js/app/crm/auth.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/crm/dashboard.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/crm/job-portal.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/crm/hustle-map.js') ?>"></script>
<!-- xtra scripts -->

<!-- closure -->
<?php include 'partials/layout/global/closure.php'; ?>
<!-- /closure -->