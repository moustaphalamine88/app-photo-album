<?php
header('Content-Type: application/json; charset=utf-8');

// Ici, tu traites le like en base (à faire)

// Puis récupère le nouveau nombre de likes pour la photo
// Exemple (à adapter) :
$newLikeCount = 13; // tu récupères ce nombre depuis ta base

$response = [
    'success' => true,
    'message' => 'Photo likée !',
    'likeCount' => $newLikeCount
];

echo json_encode($response, JSON_UNESCAPED_UNICODE);
exit;

?>
