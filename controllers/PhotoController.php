<?php
require_once 'Models/Photo.php';
require_once 'config/Database.php';
require_once 'Models/Like.php';

class PhotoController {
    private Photo $photo;

    public function __construct() {
        $this->photo = new Photo();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function uploadPhoto(array $formData, array $fileData): void {
        if (empty($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit();
        }

        if (empty($fileData['photo']) || $fileData['photo']['error'] !== UPLOAD_ERR_OK) {
            echo "Erreur lors de l'envoi du fichier.";
            return;
        }

        $album_id = $formData['album_id'] ?? null;
        if (!$album_id) {
            echo "Album non spécifié.";
            return;
        }

        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true) && !is_dir($uploadDir)) {
            echo "Erreur de création du dossier de destination.";
            return;
        }

        $filename = basename($fileData['photo']['name']);
        $new_name = uniqid('', true) . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $filename);
        $destination = $uploadDir . $new_name;

        if (move_uploaded_file($fileData['photo']['tmp_name'], $destination)) {
            $this->photo->save($album_id, $new_name, $destination, $_SESSION['user_id']);
            header("Location: index.php?page=user_home");
            exit();
        } else {
            echo "Échec de l'upload.";
        }
    }

    public function delete(int $photoId): void {
        if (empty($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit();
        }

        $photo = $this->photo->getById($photoId);
        if (!$photo) {
            echo "Photo introuvable.";
            return;
        }

        if ($photo['user_id'] !== $_SESSION['user_id']) {
            echo "Accès refusé.";
            return;
        }

        if (file_exists($photo['path'])) {
            unlink($photo['path']);
        }

        if ($this->photo->delete($photoId)) {
            header('Location: index.php?page=view_album&id=' . $photo['album_id']);
            exit();
        } else {
            echo "Erreur lors de la suppression.";
        }
    }

    public function showAddPhotoForm(?int $albumId): void {
        if (empty($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit();
        }

        if (!$albumId) {
            echo "Album ID manquant.";
            return;
        }

        require 'views/add_photos.php';
    }

    public function addComment(array $formData): void {
        $photo_id = (int) ($formData['photo_id'] ?? 0);
        $content = trim($formData['content'] ?? '');

        if ($photo_id <= 0 || $content === '') {
            echo "Commentaire invalide.";
            return;
        }

        if (empty($_SESSION['user_id'])) {
            echo "Utilisateur non connecté.";
            return;
        }

        require_once 'Models/Comment.php';
        $commentModel = new Comment();

        try {
            $commentModel->save($photo_id, $_SESSION['user_id'], $content);
            $album_id = (int) ($_GET['album_id'] ?? 0);
            header("Location: index.php?page=view_album&album_id={$album_id}");
            exit();
        } catch (Exception $e) {
            echo "Erreur lors de l'ajout du commentaire.";
        }
    }

    public function like(int $photoId, int $userId): void {
        header('Content-Type: application/json');

        if ($photoId <= 0 || $userId <= 0) {
            http_response_code(400);
            echo json_encode(['error' => 'Paramètres manquants ou invalides']);
            return;
        }

        $likeModel = new Like();
        $result = $likeModel->addLike($photoId, $userId);

        if ($result === true) {
            echo json_encode(['success' => true, 'message' => 'Photo likée']);
        } elseif ($result === 'exists') {
            http_response_code(409);
            echo json_encode(['error' => 'Vous avez déjà liké cette photo']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Erreur lors du like']);
        }
    }
}
