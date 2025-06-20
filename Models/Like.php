<?php
require_once 'config/database.php';

class Like {
    private $pdo;

    public function __construct() {
        $this->pdo = connect();
    }

    public function addLike($photoId, $userId) {
        try {
            // Vérifie si le like existe déjà
            $stmt = $this->pdo->prepare("SELECT id FROM likes WHERE photo_id = ? AND user_id = ?");
            $stmt->execute([$photoId, $userId]);

            if ($stmt->fetch()) {
                return 'exists'; // Like déjà présent
            }

            // Ajoute le like
            $stmt = $this->pdo->prepare("INSERT INTO likes (photo_id, user_id) VALUES (?, ?)");
            return $stmt->execute([$photoId, $userId]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
