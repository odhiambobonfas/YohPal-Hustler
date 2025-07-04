<div class="modal-dialog modal-md">
    <div class="modal-content rounded-4">
        <div class="modal-header">
            <h6 class="modal-title" id="verifyPhoneModalIdLabel">Verify Phone Number</h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <form action="/profile/confirm" method="post"> 
                <div class="mb-3">
                    <label for="verificationCode" class="form-label">Enter Verification Code</label>
                    <input type="text" id="verificationCode" name="verificationCode" class="form-control" placeholder="Enter code sent to your phone">
                </div>

                <div class="d-flex justify-content-between align-items-center py-3 pb-3">
                    <button type="submit" class="btn btn-outline-danger btn-sm confirm-detail-btn" data-id="phone">Confirm Code</button>
                    <button type="button" class="btn btn-link text-decoration-none p-0" id="resendCodeBtn">Resend Code</button>
                </div>
            </form>
        </div>
    </div>
</div>