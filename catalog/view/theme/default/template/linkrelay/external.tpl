<!doctype html>
<html lang="en" class="no-js">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <title><?php echo $text_header ?></title>
    
    <meta name="description" content="<?php echo $text_dec ?>">
    <meta name="robots" content="noindex, follow" />
    <meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1" />
    <link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/stylesheet.css" />
    <style>
    body,html {
          direction:rtl;
          overflow-x: hidden;
          overflow-y: hidden;
    }
    .full {
          padding-top:0px !important;
          height: 600px;
    }
    </style>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
     <script>
     
     /*
     
     $(document).ready(function(){
          $("#go-site").click(function(){
          $(".fix-header").hide(500);
          $(".frame").addClass( "frame full" );
          });
     });



      //function to fix height of iframe!
      var calcHeight = function() {
        var headerDimensions = $('.fix-header').height();
        $('.frame').height($(window).height() - headerDimensions);
      }

      $(document).ready(function() {
        calcHeight();
      });

      $(window).resize(function() {
        calcHeight();
      }).load(function() {
        calcHeight();
      });


     $(document).ready(function() {
               if (("#preview-frame").length < 100) {
               window.location = "<?php echo $relay_url ?>"
               }
      });
      */
    </script>
  </head>

  <body>
  <div class="frame-foot ">
    در صورتی که سایت عرضه کننده به طور کامل نمایش داده نشد
    <a  href="<?php echo $relay_url ?>" class="btn btn--primary">اینجا</a>
    کلیک نمائید.
  </div>
    <div class="fix-header">
          <div class="logo">
               <span><?php echo $text_dec ?></span>
               <a href="<?php echo $site_link  ?>"><img  src="<?php echo $logo ?>" /></a>
          </div>
          <div class="close">
               <a id="go-site" href="<?php echo $relay_url ?>"><span><?php echo $text_remove_frame ?></span></a>
          </div>
          <div class="go-site">
               <a  href="<?php echo $site_link  ?>" class="btn btn--primary"><?php echo $text_back_site ?></a>
          </div>
     </div>
<iframe class="frame" style="z-index:100;"src="<?php echo $relay_url ?>" id="preview-frame" name="preview-frame" frameborder="0" noresize="noresize"></iframe>

  </body>
</html>