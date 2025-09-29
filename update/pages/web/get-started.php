<!-- header -->
<?php include 'partials/layout/web/header.php'; ?>
<!-- /header -->

<!-- styles -->
<link type="text/css" rel="stylesheet" href="<?= asset_url('/css/global/master.css') ?>">
<link type="text/css" rel="stylesheet" href="<?= asset_url('/css/app/crm/onboarding.css') ?>">
<link type="text/css" rel="stylesheet" href="<?= asset_url('/css/app/web/get-started.css') ?>">
<!-- /styles -->

<!-- build main -->
<main class="main">
    <div class="container">
        <form action="/get-started/onboarding" method="post" enctype="multipart/form-data">
            <div class="row get-started-container align-items-center justify-content-center g-3">
                <div class="col-4">
                    <div class="card shadow-lg border-0 rounded-2 get-started-card pb-5">
                        <div class="card-body position-relative">
                            <div class="position-absolute top-0 end-0 p-3">
                                <input type="radio" class="form-check-input fa-2x text-danger role" name="clientRole" id="role-client" value="client" checked>
                            </div>
                            <div class="d-flex justify-content-center align-items-center py-3" style="min-height: 250px;">
                                <div class="text-center">
                                    <img class="get-started-icon-x1" src="<?= asset_url('store/images/icons/customer-service.png') ?>" alt="">
                                    <h3 class="fw-bold m-3"><span>Client</span></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card shadow-lg border-0 rounded-2 get-started-card pb-5">
                        <div class="card-body position-relative">
                            <div class="position-absolute top-0 end-0 p-3">
                                <input type="radio" class="form-check-input fa-2x text-danger role" name="hustlerRole" id="role-hustler" value="hustler">
                            </div>
                            <div class="d-flex justify-content-center align-items-center py-3" style="min-height: 250px;">
                                <div class="text-center">
                                    <img class="get-started-icon-x1" src="<?= asset_url('store/images/icons/customer-working.png') ?>" alt="">
                                    <h3 class="fw-bold m-3"><span>Hustler</span></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mx-auto w-75 my-5">
                <div class="card-footer bg-transparent border-0">
                    <div class="pt-0 d-flex justify-content-center align-items-center gap-3"> 
                        <div class="d-flex align-items-center gap-2">
                            <span class="dot"></span>
                            <span class="dot"></span>
                            <span class="dot active-dot"></span>
                        </div>

                        <button type="button" class="caret btn btn-light text-danger rounded-circle p-2 d-flex align-items-center justify-content-center get-started-submit-btn">
                            <i class="fa fa-caret-right" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>
<!-- /main -->

<!-- modals -->
<!-- /modals -->

<!-- footer -->
<?php include 'partials/layout/web/footer.php'; ?>
<!-- /footer -->

<!-- xtra scripts -->
<script type="text/javascript" src="<?= asset_url('js/app/web/web.js') ?>"></script>
<!-- xtra scripts -->

<!-- closure -->
<?php include 'partials/layout/global/closure.php'; ?>
<!-- /closure -->