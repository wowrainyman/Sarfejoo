<?php
###############################
### list.php - 10:47 AM 4/23/2015 by M.Abooali
###############################
require_once "config.php";


	$emalls_users_info="";
     $sql = "SELECT COUNT(*) AS count,user FROM `emalls_updated_price` WHERE is_r=1 AND time > CURDATE() GROUP BY user";
     $result = mysqli_query($link_DB, $sql) or die(mysqli_error($con_rb));
     while ($row = mysqli_fetch_assoc($result)) {
     	if($row['user']!=''){
	     	$emalls_users_info .= $row['user'];
	     	$emalls_users_info .= ',';
	     	$emalls_users_info .= $row['count'];
	     	$emalls_users_info .= ';';
     	}
     }
     
     $digi_users_info="";
     $sql = "SELECT COUNT(*) AS count,user FROM `digikala_updated_price` WHERE is_r=1 AND time > CURDATE() GROUP BY user";
     $result = mysqli_query($link_DB, $sql) or die(mysqli_error($con_rb));
     while ($row = mysqli_fetch_assoc($result)) {
     	if($row['user']!=''){
	     	$digi_users_info .= $row['user'];
	     	$digi_users_info .= ',';
	     	$digi_users_info .= $row['count'];
	     	$digi_users_info .= ';';
     	}
     }

     $sql = "SELECT * FROM `digikala_updated_price` WHERE time > CURDATE()";
     $result = mysqli_query($link_DB, $sql) or die(mysqli_error($con_rb));
     $hidigi_all = mysqli_num_rows($result);

     $sql = "SELECT * FROM `digikala_updated_price` WHERE is_r=1 AND time > CURDATE()";
     $result = mysqli_query($link_DB, $sql) or die(mysqli_error($con_rb));
     $hidigi = mysqli_num_rows($result);

     $sql = "SELECT * FROM `emalls_updated_price` WHERE time > CURDATE()";
     $result = mysqli_query($link_DB, $sql) or die(mysqli_error($con_rb));
     $bot_all= mysqli_num_rows($result);

     $sql = "SELECT * FROM `emalls_updated_price` WHERE is_r=1 AND time > CURDATE()";
     $result = mysqli_query($link_DB, $sql) or die(mysqli_error($con_rb));
     $bot = mysqli_num_rows($result);

     $sql = "SELECT * FROM `joo_posts` WHERE post_status='publish' AND post_date > CURDATE()";
     $result = mysqli_query($link_Blog_DB, $sql) or die(mysqli_error($con_rb));
     $blog = mysqli_num_rows($result);

     $sql = "SELECT * FROM `pu_subprofile` WHERE time > CURDATE()";
     $result = mysqli_query($link_PU_DB, $sql) or die(mysqli_error($con_rb));
     $sub= mysqli_num_rows($result);

     $sql = "SELECT * FROM `oc_customer` WHERE customer_group_id=1 AND date_added > CURDATE()";
     $result = mysqli_query($link_OC_DB, $sql) or die(mysqli_error($con_rb));
     $costumer= mysqli_num_rows($result);

     $sql = "SELECT * FROM `oc_customer` WHERE  customer_group_id=2 AND date_added > CURDATE()";
     $result = mysqli_query($link_OC_DB, $sql) or die(mysqli_error($con_rb));
     $provider= mysqli_num_rows($result);

     $sql = "SELECT * FROM `oc_category` WHERE date_modified > CURDATE()";
     $result = mysqli_query($link_OC_DB, $sql) or die(mysqli_error($con_rb));
     $cat_edit= mysqli_num_rows($result);

     $sql = "SELECT * FROM `oc_category` WHERE date_added > CURDATE()";
     $result = mysqli_query($link_OC_DB, $sql) or die(mysqli_error($con_rb));
     $cat_new = mysqli_num_rows($result);
     $cat_edit=$cat_edit-$cat_new;

     $sql = "SELECT * FROM `oc_product` WHERE date_modified > CURDATE()";
     $result = mysqli_query($link_OC_DB, $sql) or die(mysqli_error($con_rb));
     $pro_edit= mysqli_num_rows($result);

     $sql = "SELECT * FROM `oc_product` WHERE date_added > CURDATE()";
     $result = mysqli_query($link_OC_DB, $sql) or die(mysqli_error($con_rb));
     $pro_new= mysqli_num_rows($result);
     $pro_edit=$pro_edit-$pro_new;

     $sql = "SELECT * FROM `user_hi` WHERE date > CURDATE()";
     $result = mysqli_query($link_DB, $sql) or die(mysqli_error($con_rb));
     $today= mysqli_num_rows($result);

if ($today==0) {
               mysqli_query($link_DB , "INSERT INTO `manirahn_sarfe_bot`.`user_hi` ( 
                                                            `hidigi_all`, 
                                                            `hidigi`, 
                                                            `bot_all`, 
                                                            `bot`, 
                                                            `new_product`, 
                                                            `edited_product`, 
                                                            `new_group`, 
                                                            `edited_group`, 
                                                            `new_user`, 
                                                            `new_provider`, 
                                                            `new_subprofile`, 
                                                            `blog`, 
                                                            `site_view`, 
                                                            `hidigi_users`, 
                                                            `bot_users`
                                                ) VALUES (
                                                            '$hidigi_all', 
                                                            '$hidigi', 
                                                            '$bot_all', 
                                                            '$bot', 
                                                            '$pro_new', 
                                                            '$pro_edit', 
                                                            '$cat_new', 
                                                            '$cat_edit', 
                                                            '$costumer', 
                                                            '$provider', 
                                                            '$sub', 
                                                            '$blog', 
                                                            '0', 
                                                            '$emalls_users_info', 
                                                            '$digi_users_info'
                                                         )
                                   ");
} else {
         mysqli_query($link_DB , "UPDATE `manirahn_sarfe_bot`.`user_hi` SET
                                                      hidigi_all=$hidigi_all,
                                                      hidigi=$hidigi,
                                                      bot_all=$bot_all,
                                                      bot=$bot, 
                                                      new_product=$pro_new, 
                                                      edited_product=$pro_edit, 
                                                      new_group=$cat_new, 
                                                      edited_group=$cat_edit, 
                                                      new_user=$costumer, 
                                                      new_provider=$provider, 
                                                      new_subprofile=$sub, 
                                                      blog=$blog, 
                                                      site_view=0, 
                                                      hidigi_users='$digi_users_info', 
                                                      bot_users='$emalls_users_info'
                                             WHERE
                                                      date > CURDATE()
         ");
}
?>