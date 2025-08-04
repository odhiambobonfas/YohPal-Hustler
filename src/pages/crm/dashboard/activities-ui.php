<?php include 'partials/layout/web/header.php'; ?>
<!-- styles -->
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link type="text/css" rel="stylesheet" href="<?= asset_url('/css/app/crm/main.css') ?>">
<link type="text/css" rel="stylesheet" href="<?= asset_url('/css/app/crm/dashboard.css') ?>">
<link type="text/css" rel="stylesheet" href="<?= asset_url('/css/app/crm/activities.css') ?>">
<!-- /styles -->
<?php include 'partials/dashboard/activities-ui.php'; ?>

<script type="text/javascript" src="<?= asset_url('js/app/crm/activities.js') ?>"></script>
<!-- Ensure Bootstrap JS is included -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
