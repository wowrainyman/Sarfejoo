<?php

require_once "provider.php";

class ModelLinkRelayExternal extends Model 
{
    public function UpdateSiteLinkViewCount ($website)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_subprofile` WHERE `website` = '$website'";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
          $sql_update_string = "UPDATE `pu_subprofile` SET
                                                                           view_count = view_count + 1 
                                                                 WHERE
                                                                            website = '$website'";
          $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
          return true;
          } else {
               return false;
          }
     }
    public function UpdateBuyLinkViewCount ($buy_link)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_subprofile_product` WHERE buy_link = '$buy_link'";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
          $sql_update_string = "UPDATE `pu_subprofile_product` SET
                                                                           view_count = view_count + 1 
                                                                 WHERE
                                                                            buy_link = '$buy_link'";
          $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
          return true;
          } else {
               return false;
          }
     }
}


