<?php
// Admin-paneeli andmebaasiühendus (kasutab juurkausta config.php-d)
require_once __DIR__ . '/../../config.php';
$conn = $yhendus;

// Ligipääsu kontroll: ilma sisselogimiseta suunatakse login.php lehele
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['tootaja'])) {
    header('Location: ../login.php');
    exit;
}
