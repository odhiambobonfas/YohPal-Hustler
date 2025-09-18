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
        <form action="/get-started/search-engine" method="post" enctype="multipart/form-data">
            <div class="row get-started-container align-items-center justify-content-center g-3">
                <div class="col-12 g-0">
                    <div class="card shadow-lg border-0 rounded-2 get-started-card pb-5">
                        <div class="card-body py-5">
                            <div class="position-relative py-5">
                                <div class="input-group position-relative">
                                    <input type="search" class="form-control searchInput" name="searchInput" id="searchInput" aria-describedby="helpId" placeholder="Search <?= $authRole == 'client' ? 'skills' : 'jobs' ?> here...">
                                    <button type="button" class="btn btn-outline-danger p-3"><i class="fas fa-search fa-2x"></i></button>
                                </div>
                                <div class="search-dropdown-container position-absolute"></div>
                            </div>
                        </div>

                        <div class="card-footer border-0 bg-transparent mx-auto">
                            <p class="text-center">Yohpal Search Engine &copy; <?= date('Y') ?> All rights reserved</p>
                        </div>
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