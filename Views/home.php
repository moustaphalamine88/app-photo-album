<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/home.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="assets/image/imgornage.png" alt="Logo Photo Album" width="150" height="80">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
            <div class="d-flex gap-2">
                <a href="index.php?page=login" class="btn btn-outline-primary">
                    <i class="bi bi-box-arrow-in-right"></i> Se connecter
                </a>
                <a href="index.php?page=register" class="btn btn-primary">
                    <i class="bi bi-person-plus"></i> S'inscrire
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- CAROUSEL -->
<div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="assets/image/asera.AVIF" class="d-block w-100" style="max-height: 500px; object-fit: cover;" alt="Image du carousel">
        </div>
    </div>
</div>

<!-- SECTION AVANTAGES -->
<section class="container my-5">
    <h2 class="text-center mb-4">Pourquoi choisir notre Album Photo ?</h2>
    <div class="row g-4 text-center">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-easel2"></i> Facile à utiliser</h5>
                    <p class="card-text">Une interface simple et intuitive pour tous les utilisateurs.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-lock"></i> Accès sécurisé</h5>
                    <p class="card-text">Vos photos sont protégées et accessibles uniquement par vous.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-share"></i> Partage facile</h5>
                    <p class="card-text">Partagez vos albums avec vos proches en un clic.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="bg-dark text-white text-center py-4">
    <p class="mb-2">&copy; 2025 Photo Album. Tous droits réservés.</p>
    <p class="mb-0">
        <a href="#" class="text-white text-decoration-underline me-2">Politique de confidentialité</a> |
        <a href="#" class="text-white text-decoration-underline ms-2">Conditions d'utilisation</a>
    </p>
</footer>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

