<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = $_POST['mail'];
    $mdp = $_POST['mdp'];

    $servername = "localhost";
    $username = "root";
    $password = ""; 
    $dbname = "boutique";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connexion échouée : " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM register WHERE mail = ?");
    $stmt->bind_param("s", $mail);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($mdp === $user['mdp']) {
            header("Location: ventes.php");
            exit;
        } else {
            $error_message = "Mot de passe incorrect.";
        }
    } else {
        $error_message = "Identifiants incorrects.";
    }

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
