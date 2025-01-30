<?php
session_start();

$server_name = "localhost";
$user_name = "root";
$password = "";

$database_name = "boutique";

$connection = mysqli_connect($server_name, $user_name, $password, $database_name);

$query = "SELECT * from produits";
$final = mysqli_query($connection, $query);

$jour = getdate();
(getdate());
$semaine = array(" Dimanche "," Lundi "," Mardi "," Mercredi "," Jeudi ", " Vendredi ", " Samedi ");
$mois = array(1=>" Janvier "," Février "," Mars "," Avril "," Mai "," Juin "," Juillet "," Août "," Septembre "," Octobre "," Novembre "," Décembre ");

?>

<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="sty/facture.css" type="text/css" media="all" />
    <script src="js/script.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
    #telecharger {
    display: block;
    width: 200px;
    margin: 20px auto;
    padding: 10px;
    background-color: #367588;
    color: #fff;
    text-align: center;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: 600;
  }
  #telecharger:hover {
    background-color: #007474;
  }
    </style>

</head>
<body>

<?php
    if (!empty($_SESSION["panier"])) :
        $totalHT = 0;
        $totalTVA = 0;
        $totalTTC = 0;
        $fraisLivraison = 35.00;
?>

<button id="telecharger"> Télécharger la version PDF</button>

<h2>Facture</h2>

<br>

<div id="contenu">

Date : <?php echo $semaine[date('w')] ," ",date('j'), " ", $mois[date('n')], date('Y')," "; ?>
<br>
<br>
Facture : <?php echo date("y");?>CES-<?php echo date("m");?>12

<table>
    <tr>
        <td>Fournisseur</td>
        <td>Clients</td>
    </tr>
    <tr>
        <td>Apple</td>
        <td>Carnus Enseignement Supérieur</td>
    </tr>
    <tr>
        <td>N° de TVA FR45365423857</td>
        <td>N° de TVA FR45645645363</td>
    </tr>
    <tr>
        <td>SIRET : 1234567890</td>
        <td>SIRET : 1234565431</td>
    </tr>
    <tr>
        <td>12 Rue Halévy</td>
        <td>Avenue de Saint Pierre</td>
    </tr>
    <tr>
        <td>75009</td>
        <td>12000</td>
    </tr>
    <tr>
        <td>France</td>
        <td>France</td>
    </tr>
</table>

<table>
    <tr>
        <th>#</th>
        <th>Produits</th>
        <th>Prix</th>
        <th>Qté</th>
        <th>TVA</th>
        <th>Sous total</th>
        <th>Sous total TTC</th>
    </tr>

    <?php
    $index = 1;
    foreach ($_SESSION["panier"] as $item) :
        $prix = $item['item_price'];
        $quantite = $item['item_quantity'];
        $sous_total = $prix * $quantite;
        $tva = 0.2 * $sous_total;
        $total_sous_total_ttc = $sous_total + $tva;
        

        $totalHT += $sous_total;
        $totalTVA += $tva;
        $totalTTC += $total_sous_total_ttc;
    ?>
    <tr>
        <th><?php echo $index++; ?>.</th>
        <th><?php echo htmlspecialchars($item['item_name']); ?></th>
        <th><?php echo number_format($prix, 2, ".", " "); ?>€</th>
        <th><?php echo number_format($quantite, 1); ?></th>
        <th>20%</th>
        <th><?php echo number_format($sous_total, 2, ".", " "); ?>€</th>
        <th><?php echo number_format($total_sous_total_ttc, 2, ".", " "); ?>€</th>
    </tr>
    <?php endforeach; ?>

    <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th>Total HT :</th>
        <th><?php echo number_format($totalHT, 2, ".", " "); ?>€</th>
    </tr>
    <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th>Taxes :</th>
        <th><?php echo number_format($totalTVA, 2, ".", " "); ?>€</th>
    </tr>
    <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th>Frais de livrason :</th>
        <th><?php echo number_format($fraisLivraison, 2, ".", " "); ?>€</th>
    </tr>
    <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th>Total TTC :</th>
        <th><?php echo number_format($totalTTC + $fraisLivraison, 2, ".", " "); ?>€</th>
    </tr>
</table>
<br>
<table>
    <tr>
        <h3>Informations Bancaire</h3>
    </tr>
    <tr>
        <p>Carte de Crédit</p>
    </tr>
    <tr>
        <p>Type de carte : Visa</p>
    </tr>
    <tr>
        <p>Numéro de carte : **** **** **** <?php echo rand(1000,9999); ?></p>
    </tr>
    <tr>
        <p>Référence de paiement : <?php echo date("y");?>CES-<?php echo date("m");?><?php echo date("d");?><?php echo date("H");?></p>
    </tr>
</table>

<h3>Notes</h3>
<p>Les factures devront être réglées en Euros (€) dès réception, et au plus tard dans un délai de 30 jours (délai inférieur ou égal à 45 jours) à partir de la date de leur émission.</p>

<?php
else:
    echo "<p>Votre panier est vide.</p>";
endif;
?>

</div>

</body>
</html>
