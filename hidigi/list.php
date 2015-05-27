<?php
###############################
### list.php - 10:47 AM 3/9/2015 by M.Abooali
###############################
?>
<html>
<head>
     <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=0.8">
<style>
body {
     font-family:tahoma;
     font-size:11px;
}
#pagenation {
     position:fixed;
     bottom:0;
     padding: 15px 50px 10px;
     background-color:rgba(200,200,200,0.4);
}
.pp {
     width: 280px;
     height: 145px;
     float: right;
     display: block;
     border: 2px solid #CCC;
     margin: 5px;
     padding: 10px 15px;
     font-size: 11px;
     line-height: 245%;
     max-width: 95%;
}
.pp:hover {
     border: solid 2px #888;
}

@media only screen and (min-device-width : 320px) and (max-device-width : 480px) {        /* Smartphones (portrait and landscape) */
     .pp {
          min-width: 90%;
     }

}
.upd {
     background-color:#5555FF;
     color:#fff;
     padding:1px 8px;
     float:left;
     cursor: pointer;
     margin: 0;
}
.upd:hover {
     color:#fff;
     background-color:#0055FF;
}
.ins2 {
     background-color: #D6E3D6;
     color: #3D8020;
     padding:1px 8px;
     float:left;
     margin: 0;
}
.ins {
     background-color:#da532c;
     color:#fff;
     padding:1px 8px;
     float:left;
     cursor: pointer;
     margin: 0;
}
.ins:hover {
     color:#fff;
     background-color:#ee1111;
}
.pa2 {
     font-size:11px;
     background-color:#ececec;
     color:#666;
     padding:8px 15px;
     margin: 0;
     border: solid 1px #ccc;
}
.pa {
     font-size:11px;
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
.buy-link {
     width:100%;
     border: 1px solid #ccc;
     padding:5px 50px 5px 20px;
     font-family:tahoma;
     font-size:9px;
     color:#888;
     direction:ltr;
}
#buy-link:hover {
     color:#ff8888;
     border: 1px solid #999;
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
     color:#fff;
     background-color:#E91717;
}
.paimg {
     float: right;
     margin-top: -13px;
     padding: 0 20px;
     margin-right: -45px;
}
</style>
</head>
<?php

     require_once "config.php";

     if (!isset($_GET["p"]))  {
     $page = "0"; 
      } else  {
     $page = $_GET["p"]; 
      }
     
     $sql = "SELECT * FROM `digikala_updated_price` WHERE time > CURDATE()";
     $result = mysqli_query($link_DB, $sql) or die(mysqli_error($con_rb));
     $site_bot_count = mysqli_num_rows($result);


     $sql = "SELECT * FROM `digikala_updated_price` WHERE time > CURDATE() AND is_r =1";
     $result = mysqli_query($link_DB, $sql) or die(mysqli_error($con_rb));
     $site_bot_aded_count = mysqli_num_rows($result);
     
      $offset = $page *12;
     $sql = "SELECT * FROM `digikala_updated_price` WHERE time > CURDATE() limit 12 OFFSET $offset";
     $result_select = mysqli_query($link_DB, $sql) or die(mysqli_error());
     
?>

     <div style="width:100%;display:block;margin:auto;direction:rtl;">

