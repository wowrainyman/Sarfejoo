<?php

require_once "../provider.php";
require_once "../settings.php";
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/15/2014
 * Time: 9:34 AM
 */

class ModelFinancialPuPlansFeatures extends Model {
    public function getPlansFeaturesValue($plan_id,$feature_id){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];

        $sql = "SELECT value FROM $pu_database_name.pu_financial_plans_features tab1 WHERE plan_id = $plan_id AND feature_id = $feature_id";

        $query = $this->db->query($sql);

        return $query->row['value'];
    }
    public function updatePlansFeaturesValue($plan_id,$feature_id,$value){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];

        $sql = "Delete FROM $pu_database_name.pu_financial_plans_features WHERE plan_id = $plan_id AND feature_id = $feature_id";

        $query = $this->db->query($sql);

        $sql = "INSERT INTO $pu_database_name.pu_financial_plans_features" .
            "(`plan_id`, `feature_id`, `value`)" .
            " VALUES ('$plan_id', '$feature_id', '$value');";
        $query = $this->db->query($sql);

        return ;
    }
} 