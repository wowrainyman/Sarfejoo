<?php 

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
     if (!isset($_GET["link"]))  {
     $link = ""; 
      } else  {
     $link = $_GET["link"]; 
      }

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