<?php
// Étape 1: Connexion à la base de données
$serveur = "localhost";
$utilisateur = "root"; 
$mot_de_passe = ""; 
$base_de_donnees = "soumaya"; 

$connexion = mysqli_connect($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

if (!$connexion) {
    die("La connexion a échoué: " . mysqli_connect_error());
}

// Étape 2: Récupérer les données du formulaire
if (isset($_POST['bouton-valider'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $cin = $_POST['cin'];
    $email = $_POST['mail'];
    $nom_entreprise = $_POST['nom_entreprise'];
    $adresse_entreprise = $_POST['adresse_entreprise'];
    $numero_registre_commerce = $_POST['numero_registre_commerce'];
    $pseudo = $_POST['pseudo'];
    $pwrd = $_POST['pwrd'];

    // Insérer l'image dans la base de données
    if(isset($_FILES['f1'])) {
        $image = addslashes(file_get_contents($_FILES['f1']['tmp_name']));
    } else {
        $image = ''; // Si aucune image n'est téléchargée, laisser la colonne photo vide
    }

    // Étape 3: Exécuter la requête SQL pour insérer les données dans la table
    $requete = "INSERT INTO startuper (nom, prenom, CIN, email, nom_entreprise, adresse_entreprise, numero_registre_commerce, photo, pseudo, pwrd) VALUES ('$nom', '$prenom', '$cin', '$email', '$nom_entreprise', '$adresse_entreprise', '$numero_registre_commerce', '$image', '$pseudo', '$pwrd')";

    if (mysqli_query($connexion, $requete)) {
        echo "Nouvelle ligne insérée avec succès.";
    } else {
        echo "Erreur: " . $requete . "<br>" . mysqli_error($connexion);
    }
}

// Fermer la connexion à la base de données
mysqli_close($connexion);
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="style.css" />
    <title>Sign in & Sign up Form</title>
  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form action="authenification.php" method="post" class="sign-in-form">
            <h2 class="title">Sign in</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" id="pseudo" name="pseudo" placeholder="Pseudo" required/>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" id="pwrd" name="pwrd" placeholder="Password" required/>
            </div>
            <input type="submit" value="Login" class="btn solid" />
            <p class="social-text">Or Sign in with social platforms</p>
            <div class="social-media">
              <a href="#" class="social-icon">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-google"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>
          </form>
          <form action="" method= "POST" id="form1" enctype="multipart/form-data" class="sign-up-form">
            <h2 class="title">Sign up</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="nom" id = "nom" placeholder="nom" >
            </div>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="prenom" id="prenom" placeholder="prenom">
            </div>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="text" name="cin" id="cin" placeholder="CIN">
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="email" name="mail" id="mail" placeholder="E-mail">
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="text" name="nom entreprise" id="nom entreprise" placeholder="nom de l'entreprise">
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="text" name="adresse entreprise" id="entrepriseAdresse" placeholder="adresse de l'entreprise">
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="text" name="numero_registre_commerce" id="numero_registre_commerce" placeholder="le numero du registre"> 
            </div>
            
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="text" name="pseudo" id="pseudo" placeholder="Pseudo" />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="pwrd" id="motDePasse" placeholder="Password" />
            </div>
            <div >
              <label>importer une photo</label>
              
              <input type="file" name="f1">
            </div>
            
            <input type="submit" class="btn" name="bouton-valider" value="Sign up" /> 
          </form>
        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>New here ?</h3>
            <p>
              Lorem ipsum, dolor sit amet consectetur adipisicing elit. Debitis,
              ex ratione. Aliquid!
            </p>
            <button class="btn transparent" id="sign-up-btn">Sign up</button>
          </div>
          <img src="signin.svg" class="image" alt="" />
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h3>One of us ?</h3>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum
              laboriosam ad deleniti.
            </p>
            <button class="btn transparent" id="sign-in-btn">Sign in</button>
          </div>
          <img src="signup.svg" class="image" alt="" />
        </div>
      </div>
    </div>
    <!--  les fichiers JavaScript -->
    <script src="app.js"></script>
    <script src="controlsaisi.js"></script>
  </body>
</html>
