<?php
require_once __DIR__ . '/config.php';

// 4 viimati lisatud looma
$tulemus = $yhendus->query(
    "SELECT l.id, l.nimi, li.nimetus AS liik, l.sugu, l.vanus, l.luhikirjeldus, l.pilt
     FROM loomad l
     JOIN liigid li ON li.id = l.liik_id
     ORDER BY l.id DESC
     LIMIT 4"
);
$loomad = $tulemus->fetch_all(MYSQLI_ASSOC);
?>
<?php
$page_title = 'Avaleht – Alina Käpakodu';
require __DIR__ . '/header.php';
?>

    <div class="container-fluid">
        <!-- Hero section -->
        <div class="container">
            <div class="hero position-relative">
                <div class="hero-text position-absolute top-50 translate-middle-y">
                    <div class="row p-4">
                        <div class="col-7 p-4">
                            <h1 class="display-4 fw-bold">Iga loom väärib armastust ja kodu</h1>
                            <p class="fs-5 pt-4 pb-4">Meie varjupaigas ootavad paljud toredad loomad oma päriskodu. Tule ja leia endale uus parim sõber!</p>
                            <div class="d-flex gap-2">
                                <a href="all_animals.php" class="btn btn-success p-2 w-100"><i class="fa-solid fa-paw"></i> Vaata loomi</a>
                                <a href="#" class="btn btn-outline-success bg-white p-2 w-100">Kuidas aidata?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mission section -->
        <div class="container py-5">
            <div class="row align-items-center">

                <div class="col-lg-7">
                    <div class="row align-items-center">

                        <div class="col-3 text-center">
                            <img src="assets/images/logo_icon.svg" alt="Logo" class="img-fluid" width="110">
                        </div>

                        <div class="col-9">
                            <h2 class="fw-bold mb-3">Meie missioon</h2>

                            <p class="mb-4">
                                Oleme mittetulundusühing, kes aitab koduta ja hätta sattunud loomi.
                                Meie eesmärk on leida igale loomale soe ja armastav kodu ning
                                tõsta inimeste teadlikkust loomade heaolust.
                            </p>

                            <button class="btn btn-outline-success px-5 py-2" type="button">
                                Loe lähemalt meist
                            </button>
                        </div>

                    </div>
                </div>

                <div class="col-lg-5 border-start ps-5">

                    <div class="row mb-4 align-items-start">
                        <div class="col-2 text-center">
                            <i class="fa-regular fa-heart fa-2xl text-success"></i>
                        </div>
                        <div class="col-10">
                            <p class="fw-bold text-success mb-1">Aitame loomi</p>
                            <p class="mb-0">
                                Hoolitseme, ravime ja pakume turvalist peavarju koduta loomadele.
                            </p>
                        </div>
                    </div>

                    <div class="row mb-4 align-items-start">
                        <div class="col-2 text-center">
                            <i class="fa-solid fa-user-group fa-2xl text-success"></i>
                        </div>
                        <div class="col-10">
                            <p class="fw-bold text-success mb-1">Leiame kodud</p>
                            <p class="mb-0">
                                Otsime igale loomale armastavat kodu ja hoolitseme sobiva pere leidmise eest.
                            </p>
                        </div>
                    </div>

                    <div class="row align-items-start">
                        <div class="col-2 text-center">
                            <i class="fa-solid fa-paw fa-2xl text-success"></i>
                        </div>
                        <div class="col-10">
                            <p class="fw-bold text-success mb-1">Harime ja teavitame</p>
                            <p class="mb-0">
                                Korraldame üritusi ja jagame infot loomade heaolu teemadel.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Mission section end -->

        <!-- Animals section -->
        <div class="container py-5 bg-light">

            <div class="text-center mb-5">
                <h2 class="fw-bold">Kodu ootavad loomad</h2>
                <p class="text-muted">
                    Tutvu meie armsate hoolealustega ja leia endale uus sõber.
                </p>
            </div>

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
                            <p class="card-text mb-1"><?= h($loom['liik']) ?>, <?= h($loom['sugu']) ?>, <?= h($loom['vanus']) ?></p>
                            <p class="card-text small text-muted"><?= h($loom['luhikirjeldus']) ?></p>
                            <a href="animal.php?id=<?= (int)$loom['id'] ?>" class="btn btn-success">Vaata lähemalt</a>
                        </div>
                    </div>
                </div>
<?php endforeach; ?>
            </div>

            <div class="text-center mt-5">
                <a href="all_animals.php" class="btn btn-success px-5 py-2">Vaata kõiki loomi</a>
            </div>

        </div>
        <!-- Animals section end -->

<?php require __DIR__ . '/footer.php'; ?>
