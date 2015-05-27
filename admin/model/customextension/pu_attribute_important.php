<?php

require_once "../provider.php";
require_once "../settings.php";
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/15/2014
 * Time: 9:34 AM
 */

class ModelCustomextensionPuAttributeImportant extends Model {
    public function getTotalImportantAttributes($data = array()){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT COUNT(DISTINCT id) AS total FROM $pu_database_name.pu_attribute_important tab1 , $oc_database_name.oc_attribute_description tab2 ,$oc_database_name.oc_product_description tab3 WHERE tab1.attribute_id = tab2.attribute_id AND tab3.product_id = tab1.product_id";
        $query = $this->db->query($sql);
        return $query->row['total'];
    }
    public function getImportantAttributes($data){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT tab1.id AS id,tab2.name AS attribute_name,tab3.name AS product_name FROM $pu_database_name.pu_attribute_important tab1 , $oc_database_name.oc_attribute_description tab2 ,$oc_database_name.oc_product_description tab3 WHERE tab1.attribute_id = tab2.attribute_id AND tab3.product_id = tab1.product_id";

        $sort_data = array(
            'tab1.id',
            'tab2.name',
            'tab3.name'
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

    public function UpdateAttributeValue($id,$value) {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_attribute_value` WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_attribute_value` SET " .
                "`value`='$value'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }

    public function addImportantAttribute($attribute_id,$product_id) {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_insert_string = "INSERT INTO `pu_attribute_important`" .
            "(`attribute_id`, `product_id`)" .
            "VALUES ('$attribute_id', '$product_id');";
        echo $sql_insert_string;
        $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
        $return_id = mysqli_insert_id($con_PU_db);
        return $return_id;
    }
} 