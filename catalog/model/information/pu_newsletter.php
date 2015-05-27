<?php
require_once "settings.php";
require_once "provider.php";
class ModelInformationPuNewsletter extends Model {

    public function getRootNewsletters(){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT * FROM $pu_database_name.pu_newsletter_plan tab1 WHERE parent_id = 0";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getSubNewslettersByParent($parent_id){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT * FROM $pu_database_name.pu_newsletter_plan tab1 WHERE parent_id = $parent_id";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function addCustomerNewsletter($customer_id,$email_plans,$sms_plans,$start_date,$end_date,
                                          $price,$sms_pay_status,$email_pay_status,$first_transaction_id){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $con_PU_db = $GLOBALS['con_PU_db'];

        $sql_insert_string = "INSERT INTO $pu_database_name.pu_newsletter_plan_customer" .
            "(`customer_id`, `email_plans`, `sms_plans`, `start_date`,
                 `end_date`, `price`, `sms_pay_status`, `email_pay_status`, `first_transaction_id`)" .
            "VALUES ('$customer_id', '$email_plans', '$sms_plans','$start_date'
                ,'$end_date','$price','$sms_pay_status','$email_pay_status','$first_transaction_id');";
        echo $sql_insert_string;
        $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
        $id = mysqli_insert_id($con_PU_db);
        return $id;
    }

    public function updateCustomerNewsletter($id,$email_plans,$sms_plans){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_update_string = "UPDATE $pu_database_name.pu_newsletter_plan_customer SET " .
            "`email_plans`='$email_plans'," .
            "`sms_plans`='$sms_plans'" .
            " WHERE `id` = $id";
        $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
    }

    public function updateCustomerNewsletterSecondTransaction($id,$transaction_id){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_update_string = "UPDATE $pu_database_name.pu_newsletter_plan_customer SET " .
            "`second_transaction_id`='$transaction_id'" .
            " WHERE `id` = $id";
        $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
    }

    public function updateCustomerNewsletterPrice($id,$price){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_update_string = "UPDATE $pu_database_name.pu_newsletter_plan_customer SET " .
            "`price`='$price'" .
            " WHERE `id` = $id";
        $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
    }

    public function updateCustomerNewsletterSmsPay($id,$status){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_update_string = "UPDATE $pu_database_name.pu_newsletter_plan_customer SET " .
            "`sms_pay_status`='$status'" .
            " WHERE `id` = $id";
        $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
    }

    public function updateCustomerNewsletterEmailPay($id,$status){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_update_string = "UPDATE $pu_database_name.pu_newsletter_plan_customer SET " .
            "`email_pay_status`='$status'" .
            " WHERE `id` = $id";
        $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
    }

    public function getCustomerNewsletterInfo($customer_id){
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $sql = "SELECT * FROM $pu_database_name.pu_newsletter_plan_customer tab1 WHERE end_date > now() AND customer_id = $customer_id";
        $query = $this->db->query($sql);
        return $query->rows;
    }


}
?>