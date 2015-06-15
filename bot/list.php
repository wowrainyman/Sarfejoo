<?php
// include the configs / constants for the database connection
require_once("config/db.php");

// load the login class
require_once("classes/Login.php");

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process. in consequence, you can simply ...
$login = new Login();

// ... ask if we are logged in here:
if ($login->isUserLoggedIn() != true) {
    include("views/not_logged_in.php");
} else { ?>
    <html>
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <style>
        body {
            font-family: tahoma;
            font-size: 11px;
        }

        #pagenation {
            position: fixed;
            bottom: -10;
            padding: 15px 50px 20px;
            background-color: rgba(200, 200, 200, 0.4);
        }

        .pp {
            position: relative;
            width: 400px;
            height: 240px;
            float: right;
            display: block;
            border: 2px solid #CCC;
            margin: 5px;
            padding: 15px;
            font-size: 11px;
            line-height: 245%;
            max-width: 95%;
        }

        .pp:hover {
            border: solid 2px #888;
        }

        @media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
            /* Smartphones (portrait and landscape) */
            .pp {
                min-width: 90%;
            }

            z
        }

        .upd {
            background-color: #5555FF;
            color: #fff;
            padding: 1px 8px;
            float: left;
            cursor: pointer;
            margin: 0 5px;
        }

        .upd:hover {
            color: #fff;
            background-color: #0055FF;
        }

        .ins2 {
            background-color: #D6E3D6;
            color: #3D8020;
            padding: 1px 8px;
            float: left;
            margin: 0 5px;
        }

        .ins {
            background-color: #da532c;
            color: #fff;
            padding: 1px 8px;
            float: left;
            cursor: pointer;
            margin: 0 5px;
        }

        .ins:hover {
            color: #fff;
            background-color: #ee1111;
        }

        .pa2 {
            font-size: 11px;
            background-color: #ececec;
            color: #666;
            padding: 8px 15px;
            margin: 0 5px;
            border: solid 1px #ccc;
        }

        .pa {
            font-size: 11px;
            background-color: #ececec;
            color: #000;
            padding: 8px 15px;
            cursor: pointer;
            margin: 0 5px;
            border: solid 1px #ccc;
        }

        .pa:hover {
            color: #000;
            background-color: #fff;
        }

        .buy-link {
            width: 100%;
            border: 1px solid #ccc;
            padding: 5px 50px 5px 20px;
            font-family: tahoma;
            font-size: 9px;
            color: #888;
            direction: ltr;
        }

        #buy-link:hover {
            color: #ff8888;
            border: 1px solid #999;
        }

        .logo {
            display: block;
            position: absolute;
            top: 150px;
            right: 165px;
        }

        .logo img {
            border: 1px dashed #ccc;
            padding: 3px;
            width: 80px;
            height: auto;
            max-height: 40px;
        }

        .openbuy {
            font-family: tahoma;
            font-size: 14px;
            color: #F00;
            text-decoration: none;
            position: absolute;
            top: -3px;
            left: 5px;
        }

        .bl-c {
            position: relative;
        }

        .upblc {
            line-height: 145%;
            position: absolute;
            top: 5px;
            right: 5px;
            font-family: tahoma;
            font-size: 10px;
            background-color: #EC967D;
            color: #FFF;
            padding: 0px 8px;
            float: left;
            cursor: pointer;
            margin: 0px 0px;
        }

        .upblc:hover {
            color: #fff;
            background-color: #E91717;
        }
    </style>
</head>

<?php

require_once "config.php";

//all manufacturers
$sql = "SELECT *
                FROM  `oc_manufacturer`
                ORDER BY  `oc_manufacturer`.`name` ASC ";
$result_select_oc = mysqli_query($link_OC_DB, $sql) or die(mysqli_error());
while ($row = mysqli_fetch_assoc($result_select_oc)) {
    $manufacturers[] = $row;
}

//all providers
$sql = "SELECT *
              FROM  `pu_subprofile`
              ORDER BY  `pu_subprofile`.`title` ASC  ";
$result_select_oc = mysqli_query($link_PU_DB, $sql) or die(mysqli_error());
while ($row = mysqli_fetch_assoc($result_select_oc)) {
    $all_providers[] = $row;
}

