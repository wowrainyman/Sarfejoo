<?php
###############################
### sdb.php - 10:47 AM 3/9/2015 by M.Abooali
###############################
     ini_set('max_execution_time', 0); 
     
     require_once "config.php";
     
     if (!isset($_GET["id"]) || empty($_GET["id"])) {
     $next_id  = 1;
     } else {
     $next_id  = $_GET["id"];
     }

     $sql = "SELECT * FROM `digikala_product_related` WHERE id = $next_id";
     $result_select = mysqli_query($link_DB, $sql) or die(mysqli_error());
     while ($row = mysqli_fetch_assoc($result_select)) {

     $product_id = $row['sarfejoo_id'];
     $digi_id = $row['digikala_id']; 
     }
     $page_url = "http://www.digikala.com/Product/DKP-$digi_id";
     $date = date('m-d-Y');
     
     if (!file_exists($date)) {
          mkdir($date);
     }

     $local_file = $date . '/' . $product_id  . '.html';
     $page_content = file_get_contents($page_url);
     
     $myfile = fopen("$local_file", "w") or die("Unable to open file!");
     fwrite($myfile, $page_content);

     $page_content = file_get_contents($local_file);     
     
     $page_content = str_replace("<head>","<head><script src='http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>",$page_content);
     $page_content = str_replace("class='finalprice green'","id='priceee'",$page_content);
     $page_content = str_replace("<span id='priceee'>","<price>",$page_content);
     $page_content = str_replace("<span style=\"font-size: 16px\">","</price>",$page_content);
     $page_content = strip_tags($page_content, '<price>');
     $page_content = strstr($page_content, '<price>');
     
     $rowbyrow = explode('</price>', $page_content);
     
     echo $rowbyrow[0];

     $price = trim($rowbyrow[0]);
     $price = preg_replace("/[^0-9.]/", "", $price);
     
     echo $price;
?>

<html><head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head><body>

<script language="JavaScript" type="text/javascript">
$(document).ready(function() {
          var product = '<?php echo $product_id  ?>';
          var price = '<?php echo $price  ?>';
          
          var url = 'db.php?id=' + product + '&price=' + price;
          $.ajax({
                    type: "GET",
                    url: url,
                    success: function (data) {
                    $('price').text('==============Inserted');
                    }
          });
          return false;
          e.preventDefault();
});
</script>

<?php   
     $sql = "SELECT * FROM `digikala_product_related`";
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
     }, 10);
//-->
</script>

</body></html>