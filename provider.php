<?php


#############################################  //  9:40 AM Thursday, September 11, 2014
define('DB_PU_HOSTNAME', 'localhost');
define('DB_PU_USERNAME', 'root');
define('DB_PU_PASSWORD', '');
define('DB_OC_DATABASE', 'sarfe_oc');
define('DB_PU_DATABASE', 'sarfe_pu');
define('DB_BOT_DATABASE', 'sarfe_bot');
#################################################
$site_url = 'http://172.16.19.110/sarfejoo';


# error_reporting(0); //   Debug

# OpenCart  DB & Config Files

$OC_name = DB_OC_DATABASE;             // OpenCart db name
$OC_user = DB_PU_USERNAME;              // OpenCart db username
$OC_pwd = DB_PU_PASSWORD;             // OpenCart db password
$OC_host = DB_PU_HOSTNAME;           // OpenCart db hostname

$con_OC_db = mysqli_connect($OC_host, $OC_user, $OC_pwd, $OC_name) or die ('Cannot connect to OC server');
mysqli_set_charset($con_OC_db, 'utf8');
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL (OC): " . mysqli_connect_error();
}

# ProviderModel  DB & Config Files

/*define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'sarfe_oc');
define('DB_PREFIX', 'oc_');*/

$PU_name = DB_PU_DATABASE;          // ProviderModel db name
$PU_user = DB_PU_USERNAME;          // ProviderModel db username
$PU_pwd = DB_PU_PASSWORD;        // ProviderModel db password
$PU_host = DB_PU_HOSTNAME;        // ProviderModel db hostname

$con_PU_db = mysqli_connect($PU_host, $PU_user, $PU_pwd, $PU_name) or die ('Cannot connect to server');
mysqli_set_charset($con_PU_db, 'utf8');
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


$BOT_name = DB_BOT_DATABASE;          // ProviderModel db name
$PU_user = DB_PU_USERNAME;          // ProviderModel db username
$PU_pwd = DB_PU_PASSWORD;        // ProviderModel db password
$PU_host = DB_PU_HOSTNAME;        // ProviderModel db hostname

$con_BOT_db = mysqli_connect($PU_host, $PU_user, $PU_pwd, $BOT_name) or die ('Cannot connect to server');
mysqli_set_charset($con_PU_db, 'utf8');
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
mb_http_input('UTF-8');
mb_language('uni');
mb_regex_encoding('UTF-8');
ob_start('mb_output_handler');



$GLOBALS['con_PU_db'] = $con_PU_db;
$GLOBALS['con_OC_db'] = $con_OC_db;
$GLOBALS['con_BOT_db'] = $con_BOT_db;
//  Test MOd

?>