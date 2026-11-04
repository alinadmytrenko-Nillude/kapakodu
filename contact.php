<?php
require_once __DIR__ . '/config.php';

$teemad = ['Looma adopteerimine', 'Vabatahtlik töö', 'Annetamine', 'Üldine küsimus'];
$vead = [];
$nimi = $email = $teema = $sonum = '';

// Kui tullakse looma lehelt (contact.php?loom=ID)
$loom_id = filter_input(INPUT_GET, 'loom', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
if (!$loom_id) { $loom_id = null; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nimi   = trim((string)($_POST['nimi'] ?? ''));
    $email  = trim((string)($_POST['email'] ?? ''));
    $teema  = trim((string)($_POST['teema'] ?? ''));
    $sonum  = trim((string)($_POST['sonum'] ?? ''));
    $post_loom = filter_var($_POST['loom_id'] ?? '', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    $loom_id = $post_loom ?: null;

    if ($nimi === '' || mb_strlen($nimi) > 100) {
        $vead[] = 'Palun sisesta nimi (kuni 100 märki).';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 100) {
        $vead[] = 'Palun sisesta korrektne e-posti aadress.';
    }
    if (!in_array($teema, $teemad, true)) {
        $vead[] = 'Palun vali teema.';
    }
    if (mb_strlen($sonum) < 10 || mb_strlen($sonum) > 2000) {
        $vead[] = 'Sõnum peab olema 10 kuni 2000 märki pikk.';
    }

    // Kontrollime, et loom tõesti olemas on
    if (!$vead && $loom_id !== null) {
        $k = $yhendus->prepare("SELECT id FROM loomad WHERE id = ?");
        $k->bind_param('i', $loom_id);
        $k->execute();
        if (!$k->get_result()->fetch_assoc()) { $loom_id = null; }
        $k->close();
    }

    if (!$vead) {
        $stmt = $yhendus->prepare(
            "INSERT INTO paringud (loom_id, nimi, email, teema, sonum, staatus, lisatud)
             VALUES (?, ?, ?, ?, ?, 'uus', NOW())"
        );
        $stmt->bind_param('issss', $loom_id, $nimi, $email, $teema, $sonum);
        $stmt->execute();
        $stmt->close();
        header('Location: contact.php?saadetud=1');
        exit;
    }
}
$saadetud = isset($_GET['saadetud']);
$page_title = 'Kontakt – Alina Käpakodu';
$breadcrumbs = [['Kontakt', null]];
require __DIR__ . '/header.php';
require __DIR__ . '/breadcrumbs.php';
?>
    <!-- Contact -->
    <div class="container py-5">

        <div class="mb-5">
            <h1 class="fw-bold display-4">Kontakt</h1>
            <p class="fs-5 text-muted">
                Võta meiega ühendust – vastame hea meelega kõikidele küsimustele.
            </p>
        </div>

        <div class="row g-4">

            <!-- Contact information -->
            <div class="col-lg-4">

                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">

                        <h2 class="fw-bold mb-4">Meie kontaktandmed</h2>

                        <div class="d-flex mb-4">
                            <i class="fa-solid fa-location-dot text-success fa-2x me-3 mt-1"></i>
                            <div>
                                <h5 class="fw-bold mb-1">Aadress</h5>
                                <p class="mb-0">
                                    Varjupaiga tee 1<br>
                                    Tallinn 12345
                                </p>
                            </div>
                        </div>

                        <div class="d-flex mb-4">
                            <i class="fa-solid fa-phone text-success fa-2x me-3 mt-1"></i>
                            <div>
                                <h5 class="fw-bold mb-1">Telefon</h5>
                                <p class="mb-0">
                                    +372 5555 1234<br>
                                    E–P 10:00–18:00
                                </p>
                            </div>
                        </div>

                        <div class="d-flex mb-4">
                            <i class="fa-regular fa-envelope text-success fa-2x me-3 mt-1"></i>
                            <div>
                                <h5 class="fw-bold mb-1">E-post</h5>
                                <p class="mb-0">
                                    info@varjupaik.ee
                                </p>
                            </div>
                        </div>

                        <div class="d-flex mb-4">
                            <i class="fa-regular fa-clock text-success fa-2x me-3 mt-1"></i>
                            <div>
                                <h5 class="fw-bold mb-1">Lahtiolekuajad</h5>
                                <p class="mb-0">
                                    E–P 10:00–18:00<br>
                                    L–P kokkuleppel
                                </p>
                            </div>
                        </div>

                        <h5 class="fw-bold mb-3">
                            <i class="fa-solid fa-share-nodes text-success me-2"></i>
                            Jälgi meid
                        </h5>

                        <div class="d-flex gap-3">

                            <a href="#" class="text-decoration-none" aria-label="Facebook">
                                <i class="fa-brands fa-facebook fa-3x text-primary"></i>
                            </a>

                            <a href="#" class="text-decoration-none" aria-label="Instagram">
                                <i class="fa-brands fa-instagram fa-3x" style="color:#E1306C;"></i>
                            </a>

                            <a href="#" class="text-decoration-none" aria-label="YouTube">
                                <i class="fa-brands fa-youtube fa-3x text-danger"></i>
                            </a>

                        </div>

                    </div>
                </div>

            </div>

            <!-- Contact form -->
            <div class="col-lg-8">

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">

                        <h2 class="fw-bold mb-4">Kirjuta meile</h2>

                        <?php if ($saadetud): ?>
                            <div class="alert alert-success" role="alert">Aitäh! Sinu sõnum on saadetud. Vastame sulle esimesel võimalusel.</div>
                        <?php endif; ?>
                        <?php if ($vead): ?>
                            <div class="alert alert-danger" role="alert">
                                <ul class="mb-0">
                                    <?php foreach ($vead as $viga): ?>
                                        <li><?= h($viga) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form action="contact.php" method="post">
                            <input type="hidden" name="loom_id" value="<?= h($loom_id ?? '') ?>">

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nimi" class="form-label fw-semibold">Sinu nimi</label>
                                    <input type="text" class="form-control" id="nimi" name="nimi" maxlength="100" value="<?= h($nimi) ?>" placeholder="Sinu nimi" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold">E-post</label>
                                    <input type="email" class="form-control" id="email" name="email" maxlength="100" value="<?= h($email) ?>" placeholder="Sinu e-post" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="teema" class="form-label fw-semibold">Teema</label>
                                <select class="form-select" id="teema" name="teema" required>
                                    <option value="">Vali teema</option>
                                    <?php foreach ($teemad as $t): ?>
                                        <option value="<?= h($t) ?>"<?= $teema === $t ? ' selected' : '' ?>><?= h($t) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="sonum" class="form-label fw-semibold">Sõnum</label>
                                <textarea class="form-control" id="sonum" name="sonum" rows="5" maxlength="2000" placeholder="Kirjuta oma sõnum siia..." required><?= h($sonum) ?></textarea>
                            </div>

                            <button type="submit" class="btn btn-success px-4">
                                <i class="fa-regular fa-paper-plane me-2"></i>
                                Saada sõnum
                            </button>
                        </form>

                    </div>
                </div>

            </div>

        </div>

    </div>
    <!-- Contact end -->
<?php require __DIR__ . '/footer.php'; ?>
