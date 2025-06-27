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
            <div class="card bg-transparent border-0 m-3">

                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center bg-white rounded p-2 mb-3">
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
                <div class="card bg-white border-0 rounded mb-3">
                    <div class="container-sm py-3">
                        <div style="background-image: url('<?= asset_url('store/images/banners/banner.png') ?>')" class="top-banner mb-3 text-dark" id="top-banner">
                            <h1>7,000+ Browse Jobs</h1>
                        </div>
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
                            <?php foreach ($hustleSuperCategories as $category): ?>
                                <div class="col" data-id="<?= $category['icon'] ?>">
                                    <div class="card category-card shadow-sm h-100">
                                        <div class="card-body text-center p-4">
                                            <div class="card-icon">
                                                <i class="<?= htmlspecialchars($category['icon']) ?>"></i>
                                            </div>
                                            <h3 class="card-title h5"><?= htmlspecialchars($category['name']) ?></h3>
                                            <a href="#" class="stretched-link" data-bs-toggle="modal" data-bs-target="#categoryModal"
                                                data-category="<?= htmlspecialchars($category['name']) ?>"></a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
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
<script type="text/javascript" src="<?= asset_url('js/app/crm/profile.js') ?>"></script>
<!-- xtra scripts -->

<!-- closure -->
<?php include 'partials/layout/global/closure.php'; ?>
<!-- /closure -->