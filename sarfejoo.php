<?php

## Ver 0.1.1

mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
mb_http_input('UTF-8');
mb_language('uni');
mb_regex_encoding('UTF-8');
ob_start('mb_output_handler');


# DB Link
     require_once "config.php";

     $DB_host =  constant("DB_HOSTNAME");
     $DB_user = constant("DB_USERNAME");
     $DB_pwd = constant("DB_PASSWORD");
     $OC_DB_name = constant("DB_DATABASE");
     $OC_DB_PREFIX = constant("DB_PREFIX");

     $link_OC_DB = mysqli_connect($DB_host, $DB_user, $DB_pwd, $OC_DB_name) or die ('Cannot connect to server');
     mysqli_set_charset($link_OC_DB, 'utf8');
     if (mysqli_connect_errno()) {
         echo "Failed to connect to MySQL: " . mysqli_connect_error();
     }
# # # # #
     
     if (!isset($_GET["pi"]))  {
     $product_id = "0"; 
      } else  {
     $product_id = $_GET["pi"]; 
      }
      
     $sql_product = "SELECT p.`price`, p.`quantity`, p.`status`, pd.`name` FROM `" . $OC_DB_PREFIX . "product` p, `" . $OC_DB_PREFIX . "product_description` pd WHERE p.`product_id` ='$product_id '";
     $result_product = mysqli_query($link_OC_DB, $sql_product) or die(mysqli_error());
     while ($row = mysqli_fetch_assoc($result_product)) {
                                                                           $price = $row['price'];
                                                                           $quantity = $row['quantity'];
                                                                           $status = $row['status'];
                                                                           $name = $row['name'];
                                                                           
                    echo $product_id;
                    echo $name;
     }
     
?>