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
<?php
$page_title = $loom['nimi'] . ' – Alina Käpakodu';
$active_menu = 'all_animals.php';
$breadcrumbs = [['Kõik loomad', 'all_animals.php'], [$loom['nimi'], null]];
require __DIR__ . '/header.php';
require __DIR__ . '/breadcrumbs.php';
?>
    <!-- Animal details -->
    <div class="container py-4">


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

                        <a href="contact.php?loom=<?= (int)$loom['id'] ?>" class="btn btn-success px-4">Võta ühendust</a>
                        <a href="all_animals.php" class="btn btn-outline-success px-4">Tagasi loomade juurde</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Animal details end -->
<?php require __DIR__ . '/footer.php'; ?>
