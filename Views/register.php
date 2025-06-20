<?php
// Démarrer la session (si besoin)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Variable d'erreur initiale
$error = '';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    // Vérifications simples
    if (empty($username) || empty($email) || empty($password) || empty($confirm)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email invalide.";
    } elseif ($password !== $confirm) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        // Ici tu pourrais ajouter la logique pour enregistrer l'utilisateur en BDD, etc.
        // Pour l'exemple, on simule un succès :
        $success = "Inscription réussie pour l'utilisateur : " . htmlspecialchars($username);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Inscription</title>
    <style>
        body {
            background-color: #fff8e1;
            font-family: Arial, sans-serif;
            color: #ff9800;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        form {
            background-color: #ffb300;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 0 10px #ff9800cc;
            width: 320px;
            box-sizing: border-box;
            color: white;
        }
        input {
            display: block;
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
        }
        button {
            background-color: #ffa000;
            border: none;
            padding: 12px;
            width: 100%;
            font-size: 1rem;
            color: white;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #ff6f00;
        }
        .alert {
            background-color: #f44336;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            color: white;
            font-weight: bold;
            text-align: center;
        }
        .success {
            background-color: #4caf50;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            color: white;
            font-weight: bold;
            text-align: center;
        }
        ::placeholder {
            color: #ffe082;
        }
    </style>
</head>
<body>

<form method="POST" action="">
    <h2 style="text-align:center; margin-bottom: 20px;">Inscription</h2>

    <?php if (!empty($error)) : ?>
        <div class="alert"><?= htmlspecialchars($error) ?></div>
    <?php elseif (!empty($success)) : ?>
        <div class="success"><?= $success ?></div>
    <?php endif; ?>

    <input type="text" name="username" placeholder="Nom d'utilisateur" required value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
    <input type="email" name="email" placeholder="Email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
    <input type="password" name="password" placeholder="Mot de passe" required>
    <input type="password" name="confirm" placeholder="Confirmer le mot de passe" required>
    <button type="submit">S'inscrire</button>
</form>

</body>
</html>
