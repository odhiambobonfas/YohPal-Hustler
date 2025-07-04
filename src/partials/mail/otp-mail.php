<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Your Yohpal OTP Code</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', Roboto, Arial, sans-serif;
            background-color: #f8f9fa;
            color: #212529;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 2rem auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            border: 1px solid #dee2e6;
        }

        h2 {
            color: #0d6efd;
            margin-bottom: 1rem;
        }

        .otp-box {
            background-color: #f1f3f5;
            border-radius: 8px;
            text-align: center;
            padding: 1.5rem;
            margin: 2rem 0;
        }

        .otp-box h1 {
            font-size: 36px;
            letter-spacing: 4px;
            margin: 0;
            color: #212529;
        }

        p {
            margin-bottom: 1rem;
            font-size: 16px;
        }

        .footer-text {
            font-size: 12px;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
            padding-top: 1rem;
            margin-top: 2rem;
        }

        .brand {
            font-weight: bold;
            color: #198754;
        }
    </style>
</head>

<body>

    <div class="email-container">
        <h2>Your Yohpal OTP Code</h2>

        <p>Hi <?= isset($profile->firstName) ? $profile->firstName : 'User' ?>,</p>

        <p>Thank you for using <span class="brand">Yohpal Hustler App</span>. To complete your verification, use the OTP code below:</p>

        <div class="otp-box">
            <h1><?= isset($otp) ? $otp : '_____' ?></h1>
        </div>

        <p>This code is valid for the next 10 minutes. If you didn't request this code, you can safely ignore this message.</p>

        <div class="footer-text">
            Need help? Contact our support team from your app or email us at <a href="mailto:support@yohpal.com">support@yohpal.com</a>
        </div>
    </div>

</body>

</html>