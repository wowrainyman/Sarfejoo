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

     ini_set('max_execution_time', 0); 
     
     require_once "config.php";
     
     if (!isset($_GET["id"]) || empty($_GET["id"])) {
     $next_id  = 1;
     } else {
     $next_id  = $_GET["id"];
     }

     $sql = "SELECT * FROM `emals_related` WHERE id = $next_id";
     $result_select = mysqli_query($link_DB, $sql) or die(mysqli_error());
     while ($row = mysqli_fetch_assoc($result_select)) {

     $product_id = $row['product_id'];
     $emalls_id = $row['emalls_id']; 

?><html><head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head><body>
<?php

# sTART gRAB lINK

     $page_url = "http://emalls.ir/price_compar.aspx?ID=$emalls_id";
     $date = date('m-d-Y');
     
     if (!file_exists($date)) {
          mkdir($date);
     }

     $local_file = $date . '/' . $product_id  . '.html';
     $page_content = file_get_contents($page_url);
     $page_content = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $page_content);
     $page_content = preg_replace('/(<[^>]+) action=".*?"/i', '$1', $page_content);
     $page_content = preg_replace('/(<[^>]+) value=".*?"/i', '$1', $page_content);
     $page_content = preg_replace("/<img[^>]+\>/i", " ", $page_content); 
     $page_content = str_replace('<div>',' ', $page_content);
     $page_content = str_replace('نمودار تغییرات قیمت',' ', $page_content);
     $page_content = str_replace('</div></div>',' ', $page_content);
     $page_content = str_replace("                              ",' ', $page_content);
     $page_content = str_replace("     ",' ', $page_content);
     $page_content = str_replace("     ",' ', $page_content);
     $page_content = str_replace("   ",' ', $page_content);
     $page_content = str_replace("   ",' ', $page_content);
     $page_content = str_replace("  ",' ', $page_content);
     $page_content = str_replace("  ",' ', $page_content);
     $page_content = str_replace("  ",' ', $page_content);
     $page_content = str_replace('<div class="clear"></div>',' ', $page_content);
     $page_content = strip_tags($page_content,"<div><tr><table><td>");
     $page_content = preg_replace('!\s+!', ' ', $page_content);
     
     $myfile = fopen("$local_file", "w") or die("Unable to open file!");
     fwrite($myfile, $page_content);

     $page_content = file_get_contents($local_file);     
     $rowbyrow = explode('</table>', $page_content);
     $count =0;
     
      foreach ($rowbyrow as $row) {
     $count ++;
?>
          <div id="d-<?php echo $count ?>" style='border: 1px solid black;'><div>
                    <br />
                    <?php echo $product_id  ?>
                         <br />
                    <?php echo $emalls_id  ?>
                         <br />
               <?php $row_td = explode('</td>', $row); 
                    $id =0;
                     foreach ($row_td as $td) {
                    $id ++;
?>
                    <div id="<?php echo $count  ?>-<?php echo $id  ?>">
                    <div style="color:#ff0000"id="<?php echo $count  ?>-info"></div>
                    <br /><br />
                     <?php 
                     
                     $td = strip_tags($td,"<a>");
                     $td = str_replace(' ', ' ', $td );

                     echo $td
                     ?>
                     </div>
               <?php } ?>
          </table></div>
          </div><br />
          
<script language="JavaScript" type="text/javascript">
$(document).ready(function() {
     // $("#gg-<?php echo $count  ?>").click(function(){
          var subprofile = $('#<?php echo $count  ?>-2').text();
          var dec = $('#<?php echo $count  ?>-4').text();
          var price = $('#<?php echo $count  ?>-6').text();
          
          var url = 'db.php?rid=' + <?php echo $product_id  ?> + '&s=' + subprofile + '&p=' + price +'&d=' + dec;
                    
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
<?php 
          } 
    // sleep(1) ; 
  } 
   
     $sql = "SELECT * FROM `emals_related`";
     $result = mysqli_query($link_DB, $sql) or die(mysqli_error($con_rb));
     $bot_count = mysqli_num_rows($result);
     $rand_id = rand(1,$bot_count);
      if ($rand_id == $next_id) {
      $rand_id = $rand_id+1;
      }
 ?>
<script type="text/javascript">
<!--
     setTimeout(function() {
       window.location.href = "sdb.php?id=<?php echo ($rand_id) ?>";
     }, 60000);
//-->
</script>

<?php // } ?>
</body></html>
<?php } ?>