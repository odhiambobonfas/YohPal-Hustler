<div class="modal-dialog modal-md">
    <div class="modal-content rounded-4">
        <div class="modal-body">
            <div class="text-center mb-4">
                <img src="<?= asset_url('/store/images/bg/contact-verification-img.jpeg') ?>" alt="Verify Contact" class="img-fluid modal-header-img mb-3">
                <h4 class="fw-semibold">Verify Phone Number</h4>
                <p class="text-muted">
                    Enter the OTP sent to <strong><?= isset($profile->phoneNumber) ? $profile->phoneNumber : '+2547XXXXXXX' ?></strong>
                </p>
            </div>

            <form action="/profile/contact/confirm" method="post">
                <div class="mb-4 text-center">
                    <label for="verificationCode" class="form-label">Enter Verification Code</label>
                    <div id="otp-input-group" class="d-flex justify-content-center gap-2">
                        <?php for ($i = 1; $i <= 6; $i++): ?>
                            <input type="text" name="verificationCode[]" maxlength="1" class="form-control text-center rounded-1 otp-input-box">
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="d-flex flex-column align-items-center pt-3">
                    <button type="button" class="btn btn-danger btn-md border-radius-50 mb-2 verify-otp-submit-btn">
                        Verify OTP
                    </button>
                    <button type="button" class="btn btn-link text-decoration-none d-block w-100 text-danger text-center" id="resendCodeBtn">
                        Resend
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>