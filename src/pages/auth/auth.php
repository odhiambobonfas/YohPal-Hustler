<!-- header -->
<?php include 'partials/layout/web/header.php'; ?>
<!-- /header -->

<!-- styles -->
<link type="text/css" rel="stylesheet" href="<?= asset_url('/css/app/web/main.css') ?>">
<!-- /styles --> 
 
<!-- main -->
<main class="container">
    <div class="forms-container">
        <div class="signin-signup">
            <form action="/auth/login" method="POST" class="sign-in-form">
                <img src="https://yohpals.com/img/favicon.png" class="logo" alt="">
                <h2 class="title">Sign in</h2> 
                <div class="input-field">
                    <i class="fas fa-user mt-3"></i>
                    <input value="gicehajunior76@gmail.com" type="text" placeholder="Email" name="email" style="font-size: 12px;" />
                </div>
                <div class="input-field">
                    <i class="fas fa-lock mt-3"></i>
                    <input value="iE6M&bHMm&u9D,]" type="password" name="password" placeholder="Password" style="font-size: 12px;" />
                </div>
                <input type="button" value="Login" class="btn solid login-submit-btn" />
                <div class="spacer"></div>
                <a href="/forgot-password">Forgot your password?</a>
                <p class="social-text">Sign in to access your account</p>
            </form>

            <form action="/auth/signup" method="POST" class="sign-up-form">
                <img src="https://yohpals.com/img/favicon.png" class="logo" alt="">
                <h2 class="title">Sign up</h2> 
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="email" placeholder="Email" name="email" style="font-size: 12px;" class="input-text" />
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" placeholder="Enter password" name="password1" style="font-size: 12px;" />
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" placeholder="Confirm password" name="password2" style="font-size: 12px;" />
                </div>
                <input type="button" class="btn signup-submit-btn" value="Sign up" />
                <p class="social-text">Create an account with Us!</p>
            </form>
        </div>
    </div>

    <div class="panels-container">
        <div class="panel left-panel">
            <div class="content">
                <h3>Welcome to YohPal Hustler </h3><br />
                <h3>New here ?</h3>
                <p>
                    Join us today and unlock exclusive features! Sign up now to get started on your journey.
                </p>
                <button class="btn transparent auth-toggle-btn sign-up-btn" id="sign-up-btn">Sign up</button>
            </div>
            <img src="<?= asset_url('store/images/icons/log.svg') ?>" class="image" alt="" />
        </div>
        <div class="panel right-panel">
            <div class="content">
                <h3>Welcome to YohPal Hustler </h3><br />
                <h3>One of us ?</h3>
                <p>
                    Welcome back! Sign in now to access amazing content and exclusive benefits made just for you.
                </p>
                <button class="btn transparent auth-toggle-btn sign-in-btn" id="sign-in-btn">Sign in</button>
            </div>
            <img src="<?= asset_url('store/images/icons/register.svg') ?>" class="image" alt="" />
        </div>
    </div>
</main>
<!-- /main --> 

<!-- modals -->
<!-- /modals -->

<!-- footer -->
<?php include 'partials/layout/web/footer.php'; ?>
<!-- /footer -->

<!-- xtra scripts -->
<!-- xtra scripts -->

<!-- closure -->
<?php include 'partials/layout/global/closure.php'; ?>
<!-- /closure -->