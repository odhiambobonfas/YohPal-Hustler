<!-- header -->
<?php include 'partials/layout/web/header.php'; ?>
<!-- /header -->

<!-- styles -->
<link type="text/css" rel="stylesheet" href="<?= asset_url('/css/app/web/main.css') ?>">
<!-- /styles -->

<!-- main -->
<main class="main-content">
    <div class="container-fluid"> 
        <?php include "partials/contacts/two-fa-form.php"; ?>
    </div>
</main>
<!-- /main -->

<!-- modals -->
<!-- verify profile details modal -->
<div class="modal fade verify-profile-details-modal" id="verifyProfileModalId" data-bs-keyboard="false" data-bs-backdrop="false" tabindex="-1" aria-labelledby="verifyProfileModalIdLabel" aria-hidden="true"></div>
<!-- /verify profile details modal -->
<!-- /modals -->

<!-- footer -->
<?php include 'partials/layout/web/footer.php'; ?>
<!-- /footer -->

<!-- xtra scripts -->
<script type="text/javascript" src="<?= asset_url('js/app/crm/contacts.js') ?>"></script>
<!-- xtra scripts -->

<!-- closure -->
<?php include 'partials/layout/global/closure.php'; ?>
<!-- /closure -->