function getProducts($data = array(), $link_OC_DB)
{
    $sql = "SELECT p.product_id, (SELECT AVG(rating) AS total FROM oc_review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT price FROM oc_product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '1' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM oc_product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '1' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special";

    if (!empty($data['filter_category_id'])) {
        if (!empty($data['filter_sub_category'])) {
            $sql .= " FROM oc_category_path cp LEFT JOIN oc_product_to_category p2c ON (cp.category_id = p2c.category_id)";
        } else {
            $sql .= " FROM oc_product_to_category p2c";
        }

        if (!empty($data['filter_filter'])) {
            $sql .= " LEFT JOIN oc_product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN oc_product p ON (pf.product_id = p.product_id)";
        } else {
            $sql .= " LEFT JOIN oc_product p ON (p2c.product_id = p.product_id)";
        }
    } else {
        $sql .= " FROM oc_product p";
    }

    if (!empty($data['filter_manufacturer_id'])) {
        $m_id = $data['filter_manufacturer_id'];
        $sql .= " LEFT JOIN oc_product_description pd ON (p.product_id = pd.product_id) LEFT JOIN oc_product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '2' AND p.status = '1' AND p.manufacturer_id = '$m_id' AND p.date_available <= NOW() AND p2s.store_id = '0'";
    } else {
        $sql .= " LEFT JOIN oc_product_description pd ON (p.product_id = pd.product_id) LEFT JOIN oc_product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '2' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '0'";
    }


    if (!empty($data['filter_category_id'])) {
        if (!empty($data['filter_sub_category'])) {
            $sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
        } else {
            $sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
        }
    }


    $sql .= " GROUP BY p.product_id";
    $products_id = array();

    $result_select_oc = mysqli_query($link_OC_DB, $sql) or die(mysqli_error());
    while ($row = mysqli_fetch_assoc($result_select_oc)) {
        $products_id[] = $row['product_id'];
    }

    return $products_id;
}

