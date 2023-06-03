const overlay = document.getElementById("overlay");
overlay?.addEventListener("click", () => {
  closeModal();
  closeMergeModal();
  closeGalleryModal();
  closeUploadModal();
});

const currentImageId = 'currentImageId';

function openModal() {
  document.getElementById("create-modal").style.transform =
    "translate(-50%, -50%) scale(1, 1)";
  overlay.classList.add("active");
}


function closeModal() {
  document.getElementById("create-modal").style.transform =
    "translate(-50%, -50%) scale(0, 0)";
  overlay.classList.remove("active");
}

function openDownloadModal() {
  document.getElementById("download-modal").style.transform =
    "translate(-50%, -50%) scale(1, 1)";
  overlay.classList.add("active");
}


function closeDownloadModal() {
  document.getElementById("download-modal").style.transform =
    "translate(-50%, -50%) scale(0, 0)";
  overlay.classList.remove("active");
}


function openBulkUploadModal() {
  document.getElementById("upload-bulk-modal").style.transform =
    "translate(-50%, -50%) scale(1, 1)";
  overlay.classList.add("active");
}


function closeBulkUploadModal() {
  document.getElementById("upload-bulk-modal").style.transform =
    "translate(-50%, -50%) scale(0, 0)";
  overlay.classList.remove("active");
}


function openMergeModal() {
  document.getElementById("merge-modal").style.transform =
    "translate(-50%, -50%) scale(1, 1)";
  overlay.classList.add("active");
}

function closeMergeModal() {
  document.getElementById("merge-modal").style.transform =
    "translate(-50%, -50%) scale(0, 0)";
  overlay.classList.remove("active");
}

function openUploadModal() {
  document.getElementById("upload-modal").style.transform =
    "translate(-50%, -50%) scale(1, 1)";
  overlay.classList.add("active");
}

function closeUploadModal() {
  document.getElementById("upload-modal").style.transform =
    "translate(-50%, -50%) scale(0, 0)";
  overlay.classList.remove("active");
}

function openDeleteModal(id) {
  document.getElementById(`delete-modal-${id}`).style.transform =
    "translate(-50%, -50%) scale(1, 1)";
  overlay.classList.add("active");
  //localStorage.setItem(currentImageId, id);

}

function closeDeleteModal(id) {
  document.getElementById(`delete-modal-${id}`).style.transform =
    "translate(-50%, -50%) scale(0, 0)";
  overlay.classList.remove("active");
  //localStorage.removeItem(currentImageId);
}

function openModifyModal(id) {
  document.getElementById("modify-modal").style.transform =
    "translate(-50%, -50%) scale(1, 1)";
  overlay.classList.add("active");
}

function closeModifyModal() {
  document.getElementById("modify-modal").style.transform =
    "translate(-50%, -50%) scale(0, 0)";
  overlay.classList.remove("active");
}

function openGalleryModal() {
  document.getElementById("gallery-modal").style.transform =
    "translate(-50%, -50%) scale(1, 1)";
  overlay.classList.add("active");
}

function closeGalleryModal() {
  document.getElementById("gallery-modal").style.transform =
    "translate(-50%, -50%) scale(0, 0)";
  overlay.classList.remove("active");
}

var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides((slideIndex += n));
}

function currentSlide(n) {
  showSlides((slideIndex = n));
}

function showSlides(n) {
  var i;
  var slides = document?.getElementsByClassName("slides");
  if (n > slides?.length) {
    slideIndex = 1;
  }
  if (n < 1) {
    slideIndex = slides?.length;
  }


  for (i = 0; i < slides?.length; i++) {
    slides[i].style.display = "none";
  }
  
  if (slides[slideIndex - 1]) {
    slides[slideIndex - 1].style.display = "block";
  }
}