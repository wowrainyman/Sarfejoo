<?php
// include the configs / constants for the database connection
require_once("config/db.php");
error_reporting(E_ERROR | E_PARSE);

// load the login class
require_once("classes/Login.php");

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process. in consequence, you can simply ...
$login = new Login();

// ... ask if we are logged in here:
if ($login->isUserLoggedIn() != true) {
    include("views/not_logged_in.php");
} else { ?>
<?php

ini_set('max_execution_time', 0);

require_once "config.php";

if (!isset($_GET["id"]) || empty($_GET["id"])) {
    $next_id = 1;
} else {
    $next_id = $_GET["id"] + 1;
}

$sql = "SELECT * FROM `emals_related` WHERE id = $next_id ORDER BY id DESC LIMIT 1 OFFSET $next_id";
$result_select = mysqli_query($link_DB, $sql) or die(mysqli_error());
while ($row = mysqli_fetch_assoc($result_select)) {

$product_id = $row['product_id'];
$emalls_id = $row['emalls_id'];

?>
<html>
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
</head>
<body>
<?php

# sTART gRAB lINK

$page_url = "http://emalls.ir/Spec/$emalls_id";
echo $page_url;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $page_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($ch);
curl_close($ch);
$page_content = $data;


$doc = new DOMDocument();

$doc->loadHTML(mb_convert_encoding($page_content, 'HTML-ENTITIES', 'UTF-8'));

$alla = $doc->getElementsByTagName('a');
foreach ($alla as $a) {
    foreach ($a->attributes as $attrib) {
        if ($attrib->name == 'style' && $attrib->value == 'color:blue;text-decoration-line:underline;font-size:large') {
            foreach ($a->attributes as $attrib2) {
                if ($attrib2->name == 'href'){
                    $page_url = $attrib2->value;
                }
            }
        }
    }
}

$url = "http://emalls.ir" . $page_url;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($ch);
curl_close($ch);

$page_content = $data;

$doc->loadHTML(mb_convert_encoding($page_content, 'HTML-ENTITIES', 'UTF-8'));

$divisions = $doc->getElementsByTagName('div');
$count = 0;
foreach ($divisions as $division) {
    foreach ($division->attributes as $attrib) {
        $hasIt = false;
        if ($attrib->name == 'class' && $attrib->value == 'shop-row') {
            $hasIt = true;
        }
    }
    if ($hasIt) {
        $count++; ?>
        <div id="d-<?php echo $count ?>" style='border: 1px solid black;'>
            <div>
                <br/>
                <?php echo $product_id ?>
                <br/>
                <?php echo $emalls_id ?>
                <br/>
            </div>
            <div style="color:#ff0000" id="<?php echo $count ?>-info"></div>
            <?php foreach ($division->getElementsByTagName('a') as $child) {
                foreach ($child->attributes as $attrib) {
                    $hasIt = false;
                    if ($attrib->name == 'style' && strpos($attrib->value, 'display:block; font-size:14px;') !== false) { ?>
                        <div id="<?php echo $count ?>-2">
                            <?php echo $child->textContent; ?>
                        </div>
                    <?php }
                }
            } ?>
            <?php foreach ($division->getElementsByTagName('span') as $child) {
                foreach ($child->attributes as $attrib) {
                    $hasIt = false;
                    if ($attrib->name == 'class' && strpos($attrib->value, 'shop-description') !== false) { ?>
                        <div id="<?php echo $count ?>-4">
                            <?php echo $child->textContent; ?>
                        </div>
                    <?php }
                }
            } ?>
            <?php foreach ($division->getElementsByTagName('a') as $child) {
                foreach ($child->attributes as $attrib) {
                    $hasIt = false;
                    if ($attrib->name == 'class' && strpos($attrib->value, 'shop-price') !== false) { ?>
                        <div id="<?php echo $count ?>-6">
                            <?php echo str_replace(",", "", $child->textContent); ?>
                        </div>
                    <?php }
                }
            } ?>
        </div>
        <script language="JavaScript" type="text/javascript">
            $(document).ready(function () {
                // $("#gg-<?php echo $count  ?>").click(function(){
                var subprofile = $('#<?php echo $count  ?>-2').text();
                var dec = $('#<?php echo $count  ?>-4').text();
                var price = $('#<?php echo $count  ?>-6').text();

                var url = 'db.php?rid=' + <?php echo $product_id  ?> +'&s=' + subprofile + '&p=' + price + '&d=' + dec;

                $.ajax({
                    type: "GET",
                    url: url,
                    success: function (data) {
                        $('#<?php echo $count  ?>-info').text('======Inserted');
                    }
                });
                return false;
                e.preventDefault();
                // });
            });
        </script>
    <?php }
}
}
}
?>
<script type="text/javascript">
    setTimeout(function () {
        window.location.href = "sdb.php?id=<?php echo ($next_id) ?>";
    }, 60000);
</script>
</body>
</html>