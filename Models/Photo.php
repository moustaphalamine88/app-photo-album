<?php
require_once __DIR__ . '/../config/Database.php';

class Photo {
    private PDO $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    /**
     * Enregistre une photo dans la base.
     */
    public function save(int $album_id, string $filename, string $path, int $user_id): bool {
        $stmt = $this->db->prepare("INSERT INTO photos (album_id, filename, path, user_id, uploaded_at) VALUES (?, ?, ?, ?, NOW())");
        return $stmt->execute([$album_id, $filename, $path, $user_id]);
    }

    /**
     * Récupère toutes les photos d'un album.
     */
    public function getByAlbumId(int $album_id): array {
        $stmt = $this->db->prepare("SELECT * FROM photos WHERE album_id = :album_id");
        $stmt->bindParam(':album_id', $album_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les dernières photos d'un utilisateur (limitables).
     */
    public function getRecentPhotosByUser(int $userId, int $limit = 6): array {
        $stmt = $this->db->prepare("
            SELECT photos.* FROM photos
            JOIN albums ON photos.album_id = albums.id
            WHERE albums.user_id = :user_id
            ORDER BY photos.uploaded_at DESC
            LIMIT :limit
        ");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        // bindValue est nécessaire ici pour limiter correctement le type
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère une photo par son ID.
     */
    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM photos WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Supprime une photo par son ID.
     */
    public function delete(int $photoId): bool {
        $stmt = $this->db->prepare("DELETE FROM photos WHERE id = ?");
        return $stmt->execute([$photoId]);
    }

    /**
     * Récupère une photo avec l'id de son propriétaire (user_id de l'album).
     */
    public function getPhotoWithUser(int $photoId): ?array {
        $stmt = $this->db->prepare("
            SELECT photos.*, albums.user_id 
            FROM photos 
            JOIN albums ON photos.album_id = albums.id 
            WHERE photos.id = :photo_id
            LIMIT 1
        ");
        $stmt->bindParam(':photo_id', $photoId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Méthode statique pour récupérer les photos d’un album (avec tableau associatif).
     */
    public static function getPhotosByAlbumId(int $albumId): array {
        $db = Database::connect();
        $stmt = $db->prepare('SELECT * FROM photos WHERE album_id = :albumId');
        $stmt->execute(['albumId' => $albumId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllPhotosByUser(int $userId): array {
    $stmt = $this->db->prepare("
        SELECT * FROM photos
        WHERE user_id = :user_id
        ORDER BY uploaded_at DESC
    ");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
 
   public function likePhoto($photoId, $userId) {
    // Vérifie si le like existe déjà
    $stmt = $this->db->prepare("SELECT COUNT(*) FROM likes WHERE photo_id = ? AND user_id = ?");
    $stmt->execute([$photoId, $userId]);

    if ($stmt->fetchColumn() > 0) {
        // Déjà liké
        return false;
    }

    // Insère le like
    $stmt = $this->db->prepare("INSERT INTO likes (photo_id, user_id) VALUES (?, ?)");
    $success = $stmt->execute([$photoId, $userId]);

    if (!$success) {
        echo "<pre>";
        print_r($stmt->errorInfo()); // Débogage
        echo "</pre>";
    }

    return $success;
}







public function getAllFavorites() {
    $stmt = $this->db->prepare("
        SELECT albums.title, photos.path, photos.filename, users.username, likes.user_id, likes.liked_at AS liked_at
        FROM photos
        JOIN albums ON photos.album_id = albums.id
        JOIN likes ON photos.id = likes.photo_id
        JOIN users ON likes.user_id = users.id
        ORDER BY likes.id DESC
    ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}


