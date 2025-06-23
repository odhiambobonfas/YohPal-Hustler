<!-- header -->
<?php include 'partials/layout/web/header.php'; ?>
<!-- /header -->

<!-- custom Styles -->
<link type="text/css" rel="stylesheet" href="<?= asset_url('/css/app/web/landing.css') ?>">
<link type="text/css" rel="stylesheet" href="<?= asset_url('/css/global/404.css') ?>">
<!-- /custom Styles -->

<div class="main">
    <!-- navbar section -->
    <div class="navbar-section ms-3">
        <?php include "partials/layout/web/navbar.php" ?>
    </div>
    <!-- /navbar section -->

    <!-- sidebar section -->
    <div class="sidebar-section">
        <?php include "partials/layout/web/header.php" ?>
    </div>
    <!-- /sidebar section -->

    <!-- page content -->
    <div class="content-wrapper error-page">
        <h1 class="error-code">404</h1>
        <p class="error-message">Oops! The page you're looking for doesn't exist.</p>
        <a href="/" class="back-home-link">Go Back Home</a>
    </div>
    <!-- /page content -->
</div>

<!-- footer -->
<?php include 'partials/layout/web/footer.php'; ?>
<!-- /footer -->

<!-- closure -->
<?php include 'partials/layout/global/closure.php'; ?>
<!-- /closure -->