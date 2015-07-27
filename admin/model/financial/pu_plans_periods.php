<?php

require_once "../provider.php";
require_once "../settings.php";
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/15/2014
 * Time: 9:34 AM
 */

class ModelFinancialPuPlansPeriods extends Model {
    public function getPlansPeriodsValue($plan_id,$period_id){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];

        $sql = "SELECT value FROM $pu_database_name.pu_financial_plans_periods tab1 WHERE plan_id = $plan_id AND period_id = $period_id";

        $query = $this->db->query($sql);

        return $query->row['value'];
    }
    public function updatePlansPeriodsValue($plan_id,$period_id,$value){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];

        $sql = "Delete FROM $pu_database_name.pu_financial_plans_periods WHERE plan_id = $plan_id AND period_id = $period_id";

        $query = $this->db->query($sql);

        $sql = "INSERT INTO $pu_database_name.pu_financial_plans_periods" .
            "(`plan_id`, `period_id`, `value`)" .
            " VALUES ('$plan_id', '$period_id', '$value');";
        $query = $this->db->query($sql);

        return ;
    }
} 