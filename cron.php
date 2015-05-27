<?php

ini_set('max_execution_time', 0); 

require_once('provider.php');
require_once('settings.php');
$pu_database_name = $GLOBALS['pu_database_name'];
$oc_database_name = $GLOBALS['oc_database_name'];
$type = "";
if (isset($_GET["type"]))
    $type = $_GET["type"];
switch ($type) {
    case "update-price":
# Start Free Oc Prices
              $admin_price_products_id = array(
                                                            "452",
                                                            "459",
                                                            "461", 
                                                            "463",
                                                            "1233",
                                                            "455",
                                                            "457",
                                                            "453",
                                                            "1231"
                                                       );                                                 
               $sql = "UPDATE oc_product SET price = '0' WHERE product_id NOT IN ( '" . implode($admin_price_products_id, "', '") . "' )";
                      $retval = mysqli_query($con_OC_db, $sql);
                      if (!$retval) {
                          die('Could not update data: ' . mysqli_error());
                      }
        $sql = "DELETE FROM `pu_product_avg` WHERE 1";
        $retval = mysqli_query($con_PU_db, $sql);
# End Free Oc Prices
        $sql_select_string = "SELECT product_id  FROM `pu_subprofile_product` WHERE availability = 0 AND `update_date` > DATE_SUB(CURDATE(), INTERVAL 60 DAY)  AND status_id = 1 GROUP BY product_id";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $product_all[] = $row;
        }
        foreach ($product_all as $row) {
          $product_id = $row['product_id'];
# Start Update Avrage Price By ID
            $sql_select_string = "SELECT product_id, AVG(price)  FROM `pu_subprofile_product` WHERE `product_id`= $product_id and `availability`=0 AND `update_date` > DATE_SUB(CURDATE(), INTERVAL 60 DAY)  AND status_id = 1";
            $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
            while ($row = mysqli_fetch_assoc($result_select)) {
                $avg_price = $row['AVG(price)'];
            }
            $sql = "INSERT INTO pu_product_property (
                                                                           product_id,
                                                                           average_price
                                                           ) VALUES (
                                                                           '$product_id',
                                                                           '$avg_price'
                                                                        )";
            $retval = mysqli_query($con_PU_db, $sql);
            if (!$retval) {
                die('Could not update data: ' . mysqli_error($con_PU_db));
            }
            $sql = "INSERT INTO pu_product_avg (
                                                                           product_id,
                                                                           average_price
                                                           ) VALUES (
                                                                           '$product_id',
                                                                           '$avg_price'
                                                                        )";
            $retval = mysqli_query($con_PU_db, $sql);
            if (!$retval) {
                die('Could not update data: ' . mysqli_error($con_PU_db));
            }
            //
            echo '<br />';
            echo "Updated Avrage Price for $product_id to $avg_price\n";
            echo '<br />';
# End Update Avrage Price By ID
               if (!in_array($product_id, $admin_price_products_id)) {
# Start Update Price To Minimum By ID
                      $sql_select_string = "SELECT MIN(price) FROM `pu_subprofile_product` WHERE product_id = $product_id and availability = 0";
                      $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
                      while ($row = mysqli_fetch_assoc($result_select)) {
                          $min_price = $row['MIN(price)'];
                      }
                      $sql = "UPDATE oc_product SET price = '" . $min_price . "' WHERE product_id = '" . $product_id . "'";
                      $retval = mysqli_query($con_OC_db, $sql);
                      if (!$retval) {
                          die('Could not update data: ' . mysqli_error());
                      }
                      //
                      echo '<br />';
                      echo "Updated Price for $product_id to $min_price\n";
                      echo '<br />';
# End UpdaT te Price To Minimum By ID
               }
        }
        break;
        
