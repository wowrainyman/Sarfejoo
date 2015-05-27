<?php

require_once "provider.php";
require_once "settings.php";

/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/15/2014
 * Time: 9:34 AM
 */
class ModelCustomextensionPuBlock extends Model
{
    public function getTotalBlocks($data = array())
    {
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT COUNT(tab1.id) AS total FROM $pu_database_name.pu_block tab1";

        $hasWhere = false;

        if (!empty($data['filter_block_name'])) {
            $sql .= " WHERE tab1.block_name LIKE '%" . $data['filter_block_name'] . "%'";
            $hasWhere=true;
        }

        if (!empty($data['filter_attribute_id'])) {
            if($hasWhere) {
                $sql .= " AND tab1.attribute_id = '" . $data['filter_attribute_id'] . "'";
            }else{
                $sql .= " WHERE tab1.attribute_id = '" . $data['filter_attribute_id'] . "'";
            }
        }
        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function getBlock($id)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $pu_database_name = $GLOBALS['pu_database_name'];
        $sql_select_string = "SELECT * FROM $pu_database_name.pu_block WHERE attribute_id = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            return $row;
            break;
        }
    }

    public function getBlocks($data)
    {
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT * FROM $pu_database_name.pu_block tab1";
        $hasWhere = false;
        if (!empty($data['filter_block_name'])) {
            $sql .= " WHERE tab1.block_name LIKE '%" . $data['filter_block_name'] . "%'";
            $hasWhere=true;
        }
        if (!empty($data['filter_attribute_id'])) {
            if($hasWhere) {
                $sql .= " AND tab1.attribute_id = '" . $data['filter_attribute_id'] . "'";
            }else{
                $sql .= " WHERE tab1.attribute_id = '" . $data['filter_attribute_id'] . "'";
            }
        }
        $sql .= " GROUP BY tab1.id";
        $sort_data = array(
            'tab1.block_name',
            'tab1.attribute_id'
        );
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY tab1.block_name";
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

    public function updateBlockName($id, $value)
    {
        $pu_database_name = $GLOBALS['pu_database_name'];
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM $pu_database_name.pu_block WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE $pu_database_name.pu_block SET " .
                "`block_name`='$value'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }

    public function addBlock($attribute_id, $block_name)
    {
        $pu_database_name = $GLOBALS['pu_database_name'];
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_insert_string = "INSERT INTO $pu_database_name.pu_block" .
            "(`attribute_id`, `block_name`)" .
            "VALUES ('$attribute_id', '$block_name');";
        $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
        $return_id = mysqli_insert_id($con_PU_db);
        return $return_id;
    }
} 