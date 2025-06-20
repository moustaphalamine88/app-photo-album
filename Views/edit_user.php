<?php
if (!isset($user)) {
    header('Location: index.php?page=admin_users');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/CSS/edit_user.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Éditer le rôle de l'utilisateur</title>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
       /* Tous les boutons en noir avec texte blanc */
button,
.btn,
input[type="submit"],
input[type="button"] {
    background-color: black !important;
    color: white !important;
    border: none;
    padding: 0.6rem 1.2rem;
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

/* Effet au survol */
button:hover,
.btn:hover,
input[type="submit"]:hover,
input[type="button"]:hover {
    background-color: black !important;
    color: #fff !important;
}

    </style>
</head>
<body>

    <form action="index.php?page=update_user_role&id=<?= $user['id']; ?>" method="POST" class="edit-user-form">
        <h1>Éditer le rôle de <?= htmlspecialchars($user['username']); ?> </h1>

        <label for="role">Rôle</label>
        <select id="role" name="role">
            <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>Utilisateur</option>
            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Administrateur</option>
        </select>

        <button type="submit">Enregistrer</button>
        <br>
        <a href="index.php?page=admin_user">Annuler</a>
    </form>

</body>
</html>
