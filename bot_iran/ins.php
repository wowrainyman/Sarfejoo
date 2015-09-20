<?php

require_once "config.php";

$product_id = $_GET["product_id"];
$subprofile_id = $_GET["subprofile_id"];
$price = $_GET["price"];
$description = $_GET["description"];


if (!empty($subprofile_id)) {
    $haveIt = false;
    $sql_id = "SELECT * FROM pu_subprofile_product WHERE product_id = $product_id AND subprofile_id = $subprofile_id";
    $result_id = mysqli_query($link_PU_DB, $sql_id) or die(mysqli_error());
    while ($row = mysqli_fetch_assoc($result_id)) {
        $haveIt =true;
    }
    if($haveIt){
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
    }else{
        $sql_insert = "INSERT INTO pu_subprofile_product (
                                                                           product_id,
                                                                           subprofile_id,
                                                                           price,
                                                                           description,
                                                                           availability,
                                                                           update_date,
                                                                           status_id
                                                            ) VALUES (
                                                                           '$product_id',
                                                                           '$subprofile_id',
                                                                           '$price',
                                                                           '$description',
                                                                           0,
                                                                           NOW(),
                                                                           1
                                                                      )";

        mysqli_query($link_PU_DB, $sql_insert) or die(mysqli_error());

        $sql_id = "SELECT id FROM pu_subprofile_product ORDER BY id DESC limit 1";
        $result_id = mysqli_query($link_PU_DB, $sql_id) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_id)) {
            $subprofile_product_id = $row['id'];
        }
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

}

?>