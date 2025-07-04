<!-- Header -->
<div class="d-flex justify-content-between align-items-center rounded p-2 mb-3 m-2">
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

<!-- Stepper -->
<div class="container stepper-wrapper">
    <!-- Step 1: Carousel -->
    <div class="stepper-section stepper-one bg-white rounded shadow-sm d-flex flex-column align-items-center justify-content-center">
        <div id="carouselId" class="carousel slide w-100" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselId" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselId" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselId" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner rounded" role="listbox">
                <div class="col-md-6 carousel-item p-4 active">
                    <img src="<?= asset_url('store/images/app/businessman.png') ?>" class="img-fluid mx-auto d-block w-100 h-100 carousel-img" alt="First slide">
                </div>
                <div class="col-md-6 carousel-item p-4">
                    <img src="<?= asset_url('store/images/avatars/default-avatar.jpg') ?>" class="img-fluid mx-auto d-block w-100 h-100 carousel-img" alt="Second slide">
                </div>
                <div class="col-md-6 carousel-item p-4">
                    <img src="<?= asset_url('store/images/avatars/default-avatar.jpg') ?>" class="img-fluid mx-auto d-block w-100 h-100 carousel-img" alt="Third slide">
                </div>
            </div>
            <button class="carousel-control-prev text-dark" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
                <i class="fas fa-chevron-left fa-2x text-dark"></i>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next text-dark" type="button" data-bs-target="#carouselId" data-bs-slide="next">
                <i class="fas fa-chevron-right fa-2x text-dark"></i>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <!-- Step 2: Form -->
    <div class="stepper-section stepper-two rounded shadow-sm d-none">
        <form action="/profile/update" method="post">
            <div class="row g-3 m-2">
                <div class="col-md-6">
                    <label class="form-label">First Name:</label>
                    <input type="text" name="firstname" class="form-control" value="<?= !empty($profile) ? $profile->firstName : null ?>" placeholder="Enter first name">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Last Name:</label>
                    <input type="text" name="lastname" class="form-control" value="<?= !empty($profile) ? $profile->lastName : null ?>" placeholder="Enter last name">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Username:</label>
                    <input type="text" name="username" class="form-control" value="<?= !empty($profile) ? $profile->userName : null ?>" placeholder="Enter username">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email:</label>
                    <input type="email" name="email" class="form-control" value="<?= !empty($profile) ? $profile->email : null ?>" placeholder="Enter email address">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Mobile Number:</label>
                    <input type="text" name="phone" class="form-control" value="<?= !empty($profile) ? $profile->phoneNumber : null ?>" placeholder="Enter phone number">
                </div>
                <div class="col-12">
                    <label class="form-label">Bio:</label>
                    <textarea class="form-control" name="bio" id="bio" rows="3" placeholder="Tell us a bit about yourself..."><?= !empty($profile) ? $profile->bio : null ?></textarea>
                </div>
                <div class="col-12 mt-3 mb-3">
                    <button type="button" class="btn btn-outline-danger w-100 text-nowrap update-details-btn">Update Profile</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Step 3:  -->
    <div class="stepper-section stepper-three rounded shadow-sm d-none">
        <div class="container-fluid m-3 pb-3">
            <div class="pt-3 pb-3">
                <h4 class="text-start">Grow Your Career with Us!</h4>
                <span class="muted mb-3">Please complete the verification steps to secure your account!</span>
            </div>
            <form action="/profile/verify" method="post">
                <div class="container-fluid">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Email:</label>
                        <div class="input-group input-group-rounded me-3 flex-nowrap">
                            <input type="contact" name="contact" class="form-control border-0 bg-transparent"
                                value="<?= !empty($profile) ? $profile->email : (!empty($profile->email) ? $profile->email : null) ?>"
                                placeholder="Enter email address or Phone number">
                            <button class="btn text-danger p-2 me-2 verify-profile-detail-btn" data-id="email" type="button">Verify</button>
                        </div>
                    </div>
                    <div class="col-12 mt-3 mb-3">
                        <button type="button" class="btn btn-outline-danger w-100 text-nowrap verify-contact-btn">Verify</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Step 4:  -->
    <div class="stepper-section stepper-four rounded shadow-sm d-none">
        <h5>Ratings</h5>
    </div>

    <!-- Step 5:  -->
    <div class="stepper-section stepper-five rounded shadow-sm d-none">
        <h5>Upload Documents</h5>
    </div>

    <!-- Step 6:  -->
    <div class="stepper-section stepper-six rounded shadow-sm d-none">
        <h6>Onboarding Success</h6>
    </div>

    <!-- Action Button -->
    <div class="stepper-action-btn mx-auto mt-3 w-100 d-flex justify-content-center">
        <button type="button" class="btn btn-outline-danger w-100 text-nowrap proceed-next">Proceed Next</button>
    </div>
</div>