if (!isset($_GET["p"])) {
    $page = "0";
} else {
    $page = $_GET["p"];
}
if (!isset($_GET["m"])) {
    $manufacturer_id = false;
    $cur_manufacturer_id = false;
} else {
    $manufacturer_id = $_GET["m"];
    $cur_manufacturer_id = $_GET["m"];
}
if (!isset($_GET["c"])) {
    $category_id = false;
    $cur_category_id = false;
} else {
    $category_id = $_GET["c"];
    $cur_category_id = $_GET["c"];
}
if (!isset($_GET["s"])) {
    $subprofile_name = false;
    $cur_subprofile_name = false;
} else {
    $subprofile_name = $_GET["s"];
    $cur_subprofile_name = $_GET["s"];
}
if (!isset($_GET["v"])) {
    $view_sort = false;
    $cur_view_sort = false;
} else {
    $view_sort = $_GET["v"];
    $cur_view_sort = $_GET["v"];
}
$latest_last=false;
if (isset($_GET["l"])&&$_GET["l"]) {
    $latest_last=true;
}else{
    $latest_last=false;
}
$data = array();
$offset = $page * 6;
$withFilter = false;
if ($category_id && $category_id != "false") {
    $data = array(
        'filter_category_id' => $category_id,
        'filter_sub_category' => true
    );
    $withFilter = true;
    if ($manufacturer_id && $manufacturer_id != "false") {
        $data = array(
            'filter_category_id' => $category_id,
            'filter_sub_category' => true,
            'filter_manufacturer_id' => $manufacturer_id
        );
    }
} else if ($manufacturer_id && $manufacturer_id != "false") {
    $data = array(
        'filter_category_id' => $category_id,
        'filter_sub_category' => true,
        'filter_manufacturer_id' => $manufacturer_id
    );
    $withFilter = true;
}
if($latest_last){
    $sql = "(SELECT DISTINCT(p.product_id) ,sp.update_date FROM sarfe_oc.oc_product p LEFT JOIN sarfe_pu.pu_subprofile_product sp ON (p.product_id = sp.product_id)  GROUP BY p.product_id ORDER BY MAX(sp.update_date) DESC) ORDER BY update_date";
    $result_select = mysqli_query($link_OC_DB, $sql) or die(mysqli_error());
    while ($row = mysqli_fetch_assoc($result_select)) {
        $product_sort[] = $row['product_id'];
    }
    $sort_string = implode($product_sort, ",");
    $sort_string = rtrim($sort_string, ",");
    if ($withFilter) {
        if ($subprofile_name && $subprofile_name != "false") {
            if ($view_sort && $view_sort != "false") {
                $products_id = getProducts($data, $link_OC_DB);
                $sql = "SELECT * FROM `emalls_updated_price` LEFT JOIN sarfe_oc.oc_product ON sarfe_oc.oc_product.product_id = `emalls_updated_price`.related_id WHERE auto_update<>1 AND time > CURDATE() AND `emalls_updated_price`.subprofile_name = '$subprofile_name' AND `emalls_updated_price`.related_id IN ('" . implode($products_id, "', '") . "') ORDER BY FIELD(sarfe_oc.oc_product.product_id, ". $sort_string ."),sarfe_oc.oc_product.viewed $view_sort limit 6 OFFSET $offset";
                $result_select = mysqli_query($link_DB, $sql) or die(mysqli_error());
            }else{
                $products_id = getProducts($data, $link_OC_DB);
                $sql = "SELECT * FROM `emalls_updated_price` WHERE auto_update<>1 AND time > CURDATE() AND subprofile_name = '$subprofile_name' AND related_id IN ('" . implode($products_id, "', '") . "') ORDER BY FIELD(sarfe_oc.oc_product.product_id, ". $sort_string .") limit 6 OFFSET $offset";
                $result_select = mysqli_query($link_DB, $sql) or die(mysqli_error());
            }
        } else {
            if ($view_sort && $view_sort != "false") {
                $products_id = getProducts($data, $link_OC_DB);
                $sql = "SELECT * FROM `emalls_updated_price` LEFT JOIN sarfe_oc.oc_product ON sarfe_oc.oc_product.product_id = `emalls_updated_price`.related_id WHERE auto_update<>1 AND time > CURDATE() AND related_id IN ('" . implode($products_id, "', '") . "') ORDER BY FIELD(sarfe_oc.oc_product.product_id, ". $sort_string ."), sarfe_oc.oc_product.viewed $view_sort limit 6 OFFSET $offset";
                $result_select = mysqli_query($link_DB, $sql) or die(mysqli_error());
            }else{
                $products_id = getProducts($data, $link_OC_DB);
                $sql = "SELECT * FROM `emalls_updated_price` WHERE auto_update<>1 AND time > CURDATE() AND related_id IN ('" . implode($products_id, "', '") . "') ORDER BY FIELD(sarfe_oc.oc_product.product_id, ". $sort_string .") limit 6 OFFSET $offset";
                $result_select = mysqli_query($link_DB, $sql) or die(mysqli_error());
            }
        }
    } else {
        if ($subprofile_name && $subprofile_name != "false") {
            if ($view_sort && $view_sort != "false") {
                $sql = "SELECT * FROM `emalls_updated_price` LEFT JOIN sarfe_oc.oc_product ON sarfe_oc.oc_product.product_id = `emalls_updated_price`.related_id WHERE auto_update<>1 AND time > CURDATE() AND subprofile_name = '$subprofile_name' ORDER BY FIELD(sarfe_oc.oc_product.product_id, ". $sort_string ."), sarfe_oc.oc_product.viewed $view_sort limit 6 OFFSET $offset";
                $result_select = mysqli_query($link_DB, $sql) or die(mysqli_error());
            }else{
                $sql = "SELECT * FROM `emalls_updated_price` WHERE auto_update<>1 AND time > CURDATE() AND subprofile_name = '$subprofile_name' ORDER BY FIELD(sarfe_oc.oc_product.product_id, ". $sort_string .") limit 6 OFFSET $offset";
                $result_select = mysqli_query($link_DB, $sql) or die(mysqli_error());
            }
        } else {
            if ($view_sort && $view_sort != "false") {
                $sql = "SELECT * FROM `emalls_updated_price` LEFT JOIN sarfe_oc.oc_product ON sarfe_oc.oc_product.product_id = `emalls_updated_price`.related_id  WHERE auto_update<>1 AND time > CURDATE() ORDER BY FIELD(sarfe_oc.oc_product.product_id, ". $sort_string ."), sarfe_oc.oc_product.viewed $view_sort limit 6 OFFSET $offset";
                $result_select = mysqli_query($link_DB, $sql) or die(mysqli_error());
            }else{
                $sql = "SELECT * FROM `emalls_updated_price` LEFT JOIN sarfe_oc.oc_product ON sarfe_oc.oc_product.product_id = `emalls_updated_price`.related_id  WHERE auto_update<>1 AND time > CURDATE() ORDER BY FIELD(sarfe_oc.oc_product.product_id, ". $sort_string .") limit 6 OFFSET $offset";
                $result_select = mysqli_query($link_DB, $sql) or die(mysqli_error());
            }
        }
    }
}else {
    if ($withFilter) {
        if ($subprofile_name && $subprofile_name != "false") {
            if ($view_sort && $view_sort != "false") {
                $products_id = getProducts($data, $link_OC_DB);
                $sql = "SELECT * FROM `emalls_updated_price` LEFT JOIN sarfe_oc.oc_product ON sarfe_oc.oc_product.product_id = `emalls_updated_price`.related_id WHERE auto_update<>1 AND time > CURDATE() AND `emalls_updated_price`.subprofile_name = '$subprofile_name' AND `emalls_updated_price`.related_id IN ('" . implode($products_id, "', '") . "') ORDER BY sarfe_oc.oc_product.viewed $view_sort limit 6 OFFSET $offset";
                $result_select = mysqli_query($link_DB, $sql) or die(mysqli_error());
            } else {
                $products_id = getProducts($data, $link_OC_DB);
                $sql = "SELECT * FROM `emalls_updated_price` WHERE auto_update<>1 AND time > CURDATE() AND subprofile_name = '$subprofile_name' AND related_id IN ('" . implode($products_id, "', '") . "') limit 6 OFFSET $offset";
                $result_select = mysqli_query($link_DB, $sql) or die(mysqli_error());
            }
        } else {
            if ($view_sort && $view_sort != "false") {
                $products_id = getProducts($data, $link_OC_DB);
                $sql = "SELECT * FROM `emalls_updated_price` LEFT JOIN sarfe_oc.oc_product ON sarfe_oc.oc_product.product_id = `emalls_updated_price`.related_id WHERE auto_update<>1 AND time > CURDATE() AND related_id IN ('" . implode($products_id, "', '") . "') ORDER BY sarfe_oc.oc_product.viewed $view_sort limit 6 OFFSET $offset";
                $result_select = mysqli_query($link_DB, $sql) or die(mysqli_error());
            } else {
                $products_id = getProducts($data, $link_OC_DB);
                $sql = "SELECT * FROM `emalls_updated_price` WHERE auto_update<>1 AND time > CURDATE() AND related_id IN ('" . implode($products_id, "', '") . "') limit 6 OFFSET $offset";
                $result_select = mysqli_query($link_DB, $sql) or die(mysqli_error());
            }
        }
    } else {
        if ($subprofile_name && $subprofile_name != "false") {
            if ($view_sort && $view_sort != "false") {
                $sql = "SELECT * FROM `emalls_updated_price` LEFT JOIN sarfe_oc.oc_product ON sarfe_oc.oc_product.product_id = `emalls_updated_price`.related_id WHERE auto_update<>1 AND time > CURDATE() AND subprofile_name = '$subprofile_name' ORDER BY sarfe_oc.oc_product.viewed $view_sort limit 6 OFFSET $offset";
                $result_select = mysqli_query($link_DB, $sql) or die(mysqli_error());
            } else {
                $sql = "SELECT * FROM `emalls_updated_price` WHERE auto_update<>1 AND time > CURDATE() AND subprofile_name = '$subprofile_name' limit 6 OFFSET $offset";
                $result_select = mysqli_query($link_DB, $sql) or die(mysqli_error());
            }
        } else {
            if ($view_sort && $view_sort != "false") {
                $sql = "SELECT * FROM `emalls_updated_price` LEFT JOIN sarfe_oc.oc_product ON sarfe_oc.oc_product.product_id = `emalls_updated_price`.related_id  WHERE auto_update<>1 AND time > CURDATE() ORDER BY sarfe_oc.oc_product.viewed $view_sort limit 6 OFFSET $offset";
                $result_select = mysqli_query($link_DB, $sql) or die(mysqli_error());
            } else {
                $sql = "SELECT * FROM `emalls_updated_price` WHERE auto_update<>1 AND time > CURDATE() limit 6 OFFSET $offset";
                $result_select = mysqli_query($link_DB, $sql) or die(mysqli_error());
            }
        }
    }
}
$sql = "SELECT * FROM `emalls_updated_price` WHERE auto_update<>1 AND time > CURDATE()";
$result = mysqli_query($link_DB, $sql) or die(mysqli_error($con_rb));
$site_bot_count = mysqli_num_rows($result);
$sql = "SELECT * FROM `emalls_updated_price` WHERE auto_update<>1 AND time > CURDATE() AND is_r =1";
$result = mysqli_query($link_DB, $sql) or die(mysqli_error($con_rb));
$site_bot_aded_count = mysqli_num_rows($result);

