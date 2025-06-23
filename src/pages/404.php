<!-- header -->
<?php include "partials/layout/header.php" ?>
<!-- /header -->

<!-- custom Styles -->
<link rel="stylesheet" href="<?= asset_url('css/global/404.css') ?>">
<!-- /custom Styles -->

<div class="main">
    <!-- navbar section -->
    <div class="navbar-section">
        <?php include "partials/layout/navbar.php" ?>
    </div>
    <!-- /navbar section -->

    <!-- sidebar section -->
    <div class="sidebar-section">
        <?php include "partials/layout/header.php" ?>
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
<?php include "partials/layout/footer.php" ?>
<!-- /footer -->