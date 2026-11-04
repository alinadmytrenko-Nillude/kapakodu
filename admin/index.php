<?php
require_once __DIR__ . '/includes/config.php';
$page_title = 'Administraatori avaleht – Alina Käpakodu';

$kokku       = (int)$conn->query("SELECT COUNT(*) AS n FROM loomad")->fetch_assoc()['n'];
$saadaval    = (int)$conn->query("SELECT COUNT(*) AS n FROM loomad WHERE staatus = 'saadaval'")->fetch_assoc()['n'];
$broneeritud = (int)$conn->query("SELECT COUNT(*) AS n FROM loomad WHERE staatus = 'broneeritud'")->fetch_assoc()['n'];
$uued        = (int)$conn->query("SELECT COUNT(*) AS n FROM paringud WHERE staatus = 'uus'")->fetch_assoc()['n'];

$viimased_loomad = $conn->query(
    "SELECT l.nimi, l.vanus, l.staatus, li.nimetus AS liik
     FROM loomad l JOIN liigid li ON li.id = l.liik_id
     ORDER BY l.id DESC LIMIT 4"
)->fetch_all(MYSQLI_ASSOC);

$viimased_sonumid = $conn->query(
    "SELECT nimi, teema, staatus FROM paringud ORDER BY id DESC LIMIT 4"
)->fetch_all(MYSQLI_ASSOC);

$loom_badge = [
    'saadaval'    => ['bg-success', 'Saadaval'],
    'broneeritud' => ['bg-warning text-dark', 'Broneeritud'],
    'hoolduses'   => ['bg-secondary', 'Hoolduses'],
];
$sonum_badge = [
    'uus'         => ['bg-primary', 'Uus'],
    'menetlustes' => ['bg-warning text-dark', 'Menetluses'],
    'suletud'     => ['bg-secondary', 'Suletud'],
];
require __DIR__ . '/includes/header.php';
?>
    <main>
<!-- Site content -->
<div class="container py-5">
    <h1 class="fw-bold mb-2">Administraatori avaleht</h1>
    <p class="text-muted mb-5">Ülevaade varjupaiga tegevusest.</p>

    <!-- Stat -->
    <div class="row g-4 mb-5">
        <div class="col-lg-3">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <i class="fa-solid fa-paw fa-3x text-success mb-3"></i>
                    <h2 class="fw-bold"><?= $kokku ?></h2>
                    <p class="mb-0">Looma</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <i class="fa-solid fa-house fa-3x text-success mb-3"></i>
                    <h2 class="fw-bold"><?= $saadaval ?></h2>
                    <p class="mb-0">Koduta</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <i class="fa-regular fa-heart fa-3x text-success mb-3"></i>
                    <h2 class="fw-bold"><?= $broneeritud ?></h2>
                    <p class="mb-0">Broneeritud</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <i class="fa-regular fa-envelope fa-3x text-success mb-3"></i>
                    <h2 class="fw-bold"><?= $uued ?></h2>
                    <p class="mb-0">Uusi sõnumeid</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Stat end -->

    <div class="row g-4">
        <!-- Animals -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h4 class="mb-0">Viimati lisatud loomad</h4>
                </div>

                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nimi</th>
                                <th>Liik</th>
                                <th>Vanus</th>
                                <th>Staatus</th>
                            </tr>
                        </thead>

                        <tbody>
<?php foreach ($viimased_loomad as $l):
    [$kl, $si] = $loom_badge[$l['staatus']] ?? ['bg-dark', ucfirst($l['staatus'])];
?>
                    <tr>
                        <td><?= h($l['nimi']) ?></td>
                        <td><?= h($l['liik']) ?></td>
                        <td><?= h($l['vanus']) ?> a</td>
                        <td><span class="badge <?= h($kl) ?>"><?= h($si) ?></span></td>
                    </tr>
<?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Animals end -->

        <!-- Requests -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h4 class="mb-0">Viimased sõnumid</h4>
                </div>

                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nimi</th>
                                <th>Teema</th>
                                <th>Staatus</th>
                            </tr>
                        </thead>

                        <tbody>
<?php foreach ($viimased_sonumid as $s):
    [$kl, $si] = $sonum_badge[$s['staatus']] ?? ['bg-dark', ucfirst($s['staatus'])];
?>
                    <tr>
                        <td><?= h($s['nimi']) ?></td>
                        <td><?= h($s['teema']) ?></td>
                        <td><span class="badge <?= h($kl) ?>"><?= h($si) ?></span></td>
                    </tr>
<?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Requests end -->
    </div>
</div>
<!-- Site content end -->
    </main>
<?php require __DIR__ . "/includes/footer.php"; ?>
