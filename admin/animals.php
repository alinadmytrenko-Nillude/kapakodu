<?php
require_once __DIR__ . '/includes/config.php';
$page_title = 'Loomad – Admin – Alina Käpakodu';

$loomad = $conn->query(
    "SELECT l.id, l.nimi, l.pilt, l.sugu, l.vanus, l.staatus, l.lisatud, li.nimetus AS liik
     FROM loomad l
     JOIN liigid li ON li.id = l.liik_id
     ORDER BY l.id DESC"
)->fetch_all(MYSQLI_ASSOC);

$staatused = [
    'saadaval'   => ['bg-success-subtle text-success', 'Saadaval'],
    'broneeritud' => ['bg-warning-subtle text-warning-emphasis', 'Broneeritud'],
    'hoolduses'  => ['bg-secondary-subtle text-secondary', 'Hoolduses'],
];
require __DIR__ . '/includes/header.php';
?>
    <main class="py-5">
    <div class="container pt-4">
        <?php if (isset($_GET['deleted'])): ?>
            <div class="alert alert-success">Loom kustutati edukalt.</div>
        <?php endif; ?>
        <?php if (isset($_GET['linked'])): ?>
            <div class="alert alert-warning">Looma ei saa kustutada, sest temaga on seotud päringuid.</div>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">Looma kustutamine ebaõnnestus.</div>
        <?php endif; ?>
    </div>
<div class="container-xl">
    <!-- Lehe pealkiri -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h2 fw-bold mb-1">Loomad</h1>
            <p class="text-muted mb-0">
                Halda varjupaiga loomi: vaata, lisa, muuda või kustuta.
            </p>
        </div>

        <a href="animal_add.html" class="btn btn-success">
            <i class="fa-solid fa-plus me-2"></i>
            Lisa uus loom
        </a>

    </div>

    <!-- Filtrid -->
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <div class="row g-3">

                <div class="col-lg-4">
                    <label class="form-label fw-semibold">Otsi looma</label>

                    <div class="input-group">
                        <input type="text" class="form-control"
                            placeholder="Otsi nime, liigi või kirjelduse järgi...">

                        <button class="btn btn-outline-secondary" type="button" aria-label="Otsi">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </div>

                <div class="col-lg-3">
                    <label class="form-label fw-semibold">Liik</label>

                    <select class="form-select">
                        <option>Kõik liigid</option>
                        <option>Koer</option>
                        <option>Kass</option>
                    </select>
                </div>

                <div class="col-lg-3">
                    <label class="form-label fw-semibold">Staatus</label>

                    <select class="form-select">
                        <option>Kõik staatused</option>
                        <option>Kodus</option>
                        <option>Hoolduses</option>
                    </select>
                </div>

                <div class="col-lg-2">
                    <label class="form-label fw-semibold">Vanus</label>

                    <select class="form-select">
                        <option>Kõik</option>
                        <option>Kuni 1 a</option>
                        <option>1–5 a</option>
                        <option>5+ a</option>
                    </select>
                </div>

            </div>

            <div class="text-end mt-4">

                <button class="btn btn-outline-secondary me-2" type="button">
                    <i class="fa-solid fa-rotate-left me-2"></i>
                    Tühista filtrid
                </button>

                <button class="btn btn-success" type="button">
                    <i class="fa-solid fa-filter me-2"></i>
                    Rakenda filtrid
                </button>

            </div>

        </div>

    </div>

    <!-- Tabel -->
    <div class="card shadow-sm border-0">

        <div class="table-responsive">

            <table class="table align-middle table-hover mb-0">

                <thead>

                    <tr>
                        <th>Pilt</th>
                        <th>Nimi</th>
                        <th>Liik</th>
                        <th>Sugu</th>
                        <th>Vanus</th>
                        <th>Staatus</th>
                        <th>Lisatud</th>
                        <th class="text-end">Tegevused</th>
                    </tr>

                </thead>

                <tbody>
<?php foreach ($loomad as $loom):
    $pilt = is_file(__DIR__ . '/../assets/images/' . $loom['pilt'])
        ? '../assets/images/' . $loom['pilt']
        : '../assets/images/placeholder.svg';
    [$klass, $silt] = $staatused[$loom['staatus']] ?? ['bg-dark-subtle text-dark', ucfirst($loom['staatus'])];
?>
                    <tr>
                        <td><img src="<?= h($pilt) ?>" class="rounded" width="70" alt="<?= h($loom['nimi']) ?>"></td>
                        <td class="fw-semibold"><?= h($loom['nimi']) ?></td>
                        <td><?= h($loom['liik']) ?></td>
                        <td><?= h(ucfirst($loom['sugu'])) ?></td>
                        <td><?= h($loom['vanus']) ?> a</td>
                        <td><span class="badge <?= h($klass) ?>"><?= h($silt) ?></span></td>
                        <td><?= h(date('d.m.Y', strtotime($loom['lisatud']))) ?></td>
                        <td class="text-end">
                            <a href="../animal.php?id=<?= (int)$loom['id'] ?>" class="btn btn-outline-secondary btn-sm" title="Vaata"><i class="fa-solid fa-eye"></i></a>
                            <a href="animal_edit.php?id=<?= (int)$loom['id'] ?>" class="btn btn-outline-primary btn-sm" title="Muuda"><i class="fa-solid fa-pen"></i></a>
                            <form action="animal_delete.php" method="post" class="d-inline" onsubmit="return confirm('Kas soovid selle looma kustutada?');">
                                <input type="hidden" name="id" value="<?= (int)$loom['id'] ?>">
                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Kustuta"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
<?php endforeach; ?>
                </tbody>

            </table>

        </div>

        <div class="card-footer bg-white d-flex justify-content-between align-items-center">

            <small class="text-muted">
                Kuvatakse kokku <?= count($loomad) ?> looma.
            </small>

        </div>
    </div>
</div>
    </main>
<?php require __DIR__ . "/includes/footer.php"; ?>
