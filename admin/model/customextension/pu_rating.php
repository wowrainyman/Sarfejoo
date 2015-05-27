<?php

require_once "../provider.php";
require_once "../settings.php";
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/15/2014
 * Time: 9:34 AM
 */

class ModelCustomextensionPuRating extends Model {
    public function getTotalRating($data = array()){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];

        $sql = "SELECT COUNT(DISTINCT tab1.id) AS total FROM $pu_database_name.pu_rating_item tab1 WHERE 1";

        if (!empty($data['filter_name'])) {
            $sql .= " AND tab1.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function getRatings($data){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];

        $sql = "SELECT * FROM $pu_database_name.pu_rating_item tab1 WHERE 1";

        if (!empty($data['filter_name'])) {
            $sql .= " AND tab1.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
        }
        $sql .= " GROUP BY tab1.id";

        $sort_data = array(
            'tab1.name',
            'tab1.enable'
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

    public function UpdateName($id,$value) {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_rating_item` WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_rating_item` SET " .
                "`name`='$value'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }

    public function UpdateEnable($id,$value) {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_rating_item` WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_rating_item` SET " .
                "`enable`='$value'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }

    public function addRating(
        $name,
        $enable)
    {
        $pu_database_name = $GLOBALS['pu_database_name'];
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_insert_string = "INSERT INTO $pu_database_name.pu_rating_item" .
            "(`name`, `enable`)" .
            " VALUES ('$name', '$enable');";
        echo $sql_insert_string;
        $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
        $return_id = mysqli_insert_id($con_PU_db);
        return $return_id;
    }

} 