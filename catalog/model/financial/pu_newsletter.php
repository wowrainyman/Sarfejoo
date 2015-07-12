<?php
require_once "settings.php";
require_once "provider.php";
class ModelFinancialPuNewsletter extends Model {
    public function  UpdateSuccessfulNewsletter($customer_id,$is_pay,$invited_from){
        $con_PU_db = $GLOBALS['con_PU_db'];
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $invited_key = md5(md5($customer_id)).md5($customer_id);
        $sql_insert_string = "INSERT INTO $pu_database_name.pu_newsletter_plan_verification" .
            "(`customer_id`, `is_buy`, `invitation_key`, `invited_from`)" .
            "VALUES ('$customer_id', '$is_pay', '$invited_key','$invited_from');";
        echo $sql_insert_string;
        $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
        $id = mysqli_insert_id($con_PU_db);
        return $id;
    }
}
?>