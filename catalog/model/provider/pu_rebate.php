<?php
require_once "provider.php";

/**
 * Created by PhpStorm.
 * User: Sarfejoo1
 * Date: 10/15/2014
 * Time: 8:35 AM
 */
class ModelProviderPuRebate extends Model
{
    public function AddRebate($data,$rebatetype)
    {
        //if rebate type = 0 add rebate for subprofile and if rebate type  =1 add rebate for a product
        $con_PU_db = $GLOBALS['con_PU_db'];
        $product_id=$data["product_id"];
        $subprofile_id=$data["subprofile_id"];
        $title=$data["title"];
        $startdate=$data["startdate"];
        $enddate=$data["enddate"];
        $percent=$data["percent"];
        $destination_id=$subprofile_id;
        if($rebatetype) {
            $destination_id=$product_id;
        }
        $sql_insert_string = "INSERT INTO `sarfe_pu`.`pu_rebate`" .
            "(`title`, `rebatetype`, `subprofile_id`,`product_id`, `percent`, `startdate`, `enddate`)" .
            "VALUES ('$title', '$rebatetype', '$subprofile_id','$product_id','$percent','$startdate','$enddate');";
        $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
        $id = mysqli_insert_id($con_PU_db);
        return $id;
    }
}
?>