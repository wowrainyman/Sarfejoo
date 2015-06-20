<?php
require_once "settings.php";
require_once "provider.php";
class ModelFinancialPuAdvertising extends Model {
    public function getAdPlanCustomer($id){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT * FROM $pu_database_name.pu_ad_plan_customer tab1"." WHERE id = '$id'";
        $query = $this->db->query($sql);
        if(count($query->rows)>0){
            $planType = $query->rows[0]['plan_type'];
            $planId = $query->rows[0]['plan_id'];

            $sql = "SELECT * FROM $pu_database_name.pu_ad_plan_customer tab1";
            if($planType == 1){
                $sql .= " LEFT JOIN $pu_database_name.pu_ad_byclick_plan cp ON (tab1.plan_id = cp.id)";
            }elseif($planType == 2){
                $sql .= " LEFT JOIN $pu_database_name.pu_ad_byview_plan vp ON (tab1.plan_id = vp.id)";
            }elseif($planType == 3){
                $sql .= " LEFT JOIN $pu_database_name.pu_ad_bytime_plan tp ON (tab1.plan_id = tp.id)";
            }

            $sql .= " WHERE tab1.id = '$id'";
            $query = $this->db->query($sql);
            return $query->rows[0];
        }
        return false;
    }
    public function  UpdateSuccessfulAdPlanCustomer($id){
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_ad_plan_customer` WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        $data = array();
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_ad_plan_customer` SET " .
                "`is_pay`='1'".
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }
}
?>