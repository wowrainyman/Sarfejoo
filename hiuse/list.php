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
<?php
###############################
### list.php - 10:47 AM 3/9/2015 by M.Abooali
###############################
require_once "config.php";
error_reporting(0);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=0.8">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

<style>
@font-face {
	font-family: 'BYekan';
	src: url('http://sarfejoo.com/catalog/view/theme/default/fonts/cb_Yekan_3.eot?#') format('eot'),       /* IE6â€“8 */
	url('http://sarfejoo.com/catalog/view/theme/default/fonts/cb_Yekan_3.woff') format('woff'),       /* FF3.6+, IE9, Chrome6+, Saf5.1+*/
	url('http://sarfejoo.com/catalog/view/theme/default/fonts/cb_Yekan_3.ttf') format('truetype');         /* Saf3â€”5, Chrome4+, FF3.5, Opera 10+ */
}
body {
     direction:rtl;
     font-family:BYekan;
     font-size:14px;
}
th {
  text-align: center;
}
.progress {
  margin-bottom: 0;
}
.sr-only {
  position: relative;
 }
.pa2 {
     font-size:13px;
     background-color:#ececec;
     color:#666;
     padding:8px 15px;
     margin: 0;
     border: solid 1px #ccc;
}
.pa {
     font-size:13px;
     background-color:#ececec;
     color:#000;
     padding:8px 15px;
     cursor: pointer;
     margin: 0;
     border: solid 1px #ccc;
}
.pa:hover {
     color:#000;
     background-color:#fff;
}
</style>
</head>
<body>
	<div class="container">
     <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>تاریخ</th>
                                        <th>کالای N</th>
                                        <th>ویرایش کالا</th>
                                        <th>گروه N</th>
                                        <th>ویرایش گروه</th>
                                        <th>کاربر N</th>
                                        <th>عرضه کننده N</th>
                                        <th>ساب N</th>
                                        <th>وبلاگ S</th>
                                        <th>Hidigi</th>
                                        <th>Bot</th>
<th>Hidigi</th>
                                        <th>Bot</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php
     if (!isset($_GET["p"]))  {
     $page = "0"; 
      } else  {
     $page = $_GET["p"]; 
      }
	$offset = $page *12;
