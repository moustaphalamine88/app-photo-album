<?php
// Démarrer la session si nécessaire
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifier que l'utilisateur est bien un administrateur
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php?page=login');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Admin</title>
    <link rel="stylesheet" href="assets/css/admin_home.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary px-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php?page=user_home">
            <img src="assets/image/adminimg.png" alt="Logo Photo Album" width="150" height="80">
        </a>

        <div class="ms-auto d-flex flex-column flex-sm-row align-items-end align-items-sm-center gap-2 text-end mt-2 mt-sm-0">
          <span class="navbar-text fw-bold">
            Admin : <?= htmlspecialchars($_SESSION['user']['username']) ?>
          </span>
          <a href="index.php?page=logout" class="btn btn-outline-danger btn-sm">Déconnexion</a>
        </div>

    </div>
</nav>
<main class="container my-5">
    <h1 class="text-center mb-4">Tableau de bord administrateur</h1>

    <div class="row justify-content-center">
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm p-5">
                <h4>Gérer les utilisateurs</h4>
                <p>Voir, modifier ou supprimer des utilisateurs.</p>
                <a href="index.php?page=admin_user" class="btn btn-primary">Voir les utilisateurs</a>

            </div>
        </div>
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm p-5">
                <h4>Gérer les albums</h4>
                <p>Consulter et modérer les albums publics.</p>
                <a href="index.php?page=admin_album" class="btn btn-primary">Voir les albums</a>
            </div>
        </div>
    </div>
</main>

<footer class="text-center py-5 mt-5">
    <p style="font-size: 1.2rem;">&copy; 2025 Photo Album. Tous droits réservés.</p>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
