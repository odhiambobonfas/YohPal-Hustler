<?php
session_start();
$showSignup = false;
if (isset($_GET['status']) && $_GET['status'] === "signup") {
    $showSignup = true;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/css/main.css" />
    <title>YohPal Hustler App</title>

</head>

<body>

    <div class="container ">

        <div class="forms-container">
            <div class="signin-signup">
                <form action="?url=signin_function" method="POST" class="sign-in-form">
                    <img src="assets/logos/logo.jpg" class="logo" alt="">
                    <h2 class="title">Sign in</h2>
                    <?php if (isset($_GET['error']) && $_GET['status'] !== "signup"): ?>
                        <P class="error"><?php echo $_GET['error']; ?></P>
                    <?php endif; ?>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="email" placeholder="Username" name="email" style="font-size: 12px;" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Password" style="font-size: 12px;" />
                    </div>
                    <input type="submit" value="Login" class="btn solid" />
                    <div class="spacer"></div>
                    <a href="./index.php?url=forgot_pass">Forgot your password?</a>
                    <p class="social-text">Sign in to access your account</p>

                </form>
                <form action="?url=signup_function" method="POST" class="sign-up-form">
                    <img src="assets/logos/logo.jpg" class="logo" alt="">
                    <h2 class="title">Sign up</h2>
                    <?php if (isset($_GET['error']) && $_GET['status'] === "signup"): ?>
                        <P class="error"><?php echo $_GET['error']; ?></P>
                    <?php endif; ?>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="email" placeholder="Email" name="email" style="font-size: 12px;"
                            class="input-text" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="enter password" name="password1" style="font-size: 12px;" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="confirm password" name="password2"
                            style="font-size: 12px;" />
                    </div>
                    <input type="submit" class="btn" value="Sign up" />
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

                    <button class="btn transparent" id="sign-up-btn">
                        Sign up
                    </button>


                </div>
                <img src="./assets/images/log.svg" class="image" alt="" />
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>Welcome to YohPal Hustler </h3><br />
                    <h3>One of us ?</h3>
                    <p>
                        Welcome back! Sign in now to access amazing content and exclusive benefits made just for you.
                    </p>

                    <button class="btn transparent" onclick="removeHeaderVariables()" id="sign-in-btn">
                        Sign in
                    </button>
                </div>
                <img src="./assets/images/register.svg" class="image" alt="" />
            </div>
        </div>
    </div>

    <?php if ($showSignup): ?>
        <script>
            window.addEventListener("DOMContentLoaded", () => {
                const container = document.querySelector('.container');
                container.classList.add('sign-up-mode');
            });
        </script>
    <?php endif; ?>
    <script>
        function removeHeaderVariables() {
            localStorage.removeItem('status');
            localStorage.removeItem('error');
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    </script>
    <script src="./assets/js/main.js"></script>
</body>

</html>