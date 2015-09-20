<?php

require_once "provider.php";
require_once "settings.php";
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/15/2014
 * Time: 9:34 AM
 */

class ModelFinancialPuSubprofilePlanFree extends Model {
    public function canUserGetFreeAccount($id){
        $con_PU_db = $GLOBALS['con_PU_db'];
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT * FROM $pu_database_name.pu_customer_freeaccount tab1 WHERE customer_id = $id";
        $result_select = mysqli_query($con_PU_db, $sql) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            return false;
        }
        return true;
    }
    public function setUserFreeAccount($id){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_insert_string = "INSERT INTO $pu_database_name.pu_customer_freeaccount" .
            "(`customer_id`)" .
            " VALUES ('$id');";
        $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
        $return_id = mysqli_insert_id($con_PU_db);
        return $return_id;
    }
} 