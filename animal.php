<?php
require_once __DIR__ . '/config.php';

// 1) id kontroll: peab olemas olema ja olema täisarv
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === null || $id === false || $id < 1) {
    header('Location: index.php');
    exit;
}

// 2) Ettevalmistatud päring (Prepared Statement)
$stmt = $yhendus->prepare(
    "SELECT l.id, l.nimi, l.sugu, l.vanus, l.sunnikuupaev, l.suurus, l.varvus,
            l.asukoht, l.luhikirjeldus, l.kirjeldus, l.pilt, l.staatus,
            l.steriliseeritud, l.kiibistatud, l.lisatud,
            li.nimetus AS liik, t.nimetus AS toug
     FROM loomad l
     JOIN liigid li ON li.id = l.liik_id
     LEFT JOIN toud t ON t.id = l.toug_id
     WHERE l.id = ?"
);
$stmt->bind_param('i', $id);
$stmt->execute();
$loom = $stmt->get_result()->fetch_assoc();
$stmt->close();

// 3) Looma ei ole -> avalehele
if (!$loom) {
    header('Location: index.php');
    exit;
}

$pilt = is_file(__DIR__ . '/assets/images/' . $loom['pilt'])
    ? 'assets/images/' . $loom['pilt']
    : 'assets/images/placeholder.svg';
