<?php 

$server_name = "localhost";
$user_name = "root";
$password = "";

$database_name = "boutique";

$connection = mysqli_connect($server_name, $user_name, $password, $database_name);

$query = "SELECT * from produits";

$final = mysqli_query($connection, $query);

if (mysqli_num_rows($final) > 0) {
    while($i = mysqli_fetch_assoc($final)) {
        ?>
    <table>

        <img src='<?php echo $i["image_p"]; ?>' />
        <?php echo $i["nom_p"]; ?> <br>
        <?php echo $i["ref"]; ?> 
        <?php echo $i["description_p"]; ?>
        <?php echo $i["prix"]. "€"; ?>
    <table>
        <?php 
    }
} else {
    echo "Aucun résultat";
}

?>
