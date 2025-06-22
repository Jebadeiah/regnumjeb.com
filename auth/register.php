<?php
// For debugging — disable in prod
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../db.php';        // Adjust path if needed
require_once __DIR__ . '/../mail.php';

$banned = ['admin', 'support', 'null', 'undefined'];

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    exit('This endpoint only accepts POST requests.');
}

// Sanitize inputs
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirmPassword'] ?? '';

if (!$username || !$email || !$password || !$confirm) {
    exit('Missing required fields.');
}

if ($password !== $confirm) {
    exit('Passwords do not match.');
}

if (strlen($password) < 12) {
    exit('Password must be at least 12 characters long.');
}

if (in_array(strtolower($username), $banned)) {
    exit('Credentials are invalid.');
}

try {
    // Check for duplicate email or username
    $check = $pdo->prepare("SELECT 1 FROM users WHERE email = :email OR username = :username");
    $check->execute(['email' => $email, 'username' => $username]);
    if ($check->fetch()) {
        exit('Credentials are invalid.');
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $token = bin2hex(random_bytes(32));

    $insert = $pdo->prepare("INSERT INTO users (username, email, password_hash, verification_token)
                             VALUES (?, ?, ?, ?)");
    $insert->execute([$username, $email, $hash, $token]);

    // Set cookie
    setcookie('regnum_auth', $token, time() + 604800, '/', '', true, true);

    // Send email
    $verifyUrl = "https://regnumjeb.com/verify.php?token=$token";
    sendVerificationEmail($email, $verifyUrl);

    echo 'Registration successful. Check your email to verify.';
} catch (Exception $e) {
    error_log('Registration error: ' . $e->getMessage());
    exit('Something went wrong.');
}