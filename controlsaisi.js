document.addEventListener("DOMContentLoaded", function () {
  let formulaire = document.getElementById("form1");
  formulaire.addEventListener("submit", function (e) {
    let name = document.getElementById("nom");
    let prenom = document.getElementById("prenom");
    let mail = document.getElementById("mail");
    let cin = document.getElementById("cin");
    let nomEntreprise = document.getElementById("nom_entreprise");
    let pseudo = document.getElementById("pseudo");
    let motDePasse = document.getElementById("motDePasse");
    let entrepriseAdresse = document.getElementById("entrepriseAdresse");
    let registreCommerce = document.getElementById("numero_registre_commerce");
    let myError = document.getElementById("erreur");
    myError.style.color = "red";

    //les regex des champs du form
    let regExNom = /^[a-zA-Z\s]+$/;
    let regExPrenom = /^[a-zA-Z\s]+$/;
    let regExEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    let regExCIN = /^\d{8}$/;
    let regExRegistreCommerce = /^[A-Z]\d{10}$/;
    let regExPseudo = /^[a-zA-Z0-9]+$/;
    let regExMotDePasse = /^[a-zA-Z0-9]{7,}[#$]$/;
    let regExEntrepriseAdresse = /^[a-zA-Z0-9\s,'-]+$/;

    // réinitialiser l'erreur
    myError.innerHTML = "";

    // Controle du nom
    if (name.value.trim() == "") {
      myError.innerHTML = "Le champ nom est requis";
      e.preventDefault();
    } else if (regExNom.test(name.value) == false) {
      myError.innerHTML =
        "Le champ nom doit être composé de lettres ou d'espaces";
      e.preventDefault();
    }

    // Controle du prenom
    if (prenom.value.trim() == "") {
      myError.innerHTML = "Le champ prénom est requis";
      e.preventDefault();
    } else if (regExPrenom.test(prenom.value) == false) {
      myError.innerHTML =
        "Le champ prénom doit être composé de lettres ou d'espaces";
      e.preventDefault();
    }

    // Controle du numéro de CIN
    if (cin.value.trim() == "") {
      myError.innerHTML = "Le champ CIN est requis";
      e.preventDefault();
    } else if (regExCIN.test(cin.value) == false) {
      myError.innerHTML = "Le numéro de CIN doit être composé de 8 chiffres";
      e.preventDefault();
    }

    // Controle de l'email
    if (mail.value.trim() == "") {
      myError.innerHTML = "Le champ Email est requis";
      e.preventDefault();
    } else if (regExEmail.test(mail.value) == false) {
      myError.innerHTML = "L'adresse email n'est pas valide";
      e.preventDefault();
    }

    // Controle du numéro de registre de commerce
    if (registreCommerce.value.trim() == "") {
      myError.innerHTML = "Le champ Registre de commerce est requis";
      e.preventDefault();
    } else if (regExRegistreCommerce.test(registreCommerce.value) == false) {
      myError.innerHTML =
        "Le numéro de Registre de commerce doit commencer par une lettre majuscule suivie de 10 chiffres";
      e.preventDefault();
    }

    // Controle du nom de l'entreprise
    if (nomEntreprise.value.trim() == "") {
      myError.innerHTML = "Le champ nom de l'entreprise est requis";
      e.preventDefault();
    }

    // Controle du pseudo
    if (pseudo.value.trim() == "") {
      myError.innerHTML = "Le champ Pseudo est requis";
      e.preventDefault();
    } else if (regExPseudo.test(pseudo.value) == false) {
      myError.innerHTML = "Le pseudo doit être composé de lettres ou chiffres";
      e.preventDefault();
    }

    // Controle du mot de passe
    if (motDePasse.value.trim() == "") {
      myError.innerHTML = "Le champ Mot de passe est requis";
      e.preventDefault();
    } else if (regExMotDePasse.test(motDePasse.value) == false) {
      myError.innerHTML =
        "Le mot de passe doit avoir au moins 8 caractères et se terminer par $ ou #";
      e.preventDefault();
    }

    // Controle de l'adresse de l'entreprise
    if (entrepriseAdresse.value.trim() == "") {
      myError.innerHTML = "Le champ Adresse de l'entreprise est requis";
      e.preventDefault();
    } else if (regExEntrepriseAdresse.test(entrepriseAdresse.value) == false) {
      myError.innerHTML = "L'adresse de l'entreprise n'est pas valide";
      e.preventDefault();
    }
  });
});
