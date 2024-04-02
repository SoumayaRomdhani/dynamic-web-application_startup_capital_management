<?php
session_start();

// Vérifie si l'utilisateur est authentifié
if (!isset($_SESSION['id_startuper'])) {
    // Si non authentifié, redirigez vers la page de connexion
    header('Location: pr.php');
    exit;
}

// Récupère l'ID du startuper à partir de la session
$id_startuper = $_SESSION['id_startuper'];

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

// Requête pour récupérer les projets associés à ce startuper
$requete_projets = "SELECT * FROM projet WHERE id_startuper = '$id_startuper'";
$resultat_projets = mysqli_query($connexion, $requete_projets);

// Requête pour récupérer les noms et prénoms des capitaux risque qui ont acheté des actions des projets possédés par le startuper
// Requête pour récupérer les noms et prénoms des capitaux risque qui ont acheté des actions des projets possédés par le startuper
$requete_capitaux_risque = "SELECT DISTINCT cr.nom, cr.prenom, p.titre AS nom_projet 
                            FROM capital_risque AS cr
                            INNER JOIN capital_risque_projet AS crp ON cr.id_capital_risque = crp.id_capital_risque
                            INNER JOIN projet AS p ON crp.id_projet = p.id_projet
                            WHERE p.id_startuper = '$id_startuper'";

$resultat_capitaux_risque = mysqli_query($connexion, $requete_capitaux_risque);



?>






