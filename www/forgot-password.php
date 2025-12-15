<?php
session_start();
require __DIR__ . "/vendor/autoload.php";
include "internal/db_config.php";
include "internal/email.php";


if (isset($_POST["type"])) {
    $email = trim($_POST["email"]);
    $stmt = $conn->prepare("SELECT UID FROM USERS WHERE EMAIL = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {

        $_SESSION["reset_email"] = $email;
        header("Location: reset-password.php");
        exit();
    }

    $stmt->bind_result($uid);
    $stmt->fetch();
    $stmt->close();

    $code = random_int(100000, 999999);
    $expires = date("Y-m-d H:i:s", time() + 600);

    // Save token
    $stmt = $conn->prepare("UPDATE USERS SET RESET_TOKEN=?, TOKEN_EXPIRATION=? WHERE UID=?");
    $stmt->bind_param("ssi", $code, $expires, $uid);
    $stmt->execute();
    $stmt->close();

    $mail_status = sendResetCode($email, $code);

    if ($mail_status !== true) {
        $_SESSION["error"] = "Error sending email. Details: " . $mail_status;
        header("Location: forgot-password.php");
        exit();
    }

    $_SESSION["reset_email"] = $email;
    header("Location: reset-password.php");
    exit();
}
?>

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
    <div class="container">
        <div class="illustration-section">
            <img src="static/images/forgot.png" alt="forgot-password-illustration" class="illustration">
        </div>

        <div class="form-section">
            <img src="static/images/logo-inverted.png" alt="company-logo" class="logo">
            <h1>Forgot Password?</h1>
            <p class="subtitle">Enter your email address and we'll send you the confirmation code to reset your password.</p>
            <form id="forgotPasswordForm" action="forgot-password.php" method="POST">
                <input type="hidden" name="type" value="submit">
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
                <a href="login.php#login">← Back to Login</a>
            </div>
        </div>
    </div>
</body>

</html>