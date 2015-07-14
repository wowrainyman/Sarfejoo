<?php

require_once "config.php";

$link = $_GET["link"];
$product_id = $_GET["product_id"];
$subprofile_id = $_GET["subprofile_id"];

if (!empty($subprofile_id)) {

    $sql_update = "UPDATE `pu_subprofile_product` SET
                                                                                `buy_link`='$link'
                                                                      WHERE 
                                                                                `product_id` = $product_id
                                                                         AND
                                                                                `subprofile_id` = $subprofile_id";

    mysqli_query($link_PU_DB, $sql_update) or die(mysqli_error());

}

?>