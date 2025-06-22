<?php

$db_host = "localhost";
$db_user = "masterbader";
$db_password = "DestroyingCastlesInTheSky";
$db_name = "regnumjeb_db";

try {
    $db = new PDO("mysql:host={$db_host};dbname={$db_name}", $db_user, $db_password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOEXCEPTION $e) {
    echo $e->getMessage();
}