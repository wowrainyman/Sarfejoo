<?php
require_once "provider.php";
require_once "settings.php";

class ModelProviderPuRating extends Model
{
    public function getRatingItems()
    {
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $con_PU_db = $GLOBALS['con_PU_db'];

        $sql_select_string = "SELECT * FROM `pu_rating_item` WHERE `enable` <> 0";
        $result = array();
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $result[] = $row;
        }
        return $result;
    }

    public function getSubprofileRating($subprofileid, $rating_item_id)
    {
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $con_PU_db = $GLOBALS['con_PU_db'];

        $sql_select_string = "SELECT * FROM `pu_subprofile_rating` WHERE `subprofile_id` = $subprofileid AND rating_item_id = $rating_item_id";
        $result = array();
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            return $row;
        }
        return false;
    }

    public function getUserRate($user_id, $subprofileid, $rating_item_id)
    {
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $con_PU_db = $GLOBALS['con_PU_db'];

        $sql_select_string = "SELECT * FROM `pu_user_rating` WHERE `subprofile_id` = $subprofileid AND rating_item_id = $rating_item_id AND customer_id = $user_id ";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            return $row;
        }
        return false;
    }

    public function isUserRate($user_id, $subprofile_id, $rating_item_id)
    {
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];

        $query = $this->db->query("SELECT COUNT(id) AS total FROM $pu_database_name.pu_user_rating WHERE customer_id = $user_id AND subprofile_id = $subprofile_id AND rating_item_id = $rating_item_id");

        return $query->row['total'];
    }

    public function updateUserRate($user_id, $subprofile_id, $rating_item_id, $rate)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_insert_string = "UPDATE `pu_user_rating` SET " .
            "rate = $rate WHERE customer_id = $user_id AND subprofile_id = $subprofile_id AND rating_item_id = $rating_item_id";

        $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
    }

    public function addUserRate($user_id, $subprofile_id, $rating_item_id, $rate)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_insert_string = "INSERT INTO `pu_user_rating`" .
            "(`customer_id`, `subprofile_id`, `rating_item_id`, `rate`)" .
            "VALUES ('$user_id', '$subprofile_id', '$rating_item_id', '$rate');";
        $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
        $id = mysqli_insert_id($con_PU_db);
        return $id;
    }

    public function updateSubprofileRate($subprofile_id, $rating_item_id, $rate)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];

        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_subprofile_rating` WHERE subprofile_id = $subprofile_id AND rating_item_id = $rating_item_id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_insert_string = "UPDATE `pu_subprofile_rating` SET " .
                "average = (((total_rate * average)+$rate) / (total_rate + 1)) ,total_rate = (total_rate + 1) WHERE subprofile_id = $subprofile_id AND rating_item_id = $rating_item_id";

            $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
        }else{
            $sql_insert_string = "INSERT INTO `pu_subprofile_rating`" .
                "(`subprofile_id`, `rating_item_id`, `total_rate`, `average`)" .
                "VALUES ('$subprofile_id', '$rating_item_id', '1', '$rate');";
            $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
        }
    }

    public function updateExistSubprofileRate($subprofile_id, $rating_item_id, $rate, $curRate)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_insert_string = "UPDATE `pu_subprofile_rating` SET " .
            "average = (((total_rate * average) - $curRate +$rate) / (total_rate)) WHERE subprofile_id = $subprofile_id AND rating_item_id = $rating_item_id";

        $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
    }


}

?>