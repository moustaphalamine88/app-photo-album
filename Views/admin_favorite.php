<style>
.card {
  max-width: 900px;
  margin: 30px auto;
  padding: 25px;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  background-color: #fff;
  font-family: Arial, sans-serif;
  position: relative;
}

/* Bouton retour */
.btn.retour {
  display: inline-block;
  background-color: #000;
  color: #fff;
  padding: 10px 18px;
  border-radius: 6px;
  text-decoration: none;
  font-weight: bold;
  position: absolute;
  top: 25px;
  left: 25px;
  transition: background-color 0.3s ease;
}

.btn.retour:hover {
  background-color: #333;
}

/* Titre */
.card-title {
  color: #000;
  margin-bottom: 20px;
  font-size: 24px;
  border-bottom: 2px solid #eee;
  padding-bottom: 10px;
  text-align: center;
}

/* Tableau */
.card-table {
  width: 100%;
  border-collapse: collapse;
}

.card-table th,
.card-table td {
  padding: 12px 15px;
  text-align: left;
  border-bottom: 1px solid #ddd;
  vertical-align: middle;
}

.card-table th {
  background-color: #f5f5f5;
  color: #000;
  font-weight: bold;
}

.card-table tr:hover {
  background-color: #f9f9f9;
}

.card-table img {
  border-radius: 4px;
  object-fit: cover;
  max-width: 100%;
  height: auto;
}

/* Responsive */
@media (max-width: 768px) {
  .card {
    padding: 15px;
  }

  .btn.retour {
    position: static;
    margin-bottom: 10px;
    display: block;
    width: fit-content;
  }

  .card-title {
    font-size: 20px;
  }

  .card-table {
    display: block;
    overflow-x: auto;
    white-space: nowrap;
  }

  .card-table th,
  .card-table td {
    font-size: 14px;
    padding: 10px;
  }
}

@media (max-width: 480px) {
  .card-title {
    font-size: 18px;
  }

  .btn.retour {
    padding: 8px 14px;
    font-size: 14px;
  }

  .card-table th,
  .card-table td {
    font-size: 12px;
  }

  .card-table img {
    width: 40px;
  }
}
</style>

<div class="card">
  <a href="index.php?page=admin_album" class="btn retour">Retour</a>
  <h2 class="card-title">Liste des photos favorites</h2>

  <?php if (empty($favorites)): ?>
      <p>Aucun favori trouvé.</p>
  <?php else: ?>
      <table class="card-table">
          <thead>
              <tr>
                  <th>Photo</th>
                  <th>Nom de la photo</th>
                  <th>Album</th>
                  <th>Utilisateur</th>
                  <th>Date du like</th>
              </tr>
          </thead>
          <tbody>
              <?php foreach ($favorites as $fav): ?>
                  <tr>
                      <td><img src="<?= htmlspecialchars($fav['path']) ?>" alt="photo" width="60"></td>
                      <td><?= htmlspecialchars($fav['filename']) ?></td>
                      <td><?= htmlspecialchars($fav['title']) ?></td>
                      <td><?= htmlspecialchars($fav['username']) ?></td>
                      <td><?= htmlspecialchars($fav['liked_at']) ?></td>
                  </tr>
              <?php endforeach; ?>
          </tbody>
      </table>
  <?php endif; ?>
</div>
