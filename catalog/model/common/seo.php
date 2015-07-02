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
        $sql_select_string = "SELECT * FROM `pu_subprofile_product`  LEFT JOIN `pu_subprofile_verification` ON pu_subprofile_product.subprofile_id = `pu_subprofile_verification`.subprofile_id  LEFT JOIN `pu_subprofile` ON pu_subprofile.id = `pu_subprofile_product`.subprofile_id WHERE `buy_link` LIKE '%$buy_link%' AND `pu_subprofile_product`.status_id <> 0 AND (`pu_subprofile_product`.price <> 0 OR `pu_subprofile_product`.guarantee_price <> 0) AND ((`pu_subprofile_verification`.expire_date > CURDATE()) OR `pu_subprofile`.financial_exception = 1) AND `pu_subprofile_product`.`update_date` > DATE_SUB(CURDATE(), INTERVAL 60 DAY) AND(`pu_subprofile_product`.`availability` = 0 or`pu_subprofile_product`.`availability` = 2)";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        $results = array();
        while ($row = mysqli_fetch_assoc($result_select)) {
            $results[] = $row;
        }
        return $results;
    }
}

?>
