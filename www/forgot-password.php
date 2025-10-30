<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/static/css/style.css">
    <link rel="stylesheet" href="/static/css/forgot-password.css">
    <title>Forgot Password</title>
</head>

<body>
    <div class="form-area">
        <div class="wrapper">
            <h1>Forgot Password?</h1>
            <p class="subtitle">Enter your email address and we'll send you the confirmation code to reset your password.</p>
            <form id="box">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-wrapper">
                        <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                    </div>
                </div>
                <button type="submit" class="submit-btn">Send Reset Link</button>
            </form>
            <div class="info-box">
                <p>Check your spam folder if you don't receive the email within a few minutes.</p>
            </div>
            <div class="back-to-login">
                <a href="#login">← Back to Login</a>
            </div>
        </div>
    </div>
</body>

</html>

<?php

?>