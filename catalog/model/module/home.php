<?php

require_once "provider.php";

require_once "settings.php";

class ModelModuleHome extends Model
{
    public function GetRecentSubprofilesUpdate()
    {
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $result = array();
        $sql_select_string = "SELECT tab2.id as subprofile_product_id, tab2.price as new_price, tab1.name, tab2.product_id, tab2.update_date,tab3.title,tab3.id,tab3.logo,tab3.customer_id FROM $oc_database_name.oc_product_description tab1,$pu_database_name.pu_subprofile_product tab2,$pu_database_name.pu_subprofile tab3 WHERE tab1.product_id = tab2.product_id AND tab2.subprofile_id = tab3.id ORDER BY tab2.update_date DESC LIMIT 5";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        if ($result_select)
            return $result_select;
        else
            return false;
    }
    public function GetOldPrice($subprofile_product_id)
    {
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT price FROM `pu_subprofile_product_history` WHERE subprofile_product_id = $subprofile_product_id ORDER BY `time` DESC limit 1 offset 1";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        if ($result_select)
            while($row = $result_select->fetch_assoc()) {
          	  return $row["price"];
            }
        else
            return '0';
    }
}


?>