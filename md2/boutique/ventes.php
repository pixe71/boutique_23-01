
<?php 
session_start();

$server_name = "localhost";
$user_name = "root";
$password = "";

$database_name = "boutique";

$connection = mysqli_connect($server_name, $user_name, $password, $database_name);

if(isset($_POST["ajouter"]))
{
  if(isset($_SESSION["panier"]))
  {
    $acol = array_column($_SESSION["panier"], 'item_id');
    if(!in_array($_GET["id"], $acol))
    {
      $item = array(
        'item_id' =>  $_GET["id"],
        'item_name' =>  $_POST["hidden_name"],
        'item_image' =>  $_POST["hidden_image"],
        'item_price' =>  $_POST["hidden_price"],
        'item_description' =>  $_POST["hidden_description"],
        'item_quantity' =>  $_POST["quantity"]
      );
      $_SESSION["panier"] [$_GET["id"]] = $item;
    }
    else
    {
      $_SESSION['panier'] [$_GET["id"]] ['item_quantity'] += $_POST["quantity"];
    }
  }
  else
  {
    $item = array(
      'item_id' =>  $_GET["id"],
      'item_name' =>  $_POST["hidden_name"],
      'item_image' =>  $_POST["hidden_image"],
      'item_price' =>  $_POST["hidden_price"],
      'item_description' =>  $_POST["hidden_description"],
      'item_quantity' =>  $_POST["quantity"]
    );
    $_SESSION['panier'] [$_GET["id"]] = $item;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste de nos produits</title>
    <link rel="stylesheet" type="text/css" href="sty/ventes.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://kit.fontawesome.com/b2bdba9beb.js" crossorigin="anonymous"></script>
</head>

<body>
  
  <!-- Titres de la page -->

  <h1 class="textUp">Nos produits</h1>
  <h1 class="textUp">Découvrez notre sélection de produits</h1>
  

  <div class="panier">
    <a href="panier.php">
    <button class="buttonProduct" style="font-size: 20px;"><i class="fa-solid fa-cart-shopping"></i>Acceder au panier</button>
    </a>
  </div>
  

    <div class="container">

      <?php
      $query = "SELECT * from produits";

      $final = mysqli_query($connection, $query);

      if (mysqli_num_rows($final) > 0) {
          while($i = mysqli_fetch_assoc($final)) {
              ?>


      <!-- Tout les produits -->

        <div class="product">
        
       <!-- <div class="promotion"><h5>Promotion</h5></div> -->
          
        <!-- Nom des produits -->

          <div class="nom">
            <p class="center"><?php echo $i["nom_p"]; ?></p>
          </div>
          
          <!-- Image des produits -->

          <div class="img">
            <img src="<?php echo $i['image_p']; ?>" alt="PC1" height="170px" class="centerimg">
          </div>
          
          <!-- Descrption des produits -->

          <div class="description">
            <?php echo $i["description_p"]; ?>
          </div>
          
          <br>
          
          <!-- Références des produits -->

          <div class="ref">Ref :<?php echo $i["ref"]; ?></div>
          
          <br>
          
          <!-- Prix des produits -->

          <div class="prix">
            <?php 
              if ($i["prix"] == $i["prixpromo"]) { 
                echo $i["prix"]. '€';
              } else { 
                echo $i["prixpromo"]. '€' . ' <s>' . $i["prix"] . '€' . '</s>';
              }?>
              <br>
          </div>

            <!-- Avis des produits -->

            <div class="avis">
              Avis : <?php echo $i["avis"]; ?>

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

          <br>

          <!-- Bouton "ajouter au panier" -->
          <form action="ventes.php?action=ajouter&id=<?=$i['id']?>" method="POST" class="admin">
          <input type="number" value="1" name="quantity" style="width: 40%"/>
          <input type="hidden" value="<?= $i['id'] ?>" name="id"/>
          <input type="hidden" value="<?= $i['nom_p'] ?>" name="hidden_name"/>
          <input type="hidden" value="<?= $i['image_p'] ?>" name="hidden_image"/>
          <input type="hidden" value="<?= $i['prix'] ?>" name="hidden_price"/>
          <input type="hidden" value="<?= $i['description_p'] ?>" name="hidden_description"/>
            <button class="buttonProduct">
              <a href="" class="aButton">Ajouter au panier</a>
            </button>
          
        </div>

        </div>
        
        <?php 
            }
        } else {
            echo "Aucun résultat";
        }

        ?>

      </div>

        <!-- <div class="Product5">
          <div class="Nom5"></div>
          <div class="Img5"></div>
          <div class="Prix5"></div>
        </div> -->

</body>
</html>