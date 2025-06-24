<?php
// config/config.php

// Base URL passed from NGINX or fallback to default
define('BASE_URL', $_SERVER['BASE_URL'] ?? 'https://www.regnumjeb.com/');

// Path to the root of the project on the server (filesystem)
define('ROOT_PATH', dirname(__DIR__));

// Toggle debugging mode (disable in production)
define('DEBUG_MODE', true);

// Path to log file
define('LOG_PATH', __DIR__ . '/../logs/mail.log');

// Set error reporting based on debug mode
if (DEBUG_MODE) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}

// Timezone configuration
date_default_timezone_set('America/Los_Angeles');

// Optional: Log directory path
define('LOG_PATH', ROOT_PATH . '/logs');
