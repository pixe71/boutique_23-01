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
    <script src="js/script.js"></script> 
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button
      data-mdb-collapse-init
      class="navbar-toggler"
      type="button"
      data-mdb-target="#navbarNav"
      aria-controls="navbarNav"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <i class="fas fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Features</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Pricing</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled"
            >Deconnexion</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

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
                
                <div class="description">
                    <?= $i["description_p"]; ?>
                </div>
                
                <div class="ref">
                    Ref: <?= $i["ref"]; ?>
                </div>
                
                <div class="avis">
                Avis : <?php echo $i["avis"]; ?>
                </div>

                <div class="prix">
                    <?= ($i["prix"] == $i["prixpromo"]) ? $i["prix"].'€' : $i["prixpromo"].'€ <s>'.$i["prix"].'€</s>'; ?>
                </div>
                
                <div class="notes">               
                    <?php echo $i["notes"]; ?>
                </div>
                <div class="etoiles">
                  <fieldset class="avis__etoiles">
                  <?php
                    for ($ii = 10; $ii > 0; $ii--) {
                        if ($ii <= (2 * $i["notes"])) {
                            if ($ii % 2 == 0) {
                                $jj = $ii / 2;
                                echo '<input type="radio"/><label class="full" style="color:#fccf47;"></label>';
                            } else {
                                echo '<input type="radio"/><label class="half" style="color:#fccf47;"></label>';
                            }
                        } else {
                            
                            if ($ii % 2 == 0) {
                                $jj = $ii / 2;
                                echo '<input type="radio"/><label class="full"></label>';
                            } else { 
                                echo '<input type="radio"/><label class="half"></label>';
                            }
                        }
                    }
                    ?>
                  </fieldset>
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
