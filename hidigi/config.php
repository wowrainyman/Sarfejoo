<?php 
###############################
### config.php - 10:47 AM 3/9/2015 by M.Abooali
###############################
$local = 0;
if ($local=='1') {
     $DB_host = 'localhost';
     $DB_user = 'root';
     $DB_pwd = '';
     $DB_name = 'sarfe_bot';
     $OC_DB_name = 'sarfe_oc';
     $PU_DB_name = 'sarfe_pu';
} else {
     $DB_host = 'localhost';
     $DB_user = 'manirahn_sarfe';
     $DB_pwd = '}QhNl~14E1*%';
     $DB_name = 'manirahn_sarfe_bot';
     $OC_DB_name = 'manirahn_sarfe_oc';
     $PU_DB_name = 'manirahn_sarfe_pu';
}
$link_DB = mysqli_connect($DB_host, $DB_user, $DB_pwd, $DB_name) or die ('Cannot connect to server');
mysqli_set_charset($link_DB, 'utf8');
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$link_OC_DB = mysqli_connect($DB_host, $DB_user, $DB_pwd, $OC_DB_name) or die ('Cannot connect to server');
mysqli_set_charset($link_OC_DB, 'utf8');
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$link_PU_DB = mysqli_connect($DB_host, $DB_user, $DB_pwd, $PU_DB_name) or die ('Cannot connect to server');
mysqli_set_charset($link_PU_DB, 'utf8');
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
mb_http_input('UTF-8');
mb_language('uni');
mb_regex_encoding('UTF-8');
ob_start('mb_output_handler');
?>