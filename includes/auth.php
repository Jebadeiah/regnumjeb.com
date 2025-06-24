<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';

/**
 * If user is not logged in but has a valid auth cookie,
 * restores the session silently from the database.
 */
function auto_login_from_cookie(): void {
    if (isset($_SESSION['user_id'])) {
        return; // Already logged in
    }

    if (!isset($_COOKIE[AUTH_COOKIE_NAME])) {
        return; // No auth cookie present
    }

    $userId = (int) $_COOKIE[AUTH_COOKIE_NAME];

    global $db;
    $stmt = $db->prepare("
        SELECT id, username, email 
        FROM users 
        WHERE id = :id AND is_verified = 1
        LIMIT 1
    ");
    $stmt->execute([':id' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        session_regenerate_id(true);
        $_SESSION['user_id']    = $user['id'];
        $_SESSION['username']   = $user['username'];
        $_SESSION['user_email'] = $user['email'];
    } else {
        // Invalid ID in cookie—clear it
        setcookie(AUTH_COOKIE_NAME, '', time() - 3600, '/', '', true, true);
    }
}