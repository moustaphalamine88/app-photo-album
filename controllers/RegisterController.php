<?php

require_once 'models/User.php';

class RegisterController {
    public function index() {
        // Si le formulaire est soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérifier si l'utilisateur est déjà connecté
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            if (isset($_SESSION['user'])) {
                header('Location: index.php?page=user_home');
                exit();
            }
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm'] ?? '';

            // Simple validation
            if ($password !== $confirm) {
                $error = "Les mots de passe ne correspondent pas.";
                require 'view/register.php';
                return;
            }

            // Créer un nouvel utilisateur
            $user = new User();
            $success = $user->register($username, $email, $password);

            if ($success) {
                header('Location: index.php?page=login');
                exit();
            } else {
                $error = "Erreur lors de l'enregistrement.";
            }
        }

        require 'views/register.php';
    }
}

  
  
  