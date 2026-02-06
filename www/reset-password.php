<?php
session_start();
require __DIR__ . "/vendor/autoload.php";
include "internal/db_config.php";
include "internal/email.php";

if (!isset($_SESSION["reset_email"])) {
    header("Location: forgot-password.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["resend"])) {
    $email = $_SESSION["reset_email"];
    $stmt = $conn->prepare("SELECT UID FROM USERS WHERE EMAIL=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($uid);
        $stmt->fetch();
        $stmt->close();

        $code = random_int(100000, 999999);
        $expires = date("Y-m-d H:i:s", time() + 600);

        $stmt = $conn->prepare("UPDATE USERS SET RESET_TOKEN=?, TOKEN_EXPIRATION=? WHERE UID=?");
        $stmt->bind_param("ssi", $code, $expires, $uid);
        $stmt->execute();
        $stmt->close();
        sendResetCode($email, $code);

        $_SESSION["success"] = "A new verification code has been sent to your email.";
    }

    header("Location: reset-password.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_SESSION["reset_email"];
    $code = trim($_POST["code"]);

    $stmt = $conn->prepare("SELECT UID, RESET_TOKEN, TOKEN_EXPIRATION FROM USERS WHERE EMAIL=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($uid, $db_code, $db_exp);
    $stmt->fetch();

    if ($db_code === null || $db_exp === null) {
        $_SESSION["error"] = "No reset request found for this account, please retry";
        header("Location: forgot-password.php");
        exit();
    }

    if ($code !== $db_code) {
        $_SESSION["error"] = "Incorrect verification code.";
        header("Location: reset-password.php");
        exit();
    }

    if (strtotime($db_exp) < time()) {
        $_SESSION["error"] = "The verification code has expired.";
        header("Location: forgot-password.php");
        exit();
    }

    $_SESSION["reset_uid"] = $uid;
    header("Location: new-password.php");
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
            <form id="verifyCodeForm" method="POST" action="reset-password.php">
                <div class="form-group">
                    <label for="code">Verification Code</label>
                    <div class="input-wrapper">
                        <input type="text" id="code" name="code" placeholder="Enter the 6-digit code" maxlength="6" required>
                    </div>
                    <?php if (isset($_SESSION["error"])) { ?>
                        <div class="error-msg"><?= htmlspecialchars($_SESSION["error"]);
                                                unset($_SESSION["error"]); ?></div>
                    <?php } ?>
                    <?php if (isset($_SESSION["success"])) { ?>
                        <div class="success-msg"><?= htmlspecialchars($_SESSION["success"]);
                                                    unset($_SESSION["success"]); ?></div>
                    <?php } ?>
                </div>
                <button type="submit" class="submit-btn">Verify Code</button>
            </form>
            <div class="info-box">
                <p>Didn't receive the code? <a href="reset-password.php?resend=1" class="resend-link">Resend code</a></p>
            </div>
            <div class="back-to-login">
                <a href="login.php#login">← Back to Login</a>
            </div>
        </div>
    </div>
</body>

</html>