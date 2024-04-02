

<?php
session_start();

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

// Vérification si le formulaire de connexion est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pseudo = $_POST["pseudo"];
    $pwrd = $_POST["pwrd"];

    // Requête pour vérifier les informations de connexion
    $requete = "SELECT id_startuper FROM startuper WHERE pseudo = '$pseudo' AND pwrd = '$pwrd'";
    $resultat = mysqli_query($connexion, $requete);

    if (mysqli_num_rows($resultat) == 1) {
        // Utilisateur authentifié
        $ligne = mysqli_fetch_assoc($resultat);
        $id_startuper = $ligne["id_startuper"];

        // Stocke l'ID du startuper dans une variable de session
        $_SESSION['id_startuper'] = $id_startuper;

        // Redirection vers la page des projets
        header('Location: projets.php');
        exit;
    } else {
        // Informations de connexion incorrectes
        header('Location: pr.php?erreur=1');
        exit;
    }
} else {
    // Redirigez vers la page de connexion si les données de formulaire ne sont pas soumises
    header('Location: pr.php');
    exit;
}
?>