?>
<?php
//$categories = $this->model_catalog_category->getCategories(0);
$queryCategories = "SELECT * FROM oc_category c LEFT JOIN oc_category_description cd ON (c.category_id = cd.category_id) LEFT JOIN oc_category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '0' AND cd.language_id = '2' AND c2s.store_id = '0'  AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)";

//$sql_oc = "SELECT price,model FROM `oc_product` WHERE product_id=$related_id";
$result_select_oc = mysqli_query($link_OC_DB, $queryCategories) or die(mysqli_error());
while ($row = mysqli_fetch_assoc($result_select_oc)) {
    $categories[] = $row;
}
foreach ($categories as $category) {
    $category_id = $category['category_id'];
    $queryCategories = "SELECT * FROM oc_category c LEFT JOIN oc_category_description cd ON (c.category_id = cd.category_id) LEFT JOIN oc_category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '$category_id' AND cd.language_id = '2' AND c2s.store_id = '0'  AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)";

    //$sql_oc = "SELECT price,model FROM `oc_product` WHERE product_id=$related_id";
    $result_select_oc = mysqli_query($link_OC_DB, $queryCategories) or die(mysqli_error());
    while ($row = mysqli_fetch_assoc($result_select_oc)) {
        $children[] = $row;
    }
}

?>
<select id="sel-lastupdate">
    <option value="false" selected>
