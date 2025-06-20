function likePhoto(photoId) {
  fetch(`index.php?page=like_photo&id=${photoId}`, { method: 'POST' })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        const likeCountElem = document.getElementById(`like-count-${photoId}`);
        if (likeCountElem) {
          likeCountElem.textContent = data.likes;
        }
      }
    });
}
