<?php

require_once "provider.php";
require_once "settings.php";
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/15/2014
 * Time: 9:34 AM
 */

class ModelFinancialPuFeatureBasedPlan extends Model {
    public function getPlans(){

        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT * FROM $pu_database_name.pu_financial_plans tab1 WHERE enabled = 1 ORDER BY sort_order LIMIT 0,4";

        $query = $this->db->query($sql);

        return $query->rows;

    }
    public function getPlan($plan_id){

        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT * FROM $pu_database_name.pu_financial_plans tab1 WHERE id = $plan_id AND enabled = 1 ORDER BY sort_order LIMIT 0,4";

        $query = $this->db->query($sql);

        return $query->rows[0];

    }
    public function getFeatures(){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT * FROM $pu_database_name.pu_financial_features tab1 WHERE enabled = 1 ORDER BY sort_order";

        $query = $this->db->query($sql);

        return $query->rows;

    }
    public function getFeature($feature_id){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT * FROM $pu_database_name.pu_financial_features tab1 WHERE id = $feature_id AND enabled = 1 ORDER BY sort_order";

        $query = $this->db->query($sql);

        return $query->rows[0];

    }
    public function getPeriods(){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT * FROM $pu_database_name.pu_financial_periods tab1 WHERE enabled = 1 ORDER BY sort_order";

        $query = $this->db->query($sql);

        return $query->rows;

    }
    public function getPeriod($period_id){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT * FROM $pu_database_name.pu_financial_periods tab1 WHERE id = $period_id AND enabled = 1 ORDER BY sort_order";

        $query = $this->db->query($sql);

        return $query->rows[0];

    }
    public function getPlanFeatureValue($plan_id,$feature_id){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT value FROM $pu_database_name.pu_financial_plans_features WHERE plan_id = $plan_id AND feature_id = $feature_id";

        $query = $this->db->query($sql);

        return $query->rows[0];

    }
    public function getPlanPeriodValue($plan_id,$period_id){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT value FROM $pu_database_name.pu_financial_plans_periods WHERE plan_id = $plan_id AND period_id = $period_id";

        $query = $this->db->query($sql);

        return $query->rows;

    }
    public function addSubprofileHistory($customer_id,
            $subprofile_id,
            $plan_id,
            $period_id,
            $payed_price,
            $period_duration,
            $transaction_id,
            $is_payed){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_insert_string = "INSERT INTO $pu_database_name.pu_financial_subprofile_history" .
            "(`customer_id`, `subprofile_id`, `plan_id`, `period_id`, `date`, `payed_price`, `period_duration`, `transaction_id`, `is_payed`)" .
            " VALUES ('$customer_id', '$subprofile_id', '$plan_id', '$period_id', NOW(), '$payed_price', '$period_duration', '$transaction_id', '$is_payed');";
        $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
        $return_id = mysqli_insert_id($con_PU_db);
        return $return_id;

    }
    public function getHistoryByTransactionId($transaction_id){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT * FROM $pu_database_name.pu_financial_subprofile_history WHERE transaction_id = $transaction_id";

        $query = $this->db->query($sql);

        return $query->rows[0];

    }
    public function updateSuccessfulPayHistory($id){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "UPDATE $pu_database_name.pu_financial_subprofile_history SET " .
            "`is_payed`='1'" .
            " WHERE `id` = $id";

        $query = $this->db->query($sql);

        return 1;

    }
    public function addSubprofileFeatureValue($subprofile_id,$feature_id,$value){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "DELETE FROM $pu_database_name.pu_financial_plans_features_subprofiles WHERE subprofile_id = $subprofile_id AND feature_id = $feature_id";

        $query = $this->db->query($sql);
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_insert_string = "INSERT INTO $pu_database_name.pu_financial_plans_features_subprofiles" .
            "(`subprofile_id`, `feature_id`, `start_value`, `current_value`)" .
            " VALUES ('$subprofile_id', '$feature_id', '$value', '$value');";
        $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
        $return_id = mysqli_insert_id($con_PU_db);
        return $return_id;

    }
} 