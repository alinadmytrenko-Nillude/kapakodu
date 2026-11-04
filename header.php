<?php
require_once __DIR__ . '/config.php';
$current = $active_menu ?? basename($_SERVER['SCRIPT_NAME']);
$menu = $yhendus->query("SELECT nimetus, url FROM menu WHERE nahtav = 1 ORDER BY jarjekord")->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="et">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/style.css">
    <title><?= h($page_title ?? "Alina Käpakodu") ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>

<body>
    <!-- Header section -->
    <div class="container">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                    <img src="assets/images/logo_big.svg" alt="Logo" width="140">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
<?php foreach ($menu as $m): $akt = ($m['url'] === $current); ?>
                        <li class="nav-item"><a class="nav-link<?= $akt ? ' active' : '' ?>"<?= $akt ? ' aria-current="page"' : '' ?> href="<?= h($m['url']) ?>"><strong><?= h($m['nimetus']) ?></strong></a></li>
<?php endforeach; ?>
                    </ul>
                    <button class="btn btn-success" type="button">Anneta <i class="fa-solid fa-heart-circle-check"></i>
                    </button>

                </div>
            </div>
        </nav>
    </div>
    <!-- Header section end -->
