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
     $date = 'products';
     
     if (!file_exists($date)) {
          mkdir($date);
     }

     $local_file = $date . '/' . $product_id  . '.html';
     $page_content = file_get_contents($page_url);

     $rowbyrow = explode('</table>', $page_content);
     $page_content = $rowbyrow[34]; 
     $page_content = str_replace('table','ooo', $page_content);
     $page_content = strip_tags($page_content, '<ooo><tr><td><span><img>');
     $page_content = strstr($page_content, '<ooo>');
     $page_content = str_replace('ooo','table', $page_content);

     $myfile = fopen("$local_file", "w") or die("Unable to open file!");
     fwrite($myfile, $page_content);

?>

<html><head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head><body>

<?php   
     $sql = "SELECT * FROM `digikala_product_related`";
     $result = mysqli_query($link_DB, $sql) or die(mysqli_error($con_rb));
     $bot_count = mysqli_num_rows($result) +1;
      if ($next_id <$bot_count) {
     $next_id = $next_id+1;
      }
      else {
          die ('finish');
      }
 ?>
 
<script type="text/javascript">

<!-- 
     setTimeout(function() {
       window.location.href = "sdb.php?id=<?php echo ($next_id) ?>";
     }, 200);
//-->

</script>

</body></html>