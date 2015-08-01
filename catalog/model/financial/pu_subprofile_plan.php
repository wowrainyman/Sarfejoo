<?php

require_once "provider.php";
require_once "settings.php";
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/15/2014
 * Time: 9:34 AM
 */

class ModelFinancialPuSubprofilePlan extends Model {
    public function getTotalPlans($data = array()){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];

        $sql = "SELECT COUNT(DISTINCT tab1.id) AS total FROM $pu_database_name.pu_subprofile_plans tab1 WHERE 1";

        if (!empty($data['filter_name'])) {
            $sql .= " AND tab1.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
        }
        if (!empty($data['filter_price'])) {
            $sql .= " AND tab1.price = " . $this->db->escape($data['filter_price']) . "";
        }
        if (!empty($data['filter_duration'])) {
            $sql .= " AND tab1.duration = " . $this->db->escape($data['filter_duration']) . "";
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function getPlans($type){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT * FROM $pu_database_name.pu_subprofile_plans tab1 WHERE active = 1 AND is_product = $type";
        $sql .= " ORDER BY tab1.sort_order";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getPlan($id){
        $con_PU_db = $GLOBALS['con_PU_db'];
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT * FROM $pu_database_name.pu_subprofile_plans tab1 WHERE active = 1 AND id = $id";
        $result_select = mysqli_query($con_PU_db, $sql) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            return $row;
            break;
        }
        return false;
    }

    public function UpdateSortOrder($id,$value) {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_subprofile_plans` WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_subprofile_plans` SET " .
                "`sort_order`='$value'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }

    public function UpdateName($id,$value) {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_subprofile_plans` WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_subprofile_plans` SET " .
                "`name`='$value'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }

    public function UpdateDuration($id,$value) {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_subprofile_plans` WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_subprofile_plans` SET " .
                "`duration`='$value'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }

    public function UpdatePrice($id,$value) {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_subprofile_plans` WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_subprofile_plans` SET " .
                "`price`='$value'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }

    public function UpdateActive($id,$value) {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_subprofile_plans` WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_subprofile_plans` SET " .
                "`active`='$value'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }

    public function addPlan(
        $name,
        $duration,
        $price,
        $active,
        $sort_order)
    {
        $pu_database_name = $GLOBALS['pu_database_name'];
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_insert_string = "INSERT INTO $pu_database_name.pu_subprofile_plans" .
            "(`name`, `duration`, `price`, `active`, `sort_order`)" .
            " VALUES ('$name', '$duration', '$price', '$active', '$sort_order');";
        $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
        $return_id = mysqli_insert_id($con_PU_db);
        return $return_id;
    }

} 