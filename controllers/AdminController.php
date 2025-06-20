<?php
require_once 'models/User.php';
require_once 'models/Comment.php';
require_once 'models/Photo.php';
require_once 'models/Album.php';

class AdminController {

    // Vérifie la session admin, redirige sinon
    private function checkAdmin(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?page=login');
            exit();
        }
    }

    // Tableau de bord admin
    public function index(): void {
        $this->checkAdmin();
        require 'views/admin_home.php';
    }

    // Liste des utilisateurs
    public function viewUsers(): void {
        $this->checkAdmin();
        $users = User::getAllUsers();
        require 'views/admin_user.php';
    }

    // Supprime un utilisateur par ID
    public function deleteUser(int $id): void {
        $this->checkAdmin();
        User::deleteById($id);
        header('Location: index.php?page=admin_user');
        exit();
    }

    // Affiche le formulaire d'édition d'un utilisateur
    public function editUserRole(int $id): void {
        $this->checkAdmin();
        $user = User::getUserById($id);
        if (!$user) {
            header('Location: index.php?page=admin_user');
            exit();
        }
        require 'views/edit_user.php';
    }

    // Met à jour le rôle d'un utilisateur
    public function updateUserRole(int $id): void {
        $this->checkAdmin();
        if (isset($_POST['role'])) {
            User::updateUserRole($id, $_POST['role']);
        }
        header('Location: index.php?page=admin_user');
        exit();
    }

    // Liste des albums
    public function listAlbums(): void {
        $this->checkAdmin();
        $albums = Album::getAll();
        require 'views/admin_album.php';
    }

    // Supprime un album par ID
    public function deleteAlbum(int $id): void {
        $this->checkAdmin();
        if (Album::delete($id)) {
            header('Location: index.php?page=admin_album');
            exit();
        }
        echo "Échec de la suppression.";
    }

    // Affiche un album avec ses photos et commentaires
    public function viewAlbum(int $id): void {
        $this->checkAdmin();
        $album = Album::getById($id);
        if (!$album) {
            echo "Album non trouvé.";
            return;
        }
        $photos = Photo::getPhotosByAlbumId($id);
        $comments = [];
        foreach ($photos as $photo) {
            $comments[$photo['id']] = Comment::getByPhotoId($photo['id']);
        }
        require 'views/admin_view_album.php';
    }
}
