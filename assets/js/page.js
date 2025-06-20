const photosPerPage = 4;
let currentPage = 1;

function displayPhotos() {
  const photoContainer = document.getElementById('photo-container');
  photoContainer.innerHTML = ''; // Vide le container

  const start = (currentPage - 1) * photosPerPage;
  const end = start + photosPerPage;
  const paginatedPhotos = photos.slice(start, end);

  paginatedPhotos.forEach(photo => {
    const div = document.createElement('div');
    div.className = 'col-md-3 mb-4';

    div.innerHTML = `
      <div class="card">
        <img src="${photo.path}" class="card-img-top" alt="Photo">
      </div>
    `;
    photoContainer.appendChild(div);
  });

  updatePaginationButtons();
  displayPageNumbers();
}

function updatePaginationButtons() {
  document.getElementById('prevBtn').disabled = currentPage === 1;
  document.getElementById('nextBtn').disabled = currentPage === Math.ceil(photos.length / photosPerPage);
}

function displayPageNumbers() {
  const pageNumbers = document.getElementById('pageNumbers');
  const totalPages = Math.ceil(photos.length / photosPerPage);
  pageNumbers.textContent = `Page ${currentPage} sur ${totalPages}`;
}

document.getElementById('prevBtn').addEventListener('click', () => {
  if (currentPage > 1) {
    currentPage--;
    displayPhotos();
  }
});

document.getElementById('nextBtn').addEventListener('click', () => {
  if (currentPage < Math.ceil(photos.length / photosPerPage)) {
    currentPage++;
    displayPhotos();
  }
});

// Affiche la première page au chargement
displayPhotos();
