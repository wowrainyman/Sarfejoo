<?php

require_once "provider.php";
require_once "settings.php";

class ModelBlogBlog extends Model
{

# Get  Categury  How  To  Buy  Link
    public function GetCateguryHowToBuyLink($category)
    {

        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $result = array();
        $sql_select_string = "SELECT * FROM `pu_category_blog` WHERE `category` = $category";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        if ($result_select)
            return $result_select;
        else
            return false;
    }
    
}