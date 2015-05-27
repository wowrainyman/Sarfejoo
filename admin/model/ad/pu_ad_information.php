<?php
require_once "../provider.php";
require_once "../settings.php";
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/15/2014
 * Time: 9:34 AM
 */
class ModelAdPuAdInformation extends Model {
    public function getTotalPlanCustomers($data = array()){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT COUNT(DISTINCT tab1.id) AS total FROM $pu_database_name.pu_ad_plan_customer tab1 LEFT JOIN $oc_database_name.oc_customer tab2 ON(tab1.customer_id = tab2.customer_id) WHERE 1";
        if (!empty($data['filter_customer_name'])) {
            $sql .= " AND CONCAT(tab2.firstname, ' ', tab2.lastname) LIKE '%" . $this->db->escape($data['filter_customer_name']) . "%'";
        }
        if (!empty($data['filter_plan_type'])) {
            $sql .= " AND tab1.plan_type = " . $this->db->escape($data['filter_plan_type']) . "";
        }
        if (!empty($data['filter_position_id'])) {
            $sql .= " AND tab1.position_id  = " . $this->db->escape($data['filter_position_id']) . "";
        }
        $query = $this->db->query($sql);
        return $query->row['total'];
    }
    public function getPlanCustomers($data){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT *,CONCAT(tab2.firstname, ' ', tab2.lastname) AS name,tab1.id AS id FROM $pu_database_name.pu_ad_plan_customer tab1 LEFT JOIN $oc_database_name.oc_customer tab2 ON(tab1.customer_id = tab2.customer_id) WHERE 1";
        if (!empty($data['filter_customer_name'])) {
            $sql .= " AND CONCAT(tab2.firstname, ' ', tab2.lastname) LIKE '%" . $this->db->escape($data['filter_customer_name']) . "%'";
        }
        if (!empty($data['filter_plan_type'])) {
            $sql .= " AND tab1.plan_type = " . $this->db->escape($data['filter_plan_type']) . "";
        }
        if (!empty($data['filter_position_id'])) {
            $sql .= " AND tab1.position_id  = " . $this->db->escape($data['filter_position_id']) . "";
        }
        $sql .= " GROUP BY tab1.id";
        $sort_data = array(
            'tab1.id',
            'tab2.lastname',
            'tab1.plan_type',
            'tab1.dest_click',
            'tab1.current_click',
            'tab1.dest_view',
            'tab1.current_view',
            'tab1.start_date',
            'tab1.end_date',
            'tab1.transaction_id',
            'tab1.status_id',
            'tab1.periority',
            'tab1.position_id'
        );
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY tab1.id";
        }
        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }
        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }
            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }
            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }
        $query = $this->db->query($sql);
        return $query->rows;
    }
    public function UpdateStatusId($id,$value) {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_ad_plan_customer` WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_ad_plan_customer` SET " .
                "`status_id`='$value'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }
    public function UpdatePeriority($id,$value) {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_ad_plan_customer` WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_ad_plan_customer` SET " .
                "`periority`='$value'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }
} 