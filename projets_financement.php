<?php
session_start();

// Vérifie si le capital risque est authentifié
if (!isset($_SESSION['id_capital_risque'])) {
    // Si non authentifié, redirigez vers la page de connexion
    header('Location: cr.php');
    exit;
}

// Récupère l'ID du capital risque à partir de la session
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

// Traitement de la recherche par mot-clé
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['mot_cle'])) {
    // Récupère le mot-clé de la recherche
    $mot_cle = $_POST['mot_cle'];

    // Requête pour rechercher des projets en fonction du mot-clé dans la description
    $requete_recherche = "SELECT id_projet, titre, description FROM projet WHERE description LIKE '%$mot_cle%'";

    $resultat_recherche = mysqli_query($connexion, $requete_recherche);
} else {
    // Si la clé 'mot_cle' n'est pas définie, afficher tous les projets
    $requete_projets = "SELECT id_projet, titre, description FROM projet";

    $resultat_recherche = mysqli_query($connexion, $requete_projets);
}

// Requête pour récupérer les projets du capital risque avec les détails sur les actions achetées (sans redondance)
$requete_projets = "SELECT
projet.id_projet,
projet.titre,
projet.description,
SUM(capital_risque_projet.nombre_actions_achetees) AS total_actions_achetees,
SUM(capital_risque_projet.nombre_actions_achetees * projet.prix_action) AS investissement_total
FROM
projet
INNER JOIN
capital_risque_projet ON projet.id_projet = capital_risque_projet.id_projet
WHERE
capital_risque_projet.id_capital_risque = $id_capital_risque
GROUP BY
projet.id_projet
";

