<?php
session_start();  // Toujours démarrer la session ici

class HomeController {
    public function index(): void {
        // Vérifier si la session est déjà démarrée
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }   
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            // Afficher la page publique si l'utilisateur n'est pas connecté
            include 'views/home.php';
        } else {
            // Afficher la page d'accueil privée si l'utilisateur est connecté
            $user = $_SESSION['user'];
            include 'views/user_home.php'; 
        }
    }
}
