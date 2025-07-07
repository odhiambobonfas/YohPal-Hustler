<!-- forgot pass form sits in here -->
<div class="vh-100 d-flex align-items-center justify-content-center">
    <div class="row w-100 g-0 bg-white shadow-lg" style="max-width: 90%;">
        <div class="col-md-6">
            <div class="card border-transparent border-0 rounded-0 h-100 p-5">
                <div class="card-body">
                    <form class="sign-in-form" action="/forgot-password" method="post">
                        <h2 class="card-title text-start mb-4">YOHPAL</h2>
                        <h5 class="card-text text-start mb-3">Forgot Password!</h5>
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="xyz@example.com" autocomplete="off" autocapitalize="off" autocorrect="off" spellcheck="false">
                        </div> 
                        <div class="form-group mb-3">
                            <button type="button" class="btn btn-danger w-100 p-2 rounded-0 forgot-pass-submit-btn">Send</button>
                        </div>
                    </form>

                    <div class="actions d-flex align-items-center text-muted my-4">
                        <hr class="flex-grow-1">
                        <span class="px-3">Remembered Password?</span>
                        <hr class="flex-grow-1">
                    </div>

                    <p class="text-center">
                        <a href="/login" class="btn btn-link text-dark">Sign In</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6 d-none d-md-block">
            <div style="background-image: url('<?= asset_url("/store/images/bg/login.jpg") ?>')" class="card border-transparent border-0 bg-image rounded-0 h-100 p-5"></div>
        </div>
    </div>
</div>