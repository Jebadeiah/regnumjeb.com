<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require __DIR__ . '/vendor/autoload.php';

/**
 * Sends a verification email with a clickable link
 *
 * @param string $toEmail   Recipient's email
 * @param string $verifyUrl Full verification link
 */
function sendVerificationEmail($toEmail, $verifyUrl) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'regnumjeb@gmail.com'; // Your Gmail
        $mail->Password   = 'your-app-password-here'; // NOT your Gmail password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('regnumjeb@gmail.com', 'RegnumJeb');
        $mail->addAddress($toEmail);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Please verify your email address for RegnumJeb';
        $mail->Body    = "
          <p>Welcome to RegnumJeb!</p>
          <p>Click the link below to verify your email and activate your account:</p>
          <p><a href=\"$verifyUrl\">Verify Email</a></p>
        ";

        $mail->send();
    } catch (Exception $e) {
        error_log("Email could not be sent: {$mail->ErrorInfo}");
    }
}