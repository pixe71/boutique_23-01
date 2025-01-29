<?php
// Vérification si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les informations du formulaire
    $mail = $_POST['mail'];
    $mdp = $_POST['mdp'];

    // Connexion à la base de données
    $servername = "localhost";
    $username = "root"; // Remplace par ton utilisateur
    $password = ""; // Remplace par ton mot de passe
    $dbname = "boutique"; // Remplace par le nom de ta base de données

    // Créer la connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Connexion échouée : " . $conn->connect_error);
    }

    // Préparer la requête SQL sécurisée pour vérifier l'utilisateur
    $stmt = $conn->prepare("SELECT * FROM register WHERE mail = ?");
    $stmt->bind_param("s", $mail); // "s" signifie que le paramètre est une chaîne

    // Exécuter la requête
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérifier si un utilisateur a été trouvé
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Comparer le mot de passe en clair
        if ($mdp === $user['mdp']) { // Comparaison directe sans hashage
            // Mot de passe correct, redirection vers la page des ventes
            header("Location: ventes.php");
            exit;
        } else {
            // Si le mot de passe est incorrect
            $error_message = "Mot de passe incorrect.";
        }
    } else {
        // Si l'utilisateur n'est pas trouvé
        $error_message = "Identifiants incorrects.";
    }

    // Fermer la connexion
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page de Connexion</title>
    <link rel="stylesheet" href="sty/connexion.css">
</head>
<body>
    <form class="form" method="POST" action="">
        <div class="title">BTS CIEL - IR</div>
        <div class="subtitle">Connexion</div>
        
        <?php if (isset($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>

        <div class="input-container ic1">
            <input id="mail" class="input" type="text" name="mail" placeholder=" " required />
            <div class="cut"></div>
            <label for="mail" class="placeholder">Mail</label>
        </div>
        
        <div class="input-container ic2">
            <input id="mdp" class="input" type="password" name="mdp" placeholder=" " required />
            <div class="cut"></div>
            <label for="mdp" class="placeholder">Mot de passe</label>
        </div>

        <button type="submit" class="submit">Se connecter</button><br>
    </form>
</body>
</html>
