<?php
require_once "provider.php";

require_once "settings.php";

class bpShopProduct
{
    public $id;
    public $href;
    public $price;
    public $available;

    public function __construct($id, $href, $price, $available)
    {
        $this->id = $id;
        $this->href = $href;
        $this->price = $price;
        $this->available = $available;
    }
}

/**
 * Created by PhpStorm.
 * User: root
 * Date: 8/16/2015
 * Time: 7:47 AM
 */
class ControllerBotsBpshop extends Controller
{
    function convert($string)
    {
        $persian = array('&#1632;', '&#1633;', '&#1634;', '&#1635;', '&#1636;', '&#1637;', '&#1638;', '&#1639;', '&#1640;', '&#1641;');
        $num = range(0, 9);
        return str_replace($persian, $num, $string);
    }

    public function index()
    {
        $subprofile_id = 371;

        $url = "http://www.bpshop.ir/?u=template&ID=11";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);

        $page_content = $data;

        $doc = new DOMDocument();

        $doc->loadHTML(mb_convert_encoding($page_content, 'HTML-ENTITIES', 'UTF-8'));

        $divisions = $doc->getElementsByTagName('div');
        $bpProducts = array();
        $count = 0;

        foreach ($divisions as $division) {
            foreach ($division->attributes as $attrib) {
                if ($attrib->name == 'class' && strpos($attrib->value, "product-container") !== false) {
                    $productContainerDiv = $division;
                    foreach ($productContainerDiv->getElementsByTagName('div') as $productContainerInner) {
                        foreach ($productContainerInner->attributes as $productContainerInnerAttrib) {
                            if ($productContainerInnerAttrib->name == 'class' && strpos($productContainerInnerAttrib->value, 'digionline-product') !== false) {
                                $digionlineProductDiv = $productContainerInner;
                                foreach ($digionlineProductDiv->getElementsByTagName('a') as $digionlineProductAnchor) {
                                    foreach ($digionlineProductAnchor->attributes as $digionlineProductAnchorAttrib) {
                                        if ($digionlineProductAnchorAttrib->name == 'href') {
                                            $href = $digionlineProductAnchorAttrib->value;
                                        }
                                    }
                                }
                            } elseif ($productContainerInnerAttrib->name == 'class' && strpos($productContainerInnerAttrib->value, 'price') !== false) {
                                $priceDiv = $productContainerInner;
                                foreach ($priceDiv->getElementsByTagName('span') as $priceDivSpan) {
                                    foreach ($priceDivSpan->attributes as $priceDivSpanAttribute) {
                                        if ($priceDivSpanAttribute->name == 'dir' && $priceDivSpanAttribute->value == 'rtl') {
                                            $price = mb_convert_encoding($priceDivSpan->textContent, 'HTML-ENTITIES', 'UTF-8');
                                        }
                                    }
                                }
                            } elseif ($productContainerInnerAttrib->name == 'class' && strpos($productContainerInnerAttrib->value, 'state') !== false) {
                                $stateDiv = $productContainerInner;
                                foreach ($stateDiv->getElementsByTagName('i') as $stateDivI) {
                                    foreach ($stateDivI->attributes as $stateDivIAttribute) {
                                        if ($stateDivIAttribute->name == 'class' && $stateDivIAttribute->value == 'fa fa-check') {
                                            $available = true;
                                        } else {
                                            $available = false;
                                        }
                                    }
                                }
                            }
                        }
                    }

                    $pieces = explode("-", $href);
                    $id = $pieces[1];
                    $href = "http://www.bpshop.ir/" . $href;
                    $price = str_replace(",", "", $price);
                    $price = $this->convert($price);
                    $price = $this->convert($price);

                    $bpProducts[] = new bpShopProduct($id, $href, $price, $available);
                }
            }
        }
        foreach ($bpProducts as $bpProduct) {
            print_r($bpProduct);
            $con_PU_db = $GLOBALS['con_PU_db'];
            $con_BOT_db = $GLOBALS['con_BOT_db'];

            $product_id = $bpProduct->id;
            $price = $bpProduct->price;
            $buy_link = $bpProduct->href;
            if($bpProduct->available)
            {
                $availability = 0;
            }else{
                $availability = 1;
            }

            //check if related exist in our DB
            //
            //
            $weHaveIt = false;

            $sql_select_string = "SELECT * FROM `bpshop_related` WHERE bpshop_id = $product_id";
            $result_select = mysqli_query($con_BOT_db, $sql_select_string) or die(mysqli_error());
            while ($row = mysqli_fetch_assoc($result_select)) {
                $weHaveIt = true;
                $product_id = $row['product_id'];
            }
            echo $weHaveIt;
            if ($weHaveIt) {
                //check if product exist in subprofile list
                //
                //
                $exist = false;

                $sql_select_string = "SELECT * FROM `pu_subprofile_product` WHERE product_id = $product_id AND subprofile_id = $subprofile_id ";

                $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
                while ($row = mysqli_fetch_assoc($result_select)) {
                    $exist = true;
                    $subprofile_product_id = $row['id'];
                    $last_price = $row['price'];
                }

                if ($exist) {
                    $sql_update = "UPDATE `pu_subprofile_product` SET
                                                                                `price`='$price',
                                                                                `availability`=$availability,
                                                                                `status_id`='1',
                                                                                `update_date`= NOW()
                                                                      WHERE
                                                                                `product_id` = $product_id
                                                                         AND
                                                                                `subprofile_id` = $subprofile_id";
                    mysqli_query($con_PU_db, $sql_update) or die(mysqli_error());
                    if($last_price!=$price) {

                        $sql_history = "INSERT INTO pu_subprofile_product_history (
                                                                                     subprofile_product_id,
                                                                                     price,
                                                                                     bot
                                                                      ) VALUES (
                                                                                     '$subprofile_product_id',
                                                                                     '$price',
                                                                                     '1'
                                                                                )";
                        mysqli_query($con_PU_db, $sql_history) or die(mysqli_error());
                    }

                } else {
                    $sql_insert_string = "INSERT INTO `pu_subprofile_product`" .
                        "(`product_id`, `subprofile_id`, `price`, `buy_link`, `availability`, `update_date`)" .
                        "VALUES ('$product_id', '$subprofile_id', '$price', '$buy_link','$availability',NOW());";
                    $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
                    $id = mysqli_insert_id($con_PU_db);

                    $sql_history = "INSERT INTO pu_subprofile_product_history (
                                                                                     subprofile_product_id,
                                                                                     price,
                                                                                     bot
                                                                      ) VALUES (
                                                                                     '$id',
                                                                                     '$price',
                                                                                     '1'
                                                                                )";
                    mysqli_query($con_PU_db, $sql_history) or die(mysqli_error());
                }
            }
        }
        echo 'Done';
    }
}

?>