<?php
// Andmebaasi ühenduse seaded
date_default_timezone_set('Europe/Tallinn');

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$db_host = 'localhost';
$db_user = 'alina';
$db_pass = 'PAROOL_SIIA';
$db_name = 'kapakodu';

try {
    $yhendus = new mysqli($db_host, $db_user, $db_pass, $db_name);
    $yhendus->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    error_log('DB viga: ' . $e->getMessage());
    http_response_code(500);
    exit('Andmebaasiühendus ebaõnnestus.');
}
