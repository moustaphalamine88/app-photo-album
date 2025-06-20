<?php
require_once 'Models/Comment.php';
require_once 'Models/Photo.php';

class CommentController {
    public function addComment(array $data): void {
        if (empty($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit();
        }

        $userId = (int) $_SESSION['user_id'];
        $photoId = isset($data['photo_id']) ? (int) $data['photo_id'] : 0;
        $content = trim($data['content'] ?? '');
        $albumId = isset($data['album_id']) ? (int) $data['album_id'] : 0;

        if ($photoId <= 0 || $content === '') {
            echo "Commentaire invalide.";
            return;
        }

        // Vérifier que la photo existe avant d'ajouter le commentaire
        $photoModel = new Photo();
        if (!$photoModel->getById($photoId)) {
            echo "Erreur : la photo n'existe pas.";
            return;
        }

        $commentModel = new Comment();

        try {
            $commentModel->save($userId, $photoId, $content);
            // Redirection vers la page album de l'utilisateur (ou accueil)
            header("Location: index.php?page=user_home&album_id={$albumId}");
            exit();
        } catch (PDOException $e) {
            // En prod, tu devrais logger l'erreur et afficher un message plus générique
            echo "Erreur lors de l'enregistrement du commentaire.";
        }
    }

    public function getCommentsJson(): void {
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['photo_id'])) {
        $photoId = (int) $_GET['photo_id'];
        $comments = Comment::getByPhotoId($photoId);

        header('Content-Type: application/json');
        echo json_encode($comments);
        exit;
    }
}


}
