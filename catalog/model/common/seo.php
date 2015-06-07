<?php

require_once "provider.php";

require_once "settings.php";
/*
 * $this->load->model('connection/sms');
        $this->model_connection_sms->sendSms("9366275875",false,'Test');
 */
class ModelCommonSeo extends Model
{
    public function GetProductsByLink($buy_link)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_select_string = "SELECT * FROM `pu_subprofile_product` WHERE `buy_link` LIKE '%$buy_link%'";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        $results = array();
        while ($row = mysqli_fetch_assoc($result_select)) {
            $results[] = $row;
        }
        return $results;
    }
}

?>
