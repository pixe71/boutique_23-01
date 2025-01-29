<?php 
session_start();

$server_name = "localhost";
$user_name = "root";
$password = "";
$database_name = "boutique";

$connection = mysqli_connect($server_name, $user_name, $password, $database_name);

if(isset($_POST["ajouter"])) {
    if(!isset($_SESSION["panier"])) {
        $_SESSION["panier"] = array();
    }

    $acol = array_column($_SESSION["panier"], 'item_id');

    if(!in_array($_POST["id"], $acol)) {
        $item = array(
            'item_id' => $_POST["id"],
            'item_name' => $_POST["hidden_name"],
            'item_image' => $_POST["hidden_image"],
            'item_price' => $_POST["hidden_price"],
            'item_description' => $_POST["hidden_description"],
            'item_quantity' => $_POST["quantity"]
        );
        $_SESSION["panier"][$_POST["id"]] = $item;
    } else {
        $_SESSION['panier'][$_POST["id"]]['item_quantity'] += $_POST["quantity"];
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste de nos produits</title>
    <link rel="stylesheet" type="text/css" href="sty/ventes.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
  
  <h1 class="textUp">Nos produits</h1>
  <h1 class="textUp">Découvrez notre sélection de produits</h1>

  <div class="panier">
    <a href="panier.php">
      <button class="buttonProduct" style="font-size: 20px;">
        <i class="fa-solid fa-cart-shopping"></i> Accéder au panier
      </button>
    </a>
  </div>

  <div class="container">
    <?php
    $query = "SELECT * FROM produits";
    $final = mysqli_query($connection, $query);

    if (mysqli_num_rows($final) > 0) {
        while($i = mysqli_fetch_assoc($final)) { ?>
            <div class="product">
                <div class="nom">
                    <p class="center"><?= $i["nom_p"]; ?></p>
                </div>
                <div class="img">
                    <img src="<?= $i['image_p']; ?>" alt="Produit" height="170px" class="centerimg">
                </div>
                <div class="description"><?= $i["description_p"]; ?></div>
                <div class="ref">Ref: <?= $i["ref"]; ?></div>
                <div class="prix">
                    <?= ($i["prix"] == $i["prixpromo"]) ? $i["prix"].'€' : $i["prixpromo"].'€ <s>'.$i["prix"].'€</s>'; ?>
                </div>

                <form action="ventes.php" method="POST" class="admin">
                    <input type="number" name="quantity" value="1" min="1" style="width: 40%">
                    <input type="hidden" name="id" value="<?= $i['id'] ?>">
                    <input type="hidden" name="hidden_name" value="<?= $i['nom_p'] ?>">
                    <input type="hidden" name="hidden_image" value="<?= $i['image_p'] ?>">
                    <input type="hidden" name="hidden_price" value="<?= $i['prixpromo'] ?>">
                    <input type="hidden" name="hidden_description" value="<?= $i['description_p'] ?>">
                    <button type="submit" name="ajouter" class="buttonProduct">Ajouter au panier</button>
                </form>
            </div>
        <?php 
        }
    } else {
        echo "<p>Aucun produit disponible.</p>";
    }
    ?>
  </div>
</body>
</html>
