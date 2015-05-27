<?php

require_once "provider.php";
require_once "settings.php";

/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/15/2014
 * Time: 9:34 AM
 */
class ModelCustomextensionPuBlockAttribute extends Model
{
    public function getTotalBlockAttributes($data = array())
    {
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT COUNT(tab1.id) AS total FROM $pu_database_name.pu_block_attribute tab1";

        $hasWhere = false;

        if (!empty($data['filter_subattribute_name'])) {
            $sql .= " WHERE tab1.subattribute_name LIKE '%" . $data['filter_subattribute_name'] . "%'";
            $hasWhere=true;
        }

        if (!empty($data['filter_block_id'])) {
            if($hasWhere) {
                $sql .= " AND tab1.block_id = '" . $data['filter_block_id'] . "'";
            }else{
                $sql .= " WHERE tab1.block_id = '" . $data['filter_block_id'] . "'";
                $hasWhere=true;
            }
        }

        if (!empty($data['filter_type'])) {
            if($hasWhere) {
                $sql .= " AND tab1.type LIKE '%" . $data['filter_type'] . "%'";
            }else{
                $sql .= " WHERE tab1.type LIKE '%" . $data['filter_type'] . "%'";
                $hasWhere=true;
            }
        }
        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function getBlockAttribute($id)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $pu_database_name = $GLOBALS['pu_database_name'];
        $sql_select_string = "SELECT * FROM $pu_database_name.pu_block_attribute WHERE id = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            return $row;
            break;
        }
    }

    public function getBlockAttributes($data)
    {
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT * FROM $pu_database_name.pu_block_attribute tab1";
        $hasWhere = false;
        if (!empty($data['filter_subattribute_name'])) {
            $sql .= " WHERE tab1.subattribute_name LIKE '%" . $data['filter_subattribute_name'] . "%'";
            $hasWhere=true;
        }
        if (!empty($data['filter_block_id'])) {
            if($hasWhere) {
                $sql .= " AND tab1.block_id = '" . $data['filter_block_id'] . "'";
            }else{
                $sql .= " WHERE tab1.block_id = '" . $data['filter_block_id'] . "'";
            }
        }
        $sql .= " GROUP BY tab1.id";
        $sort_data = array(
            'tab1.subattribute_name',
            'tab1.block_id'
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

    public function getSubAttributes($block_id)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $pu_database_name = $GLOBALS['pu_database_name'];
        $sql_select_string = "SELECT * FROM $pu_database_name.pu_block_attribute WHERE block_id = $block_id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        $result = array();
        while ($row = mysqli_fetch_assoc($result_select)) {
            $result[] = $row;
        }
        return $result;
    }

    public function updateSubattributeName($id, $value)
    {
        $pu_database_name = $GLOBALS['pu_database_name'];
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM $pu_database_name.pu_block_attribute WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE $pu_database_name.pu_block_attribute SET " .
                "`subattribute_name`='$value'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }

    public function updateType($id, $value)
    {
        $pu_database_name = $GLOBALS['pu_database_name'];
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM $pu_database_name.pu_block_attribute WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE $pu_database_name.pu_block_attribute SET " .
                "`type`='$value'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }

    public function addBlockAttribute($block_id, $subattribute_name, $type)
    {
        $pu_database_name = $GLOBALS['pu_database_name'];
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_insert_string = "INSERT INTO $pu_database_name.pu_block_attribute" .
            "(`block_id`, `subattribute_name`, `type`)" .
            "VALUES ('$block_id', '$subattribute_name', '$type');";
        echo $sql_insert_string;
        $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
        $return_id = mysqli_insert_id($con_PU_db);
        return $return_id;
    }
} 