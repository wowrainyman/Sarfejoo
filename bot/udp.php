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
        if (!isset($_GET["auto_update"]))  {
            $auto_update = false;
        } else  {
            $auto_update = $_GET["auto_update"];
        }
        if (!isset($_GET["not_related"]))  {
            $not_related = false;
        } else  {
            $not_related = $_GET["not_related"];
        }
        if (!isset($_GET["subprofile_name"]))  {
            $subprofile_name = "";
        } else  {
            $subprofile_name = $_GET["subprofile_name"];
        }
        if (!isset($_GET["text"]))  {
            $text = "";
        } else  {
            $text = $_GET["text"];
        }

 if (!empty($subprofile_id)) {
     $url = "http://sarfejoo.com/bot_iran/udp.php?product_id=$product_id&subprofile_id=$subprofile_id&price=$price&description=$description";
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, $url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     $data = curl_exec($ch);
     curl_close($ch);
     echo $data;
     $username=$_SESSION['user_name'];

          $sql_update = "UPDATE `emalls_updated_price` SET
                                                                                `is_r`='1',
                                                                                user='$username'
                                                                      WHERE 
                                                                                `id` = $c_id";
                                                                                
          mysqli_query($link_DB, $sql_update) or die(mysqli_error());

}

if ($auto_update) {
    $sql_insert = "INSERT INTO `auto_update`(
                                 `related_id`,
                                 `subprofile_name`,
                                 `text`,
                                 `update_until`
                  ) VALUES (
                                 '$product_id',
                                 '$subprofile_name',
                                 '$text',
                                  DATE_ADD(current_date,INTERVAL 7 DAY)
                            );";
    echo $sql_insert;
    mysqli_query($link_DB, $sql_insert) or die(mysqli_error());
}
if ($not_related) {
    $sql_insert = "INSERT INTO `not_related`(
                                 `related_id`,
                                 `subprofile_name`,
                                 `text`,
                                 `remove_until`
                  ) VALUES (
                                 '$product_id',
                                 '$subprofile_name',
                                 '$text',
                                  DATE_ADD(current_date,INTERVAL 30 DAY)
                            );";
    echo $sql_insert;
    mysqli_query($link_DB, $sql_insert) or die(mysqli_error());
}

 ?>