$sql_oc = "SELECT * FROM  `user_hi` ORDER BY  `user_hi`.`date` DESC LIMIT 12 OFFSET $offset";
$result_select_oc = mysqli_query($link_DB, $sql_oc) or die(mysqli_error());
$counter = 0;
while ($row = mysqli_fetch_assoc($result_select_oc)) {
$counter++;
   $id= $row['id'];
   $timestamp= strtotime($row['date']);
   $date = date('d-m-Y', $timestamp);
   $hidigi= $row['hidigi'];
   $hidigi_all= $row['hidigi_all'];
   $bot_all= $row['bot_all'];
   $bot= $row['bot'];
   $new_product= $row['new_product'];
   $edited_product= $row['edited_product'];
   $new_group= $row['new_group'];
   $edited_group= $row['edited_group'];
   $new_user= $row['new_user'];
   $new_provider= $row['new_provider'];
   $new_subprofile= $row['new_subprofile'];
   $blog= $row['blog'];
   $hidigi_users=$row['hidigi_users'];
   $bot_users=$row['bot_users'];
   $hidigi_users = explode(";", $hidigi_users);
	$bot_users = explode(";", $bot_users);
	$hidigi_pairs=array();
 
	$bot_pairs=array();
	foreach ($hidigi_users as $hidigi_user) {
	    $info = explode(",", $hidigi_user);
	    $hidigi_pairs[]=array(
				'name'  => $info[0],
				'count' => $info[1]
			);
	}
	foreach ($bot_users as $bot_user) {
	    $info = explode(",", $bot_user);
	    $bot_pairs[]=array(
				'name'  => $info[0],
				'count' => $info[1]
			);
	}

?>

<tr id="<?php echo $id; ?>">
<td style="width: 100px;"><?php echo $date; ?></td>
<td><?php echo $new_product; ?></td>
<td><?php echo $edited_product; ?></td>
<td><?php echo $new_group; ?></td>
<td><?php echo $edited_group; ?></td>
<td><?php echo $new_user; ?></td>
<td><?php echo $new_provider; ?></td>
<td><?php echo $new_subprofile; ?></td>
<td><?php echo $blog; ?></td>
<td style="width: 150px;">
<?php 
$hidigi_percent = $hidigi/$hidigi_all;
$hidigi_percent = number_format( $hidigi_percent * 100, 0 );
?>
<div class="progress">
  <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?php echo $hidigi; ?>"
  aria-valuemin="0" aria-valuemax="<?php echo $hidigi_all; ?>" style="width:<?php echo $hidigi_percent; ?>%">
  </div><span class="sr-only">% <?php echo $hidigi_percent; ?> (<?php echo $hidigi; ?>)</span>
</div>
</td>
<td style="width: 150px;">
<?php 
$bot_percent = $bot/$bot_all;
$bot_percent = number_format( $bot_percent * 100, 0);
?>
<div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $bot; ?>"
  aria-valuemin="0" aria-valuemax="<?php echo $bot_all; ?>" style="width:<?php echo $bot_percent; ?>%">
  </div><span class="sr-only">% <?php echo $bot_percent; ?> (<?php echo $bot; ?>)</span>
</div>
</td>
<td style="width: 150px;">
		<div id="donut-hidigi-<?php echo $counter; ?>"></div>
<script>
/*
 * Play with this code and it'll update in the panel opposite.
 *
 * Why not try some of the options above?
 */
Morris.Donut({
  element: 'donut-hidigi-<?php echo $counter; ?>',
  data: [
<?php foreach ($hidigi_pairs as $hidigi_pair) { ?>
<?php if ($hidigi_pair['name'] != '' && $hidigi_pair['name'] != '') { ?>
    {label: "<?php echo $hidigi_pair['name']; ?>", value: <?php echo $hidigi_pair['count']; ?>},
<?php } ?>
<?php } ?>
]
});
</script>
</td>
<td style="width: 150px;">
		<div id="donut-bot-<?php echo $counter; ?>"></div>
<script>
/*
 * Play with this code and it'll update in the panel opposite.
 *
 * Why not try some of the options above?
 */
Morris.Donut({
  element: 'donut-bot-<?php echo $counter; ?>',
  data: [
<?php foreach ($bot_pairs as $bot_pair) { ?>
<?php if ($bot_pair['name'] != '' && $bot_pair['name'] != '') { ?>
    {label: "<?php echo $bot_pair['name']; ?>", value: <?php echo $bot_pair['count']; ?>},
<?php } ?>
<?php } ?>
]
});
</script>
</td>
      </tr>
<?php } ?>
                                </tbody>
                            </table>

<div id="pagenation">
     <?php
     $sql = "SELECT * FROM  `user_hi` ";
     $result = mysqli_query($link_DB, $sql) or die(mysqli_error($con_rb));
     $site_bot_count = ceil(mysqli_num_rows($result)/12)-1;
     
      $next = $page +1;
      $back = $page -1;
     ?>
     <?php if ($page > 0) { ?>
     <span id="back" class="pa">صفحه قبل</span>
     <?php } ?>
     <span id="page" class="pa2">صفحه حاضر: <?php echo $page ?>
     &nbsp;&nbsp;&nbsp;&nbsp; <b style="color:#ccc;">|</b> &nbsp;&nbsp;&nbsp;&nbsp;
     کل صفحات: <?php echo $site_bot_count ?></span>
     <?php if ($page < $site_bot_count){ ?> 
     <span id="next" class="pa">صفحه بعد</span>
     <?php } ?>
     <span class="paimg">
     <a href="http://sarfejoo.com" target="_blank">
     <img src="http://sarfejoo.com/image/data/logos/sarfejoo_beta0.png" style="height: 45px;width: auto;" /></a></span>
</div>
<script language="JavaScript" type="text/javascript">
     $(document).ready(function() {
          $("#back").click(function(){
               window.location.href = "list.php?p=<?php echo $back ?>";
          });
          $("#next").click(function(){
               window.location.href = "list.php?p=<?php echo $next ?>";
          });
     });
</script>
	</div>
</body>
</html>
<?php include('cron.php'); ?>
<?php } ?>