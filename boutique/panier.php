<?php
session_start();

if (isset($_POST["ajouter"]) && isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $id = $_GET["id"];
    $item = array(
        'item_id' => $id,
        'item_name' => htmlspecialchars($_POST["hidden_name"]),
        'item_image' => htmlspecialchars($_POST["hidden_image"]),
        'item_price' => floatval($_POST["hidden_price"]),
        'item_description' => htmlspecialchars($_POST["hidden_description"]),
        'item_quantity' => intval($_POST["quantity"])
    );

    if (!isset($_SESSION["panier"][$id])) {
        $_SESSION["panier"][$id] = $item;
    } else {
        $_SESSION["panier"][$id]['item_quantity'] += intval($_POST["quantity"]);
    }
}

// Gestion de la suppression d'un article du panier
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["supprimer"]) && isset($_POST["id"])) {
    $id = $_POST["id"];
    if (isset($_SESSION["panier"][$id])) {
        unset($_SESSION["panier"][$id]);
        // Redirection après la suppression pour ne pas resoumettre le formulaire lors du rafraîchissement de la page
        header("Location: panier.php");
        exit();
    }
}

$connection = mysqli_connect("localhost", "root", "", "boutique");

if (!$connection) {
    die("Échec de la connexion : " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sty/panier.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
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
                <tbody>
                    <?php 
                    $total = 0;
                    if (!empty($_SESSION["panier"])) :
                        foreach ($_SESSION["panier"] as $item) : 
                            $subtotal = $item["item_price"] * $item["item_quantity"];
                            $total += $subtotal;
                    ?>
                    <tr class="productitm">
                        <td><img src="<?= htmlspecialchars($item["item_image"]) ?>" alt="produit"></td>
                        <td><input type="number" value="<?= htmlspecialchars($item["item_quantity"]) ?>" min="1" max="99" class="qtyinput"></td>
                        <td><?= htmlspecialchars($item["item_name"]) ?></td>
                        <td><?= number_format($subtotal, 2, ".", " ") ?> €</td>
                        <td>
                            <form method="POST" action="panier.php">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($item['item_id']) ?>">
                                <button type="submit" name="supprimer" class="btn btn-delete">
                                    <span class="mdi mdi-delete mdi-24px"></span>
                                    <span class="mdi mdi-delete-empty mdi-24px"></span>
                                    <span>Supprimer</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; endif; ?>
                    <tr class="extracosts">
                        <td class="light">Frais de livraison &amp; Taxes</td>
                        <td colspan="2" class="light"></td>
                        <td>35.00 €</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr class="totalprice">
                        <td class="light">Total:</td>
                        <td colspan="2">&nbsp;</td>
                        <td colspan="2"><span class="thick"><?= number_format($total + 35, 2, ".", " ") ?> €</span></td>
                    </tr>
                    <tr class="checkoutrow">
                        <td colspan="5" class="checkout">
                            <div class="container">
                                <div class="right-side">
                                    <div class="new">Commander</div>
                                    <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 451.846 451.847">
                                        <path d="M345.441 248.292L151.154 442.573c-12.359 12.365-32.397 12.365-44.75 0-12.354-12.354-12.354-32.391 0-44.744L278.318 225.92 106.409 54.017c-12.354-12.359-12.354-32.394 0-44.748 12.354-12.359 32.391-12.359 44.75 0l194.287 194.284c6.177 6.18 9.262 14.271 9.262 22.366 0 8.099-3.091 16.196-9.267 22.373z" fill="#cfcfcf"/>
                                    </svg>
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
