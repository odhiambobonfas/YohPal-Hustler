<div class="card bg-transparent border-0">
    <!-- Card Header -->
    <div class="card-header bg-white border-0">
        <div class="d-flex bg-transparent align-items-center justify-content-between ">
            <button class="btn btn-md btn-link me-2 text-nowrap backBtn float-start" id="backBtn">
                <i class="bi bi-arrow-left"></i>
            </button>
            <div class="quick-actions float-end">
                <button class="btn btn-md btn-outline-danger me-2 text-nowrap create-job float-end" id="createJob">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i> Create Job
                </button>
            </div>
        </div>
    </div>
    <div class="card-body p-0 m-0 g-0 mt-3"> 
        <?php include "partials/job-portal/geomap.php" ?>
    </div>
</div>