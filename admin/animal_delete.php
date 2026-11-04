<?php
require_once __DIR__ . '/includes/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: animals.php');
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: animals.php?error=1');
    exit;
}

try {
    $stmt = $conn->prepare("DELETE FROM loomad WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header('Location: animals.php?deleted=1');
    } else {
        header('Location: animals.php?error=1');
    }
    $stmt->close();
} catch (mysqli_sql_exception $e) {
    // loomaga on seotud päringud (võõrvõti RESTRICT)
    header('Location: animals.php?linked=1');
}
exit;
