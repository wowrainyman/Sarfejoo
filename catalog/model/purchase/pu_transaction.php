<?php
require_once "provider.php";

/**
 * Created by PhpStorm.
 * User: Sarfejoo1
 * Date: 10/15/2014
 * Time: 8:35 AM
 */
class ModelPurchasePuTransaction extends Model
{
    public function GetGateways()
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_select_string = "SELECT * FROM `pu_gateway` WHERE `is_enable` = 1";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        $gate_ways = array();
        while ($row = mysqli_fetch_assoc($result_select)) {
            $gate_ways[] = $row;
        }
        return $gate_ways;
    }

    public function AddTransaction($data)
    {
        //if rebate type = 0 add rebate for subprofile and if rebate type  =1 add rebate for a product
        $con_PU_db = $GLOBALS['con_PU_db'];
        $customer_id = $data["customer_id"];
        $payment_gateway_id = $data["payment_gateway_id"];
        $value = $data["value"];
        $successful = 0;
        $sql_insert_string = "INSERT INTO `pu_transaction`" .
            "(`customer_id`, `payment_gateway_id`, `value`,`successful`)" .
            "VALUES ('$customer_id', '$payment_gateway_id', '$value','$successful');";
        $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
        $id = mysqli_insert_id($con_PU_db);
        return $id;
    }

    public function GetTransactionInfo($transaction_id)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_select_string = "SELECT * FROM `pu_transaction` WHERE `id` = $transaction_id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            return $row;
        }
    }
    public function getTransactionByTransactionGatewayId($transaction_gateway_id)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_select_string = "SELECT * FROM `pu_transaction` WHERE `transaction_gateway_id` = $transaction_gateway_id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            return $row;
        }
    }
    public function getTransactionByToken($token)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_select_string = "SELECT * FROM `pu_transaction` WHERE `token` = '$token'";
        echo $sql_select_string;
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            return $row;
        }
    }
    public function UpdateTransactionGatewayId($id, $transaction_gateway_id)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_transaction` WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_transaction` SET " .
                "`transaction_gateway_id`='$transaction_gateway_id'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }
    public function UpdateToken($id, $token)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_transaction` WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_transaction` SET " .
                "`token`='$token'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }
    public function UpdateStoreTrackingNumber($id, $store_tracking_number)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_transaction` WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_transaction` SET " .
                "`store_tracking_number`='$store_tracking_number'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }
    public function UpdateCustomerBalance($customer_id, $amount)
    {
        $date = new DateTime();
        $date = date('Y-m-d H:i:s',$date->getTimestamp());
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_balance` WHERE `customer_id` = $customer_id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        $data=array();
        while ($row = mysqli_fetch_assoc($result_select)) {
            $data = $row;
            $exist = true;
            break;
        }
        if ($exist) {
            $amountb = $data['balance'];
            $amount = $amount + $amountb;
            $sql_update_string = "UPDATE `pu_balance` SET " .
                "`balance`=$amount" .
                ",`lastactivity`='$date'" .
                " WHERE `customer_id` = $customer_id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
        } else {
            $sql_insert_string = "INSERT INTO `pu_balance`" .
                "(`customer_id`, `balance` , `lastactivity`)" .
                "VALUES ('$customer_id', '$amount' , '$date');";
            $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
            $id = mysqli_insert_id($con_PU_db);
        }
    }


    public function UpdateSuccessfulTransaction($id)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_transaction` WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        $data = array();
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            $data = $row;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_transaction` SET " .
                "`successful`='1'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }

    public function AddBuyTransaction($customer_id,$value,$transaction_type)
    {
        //if rebate type = 0 add rebate for subprofile and if rebate type  =1 add rebate for a product
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_insert_string = "INSERT INTO `pu_transaction`" .
            "(`customer_id`, `value`, `transaction_type`)" .
            "VALUES ('$customer_id', '$value', '$transaction_type');";
        $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
        $id = mysqli_insert_id($con_PU_db);
        return $id;
    }
}

?>