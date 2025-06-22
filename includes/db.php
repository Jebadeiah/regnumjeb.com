<?php
$creds = require __DIR__ . '/../config/credentials.php';

$host = 'localhost';
$dbname = 'regnumjeb_db';
$user = $creds['db_user'];
$pass = $creds['db_pass'];

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Consider logging instead of echoing in production
    die("Database connection failed: " . $e->getMessage());
}
