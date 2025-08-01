<!-- Header -->
<div class="d-flex justify-content-between align-items-center rounded p-2 mb-3">
    <h4 class="m-0">
        <span id="sidebarToggleBtn" class="me-2"><i class="fas fa-bars fw-bold"></i></span>
        Onboarding
    </h4>
    <div class="d-flex justify-content-between align-items-center">
        <a href="/dashboard" class="text-dark me-2">
            Home
        </a>
        <span><i class="bi bi-arrow-right me-2"></i></span>
        <span class="text-dark">Onboarding</span>
    </div>
</div>

<div class="h-100 w-100 d-flex bg-white shadow-lg d-flex justify-content-center align-items-center align-items-stretch my-2">
    <div class="w-100 g-0 d-flex align-items-stretch">
        <div class="col-12 col-md-6 d-flex flex-column justify-content-center">
            <div class="card bg-transparent border-0 rounded-0 p-4">
                <div class="card-body my-1">
                    <h3 class="fw-bold text-dark mb-3">YOHPAL</h3>
                    <form action="/account/activate-account" method="post" enctype="multipart/form-data">
                        <div class="stepper-section ratings-section d-none">
                            <?php include "onboarding/rating-setup-form.php" ?>
                        </div>
                        <div class="stepper-section uploads-section d-none">
                            <?php include "onboarding/portfolio-upload.php" ?>
                        </div>
                        <div class="stepper-section uploads-section d-none">
                            <?php include "onboarding/cv-upload.php" ?>
                        </div>
                        <div class="stepper-section uploads-section d-none">
                            <?php include "onboarding/certifications-uploads.php" ?>
                        </div>
                        <div class="stepper-section uploads-section d-none">
                            <?php include "onboarding/nid-upload.php" ?>

                            <div class="mb-3 d-flex justify-content-center align-items-center py-3">
                                <button type="button" name="activateAccount" id="activateAccount" class="btn btn-danger btn-md btn-block mx-auto activate-account">Activate Your Account</button>
                            </div>
                        </div>
                    </form>
                    <!-- <div class="stepper-section success-section d-none">
                        <div class="success-alert-image text-center mb-4 my-4">
                            <img class="onboarding-success-img-alert img-fluid" src="<?= asset_url("/store/images/bg/onboarding-success-alert.png") ?>" alt="Success Image">
                        </div>

                        <div class="text-center">
                            <h2 class="mb-3 fw-bold">Onboarding Success</h2>
                            <p class="text-muted mb-4">
                                Your profile has been set up successfully...
                            </p>
                            <button type="button" class="btn btn-danger px-4">Get Started</button>
                        </div>
                    </div> -->
                </div>
                <?php include "onboarding/progress-action-btns.php" ?>
            </div>
        </div>
        <div class="col-md-6 p-0 d-none d-md-block">
            <div style="background-image: url('<?= asset_url("/store/images/bg/ratings.jpeg") ?>');" class="card bg-transparent border-0 stepper-section-bg bg-image rounded-0 h-100 p-5"></div>
        </div>
    </div>
</div>
