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
    $next_id = $_GET["id"];
}

$sql = "SELECT * FROM `emals_related` WHERE id = $next_id";
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

$page_url = "http://emalls.ir/price_compar.aspx?ID=$emalls_id";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $page_url);
curl_setopt($ch, CURLOPT_HEADER, TRUE);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$a = curl_exec($ch);
if (preg_match('#Location: (.*)#', $a, $r))
    $l = trim($r[1]);
$page_url = "$l";
$date = date('m-d-Y');

if (!file_exists($date)) {
    mkdir($date);
}
$local_file = $date . '/' . $product_id . '.html';
$context = stream_context_create($opts);
try {
    $page_content = file_get_contents('http://emalls.ir/' . urlencode($page_url));
} catch (Exception $exc) {
    echo $exc;
}

$myfile = fopen("$local_file", "w") or die("Unable to open file!");
fwrite($myfile, $page_content);


$page_content = file_get_contents($local_file);

$doc = new DOMDocument();

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
<?php

$sql = "SELECT * FROM `emals_related`";
$result = mysqli_query($link_DB, $sql) or die(mysqli_error($con_rb));
$bot_count = mysqli_num_rows($result);
$rand_id = rand(1, $bot_count);
if ($rand_id == $next_id) {
    $rand_id = $rand_id + 1;
}
?>
<script type="text/javascript">
    setTimeout(function () {
        window.location.href = "sdblocal.php?id=<?php echo ($rand_id) ?>";
    }, 60000);
</script>
</body>
</html>