<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Responsive Admin Dashboard | Korsat X Parmaga</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="projets.css" />
  </head>

  <body>
    <!-- =============== Navigation ================ -->
    <div class="container">
      <div class="navigation">
        <ul>
          <li>
            <a href="#">
              <span class="icon">
                <ion-icon name="logo-apple"></ion-icon>
              </span>
              <span class="title">Brand Name</span>
            </a>
          </li>

          <li>
            <a href="#">
              <span class="icon">
                <ion-icon name="home-outline"></ion-icon>
              </span>
              <span class="title">Dashboard</span>
            </a>
          </li>

          <li>
            <a href="#">
              <span class="icon">
                <ion-icon name="people-outline"></ion-icon>
              </span>
              <span class="title">Customers</span>
            </a>
          </li>

          <li>
            <a href="#">
              <span class="icon">
                <ion-icon name="chatbubble-outline"></ion-icon>
              </span>
              <span class="title">Messages</span>
            </a>
          </li>

          <li>
            <a href="#">
              <span class="icon">
                <ion-icon name="help-outline"></ion-icon>
              </span>
              <span class="title">Help</span>
            </a>
          </li>

          <li>
            <a href="edit_profil_statuper.php">
              <span class="icon">
                <ion-icon name="settings-outline"></ion-icon>
              </span>
              <span class="title">Edit profil</span>
            </a>
          </li>

          <li>
            <a href="#">
              <span class="icon">
                <ion-icon name="lock-closed-outline"></ion-icon>
              </span>
              <span class="title">Password</span>
            </a>
          </li>

          <li>
            <a href="welcome_page.php">
              <span class="icon">
                <ion-icon name="log-out-outline"></ion-icon>
              </span>
              <span class="title">Sign Out</span>
            </a>
          </li>
        </ul>
      </div>

      <!-- ========================= Main ==================== -->
      <div class="main">
        <div class="topbar">
          <div class="toggle">
            <ion-icon name="menu-outline"></ion-icon>
          </div>
        </div>

        <!-- ======================= Cards ================== -->
        <div class="cardBox">
          <div class="card">
            <div>
              <div class="numbers">
              <?php
        // Compter le nombre total de projets
        $requete_nombre_projets = "SELECT COUNT(*) AS total_projets FROM projet WHERE id_startuper = '$id_startuper'";
        $resultat_nombre_projets = mysqli_query($connexion, $requete_nombre_projets);
        $ligne_nombre_projets = mysqli_fetch_assoc($resultat_nombre_projets);
        echo $ligne_nombre_projets['total_projets'];
        ?>
              </div>

              <div class="cardName">nombre de projets</div>
            </div>

            <div class="iconBx">
              <ion-icon name="eye-outline"></ion-icon>
            </div>
          </div>

          <div class="card">
            <div>
              <div class="numbers">
              <?php
            // Calculer le nombre total de capitaux risque qui ont acheté des actions des projets du startuper
            $requete_nombre_capitaux_risque = "SELECT COUNT(DISTINCT cr.id_capital_risque) AS total_capitaux_risque 
                                              FROM capital_risque AS cr
                                              INNER JOIN capital_risque_projet AS crp ON cr.id_capital_risque = crp.id_capital_risque
                                              INNER JOIN projet AS p ON crp.id_projet = p.id_projet
                                              WHERE p.id_startuper = '$id_startuper'";
            $resultat_nombre_capitaux_risque = mysqli_query($connexion, $requete_nombre_capitaux_risque);
            $ligne_nombre_capitaux_risque = mysqli_fetch_assoc($resultat_nombre_capitaux_risque);
            echo $ligne_nombre_capitaux_risque['total_capitaux_risque'];
            ?>
              </div>
              <div class="cardName">nombre des actionneurs</div>
            </div>

            <div class="iconBx">
              <ion-icon name="cart-outline"></ion-icon>
            </div>
          </div>

          <div class="card">
            <div>
              <div class="numbers"><?php
        // Calculer le nombre total d'actions à vendre
        $requete_actions_a_vendre = "SELECT SUM(nombre_actions_a_vendre) AS total_actions_a_vendre FROM projet WHERE id_startuper = '$id_startuper'";
        $resultat_actions_a_vendre = mysqli_query($connexion, $requete_actions_a_vendre);
        $ligne_actions_a_vendre = mysqli_fetch_assoc($resultat_actions_a_vendre);
        echo $ligne_actions_a_vendre['total_actions_a_vendre'];
        ?></div>
              <div class="cardName">actions à vendre </div>
            </div>

            <div class="iconBx">
              <ion-icon name="chatbubbles-outline"></ion-icon>
            </div>
          </div>

          <div class="card">
            <div>
              <div class="numbers">
              <?php
        // Calculer le nombre total d'actions vendues
        $requete_actions_vendues = "SELECT SUM(nombre_actions_vendus) AS total_actions_vendues FROM projet WHERE id_startuper = '$id_startuper'";
        $resultat_actions_vendues = mysqli_query($connexion, $requete_actions_vendues);
        $ligne_actions_vendues = mysqli_fetch_assoc($resultat_actions_vendues);
        echo $ligne_actions_vendues['total_actions_vendues'];
        ?>
              </div>
              <div class="cardName">action vendues</div>
            </div>

            <div class="iconBx">
              <ion-icon name="cash-outline"></ion-icon>
            </div>
          </div>
        </div>

        <!-- ================ projects Details List ================= -->
        <div class="details">
          <div class="recentOrders">
            <div class="cardHeader">
              <h2>liste de vos projets</h2>
              <a href="create.php" class="btn">
        <span class="icon"><i class="fas fa-plus"></i></span> <!-- Icône d'ajout -->
        ajouter
    </a>
    
            </div>

            <table>
              <thead>
                <tr>
                <tr>
                <th>Nom projet</th>
                <th>Description</th>
                <th>Nombre d'actions à vendre</th>
                <th>Nombre d'actions vendues</th>
                <th>Prix de l'action</th>
                <th>actions</th>
            </tr>
                </tr>
              </thead>

              <tbody>
              <?php
              while ($ligne_projet = mysqli_fetch_assoc($resultat_projets)) {
              echo "
            <tr>
            <td>$ligne_projet[titre]</td>
            <td>$ligne_projet[description]</td>
            <td>$ligne_projet[nombre_actions_a_vendre]</td>
            <td>$ligne_projet[nombre_actions_vendus]</td>
            <td>$ligne_projet[prix_action]</td>
            <td><a class=\"btn btn-primary btn-sm edit-btn\" href='/test/edit.php?id=$ligne_projet[id_projet]'><i class=\"fas fa-edit\"></i></a></td>
            <td><a class=\"btn btn-danger btn-sm delete-btn\" href='/test/delete.php?id=$ligne_projet[id_projet]'><i class=\"fas fa-trash-alt\"></i></a></td>
             </tr>";
    }
    ?>
</tbody>

            </table>
          </div>

          <!-- ================= New Customers ================ -->
          <div class="recentCustomers">
            <div class="cardHeader">
              <h2>Recent Customers</h2>
            </div>

            <table>
<?php
        // Vérifie s'il y a des capitaux risque à afficher
        if (mysqli_num_rows($resultat_capitaux_risque) > 0) {
          // Affiche les informations des capitaux risque
          while ($row = mysqli_fetch_assoc($resultat_capitaux_risque)) {
              echo "<tr>";
              echo "<td width='40px'>";
             
              echo "<img src='assets/imgs/customer02.jpg' alt='' />";
              echo "</div>";
              echo "</td>";
              echo "<td>";
              echo "<h4>" . $row['nom'] . " " . $row['prenom'] . "<br />";
              echo "<span>a acheté des actions du projet: " . $row['nom_projet'] . "</span>";
              echo "</h4>";
              echo "</td>";
              echo "</tr>";
          }
        } else {
            // Aucun capital risque trouvé
            echo "<tr><td colspan='2'>Aucun capital risque trouvé.</td></tr>";
        }
        ?>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="projets.js"></script>

    <!-- ====== ionicons ======= -->
    <script
      type="module"
      src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"
    ></script>
    <script
      nomodule
      src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"
    ></script>
  </body>
</html>
