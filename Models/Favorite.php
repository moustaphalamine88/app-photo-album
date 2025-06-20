<?php
require_once 'config/Database.php';

class Favorite {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    // Retourne un tableau des IDs des photos favorites pour un user donné
    public function getFavoritesIdsByUser(int $userId): array {
        $stmt = $this->db->prepare('SELECT photo_id FROM favorites WHERE user_id = :userId');
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}

