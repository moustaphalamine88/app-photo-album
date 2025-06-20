<?php
session_start();

/**
 * Vérifie si l'utilisateur est connecté, sinon redirige vers la page de login.
 */
function requireLogin() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php?page=login');
        exit();
    }
}

// Récupération sécurisée de la page demandée
$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'home':
        require 'views/home.php';
        break;

    case 'login':
        require_once 'controllers/LoginController.php';
        (new LoginController())->index();
        break;

    case 'register':
        require_once 'controllers/RegisterController.php';
        (new RegisterController())->index();
        break;

    case 'logout':
        session_destroy();
        header('Location: index.php?page=home');
        exit();

    // Admin routes
    case 'admin_home':
        requireLogin();
        require_once 'controllers/AdminController.php';
        (new AdminController())->index();
        break;

    case 'admin_user':
        requireLogin();
        require_once 'controllers/AdminController.php';
        (new AdminController())->viewUsers();
        break;

    case 'delete_user':
        requireLogin();
        require_once 'controllers/AdminController.php';
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = (int) $_GET['id'];
        (new AdminController())->deleteUser($id);
    } else {
        // Gestion d'erreur : id manquant ou invalide
        header('Location: index.php?page=admin_user');
        exit();
    }
        break;


    case 'edit_user':
        requireLogin();
        $id = isset($_GET['id']) ? intval($_GET['id']) : null;
        if ($id === null) {
            echo "ID utilisateur manquant.";
            break;
        }
        require_once 'controllers/AdminController.php';
        (new AdminController())->editUserRole($id);
        break;

    case 'update_user_role':
        requireLogin();
        $id = isset($_GET['id']) ? intval($_GET['id']) : null;
        if ($id === null) {
            echo "ID utilisateur manquant.";
            break;
        }
        require_once 'controllers/AdminController.php';
        (new AdminController())->updateUserRole($id);
        break;

    case 'admin_album':
        requireLogin();
        require_once 'controllers/AdminController.php';
        (new AdminController())->listAlbums();
        break;

    case 'admin_view_album':
        requireLogin();
        $id = isset($_GET['id']) ? intval($_GET['id']) : null;
        if ($id === null) {
            echo "ID album manquant.";
            break;
        }
        require_once 'controllers/AdminController.php';
        (new AdminController())->viewAlbum($id);
        break;

    case 'admin_delete_album':
        requireLogin();
        $id = isset($_GET['id']) ? intval($_GET['id']) : null;
        if ($id === null) {
            echo "ID album manquant.";
            break;
        }
        require_once 'controllers/AdminController.php';
        (new AdminController())->deleteAlbum($id);
        break;



    // User routes
    case 'user_home':
        requireLogin();
        require 'views/user_home.php';
        break;

    case 'create_album':
        requireLogin();
        require 'views/create_album.php';
        break;

    case 'save_album':
        requireLogin();
        require_once 'controllers/AlbumController.php';
        (new AlbumController())->saveAlbum($_POST);
        break;

    case 'edit_album':
        requireLogin();
        $albumId = isset($_GET['album_id']) ? intval($_GET['album_id']) : null;
        if ($albumId === null) {
            echo "ID album manquant.";
            break;
        }
        require_once 'controllers/AlbumController.php';
        (new AlbumController())->editForm($albumId);
        break;

    case 'update_album':
        requireLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=user_home');
            exit();
        }
        require_once 'controllers/AlbumController.php';
        (new AlbumController())->updateAlbum($_POST);
        break;

    case 'delete_album':
        requireLogin();
        $albumId = isset($_GET['album_id']) ? intval($_GET['album_id']) : null;
        if ($albumId === null) {
            echo "ID album manquant.";
            break;
        }
        require_once 'controllers/AlbumController.php';
        (new AlbumController())->deleteAlbum($albumId);
        break;

   

    case 'view_album':
        $albumId = isset($_GET['album_id']) ? intval($_GET['album_id']) : null;
        if ($albumId === null) {
            http_response_code(400);
            echo "Album ID manquant.";
            exit();
        }
        require_once 'controllers/AlbumController.php';
        (new AlbumController())->view($albumId);
        break;

    case 'add_photos':
        requireLogin();
        $albumId = isset($_GET['album_id']) ? intval($_GET['album_id']) : null;
        require_once 'controllers/PhotoController.php';
        (new PhotoController())->showAddPhotoForm($albumId);
        break;

    case 'upload_photo':
        requireLogin();
        require_once 'controllers/PhotoController.php';
        (new PhotoController())->uploadPhoto($_POST, $_FILES);
        break;

    case 'add_comment':
        requireLogin();
        require_once 'controllers/CommentController.php';
        (new CommentController())->addComment($_POST);
        break;

     case 'favorite_toggle':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            if (empty($_SESSION['user_id'])) {
                header('Location: index.php?page=login');
                exit();
            }

            $userId = (int) $_SESSION['user_id'];
            $photoId = isset($_POST['photo_id']) ? (int) $_POST['photo_id'] : 0;

            if ($photoId > 0) {
                require_once 'Controllers/FavoriteController.php';
                $favoriteController = new FavoriteController();
                $favoriteController->toggleFavorite($userId, $photoId);
            }

            $redirect = $_POST['redirect'] ?? 'index.php?page=home';
            header("Location: $redirect");
            exit();
        }
        break;


    case 'like_photo':
             require 'controllers/like_photo.php';
            break;
    
    case 'admin_favorite':
         require_once 'controllers/AdminFavorite.php';
         break;


    default:
        http_response_code(404);
        echo "Page introuvable.";
        break;
}
