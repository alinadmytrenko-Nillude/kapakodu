<?php
require_once __DIR__ . '/includes/config.php';
$page_title = 'Lisa loom - Admin - Alina Käpakodu';

$liigid = $conn->query('SELECT id, nimetus FROM liigid ORDER BY nimetus')->fetch_all(MYSQLI_ASSOC);
$toud = $conn->query('SELECT id, liik_id, nimetus FROM toud ORDER BY nimetus')->fetch_all(MYSQLI_ASSOC);
$tootajad = $conn->query('SELECT id, nimi FROM tootajad ORDER BY nimi')->fetch_all(MYSQLI_ASSOC);

$lubatud_sugu = ['isane', 'emane'];
$lubatud_suurus = ['väike', 'keskmine', 'suur'];
$lubatud_staatus = ['saadaval', 'broneeritud', 'hoolduses'];
$pildi_tyybid = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];

$vead = [];
$v = [
    'liik_id' => 0, 'toug_id' => 0, 'tootaja_id' => 0,
    'nimi' => '', 'sugu' => '', 'vanus' => '', 'sunnikuupaev' => '',
    'suurus' => '', 'varvus' => '', 'asukoht' => '',
    'luhikirjeldus' => '', 'kirjeldus' => '', 'staatus' => 'saadaval',
    'steriliseeritud' => 0, 'kiibistatud' => 0,
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach (['nimi', 'vanus', 'sunnikuupaev', 'sugu', 'suurus', 'varvus', 'asukoht', 'luhikirjeldus', 'kirjeldus', 'staatus'] as $k) {
        $v[$k] = trim((string)($_POST[$k] ?? ''));
    }
    $v['liik_id'] = (int)($_POST['liik_id'] ?? 0);
    $v['toug_id'] = (int)($_POST['toug_id'] ?? 0);
    $v['tootaja_id'] = (int)($_POST['tootaja_id'] ?? 0);
    $v['steriliseeritud'] = isset($_POST['steriliseeritud']) ? 1 : 0;
    $v['kiibistatud'] = isset($_POST['kiibistatud']) ? 1 : 0;

    if (mb_strlen($v['nimi']) < 2 || mb_strlen($v['nimi']) > 100) {
        $vead[] = 'Nimi peab olema 2-100 tähemärki.';
    }

    $liik_ok = false;
    foreach ($liigid as $l) {
        if ((int)$l['id'] === $v['liik_id']) { $liik_ok = true; }
    }
    if ($liik_ok === false) { $vead[] = 'Vali liik.'; }

    $toug_ok = false;
    foreach ($toud as $t) {
        if ((int)$t['id'] === $v['toug_id'] && (int)$t['liik_id'] === $v['liik_id']) { $toug_ok = true; }
    }
    if ($toug_ok === false) { $vead[] = 'Tõug ei sobi valitud liigiga.'; }

    $tootaja_ok = false;
    foreach ($tootajad as $w) {
        if ((int)$w['id'] === $v['tootaja_id']) { $tootaja_ok = true; }
    }
    if ($tootaja_ok === false) { $vead[] = 'Vali vastutav töötaja.'; }

    if (in_array($v['sugu'], $lubatud_sugu, true) === false) { $vead[] = 'Vali sugu.'; }
    if (in_array($v['suurus'], $lubatud_suurus, true) === false) { $vead[] = 'Vali suurus.'; }
    if (in_array($v['staatus'], $lubatud_staatus, true) === false) { $vead[] = 'Vali staatus.'; }

    $vanus = filter_var($v['vanus'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 40]]);
    if ($vanus === false) { $vead[] = 'Vanus peab olema arv 0-40.'; }

    if ($v['sunnikuupaev'] !== '') {
        $d = DateTime::createFromFormat('Y-m-d', $v['sunnikuupaev']);
        if ($d === false || $d->format('Y-m-d') !== $v['sunnikuupaev'] || $v['sunnikuupaev'] > date('Y-m-d')) {
            $vead[] = 'Sünnikuupäev on vigane.';
        }
    }

    if (mb_strlen($v['varvus']) < 1 || mb_strlen($v['varvus']) > 100) { $vead[] = 'Värvus on kohustuslik (kuni 100 märki).'; }
    if (mb_strlen($v['asukoht']) < 1 || mb_strlen($v['asukoht']) > 100) { $vead[] = 'Asukoht on kohustuslik (kuni 100 märki).'; }
    if (mb_strlen($v['luhikirjeldus']) < 1 || mb_strlen($v['luhikirjeldus']) > 255) { $vead[] = 'Lühikirjeldus on kohustuslik (kuni 255 märki).'; }
    if ($v['kirjeldus'] === '') { $vead[] = 'Kirjeldus on kohustuslik.'; }

    $uus_fail = null;
    $fail = $_FILES['pilt'] ?? null;
    if ($fail !== null && $fail['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($fail['error'] !== UPLOAD_ERR_OK) {
            $vead[] = 'Pildi üleslaadimine ebaõnnestus.';
        } elseif ($fail['size'] > 2 * 1024 * 1024) {
            $vead[] = 'Pilt on liiga suur (maksimaalselt 2 MB).';
        } else {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($fail['tmp_name']);
            if (isset($pildi_tyybid[$mime])) {
                $uus_fail = ['tmp' => $fail['tmp_name'], 'ext' => $pildi_tyybid[$mime]];
            } else {
                $vead[] = 'Pilt peab olema JPG, PNG või WEBP.';
            }
        }
    }

    $pilt = 'placeholder.svg';
    if (count($vead) === 0 && $uus_fail !== null) {
        $slug = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($v['nimi'])), '-');
        if ($slug === '') { $slug = 'loom'; }
        $pilt = time() . '_' . $slug . '.' . $uus_fail['ext'];
        if (move_uploaded_file($uus_fail['tmp'], __DIR__ . '/../assets/images/' . $pilt) === false) {
            $vead[] = 'Pildi salvestamine ebaõnnestus.';
            $pilt = 'placeholder.svg';
        }
    }

    if (count($vead) === 0) {
        $sunni = ($v['sunnikuupaev'] === '') ? null : $v['sunnikuupaev'];
        try {
            $stmt = $conn->prepare('INSERT INTO loomad (liik_id, toug_id, tootaja_id, nimi, sugu, vanus, sunnikuupaev, suurus, varvus, asukoht, luhikirjeldus, kirjeldus, pilt, staatus, steriliseeritud, kiibistatud) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->bind_param(
                'iiississssssssii',
                $v['liik_id'], $v['toug_id'], $v['tootaja_id'], $v['nimi'], $v['sugu'],
                $vanus, $sunni, $v['suurus'], $v['varvus'], $v['asukoht'],
                $v['luhikirjeldus'], $v['kirjeldus'], $pilt, $v['staatus'],
                $v['steriliseeritud'], $v['kiibistatud']
            );
            $stmt->execute();
            $stmt->close();
            header('Location: animals.php?added=1');
            exit;
        } catch (mysqli_sql_exception $e) {
            if ($pilt !== 'placeholder.svg') {
                @unlink(__DIR__ . '/../assets/images/' . $pilt);
            }
            $vead[] = 'Andmebaasi viga: looma ei lisatud.';
        }
    }
}

