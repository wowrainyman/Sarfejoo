<?php
require_once "provider.php";

/**
 * Created by PhpStorm.
 * User: Amir
 * Date: 10/7/2014
 * Time: 11:31 AM
 */
class ModelProviderPuCustomer extends Model
{

    public function GetCustomer($id)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $result = array();
        $sql_select_string = "SELECT * FROM `pu_customer` WHERE `customer_id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            $result = $row;
            break;
        }

        if ($exist)
            return $result;
        else
            return false;
    }

    public function EditCustomer_nationalcardstamp($nationalcardstamp,$customer_id)
    {

        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT `customer_id` FROM `pu_customer` WHERE `customer_id` = $customer_id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_customer` SET " .
                "`nationalcardstamp`='$nationalcardstamp'" .
                " WHERE `customer_id` = $customer_id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
        }
        else {
            return false;
        }
        return true;
    }

    public function EditCustomer_approvementstamp($approvementstamp,$customer_id)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT `customer_id` FROM `pu_customer` WHERE `customer_id` = $customer_id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_customer` SET " .
                "`approvementstamp`='$approvementstamp'" .
                " WHERE `customer_id` = $customer_id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
        }
        else {
            return false;
        }
        return true;
    }

    public function EditCustomer_agreementstamp($agreementstamp,$customer_id)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT `customer_id` FROM `pu_customer` WHERE `customer_id` = $customer_id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_customer` SET " .
                "`agreementstamp`='$agreementstamp'" .
                " WHERE `customer_id` = $customer_id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
        }
        else {
            return false;
        }
        return true;
    }
// Milad > birthday
public function EditCustomer_birthday($birthday,$customer_id)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT `birthday` FROM `pu_customer` WHERE `customer_id` = $customer_id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_customer` SET " .
                "`birthday`='$birthday'" .
                " WHERE `customer_id` = $customer_id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
        }
        else {
            return false;
        }
        return true;
    }
    
    public function EditCustomer_status_id($status_id,$customer_id)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT `customer_id` FROM `pu_customer` WHERE `customer_id` = $customer_id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_customer` SET " .
                "`status_id`='$status_id'" .
                " WHERE `customer_id` = $customer_id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
        }
        else {
            return false;
        }
        return true;
    }

    public function EditCustomer_user_id($user_id,$customer_id)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT `customer_id` FROM `pu_customer` WHERE `customer_id` = $customer_id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_customer` SET " .
                "`user_id`='$user_id'" .
                " WHERE `customer_id` = $customer_id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
        }
        else {
            return false;
        }
        return true;
    }

    public function EditCustomer_adminmessage($adminmessage,$customer_id)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT `customer_id` FROM `pu_customer` WHERE `customer_id` = $customer_id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_customer` SET " .
                "`adminmessage`='$adminmessage'" .
                " WHERE `customer_id` = $customer_id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
        }
        else {
            return false;
        }
        return true;
    }

    public function EditCustomer($data)
    {
        $this->load->model('account/customer');
        $con_PU_db = $GLOBALS['con_PU_db'];
        $id = $this->customer->getId();

        $nationalcode = $data['nationalcode'];
        $birthplace = $data['birthplace'];
        $fathername = $data['fathername'];

        $exist = false;
        $sql_select_string = "SELECT `customer_id` FROM `pu_customer` WHERE `customer_id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_customer` SET " .
                "`nationalcode`='$nationalcode'" .
                ",`birthplace`='$birthplace'" .
                ",`fathername`='$fathername'" .
                " WHERE `customer_id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
        } else {
            $sql_insert_string = "INSERT INTO `sarfe_pu`.`pu_customer`" .
                "(`customer_id`, `nationalcode`, `birthplace`, `fathername`)" .
                "VALUES ('$id', '$nationalcode', '$birthplace','$fathername');";
            $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
        }

    }
}
