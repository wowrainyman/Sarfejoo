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
     $url = "http://sarfejoo.com/bot_iran/blink.php?product_id=$product_id&link=$link&product_id=$product_id&subprofile_id=$subprofile_id";
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, $url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     $data = curl_exec($ch);
     curl_close($ch);
     echo $data;

}

 ?>