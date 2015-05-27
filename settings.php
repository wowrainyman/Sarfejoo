<?php
/**
 * Created by PhpStorm.
 * User: Amir
 * Date: 11/24/2014
 * Time: 1:41 PM
 */
/**
 */
/* Here we have online mode settings we should comment them in local */
$GLOBALS['providers_scans_folder'] = $_SERVER['DOCUMENT_ROOT'] . "/ProvidersScans";
$GLOBALS['pu_database_name'] = "manirahn_sarfe_pu";
$GLOBALS['oc_database_name'] = "manirahn_sarfe_oc";


/**
 */
/* Here we have local settings we should comment them in online mode */
$GLOBALS['providers_scans_folder'] = $_SERVER['DOCUMENT_ROOT'] . "/sarfejoo" . "/ProvidersScans";
$GLOBALS['pu_database_name'] = "sarfe_pu";
$GLOBALS['oc_database_name'] = "sarfe_oc";


/*
 *
 * Here we have settings for both
 */
$GLOBALS['JAHANPAY_API_KEY'] = "gt24713g766";
$GLOBALS['sms_username'] = "sarfejoo";
$GLOBALS['sms_password'] = "joo@123";
$GLOBALS['sms_number'] = "10000072733566";
?>