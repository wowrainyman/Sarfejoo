<?php
require_once "settings.php";
require_once "provider.php";
class ModelFinancialPuInvoice extends Model {
    public function addInvoice($plan_periodic_id,$plan_once_id,$type,$related_id,$customer_id){
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_insert_string = "INSERT INTO `pu_invoice`" .
            "(`plan_periodic_id`, `plan_once_id`, `type`, `related_id`, `customer_id`)" .
            "VALUES ('$plan_periodic_id', '$plan_once_id', '$type', '$related_id', '$customer_id');";
        echo $sql_insert_string;
        $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
        $id = mysqli_insert_id($con_PU_db);
        return $id;
    }

    public function getCustomerInvoices($customer_id){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT * FROM $pu_database_name.pu_invoice tab1 WHERE customer_id = '$customer_id' AND is_payed <> 1";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function delete($id){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "DELETE FROM $pu_database_name.pu_invoice WHERE id = '$id'";
        $query = $this->db->query($sql);
    }

    public function PayedInvoice($id,$date){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "UPDATE $pu_database_name.pu_invoice SET " .
            "`is_payed`='1'," .
            "`payed_time`='$date' " .
            " WHERE `id` = $id";
        $query = $this->db->query($sql);
    }
}
?>