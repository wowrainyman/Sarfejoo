<?php 
###############################
### ins.php - 10:47 AM 3/9/2015 by M.Abooali
###############################
     require_once "config.php";
     if (!isset($_GET["pid"]))  {     $product_id = ""; 
      } else  {
     $product_id = $_GET["pid"]; 
      }
     if (!isset($_GET["s"]))  {
     $subprofile_id = "";
      } else  {
     $subprofile_id = $_GET["s"]; 
      }
     if (!isset($_GET["p"]))  {
     $price = ""; 
      } else  {
     $price = $_GET["p"]; 
      }
     if (!isset($_GET["d"]))  {
     $description = ""; 
      } else  {
     $description = $_GET["d"]; 
      }
     if (!isset($_GET["c_id"]))  {
     $c_id = ""; 
      } else  {
     $c_id = $_GET["c_id"]; 
      }
      
 if (!empty($subprofile_id)) {
 
     $sql_insert = "INSERT INTO pu_subprofile_product (
                                                                           product_id,
                                                                           subprofile_id,
                                                                           price,
                                                                           description,
                                                                           availability,
                                                                           status_id,
                                                                           is_payed
                                                            ) VALUES (
                                                                           '$product_id',
                                                                           '$subprofile_id',
                                                                           '$price',
                                                                           '$description',
                                                                           0,
                                                                           1,
                                                                           1
                                                                      )";
     
          mysqli_query($link_PU_DB, $sql_insert) or die(mysqli_error());

          $sql_id = "SELECT id FROM pu_subprofile_product ORDER BY id DESC limit 1";
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



          $sql_update = "UPDATE `digikala_updated_price` SET
                                                                                `is_r`='1'
                                                                      WHERE 
                                                                                `id` = $c_id";
                                                                                
          mysqli_query($link_DB, $sql_update) or die(mysqli_error());

}

 ?>