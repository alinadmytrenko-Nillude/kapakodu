<?php
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

                        <form>

                            <div class="row mb-3">

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        Sinu nimi
                                    </label>

                                    <input type="text" class="form-control" placeholder="Sinu nimi">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        E-post
                                    </label>

                                    <input type="email" class="form-control" placeholder="Sinu e-post">
                                </div>

                            </div>

                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Teema
                                </label>

                                <select class="form-select">
                                    <option selected>Vali teema</option>
                                    <option>Looma adopteerimine</option>
                                    <option>Vabatahtlik töö</option>
                                    <option>Annetamine</option>
                                    <option>Üldine küsimus</option>
                                </select>

                            </div>

                            <div class="mb-4">

                                <label class="form-label fw-semibold">
                                    Sõnum
                                </label>

                                <textarea class="form-control" rows="5"
                                    placeholder="Kirjuta oma sõnum siia..."></textarea>

                            </div>

                            <button class="btn btn-success px-4">
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
