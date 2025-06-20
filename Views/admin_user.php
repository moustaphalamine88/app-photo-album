<?php
// Sécurité : empêche l'accès direct à la vue
if (!isset($users)) {
    header('Location: index.php?page=admin_home');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des utilisateurs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        /* Boutons noirs personnalisés */
        .btn-black {
            background-color: #000;
            color: #fff;
            border: none;
        }

        .btn-black:hover,
        .btn-black:focus {
            background-color: #222;
            color: #fff;
        }

        /* Table responsive */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Modale */
        #confirmDeleteModal {
            display: none;
            position: fixed;
            top:0; left:0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
            z-index: 2000;
        }

        #confirmDeleteModal.active {
            display: flex;
        }

        #confirmDeleteModal .modal-content {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            color: #000;
        }

        #confirmDeleteModal button {
            background-color: #000;
            color: #fff;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 1rem;
            margin: 0 0.5rem;
            transition: background-color 0.3s ease;
        }

        #confirmDeleteModal button:hover {
            background-color: #222;
        }

        /* Responsive bouton de déconnexion */
        @media (max-width: 576px) {
            .admin-header {
                flex-direction: column;
                align-items: flex-end;
                gap: 0.5rem;
            }
            .admin-header .btn {
                width: 100%;
                text-align: right;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary px-4">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <a class="navbar-brand" href="index.php?page=admin_home">
            <img src="assets/image/adminimg.png" alt="Logo Photo Album" width="150" height="80">
        </a>
        <div class="d-flex align-items-center admin-header gap-2">
            <span class="navbar-text fw-bold">Admin : <?= htmlspecialchars($_SESSION['user']['username']) ?></span>
            <a href="index.php?page=logout" class="btn btn-black btn-sm">Déconnexion</a>

        </div>
    </div>
</nav>

<main class="container my-5">
    <h1 class="text-center mb-4">Liste des utilisateurs</h1>

    <?php if (empty($users)): ?>
        <p class="text-center text-muted">Aucun utilisateur trouvé.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered align-middle table-striped">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Nom d'utilisateur</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Date d'inscription</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['role']) ?></td>
                            <td><?= htmlspecialchars($user['created_at']) ?></td>
                            <td class="text-center">
                                <a href="index.php?page=edit_user&id=<?= $user['id'] ?>" 
                                   class="btn btn-black btn-sm mb-1" 
                                   title="Éditer l'utilisateur">
                                   <i class="bi bi-pencil" style="font-size: 1rem;"></i>
                                </a>
                                <button 
                                   class="btn btn-black btn-sm btn-delete-user mb-1" 
                                   title="Supprimer l'utilisateur"
                                   data-user-id="<?= $user['id'] ?>" 
                                   data-user-name="<?= htmlspecialchars($user['username']) ?>">
                                   <i class="bi bi-trash" style="font-size: 1rem;"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="index.php?page=admin_home" class="btn btn-black">Retour</a>
    </div>
</main>

<!-- Modale de confirmation suppression -->
<div id="confirmDeleteModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle" aria-describedby="modalDesc">
    <div class="modal-content">
        <p id="modalDesc">Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.</p>
        <div>
            <button id="confirmDeleteBtn">Supprimer</button>
            <button id="cancelDeleteBtn">Annuler</button>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('confirmDeleteModal');
    const confirmBtn = document.getElementById('confirmDeleteBtn');
    const cancelBtn = document.getElementById('cancelDeleteBtn');
    let userIdToDelete = null;

    document.querySelectorAll('.btn-delete-user').forEach(button => {
        button.addEventListener('click', () => {
            userIdToDelete = button.getAttribute('data-user-id');
            const username = button.getAttribute('data-user-name');
            modal.querySelector('#modalDesc').textContent = `Êtes-vous sûr de vouloir supprimer l'utilisateur "${username}" ? Cette action est irréversible.`;
            modal.classList.add('active');
        });
    });

    cancelBtn.addEventListener('click', () => {
        userIdToDelete = null;
        modal.classList.remove('active');
    });

    confirmBtn.addEventListener('click', () => {
        if (userIdToDelete) {
            window.location.href = `index.php?page=delete_user&id=${userIdToDelete}`;
        }
    });

    modal.addEventListener('click', e => {
        if (e.target === modal) {
            userIdToDelete = null;
            modal.classList.remove('active');
        }
    });
</script>

</body>
</html>
