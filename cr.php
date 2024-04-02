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
    $email = $_POST['mail'];
    $cin = $_POST['cin'];
    $pseudo = $_POST['pseudo'];
    $pwrd = $_POST['pwrd'];

    

    // Étape 4: Exécuter la requête SQL pour insérer les données dans la table
    $requete = "INSERT INTO capital_risque (nom, prenom, email, CIN, pseudo, pwrd) VALUES ('$nom', '$cin', '$prenom', '$email', '$pseudo', '$pwrd')";

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
          <form action="authentification2.php" method="post" class="sign-in-form">
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
              <input type="text" name="nom" id = "nom" placeholder="nom" />
            </div>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="text" name="prenom" id="prenom" placeholder="prenom"/>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="email" name="mail" id="mail" placeholder="E-mail"/>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="text" name="cin" id="cin" placeholder="CIN" />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="text" name="pseudo" id="pseudo" placeholder="Pseudo" />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="text" name="pwrd" id="motDePasse"placeholder="Password" />
            </div>
           

            <input type="submit" class="btn" name="bouton-valider" value="Sign up" />
            <p class="social-text">Or Sign up with social platforms</p>
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

    <script src="app.js"></script>
  </body>
</html>
