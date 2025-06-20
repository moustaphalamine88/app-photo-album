<?php

require_once 'models/User.php';

class LoginController {
    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Démarrer la session si ce n'est pas déjà fait
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Si l'utilisateur est déjà connecté, rediriger selon son rôle
            if (isset($_SESSION['user'])) {
                if ($_SESSION['role'] === 'admin') {
                    header('Location: index.php?page=admin_home');
                } else {
                    header('Location: index.php?page=user_home');
                }
                exit();
            }

            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Vérifier les identifiants
            $userModel = new User();
            $user = $userModel->login($email, $password);

            if ($user) {
                // Stocker les informations dans la session
                $_SESSION['user'] = $user;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];

                // Redirection selon le rôle
                if ($user['role'] === 'admin') {
                    header('Location: index.php?page=admin_home');
                } else {
                    header('Location: index.php?page=user_home');
                }
                exit();
            } else {
                $error = "Identifiants incorrects";
                require 'views/login.php';
            }
        } else {
            require 'views/login.php';
        }
    }
}
