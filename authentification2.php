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
    $requete = "SELECT id_capital_risque FROM capital_risque WHERE pseudo = '$pseudo' AND pwrd = '$pwrd'";
    $resultat = mysqli_query($connexion, $requete);

    if (mysqli_num_rows($resultat) == 1) {
        // Utilisateur authentifié
        $ligne = mysqli_fetch_assoc($resultat);
        $id_capital_risque = $ligne["id_capital_risque"];

        // Stocke l'ID du capital risque dans une variable de session
        $_SESSION['id_capital_risque'] = $id_capital_risque;

        // Redirection vers la page des projets de financement
        header('Location: projets_financement.php');
        exit;
    } else {
        // Informations de connexion incorrectes
        header('Location: cr.php?erreur=1');
        exit;
    }
} else {
    // Redirigez vers la page de connexion si les données de formulaire ne sont pas soumises
    header('Location: cr.php');
    exit;
}
?>