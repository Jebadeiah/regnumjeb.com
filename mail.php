<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require __DIR__ . '/../vendor/autoload.php';

/**
 * Sends a verification email with a clickable link
 *
 * @param string $toEmail   Recipient's email address
 * @param string $verifyUrl Full email verification URL
 * @return bool             True if sent, false on failure
 */
function sendVerificationEmail($toEmail, $verifyUrl) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'regnumjeb@gmail.com';
        $mail->Password   = 'mfbw svor pgbb ifsc';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('regnumjeb@gmail.com', 'RegnumJeb');
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
        return true;
    } catch (Exception $e) {
        error_log("Email could not be sent to $toEmail. Error: {$mail->ErrorInfo}");
        return false;
    }
}