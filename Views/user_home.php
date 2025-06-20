<?php
require_once 'Models/Album.php';
require_once 'Models/Photo.php';
require_once 'Models/Favorite.php';

$user = $_SESSION['user'];
$userId = $user['id'];

// Récupération des albums de l'utilisateur
$albums = Album::getByUserId($userId);

// Récupération des dernières photos de l'utilisateur
$photoModel = new Photo();
$photos = $photoModel->getRecentPhotosByUser($userId);

// Récupération des IDs favoris pour l'utilisateur (pour pré-cocher les cœurs)
$favModel = new Favorite();
$favoritesIds = $favModel->getFavoritesIdsByUser($userId);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/user_home.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .card-img-top {
            width: 100%;
            height: 200px;         
            object-fit: cover;     
            border-radius: 5px;
        }
        /* Style du bouton cœur */
        .btn-favorite {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 1.8rem;
            color: rgba(255, 255, 255, 0.7);
            cursor: pointer;
            transition: color 0.3s ease;
            z-index: 10;
        }
        .btn-favorite.favorited {
            color: #ff4d4d;
            text-shadow: 0 0 5px rgba(255, 77, 77, 0.7);
        }
        .photo-card {
            position: relative;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary px-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="assets/image/imgornage.png" alt="Logo Photo Album" width="150" height="80">
    </a>

    <div class="ms-auto d-flex flex-column flex-sm-row gap-2 align-items-sm-center text-end">
         <span class="fw-bold">Bienvenue, <?= htmlspecialchars($user['username']) ?></span>
         <a href="index.php?page=logout" class="btn btn-outline-danger btn-sm logout-btn">Déconnexion</a>
    </div>
  </div>
</nav>

<main class="container my-5">
    <h2 class="text-center mb-4">Tableau de bord</h2>

    <section class="mb-5 text-center">
        <p>Gérez vos albums photo, ajoutez de nouvelles photos, et bien plus encore.</p>
        <a href="index.php?page=create_album" class="btn btn-primary">Créer un nouvel album</a>
    </section>

    <section class="mb-5">
        <h3>Vos albums</h3>
        <?php if (empty($albums)): ?>
            <p>Aucun album pour le moment.</p>
        <?php else: ?>
            <ul class="list-group">
                <?php foreach ($albums as $album): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong><?= htmlspecialchars($album['title']) ?></strong><br>
                            <small><?= htmlspecialchars($album['description']) ?></small>
                        </div>
                        <div class="album-actions d-flex flex-wrap gap-1">
                          <a href="index.php?page=add_photos&album_id=<?= $album['id'] ?>" class="btn btn-sm btn-outline-primary" title="Ajouter des photos">
                            <i class="bi bi-plus-circle"></i>
                          </a>
                          <a href="index.php?page=view_album&album_id=<?= $album['id'] ?>" class="btn btn-sm btn-primary" title="Voir l'album">
                            <i class="bi bi-eye"></i>
                          </a>
                          <a href="index.php?page=edit_album&album_id=<?= $album['id'] ?>" class="btn btn-sm btn-warning" title="Modifier l'album">
                            <i class="bi bi-pencil-square"></i>
                          </a>
                          <a href="#" class="btn btn-sm btn-danger delete-btn" data-album-id="<?= $album['id'] ?>" title="Supprimer l'album">
                            <i class="bi bi-trash"></i>
                          </a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </section>

    <section>
        <h3>Vos dernières photos</h3>
        <div id="photo-container" class="row">
            <!-- Les photos seront insérées ici par JS -->
        </div>

        <div id="pagination" class="text-center my-3">
            <button id="prevBtn" class="btn btn-secondary mx-2">Précédent</button>
            <span id="pageNumbers"></span>
            <button id="nextBtn" class="btn btn-secondary mx-2">Suivant</button>
        </div>
    </section>

</main>

<footer class="text-center py-5 mt-5">
    <p style="font-size: 1.2rem;">&copy; 2025 Photo Album. Tous droits réservés.</p>
    <p>
        <a href="#" style="font-size: 1.1rem;">Politique de confidentialité</a> |
        <a href="#" style="font-size: 1.1rem;">Conditions d'utilisation</a>
    </p>
</footer>

<div id="confirmDeleteModal" class="modal">
  <div class="modal-content">
    <p>Êtes-vous sûr de vouloir supprimer cet album ? Cette action est irréversible.</p>
    <div class="modal-actions">
      <button id="confirmDeleteBtn" class="btn-orange">Supprimer</button>
      <button id="cancelDeleteBtn" class="btn-cancel">Annuler</button>
    </div>
  </div>
</div>

<script>
document.querySelectorAll('.delete-btn').forEach(button => {
  button.addEventListener('click', function (e) {
    e.preventDefault();
    const albumId = this.dataset.albumId;
    const confirmBtn = document.getElementById('confirmDeleteBtn');

    confirmBtn.dataset.albumId = albumId; // stocker l’ID
    document.getElementById('confirmDeleteModal').style.display = 'flex';
  });
});

document.getElementById('cancelDeleteBtn').addEventListener('click', function () {
  document.getElementById('confirmDeleteModal').style.display = 'none';
});

document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
  const albumId = this.dataset.albumId;
  window.location.href = `index.php?page=delete_album&album_id=${albumId}`;
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


  <script>
  const photos = <?= json_encode($photos, JSON_HEX_TAG); ?>;
  const favoritesIds = <?= json_encode($favoritesIds, JSON_HEX_TAG); ?>;
</script>


<script src="assets/js/page.js"></script>

<script src="assets/js/like.js"></script>

</body>
</html>
