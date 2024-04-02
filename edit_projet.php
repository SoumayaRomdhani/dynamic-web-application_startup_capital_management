<?php
session_start();

// Vérifier si l'utilisateur est authentifié en tant que capital risque
if (!isset($_SESSION['id_capital_risque'])) {
    header('Location: cr.php');
    exit;
}

// Vérifier si l'ID du projet est passé en tant que paramètre GET
if (!isset($_GET['id_projet'])) {
    // Rediriger si l'ID du projet n'est pas fourni
    header('Location: projets_financement.php');
    exit;
}

// Récupérer l'ID du projet depuis le paramètre GET
$id_projet = $_GET['id_projet'];

// Récupérer l'ID du capital risque à partir de la session
$id_capital_risque = $_SESSION['id_capital_risque'];

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

// Récupérer les informations sur le projet à partir de la base de données
$requete_projet = "SELECT * FROM projet WHERE id_projet = $id_projet";
$resultat_projet = mysqli_query($connexion, $requete_projet);

// Vérifier si le projet existe
if (mysqli_num_rows($resultat_projet) == 0) {
    // Rediriger si le projet n'existe pas
    header('Location: projets_financement.php');
    exit;
}

// Récupérer les détails du projet
$projet = mysqli_fetch_assoc($resultat_projet);

// Traitement de l'achat d'actions pour le projet
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'achat') {
    $nombre_actions_acheter = $_POST['nombre_actions_acheter'];

    // Vérifier si le nombre d'actions à acheter est valide
    if ($nombre_actions_acheter > 0 && $nombre_actions_acheter <= $projet['nombre_actions_a_vendre']) {
        // Mettre à jour le nombre d'actions restant à vendre
        $nouveau_nombre_actions_a_vendre = $projet['nombre_actions_a_vendre'] - $nombre_actions_acheter;
        $requete_achat = "UPDATE projet SET nombre_actions_a_vendre = $nouveau_nombre_actions_a_vendre WHERE id_projet = $id_projet";
        $resultat_achat = mysqli_query($connexion, $requete_achat);

        if ($resultat_achat) {
            // Insérer une nouvelle ligne dans la table capital_risque_projets
            $requete_insertion = "INSERT INTO capital_risque_projet (id_projet, id_capital_risque, nombre_actions_achetees) VALUES ('$id_projet', '$id_capital_risque', '$nombre_actions_acheter')";
            $resultat_insertion = mysqli_query($connexion, $requete_insertion);
            
            if ($resultat_insertion) {
                // Achat réussi, rediriger vers la page de projets de financement
                header('Location: projets_financement.php');
                exit;
            } else {
                // Erreur lors de l'insertion dans la table capital_risque_projets, afficher un message d'erreur
                $erreur_achat = "Erreur lors de l'insertion dans la table capital_risque_projets.";
            }
        } else {
            // Erreur lors de l'achat, afficher un message d'erreur
            $erreur_achat = "Erreur lors de l'achat.";
        }
    } else {
        // Le nombre d'actions à acheter est invalide, afficher un message d'erreur
        $erreur_achat = "Le nombre d'actions à acheter est invalide.";
    }
}

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
    <img class="wave" src="ad.jpg" />
    <div class="container">
      <div class="img">
        <img src="moneyy.svg" />
      </div>
      <div class="login-content">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id_projet=' . $id_projet; ?>" method="post">
          <img src="add2.svg" />
          <h2 class="title">acheter des actions d'un projet</h2>
          <h1><?php echo $projet['titre']; ?></h1>
          <div class="card-body">
                <h5 class="card-title"><?php echo $projet['titre']; ?></h5>
                <p class="card-text"><?php echo $projet['description']; ?></p>
                <p class="card-text">Nombre d'actions à vendre : <?php echo $projet['nombre_actions_a_vendre']; ?></p>
                <p class="card-text">Nombre d'actions vendues : <?php echo $projet['nombre_actions_vendus']; ?></p>
                <p class="card-text">Prix de l'action : <?php echo $projet['prix_action']; ?></p>
            </div>

          <div class="input-div pass">
            <div class="i">
              <i class="fas fa-euro-sign"></i>
            </div>
            <div class="div">
              <h5>nombre des actions à acheter</h5>
              <input type="number" class="input" id="nombre_actions_acheter" name="nombre_actions_acheter" required>
            </div>
          </div>

          <div>
            <div>
              <button type="submit" class="btn" name="action" value="achat">Mettre à jour</button>
              
            </div>
            <?php if (isset($erreur_achat)) { ?>
                <div class="alert alert-danger mt-3" role="alert">
                    <?php echo $erreur_achat; ?>
                </div>
            <?php } ?>
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