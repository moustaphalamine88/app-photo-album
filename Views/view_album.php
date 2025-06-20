<link rel="stylesheet" href="assets/css/view_album.css">

<div class="album-container">
  <h2>Album : <?= htmlspecialchars($album['title']) ?></h2>
  <p>Créé le : <?= htmlspecialchars($album['created_at']) ?></p>

  <div class="album-photos">
    <?php if (!empty($photos)): ?>
      <?php foreach ($photos as $photo): ?>
        <div class="photo-card">
          <img src="<?= $photo['path'] ?>" alt="<?= htmlspecialchars($photo['filename']) ?>">
          <p><?= htmlspecialchars($photo['filename']) ?></p>

          <!-- Bouton "Ajouter aux favoris" -->
          <?php if ($_SESSION['user']['role'] !== 'admin'): ?>
        <a href="index.php?page=view_album&photo_id=<?= $photo['id'] ?>&album_id=<?= $album['id'] ?>" class="like-button">
  <img src="assets/image/like.png" alt="Favori" style="width: 20px; height: 20px;">
</a>




          <?php endif; ?>

          <!-- Commentaires -->
          <div class="photo-comments">
            <h4>Commentaires :</h4>

            <?php if (!empty($comments[$photo['id']])): ?>
              <ul class="comment-list">
                <?php foreach ($comments[$photo['id']] as $comment): ?>
                  <li class="comment-item">
                    <strong><?= htmlspecialchars($comment['username'] ?? 'Utilisateur') ?>:</strong>
                    <?= htmlspecialchars($comment['content']) ?>
                    <em>(<?= htmlspecialchars($comment['created_at']) ?>)</em>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php else: ?>
              <p class="no-comment">Aucun commentaire pour cette photo.</p>
            <?php endif; ?>

            <!-- Formulaire de commentaire -->
            <div class="add-comment-form">
              <form method="POST" action="index.php?page=add_comment">
                <input type="hidden" name="photo_id" value="<?= $photo['id'] ?>">
                <input type="hidden" name="album_id" value="<?= $album['id'] ?>">
                <textarea name="content" placeholder="Écrire un commentaire..." required></textarea>
                <button class="btn" type="submit">Publier</button>
              </form>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Aucune photo dans cet album.</p>
    <?php endif; ?>
  </div>
</div>
<?php if (isset($_GET['liked']) && $_GET['liked'] == 1): ?>
  <div id="toast" class="toast">👍 Photo ajoutée aux favoris !</div>
  <script>
    const toast = document.getElementById('toast');
    toast.style.display = 'block';

    setTimeout(() => {
      toast.style.opacity = '0';
      setTimeout(() => toast.style.display = 'none', 500);
    }, 3000);
  </script>
<?php endif; ?>
<style>
  .toast {
  position: fixed;
  bottom: 20px;
  right: 20px;
  background-color: #e67e22;
  color: white;
  padding: 1rem 1.5rem;
  border-radius: 8px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  font-size: 1rem;
  display: none;
  opacity: 1;
  transition: opacity 0.5s ease;
  z-index: 1000;
}

</style>
