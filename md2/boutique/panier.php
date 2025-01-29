<?php
session_start();

if(isset($_POST["ajouter"]))
{
  if(isset($_SESSION["panier"]))
  {
    $acol = array_column($_SESSION["panier"], "item_id");
    if(!in_array($_GET["id"], $acol))
    {
      // $count = count($_SESSION["panier"]);
      $item = array(
        'item_id'     =>  $_GET["id"],
        'item_name'     =>  $_POST["hidden_name"],
        'item_image'     =>  $_POST["hidden_image"],
        'item_price'    =>  $_POST["hidden_price"],
        'item_description'    =>  $_POST["hidden_description"],
        'item_quantity'   =>  $_POST["quantity"]
      );
      $_SESSION["panier"][$_GET["id"]] = $item;
    }
    else
    {
      $_SESSION['panier'][$_GET["id"]]['item_quantity'] += $_POST["quantity"];
      // echo '<script>alert("Article existe déjà dans le panier")</script>';
    }
  }
  else
  {
    $item = array(
      'item_id'     =>  $_GET["id"],
      'item_name'     =>  $_POST["hidden_name"],
      'item_image'     =>  $_POST["hidden_image"],
      'item_price'    =>  $_POST["hidden_price"],
      'item_description'    =>  $_POST["hidden_description"],
      'item_quantity'   =>  $_POST["quantity"]
    );
    $_SESSION["panier"][$_GET["id"]] = $item;
  }
}

$server_name = "localhost";
$user_name = "root";
$password = "";

$database_name = "boutique";

$connection = mysqli_connect($server_name, $user_name, $password, $database_name);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="sty/panier.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="https://cdn.materialdesignicons.com/3.6.95/css/materialdesignicons.min.css">
	<title>Panier</title>
</head>


<body>
  <div id="w">
    <header id="title">
      <h1>Panier</h1>
    </header>
    <div id="page">
      <table id="cart">
        <thead>
          <tr>
            <th class="first">Photo</th>
            <th class="second">Qté</th>
            <th class="third">Produit</th>
            <th class="fourth">Total</th>
            <th class="fifth">&nbsp;</th>
          </tr>
        </thead>
        <body>
          <!-- shopping cart contents -->
          <tr class="productitm">
            <td><img src="<?=$i["image"]?>" alt="produit"></td>
            <td><input type="number" value="1" min="0" max="99" class="qtyinput"></td>
            <td><?= $panier['item_name']?></td>
            <td><?=number_format($i["prix"],2,"."," ")?> &#8364;</td>
            <!-- <td><span class="remove"><i class="fa-solid fa-x"></i></span> </td>-->
            <td><span class="remove">
            	<button class="btn btn-delete">
            	<span class="mdi mdi-delete mdi-24px"></span>
            	<span class="mdi mdi-delete-empty mdi-24px"></span>
            	<span>Delete</span>
            	</button>
            	</span>
            </td>
          </tr>
          <!-- tax + subtotal -->
          <tr class="extracosts">
            <td class="light">Frais de livraison &amp; Taxes</td>
            <td colspan="2" class="light"></td>
            <td>35.00 €</td>
            <td>&nbsp;</td>
          </tr>
          <tr class="totalprice">
            <td class="light">Total:</td>
            <td colspan="2">&nbsp;</td>
            <td colspan="2"><span class="thick">225.45 €</span></td>
          </tr>
          
          <!-- checkout btn -->
          <tr class="checkoutrow">
            <td colspan="5" class="checkout">
            <div class="container">
              <div class="left-side">
               <div class="card">
                <div class="card-line"></div>
                <div class="buttons"></div>
               </div>
               <div class="post">
                <div class="post-line"></div>
                <div class="screen">
                 <div class="dollar">€</div>
                </div>
                <div class="numbers"></div>
                <div class="numbers-line2"></div>
               </div>
              </div>
              <div class="right-side">
               <div class="new">Commander</div>
               
                <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 451.846 451.847"><path d="M345.441 248.292L151.154 442.573c-12.359 12.365-32.397 12.365-44.75 0-12.354-12.354-12.354-32.391 0-44.744L278.318 225.92 106.409 54.017c-12.354-12.359-12.354-32.394 0-44.748 12.354-12.359 32.391-12.359 44.75 0l194.287 194.284c6.177 6.18 9.262 14.271 9.262 22.366 0 8.099-3.091 16.196-9.267 22.373z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#cfcfcf"/></svg>
              
              </div>
             </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</body>



</html>