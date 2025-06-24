<!-- header -->
<?php include 'partials/layout/web/header.php'; ?>
<!-- /header -->

<!-- styles -->
<link type="text/css" rel="stylesheet" href="<?= asset_url('/css/app/web/main.css') ?>">
<!-- /styles -->

<!-- main -->
<main class="main">
    <div class="container">
        <div class="form-container">
            <div class="signin-signup">
                <form action="/forgot-password" method="POST" class="sign-in-form" id="forgot-password">
                    <img src="https://yohpals.com/img/favicon.png" class="logo" alt="">
                    <h2 class="title">Forgot Password</h2> 

                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="email" placeholder="Email" name="email" id="email" style="font-size: 12px;" required />
                    </div>
                    <input type="submit" value="Submit" class="btn solid" />
                    <div class="spacer"></div>
                    <a href="/auth">Back to Sign in</a>
                </form>
            </div>
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
<script type="text/javascript" src="<?= asset_url('js/app/web/auth.js') ?>"></script>
<!-- xtra scripts -->

<!-- closure -->
<?php include 'partials/layout/global/closure.php'; ?>
<!-- /closure -->