<?php
require_once "settings.php";
require_once "provider.php";
class ModelAdPuAdvertising extends Model {

    public function getClickPlans(){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT * FROM $pu_database_name.pu_ad_byclick_plan tab1 WHERE enable <> 0";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getViewPlans(){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT * FROM $pu_database_name.pu_ad_byview_plan tab1 WHERE enable <> 0";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getTimePlans(){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT * FROM $pu_database_name.pu_ad_bytime_plan tab1 WHERE enable <> 0";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getClickPlanInfo($id){

        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT * FROM $pu_database_name.pu_ad_byclick_plan tab1 WHERE enable <> 0 AND id = $id";

        $con_PU_db = $GLOBALS['con_PU_db'];
        $result_select = mysqli_query($con_PU_db, $sql) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            return $row;
        }
    }

    public function getViewPlanInfo($id){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT * FROM $pu_database_name.pu_ad_byview_plan tab1 WHERE enable <> 0 AND id = $id";
        $con_PU_db = $GLOBALS['con_PU_db'];
        $result_select = mysqli_query($con_PU_db, $sql) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            return $row;
        }
    }

    public function getTimePlanInfo($id){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT * FROM $pu_database_name.pu_ad_bytime_plan tab1 WHERE enable <> 0 AND id = $id";
        $con_PU_db = $GLOBALS['con_PU_db'];
        $result_select = mysqli_query($con_PU_db, $sql) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            return $row;
        }
    }

    public function getPositionAvailableDate($position_id){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT IFNULL(MAX(end_date),0) AS date FROM $pu_database_name.pu_ad_plan_customer WHERE position_id = $position_id AND plan_type = 3 ORDER BY end_date DESC LIMIT 1";
        $query = $this->db->query($sql);
        return $query->row['date'];
    }


    public function getPositions(){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT * FROM $pu_database_name.pu_ad_position tab1";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getPositionInfo($id){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT * FROM $pu_database_name.pu_ad_position tab1 WHERE id = $id";
        $con_PU_db = $GLOBALS['con_PU_db'];
        $result_select = mysqli_query($con_PU_db, $sql) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            return $row;
        }
    }


    public function AddAdPlanCustomer(
        $customer_id,
        $plan_type,
        $plan_id,
        $file_90_728,
        $file_60_468,
        $file_240_120,
        $file_125_125,
        $dest_click,
        $dest_view,
        $start_date,
        $end_date,
        $transaction_id,
        $position_id){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_insert_string = "INSERT INTO `pu_ad_plan_customer`" .
            "(`customer_id`, `plan_type`, `plan_id`, `file_90_728`, `file_60_468`, `file_240_120`, `file_125_125`,
                 `dest_click`, `dest_view`,
                 `start_date`, `end_date`,
                  `transaction_id`,`position_id`)" .
            "VALUES ('$customer_id', '$plan_type', '$plan_id','$file_90_728','$file_60_468','$file_240_120','$file_125_125'
                ,'$dest_click','$dest_view','$start_date'
                ,'$end_date','$transaction_id','$position_id');";

        $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
        $id = mysqli_insert_id($con_PU_db);
        return $id;
    }

    public function getUserAds($customer_id){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT * FROM $pu_database_name.pu_ad_plan_customer tab1 WHERE customer_id = $customer_id";
        $query = $this->db->query($sql);
        return $query->rows;
    }
}
?>