?>
<!doctype html>
<html lang="et">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/style.css">
    <title><?= h($loom["nimi"]) ?> – Alina Käpakodu</title>
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
                        <li class="nav-item"> <a class="nav-link" href="index.php"><strong>Avaleht</strong></a></li>
                        <li class="nav-item"> <a class="nav-link active" aria-current="page" href="all_animals.php"><strong>Loomad</strong></a></li>
                        <li class="nav-item"> <a class="nav-link" href="#"><strong>Kuidas aidata</strong></a></li>
                        <li class="nav-item"> <a class="nav-link" href="#"><strong>Meist</strong></a></li>
                        <li class="nav-item"> <a class="nav-link" href="contact.html"><strong>Kontakt</strong></a></li>
                    </ul>
                    <button class="btn btn-success" type="button">Anneta <i class="fa-solid fa-heart-circle-check"></i>
                    </button>

                </div>
            </div>
        </nav>
    </div>
    <!-- Header section end -->
    <!-- Animal details -->
    <div class="container py-4">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Avaleht</a></li>
                <li class="breadcrumb-item"><a href="all_animals.php" class="text-decoration-none">Loomad</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= h($loom['nimi']) ?></li>
            </ol>
        </nav>

        <div class="card shadow-sm border-0">
            <div class="row g-0">
                <div class="col-md-5">
                    <img src="<?= h($pilt) ?>" class="img-fluid rounded-start w-100" alt="<?= h($loom['liik'] . ' ' . $loom['nimi']) ?>">
                </div>
                <div class="col-md-7">
                    <div class="card-body p-4">
                        <h1 class="fw-bold"><?= h($loom['nimi']) ?></h1>
                        <p class="text-muted"><?= h($loom['liik']) ?>, <?= h($loom['vanus']) ?> aastat</p>

                        <ul class="list-group list-group-flush mb-4">
                            <li class="list-group-item"><strong>Liik:</strong> <?= h($loom['liik']) ?></li>
                            <li class="list-group-item"><strong>Tõug:</strong> <?= h($loom['toug'] ?? 'Määramata') ?></li>
                            <li class="list-group-item"><strong>Sugu:</strong> <?= h($loom['sugu']) ?></li>
                            <li class="list-group-item"><strong>Vanus:</strong> <?= h($loom['vanus']) ?> aastat</li>
                            <li class="list-group-item"><strong>Sünnikuupäev:</strong> <?= h(date('d.m.Y', strtotime($loom['sunnikuupaev']))) ?></li>
                            <li class="list-group-item"><strong>Suurus:</strong> <?= h($loom['suurus']) ?></li>
                            <li class="list-group-item"><strong>Värvus:</strong> <?= h($loom['varvus']) ?></li>
                            <li class="list-group-item"><strong>Asukoht:</strong> <?= h($loom['asukoht']) ?></li>
                            <li class="list-group-item"><strong>Steriliseeritud:</strong> <?= $loom['steriliseeritud'] ? 'Jah' : 'Ei' ?></li>
                            <li class="list-group-item"><strong>Kiibistatud:</strong> <?= $loom['kiibistatud'] ? 'Jah' : 'Ei' ?></li>
                            <li class="list-group-item"><strong>Staatus:</strong> <?= h(ucfirst($loom['staatus'])) ?></li>
                            <li class="list-group-item"><strong>Lisatud:</strong> <?= h(date('d.m.Y', strtotime($loom['lisatud']))) ?></li>
                        </ul>

                        <p class="fw-semibold mb-1"><?= h($loom['luhikirjeldus']) ?></p>
                        <p><?= nl2br(h($loom['kirjeldus'])) ?></p>

                        <a href="contact.html" class="btn btn-success px-4">Võta ühendust</a>
                        <a href="all_animals.php" class="btn btn-outline-success px-4">Tagasi loomade juurde</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Animal details end -->
    <!-- Footer -->
    <footer class="bg-white border-top mt-5">
        <div class="container py-5">

            <div class="row gy-4">

                <div class="col-lg-3">
                    <img src="assets/images/logo_big.svg" alt="Loomade Varjupaik" height="50">

                    <p class="mt-3">
                        Aitame koduta ja hätta sattunud loomi ning leiame neile armastavad kodud.
                    </p>

                    <div class="d-flex gap-3 mt-4">
                        <a href="#" class="btn btn-outline-secondary rounded-circle" aria-label="Facebook">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>

                        <a href="#" class="btn btn-outline-secondary rounded-circle" aria-label="Instagram">
                            <i class="fa-brands fa-instagram"></i>
                        </a>

                        <a href="#" class="btn btn-outline-secondary rounded-circle" aria-label="E-post">
                            <i class="fa-regular fa-envelope"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3">
                    <h5 class="fw-bold mb-3">Kiirlingid</h5>

                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="index.php" class="text-decoration-none text-dark">Avaleht</a></li>
                        <li class="mb-2"><a href="all_animals.php" class="text-decoration-none text-dark">Loomad</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-dark">Kuidas aidata</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-dark">Meist</a></li>
                        <li><a href="contact.html" class="text-decoration-none text-dark">Kontakt</a></li>
                    </ul>
                </div>

                <div class="col-lg-3">
                    <h5 class="fw-bold mb-3">Kontakt</h5>

                    <p><i class="fa-solid fa-location-dot me-2"></i>Varjupaiga tee 1, Tallinn 12345</p>
                    <p><i class="fa-solid fa-phone me-2"></i>+372 5555 1234</p>
                    <p><i class="fa-regular fa-envelope me-2"></i>info@varjupaik.ee</p>
                    <p><i class="fa-regular fa-clock me-2"></i>E–P 10:00–18:00</p>
                </div>

                <div class="col-lg-3">
                    <h5 class="fw-bold mb-3">Toeta meid</h5>

                    <p>
                        Sinu annetus aitab meil pakkuda loomadele paremat elu.
                    </p>

                    <button class="btn btn-success px-4" type="button">
                        Anneta
                    </button>
                </div>

            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <small>&copy; 2026 Loomade Varjupaik. Kõik õigused kaitstud.</small>

                <div>
                    <a href="#" class="text-decoration-none text-muted me-3">Küpsiste eelistused</a>
                    <a href="#" class="text-decoration-none text-muted">Privaatsuspoliitika</a>
                </div>
            </div>

        </div>
    </footer>
    <!-- Footer end -->


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>