<!DOCTYPE html>
<html lang="et">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= h($page_title ?? "Admin – Alina Käpakodu") ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>

    <!-- Admin nav -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="../assets/images/logo_big.svg" alt="Loomade Varjupaik" height="50">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminMenu"
                aria-controls="adminMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="adminMenu">

                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="fa-solid fa-house me-1"></i>
                            Avaleht
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="animals.php">
                            <i class="fa-solid fa-paw me-1"></i>
                            Loomad
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="animal_add.html">
                            <i class="fa-solid fa-plus me-1"></i>
                            Lisa loom
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-tags me-1"></i>
                            Kategooriad
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-users me-1"></i>
                            Kasutajad
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fa-regular fa-envelope me-1"></i>
                            Päringud
                        </a>
                    </li>
                </ul>

                <span class="navbar-text me-3">
                    <i class="fa-solid fa-user-shield text-success me-1"></i>
                    Admin
                </span>

                <a href="../login.html" class="btn btn-outline-danger">
                    <i class="fa-solid fa-right-from-bracket me-2"></i>
                    Logi välja
                </a>
            </div>
        </div>
    </nav>
    <!-- Admin nav end -->
