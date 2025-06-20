<?php

require_once 'config/Database.php';
require_once 'Models/Album.php';
require_once 'Models/Photo.php';
require_once 'Models/Comment.php';

class AlbumController {
    private Album $albumModel;
    private Photo $photoModel;
    private Comment $commentModel;

    public function __construct() {
        $this->albumModel = new Album();
        $this->photoModel = new Photo();
        $this->commentModel = new Comment();
    }

    public function saveAlbum(array $data): void {
        if (empty($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit();
        }

        $this->albumModel->user_id = $_SESSION['user_id'];
        $this->albumModel->title = trim($data['title'] ?? '');
        $this->albumModel->description = trim($data['description'] ?? '');
        $this->albumModel->tags = trim($data['tags'] ?? '');
        $this->albumModel->visibility = $data['visibility'] ?? 'public';

        $albumId = $this->albumModel->create();

        if ($albumId) {
            header('Location: index.php?page=add_photos&album_id=' . $albumId);
            exit();
        }

        echo "Erreur lors de la création de l'album.";
    }

    public function view(int $album_id): void {
        $album = $this->albumModel->getById($album_id);

        if (!$album) {
            echo "Album introuvable.";
            return;
        }

        if ($album['visibility'] === 'private' && ($_SESSION['user_id'] ?? null) != $album['user_id']) {
            echo "Accès refusé à cet album privé.";
            return;
        }

        $photos = $this->photoModel->getByAlbumId($album_id);

        // Récupération des commentaires groupés par photo id
        $comments = [];
        foreach ($photos as $photo) {
            $comments[$photo['id']] = $this->commentModel->getByPhotoId($photo['id']);
        }

        require 'views/view_album.php';
    }

    public function index(): void {
        $userId = $_SESSION['user_id'] ?? null;
        $albums = $this->albumModel->getVisibleAlbumsForUser($userId);
        require 'views/album_list.php';
    }

    public function editForm(int $album_id): void {
        $album = $this->albumModel->getById($album_id);

        if (!$album || $album['user_id'] !== ($_SESSION['user']['id'] ?? null)) {
            echo "Album introuvable ou accès refusé.";
            return;
        }

        require 'views/edit_album.php';
    }

    public function updateAlbum(array $postData): void {
        $albumId = $postData['album_id'] ?? null;
        if (!$albumId) {
            echo "ID d'album manquant.";
            return;
        }

        $this->albumModel->id = $albumId;
        $this->albumModel->title = trim($postData['title'] ?? '');
        $this->albumModel->description = trim($postData['description'] ?? '');
        $this->albumModel->tags = trim($postData['tags'] ?? '');
        $this->albumModel->visibility = $postData['visibility'] ?? 'public';

        $this->albumModel->update();

        header('Location: index.php?page=user_home');
        exit();
    }

    public function deleteAlbum(int $albumId): void {
        if ($this->albumModel->delete($albumId)) {
            header('Location: index.php?page=user_home');
            exit();
        }

        echo "Erreur lors de la suppression de l'album.";
    }
}
