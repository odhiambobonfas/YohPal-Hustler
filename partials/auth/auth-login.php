<!-- login form sits in here -->
<div class="vh-100 d-flex align-items-center justify-content-center">
    <div class="row w-100 g-0 bg-white shadow-lg auth-card">
        <div class="col-md-6">
            <div class="card border-transparent border-0 rounded-0 h-100 p-5">
                <div class="card-body">
                    <form class="sign-in-form" action="/auth/login" method="post">
                        <h2 class="card-title text-start mb-4">YOHPAL</h2>
                        <h5 class="card-text text-start mb-3">Welcome back to Yohpal Hustle!</h5>
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input value="<?= env('APP_ENV') == 'development' ? env('TEST_USERNAME') : null; ?>" type="email" class="form-control" name="email" id="email" placeholder="xyz@example.com" autocomplete="off" autocapitalize="off" autocorrect="off" spellcheck="false">
                        </div>
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input value="<?= env('APP_ENV') == 'development' ? env('TEST_PASSWORD') : null; ?>" type="password" class="form-control" name="password" id="password" placeholder="Enter password" autocomplete="off" autocapitalize="off" autocorrect="off" spellcheck="false">
                        </div>
                        <div class="form-group d-flex align-items-center justify-content-between mb-3">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input text-danger" type="checkbox" name="rememberPassword" id="rememberPassword" value="checkedValue"> Remember password?
                                </label>
                            </div>
                            <div class="action-text">
                                <p class="fw-bold"><a class="text-dark" href="/forgot-password">Forgot your password?</a></p>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <button type="button" class="btn btn-danger w-100 p-2 rounded-0 login-submit-btn">Login</button>
                        </div>
                    </form>

                    <div class="actions d-flex align-items-center text-muted my-4">
                        <hr class="flex-grow-1">
                        <span class="px-3">Don't have an account?</span>
                        <hr class="flex-grow-1">
                    </div>

                    <p class="text-center">
                        <a href="/register" class="btn btn-link text-dark">Sign Up</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6 d-none d-md-block">
            <div style="background-image: url('<?= asset_url("/store/images/bg/generic-bg.jpg") ?>')" class="card border-transparent border-0 bg-image rounded-0 h-100 p-5"></div>
        </div>
    </div>
</div>
