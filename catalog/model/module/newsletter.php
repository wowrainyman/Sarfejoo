<?php
require_once "provider.php";
class ModelModuleNewsletter extends Model {
    public function insert($data) {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $email = $data['email'];
        if(isset($data['subject']))
            $subject = $data['subject'];
        else
            $subject="";
        if(isset($data['mobile']))
            $mobile = $data['mobile'];
        else
            $mobile="";
        if(isset($data['isemail']))
            $isemail = $data['isemail'];
        else
            $isemail=true;
        if(isset($data['ismobile']))
            $ismobile = $data['ismobile'];
        else
            $ismobile=true;
        if(isset($data['expiretime']))
            $expiretime = $data['expiretime'];
        else
            $expiretime='';

        $sql_insert_string = "INSERT INTO `pu_newsletter`" .
            "(`email`, `subject`, `mobile`, `isemail`, `ismobile`)" .
            "VALUES ('$email', '$subject', '$mobile', '$isemail', '$ismobile');";
        $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
        $id = mysqli_insert_id($con_PU_db);
        return $id;
    }

    public function select($data) {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $email=$data['email'];
        $subject=$data['subject'];
        $sql_select_string = "SELECT * FROM `pu_newsletter` WHERE `email` ='$email' AND `subject` = '$subject'";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            return true;
        }
        return false;
    }
}
?>