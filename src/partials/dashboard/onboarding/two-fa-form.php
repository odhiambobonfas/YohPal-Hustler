<h5 class="fw-semibold mb-3">Welcome to Hustler mode.<br>Start your journey to flexible work today.</h5>

<form class="two-fa-form py-5" action="/profile/contact/verify" method="post">
    <div class="mb-3">
        <label for="contactInput" class="form-label">Email/Phone</label>
        <input value="<?= isset($profile->phoneNumber) ? $profile->phoneNumber : null ?>" type="text" class="form-control form-control-lg" id="contactInput" name="contact" placeholder="Enter your email or phone number">
    </div>
    <button type="button" class="btn btn-danger float-end px-4 verify-contact-btn">Send</button>
</form>