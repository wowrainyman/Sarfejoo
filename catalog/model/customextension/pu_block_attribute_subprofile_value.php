<?php

require_once "provider.php";
require_once "settings.php";

/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/15/2014
 * Time: 9:34 AM
 */
class ModelCustomextensionPuBlockAttributeSubprofileValue extends Model
{
    public function add($subprofile_id,$product_id,$block_attribute_id,$value,$row){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_insert_string = "INSERT INTO $pu_database_name.pu_block_attribute_subprofile_value" .
            "(`subprofile_id`, `product_id`, `block_attribute_id`, `value`, `row`)" .
            "VALUES ('$subprofile_id', '$product_id', '$block_attribute_id', '$value', '$row');";
        $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
        $return_id = mysqli_insert_id($con_PU_db);
        return $return_id;
    }

    public function maxRow()
    {
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT MAX(row) AS maximum FROM $pu_database_name.pu_block_attribute_subprofile_value";
        $query = $this->db->query($sql);
        return $query->row['maximum'];
    }

    public function get($subprofile_id,$product_id,$block_attribute_id)
    {

        $con_PU_db = $GLOBALS['con_PU_db'];
        $pu_database_name = $GLOBALS['pu_database_name'];
        $sql_select_string = "SELECT * FROM $pu_database_name.pu_block_attribute_subprofile_value AS basv LEFT JOIN $pu_database_name.pu_block_attribute AS ba ON basv.block_attribute_id = ba.id LEFT JOIN $pu_database_name.pu_block ON ba.block_id = $pu_database_name.pu_block.id  WHERE `subprofile_id` = $subprofile_id AND `product_id` = $product_id AND $pu_database_name.pu_block.attribute_id = $block_attribute_id ORDER BY basv.row";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        $result = array();
        while ($row = mysqli_fetch_assoc($result_select)) {
            $result[] = $row;
        }
        return $result;
    }

} 