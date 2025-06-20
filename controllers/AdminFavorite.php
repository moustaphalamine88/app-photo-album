<?php
require_once 'models/Photo.php';
require_once 'config/Database.php';



// Vérifier si l'utilisateur est admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: index.php?page=login');
    exit;
}

$pdo = Database::connect();
$photoModel = new Photo($pdo);

// Pour un admin, on veut probablement tous les favoris, donc on n'utilise pas de filtre user_id
$favorites = $photoModel->getAllFavorites(); // <-- méthode à créer dans Photo.php

// Inclure la vue admin des favoris
require 'views/admin_favorite.php';