نمایش بر اساس  بروزرسانی
    </option>
    <option value="true" <?php if ($latest_last) echo 'selected="selected"'; ?>>
        دیرترین بروزرسانی در ابتدا
    </option>
</select>
<select id="sel-views">
    <option value="false" selected>
        نمایش بر اساس تعداد بازدید کالا    </option>
    <option
        value="ASC" <?php if ("ASC" == $cur_view_sort) echo 'selected="selected"'; ?>>
        بیشترین بازدید در ابتدا
    </option>
    <option
        value="DESC" <?php if ("DESC" == $cur_view_sort) echo 'selected="selected"'; ?>>
        کمترین بازدید در ابتدا
    </option>
</select>
<select id="sel-providers">
    <option value="false" selected>
        تمامی عرضه کنندگان
    </option>
    <?php foreach ($all_providers as $p) { ?>
        <option
            value="<?php echo $p['title']; ?>" <?php if ($p['title'] == $cur_subprofile_name) echo 'selected="selected"'; ?>>
            <?php echo $p['title']; ?>
        </option>
    <?php } ?>
</select>
<select id="sel-manufacturers">
    <option value="false">
        تمامی برندها
    </option>
    <?php foreach ($manufacturers as $manufacturer) { ?>
        <option
            value="<?php echo $manufacturer['manufacturer_id']; ?>" <?php if ($manufacturer['manufacturer_id'] == $cur_manufacturer_id) echo 'selected="selected"'; ?>>
            <?php echo $manufacturer['name']; ?>
        </option>
    <?php } ?>
</select>
<select id="sel-categories">
    <option value="false">
        تمامی گروه ها
    </option>
    <?php foreach ($children as $category) { ?>
        <option
            value="<?php echo $category['category_id']; ?>" <?php if ($category['category_id'] == $cur_category_id) echo 'selected="selected"'; ?>>
            <?php echo $category['name']; ?>
        </option>
    <?php } ?>
</select>


