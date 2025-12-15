<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// load composer's autoloader
require __DIR__ . "/../vendor/autoload.php";

function sendResetCode($email, $code)
{
    // replace these placeholders with your actual credentials
    $smtpUsername = "YOUR_SMTP_USERNAME@example.com";
    $smtpPassword = "YOUR_APP_PASSWORD"; 
    
    $mail = new PHPMailer(true);
    try {
        // server settings
        $mail->isSMTP();
        $mail->Host       = "smtp.gmail.com";
        $mail->SMTPAuth   = true;
        $mail->Username   = $smtpUsername; 
        $mail->Password   = $smtpPassword;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // recipients
        $mail->setFrom("no-reply@yourdomain.com", "Domestic Airlines");
        $mail->addAddress($email);

        // content
        $mail->isHTML(true);
        $mail->Subject = "Your Password Reset Verification Code";
        $mail->Body = "
            <h3>Your verification code:</h3>
            <h1>$code</h1>
            <p>This code expires in 10 minutes.</p>
        ";
        $mail->AltBody = "Your verification code: $code. This code expires in 10 minutes.";

        return $mail->send();
    } catch (Exception $e) {
        return false;
    }
}