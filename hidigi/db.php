<?php 
###############################
### db.php - 10:47 AM 3/9/2015 by M.Abooali
###############################
require_once "config.php";
if (!isset($_GET["id"]))  {$product_id = "";} else  {$product_id = $_GET["id"];}
if (!isset($_GET["price"]))  {$price = '';} else  {$price= $_GET["price"];}
if (!empty($product_id) && !empty($price)) {
$sql = "INSERT INTO digikala_updated_price (product_id, price) VALUES ('$product_id', '$price')";
mysqli_query($link_DB, $sql) or die(mysqli_error());
}
?>