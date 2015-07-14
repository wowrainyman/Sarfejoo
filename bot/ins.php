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

     $url = "http://sarfejoo.com/bot_iran/ins.php?product_id=$product_id&subprofile_id=$subprofile_id&price=$price&description=$description";
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, $url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     $data = curl_exec($ch);
     curl_close($ch);
     echo $data;

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