<?php

require_once "../provider.php";
require_once "../settings.php";
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/15/2014
 * Time: 9:34 AM
 */

class ModelCustomextensionPuSubprofileComment extends Model {
    public function getTotalComment($data = array()){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT COUNT(DISTINCT id) AS total FROM $pu_database_name.pu_subprofile_comment tab1 WHERE approved = 0";
        $query = $this->db->query($sql);
        return $query->row['total'];
    }
    public function getComments($data){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT *,tab1.approved AS approved,tab1.id AS id FROM $pu_database_name.pu_subprofile_comment tab1 LEFT JOIN $oc_database_name.oc_customer tab2
                  ON(tab1.customer_id=tab2.customer_id) LEFT JOIN $pu_database_name.pu_subprofile tab3 ON(tab1.subprofile_id=tab3.id)
                  WHERE tab1.approved = 0";

        $sort_data = array();
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

    public function UpdateApproved($id,$value) {
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM $pu_database_name.pu_subprofile_comment WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE $pu_database_name.pu_subprofile_comment SET " .
                "`approved`='$value'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }
} 