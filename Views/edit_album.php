<style>
/* Conteneur centré */
.form-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  padding: 2rem;
  background-color: #fff;
}

/* Card stylée */
.album-card {
  background-color: #fff;
  padding: 2rem 2.5rem;
  border-radius: 12px;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
  max-width: 600px;
  width: 100%;
}

/* Style général pour tout le texte en dehors des boutons */
body, h1, h2, h3, h4, h5, h6, p, label, span, a {
  color: #ff9800;
}

/* Boutons orange */
button,
input[type="submit"],
input[type="button"],
.btn,
.btn-primary,
.btn-warning,
.btn-danger,
.btn-outline-primary {
  background-color: #ff9800 !important;
  color: white !important;
  border: none;
  font-weight: bold;
  padding: 10px 20px;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

/* Hover */
button:hover {
  background-color: darkorange !important;
}

/* Liens dans boutons */
button a,
.btn a {
  color: white !important;
  text-decoration: none;
}

/* Champs du formulaire */
form label,
form input,
form textarea,
form select,
form option {
  color: orange;
  display: block;
  width: 100%;
  margin-top: 1rem;
}

form input,
form textarea,
form select {
  border: 1px solid orange;
  border-radius: 8px;
  padding: 0.6rem 0.8rem;
  font-size: 1rem;
  background-color: white;
  box-sizing: border-box;
}

form textarea {
  resize: vertical;
}

/* Titre */
.album-card h2 {
  text-align: center;
  color: #ff9800;
  margin-bottom: 1.5rem;
}
</style>

<!-- HTML Formulaire -->
<div class="form-wrapper">
  <div class="album-card">
    <h2>Modifier l'album</h2>
    <form method="POST" action="index.php?page=update_album">
      <input type="hidden" name="album_id" value="<?= $album['id'] ?>">

      <label for="title">Titre :</label>
      <input type="text" name="title" id="title" value="<?= htmlspecialchars($album['title']) ?>" required>

      <label for="description">Description :</label>
      <textarea name="description" id="description"><?= htmlspecialchars($album['description']) ?></textarea>

      <label for="tags">Tags :</label>
      <input type="text" name="tags" id="tags" value="<?= htmlspecialchars($album['tags']) ?>">

      <label for="visibility">Visibilité :</label>
      <select name="visibility" id="visibility">
        <option value="public" <?= $album['visibility'] == 'public' ? 'selected' : '' ?>>Public</option>
        <option value="private" <?= $album['visibility'] == 'private' ? 'selected' : '' ?>>Privé</option>
      </select>

      <div style="text-align:center; margin-top: 2rem;">
        <button type="submit">Mettre à jour</button>
      </div>
    </form>
  </div>
</div>
