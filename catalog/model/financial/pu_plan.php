<?php
require_once "settings.php";

class ModelFinancialPuPlan extends Model
{
    public function getAllPeriodicPlans($target)
    {
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT * FROM $pu_database_name.pu_plan_periodic tab1 WHERE target = '$target' AND available <> 0 ORDER BY sort_order";
        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getAllOncePlans($target)
    {
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT * FROM $pu_database_name.pu_plan_once tab1 WHERE target = '$target' AND available <> 0 ORDER BY sort_order";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getPeriodicPlanInfo($id)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $result = array();

        $sql_select_string = "SELECT * FROM `pu_plan_periodic` WHERE id = $id";

        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            return $row;
        }
        return false;
    }

    public function getOncePlanInfo($id)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $result = array();

        $sql_select_string = "SELECT * FROM `pu_plan_once` WHERE id = $id";

        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            return $row;
        }
        return false;
    }

    public function addPeriodicSubprofilePlan($data)
    {
        $plan_periodic_id = $data['plan_periodic_id'];
        $subprofile_id = $data['subprofile_id'];
        $customer_id = $data['customer_id'];
        $transaction_id = $data['transaction_id'];
        $start_date = $data['start_date'];
        $price = $data['price'];
        $end_date = $data['end_date'];
        $status = $data['status'];

        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_insert_string = "INSERT INTO `pu_plan_periodic_subprofile`" .
            "(`plan_periodic_id`, `subprofile_id`, `customer_id`, `transaction_id`, `start_date`, `price`, `end_date`, `status`)" .
            "VALUES ('$plan_periodic_id', '$subprofile_id', '$customer_id', '$transaction_id', '$start_date', '$price', '$end_date', '$status');";
        echo $sql_insert_string;
        $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
        $id = mysqli_insert_id($con_PU_db);
        return $id;
    }

    public function addOnceSubprofilePlan($data)
    {
        $plan_once_id = $data['plan_once_id'];
        $subprofile_id = $data['subprofile_id'];
        $customer_id = $data['customer_id'];
        $transaction_id = $data['transaction_id'];
        $start_date = $data['start_date'];
        $price = $data['price'];
        $status = $data['status'];
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_insert_string = "INSERT INTO `pu_plan_once_subprofile`" .
            "(`plan_once_id`, `subprofile_id`, `customer_id`, `transaction_id`, `date`, `price`, `status`)" .
            "VALUES ('$plan_once_id', '$subprofile_id', '$customer_id', '$transaction_id', '$start_date', '$price', '$status');";
        echo $sql_insert_string;
        $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
        $id = mysqli_insert_id($con_PU_db);
        return $id;
    }

    public function addPeriodicProductPlan($data)
    {
        $plan_periodic_id = $data['plan_periodic_id'];
        $subprofile_product_id = $data['subprofile_product_id'];
        $customer_id = $data['customer_id'];
        $transaction_id = $data['transaction_id'];
        $start_date = $data['start_date'];
        $price = $data['price'];
        $end_date = $data['end_date'];
        $status = $data['status'];

        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_insert_string = "INSERT INTO `pu_plan_periodic_product`" .
            "(`plan_periodic_id`, `subprofile_product_id`, `customer_id`, `transaction_id`, `start_date`, `price`, `end_date`, `status`)" .
            "VALUES ('$plan_periodic_id', '$subprofile_product_id', '$customer_id', '$transaction_id', '$start_date', '$price', '$end_date', '$status');";
        echo $sql_insert_string;
        $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
        $id = mysqli_insert_id($con_PU_db);
        return $id;
    }

    public function addOnceProductPlan($data)
    {
        $plan_once_id = $data['plan_once_id'];
        $subprofile_product_id = $data['subprofile_product_id'];
        $customer_id = $data['customer_id'];
        $transaction_id = $data['transaction_id'];
        $start_date = $data['start_date'];
        $price = $data['price'];
        $status = $data['status'];
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_insert_string = "INSERT INTO `pu_plan_once_product`" .
            "(`plan_once_id`, `subprofile_product_id`, `customer_id`, `transaction_id`, `date`, `price`, `status`)" .
            "VALUES ('$plan_once_id', '$subprofile_product_id', '$customer_id', '$transaction_id', '$start_date', '$price', '$status');";
        echo $sql_insert_string;
        $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
        $id = mysqli_insert_id($con_PU_db);
        return $id;
    }

}

?>