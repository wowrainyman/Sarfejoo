<?php

     require_once "config.php";

     $product_id = '396';

     $page_url = 'http://emalls.ir/price_compar.aspx?ID=130589';

     if (!file_exists($product_id)) {
          mkdir($product_id);
     }

     $local_file = $product_id . '/' . date('m-d-Y') . '.html';

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
     $page_content = str_replace(" 
 

 
 ",' ', $page_content);



     $page_content = strip_tags($page_content,"<div><tr><table><td>");
     
    $page_content = preg_replace('!\s+!', ' ', $page_content);
     
     $myfile = fopen("$local_file", "w") or die("Unable to open file!");
     fwrite($myfile, $page_content);
     
     echo $page_content;