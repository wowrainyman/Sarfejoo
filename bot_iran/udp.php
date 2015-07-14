<?php
require_once "config.php";
$product_id = $_GET["product_id"];
$subprofile_id = $_GET["subprofile_id"];
$price = $_GET["price"];
$description = $_GET["description"];
$sql_update = "UPDATE `pu_subprofile_product` SET
                                                                                `price`='$price',
                                                                                `availability`='0',
                                                                                `status_id`='1',
                                                                                `description`='$description',
                                                                                `update_date`= NOW()
                                                                      WHERE 
                                                                                `product_id` = $product_id
                                                                         AND
                                                                                `subprofile_id` = $subprofile_id";

mysqli_query($link_PU_DB, $sql_update) or die(mysqli_error());
$sql_id = "SELECT id FROM pu_subprofile_product WHERE `product_id` = $product_id  AND `subprofile_id` = $subprofile_id";
$result_id = mysqli_query($link_PU_DB, $sql_id) or die(mysqli_error());
while ($row = mysqli_fetch_assoc($result_id)) {
    $subprofile_product_id = $row['id'];
}
$sql_insert = "INSERT INTO pu_subprofile_product_history (
                                                                                     subprofile_product_id,
                                                                                     price,
                                                                                     bot
                                                                      ) VALUES (
                                                                                     '$subprofile_product_id',
                                                                                     '$price',
                                                                                     '1'
                                                                                )";
mysqli_query($link_PU_DB, $sql_insert) or die(mysqli_error());
?>