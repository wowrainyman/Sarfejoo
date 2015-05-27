<?php

require_once "provider.php";
require_once "settings.php";
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/15/2014
 * Time: 9:34 AM
 */

class ModelCustomextensionPuAttribute extends Model {
    public function getTotalProducts($data = array()){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];

        $sql = "SELECT COUNT(DISTINCT tab1.product_id) AS total FROM $pu_database_name.pu_product_attributetype tab1 , $oc_database_name.oc_product tab2 ,$oc_database_name.oc_product_description tab3 WHERE tab1.product_id = tab2.product_id AND tab3.product_id=tab1.product_id";

        $sql .= " AND tab3.language_id = '" . (int)$this->config->get('config_language_id') . "'";

        if (!empty($data['filter_category_id'])) {
            $sql .= " LEFT JOIN sarfe_oc." . DB_PREFIX . "product_to_category p2c ON (tab2.product_id = p2c.product_id)";
        }



        if (!empty($data['filter_name'])) {
            $sql .= " AND tab3.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
        }

        if (!empty($data['filter_model'])) {
            $sql .= " AND tab2.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
        }

        if (!empty($data['filter_type'])) {
            $sql .= " AND tab1.attribute_type LIKE '" . $this->db->escape($data['filter_type']) . "%'";
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function getProducts($data){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];

        $sql = "SELECT * FROM $pu_database_name.pu_product_attributetype tab1 , $oc_database_name.oc_product tab2 ,$oc_database_name.oc_product_description tab3 WHERE tab1.product_id = tab2.product_id AND tab3.product_id=tab1.product_id";

        $sql .= " AND tab3.language_id = '" . (int)$this->config->get('config_language_id') . "'";

        if (!empty($data['filter_category_id'])) {
            $sql .= " LEFT JOIN sarfe_oc." . DB_PREFIX . "product_to_category p2c ON (tab2.product_id = p2c.product_id)";
        }



        if (!empty($data['filter_name'])) {
            $sql .= " AND tab3.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
        }

        if (!empty($data['filter_model'])) {
            $sql .= " AND tab2.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
        }

        if (!empty($data['filter_type'])) {
            $sql .= " AND tab1.attribute_type LIKE '" . $this->db->escape($data['filter_type']) . "%'";
        }



        $sql .= " GROUP BY tab1.product_id";

        $sort_data = array(
            'tab3.name',
            'tab2.model',
            'tab1.attribute_type',
            'tab2.sort_order'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY tab3.name";
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

    public function UpdateAttributeType($id,$value) {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_product_attributetype` WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_product_attributetype` SET " .
                "`attribute_type`='$value'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }

    public function addProductAttribute($id,$value) {
        $con_PU_db = $GLOBALS['con_PU_db'];

        $sql_select_string = "SELECT * FROM `pu_product_attributetype` WHERE `product_id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            $return_id=$row['id'];
            break;
        }
        if(!$exist) {
            $sql_insert_string = "INSERT INTO `pu_product_attributetype`" .
                "(`product_id`, `attribute_type`)" .
                "VALUES ('$id', '$value');";
            $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
            $return_id = mysqli_insert_id($con_PU_db);
        } else {
            $sql_update_string = "UPDATE `pu_product_attributetype` SET " .
                "`attribute_type`='$value'" .
                " WHERE `product_id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
        }
        return $return_id;
    }

    public function isBlockAttribute($attribute_id) {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_select_string = "SELECT * FROM `pu_block` WHERE `attribute_id` = $attribute_id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            return true;
        }
        return false;
    }
} 