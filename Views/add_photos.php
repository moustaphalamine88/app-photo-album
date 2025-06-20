<style>
  /* Conteneur centré */
.photo-album-wrapper {
  display: flex;
  justify-content: center;
  padding: 2rem;
  background-color: #fefefe;
}

/* Carte principale */
.photo-album-card {
  background-color: #fff;
  padding: 2.5rem;
  border-radius: 16px;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
  max-width: 900px;
  width: 100%;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Titre */
.photo-album-card h2 {
  text-align: center;
  color: #ff9800;
  margin-top: 0;
  margin-bottom: 2rem;
  font-size: 2rem;
  font-weight: bold;
}

/* Formulaire */
.photo-album-card form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  margin-bottom: 2rem;
}

/* Label */
.photo-album-card label {
  color: #ff9800;
  font-weight: 600;
  font-size: 1rem;
}

/* Input fichier */
.photo-album-card input[type="file"] {
  padding: 0.6rem;
  border-radius: 8px;
  border: 1px solid #ccc;
}

/* Bouton orange */
.photo-album-card button.btn {
  background-color: #ff9800;
  color: #fff;
  font-weight: bold;
  padding: 0.7rem 1.4rem;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  width: fit-content;
}

.photo-album-card button.btn:hover {
  background-color: #e68a00;
}

/* Galerie de photos */
.photo-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
  justify-content: center;
}

/* Carte photo individuelle */
.photo-card {
  background-color: #f9f9f9;
  border: 2px solid #ff9800;
  border-radius: 10px;
  overflow: hidden;
  max-width: 180px;
  flex: 1 1 150px;
  text-align: center;
}

.photo-img {
  width: 100%;
  height: auto;
  display: block;
}

/* Texte vide (aucune photo) */
.photo-album-card p {
  text-align: center;
  color: #ff9800;
  font-weight: 500;
}

</style>
<div class="photo-album-wrapper">
  <div class="photo-album-card">
    
    <!-- Formulaire d'ajout -->
    <form action="index.php?page=upload_photo" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="album_id" value="<?= htmlspecialchars($_GET['album_id'] ?? '') ?>">
        <label for="photo">Ajouter une photo :</label><br>
        <input type="file" name="photo" accept="image/*" required><br>
        <button type="submit" class="btn btn-primary">Ajouter la photo</button>
    </form>

    <h2>Photos de l'album</h2>

    <?php if (!empty($photos)) : ?>
        <div class="photo-grid">
            <?php foreach ($photos as $photo) : ?>
                <div class="photo-card">
                    <img src="<?= htmlspecialchars($photo['path']) ?>" alt="Photo" class="photo-img">
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <p>Aucune photo n'a été ajoutée à cet album.</p>
    <?php endif; ?>

  </div>
</div>
