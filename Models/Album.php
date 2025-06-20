<?php
// model/Album.php
require_once __DIR__ . '/../config/database.php';

class Album {
    private PDO $db;

    public ?int $id = null;
    public int $user_id;
    public string $title;
    public ?string $description = null;
    public ?string $tags = null;
    public string $visibility;

    public function __construct() {
        $this->db = Database::connect();
    }

    /**
     * Crée un nouvel album et retourne son ID ou false en cas d'échec.
     * @return int|false
     */
    public function create(): int|false {
        $query = "INSERT INTO albums (user_id, title, description, tags, visibility, created_at)
                  VALUES (:user_id, :title, :description, :tags, :visibility, NOW())";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $this->title, PDO::PARAM_STR);
        $stmt->bindParam(':description', $this->description, PDO::PARAM_STR);
        $stmt->bindParam(':tags', $this->tags, PDO::PARAM_STR);
        $stmt->bindParam(':visibility', $this->visibility, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return (int) $this->db->lastInsertId();
        }
        return false;
    }

    /**
     * Récupère tous les albums.
     * @return array
     */
    public static function getAll(): array {
        $db = Database::connect();
        $stmt = $db->query("SELECT * FROM albums ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un album par son ID.
     * @param int $id
     * @return array|null
     */
    public static function getById(int $id): ?array {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM albums WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Récupère tous les albums visibles pour un utilisateur donné ou publics.
     * @param int|null $userId
     * @return array
     */
    public static function getVisibleAlbumsForUser(?int $userId = null): array {
        $db = Database::connect();

        if ($userId !== null) {
            $stmt = $db->prepare("SELECT * FROM albums WHERE visibility = 'public' OR user_id = ?");
            $stmt->execute([$userId]);
        } else {
            $stmt = $db->prepare("SELECT * FROM albums WHERE visibility = 'public'");
            $stmt->execute();
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère tous les albums d'un utilisateur (propriétaire + partagés via permissions).
     * @param int $userId
     * @return array
     */
    public static function getByUserId(int $userId): array {
        $db = Database::connect();

        $sqlOwn = "SELECT * FROM albums WHERE user_id = :user_id";
        $sqlShared = "SELECT a.* FROM albums a
                      INNER JOIN album_permissions ap ON a.id = ap.album_id
                      WHERE ap.user_id = :user_id";

        $sql = "($sqlOwn) UNION ($sqlShared) ORDER BY created_at DESC";

        $stmt = $db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Met à jour l'album actuel.
     * @return bool
     * @throws InvalidArgumentException
     */
    public function update(): bool {
        if (!$this->id) {
            throw new InvalidArgumentException("L'id de l'album doit être défini pour la mise à jour.");
        }

        $query = "UPDATE albums 
                  SET title = :title, description = :description, tags = :tags, visibility = :visibility 
                  WHERE id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $this->title, PDO::PARAM_STR);
        $stmt->bindParam(':description', $this->description, PDO::PARAM_STR);
        $stmt->bindParam(':tags', $this->tags, PDO::PARAM_STR);
        $stmt->bindParam(':visibility', $this->visibility, PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
     * Supprime un album et toutes ses photos.
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public static function delete(int $id): bool {
        $db = Database::connect();

        try {
            // Suppression des photos de l'album
            $stmtPhotos = $db->prepare('DELETE FROM photos WHERE album_id = :id');
            $stmtPhotos->execute(['id' => $id]);

            // Suppression des permissions liées (si applicable)
            $stmtPermissions = $db->prepare('DELETE FROM album_permissions WHERE album_id = :id');
            $stmtPermissions->execute(['id' => $id]);

            // Suppression de l'album
            $stmtAlbum = $db->prepare('DELETE FROM albums WHERE id = :id');
            $stmtAlbum->execute(['id' => $id]);

            return true;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la suppression de l'album : " . $e->getMessage());
        }
    }
}
