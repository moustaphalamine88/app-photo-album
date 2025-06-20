<?php
require_once 'models/Photo.php';
require_once 'config/Database.php';

session_start();

$photoId = $_GET['photo_id'] ?? null;
$userId = $_SESSION['user_id'] ?? null;
$albumId = $_GET['album_id'] ?? null;

if ($photoId && $userId && $albumId) {
    $pdo = Database::connect();
    $photoModel = new Photo($pdo);
    $photoModel->likePhoto($photoId, $userId);
    header("Location: index.php?page=view_album&id=$albumId&liked=1");
    exit;
} else {
    // Redirection en cas de problème
    header("Location: index.php?page=view_album&id=$albumId");
    exit;
}