<div style="width:100%;display:block;margin:auto;direction:rtl;">

    <?php
    $count = 0;
    while ($row = mysqli_fetch_assoc($result_select)) {

        $count++;

        $c_id = $row['id'];
        $related_id = $row['related_id'];
        $subprofile_name = $row['subprofile_name'];
        $price = $row['price'];
        $text = $row['text'];
        $time = $row['time'];
        $is_r = $row['is_r'];

        $timestamp = strtotime($time);

        $sql_oc = "SELECT emalls_id FROM `emals_related` WHERE product_id=$related_id";
        $result_select_oc = mysqli_query($link_DB, $sql_oc) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select_oc)) {
            $emalls_id = $row['emalls_id'];
        }

        $price_avg = 0;
        $sql_oc = "SELECT price,model FROM `oc_product` WHERE product_id=$related_id";
        $result_select_oc = mysqli_query($link_OC_DB, $sql_oc) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select_oc)) {
            $price_avg = $row['price'];
            $model = $row['model'];
        }

        $sql_related_subprofile = "SELECT subprofile_id FROM emalls_related_subprofile WHERE emalls_subprofile = '$subprofile_name'";
        $result_related_subprofile = mysqli_query($link_DB, $sql_related_subprofile) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_related_subprofile)) {
            $subprofile_id = $row['subprofile_id'];
        }

        $price_sp = 0;
        $i_customer_id = 0;
        $i_title = '';
        if (!empty($subprofile_id) && isset($subprofile_id)) {
            $sql_pu = "SELECT customer_id, title, logo FROM pu_subprofile WHERE id =$subprofile_id ";
            $result_select_pu = mysqli_query($link_PU_DB, $sql_pu) or die(mysqli_error());
            while ($row = mysqli_fetch_assoc($result_select_pu)) {
                $i_customer_id = $row['customer_id'];
                $i_title = $row['title'];
                $i_logo = $row['logo'];
            }

            $view_count = '';
            $sql_pu = "SELECT * FROM pu_subprofile_product WHERE subprofile_id =$subprofile_id  AND  product_id = $related_id";
            $result_select_pu = mysqli_query($link_PU_DB, $sql_pu) or die(mysqli_error());
            while ($row = mysqli_fetch_assoc($result_select_pu)) {
                $price_sp = $row['price'];
                $buy_link = $row['buy_link'];
                $view_count = $row['view_count'];
            }
        }
        if ($i_customer_id == 15) {
            $i_customer_id = 'S';
            $i_customer_id_r = '15';
        } elseif ($i_customer_id == 23) {
            $i_customer_id = 'S';
            $i_customer_id_r = '23';
        } elseif ($i_customer_id == 0) {
            $i_customer_id = 'ناموجود در صرفه جو';
        } else {
            $i_customer_id = 'c:' . $i_customer_id;
        }
        ?>

        <div class="pp">
            <?php if (!empty($subprofile_id) && isset($subprofile_id)) { ?>

                <?php if ($is_r == 0) { ?>
                <?php if ($price_sp != 0) { ?>
                <span id="upd<?php echo $count ?>" class="upd">ثبت قیمت جدید</span>
            <input type="checkbox" name="auto-update<?php echo $count ?>" value="male">
                بروزرسانی خودکاربرای یک هفته
            <br/>
            <?php } else { ?>
                <span id="ins<?php echo $count ?>" class="ins">افزودن کالا</span>
            <?php } ?>
            <?php } else { ?>
                <span id="is_r<?php echo $count ?>" class="ins2">امروز ثبت شده است.</span>
            <?php } ?>

                <script language="JavaScript" type="text/javascript">

                    $(document).ready(function () {
                        $("#upd<?php echo $count  ?>").click(function () {
                            var isChecked = $("input[name='auto-update<?php echo $count ?>']").is(":checked") ? 1:0;
                            var subprofile = '<?php echo $subprofile_id  ?>';
                            var dec = '<?php echo $text ?>';
                            var price = $("#newPrice<?php echo $count ?>").val();
                            var product = '<?php echo $related_id ?>';
                            var c_id = '<?php echo $c_id ?>';
                            var subprofile_name = '<?php echo $subprofile_name; ?>';
                            var text = '<?php echo $text ?>';

                            var url = 'udp.php?pid=' + product + '&s=' + subprofile + '&p=' + price + '&d=' + dec + '&c_id=' + c_id + '&auto_update=' + isChecked + '&subprofile_name=' + subprofile_name + '&text=' + text;

                            $.ajax({
                                type: "GET",
                                url: url,
                                success: function (data) {
                                    $('#upd<?php echo $count  ?>').css("background-color", "green");
                                    $('#upd<?php echo $count  ?>').text('ثبت شد.');
                                    $('#old-<?php echo $count  ?>').text('<?php echo number_format($price) ?>');
                                }
                            });
                            return false;
                            e.preventDefault();
                        });
                        $("#ins<?php echo $count  ?>").click(function () {
                            var subprofile = '<?php echo $subprofile_id  ?>';
                            var dec = '<?php echo$text ?>';
                            var price = '<?php echo $price ?>';
                            var product = '<?php echo $related_id ?>';
                            var c_id = '<?php echo $c_id ?>';

                            var url = 'ins.php?pid=' + product + '&s=' + subprofile + '&p=' + price + '&d=' + dec + '&c_id=' + c_id;

                            $.ajax({
                                type: "GET",
                                url: url,
                                success: function (data) {
                                    $('#ins<?php echo $count  ?>').css("background-color", "green");
                                    $('#ins<?php echo $count  ?>').text('افزوده شد.');
                                    $('#old-<?php echo $count  ?>').text('<?php echo number_format($price) ?>');
                                }
                            });
                            return false;
                            e.preventDefault();
                        });

                        $('.upblc').hide('');
                        $("#in-upblc-<?php echo $count;  ?>").change(function () {
                            $('#upblc-<?php echo $count  ?>').show('');
                        });
                        $("#in-upblc-<?php echo $count;  ?>").keypress(function () {
                            $('#upblc-<?php echo $count  ?>').show('');
                        });

                        $("#upblc-<?php echo $count  ?>").click(function () {
                            var link = $('#in-upblc-<?php echo $count;  ?>').val();
                            for(var i=0;i<10;i++){

                                var link = link.replace("&", "%26");
                            }
                            var subprofile = '<?php echo $subprofile_id  ?>';
                            var product = '<?php echo $related_id ?>';

                            var url = 'blink.php?pid=' + product + '&s=' + subprofile + '&link=' + link;

                            $.ajax({
                                type: "GET",
                                url: url,
                                success: function (data) {
                                    $('#upblc-<?php echo $count  ?>').css("background-color", "green");
                                    $('#upblc-<?php echo $count  ?>').text('OK');
                                    $('#in-upblc-<?php echo $count;  ?>').val(link);
                                }
                            });
                            return false;
                            e.preventDefault();
                        });

                    });
                </script>
            <?php } ?>
            <?php if (date("Y-m-d", $timestamp) == date("Y-m-d")) { ?>
                <div class="logo">
                    <img
                        src="../ProvidersScans/<?php echo $i_customer_id_r . '/' . $subprofile_id . '/' . 'logo_' . $i_logo ?>"/>
                </div>
            <?php } else { ?>
                <span style="color:#FF2255;font-size:12px;direction:ltr;"><?php echo date("Y-m-d", $timestamp) ?></span>
            <?php } ?><br/><br/>
            <?php if (!empty($subprofile_id) && isset($subprofile_id)) { ?>
                <div class="bl-c">
                    <?php if (!empty($buy_link)) { ?>
                        <a target="_blank" href="<?php echo $buy_link; ?>" title="نمایش" class="openbuy">@</a>
                    <?php } ?>
                    <input id="in-upblc-<?php echo $count; ?>" placeholder="http://" type="text"
                           value="<?php echo $buy_link; ?>" class="buy-link"/>
                    <span class="upblc" id="upblc-<?php echo $count ?>">UP</span>
                </div>
            <?php } ?>
            فروشگاه: <span style="color:#5555FF;font-size:10px;"><?php echo $subprofile_name ?></span>
            <span style="float:left;color:#993DD5;font-size:10px;">[<?php echo $i_customer_id ?>]</span>
            <span style="float:left;">&nbsp;<?php echo $i_title ?>&nbsp;</span>
            <br/>
            کالا: <span style="color:#5555FF;"><?php echo $model ?></span>
         <span style="float:left;">
         <a href="../index.php?route=product/product&product_id=<?php echo $related_id ?>"
            title="Sarfejoo: <?php echo $related_id ?>" target="_blank">IN</a> |
         <a href="http://sarfejoo.com/uoo.php?u=emalls.ir/price_compar.aspx?ID=<?php echo $emalls_id ?>"
            title="Emalls: <?php echo $emalls_id ?>" target="_blank">OUT</a>
             <?php if (isset($view_count)) { ?>
                 -  بازدید: <?php echo $view_count; ?> بار
             <?php } ?>
         </span>
            <br/>
            قیمت فعلی: <span id="old-<?php echo $count ?>"
                             style="float:left;color:#888;font-size:14px;"><b><?php echo number_format($price_sp) ?></b></span>
            <br/>
            قیمت جدید:
            <span style="float:left;color:#FF2255;font-size:14px;"><b><?php echo number_format($price) ?></b></span><br/>
            <input type="text" style="float:left;width:30%;text-align:left;" id="newPrice<?php echo $count ?>" value="<?php echo $price ?>" />

            <br/>
            قیمت صرفه جو: <span
                style="float:left;color:#55aa55;font-size:14px;"><b><?php echo number_format($price_avg) ?></b></span><br/>
            توضیحات: <span style="color:#5555FF;font-size:10px;"><?php echo $text; ?></span>
        </div>



        <?php

        $subprofile_id = '';
    }

    ?>
