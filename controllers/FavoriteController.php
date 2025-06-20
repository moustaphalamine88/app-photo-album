<?php
require_once 'Models/Favorite.php';

class FavoriteController {
    private $favoriteModel;

    public function __construct() {
        $this->favoriteModel = new Favorite();
    }

    // Ajouter ou retirer un favori (toggle)
    public function toggleFavorite(int $userId, int $photoId): void {
        if ($this->favoriteModel->isFavorited($userId, $photoId)) {
            // Si déjà favori, on enlève
            $this->favoriteModel->remove($userId, $photoId);
        } else {
            // Sinon on ajoute
            $this->favoriteModel->add($userId, $photoId);
        }
    }

    // Récupérer les favoris d’un utilisateur
    public function getFavorites(int $userId): array {
        return $this->favoriteModel->getByUser($userId);
    }
}
