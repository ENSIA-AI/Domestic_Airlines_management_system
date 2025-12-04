<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/static/css/style.css">
    <link rel="stylesheet" href="/static/css/forgot-password.css">
    <title>Verify Code</title>
</head>

<body>
    <div class="container">
        <div class="illustration-section">
            <img src="static/images/forgot.png" alt="verify-code-illustration" class="illustration">
        </div>
        <div class="form-section">
            <img src="static/images/logo-inverted.png" alt="company-logo" class="logo">
            <h1>Enter Verification Code</h1>
            <p class="subtitle">
                We've sent a 6-digit verification code to your email.
                Enter it below to continue resetting your password.
            </p>
            <form id="verifyCodeForm" method="POST" action="verify-code.php">
                <div class="form-group">
                    <label for="code">Verification Code</label>
                    <div class="input-wrapper">
                        <input type="text" id="code" name="code" placeholder="Enter the 6-digit code" maxlength="6" required>
                    </div>
                </div>
                <button type="submit" class="submit-btn">Verify Code</button>
            </form>
            <div class="info-box">
                <p>Didn’t receive the code? <a href="#" class="resend-link">Resend code</a></p>
            </div>
            <div class="back-to-login">
                <a href="login.php#login">← Back to Login</a>
            </div>
        </div>
    </div>
</body>

</html>