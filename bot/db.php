<?php 

     require_once "config.php";

     if (!isset($_GET["rid"]))  {
     $related_id = "000"; 
      } else  {
     $related_id = $_GET["rid"]; 
      }
     if (!isset($_GET["s"]))  {
     $subprofile_name = "000";
      } else  {
     $subprofile_name = $_GET["s"]; 
      }
     if (!isset($_GET["p"]))  {
     $price = "000"; 
      } else  {
     $price = $_GET["p"]; 
      }
     if (!isset($_GET["d"]))  {
     $text = " "; 
      } else  {
     $text= $_GET["d"]; 
      }

     $subprofile_name = trim($subprofile_name);
     $text = trim($text);
     $price = preg_replace("/[^0-9.]/", "", $price);
 if (!empty($subprofile_name)) {
    $auto_update = false;
     $sql_pu = "SELECT * FROM auto_update WHERE related_id = '$related_id' AND subprofile_name = '$subprofile_name' AND text = '$text' AND update_until > current_date";
     echo $sql_pu;
     $result_select_pu = mysqli_query($link_DB, $sql_pu) or die(mysqli_error());
     while ($row = mysqli_fetch_assoc($result_select_pu)) {
         $auto_update = true;
     }
   //  mysqli_query($con_PU_db,'TRUNCATE TABLE emalls_updated_price');

        $sql = "INSERT INTO emalls_updated_price (
                                                     related_id,
                                                     subprofile_name,
                                                     price,
                                                     text,
                                                     auto_update
                                                    )
                                            VALUES
                                                    (
                                                     '$related_id',
                                                     '$subprofile_name',
                                                     '$price',
                                                     '$text',
                                                     '$auto_update'
                                                 )";
        mysqli_query($link_DB, $sql) or die(mysqli_error());

     if ($auto_update) {

         $sql_update = "UPDATE `pu_subprofile_product` SET
                                                                                `price`='$price',
                                                                                `availability`='0',
                                                                                `status_id`='1',
                                                                                `description`='$text',
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


         $sql_update = "UPDATE `emalls_updated_price` SET
                                                                                `is_r`='1'
                                                                      WHERE
                                                                                `id` = $c_id";

         mysqli_query($link_DB, $sql_update) or die(mysqli_error());

     }
}

 ?>