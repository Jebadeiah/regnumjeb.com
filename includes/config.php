<?php
$host = $_SERVER['HTTP_HOST'] ?? 'unknown';

if (
    $host === '127.0.0.1' ||
    $host === 'localhost' ||
    str_starts_with($host, 'localhost') ||
    str_ends_with($host, '.local') ||
    preg_match('/^192\.168\./', $host)
) {
    define('IS_DEV', true);
} else {
    define('IS_DEV', false);
}

// Logging path for email logs
define('LOG_PATH', __DIR__ . '/../logs/mail.log');

// Name of the authentication cookie used for auto-login
define('AUTH_COOKIE_NAME', 'regnum_user');

// Base URL
define('BASE_URL', IS_DEV ? 'http://localhost:8000/' : 'https://www.regnumjeb.com/');