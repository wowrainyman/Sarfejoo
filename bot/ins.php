<?php
    // load the login class
    require_once("classes/Login.php");

    // create a login object. when this object is created, it will do all login/logout stuff automatically
    // so this single line handles the entire login process. in consequence, you can simply ...
    $login = new Login();

     require_once "config.php";

     if (!isset($_GET["pid"]))  {
     $product_id = ""; 
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

     $username=$_SESSION['user_name'];
     echo $username;

          $sql_update = "UPDATE `emalls_updated_price` SET
                                                                                `is_r`='1',
                                                                                user='$username'
                                                                      WHERE 
                                                                                `id` = $c_id";
                                                                                
          mysqli_query($link_DB, $sql_update) or die(mysqli_error());

}

 ?>