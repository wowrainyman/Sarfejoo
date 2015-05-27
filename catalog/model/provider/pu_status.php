<?php
require_once "provider.php";

/**
 * Created by PhpStorm.
 * User: Amir
 * Date: 10/7/2014
 * Time: 11:31 AM
 */
 
class ModelProviderPuStatus extends Model
{

    public function GetStatus($id)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $result = array();
        $sql_select_string = "SELECT * FROM `pu_status` WHERE `id` = $id";
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
}
