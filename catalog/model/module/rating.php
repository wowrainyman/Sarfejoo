<?php
require_once("provider.php");

class ModelModuleRating extends Model
{
    public function addRate($subprofile_id, $customer_id, $rate)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];

        $sql_select_string = "SELECT * FROM `pu_rating_history` WHERE `subprofile_id` ='$subprofile_id' AND `customer_id` = '$customer_id'";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            return false;
        }

        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_rating` WHERE `subprofile_id` ='$subprofile_id'";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $data = $row;
            $exist = true;
        }

        if ($exist) {
            $count = $data['count'];
            $average = $data['average'];
            $total = $count * $average;
            $count++;
            $total += $rate;
            $average = $total / $count;
            $sql_update_string = "UPDATE `pu_rating` SET " .
                "`average`='$average'" .
                ",`count`='$count'" .
                " WHERE `subprofile_id` = $subprofile_id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());

            $sql_insert_string = "INSERT INTO `pu_rating_history`" .
                "(`subprofile_id`, `customer_id`, `rate`)" .
                "VALUES ('$subprofile_id', '$customer_id', '$rate');";
            $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
            return true;
        } else {
            $sql_insert_string = "INSERT INTO `pu_rating`" .
                "(`subprofile_id`, `average`, `count`)" .
                "VALUES ('$subprofile_id', '$rate', '1');";
            $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());

            $sql_insert_string = "INSERT INTO `pu_rating_history`" .
                "(`subprofile_id`, `customer_id`, `rate`)" .
                "VALUES ('$subprofile_id', '$customer_id', '$rate');";
            $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
            return true;
        }
    }
}

?>