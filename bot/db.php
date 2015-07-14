<?php

require_once "config.php";

if (!isset($_GET["rid"])) {
    $related_id = "000";
} else {
    $related_id = $_GET["rid"];
}
if (!isset($_GET["s"])) {
    $subprofile_name = "000";
} else {
    $subprofile_name = $_GET["s"];
}
if (!isset($_GET["p"])) {
    $price = "000";
} else {
    $price = $_GET["p"];
}
if (!isset($_GET["d"])) {
    $text = " ";
} else {
    $text = $_GET["d"];
}

$subprofile_name = trim($subprofile_name);
$text = trim($text);
$price = preg_replace("/[^0-9.]/", "", $price);
if (!empty($subprofile_name)) {
    $not_related = false;
    $sql_pu = "SELECT * FROM not_related WHERE related_id = '$related_id' AND subprofile_name = '$subprofile_name' AND text = '$text' AND remove_until > current_date";
    echo $sql_pu;
    $result_select_pu = mysqli_query($link_DB, $sql_pu) or die(mysqli_error());
    while ($row = mysqli_fetch_assoc($result_select_pu)) {
        $not_related = true;
    }
    if (!$not_related) {
        $auto_update = false;
        $sql_pu = "SELECT * FROM auto_update WHERE related_id = '$related_id' AND subprofile_name = '$subprofile_name' AND text = '$text' AND update_until > current_date";
        $result_select_pu = mysqli_query($link_DB, $sql_pu) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select_pu)) {
            $auto_update = true;
        }
        //  mysqli_query($con_PU_db,'TRUNCATE TABLE emalls_updated_price');

        $sql = "INSERT INTO emalls_updated_price (
                                                     related_id,
                                                     subprofile_name,
                                                     price,
                                                     text,
                                                     auto_update
                                                    )
                                            VALUES
                                                    (
                                                     '$related_id',
                                                     '$subprofile_name',
                                                     '$price',
                                                     '$text',
                                                     '$auto_update'
                                                 )";
        mysqli_query($link_DB, $sql) or die(mysqli_error());

        if ($auto_update && $price > 1000) {
            $sql_related_subprofile = "SELECT subprofile_id FROM emalls_related_subprofile WHERE emalls_subprofile = '$subprofile_name'";
            $result_related_subprofile = mysqli_query($link_DB, $sql_related_subprofile) or die(mysqli_error());
            while ($row = mysqli_fetch_assoc($result_related_subprofile)) {
                $subprofile_id = $row['subprofile_id'];
            }
            $url = "http://sarfejoo.com/bot_iran/db.php?product_id=$related_id&subprofile_id=$subprofile_id&price=$price&description=$text";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $data = curl_exec($ch);
            curl_close($ch);
            echo $data;
        }
    }
}

?>