</div>
<div id="pagenation">
    <?php
    $next = $page + 1;
    $back = $page - 1;
    ?>
    <span id="next" class="pa" style="float:left;">صفحه بعد</span>
    <span id="page" class="pa2" style="float:left;">صفحه حاضر: <?php echo $page ?>
        &nbsp;&nbsp;&nbsp;&nbsp; <b style="color:#ccc;">|</b> &nbsp;&nbsp;&nbsp;&nbsp;
    کل موارد: <?php echo $site_bot_count ?>
        &nbsp;&nbsp;&nbsp;&nbsp; <b style="color:#ccc;">|</b> &nbsp;&nbsp;&nbsp;&nbsp;
    ثبت شده: <?php echo $site_bot_aded_count ?>
        &nbsp;&nbsp;&nbsp;&nbsp; <b style="color:#ccc;">|</b> &nbsp;&nbsp;&nbsp;&nbsp;
    باقیمانده: <?php echo $site_bot_count - $site_bot_aded_count ?>
        &nbsp;&nbsp;&nbsp;&nbsp; <b style="color:#ccc;">|</b> &nbsp;&nbsp;&nbsp;&nbsp;
    کل صفحات: <?php echo ceil($site_bot_count / 6) ?></span>
    <?php if ($page > 0) { ?>
        <span id="back" class="pa" style="float:right;">صفحه قبل</span>
    <?php } ?>

