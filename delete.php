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

// Vérifier si des actions ont été vendues pour ce projet
$requete_verifier_actions_vendues = "SELECT nombre_actions_vendus FROM projet WHERE id_projet = '$id_projet'";
$resultat_verifier_actions_vendues = mysqli_query($connexion, $requete_verifier_actions_vendues);
$ligne_actions_vendues = mysqli_fetch_assoc($resultat_verifier_actions_vendues);
$nombre_actions_vendus = $ligne_actions_vendues['nombre_actions_vendus'];

if ($nombre_actions_vendus == 0) {
    // Aucune action n'a été vendue, donc le startuper peut supprimer le projet

    // Requête pour supprimer le projet de la base de données
    $requete_suppression = "DELETE FROM projet WHERE id_projet = '$id_projet' AND id_startuper = '$id_startuper'";

    if (mysqli_query($connexion, $requete_suppression)) {
        // Projet supprimé avec succès
        header('Location: projets.php');
        exit;
    } else {
        // Erreur lors de la suppression du projet
        echo "Erreur lors de la suppression du projet: " . mysqli_error($connexion);
    }
} else {
    // Des actions ont été vendues pour ce projet, donc le startuper ne peut pas le supprimer
    echo "Vous ne pouvez pas supprimer ce projet car des actions ont déjà été vendues.";
}

mysqli_close($connexion);
?>
