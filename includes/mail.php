<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';
$creds = require __DIR__ . '/../config/credentials.php';
define('LOG_PATH', __DIR__ . '/../logs/mail.log');

/**
 * Appends a line to the custom log file
 */
function log_email_event(string $message): void {
    $timestamp = date('[Y-m-d H:i:s]');
    error_log("$timestamp $message\n", 3, LOG_PATH);
}

/**
 * Sends a verification email with a clickable link
 *
 * @param string $toEmail   Recipient's email address
 * @param string $verifyUrl Full email verification URL
 * @return bool             True if sent, false on failure
 */
function sendVerificationEmail($toEmail, $verifyUrl) {
    global $creds;

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $creds['smtp_user'];
        $mail->Password   = $creds['smtp_pass'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom($creds['smtp_user'], 'RegnumJeb');
        $mail->addAddress($toEmail);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Please verify your email address for RegnumJeb';
        $mail->Body    = "
            <h2>Welcome to RegnumJeb!</h2>
            <p>To activate your account, please verify your email by clicking the link below:</p>
            <p><a href=\"$verifyUrl\">Verify My Email</a></p>
            <hr>
            <p>If you didn’t sign up, you can ignore this message.</p>
        ";
        $mail->AltBody = "Welcome to RegnumJeb!\n\nPlease verify your email: $verifyUrl";

        $mail->send();
        log_email_event("✅ Verification email sent to $toEmail");
        return true;

    } catch (Exception $e) {
        $errorMsg = "❌ Email failed to $toEmail – " . $mail->ErrorInfo;
        log_email_event($errorMsg);
        error_log($errorMsg);
        return false;
    }
}