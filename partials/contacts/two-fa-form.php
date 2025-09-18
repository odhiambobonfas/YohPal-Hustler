<!-- forgot pass form sits in here -->
<div class="vh-100 d-flex align-items-center justify-content-center">
    <div class="row w-100 g-0 bg-white shadow-lg" style="max-width: 90%;">
        <div class="col-md-6">
            <div class="card border-transparent border-0 rounded-0 h-100 p-5">
                <div class="card-body">
                    <h5 class="fw-semibold mb-3">Welcome to <?= $auth_role ?? 'client' ?> mode.<br>Start your journey to flexible work today.</h5>

                    <form class="two-fa-form py-5" action="/contact/verify" method="post">
                        <div class="mb-3">
                            <label for="contactInput" class="form-label">Email/Phone</label>
                            <input value="<?= isset($profile->phoneNumber) ? $profile->phoneNumber : null ?>" type="text" class="form-control form-control-lg" id="contactInput" name="contact" placeholder="Enter your email or phone number">
                        </div>
                        <button type="button" class="btn btn-danger float-end px-4 verify-contact-btn">Send</button>
                    </form> 
                </div>
            </div>
        </div>
        <div class="col-md-6 d-none d-md-block">
            <div style="background-image: url('<?= asset_url("/store/images/bg/two-fa-section.jpeg") ?>')" class="card border-transparent border-0 bg-image rounded-0 h-100 p-5"></div>
        </div>
    </div>
</div>