</div>
<script language="JavaScript" type="text/javascript">
    $(document).ready(function () {
        $("#back").click(function () {
            window.location.href = "list.php?p=<?php echo $back ?>&c=<?php echo $cur_category_id ?>&m=<?php echo $cur_manufacturer_id ?>&s=<?php echo $cur_subprofile_name ?>&v=<?php echo $cur_view_sort ?>&l=<?php echo $latest_last ?>";
        });
        $("#next").click(function () {
            window.location.href = "list.php?p=<?php echo $next ?>&c=<?php echo $cur_category_id ?>&m=<?php echo $cur_manufacturer_id ?>&s=<?php echo $cur_subprofile_name ?>&v=<?php echo $cur_view_sort ?>&l=<?php echo $latest_last ?>";
        });
        $("#sel-categories").change(function () {
            window.location.href = "list.php?c=" + $(this).val()+"&m=<?php echo $cur_manufacturer_id ?>&s=<?php echo $cur_subprofile_name ?>&l=<?php echo $latest_last ?>";
        });
        $("#sel-manufacturers").change(function () {
            window.location.href = "list.php?m=" + $(this).val()+"&c=<?php echo $cur_category_id ?>&s=<?php echo $cur_subprofile_name ?>&l=<?php echo $latest_last ?>";
        });
        $("#sel-providers").change(function () {
            window.location.href = "list.php?s=" + $(this).val()+"&m=<?php echo $cur_manufacturer_id ?>&c=<?php echo $cur_category_id ?>&l=<?php echo $latest_last ?>";
        });
        $("#sel-views").change(function () {
            window.location.href = "list.php?v=" + $(this).val()+"&m=<?php echo $cur_manufacturer_id ?>&c=<?php echo $cur_category_id ?>&s=<?php echo $cur_subprofile_name ?>&l=<?php echo $latest_last ?>";
        });
        $("#sel-lastupdate").change(function () {
            window.location.href = "list.php?l=" + $(this).val()+"&m=<?php echo $cur_manufacturer_id ?>&c=<?php echo $cur_category_id ?>&s=<?php echo $cur_subprofile_name ?>&v=<?php echo $cur_view_sort ?>";
        });
    });
</script>
<?php } ?>