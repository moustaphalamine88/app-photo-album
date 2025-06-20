<style>
/* Police générale */
body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  color: #e67e22; /* Texte global orange */
  background-color: #fefefe;
  padding: 2rem;
}

/* Titres */
h2 {
  font-size: 1.8rem;
  color: #e67e22;
  margin-bottom: 1rem;
}

/* Paragraphes */
p {
  color: #e67e22;
  margin-bottom: 1rem;
}

/* Formulaire */
form {
  background-color: #fff;
  border-radius: 12px;
  padding: 2rem;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  max-width: 600px;
  margin-top: 1rem;
}

/* Labels */
label {
  font-weight: 600;
  color: #e67e22; 
  display: block;
  margin-top: 1rem;
  margin-bottom: 0.5rem;
}

/* Champs texte */
input[type="text"],
input[type="file"],
textarea,
select {
  width: 100%;
  padding: 0.6rem 0.8rem;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 1rem;
  box-sizing: border-box;
}

/* Bouton orange */
button.button {
  background-color: #f39c12;
  color: #fff;
  border: none;
  padding: 0.7rem 1.4rem;
  font-size: 1rem;
  font-weight: bold;
  border-radius: 8px;
  cursor: pointer;
  margin-top: 1.5rem;
  transition: background-color 0.3s ease;
  box-shadow: 0 3px 8px rgba(0,0,0,0.15);
}

/* Hover */
button.button:hover {
  background-color: #e67e22;
}

/* Responsive */
@media (max-width: 600px) {
  form {
    padding: 1rem;
  }
}

</style>
<!-- view/create_album.php -->

<h2>Créer un nouvel album</h2>
<p>Veuillez remplir le formulaire ci-dessous pour créer un nouvel album.</p>
<p>Une fois l’album créé, vous pourrez y ajouter des photos.</p>
<form action="index.php?page=save_album" method="POST">
    <label for="cover">Couverture de l’album :</label><br>
    <input type="file" name="cover" accept="image/*" required><br><br>
    <label for="title">Titre de l’album :</label><br>
    <input type="text" name="title" required><br><br>

    <label for="description">Description :</label><br>
    <textarea name="description" rows="4" cols="40"></textarea><br><br>

    <label for="tags">Étiquettes (séparées par des virgules) :</label><br>
    <input type="text" name="tags"><br><br>

    <label for="visibility">Visibilité :</label><br>
    <select name="visibility">
        <option value="private">Privé</option>
        <option value="public">Public</option>
    </select><br><br>

    <button class="button" type="submit">Créer l’album</button>
</form>