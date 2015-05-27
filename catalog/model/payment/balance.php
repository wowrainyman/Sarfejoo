<?php
require_once "provider.php";
class ModelPaymentBalance extends Model {
	public function getBalance($customer_id) {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_select_string = "SELECT * FROM `pu_balance` WHERE `customer_id` = $customer_id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            return $row;
        }
        return false;
	}
}
?>