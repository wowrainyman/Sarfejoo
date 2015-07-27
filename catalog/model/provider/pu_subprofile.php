<?php

require_once "provider.php";

require_once "settings.php";
/**
 * Created by PhpStorm.
 * User: Amir
 * Date: 10/11/2014
 * Time: 09:06 AM
 */
class ModelProviderPuSubprofile extends Model
{
    public function GetCustomerSubProfilesByStatusId($customerid,$statusid)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $result = array();
        $sql_select_string = "SELECT * FROM `pu_subprofile` WHERE `customer_id` = $customerid AND `status_id` = $statusid ";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        if ($result_select)
            return $result_select;
        else
            return false;
    }
    public function GetCustomerSubProfiles($customerid)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $result = array();
        $sql_select_string = "SELECT * FROM `pu_subprofile` WHERE `customer_id` = $customerid ";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        $myres = array();
        while ($row = mysqli_fetch_assoc($result_select)) {
            $myres[] = $row;
        }
        return $myres;
    }
    public function GetCustomerSubProfile($subprofile_id)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $result = array();
        $sql_select_string = "SELECT * FROM `pu_subprofile` WHERE `id` = $subprofile_id  ";
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
    public function GetLegalPersonInfo($id)
    {

        $con_PU_db = $GLOBALS['con_PU_db'];

        $sql_select_string = "SELECT * FROM `pu_subprofile` WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            $result = $row;
            break;
        }
        $id=$result["legalperson_id"];
        if(!$id)
            return false;
        $exist = false;
        $result = array();
        $sql_select_string = "SELECT * FROM `pu_legalperson` WHERE `id` = $id";
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
    public function AddLegalPersonInfo($data)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $agreementstamp = $data['agreementstamp'];
        $newspaperstamp = $data['newspaperstamp'];
        $registrationid = $data['registrationid'];
        $adminmessage = $data['adminmessage'];


        $sql_insert_string = "INSERT INTO `pu_legalperson`" .
            "(`agreementstamp`, `newspaperstamp`, `registrationid`, `adminmessage`)" .
            "VALUES ('$agreementstamp', '$newspaperstamp', '$registrationid','$adminmessage');";
        $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
        $id = mysqli_insert_id($con_PU_db);
        return $id;
    }
    public function EditLegalPersonInfo($id, $data)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $agreementstamp = $data['agreementstamp'];
        $newspaperstamp = $data['newspaperstamp'];
        $registrationid = $data['registrationid'];

        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_legalperson` WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_legalperson` SET " .
                "`agreementstamp`='$agreementstamp'" .
                ",`newspaperstamp`='$newspaperstamp'" .
                ",`registrationid`='$registrationid'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }
    public function EditSubprofile($data)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $customer_id = $this->customer->getId();
        $id = $data['id'];
        $group_id = $data['group_id'];
        $title = $data['title'];
        $legalperson_id = $data['legalperson_id'];
        $province_id = $data['province_id'];
        $city = $data['city'];
        $address = $data['address'];
        $lat = $data['lat'];
        $lon = $data['lon'];
        $zoom = $data['zoom'];
        $tel = $data['tel'];
        $mobile = $data['mobile'];
        $email = $data['email'];
        $website = $data['website'];

        $exist = false;
        $sql_select_string = "SELECT `customer_id` FROM `pu_subprofile` WHERE `customer_id` = $customer_id AND `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_subprofile` SET " .
                "`title`='$title'" .
                ",`province_id`='$province_id'" .
                ",`city`='$city'" .
                ",`address`='$address'" .
                ",`lat`='$lat'" .
                ",`lon`='$lon'" .
                ",`zoom`='$zoom'" .
                ",`tel`='$tel'" .
                ",`mobile`='$mobile'" .
                ",`email`='$email'" .
                ",`website`='$website'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }
    public function EditSubprofileStatus($id,$status)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];


        $exist = false;
        $sql_select_string = "SELECT `customer_id` FROM `pu_subprofile` WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_subprofile` SET " .
                "`status_id`='$status'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }
    public function EditLogo($id,$name)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $customer_id = $this->customer->getId();
        $exist = false;
        $sql_select_string = "SELECT `customer_id` FROM `pu_subprofile` WHERE `customer_id` = $customer_id AND `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_subprofile` SET " .
                "`logo`='$name'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }
    public function EditPicture($id,$name)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $customer_id = $this->customer->getId();
        $exist = false;
        $sql_select_string = "SELECT `customer_id` FROM `pu_subprofile` WHERE `customer_id` = $customer_id AND `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_subprofile` SET " .
                "`picture`='$name'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }
    public function AddSubprofile($data)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $customer_id = $this->customer->getId();
        $id = $data['id'];
        $group_id = $data['group_id'];
        $title = $data['title'];
        $legalperson_id = 0;
        $province_id = $data['province_id'];
        $city = $data['city'];
        $address = $data['address'];
        $lat = $data['lat'];
        $lon = $data['lon'];
        $zoom = $data['zoom'];
        $tel = $data['tel'];
        $mobile = $data['mobile'];
        $email = $data['email'];
        $website = $data['website'];
        $sql_insert_string = "INSERT INTO `pu_subprofile`" .
            "(`customer_id`, `group_id`, `title`, `legalperson_id`,
                 `province_id`, `city`,
                 `address`, `lat`,
                  `lon`, `zoom`,
                   `tel`, `mobile`,
                  `email`, `website`, `status_id`)" .
            "VALUES ('$customer_id', '$group_id', '$title','$legalperson_id'
                ,'$province_id','$city','$address'
                ,'$lat','$lon','$zoom'
                ,'$tel','$mobile','$email','$website','0');";

        $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
        $id = mysqli_insert_id($con_PU_db);
        return $id;
    }
    public function AddTempSubprofile($data)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $customer_id = $this->customer->getId();
        $group_id = $data['group_id'];
        $title = $data['title'];
        $sql_insert_string = "INSERT INTO `pu_subprofile`" .
            "(`customer_id`, `group_id`, `title`, `legalperson_id`,
                 `province_id`, `city`,
                 `address`, `lat`,
                  `lon`, `zoom`,
                   `tel`, `mobile`,
                  `email`, `website`, `status_id`)" .
            "VALUES ('$customer_id', '$group_id', '$title',''
                ,'','',''
                ,'','',''
                ,'','','','','0');";

        $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
        $id = mysqli_insert_id($con_PU_db);
        return $id;
    }
    public function UpdateSubprofilePayedStatus($id,$timestamp){
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_subprofile` WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_subprofile` SET " .
                "`expire_date`='$timestamp'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }
    public function GetCountSubprofiles()
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $result = array();
        $sql_select_string = "SELECT COUNT(id) FROM `pu_subprofile`";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            return $row;
        }
        return false;
    }
    public function GetSubprofileInfo($id){
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $result = array();
        $sql_select_string = "SELECT * FROM `pu_subprofile` WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            return $row;
        }
        return false;
    }
    public function SetSubprofileLegalperson($subprofileid, $legalpersonid)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_subprofile` WHERE `id` = $subprofileid";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_subprofile` SET " .
                "`legalperson_id`='$legalpersonid'" .
                " WHERE `id` = $subprofileid";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }
    public function UpdateProductPrice($id,$price)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];

        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_subprofile_product` WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            if ($price != $row ['price']) {
                $exist = true;
            }
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_subprofile_product` SET
                                                                                             `price`='$price',
                                                                                             `update_date`= NOW()
                                                                                  WHERE
                                                                                             `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());

            # Start History
            $sql_history = "INSERT INTO pu_subprofile_product_history (
                                                                                     subprofile_product_id,
                                                                                     price,
                                                                                     bot
                                                                      ) VALUES (
                                                                                     '$id',
                                                                                     '$price',
                                                                                     '0'
                                                                                )";
            mysqli_query($con_PU_db, $sql_history) or die(mysqli_error());
            # End History

            return true;
        } else {
            return false;
        }
    }
    public function UpdateProductDescription($id,$description)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_subprofile_product` WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_subprofile_product` SET " .
                "`description`='$description'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }
    public function UpdateProductBuyLink($id,$buy_link)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_subprofile_product` WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_subprofile_product` SET " .
                "`buy_link`='$buy_link'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }
    public function UpdateProductGuaranteeStatus($id,$guarantee_status)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_subprofile_product` WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_subprofile_product` SET " .
                "`guarantee_status`='$guarantee_status'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }
    public function UpdateProductGuaranteePrice($id,$guarantee_price)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_subprofile_product` WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_subprofile_product` SET " .
                "`guarantee_price`='$guarantee_price'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }
    public function UpdateProductGuaranteeTime($id,$guarantee_time)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_subprofile_product` WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_subprofile_product` SET " .
                "`guarantee_time`='$guarantee_time'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }
    public function UpdateProductGuaranteeTimeType($id,$guarantee_time_type)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_subprofile_product` WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_subprofile_product` SET " .
                "`guarantee_time_type`='$guarantee_time_type'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }
    public function UpdateProductGuaranteeDescription($id,$guarantee_description)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_subprofile_product` WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_subprofile_product` SET " .
                "`guarantee_description`='$guarantee_description'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }
    public function UpdateProductAvailability($id,$status)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];

        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_subprofile_product` WHERE `id` = $id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_subprofile_product` SET " .
                "`availability`='$status'" .
                " WHERE `id` = $id";
            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
            return true;
        } else {
            return false;
        }
    }
    public function AddProductToSubprofile($data)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $product_id = $data['product_id'];
        $subprofile_id = $data['subprofile_id'];
        $price = $data['price'];
        $buy_link = $data['buy_link'];
        $description = $data['description'];
        $availability = $data['availability'];
        $guarantee_status = $data['guarantee_status'];
        $guarantee_price = $data['guarantee_price'];
        $guarantee_time = $data['guarantee_time'];
        $guarantee_time_type = $data['guarantee_time_type'];
        $guarantee_description = $data['guarantee_description'];
        $sql_insert_string = "INSERT INTO `pu_subprofile_product`" .
            "(`product_id`, `subprofile_id`, `price`, `buy_link`, `description`, `availability`, `guarantee_status`, `guarantee_price`, `guarantee_time`, `guarantee_time_type`, `guarantee_description`)" .
            "VALUES ('$product_id', '$subprofile_id', '$price', '$buy_link', '$description','$availability','$guarantee_status','$guarantee_price','$guarantee_time','$guarantee_time_type','$guarantee_description');";
        $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
        $id = mysqli_insert_id($con_PU_db);

        # Start History
        $sql_history = "INSERT INTO pu_subprofile_product_history (
                                                                                     subprofile_product_id,
                                                                                     price,
                                                                                     bot
                                                                      ) VALUES (
                                                                                     '$id',
                                                                                     '$price',
                                                                                     '0'
                                                                                )";
        mysqli_query($con_PU_db, $sql_history) or die(mysqli_error());
        # End History

        return $id;
    }
    public function GetCountProductsOfSubprofile($subprofile_id)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $result = array();
        $sql_select_string = "SELECT COUNT(DISTINCT p.product_id) AS total "." FROM pu_subprofile_product p"." WHERE `subprofile_id` = $subprofile_id AND status_id <> 0";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        return $result_select;
    }
    public function GetProductsOfSubprofile($subprofile_id,$data)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $result = array();
        $sql_select_string = "SELECT * FROM `pu_subprofile_product` WHERE `subprofile_id` = $subprofile_id AND status_id <> 0";
        $sql_select_string.=" LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        return $result_select;
    }
    public function GetSpecificProductsOfSubprofile($subprofile_id,$product_id)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $result = array();
        $sql_select_string = "SELECT * FROM `pu_subprofile_product` LEFT JOIN`pu_subprofile` ON  `pu_subprofile`.id = `pu_subprofile_product`.subprofile_id LEFT JOIN `pu_subprofile_verification` ON pu_subprofile.id=`pu_subprofile_verification`.subprofile_id WHERE `pu_subprofile_product`.status_id <> 0 AND (`pu_subprofile_product`.price <> 0 OR `pu_subprofile_product`.guarantee_price <> 0) AND ((`pu_subprofile_verification`.expire_date > CURDATE()) OR `pu_subprofile`.financial_exception = 1) AND `pu_subprofile_product`.`update_date` > DATE_SUB(CURDATE(), INTERVAL 60 DAY)  AND `pu_subprofile_product`.`subprofile_id` = $subprofile_id AND `pu_subprofile_product`.`product_id` = $product_id  AND(`pu_subprofile_product`.`availability` = 0 or`pu_subprofile_product`.`availability` = 2)  ORDER BY `pu_subprofile_product`.`update_date` DESC";

        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            return $row;
        }
    }
    public function GetProductOfSubprofile($subprofileProductId)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $result = array();
        $sql_select_string = "SELECT * FROM `pu_subprofile_product` WHERE `id` = $subprofileProductId AND status_id <> 0";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            return $row;
        }

    }
    public function GetAllProductsOfSubprofile($subprofile_id)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $result = array();
        $sql_select_string = "SELECT * FROM `pu_subprofile_product` WHERE `subprofile_id` = $subprofile_id AND status_id <> 0";
        // $sql_select_string.=" LIMIT " . (int)$data['start'] . "," . (int)$data['limit']
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        return $result_select;
    }
    public function GetAllSubprofileOfProducts($product_id)       //   Get   All   Subprofile  Of    Products ( product/product )
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $result = array();
        $sql_select_string = "SELECT *,pu_subprofile.id AS subprofile_id,pu_subprofile_product.id AS id FROM `pu_subprofile_product` LEFT JOIN`pu_subprofile` ON  `pu_subprofile`.id = `pu_subprofile_product`.subprofile_id LEFT JOIN `pu_subprofile_verification` ON pu_subprofile.id=`pu_subprofile_verification`.subprofile_id WHERE `pu_subprofile_product`.status_id <> 0 AND (`pu_subprofile_product`.price <> 0 OR `pu_subprofile_product`.guarantee_price <> 0) AND ((`pu_subprofile_verification`.expire_date > CURDATE()) OR `pu_subprofile`.financial_exception = 1) AND `pu_subprofile_product`.`update_date` > DATE_SUB(CURDATE(), INTERVAL 60 DAY) AND `pu_subprofile_product`.`product_id` = $product_id  AND(`pu_subprofile_product`.`availability` = 0 or`pu_subprofile_product`.`availability` = 2)  ORDER BY `pu_subprofile_product`.`update_date` DESC";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $result[]=$row;
        }
        return $result;
    }
    public function GetAllSubprofileList($group_id,$limit)  // List All Provider of Group_id (0=all)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $result = array();
        if ($group_id =='a') {
            $sql_select_string = "SELECT * FROM `pu_subprofile`";
        } else {
            $sql_select_string = "SELECT * FROM `pu_subprofile` WHERE group_id = $group_id  limit = $limit";
        }
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $result[]=$row;
        }
        return $result;
    }
    public function GetSubprofileByID($subprofile_id)  // Provider Profile by id
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $result = array();

        $sql_select_string = "SELECT * FROM `pu_subprofile` WHERE id = $subprofile_id";

        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());

        while ($row = mysqli_fetch_assoc($result_select)) {
            return $row;
        }
        return false;
    }
    public function CountGetListOfProductsOfSubprofileByID($subprofile_id)  // Products Of Subprofile (list Image, price, Name, ID)
    {
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];

        $con_OC_db = $GLOBALS['con_OC_db'];
        $exist = false;
        $result = array();

        $sql_select_string = "SELECT COUNT(ocp.`product_id`) AS cnt FROM `oc_product` ocp, `oc_product_description` ocd, $pu_database_name.`pu_subprofile_product` pusp WHERE ocp.`product_id`= pusp.`product_id` and ocp.`product_id` = ocd.`product_id`and pusp.`subprofile_id` = $subprofile_id";
        $result_select = mysqli_query($con_OC_db, $sql_select_string) or die(mysqli_error());

        while ($row = mysqli_fetch_assoc($result_select)) {
           return $row['cnt'];
        }
        return false;
    }
    public function GetListOfProductsOfSubprofileByID($subprofile_id,$page,$limit)  // Products Of Subprofile (list Image, price, Name, ID)
    {
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];

        $con_OC_db = $GLOBALS['con_OC_db'];
        $exist = false;
        $result = array();
        $offset = ($page - 1)* $limit;
        $sql_select_string = "SELECT ocp.`product_id`, ocp.`image`,ocd.`name`,pusp.`price` FROM `oc_product` ocp, `oc_product_description` ocd, $pu_database_name.`pu_subprofile_product` pusp WHERE ocp.`product_id`= pusp.`product_id` and ocp.`product_id` = ocd.`product_id`and pusp.`subprofile_id` = $subprofile_id limit $limit OFFSET $offset";

        $result_select = mysqli_query($con_OC_db, $sql_select_string) or die(mysqli_error());

        while ($row = mysqli_fetch_assoc($result_select)) {
            $result[]=$row;
        }
        return $result;
    }
    public function GetTopSubprofileOfProducts($product_id,$count)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_select_string = "SELECT * FROM `pu_subprofile_product`,`pu_subprofile` WHERE  `pu_subprofile`.id = `pu_subprofile_product`.subprofile_id  and `pu_subprofile_product`.`product_id` = $product_id  and (`pu_subprofile_product`.`availability` = 0 or`pu_subprofile_product`.`availability` = 2) ORDER BY `pu_subprofile_product`.`update_date` DESC LIMIT 0,$count";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $result[]=$row;
        }
        if(isset($result))
            return $result;
        else
            return $result = array();
    }
    public function GetAveragepricePriceOfProduct($product_id)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $result = array();
        $sql_select_string = "SELECT `average_price` FROM `pu_product_avg` WHERE `product_id`=$product_id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            $result = $row['average_price'];
            break;
        }
        if ($exist)
            return $result;
        else
            return false;
    }
    public function GetMinimumPriceOfProduct($product_id)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $result = array();
        $sql_select_string = "SELECT MIN(price), subprofile_id FROM `pu_subprofile_product` WHERE product_id = $product_id and `availability`=0 AND `update_date` > DATE_SUB(CURDATE(), INTERVAL 60 DAY)";
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
    public function GetMaximumPriceOfProduct($product_id)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $result = array();
        $sql_select_string = "SELECT MAX(price), subprofile_id FROM `pu_subprofile_product` WHERE product_id = $product_id and `availability`=0 AND `update_date` > DATE_SUB(CURDATE(), INTERVAL 60 DAY)";
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
    public function GetSubprofileComments($subprofile_id)  // Products Of Subprofile (list Image, price, Name, ID)
    {
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];

        $con_OC_db = $GLOBALS['con_OC_db'];
        $exist = false;
        $result = array();

        $sql_select_string = "SELECT * FROM $pu_database_name.pu_subprofile_comment tab1 LEFT JOIN $oc_database_name.oc_customer tab2 ON(tab1.customer_id = tab2.customer_id) WHERE subprofile_id = $subprofile_id AND tab1.approved = 1";

        $result_select = mysqli_query($con_OC_db, $sql_select_string) or die(mysqli_error());

        while ($row = mysqli_fetch_assoc($result_select)) {
            $result[]=$row;
        }
        return $result;
    }
    public function AddSubprofileComments($customer_id,$subprofile_id,$comment)  // Products Of Subprofile (list Image, price, Name, ID)
    {
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];

        $con_OC_db = $GLOBALS['con_OC_db'];
        $exist = false;
        $result = array();

        $sql_insert_string = "INSERT INTO $pu_database_name.pu_subprofile_comment" .
            "(`customer_id`, `subprofile_id`, `comment`)" .
            "VALUES ('$customer_id', '$subprofile_id', '$comment');";

        $result_select = mysqli_query($con_OC_db, $sql_insert_string) or die(mysqli_error());
        return ;
    }
    public function GetAllVisitors()
    {/*
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $result = array();
        $sql_select_string = "SELECT customer_id FROM `pu_visitor` WHERE is_visitor <> 0";

        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $result[]=$row;
        }
        return $result;
   */ }
    public function getSubprofileExpireDate($subprofile_id)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_select_string = "SELECT expire_date FROM `pu_subprofile_verification` WHERE `subprofile_id` = $subprofile_id ";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            return $row['expire_date'];
        }
        return false;
    }
    public function setSubprofileExpireDate($subprofile_id,$expire_date,$plan_id,$period_id)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $exist = false;
        $sql_select_string = "SELECT * FROM `pu_subprofile_verification` WHERE `subprofile_id` = $subprofile_id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $exist = true;
            break;
        }
        if ($exist) {
            $sql_update_string = "UPDATE `pu_subprofile_verification` SET " .
                "`expire_date`='$expire_date'" .
                ",`plan_id`='$plan_id'" .
                ",`period_id`='$period_id'" .
                " WHERE `subprofile_id` = $subprofile_id";

            $result_test_mod = mysqli_query($con_PU_db, $sql_update_string) or die(mysqli_error());
        }else{
            $sql_insert_string = "INSERT INTO $pu_database_name.pu_subprofile_verification" .
                "(`subprofile_id`, `expire_date`, `plan_id`, `period_id`)" .
                "VALUES ('$subprofile_id', '$expire_date', '$plan_id', '$period_id');";
            $result_select = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
        }

        return false;
    }
    public function getLastUpdateTimeOfProduct($product_id){
        $con_PU_db = $GLOBALS['con_PU_db'];
        $exist = false;
        $result = array();
        $sql_select_string = "SELECT * FROM `pu_subprofile_product` WHERE `product_id` = $product_id AND status_id <> 0 ORDER BY update_date DESC";
        // $sql_select_string.=" LIMIT " . (int)$data['start'] . "," . (int)$data['limit']
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            return $row['update_date'];
        }
        return $result_select;
    }
}