#SELECT CONCAT(type,' ',class) FROM `pu_attributetype`
    case "update-custom-tags":
        set_time_limit(0);
        $sql = "DELETE FROM pu_custom_tags WHERE 1;";
        $retval = mysqli_query($con_PU_db, $sql);
        $sql = "ALTER TABLE pu_custom_tags AUTO_INCREMENT = 1";
        $retval = mysqli_query($con_PU_db, $sql);
        $sql_select_string = "SELECT DISTINCT p.text,a.name FROM $oc_database_name.oc_product_attribute p,$oc_database_name.oc_attribute_description a WHERE p.attribute_id = a.attribute_id AND p.attribute_id <> 114 AND p.attribute_id <> 80 and p.text <> 'ندارد'ORDER BY text";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        $count = 0;
        while ($row = mysqli_fetch_assoc($result_select)) {
            $text = $row['text'];
            if ($text != "" && strlen($text) > 4) {
                $sql_select_string2 = "SELECT product_id FROM $oc_database_name.oc_product_attribute WHERE text='$text' AND attribute_id <> 114 AND attribute_id <> 80";
                $result_select2 = mysqli_query($con_PU_db, $sql_select_string2) or die(mysqli_error());
                $pIds = "";
                $searchTerm = $text;
                while ($row2 = mysqli_fetch_assoc($result_select2)) {
                    if ($text == "دارد") {
                        $searchTerm = $row['name'];
                    }
                    if ($pIds == "")
                        $pIds .= $row2['product_id'];
                    else
                        $pIds .= "," . $row2['product_id'];
                }
                $sql = "INSERT INTO pu_custom_tags (tag,products_id) VALUES ('$searchTerm','$pIds')";
                $retval = mysqli_query($con_PU_db, $sql);
                if (!$retval) {
                    die('Could not update data: ' . mysqli_error($con_PU_db));
                }
            }
        }


        $sql_select_string = "SELECT DISTINCT value FROM pu_attribute_value WHERE value<>'ندارد'";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        $count = 0;

        while ($row = mysqli_fetch_assoc($result_select)) {
            $value = $row['value'];
            $sql_select_string2 = "SELECT * FROM pu_attribute_value av,pu_subprofile_product_attribute spa,$oc_database_name.oc_attribute_description ad WHERE av.value='$value' AND av.id = spa.value AND ad.attribute_id = av.attribute_id AND av.value <> 'ندارد'";
            $result_select2 = mysqli_query($con_PU_db, $sql_select_string2) or die(mysqli_error());
            $tag = $row['value'];
            $subprofileIds = "";
            while ($row2 = mysqli_fetch_assoc($result_select2)) {
                if ($tag == "دارد") {
                    $tag = $row2['name'];
                }
                if ($subprofileIds == "") {
                    $subprofileId = $row2['subprofile_id'];
                    $subprofileIds = $subprofileId;
                } else {
                    $subprofileId = $row2['subprofile_id'];
                    $subprofileIds .= "," . $subprofileId;
                }
            }
            $sql = "INSERT INTO pu_custom_tags (tag,subprofiles_id) VALUES ('$tag','$subprofileIds')";
            $retval = mysqli_query($con_PU_db, $sql);
            if (!$retval) {
                die('Could not update data: ' . mysqli_error($con_PU_db));
            }
        }
        break;
    case "update-category-views":
        $sql_select_string = "SELECT 
                                             ptc.category_id,
                                             c.parent_id,
                                             c.sort_order,
                                             sum(viewed) 
                                       FROM 
                                             `oc_category` c,
                                             `oc_product_to_category` ptc,
                                             `oc_product` p
                                       WHERE 
                                             c.category_id = ptc.category_id
                                    GROUP BY 
                                             c.parent_id";
        $result_select = mysqli_query($con_OC_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $category_count[] = $row;
        }
        mysqli_query($con_PU_db,'TRUNCATE TABLE pu_category_view');
        foreach ($category_count as $row) {
        
            $category_id = $row['category_id'];
            $sum_viewed = $row['sum(viewed)'];
            $parent_id = $row['parent_id'];
            $sort_order = $row['sort_order'];
       
          $sql = "INSERT INTO pu_category_view (
                                                 related_id,
                                                 subprofile_name,
                                                 price,
                                                 text
                                                )
                                        VALUES 
                                                (
                                                 '$category_id',
                                                 '$subprofile_name',
                                                 '$price',
                                                 '$text'
                                             )";
          $retval = mysqli_query($con_PU_db, $sql);
          if (!$retval) {
              die('Could not update data: ' . mysqli_error());
          }
     echo $category_id . ' > ' . $sum_viewed . '<br />';
         }
        break;
    case "":
        echo "PLEASE SET TYPE!!!!!!!";
        break;
}