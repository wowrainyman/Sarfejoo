<html>
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
</head>
<body>
<?php
error_reporting(E_ERROR | E_PARSE);
require_once "config.php";



/**
 * Created by PhpStorm.
 * User: root
 * Date: 8/16/2015
 * Time: 7:47 AM
 */

$specialChars = array("\r", "\n");
$replaceChars = array("", "");

$specialChars2 = array(" ","\r", "\n");
$replaceChars2 = array("","", "");

if(isset($_GET['lastOne'])){
    $offset = $_GET['lastOne'] + 1;
}else{
    $offset = 1;
}
$end = true;
$queryCategories = "SELECT * FROM mobileir_product_relate WHERE mobileir_url <> '' ORDER BY id LIMIT 1 OFFSET $offset";

//$sql_oc = "SELECT price,model FROM `oc_product` WHERE product_id=$related_id";
$result_select_oc = mysqli_query($link_DB, $queryCategories) or die(mysqli_error());
while ($row = mysqli_fetch_assoc($result_select_oc)) {
    $end = false;
    $mobileir_product_relate = $row;
}
if($end){
    echo 0;
    return;
}

$relate_mem = getRelateMem($mobileir_product_relate);
$product_id = $mobileir_product_relate['product_id'];

$url = $mobileir_product_relate['mobileir_url'];
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
$i=-1;
$j=-1;
$providers = array();
foreach ($divisions as $division) {
    foreach ($division->attributes as $attrib) {
        if ($attrib->name == 'class' && $attrib->value == "product-prices") {
            $productpricesDiv = $division;
            foreach ($productpricesDiv->getElementsByTagName('div') as $productpricesDivChildDiv) {
                foreach ($productpricesDivChildDiv->attributes as $productpricesDivChildDivAttrib) {
                    if ($productpricesDivChildDivAttrib->name == 'class' && $productpricesDivChildDivAttrib->value == "shop") {
                        $shopDiv = $productpricesDivChildDiv;
                        foreach($shopDiv->getElementsByTagName('strong') as $strongDiv){
                            foreach($strongDiv->getElementsByTagName('a') as $nameAnchor){
                                $i++;
                                $j=-1;
                                $providers[$i]['name'] = str_replace($specialChars, $replaceChars, $nameAnchor->textContent);
                                foreach ($nameAnchor->attributes as $nameAnchorAttrib) {
                                    if($nameAnchorAttrib->name=='href'){
                                        $providers[$i]['mobileir_url'] = $nameAnchorAttrib->value;
                                    }
                                }
                            }
                        }
                    }elseif($productpricesDivChildDivAttrib->name == 'class' && $productpricesDivChildDivAttrib->value == 'price'){
                        $priceDiv = $productpricesDivChildDiv;
                        $correctMem = $false;
                        foreach($priceDiv->getElementsByTagName('div') as $innerPriceDiv){
                            foreach ($innerPriceDiv->attributes as $innerPriceDivAttrib) {
                                if($innerPriceDivAttrib->name=='class'&&$innerPriceDivAttrib->value=='comments'){
                                    if($relate_mem == 1 || getDescriptionMem($innerPriceDiv->textContent) == 1 || getDescriptionMem($innerPriceDiv->textContent) == $relate_mem){
                                        $j++;
                                        $correctMem = true;
                                        $providers[$i]['prices'][$j]['comment'] = str_replace($specialChars, $replaceChars, $innerPriceDiv->textContent);
                                    }
                                }elseif($innerPriceDivAttrib->name=='class'&&$innerPriceDivAttrib->value=='warranty' && $correctMem){
                                    $warranty = $innerPriceDiv->textContent;
                                    $warranty = str_replace('گارانتی :','',str_replace($specialChars, $replaceChars, $warranty));
                                    $providers[$i]['prices'][$j]['warranty'] = $warranty;
                                }elseif($innerPriceDivAttrib->name=='class' && $innerPriceDivAttrib->value=='date' && $correctMem){
                                    $date = $innerPriceDiv->textContent;
                                    $date = str_replace('به روز رسانی :','',$date);
                                    $providers[$i]['prices'][$j]['date'] = str_replace($specialChars, $replaceChars, $date);
                                }
                            }
                        }
                        if($correctMem) {
                            foreach ($priceDiv->getElementsByTagName('strong') as $strongDiv) {
                                $price = $strongDiv->firstChild->textContent;
                                $price = str_replace(',', '', $price);
                                $price = str_replace(' ', '', $price);
                                $providers[$i]['prices'][$j]['price'] = str_replace($specialChars2, $replaceChars2, $price);
                                $providers[$i]['prices'][$j]['price'] = convert($providers[$i]['prices'][$j]['price']);
                                $providers[$i]['prices'][$j]['price'] = $providers[$i]['prices'][$j]['price']  + 0;
                            }
                        }
                        foreach($priceDiv->getElementsByTagName('a') as $innerPriceAnchor){
                            foreach ($innerPriceAnchor->attributes as $innerPriceAnchorAttrib) {
                                if($innerPriceAnchorAttrib->name=='rel'&&$innerPriceAnchorAttrib->value=='nofollow'){
                                    foreach ($innerPriceAnchor->attributes as $innerPriceAnchorAttribAgain) {
                                        if($innerPriceAnchorAttribAgain->name=='href'){
                                            $providers[$i]['url'] = $innerPriceAnchorAttribAgain->value;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
//filter providers by date
$providersAfterDateFilter = array();
foreach($providers as $provider){
    if(mustUpdate($provider['prices'][0]['date'])){
        $providersAfterDateFilter[] = $provider;
    }
}
//get buy link
$providersAfterBuyLink = array();
foreach($providersAfterDateFilter as $provider){
    if(isset($provider['url'])) {
        $url = "http://www.mobile.ir" . $provider['url'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);

        $page_content = $data;

        $doc = new DOMDocument();

        $doc->loadHTML(mb_convert_encoding($page_content, 'HTML-ENTITIES', 'UTF-8'));
        $anchors = $doc->getElementsByTagName('a');

        foreach($anchors as $anchor){
            foreach($anchor->attributes as $attrib){
                if($attrib->name == 'href' && startsWith($attrib->value,'http://')){
                    $provider['url'] = $attrib->value;
                }
            }
        }
    }
    $providersAfterBuyLink[] = $provider;
}

foreach($providersAfterBuyLink as $provider){
    foreach($provider['prices'] as $priceArray) {
        $weHave = false;
        $name = $provider['name'];
        $queryCategories = "SELECT * FROM mobileir_subprofile_relate WHERE mobileir_name = '$name'";
        //$sql_oc = "SELECT price,model FROM `oc_product` WHERE product_id=$related_id";
        $result_select_oc = mysqli_query($link_DB, $queryCategories) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select_oc)) {
            $weHave = true;
            $subprofile_relate = $row;
        }
        if ($weHave) {
            $comment = $priceArray['comment'];
            $price = $priceArray['price'];
            $subprofile_id = $subprofile_relate['subprofile_id'];
            $timeArray = getTime($priceArray['date']);
            $timeType = $timeArray['period'];
            $timeValue = $timeArray['time'];

            $url = "http://sarfejoo.com/bot_iran/insDate.php?product_id=$product_id&subprofile_id=$subprofile_id&price=$price&timeType=$timeType&time=$timeValue";
            if(isset($priceArray['warranty'])){
                $warranty = $priceArray['warranty'];
                $url .= "&warranty=$warranty";
            }
            $data['comment'] = $comment;
            echo $url.'-->'.$comment.'</br>';
            $handle = curl_init($url);
            curl_setopt($handle, CURLOPT_POST, true);
            curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
            $data = curl_exec($handle);
            echo $data.'</br>';
            curl_close($ch);

            if(isset($provider['url'])){
                $link = $provider['url'];
                $url = "http://sarfejoo.com/bot_iran/blink.php?product_id=$product_id&link=$link&product_id=$product_id&subprofile_id=$subprofile_id";
                echo $url . '<br/>';
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $data = curl_exec($ch);
                curl_close($ch);
            }
        }
    }
}

//filter by memory
echo '<br/>' . $mobileir_product_relate['product_name'] . '<br/>';
?>
<script type="text/javascript">
    setTimeout(function () {
        window.location.href = "index.php?lastOne=<?php echo $offset ?>";
    }, 5000);
</script>
</body>
</html>
<?php
// needed functions
function mustUpdate($date){
    if (strpos($date,'روز') !== false || strpos($date,'ساعت') !== false) {
        return true;
    }else{
        return false;
    }
}
function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}
function endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
}
function getDescriptionMem($str){
    if (strpos($str,'16') !== false) {
        return 16;
    }elseif (strpos($str,'32') !== false) {
        return 32;
    }elseif (strpos($str,'64') !== false) {
        return 64;
    }elseif (strpos($str,'128') !== false) {
        return 128;
    }elseif (strpos($str,'256') !== false) {
        return 256;
    }elseif (strpos($str,'512') !== false) {
        return 512;
    }else{
        return 1;
    }
}
function getRelateMem($relate){
    if($relate['mem16']){
        return 16;
    }elseif($relate['mem32']){
        return 32;
    }elseif($relate['mem64']){
        return 64;
    }elseif($relate['mem128']){
        return 128;
    }elseif($relate['mem256']){
        return 256;
    }elseif($relate['mem512']){
        return 512;
    }else{
        return 1;
    }
}
function convert($string) {
    $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
    $num = range(0, 9);
    return str_replace($persian, $num, $string);
}
function getTime($str){
    if (strpos($str,'کمتر') !== false) {
        $result['period']='hours';
        $result['time']='0';
        return $result;
    }elseif(strpos($str,'ساعت') !== false){
        $time = filter_var($str, FILTER_SANITIZE_NUMBER_INT);
        $result['period']='hours';
        $result['time']=$time;
        return $result;
    }elseif(strpos($str,'روز') !== false){
        $time = filter_var($str, FILTER_SANITIZE_NUMBER_INT);
        $result['period']='days';
        $result['time']=$time;
        return $result;
    }
}
?>