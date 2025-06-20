<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des albums</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .retour {
  float: left;
  /* ou */
  text-align: left;
  /* ou en complément */
  margin-left: 0;
  display: inline-block;
}

        .custom-modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            text-align: center;
            max-width: 400px;
            margin: auto;
        }

        .modal-buttons {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        .btn, .modal-buttons a, .modal-buttons button {
            background-color: #000 !important;
            color: #fff !important;
            border: none !important;
            padding: 8px 12px;
            border-radius: 4px;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #333 !important;
        }

        .table-responsive {
            overflow-x: auto;
        }

        i.bi {
            font-size: 1rem;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary px-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php?page=admin_home">
            <img src="assets/image/adminimg.png" alt="Logo" width="150" height="80">
        </a>
        <div class="ms-auto d-flex flex-column flex-sm-row gap-2 align-items-center">
          <span class="navbar-text fw-bold text-center text-sm-start">Admin : <?= htmlspecialchars($_SESSION['user']['username']); ?></span>
          <a href="index.php?page=logout" class="btn btn-sm mt-1 mt-sm-0">Déconnexion</a>
        </div>

    </div>
</nav>

<main class="container my-5">
    <h1 class="text-center mb-4">Liste des albums</h1>

    <?php if (empty($albums)): ?>
        <p class="text-center text-muted">Aucun album trouvé.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Date de création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($albums as $album): ?>
                        <tr>
                            <td><?= htmlspecialchars($album['id']); ?></td>
                            <td><?= htmlspecialchars($album['title']); ?></td>
                            <td><?= htmlspecialchars($album['created_at']); ?></td>
                            <td>
                                <button class="btn btn-sm deleteBtn me-2" title="Supprimer" data-id="<?= $album['id']; ?>">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <a href="index.php?page=admin_view_album&id=<?= $album['id']; ?>" class="btn btn-sm" title="Voir plus">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="index.php?page=admin_home" class="btn retour">Retour</a>

          <!-- Bouton pour accéder aux favoris -->
<!-- Bouton pour accéder aux favoris -->
<a href="index.php?page=admin_favorite" style="
    display: inline-block;
    padding: 12px 14px;
    background-color:rgb(24, 12, 3);
    color: white;
    border-radius: 6px;
    text-decoration: none;
    font-weight: bold;
    margin-bottom: 1rem;
    float: right;
    margin-left: 0;
    transition: background-color 0.3s ease;
">
    Voir les photos favorites
</a>

<style>
a:hover {
  background-color:rgb(14, 12, 11) !important;
}
</style
    </div>
</main>

<footer class="text-center py-5 mt-5">
    <p style="font-size: 1.2rem;">&copy; 2025 Photo Album. Tous droits réservés.</p>
</footer>

<!-- Modale -->
<div id="confirmDeleteModal" class="custom-modal">
    <div class="modal-content">
        <p>Êtes-vous sûr de vouloir supprimer cet album ? Cette action est irréversible.</p>
        <div class="modal-buttons">
            <a id="confirmDeleteBtn" href="#">Supprimer</a>
            <button id="cancelDeleteBtn">Annuler</button>
        </div>
    </div>
</div>

<script>
    const deleteButtons = document.querySelectorAll('.deleteBtn');
    const modal = document.getElementById('confirmDeleteModal');
    const confirmBtn = document.getElementById('confirmDeleteBtn');
    const cancelBtn = document.getElementById('cancelDeleteBtn');

    let albumIdToDelete = null;

    deleteButtons.forEach(button => {
        button.addEventListener('click', () => {
            albumIdToDelete = button.getAttribute('data-id');
            confirmBtn.href = `index.php?page=admin_delete_album&id=${albumIdToDelete}`;
            modal.style.display = 'flex';
        });
    });

    cancelBtn.addEventListener('click', () => {
        modal.style.display = 'none';
        albumIdToDelete = null;
    });

    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
            albumIdToDelete = null;
        }
    });
</script>

</body>
</html>
