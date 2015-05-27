<?php
 
 
#############################################  //  9:40 AM Thursday, September 11, 2014
define('DB_PU_HOSTNAME', 'localhost');         #
define('DB_PU_USERNAME', 'root');                #
define('DB_PU_PASSWORD', '');                     #
define('DB_PU_DATABASE', 'sarfe_pu');          #
###################################################
    $site_url = 'http://192.168.87.192/sarfejoo';                                #
    $oc_config_path = '../config.php';     #
###################################################

# error_reporting(0); //   Debug

# OpenCart  DB & Config Files
     require $oc_config_path ;

     $OC_name =   DB_DATABASE;             // OpenCart db name
     $OC_user =     DB_USERNAME;           // OpenCart db username
     $OC_pwd =     DB_PASSWORD;         // OpenCart db password
     $OC_host =     DB_HOSTNAME;        // OpenCart db hostname 

     $con_OC_db =   mysqli_connect($OC_host, $OC_user, $OC_pwd, $OC_name) or die ('Cannot connect to OC server');
     mysqli_set_charset($con_OC_db, 'utf8');
     if (mysqli_connect_errno())
     { echo "Failed to connect to MySQL (OC): " . mysqli_connect_error();  }
   
# ProviderModel  DB & Config Files
      // require 'config.php';
      
     $PU_name =     DB_PU_DATABASE ;          // ProviderModel db name
     $PU_user =      DB_PU_USERNAME;          // ProviderModel db username
     $PU_pwd =      DB_PU_PASSWORD;        // ProviderModel db password
     $PU_host =     DB_PU_HOSTNAME;        // ProviderModel db hostname 

  $con_PU_db=mysqli_connect($PU_host, $PU_user, $PU_pwd, $PU_name) or die ('Cannot connect to server');
  mysqli_set_charset($con_PU_db, 'utf8');
  if (mysqli_connect_errno())
  { echo "Failed to connect to MySQL: " . mysqli_connect_error();  }
   
   mb_internal_encoding('UTF-8');
   mb_http_output('UTF-8');
   mb_http_input('UTF-8');
   mb_language('uni');
   mb_regex_encoding('UTF-8');
   ob_start('mb_output_handler');

//  Test MOd

          $sql_test_mod = "SELECT * FROM `oc_category` LIMIT 3";
          $result_test_mod = mysqli_query($con_OC_db, $sql_test_mod) or die(mysqli_error());
          while($row = mysqli_fetch_assoc($result_test_mod)) {
               echo $row['category_id'];
               echo $row['image'];
               echo $row['parent_id'];
              echo $row['top'];
               echo $row['column'];
               echo $row['status'];
               echo $row['date_added'];
               echo $row['date_modified'];
               echo '<br />';
               echo '<br />';
          }
                echo '<br />';



?>