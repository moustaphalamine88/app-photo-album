<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Détails de l'album</title>
  <style>
    body {
      background-color: #f8f9fa;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      color: #212529;
      margin: 0;
      padding: 2rem;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      background: #ffffff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    h1 {
      text-align: center;
      font-size: 2rem;
      margin-bottom: 2rem;
    }

    h2 {
      font-size: 1.5rem;
      margin-bottom: 1rem;
      color: #000;
    }

    h5 {
      font-size: 1rem;
      margin-bottom: 2rem;
      color: #555;
    }

    p {
      font-size: 1.1rem;
      color: #333;
      margin-bottom: 2rem;
    }

    ul {
      padding-left: 1.2rem;
      margin-bottom: 2rem;
    }

    li {
      background-color: #f1f1f1;
      padding: 0.5rem 1rem;
      border-radius: 5px;
      margin-bottom: 0.5rem;
    }

    a.back-button {
      display: inline-block;
      background-color: #000;
      color: #fff;
      padding: 0.7rem 1.4rem;
      border-radius: 5px;
      text-decoration: none;
      font-weight: bold;
      transition: background 0.3s ease;
    }

    a.back-button:hover {
      background-color: #333;
    }

    
  </style>
</head>
<body>

<div class="container">
  <h1>Détails de l'album</h1>

  <h2><?= htmlspecialchars($album['title']); ?></h2>
  <p><?= htmlspecialchars($album['description']); ?></p>

  <h5>Propriétaire : <?= htmlspecialchars($album['title']); ?></h5>

  <h3>Photos</h3>
<ul>
  <?php foreach ($photos as $photo): ?>
    <li>
      <img src="<?= htmlspecialchars($photo['path']) ?>" alt="<?= htmlspecialchars($photo['filename']) ?>" style="max-width: 150px; display: block; margin-bottom: 0.5rem;">
      <strong><?= htmlspecialchars($photo['filename']); ?></strong>

      <!-- Affichage des commentaires -->
      <div class="comments-section">
        <h4>Commentaires :</h4>
        <?php if (!empty($comments[$photo['id']])): ?>
          <ul>
            <?php foreach ($comments[$photo['id']] as $comment): ?>
              <li>
                <strong><?= htmlspecialchars($comment['username'] ?? 'Utilisateur'); ?>:</strong>
                <?= htmlspecialchars($comment['content']); ?>
                <em>(<?= htmlspecialchars($comment['created_at']); ?>)</em>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php else: ?>
          <p>Aucun commentaire pour cette photo.</p>
        <?php endif; ?>
      </div>
    </li>
  <?php endforeach; ?>
</ul>


  <a href="index.php?page=admin_album" class="back-button">Retour</a>>
</div>

</body>
</html>
