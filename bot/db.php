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
   //  mysqli_query($con_PU_db,'TRUNCATE TABLE emalls_updated_price');

     $sql = "INSERT INTO emalls_updated_price (
                                                 related_id,
                                                 subprofile_name,
                                                 price,
                                                 text
                                                )
                                        VALUES 
                                                (
                                                 '$related_id',
                                                 '$subprofile_name',
                                                 '$price',
                                                 '$text'
                                             )";
     mysqli_query($link_DB, $sql) or die(mysqli_error());
}

 ?>