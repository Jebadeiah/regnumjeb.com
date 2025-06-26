<?php

$host = $_SERVER['HTTP_HOST'] ?? 'unknown';

if (
    $host === '127.0.0.1' ||
    $host === 'localhost' ||
    str_starts_with($host, 'localhost') ||
    str_ends_with($host, '.local') ||
    preg_match('/^192\.168\./', $host)
) {
    define('DEV_MODE', true);
} else {
    define('DEV_MODE', false);
}

// Default BASE_URL for DEV_MODE and normal
define('BASE_URL', DEV_MODE ? 'http://localhost:8000/' : 'https://www.regnumjeb.com/');

// Path to the root of the project on the server (filesystem)
define('ROOT_PATH', dirname(__DIR__));

// Set error reporting based on dev mode
if (DEV_MODE) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}

// Timezone configuration
date_default_timezone_set('America/Los_Angeles');

// Log directory path
define('LOG_PATH', ROOT_PATH . '/logs');

// Logging path for email logs
define('LOG_PATH', __DIR__ . '/../logs/mail.log');

// Name of the authentication cookie used for auto-login
define('AUTH_COOKIE_NAME', 'regnum_user');
