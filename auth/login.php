<?php
session_start();

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';

/**
 * Sanitize form inputs
 */
function clean_input($data) {
    return trim(htmlspecialchars($data, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
}

// Extract and sanitize user input
$usernameInput = clean_input($_POST['username'] ?? '');
$passwordInput = $_POST['password'] ?? '';
$saveUsername  = isset($_POST['saveUsername']);
$invalid       = 'Credentials are invalid';

// Quick validation
if ($usernameInput === '' || $passwordInput === '') {
    header("Location: ../index.php?error=" . urlencode($invalid));
    exit;
}

try {
    // Query for user credentials, include is_verified
    $query = "SELECT id, email, password_hash, is_verified FROM users WHERE username = ? ORDER BY created_at DESC LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->execute([$usernameInput]);
    $user = $stmt->fetch();

    // Validate credentials
    if (!$user || !password_verify($passwordInput, $user['password_hash'])) {
        header("Location: ../index.php?error=" . urlencode($invalid));
        exit;
    }

    // Check if email is verified
    if (!$user['is_verified']) {
        header("Location: ../index.php?error=" . urlencode('Please verify your email before logging in.'));
        exit;
    }

    // Set session securely
    session_regenerate_id(true);
    $_SESSION['user_id']    = $user['id'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['username']   = $usernameInput;

    // Handle username cookie
    if ($saveUsername) {
        setcookie("saved_username", $usernameInput, [
            'expires'  => time() + (86400 * 30),
            'path'     => '/',
            'httponly' => true,
            'secure'   => !IS_DEV,
            'samesite' => 'Lax',
        ]);
    } else {
        setcookie("saved_username", '', [
            'expires'  => time() - 3600,
            'path'     => '/',
            'httponly' => true,
            'secure'   => !IS_DEV,
            'samesite' => 'Lax',
        ]);
    }

    // Redirect after successful login
    header("Location: ../game.php");
    exit;

} catch (PDOException $e) {
    if (IS_DEV) {
        die("DB Error: " . htmlspecialchars($e->getMessage()));
    } else {
        error_log("Login error: " . $e->getMessage());
        header("Location: ../index.php?error=" . urlencode($invalid));
        exit;
    }
}