<?php 
session_start();

$server_name = "localhost";
$user_name = "root";
$password = "";
$database_name = "boutique";

$connection = mysqli_connect($server_name, $user_name, $password, $database_name);

if (!$connection) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $nom = mysqli_real_escape_string($connection, htmlspecialchars($_POST['nom']));
    $mail = mysqli_real_escape_string($connection, htmlspecialchars($_POST['mail']));
    $mdp = mysqli_real_escape_string($connection, $_POST['password']); // On ne hache plus ici

    if (!empty($nom) && !empty($mail) && !empty($mdp)) {
        $query = "INSERT INTO register (nom, mail, mdp) VALUES ('$nom', '$mail', '$mdp')";
        if (mysqli_query($connection, $query)) {
            echo "<p style='color:green;'>Inscription réussie !</p>";
        } else {
            echo "<p style='color:red;'>Erreur lors de l'inscription.</p>";
        }
    } else {
        echo "<p style='color:red;'>Veuillez remplir tous les champs.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="sty/inscription.css">
    <title>Inscription</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <div class="form">
        <div class="title">BTS CIEL - IR</div>
        <div class="subtitle">Création de compte</div>
        
        <form method="POST" action="">
            <div class="input-container ic1">
                <input id="nom" name="nom" class="input" type="text" placeholder=" " required />
                <div class="cut"></div>
                <label for="nom" class="placeholder">Nom d'utilisateur</label>
            </div>
            
            <div class="input-container ic2">
                <input id="mail" name="mail" class="input" type="email" placeholder=" " required />
                <div class="cut"></div>
                <label for="mail" class="placeholder">Mail</label>
            </div>
            
            <div class="input-container ic2">
                <input id="password" name="password" class="input" type="password" placeholder=" " required />
                <div class="cut cut-short"></div>
                <label for="password" class="placeholder">Mot de passe</label>
            </div>
        
            <button type="submit" name="submit" class="submit">Valider</button>
        </form>
    </div>
</body>
</html>
