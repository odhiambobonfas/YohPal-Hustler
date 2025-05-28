<?php include_once './api_integrations/authentication/forgot_pass.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/css/main.css" />
</head>

<body>
    <div class="container">
        <div class="form-container">
            <div class="signin-signup">
                <form action="./index.php?url=forgot_pass" method="POST" class="sign-in-form" id="forgotPasswordForm">
                <img src="assets/logos/logo.jpg" class="logo" alt="">
                    <h2 class="title">Forgot Password</h2>
                    
                    <?php if (isset($_GET['success']) && $_GET['status'] === "reset"): ?>
                        <p class="success" style="color: green;"><?php echo htmlspecialchars($_GET['success']); ?></p>
                    <?php endif; ?>
                    
                    <?php if (isset($_GET['error']) && $_GET['status'] === "reset"): ?>
                        <p class="error" style="color: red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
                    <?php endif; ?>
                    
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="email" placeholder="Email" name="email" id="emailInput" style="font-size: 12px;"
                            required />
                    </div>
                    <input type="submit" value="Submit" class="btn solid" />
                    <div class="spacer"></div>
                    <a href="./index.php?url=log_in">Back to Sign in</a>
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>Forgot your password? </h3>
                    <p>
                        Enter your email to recover your password
                    </p>
                </div>
                <img src="./assets/images/log.svg" class="image" alt="" />
            </div>
        </div>
    </div>
    <script src="../assets/js/forgot_pass.js"></script>
</body>

</html>