require __DIR__ . '/includes/header.php';
?>
    <main class="py-5">
    <div class="container pt-4">

        <div class="mb-4">
            <h1 class="h2 fw-bold mb-1">Lisa uus loom</h1>
            <p class="text-muted mb-0">Täida vorm ja salvesta loom andmebaasi. Tärniga väljad on kohustuslikud.</p>
        </div>

        <?php if (count($vead) > 0): ?>
            <div class="alert alert-danger">
                <strong>Looma ei lisatud:</strong>
                <ul class="mb-0">
                    <?php foreach ($vead as $viga): ?>
                        <li><?= h($viga) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="animal_add.php" enctype="multipart/form-data" novalidate>
        <div class="row g-4">

        <div class="col-lg-8">
        <div class="card shadow-sm">
        <div class="card-body p-4">
            <h2 class="h5 fw-bold mb-3">Põhiandmed</h2>
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label" for="nimi">Nimi *</label>
                    <input class="form-control" type="text" id="nimi" name="nimi" maxlength="100" value="<?= h($v['nimi']) ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="liik_id">Liik *</label>
                    <select class="form-select" id="liik_id" name="liik_id">
                        <option value="">Vali liik</option>
                        <?php foreach ($liigid as $l): ?>
                            <option value="<?= (int)$l['id'] ?>"<?= $v['liik_id'] === (int)$l['id'] ? ' selected' : '' ?>><?= h($l['nimetus']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="toug_id">Tõug *</label>
                    <select class="form-select" id="toug_id" name="toug_id">
                        <option value="">Vali tõug</option>
                        <?php foreach ($toud as $t): ?>
                            <option value="<?= (int)$t['id'] ?>" data-liik="<?= (int)$t['liik_id'] ?>"<?= $v['toug_id'] === (int)$t['id'] ? ' selected' : '' ?>><?= h($t['nimetus']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="sugu">Sugu *</label>
                    <select class="form-select" id="sugu" name="sugu">
                        <option value="">Vali sugu</option>
                        <?php foreach ($lubatud_sugu as $s): ?>
                            <option value="<?= h($s) ?>"<?= $v['sugu'] === $s ? ' selected' : '' ?>><?= h(ucfirst($s)) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="vanus">Vanus (aastat) *</label>
                    <input class="form-control" type="number" id="vanus" name="vanus" min="0" max="40" value="<?= h($v['vanus']) ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="sunnikuupaev">Sünnikuupäev</label>
                    <input class="form-control" type="date" id="sunnikuupaev" name="sunnikuupaev" max="<?= date('Y-m-d') ?>" value="<?= h($v['sunnikuupaev']) ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="suurus">Suurus *</label>
                    <select class="form-select" id="suurus" name="suurus">
                        <option value="">Vali suurus</option>
                        <?php foreach ($lubatud_suurus as $s): ?>
                            <option value="<?= h($s) ?>"<?= $v['suurus'] === $s ? ' selected' : '' ?>><?= h(ucfirst($s)) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="varvus">Värvus *</label>
                    <input class="form-control" type="text" id="varvus" name="varvus" maxlength="100" value="<?= h($v['varvus']) ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="asukoht">Asukoht *</label>
                    <input class="form-control" type="text" id="asukoht" name="asukoht" maxlength="100" value="<?= h($v['asukoht']) ?>">
                </div>

                <div class="col-12">
                    <label class="form-label" for="luhikirjeldus">Lühikirjeldus *</label>
                    <input class="form-control" type="text" id="luhikirjeldus" name="luhikirjeldus" maxlength="255" value="<?= h($v['luhikirjeldus']) ?>">
                </div>

                <div class="col-12">
                    <label class="form-label" for="kirjeldus">Kirjeldus *</label>
                    <textarea class="form-control" id="kirjeldus" name="kirjeldus" rows="7"><?= h($v['kirjeldus']) ?></textarea>
                </div>

            </div>
        </div>
        </div>
        </div>

        <div class="col-lg-4">
        <div class="card shadow-sm">
        <div class="card-body p-4">
            <h2 class="h5 fw-bold mb-3">Haldus ja foto</h2>

            <div class="mb-3">
                <label class="form-label" for="staatus">Staatus *</label>
                <select class="form-select" id="staatus" name="staatus">
                    <?php foreach ($lubatud_staatus as $s): ?>
                        <option value="<?= h($s) ?>"<?= $v['staatus'] === $s ? ' selected' : '' ?>><?= h(ucfirst($s)) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label" for="tootaja_id">Vastutav töötaja *</label>
                <select class="form-select" id="tootaja_id" name="tootaja_id">
                    <option value="">Vali töötaja</option>
                    <?php foreach ($tootajad as $w): ?>
                        <option value="<?= (int)$w['id'] ?>"<?= $v['tootaja_id'] === (int)$w['id'] ? ' selected' : '' ?>><?= h($w['nimi']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label" for="pilt">Foto</label>
                <input class="form-control" type="file" id="pilt" name="pilt" accept="image/jpeg,image/png,image/webp">
                <div class="form-text">JPG, PNG või WEBP, kuni 2 MB. Ilma fotota kasutatakse placeholder.svg.</div>
            </div>

            <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" id="steriliseeritud" name="steriliseeritud" value="1"<?= $v['steriliseeritud'] ? ' checked' : '' ?>>
                <label class="form-check-label" for="steriliseeritud">Steriliseeritud</label>
            </div>

            <div class="form-check form-switch mb-4">
                <input class="form-check-input" type="checkbox" id="kiibistatud" name="kiibistatud" value="1"<?= $v['kiibistatud'] ? ' checked' : '' ?>>
                <label class="form-check-label" for="kiibistatud">Kiibistatud</label>
            </div>

            <button type="submit" class="btn btn-success w-100 mb-2">
                <i class="fa-solid fa-floppy-disk me-2"></i>
                Salvesta loom
            </button>
            <a href="animals.php" class="btn btn-outline-secondary w-100">Tühista</a>

        </div>
        </div>
        </div>

        </div>
        </form>

    </div>
    </main>

<script>
(function () {
    var liik = document.getElementById('liik_id');
    var toug = document.getElementById('toug_id');
    function filtreeri() {
        var valitud = liik.value;
        var opts = toug.querySelectorAll('option[data-liik]');
        opts.forEach(function (o) {
            var sobib = (o.getAttribute('data-liik') === valitud);
            o.hidden = !sobib;
            o.disabled = !sobib;
            if (!sobib && o.selected) { toug.value = ''; }
        });
    }
    liik.addEventListener('change', filtreeri);
    filtreeri();
})();
</script>
<?php require __DIR__ . "/includes/footer.php"; ?>
