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
                                            <a href="javascript:void(0)" class="category-card-tag w-100 text-decoration-none" data-id="<?= $category['slug'] ?>">
                                                <div class="card category-card shadow-sm w-100 h-100" id="cat-grid">
                                                    <div class="card-body text-center p-4 d-flex flex-column justify-content-center align-items-center">
                                                        <div class="card-icon mb-3 subcat-symbol d-flex align-items-center justify-content-center <?= !isset($category['icon']) ? 'd-none' : null ?>">
                                                            <i class="<?= isset($category['icon']) ?? htmlspecialchars($category['icon']) ?>"></i>
                                                        </div>
                                                        <h3 class="card-title h5 mb-0"><?= htmlspecialchars($category['name']) ?></h3>
                                                        <span class="mx-auto"><?= count($category['subcategory']) ?> job categories</span>
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
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="dropdown">
                                            <button class="btn btn-link p-1 border-gray rounded-0 dropdown-toggle" type="button" id="filtersDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-filter fa-2x text-dark"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end p-3" style="min-width: 250px;" aria-labelledby="filtersDropdown">
                                                <form id="filterForm">
                                                    <!-- Category select input -->
                                                    <div class="mb-2">
                                                        <label for="filterCategory" class="form-label mb-1">Category</label>
                                                        <select multiple class="form-control form-control-sm searchSelect" name="category" id="category">
                                                            <option>Select Category</option>
                                                        </select>
                                                    </div>

                                                    <!-- Sub category select input -->
                                                    <div class="mb-2">
                                                        <label for="filterSubCategory" class="form-label mb-1">Category</label>
                                                        <select multiple class="form-control form-control-sm searchSelect" name="subCategory" id="subCategory">
                                                            <option>Select Category</option>
                                                        </select>
                                                    </div>

                                                    <!-- Date filter -->
                                                    <div class="mb-2">
                                                        <label for="filterDate" class="form-label mb-1">Date</label>
                                                        <input type="date" class="form-control form-control-sm" id="filterDate" name="date">
                                                    </div>

                                                    <!-- Filter Button -->
                                                    <button type="submit" class="btn btn-sm btn-primary w-100 mt-2">Apply Filters</button>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Refresh Button -->
                                        <button type="button" id="refreshMapBtn" class="btn btn-link p-1 border-gray rounded-0 refresh-map-btn">
                                            <i class="bi bi-arrow-clockwise fa-2x text-success"></i>
                                        </button>
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
<script>
    class JobPortal extends Master {
        constructor() {
            super();
            // ANY Constructor logic applicable
            this.stepperSections = document.querySelectorAll('.job-portal-step-section');
            this.categoryCards = document.querySelectorAll('.category-card-tag');
            this.contentSection = document.querySelector('.content-section');
            this.categoryListing = document.querySelector('.category-listing');
            this.jobsListing = document.querySelector('.jobs-listing');
            this.mapSection = document.querySelector('.mapping-section');
            this.backBtns = undefined;
            this.selected_job = undefined;
        }

        setupPage() {
            this.initOverlay(this.contentSection);
            this.bindCategoryClicks();
        }

        bindCategoryClicks() {
            this.categoryCards.forEach(card => {
                card.addEventListener('click', () => {
                    const categoryId = card.getAttribute('data-id');

                    this.showOverlay();

                    setTimeout(() => {
                        $.ajax({
                            type: "GET",
                            url: `/portal/jobs/view/${categoryId}`,
                            dataType: "json",
                            success: function(response) {
                                (new JobPortal()).categoryListing.classList.add('d-none');
                                let jobsListing = (new JobPortal()).jobsListing;
                                if (!response.htmlContent) return;
                                __append_html(
                                    response.htmlContent,
                                    jobsListing
                                );
                                (new JobPortal()).jobsListing.classList.remove('d-none');
                                (new JobPortal()).hideOverlay();
                                (new JobPortal()).bindBackBtnClick();
                                (new JobPortal()).bindTabClicks('.sub-category-tab');
                                enableToggleHighlight('.job-list-group', [(new JobPortal()).createJobDraft]);
                            },
                            error: error => {
                                console.log(error.message || error);
                                toast('error', 5000, lang.undefined_error);
                            }
                        });
                    }, 800);
                });
            });
        }

        /**
         * Binds the click event to the back button.
         * When triggered, it hides the jobs listing section
         * and shows the category listing section.
         * 
         * @return {void} void
         */
        bindBackBtnClick() {
            this.backBtns = document.querySelectorAll('.backBtn');

            this.backBtns.forEach(backBtn => {
                if (!documentContains(backBtn)) return;

                backBtn.addEventListener('click', () => {
                    this.showOverlay();
                    setTimeout(() => {
                        this.stepperSections.forEach(section => section.classList.add('d-none'));
                        this.categoryListing.classList.remove('d-none');
                        this.hideOverlay();
                    }, 2000);
                });
            });
        }

        filterOutSubCategoriesBodyContentUponTabClicks() {
            // Filter out jobs based on the sub category tab clicked.
        }

        createJobDraft(subCategoryId, extra_params = []) {
            __show_modal('.create-job-modal');
            const createJobForm = document.querySelector('.create-job-modal-form');
            if (!documentContains(createJobForm)) return;
            createJobForm.setAttribute('action', `/job/create/${subCategoryId}`);
            createJobForm.querySelector('.job-title').value = extra_params['job_name'] || '';
            flatpickrUtil();

            let btn = document.querySelector('.create-job-submit-btn');
            if (!documentContains(btn)) return;
            btn = cloneNodeElement(btn);
            btn.addEventListener('click', event => {
                event.preventDefault();
                toggleButtonContent(btn);
                disableElement(btn);
                let form = btn.closest('form');
                let data = serializeFormToArray(form);

                $.ajax({
                    type: 'POST',
                    url: `${form.action}/${subCategoryId}`,
                    data: data,
                    dataType: "json",
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        console.log(response);
                        toggleButtonContent(btn, '', true);
                        enableElement(btn);

                        if (response && response.status && response.status == 'success') {
                            toast(response.status, 5000, response.message || lang.undefined_error);
                            resetFormAndCloseModal(form);
                            (new JobPortal()).showOverlay();
                            setTimeout(() => {
                                (new JobPortal()).stepperSections.forEach(section => section.classList.add('d-none'));
                                (new JobPortal()).mapSection.classList.remove('d-none');
                                (new JobPortal()).hideOverlay();
                                (new JobPortal()).bindBackBtnClick();
                                (new JobPortal()).getActiveHustlers();
                            }, 1000); // Avoid race condition...
                            return;
                        }

                        if (response && response.status && response.status == 'error') {
                            toast(response.status, 5000, response.message || lang.undefined_error);
                            return;
                        }

                        toast('error', 5000, lang.undefined_error);
                    },
                    error: error => {
                        console.log(error.message || error);
                        toggleButtonContent(btn, '', true);
                        enableElement(btn);
                        toast('error', 5000, lang.undefined_error);
                    }
                });
            });
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const dashboardInstance = new JobPortal();
        dashboardInstance.setupPage();
    });
</script>
<script type="text/javascript" src="<?= asset_url('js/app/crm/hustle-map.js') ?>"></script>
<!-- xtra scripts -->

<!-- closure -->
<?php include 'partials/layout/global/closure.php'; ?>
<!-- /closure -->