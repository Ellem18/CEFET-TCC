const btn = document.getElementById("btn");
const modal = document.getElementById("modal");

btn.addEventListener('onclick', 'openModal()');

function openModal() {
    modal.style.opacity = 100;
}

function closeModal() {
    modal.style.opacity = 0;
}