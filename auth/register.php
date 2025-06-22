<?php
require_once 'db.php'; // your PDO connection
require_once 'mail.php'; // email sender
$banned = ['admin', 'support', 'null', 'undefined']; // can be loaded from file

// Input
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirmPassword'] ?? '';

// Basic validation
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

// Check if email or username exist
$stmt = $pdo->prepare("SELECT 1 FROM users WHERE email = :email OR username = :username");
$stmt->execute(['email' => $email, 'username' => $username]);
if ($stmt->fetch()) {
  exit('Credentials are invalid.');
}

// Create user
$hash = password_hash($password, PASSWORD_DEFAULT);
$token = bin2hex(random_bytes(32));

$insert = $pdo->prepare("INSERT INTO users (username, email, password_hash, verification_token) VALUES (?, ?, ?, ?)");
$success = $insert->execute([$username, $email, $hash, $token]);

if (!$success) {
  exit('Something went wrong.');
}

// Set cookie (but not logged in yet)
setcookie('regnum_auth', $token, time() + 60 * 60 * 24 * 7, '/', '', true, true);

// Send verification email
$verifyUrl = "https://regnumjeb.com/verify.php?token=$token";
sendVerificationEmail($email, $verifyUrl);

// Respond
echo 'Registration successful. Check your email to verify.';