$resultat_projets = mysqli_query($connexion, $requete_projets);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>echri.net</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="profinancement.css">
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
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="settings-outline"></ion-icon>
                        </span>
                        <span class="title">Settings</span>
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
                        <div class="numbers"><?php
                // Calculer le nombre total de projets financés par le capital risque
                $requete_nombre_projets = "SELECT COUNT(DISTINCT id_projet) AS total_projets FROM capital_risque_projet WHERE id_capital_risque = '$id_capital_risque'";
                $resultat_nombre_projets = mysqli_query($connexion, $requete_nombre_projets);
                $ligne_nombre_projets = mysqli_fetch_assoc($resultat_nombre_projets);
                echo $ligne_nombre_projets['total_projets'];
                ?></div>
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
            $requete_projet_max_actions = "SELECT projet.titre, projet.description, capital_risque_projet.nombre_actions_achetees
                                            FROM projet
                                            INNER JOIN capital_risque_projet ON projet.id_projet = capital_risque_projet.id_projet
                                            WHERE capital_risque_projet.id_capital_risque = $id_capital_risque
                                            ORDER BY capital_risque_projet.nombre_actions_achetees DESC
                                            LIMIT 1";
            $resultat_projet_max_actions = mysqli_query($connexion, $requete_projet_max_actions);
            $ligne_projet_max_actions = mysqli_fetch_assoc($resultat_projet_max_actions);
            echo $ligne_projet_max_actions['nombre_actions_achetees'];
            ?>
                        </div>
                        <div class="cardName">le plus grand nombre d'actions achetées</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="cart-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers"><?php
                // Calculer le nombre total d'actions achetées par le capital risque
                $requete_nombre_actions = "SELECT SUM(nombre_actions_achetees) AS total_actions_achetees FROM capital_risque_projet WHERE id_capital_risque = '$id_capital_risque'";
                $resultat_nombre_actions = mysqli_query($connexion, $requete_nombre_actions);
                $ligne_nombre_actions = mysqli_fetch_assoc($resultat_nombre_actions);
                echo $ligne_nombre_actions['total_actions_achetees'];
                ?></div>
                        <div class="cardName">nombre des actions achetées</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="chatbubbles-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers"><?php
                // Calculer le montant total investi par le capital risque
                $requete_montant_total = "SELECT SUM(nombre_actions_achetees * prix_action) AS montant_total FROM capital_risque_projet INNER JOIN projet ON capital_risque_projet.id_projet = projet.id_projet WHERE id_capital_risque = '$id_capital_risque'";
                $resultat_montant_total = mysqli_query($connexion, $requete_montant_total);
                $ligne_montant_total = mysqli_fetch_assoc($resultat_montant_total);
                echo "$" . $ligne_montant_total['montant_total'];
                ?></div>
                        <div class="cardName">montant total investi</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="cash-outline"></ion-icon>
                    </div>
                </div>
            </div>

            <!-- ================ Order Details List ================= -->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Projets à Financer</h2>
                        <div class="search">
                    <label>
                    <ion-icon name="search-outline"></ion-icon>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="input-group mb-3">
                       <input type="text" class="form-control" placeholder="Entrez un mot-clé de recherche" name="mot_cle">
                       <button class="btn" type="submit">search</button>
                
                     </div>
                     </form>
                    </label>
                </div>
                
                    </div>

                    <table>
                        <thead>
                            <tr>
                            <th>Nom du Projet</th>
                            <th>Description</th>
                            <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                // Vérifie s'il y a des résultats à afficher
                if (mysqli_num_rows($resultat_recherche) > 0) {
                    while ($ligne_projet = mysqli_fetch_assoc($resultat_recherche)) {
                        echo "<tr>";
                        echo "<td>" . $ligne_projet["titre"] . "</td>";
                        echo "<td>" . $ligne_projet["description"] . "</td>";
                        echo "<td>";
                        echo "<form action='edit_projet.php' method='get'>";
                        echo "<input type='hidden' name='id_projet' value='" . $ligne_projet["id_projet"] . "'>";
                        
                        echo "<button class='btn btn-primary' type='submit'><i class='fas fa-shopping-cart purchase-icon'></i></button>";

                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Aucun résultat trouvé.</td></tr>";
                }
                ?>
                           


                        </tbody>
                    </table>
                </div>

                <!-- ================= New Customers ================ -->
                <div class="recentCustomers">
                    <div class="cardHeader">
                        <h2>Vos partenaires</h2>
                    </div>

                    <table>
                    <?php
        // Requête pour récupérer les startupers duquel le capital risque a acheté des actions
        $requete_startupers = "SELECT DISTINCT startuper.nom, startuper.prenom
                               FROM startuper
                               INNER JOIN projet ON startuper.id_startuper = projet.id_startuper
                               INNER JOIN capital_risque_projet ON projet.id_projet = capital_risque_projet.id_projet
                               WHERE capital_risque_projet.id_capital_risque = $id_capital_risque";

        $resultat_startupers = mysqli_query($connexion, $requete_startupers);

        // Vérifie s'il y a des startupers à afficher
        if (mysqli_num_rows($resultat_startupers) > 0) {
            // Affiche les informations des startupers
            while ($row = mysqli_fetch_assoc($resultat_startupers)) {
                echo "<tr>";
                echo "<td width='40px'>";
                echo "</td>";
                echo "<td>";
                echo "<h4>" . $row['nom'] . " " . $row['prenom'] . "<br />";
                echo "<span>Startuper</span>";
                echo "</h4>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            // Aucun startuper trouvé
            echo "<tr><td colspan='2'>Aucun startuper trouvé.</td></tr>";
        }
        ?>
                    </table>
                </div>
            </div>
            <div class="projetspossedes">
            <table class="table">
                <br>
                   <div class="x">
                        <h2>  vos projets</h2>
                    </div>
                    <thead>
                        <tr>
                        <th>ID Projet</th>
                        <th>Titre</th>
                        <th>Description</th>
                        <th>Actions Achetées</th>
                        <th>Investissement Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Vérifie s'il y a des résultats à afficher
                        if (mysqli_num_rows($resultat_projets) > 0) {

                                while ($row = mysqli_fetch_assoc($resultat_projets)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['id_projet'] . "</td>";
                                    echo "<td>" . $row['titre'] . "</td>";
                                    echo "<td>" . $row['description'] . "</td>";
                                    echo "<td>" . $row['total_actions_achetees'] . "</td>";
                                    echo "<td>" . $row['investissement_total'] . "</td>";
                                    echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>Aucun projet trouvé.</td></tr>";
                        }
                        ?>
                    </tbody><br><br>
                </table></div><br><br><br><br>
                
                <!-- End of New Table -->
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="projets.js"></script>

    <!-- ====== ionicons ======= -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>