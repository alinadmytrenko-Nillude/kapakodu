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
<?php
$page_title = 'Loomad – Alina Käpakodu';
$breadcrumbs = [['Kõik loomad', null]];
require __DIR__ . '/header.php';
require __DIR__ . '/breadcrumbs.php';
?>
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
<?php require __DIR__ . '/footer.php'; ?>
