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