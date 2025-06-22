<?php
session_start();
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';

function clean_input($data) {
    return trim(htmlspecialchars($data, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
}

$usernameInput = clean_input($_POST['username'] ?? '');
$passwordInput = $_POST['password'] ?? '';
$saveUsername  = isset($_POST['saveUsername']) ? true : false;
$invalid       = 'Credentials are invalid';

if (empty($usernameInput) || empty($passwordInput)) {
    header("Location: ../index.php?error=" . urlencode($invalid));
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT id, email, password_hash FROM users WHERE username = ? ORDER BY created_at DESC LIMIT 1");
    $stmt->execute([$usernameInput]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($passwordInput, $user['password_hash'])) {
        header("Location: ../index.php?error=" . urlencode($invalid));
        exit;
    }

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['username'] = $usernameInput;

    if ($saveUsername) {
        setcookie("saved_username", $usernameInput, time() + (86400 * 30), "/");
    } else {
        setcookie("saved_username", "", time() - 3600, "/");
    }

    header("Location: ../game.php");
    exit;
} catch (PDOException $e) {
    if (IS_DEV) {
        die("DB Error: " . htmlspecialchars($e->getMessage()));
    } else {
        error_log("Login failed: " . $e->getMessage());
        header("Location: ../index.php?error=" . urlencode($invalid));
        exit;
    }
}