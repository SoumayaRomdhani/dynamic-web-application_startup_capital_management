<?php
session_start();

// Vérifie si le startuper est authentifié
if (!isset($_SESSION['id_startuper'])) {
    
}

// Récupère l'ID du startuper à partir de la session
$id_startuper = $_SESSION['id_startuper'];

// Connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$motdepasse = "";
$base_de_donnees = "soumaya";

$connexion = new mysqli($serveur, $utilisateur, $motdepasse, $base_de_donnees);

// Vérification de la connexion
if ($connexion->connect_error) {
    die("La connexion à la base de données a échoué: " . $connexion->connect_error);
}

// Récupération des coordonnées actuelles du startuper
$requete_startuper = "SELECT * FROM startuper WHERE id_startuper = $id_startuper";
$resultat_startuper = $connexion->query($requete_startuper);
$row = $resultat_startuper->fetch_assoc();
$nom = $row['nom'];
$prenom = $row['prenom'];
$email = $row['email'];
$CIN = $row['CIN'];
$nom_entreprise = $row['nom_entreprise'];
$adresse_entreprise = $row['adresse_entreprise'];
$numero_registre_commerce = $row['numero_registre_commerce'];
$pseudo = $row['pseudo'];
$pwrd = $row['pwrd'];
$photo = $row['photo'];

// Traitement de la mise à jour des coordonnées et de la photo de profil
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Récupération des nouvelles coordonnées du startuper
    $nouveau_nom = $_POST['nom'];
    $nouveau_prenom = $_POST['prenom'];
    $nouvelle_email = $_POST['email'];
    $nouveau_CIN = $_POST['CIN'];
    $nouveau_nom_entreprise = $_POST['nom_entreprise'];
    $nouvelle_adresse_entreprise = $_POST['adresse_entreprise'];
    $nouveau_numero_registre_commerce = $_POST['numero_registre_commerce'];
    $nouveau_pseudo = $_POST['pseudo'];
    $nouveau_pwrd = $_POST['pwrd'];
    
    // Vérification si une nouvelle photo a été envoyée
    if ($_FILES['photo']['size'] > 0) {
        $nouvelle_photo = addslashes(file_get_contents($_FILES['photo']['tmp_name']));
        // Mise à jour de la photo de profil dans la base de données
        $requete_photo = "UPDATE startuper SET photo = '$nouvelle_photo' WHERE id_startuper = $id_startuper";
        $resultat_photo = $connexion->query($requete_photo);
        if (!$resultat_photo) {
            echo "Erreur lors de la mise à jour de la photo de profil: " . $connexion->error;
        }
    }

    // Mise à jour des coordonnées du startuper dans la base de données
    $requete_update = "UPDATE startuper SET nom = '$nouveau_nom', prenom = '$nouveau_prenom', email = '$nouvelle_email', CIN = '$nouveau_CIN', nom_entreprise = '$nouveau_nom_entreprise', adresse_entreprise = '$nouvelle_adresse_entreprise', numero_registre_commerce = '$nouveau_numero_registre_commerce', pseudo = '$nouveau_pseudo', pwrd = '$nouveau_pwrd' WHERE id_startuper = $id_startuper";
    $resultat_update = $connexion->query($requete_update);
    if (!$resultat_update) {
        echo "Erreur lors de la mise à jour des coordonnées: " . $connexion->error;
    } else {
        // Redirection vers la page de profil après la mise à jour des coordonnées
        header("Location: edit_profil_statuper.php");

    }
}

$connexion->close();
?>

<!DOCTYPE html>
<link rel="stylesheet" href="profil_startuper.css">
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Profil Startuper</title>
</head>

<body>
    <div class="container">
        <h2>Modifier votre profil</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <img src="data:image/jpeg;base64,<?php echo base64_encode($photo); ?>" height="300" width="300">
            <br>
            <input type="file" id="photo" name="photo"><br><br>

            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" value="<?php echo $nom; ?>"><br><br>
            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" value="<?php echo $prenom; ?>"><br><br>
            <label for="email">Adresse E-mail:</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>"><br><br>
            <label for="CIN">CIN:</label>
            <input type="text" id="CIN" name="CIN" value="<?php echo $CIN; ?>"><br><br>
            <label for="nom_entreprise">Nom de l'entreprise:</label>
            <input type="text" id="nom_entreprise" name="nom_entreprise" value="<?php echo $nom_entreprise; ?>"><br><br>
            <label for="adresse_entreprise">Adresse de l'entreprise:</label>
            <input type="text" id="adresse_entreprise" name="adresse_entreprise" value="<?php echo $adresse_entreprise; ?>"><br><br>
            <label for="numero_registre_commerce">registre de commerce:</label>
            <input type="text" id="numero_registre_commerce" name="numero_registre_commerce" value="<?php echo $numero_registre_commerce; ?>"><br><br>
            <label for="pseudo">Pseudo:</label>
            <input type="text" id="pseudo" name="pseudo" value="<?php echo $pseudo; ?>"><br><br>
            <label for="pwrd">Mot de passe:</label>
            <input type="password" id="pwrd" name="pwrd" value="<?php echo $pwrd; ?>"><br><br>

            <input type="submit" name="submit" value="Enregistrer les modifications">
        </form>
    </div>
</body>

</html>