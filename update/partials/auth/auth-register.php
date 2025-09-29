<!-- register form sits in here -->
<div class="vh-100 d-flex align-items-center justify-content-center">
    <div class="row w-100 g-0 bg-white shadow-lg auth-card">
        <div class="col-md-6">
            <div class="card border-transparent border-0 rounded-0 h-100 p-5">
                <div class="card-body">
                    <form class="sign-in-form" action="/auth/login" method="post">
                        <h2 class="card-title text-start mb-4">YOHPAL</h2>
                        <h5 class="card-text text-start mb-3">Welcome to Yohpal Hustle!</h5>
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="xyz@example.com" autocomplete="off" autocapitalize="off" autocorrect="off" spellcheck="false">
                        </div>
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" autocomplete="off" autocapitalize="off" autocorrect="off" spellcheck="false">
                        </div>
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" autocomplete="off" autocapitalize="off" autocorrect="off" spellcheck="false">
                        </div>
                        <div class="form-group mb-3">
                            <button type="button" class="btn btn-danger w-100 p-2 rounded-0 signup-submit-btn">Signup</button>
                        </div>
                    </form>

                    <p class="text-center my-3 fw-bold align-items-center">
                        Already have an account? <a href="/login" class="btn btn-link text-dark">Sign In</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6 d-none d-md-block">
            <div style="background-image: url('<?= asset_url("/store/images/bg/generic-bg.jpg") ?>')" class="card border-transparent border-0 bg-image rounded-0 h-100 p-5"></div>
        </div>
    </div>
</div>
