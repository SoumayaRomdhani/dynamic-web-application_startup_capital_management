<?php
session_start();

// Récupère l'ID du startuper à partir de la session
$id_startuper = $_SESSION['id_startuper'];

// Vérifie si l'ID du projet est passé en paramètre
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Redirigez vers la page des projets si l'ID du projet n'est pas spécifié
    header('Location: projets.php');
    exit;
}

// Récupère l'ID du projet depuis les paramètres de l'URL
$id_projet = $_GET['id'];

// Connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$motdepasse = "";
$base_de_donnees = "soumaya";

$connexion = mysqli_connect($serveur, $utilisateur, $motdepasse, $base_de_donnees);

// Vérification de la connexion
if (!$connexion) {
    die("La connexion à la base de données a échoué: " . mysqli_connect_error());
}

// Requête pour récupérer les informations du projet
$requete_projet = "SELECT * FROM projet WHERE id_projet = '$id_projet' AND id_startuper = '$id_startuper'";
$resultat_projet = mysqli_query($connexion, $requete_projet);

// Vérifie si le projet appartient bien à l'utilisateur actuel
if (mysqli_num_rows($resultat_projet) != 1) {
    // Redirigez vers la page des projets si le projet n'appartient pas à l'utilisateur
    header('Location: projets.php');
    exit;
}

// Traitez les données du formulaire si elles sont soumises
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérez les données du formulaire
    $description = $_POST['description'];
    $nombre_actions_a_vendre = $_POST['nombre_actions_a_vendre'];
    $nombre_actions_vendus = $_POST['nombre_actions_vendus'];
    $prix_action = $_POST['prix_action'];

    // Requête pour mettre à jour le projet dans la base de données
    $requete_mise_a_jour = "UPDATE projet SET description = '$description', nombre_actions_a_vendre = '$nombre_actions_a_vendre', nombre_actions_vendus = '$nombre_actions_vendus', prix_action = '$prix_action' WHERE id_projet = '$id_projet' AND id_startuper = '$id_startuper'";

    if (mysqli_query($connexion, $requete_mise_a_jour)) {
        // Projet mis à jour avec succès
        header('Location: projets.php');
        exit;
    } else {
        // Erreur lors de la mise à jour du projet
        echo "Erreur lors de la mise à jour du projet: " . mysqli_error($connexion);
    }

    mysqli_close($connexion);
}

// Récupère les informations du projet
$ligne_projet = mysqli_fetch_assoc($resultat_projet);

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Animated Login Form</title>
    <link rel="stylesheet" type="text/css" href="create.css" />
    <link
      href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap"
      rel="stylesheet"
    />
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
  </head>
  <body>
  <style>
      /* Styles pour les petites étiquettes */
      .label {
        font-size: 13px;
        color: black;
        margin-bottom: 5px;
        
      }
    </style>
    <img class="wave" src="ad.jpg" />
    <div class="container">
      <div class="img">
        <img src="add.svg" />
      </div>
      <div class="login-content">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id_projet; ?>" method="post">
          <img src="add2.svg" />
          <h2 class="title">Editer un projet</h2>
          <label class="label" for="description">Description :</label>
          <div class="input-div one">
            <div class="i">
              <i class="fas fa-user"></i>
            </div>
            <div class="div">
              
    
              <input type="text" class="input" id="description" name="description" value="<?php echo $ligne_projet['description']; ?>" required>
            </div>
          </div>
          <label class="label" for="description">le nombre d'actions à vendre :</label>
          <div class="input-div pass">
            <div class="i">
              <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="div">
              
              <input type="number" class="input" id="nombre_actions_a_vendre" name="nombre_actions_a_vendre" value="<?php echo $ligne_projet['nombre_actions_a_vendre']; ?>" required>
            </div>
          </div>
          <label class="label" for="description">le nombre d'actions vendues :</label>
          <div class="input-div pass">
            <div class="i">
              <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="div">
              
              <input type="number" class="input" id="nombre_actions_vendus" name="nombre_actions_vendus" value="<?php echo $ligne_projet['nombre_actions_vendus']; ?>" required>
            </div>
          </div>
          <label class="label" for="description">le prix unitaire d'une action:</label>
          <div class="input-div pass">
            <div class="i">
              <i class="fas fa-euro-sign"></i>
            </div>
            <div class="div">
              
              <input type="number" class="input" id="prix_action"  value="<?php echo $ligne_projet['prix_action']; ?>" required>
            </div>
          </div>

          <div>
            <div>
              <button type="submit" class="btn">Mettre à jour</button>
            </div>
            
          </div>
        </form>
      </div>
    </div>
    <script type="text/javascript" src="add.js"></script>
    <!---------Footer section-------->
    <footer class="footer">
      <div class="container footer__container">
        <div class="footer__1">
          <a href="index.html" class="footer__logo"><h4>SOUMAYA</h4></a>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing</p>
        </div>
        <div class="footer__2">
          <h4>Permalinks</h4>
          <ul class="permalinks">
            <li><a href="index.html">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="courses.html">Courses</a></li>
            <li><a href="cantact.html">Cantact</a></li>
          </ul>
        </div>

        <div class="footer__3">
          <h4>Primacy</h4>
          <ul class="privacy">
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Terms and conditions</a></li>
            <li><a href="#">Refund Policy</a></li>
          </ul>
        </div>

        <div class="footer__4">
          <h4>Cantact Us</h4>
          <div>
            <p>+216 92 070 125</p>
            <p>soumayaromdhani2003@gmail.com</p>
            <ul class="footer__socials">
              <li>
                <a href="">
                  <svg
                    aria-hidden="true"
                    focusable="false"
                    data-prefix="fab"
                    data-icon="facebook"
                    class="svg-inline--fa fa-facebook fa-w-16"
                    role="img"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 512 512"
                  >
                    <path
                      fill="currentColor"
                      d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z"
                    ></path>
                  </svg>
                  Facebook</a
                >
              </li>
              <li>
                <a href="">
                  <svg
                    aria-hidden="true"
                    focusable="false"
                    data-prefix="fab"
                    data-icon="instagram"
                    class="svg-inline--fa fa-instagram fa-w-14"
                    role="img"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 448 512"
                  >
                    <path
                      fill="currentColor"
                      d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"
                    ></path>
                  </svg>
                  Instagram</a
                >
              </li>
              <li>
                <a href="">
                  <svg
                    aria-hidden="true"
                    focusable="false"
                    data-prefix="fab"
                    data-icon="twitter"
                    class="svg-inline--fa fa-twitter fa-w-16"
                    role="img"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 512 512"
                  >
                    <path
                      fill="currentColor"
                      d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"
                    ></path>
                  </svg>
                  Twitter</a
                >
              </li>
            </ul>
          </div>

          <div class="footer__copyright">
            <h4>Copyright &copy; SOUMAYA</h4>
          </div>
        </div>
      </div>
    </footer>
  </body>
</html>
