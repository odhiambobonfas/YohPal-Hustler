<!-- header -->
<?php include 'partials/layout/web/header.php'; ?>
<!-- /header -->

<!-- navbar -->
<?php include 'partials/layout/crm/navbar.php'; ?>
<!-- /navbar -->

<!-- styles -->
<link type="text/css" rel="stylesheet" href="<?= asset_url('/css/app/web/dashboard.css') ?>">
<!-- /styles -->

<!-- main -->
<main class="main">
    <!-- side navbar -->
    <?php include "partials/layout/crm/sidebar.php" ?>
    <!-- /side navbar -->
</main>
<!-- /main -->

<!-- modals -->
<!-- /modals -->

<!-- footer -->
<?php include 'partials/layout/web/footer.php'; ?>
<!-- /footer -->

<!-- xtra scripts --> 
<script type="text/javascript" src="<?= asset_url('js/app/crm/auth.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/web/dashboard.js') ?>"></script>
<!-- xtra scripts -->

<!-- closure -->
<?php include 'partials/layout/global/closure.php'; ?>
<!-- /closure -->