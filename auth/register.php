<?php
session_start();

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/mail.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email address.";
        header("Location: /register.php");
        exit;
    }

    if (strlen($password) < 6) {
        $_SESSION['error'] = "Password must be at least 6 characters.";
        header("Location: /register.php");
        exit;
    }

    // Check if email already exists
    $stmt = $db->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");
    $stmt->execute([':email' => $email]);
    if ($stmt->fetch()) {
        $_SESSION['error'] = "That email is already registered.";
        header("Location: /register.php");
        exit;
    }

    // Create user
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $token = bin2hex(random_bytes(32));

    $stmt = $db->prepare("
        INSERT INTO users (email, password, verification_token, is_verified)
        VALUES (:email, :password, :token, 0)
    ");
    $stmt->execute([
        ':email'    => $email,
        ':password' => $hashedPassword,
        ':token'    => $token
    ]);

    // Send verification email
    $verifyUrl = "https://regnumjeb.com/auth/verify.php?token=$token";
    sendVerificationEmail($email, $verifyUrl);

    $_SESSION['success'] = "Registration successful! Please check your email to verify your account.";
    header("Location: /login.php");
    exit;
}