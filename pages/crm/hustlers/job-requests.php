<!-- header -->
<?php include 'partials/layout/web/header.php'; ?>
<!-- /header -->

<!-- styles -->
<link type="text/css" rel="stylesheet" href="<?= asset_url('/css/app/crm/main.css') ?>">
<link type="text/css" rel="stylesheet" href="<?= asset_url('/css/app/crm/profile.css') ?>">
<!-- /styles -->

<!-- navbar -->
<?php include 'partials/layout/crm/navbar.php'; ?>
<!-- /navbar -->

<!-- Main CRM Section -->
<div class="crm-section">
    <div class="d-flex gap-3">
        <!-- Sidebar -->
        <aside class="col-md-2" id="sidebar">
            <div class="card bg-transparent border-0">
                <?php include 'partials/layout/crm/sidebar.php'; ?>
            </div>
        </aside>

        <!-- CRM Content -->
        <main class="col-md-9 flex-grow-1 bg-light">
            <div class="card bg-transparent border-0 mt-5 p-3">
                <!-- Profile start -->
                <div class="w-100 d-flex align-items-center justify-content-center">
                    <input type="search" id="requestSearch" class="w-50 ml-10 p-3 rounded-pill border fs-5" placeholder="search"/>
                </div>
                <div class="d-flex flex-row p-3" style="height:85svh;">

                    <div class="d-flex flex-column w-50 gap-2">
                        <div class="d-flex flex-column p-2 gap-3 bg-light gap-2 flex-grow-1 overflow-auto" id="requestsList">
                            <!-- Loading skeleton for job list -->
                            <div id="requestsLoading" class="placeholder-glow">
                                <div class="border my-2 card d-flex flex-column gap-2 rounded-3 p-3">
                                    <div class="placeholder col-8"></div>
                                    <div class="placeholder col-4"></div>
                                    <div class="d-flex flex-row gap-3">
                                        <div class="placeholder col-3"></div>
                                        <div class="placeholder col-2"></div>
                                        <div class="placeholder col-2"></div>
                                    </div>
                                    <div class="placeholder col-6"></div>
                                    <div class="placeholder col-3"></div>
                                </div>
                                <div class="border my-2 card d-flex flex-column gap-2 rounded-3 p-3">
                                    <div class="placeholder col-7"></div>
                                    <div class="placeholder col-5"></div>
                                    <div class="d-flex flex-row gap-3">
                                        <div class="placeholder col-3"></div>
                                        <div class="placeholder col-2"></div>
                                        <div class="placeholder col-2"></div>
                                    </div>
                                    <div class="placeholder col-5"></div>
                                    <div class="placeholder col-3"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-column h-auto gap-2 container-fluid p-3 card">
                        <div class="d-flex flex-row justify-content-start gap-3 align-items-center">
                            <button id="acceptBtn" class="w-25 btn btn-success rounded-3" onclick="acceptRequest()">
                                <i class="fas fa-check"></i>
                                Accept
                            </button>
                            <button id="rejectBtn" class="w-25 btn border-0 btn-danger rounded-3" onclick="rejectRequest()">
                                <i class="fas fa-ban"></i>
                                Reject
                            </button>
                        </div>
                        <hr/>
                        <div class="px-3 m-0" id="requestDetails">
                            <!-- Loading skeleton for details -->
                            <div id="detailsLoading" class="placeholder-glow">
                                <div class="placeholder col-8 mb-3" style="height: 2rem;"></div>
                                <div class="placeholder col-4 mb-3"></div>
                                <div class="d-flex flex-row flex-wrap gap-3 mb-3">
                                    <div class="placeholder col-2"></div>
                                    <div class="placeholder col-2"></div>
                                    <div class="placeholder col-2"></div>
                                    <div class="placeholder col-2"></div>
                                </div>
                                <div class="d-flex flex-row gap-2 mb-3">
                                    <div class="placeholder col-1"></div>
                                    <div class="placeholder col-1"></div>
                                </div>
                                <hr/>
                                <div class="placeholder col-4 mb-2" style="height: 1.5rem;"></div>
                                <div class="placeholder col-12 mb-2"></div>
                                <div class="placeholder col-10 mb-3"></div>
                                <hr/>
                                <div class="placeholder col-3 mb-3" style="height: 1.5rem;"></div>
                                <div class="d-flex flex-row justify-content-between mb-2">
                                    <div class="placeholder col-2"></div>
                                    <div class="placeholder col-3"></div>
                                </div>
                                <div class="d-flex flex-row justify-content-between mb-2">
                                    <div class="placeholder col-2"></div>
                                    <div class="placeholder col-3"></div>
                                </div>
                                <div class="d-flex flex-row justify-content-between mb-2">
                                    <div class="placeholder col-2"></div>
                                    <div class="placeholder col-3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
<script type="text/javascript" src="<?= asset_url('js/app/crm/hustler-requests.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/crm/auth.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/crm/account.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/crm/dashboard.js') ?>"></script>
<script type="text/javascript" src="<?= asset_url('js/app/crm/profile.js') ?>"></script>
<!-- xtra scripts -->

<!-- closure -->
<?php include 'partials/layout/global/closure.php'; ?>
<!-- /closure -->
