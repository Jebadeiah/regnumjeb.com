<?php
require_once __DIR__ . '/config.php';

$host = 'localhost';
$db   = 'regnumjeb';
$user = 'regadmin';
$pass = 'CatchMeIfYouCan';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    if (IS_DEV) {
        die("Database connection failed: " . htmlspecialchars($e->getMessage()));
    } else {
        error_log("Database connection failed: " . $e->getMessage());
        die("An unexpected error occurred. Please try again later.");
    }
}