const imgAjoutClient = document.getElementById("ajoutClient");
const formAjoutClient = document.getElementById("formAjoutClient");

function chargerEvenements() {
    imgAjoutClient.addEventListener("click", afficherForm)
}

function afficherForm() {
    if (formAjoutClient.style.display == "none") {
        formAjoutClient.style.display = "block";
    } else {
        formAjoutClient.style.display = "none";
    }
}

chargerEvenements();