<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';

function clean_input($data) {
    return trim(htmlspecialchars($data, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
}

$username        = clean_input($_POST['username'] ?? '');
$email           = clean_input($_POST['email'] ?? '');
$password        = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirmPassword'] ?? '';
$invalid         = 'Credentials are invalid';

if (strlen($password) < 12 || $password !== $confirmPassword) {
    header("Location: ../index.php?error=" . urlencode($invalid));
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->fetch()) {
        header("Location: ../index.php?error=" . urlencode($invalid));
        exit;
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $passwordHash]);

    header("Location: ../index.php?success=registered");
    exit;
} catch (PDOException $e) {
    if (IS_DEV) {
        die("DB Error: " . htmlspecialchars($e->getMessage()));
    } else {
        error_log("Register failed: " . $e->getMessage());
        header("Location: ../index.php?error=" . urlencode($invalid));
        exit;
    }
}