<?php
     $count  = 0;
     while ($row = mysqli_fetch_assoc($result_select)) {

     $count ++;

                                                                           $c_id = $row['id'];
                                                                           $product_id = $row['product_id'];
                                                                           $price = $row['price'];
                                                                           $is_r = $row['is_r'];
                                                                           $time = $row['time'];
                                                                           $timestamp = strtotime($time);

     $price_avg = 0;                                                                     
     $sql_oc = "SELECT price,model FROM `oc_product` WHERE product_id=$product_id";
     $result_select_oc = mysqli_query($link_OC_DB, $sql_oc) or die(mysqli_error());
     while ($row = mysqli_fetch_assoc($result_select_oc)) {
                                                                           $price_avg = $row['price'];
                                                                           $model = $row['model'];
     }

     $subprofile_id = 17;

     $price_sp = 0; 
     $i_customer_id =15;
     $i_title = '';
     if(!empty($subprofile_id) && isset($subprofile_id)) { 
          $sql_pu = "SELECT customer_id, title FROM pu_subprofile WHERE id =$subprofile_id ";
          $result_select_pu = mysqli_query($link_PU_DB, $sql_pu) or die(mysqli_error());
          while ($row = mysqli_fetch_assoc($result_select_pu)) {
                                                                                $i_customer_id = $row['customer_id'];
                                                                                $i_title = $row['title'];
          }   
     
          $view_count ='';
          $sql_pu = "SELECT * FROM pu_subprofile_product WHERE subprofile_id =$subprofile_id  AND  product_id = $product_id";
          $result_select_pu = mysqli_query($link_PU_DB, $sql_pu) or die(mysqli_error());
          while ($row = mysqli_fetch_assoc($result_select_pu)) {
                                                                                $price_sp = $row['price'];
                                                                                $buy_link = $row['buy_link'];
                                                                                $view_count = $row['view_count'];
          }         
     }     
          if ($i_customer_id == 15 ) {
                         $i_customer_id = 'S';
          } elseif ($i_customer_id == 23 ) {
               $i_customer_id = 'S';
          } elseif ($i_customer_id == 0 ) {
               $i_customer_id = 'ناموجود در صرفه جو';
          } else {
               $i_customer_id = 'c:' . $i_customer_id ;
          }    
?>

     <div class="pp">
<?php if(!empty($subprofile_id) && isset($subprofile_id)) { ?>

<?php if ($is_r ==0) { ?>
    <?php if($price_sp != 0) { ?>
    <span id="upd<?php echo $count  ?>" class="upd">ثبت قیمت جدید</span>
    <?php } else { ?>
    <span id="ins<?php echo $count  ?>" class="ins">افزودن کالا</span>
    <?php } ?>
<?php } else { ?>
    <span id="is_r<?php echo $count  ?>" class="ins2">امروز ثبت شده است.</span>
<?php } ?>
    
<script language="JavaScript" type="text/javascript">
$(document).ready(function() {                   
     $("#upd<?php echo $count  ?>").click(function(){
          var subprofile = '<?php echo $subprofile_id  ?>';
          var dec = '';
          var price = '<?php echo $price ?>';
          var product = '<?php echo $product_id ?>';
          var c_id = '<?php echo $c_id ?>';
          
          var url = 'udp.php?pid=' + product + '&s=' + subprofile + '&p=' + price + '&d=' + dec + '&c_id=' + c_id;
                     
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
     $("#ins<?php echo $count  ?>").click(function(){
          var subprofile = '<?php echo $subprofile_id  ?>';
          var dec = '';
          var price = '<?php echo $price ?>';
          var product = '<?php echo $product_id ?>';
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
     $("#in-upblc-<?php echo $count;  ?>").change(function(){
                    $('#upblc-<?php echo $count  ?>').show('');    
     });
      $("#in-upblc-<?php echo $count;  ?>").keypress(function(){
                    $('#upblc-<?php echo $count  ?>').show('');    
     });

      $("#upblc-<?php echo $count  ?>").click(function(){
          var link = $('#in-upblc-<?php echo $count;  ?>').val();       
          var subprofile = '<?php echo $subprofile_id  ?>';
          var product = '<?php echo $product_id ?>';
          
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
     <?php  if (date("Y-m-d", $timestamp)==date("Y-m-d")) { ?>
     <span style="color:#55aa55;font-size:12px;direction:ltr;">امروز</span>
     <?php  } else { ?> 
     <span style="color:#FF2255;font-size:12px;direction:ltr;"><?php echo date("Y-m-d", $timestamp) ?></span>
     <?php  } ?>
     |
     <span>
     
     <?php
     $sql_digi= "SELECT digikala_id FROM `digikala_product_related` WHERE sarfejoo_id=$product_id";
     $result_digi = mysqli_query($link_DB, $sql_digi) or die(mysqli_error());
     while ($row = mysqli_fetch_assoc($result_digi)) {
                                                                           $digi_id = $row['digikala_id'];
     }
     ?>
     
     <a href="../index.php?route=product/product&product_id=<?php echo$product_id ?>" title="Sarfejoo: <?php echo$product_id ?>" target="_blank">IN</a> |
     <a href="http://sarfejoo.com/uoo.php?u=digikala.com/Product/DKP-<?php echo$digi_id ?>" title="DIGI: <?php echo$digi_id ?>" target="_blank">DIGI</a>
     <?php if(isset($view_count)) { ?>
     -  بازدید: <?php echo $view_count; ?> بار
     <?php } ?>
     </span>
     <br />
     <?php if(!empty($subprofile_id) && isset($subprofile_id)) { ?>
          <div class="bl-c">
               <?php if(!empty($buy_link)) { ?>
               <a target="_blank" href="<?php echo $buy_link; ?>" title="نمایش" class="openbuy">@</a>
               <?php } ?>
               <input id="in-upblc-<?php echo $count;  ?>" placeholder="http://" type="text" value="<?php echo $buy_link; ?>" class="buy-link" />
               <span class="upblc" id="upblc-<?php echo $count  ?>">UP</span>
          </div>
     <?php } ?>
     کالا: <span style="color:#5555FF;"><?php echo$model ?></span>
     <br />
    قیمت قبل: <span id="old-<?php echo $count  ?>"style="float:left;color:#888;font-size:13px;"><b><?php echo number_format($price_sp) ?></b></span> <br />
     قیمت جدید: <span style="float:left;color:#FF2255;font-size:14px;"><b><?php echo number_format($price) ?></b></span> <br />
     قیمت متوسط: <span style="float:left;color:#55aa55;font-size:13px;"><b><?php echo number_format($price_avg) ?></b></span><br />
     </div>



<?php

     $subprofile_id = '';
     }

?>
</div>
<div id="pagenation">
     <?php
      $next = $page +1;
      $back = $page -1;
     ?>
     <?php if ($page > 0) { ?>
     <span id="back" class="pa">صفحه قبل</span>
     <?php } ?>
     <span id="page" class="pa2">صفحه حاضر: <?php echo $page ?>
     &nbsp;&nbsp;&nbsp;&nbsp; <b style="color:#ccc;">|</b> &nbsp;&nbsp;&nbsp;&nbsp;
     کل موارد: <?php echo $site_bot_count ?> 
     &nbsp;&nbsp;&nbsp;&nbsp; <b style="color:#ccc;">|</b> &nbsp;&nbsp;&nbsp;&nbsp;
     ثبت شده: <?php echo $site_bot_aded_count ?> 
     &nbsp;&nbsp;&nbsp;&nbsp; <b style="color:#ccc;">|</b> &nbsp;&nbsp;&nbsp;&nbsp;
     باقیمانده: <?php echo $site_bot_count - $site_bot_aded_count  ?> 
     &nbsp;&nbsp;&nbsp;&nbsp; <b style="color:#ccc;">|</b> &nbsp;&nbsp;&nbsp;&nbsp;
     کل صفحات: <?php echo ceil($site_bot_count/12) ?></span> 
     <span id="next" class="pa">صفحه بعد</span>
     <span class="paimg"><img src="http://sarfejoo.com/ProvidersScans/15/17/logo_1425536715.png" /></span>
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