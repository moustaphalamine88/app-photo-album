<?php
require_once 'config/Database.php';

class Comment {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    // Enregistrer un commentaire
    public function save(int $userId, int $photoId, string $content): bool {
        $stmt = $this->db->prepare("INSERT INTO comments (user_id, photo_id, content, created_at) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$userId, $photoId, $content]);
    }

    // Récupérer tous les commentaires d'une photo, avec le nom utilisateur
    public static function getByPhotoId(int $photoId): array {
        $db = Database::connect();
        $stmt = $db->prepare('
            SELECT c.*, u.username AS user_name
            FROM comments c
            LEFT JOIN users u ON c.user_id = u.id
            WHERE c.photo_id = :photoId
            ORDER BY c.created_at DESC
        ');
        $stmt->execute(['photoId' => $photoId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Supprimer un commentaire par son id (fonctionnel pour modération)
    public function delete(int $commentId): bool {
        $stmt = $this->db->prepare("DELETE FROM comments WHERE id = ?");
        return $stmt->execute([$commentId]);
    }

    // Mettre à jour le contenu d'un commentaire (édition)
    public function update(int $commentId, string $newContent): bool {
        $stmt = $this->db->prepare("UPDATE comments SET content = ? WHERE id = ?");
        return $stmt->execute([$newContent, $commentId]);
    }
}
