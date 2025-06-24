<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

if (!isset($_GET['token'])) {
    $_SESSION['error'] = "Invalid verification link.";
    header("Location: /login.php");
    exit;
}

$token = $_GET['token'];

$stmt = $db->prepare("SELECT id, is_verified FROM users WHERE verification_token = :token LIMIT 1");
$stmt->execute([':token' => $token]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $_SESSION['error'] = "Verification token not found or already used.";
    header("Location: /login.php");
    exit;
}

if ($user['is_verified']) {
    $_SESSION['success'] = "Your account is already verified. You can log in.";
    header("Location: /login.php");
    exit;
}

// Mark as verified
$stmt = $db->prepare("
    UPDATE users 
    SET is_verified = 1, verification_token = NULL 
    WHERE id = :id
");
$stmt->execute([':id' => $user['id']]);

// Auto-login
$_SESSION['user_id'] = $user['id'];
setcookie('regnum_user', $user['id'], time() + 86400 * 30, '/', '', true, true); // Secure & HttpOnly

$_SESSION['success'] = "Your account has been verified and you're now logged in.";
header("Location: /index.php");
exit;