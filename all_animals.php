<?php
require_once __DIR__ . '/config.php';

$q = trim((string) filter_input(INPUT_GET, 'q', FILTER_DEFAULT));
$q = mb_substr($q, 0, 50);

$liik_id = filter_input(INPUT_GET, 'liik', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
if ($liik_id === false) { $liik_id = null; }

$sugu = trim((string) filter_input(INPUT_GET, 'sugu', FILTER_DEFAULT));
$vanus = trim((string) filter_input(INPUT_GET, 'vanus', FILTER_DEFAULT));

$liigid = $yhendus->query("SELECT id, nimetus FROM liigid ORDER BY nimetus")->fetch_all(MYSQLI_ASSOC);
$sugud = array_column(
    $yhendus->query("SELECT DISTINCT sugu FROM loomad ORDER BY sugu")->fetch_all(MYSQLI_ASSOC),
    'sugu'
);
$vanused = [
    'a' => ['Alla 2 aasta', 0, 2],
    'b' => ['2–4 aastat', 2, 5],
    'c' => ['5–8 aastat', 5, 9],
    'd' => ['9 aastat ja vanemad', 9, null],
];

if ($sugu !== '' && !in_array($sugu, $sugud, true)) { $sugu = ''; }
if ($vanus !== '' && !isset($vanused[$vanus])) { $vanus = ''; }

$sql = "SELECT l.id, l.nimi, li.nimetus AS liik, l.sugu, l.vanus, l.luhikirjeldus, l.pilt
        FROM loomad l
        JOIN liigid li ON li.id = l.liik_id
        WHERE 1=1";
$tyybid = '';
$param = [];

if ($q !== '') {
    $sql .= " AND l.nimi LIKE ?";
    $tyybid .= 's';
    $param[] = '%' . addcslashes($q, '%_\\') . '%';
}
if ($liik_id !== null) {
    $sql .= " AND l.liik_id = ?";
    $tyybid .= 'i';
    $param[] = $liik_id;
}
if ($sugu !== '') {
    $sql .= " AND l.sugu = ?";
    $tyybid .= 's';
    $param[] = $sugu;
}
if ($vanus !== '') {
    [, $min, $max] = $vanused[$vanus];
    $sql .= " AND l.vanus >= ?";
    $tyybid .= 'i';
    $param[] = $min;
    if ($max !== null) {
        $sql .= " AND l.vanus < ?";
        $tyybid .= 'i';
        $param[] = $max;
    }
}
$sql .= " ORDER BY l.nimi";

$stmt = $yhendus->prepare($sql);
if ($param) {
    $stmt->bind_param($tyybid, ...$param);
}
$stmt->execute();
$loomad = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!doctype html>
<html lang="et">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Alina Käpakodu</title>
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
    <div class="container py-5">

        <div class="text-center mb-4">
            <h1 class="fw-bold">Loomad</h1>
            <p class="text-muted">Otsi ja filtreeri meie varjupaiga loomi.</p>
        </div>

        <form method="get" action="all_animals.php" class="row g-3 mb-5">
            <div class="col-md-3">
                <label for="q" class="form-label">Nimi</label>
                <input type="text" class="form-control" id="q" name="q" maxlength="50" value="<?= h($q) ?>" placeholder="Otsi nime järgi">
            </div>
            <div class="col-md-2">
                <label for="liik" class="form-label">Liik</label>
                <select class="form-select" id="liik" name="liik">
                    <option value="">Kõik</option>
                    <?php foreach ($liigid as $li): ?>
                        <option value="<?= (int)$li['id'] ?>"<?= $liik_id === (int)$li['id'] ? ' selected' : '' ?>><?= h($li['nimetus']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label for="sugu" class="form-label">Sugu</label>
                <select class="form-select" id="sugu" name="sugu">
                    <option value="">Kõik</option>
                    <?php foreach ($sugud as $s): ?>
                        <option value="<?= h($s) ?>"<?= $sugu === $s ? ' selected' : '' ?>><?= h(ucfirst($s)) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="vanus" class="form-label">Vanus</label>
                <select class="form-select" id="vanus" name="vanus">
                    <option value="">Kõik</option>
                    <?php foreach ($vanused as $kood => $v): ?>
                        <option value="<?= h($kood) ?>"<?= $vanus === (string)$kood ? ' selected' : '' ?>><?= h($v[0]) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-success w-100">Otsi</button>
                <a href="all_animals.php" class="btn btn-outline-secondary" title="Tühjenda">×</a>
            </div>
        </form>

        <p class="text-muted">Leitud loomi: <strong><?= count($loomad) ?></strong></p>

        <?php if (!$loomad): ?>
            <div class="alert alert-warning">Valitud tingimustega loomi ei leitud. Proovi muuta otsingut või filtreid.</div>
        <?php else: ?>
        <div class="row g-4">
            <?php foreach ($loomad as $loom):
                $pilt = is_file(__DIR__ . '/assets/images/' . $loom['pilt'])
                    ? 'assets/images/' . $loom['pilt']
                    : 'assets/images/placeholder.svg';
            ?>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 shadow-sm">
                    <img src="<?= h($pilt) ?>" class="card-img-top" alt="<?= h($loom['nimi']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= h($loom['nimi']) ?></h5>
                        <p class="card-text mb-1"><?= h($loom['liik']) ?>, <?= h($loom['sugu']) ?>, <?= h($loom['vanus']) ?> a</p>
                        <p class="card-text small text-muted"><?= h($loom['luhikirjeldus']) ?></p>
                        <a href="animal.php?id=<?= (int)$loom['id'] ?>" class="btn btn-success">Vaata lähemalt</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div>
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