<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<?php echo $google_analytics; ?>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>

        <link title="Sarfejoo - Search" rel="search" type="application/opensearchdescription+xml" href="http://sarfejoo.com/sarfejoo-search.xml" />
        <link rel="shortcut icon" href="favicon.ico" />
 <meta name="viewport" content="width=device-width, initial-scale=0.8">
<!-- <link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/stylesheet.css" /> -->
    <link href="catalog/view/css/bootstrap-rtl.min.css" rel="stylesheet" />
    <link href="catalog/view/css/customCss.css" rel="stylesheet" />
    <link href="catalog/view/css/font-awesome.min.css" rel="stylesheet" />
    <link href="catalog/view/css/jquery.smartmenus.bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/sarfejoo/style.css" />
    <link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/sarfejoo/home.css" />
    <link href='http://fonts.googleapis.com/css?family=Roboto:700' rel='stylesheet' type='text/css' />
<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
    <script src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="catalog/view/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="catalog/view/js/jquery.smartmenus.bootstrap.js"></script>
    <script type="text/javascript" src="catalog/view/js/jquery.smartmenus.js"></script>
    <script type="text/javascript" src="catalog/view/js/jquery.sticky-kit.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" />
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/external/jquery.cookie.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/colorbox/jquery.colorbox.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/colorbox/colorbox.css" media="screen" />
<script type="text/javascript" src="catalog/view/javascript/jquery/tabs.js"></script>
<script type="text/javascript" src="catalog/view/javascript/common.js"></script>

<script type="text/javascript" src="catalog/view/javascript/jquery/ui/i18n/jquery.ui.datepicker-cc-fa.js"></script>
<link type="text/css" href="catalog/view/javascript/jquery/ui/jquery.ui.slider-rtl.css" rel="stylesheet">
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery.ui.slider-rtl.js"></script>

<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/maps.css"/>

<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/webdev-seo/flaticon.css"/>


	<!-- Dependencies: JQuery and GMaps API should be loaded first -->
<script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<!-- CSS and JS for our code -->
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/jquery-gmaps-latlon-picker.css"/>
<script src="catalog/view/javascript/map/jquery-gmaps-latlon-picker.js"></script>
<script>
$(document).ready(function() {

     $("#go-top").click(function(){
               $('html, body').animate({scrollTop: $('#list-p-cat').offset().top -355 }, 'slow');
     });

     $(".c-box-ul").hide();

     $(".cat-box").hover(function () {
               $(this).find(".cat-box-title").slideToggle("fast");
               $(this).find(".c-box-ul").toggle("slow");
     });


     $("#rs-column-right-key").click(function(){
          $("#column-right").toggleClass("right-rs-slide");
          $("#rs-column-right-key").toggleClass("right-key-rs-slide");
          $("#rs-lightbox").toggleClass("rs-lightbox");
     });

     $("#rs-column-left-key").click(function(){
          $(".rs-menu").toggleClass("rs-menu-slide");
          $("#rs-column-left-key").toggleClass("rs-column-left-key-slide");
          $("#rs-lightbox-2").toggleClass("rs-lightbox");
     });

     $("#rs-lightbox").click(function(){
          $("#column-right").toggleClass("right-rs-slide");
          $("#rs-column-right-key").toggleClass("right-key-rs-slide");
          $("#rs-lightbox").toggleClass("rs-lightbox");
     });

     $("#rs-lightbox-2").click(function(){
          $(".rs-menu").toggleClass("rs-menu-slide");
          $("#rs-column-left-key").toggleClass("rs-column-left-key-slide");
          $("#rs-lightbox-2").toggleClass("rs-lightbox");
     });


     $('.rs-b-search').click(function() {
        var url = 'index.php?route=product/search&search=';
        var inputURL = $('#rs-q-input').val();
        window.location.href = url + inputURL;
        return false;
     });

     $('.rs-q-input').keypress(function (e) {
      var key = e.which;
      if(key == 13)  // the enter key code
       {
        var url = 'index.php?route=product/search&search=';
        var inputURL = $('#rs-q-input').val();
        window.location.href = url + inputURL;
        return false;
       }
     });

     $('.b-search').click(function() {
        var url = 'index.php?route=product/search&search=';
        var inputURL = $('#q-input').val();
        window.location.href = url + inputURL;
        return false;
     });

     $('.q-input').keypress(function (e) {
      var key = e.which;
      if(key == 13)  // the enter key code
       {
        var url = 'index.php?route=product/search&search=';
        var inputURL = $('#q-input').val();
        window.location.href = url + inputURL;
        return false;
       }
     });

     $('.bar-full-fix').hide();
});

$(window).scroll(function(){
     if ($(this).scrollTop() > 350) {
          $('#compareblock').addClass('compareDivfix');
     } else {
          $('#compareblock').removeClass('compareDivfix');
     }

     if ($(this).scrollTop() > 300) {
          $('#compare-header').addClass('compare-he-fix s-row');
     } else {
          $('#compare-header').removeClass('compare-he-fix s-row');
     }

     if ($(this).scrollTop() > 300) {
          $('.c-th').addClass('comp-thum-fix');
          $('#s-scroll').addClass('s-scroll');
     } else {
          $('.c-th').removeClass('comp-thum-fix');
          $('#s-scroll').removeClass('s-scroll');
     }

     if ($(this).scrollTop() > 130) {
          $('.bar-full-fix').show();
     } else {
          $('.bar-full-fix').hide();
     }
});

</script>
<script type="text/javascript" src="catalog/view/javascript/cl-cr.js"></script>
<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>
<style>
    /* centered columns styles */
    .row-centered {
        text-align:center;
    }
    .col-centered {
        display:inline-block;
        float:none;
        /* reset the text-align */
        text-align:center;
        /* inline-block space fix */
        margin-right:-4px;
    }
    .right-align{
        text-align:right;
    }
</style>
<style type="text/css" media="all">
    .box-shadow{
        background-color: #ffffff;
        border: 1px solid #c8c8c8;
        box-shadow: 0 0 8px #c8c8c8;
        margin: 10px 0;
        padding: 4px;
    }
    @font-face {
        font-family: 'weblogmayekan';
        src: url('catalog/view/fonts/Weblogma_Yekan.eot');
        src: url('catalog/view/fonts/Weblogma_Yekan.eot#iefix') format('embedded-opentype'),
        url('catalog/view/fonts/Weblogma_Yekan.woff') format('woff'),
        url('catalog/view/fonts/Weblogma_Yekan.ttf') format('truetype'),
        url('catalog/view/fonts/Weblogma_Yekan.svg#CartoGothicStdBook') format('svg');
        font-weight: normal;
        font-style: normal;
    }
    @font-face {
        font-family: 'Roboto', sans-serif;
    }
    @font-face {
        font-family: 'Mj_Two_Medium';
        src: url('catalog/view/fonts/Mj_TwoMedium.eot');
        src: url('catalog/view/fonts/Mj_TwoMedium.eot#iefix') format('embedded-opentype'),
        url('catalog/view/fonts/Mj_TwoMedium.woff') format('woff'),
        url('catalog/view/fonts/Mj_TwoMedium.ttf') format('truetype'),
        url('catalog/view/fonts/Mj_TwoMedium.svg#CartoGothicStdBook') format('svg');
        font-weight: normal;
        font-style: normal;
    }
    *:not(.fa .glyphicon){
        font-family: weblogmayekan, Arial, Helvetica, sans-serif !important;
    }
    .mj-font{
        font-family: Mj_Two_Medium, Arial, Helvetica, sans-serif !important;
    }
    .roboto{
        font-family: Roboto, Arial, Helvetica, sans-serif !important;
    }
</style>
<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie7.css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie6.css" />

<script type="text/javascript" src="catalog/view/javascript/DD_belatedPNG_0.0.8a-min.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('#logo img');
</script>
<![endif]-->

</head>
<body>
<div id="rs-lightbox"></div>
<div id="rs-lightbox-2"></div>
<div id="rs-column-left-key"></div>
<div class="wrapper">
    <div class="box">
        <div class="row row-offcanvas row-offcanvas-left" style="background-color: #8926a8">
            <!-- sidebar -->
            <div class="column col-sm-2 col-xs-1 sidebar-offcanvas visible-xs" id="sidebar">

                <ul class="nav">
                    <li><a href="#" data-toggle="offcanvas" class="visible-xs text-center"><i class="glyphicon glyphicon-chevron-left"></i></a></li>
                </ul>

                <ul class="nav hidden-xs" id="lg-menu">
                    <li class="active">
                        <a href="http://sarfejoo.com/%D8%AE%D8%AF%D9%85%D8%A7%D8%AA/%D9%85%D9%82%D8%A7%DB%8C%D8%B3%D9%87-%D8%B3%DB%8C%D9%85-%DA%A9%D8%A7%D8%B1%D8%AA-%D8%AF%D8%A7%D8%A6%D9%85%DB%8C-%D8%A7%D8%B9%D8%AA%D8%A8%D8%A7%D8%B1%DB%8C"><i class="fa fa-wifi"></i>
                            خدمات تلفن همراه
                        </a>
                    </li>
                    <li class="active">
                        <a href="http://sarfejoo.com/%D8%AE%D8%AF%D9%85%D8%A7%D8%AA/%D9%85%D9%82%D8%A7%DB%8C%D8%B3%D9%87-%D8%A7%DB%8C%D9%86%D8%AA%D8%B1%D9%86%D8%AA-adsl"><i class="fa fa-globe"></i>
                            سرویس دهندگان اینترنت
                        </a>
                    </li>
                    <li class="active">
                        <a href="http://sarfejoo.com/%D8%AE%D8%AF%D9%85%D8%A7%D8%AA/%D8%A8%D8%A7%D8%B4%DA%AF%D8%A7%D9%87-%D9%88%D8%B1%D8%B2%D8%B4%DB%8C"><i class="fa fa-soccer-ball-o"></i>
                            باشگاه ورزشی
                        </a>
                    </li>
                    <li class="active">
                        <a href="http://sarfejoo.com/%D8%AE%D8%AF%D9%85%D8%A7%D8%AA/%D9%87%D8%AA%D9%84-%D8%A2%D9%BE%D8%A7%D8%B1%D8%AA%D9%85%D8%A7%D9%86-%D9%85%D9%87%D9%85%D8%A7%D9%86%D8%B3%D8%B1%D8%A7"><i class="fa fa-bed"></i>
                            هتل، هتل آپارتمان
                        </a>
                    </li>
                    <li class="active">
                        <a href="http://sarfejoo.com/%DA%A9%D8%A7%D9%84%D8%A7/%D9%85%D9%82%D8%A7%DB%8C%D8%B3%D9%87-%DA%AF%D9%88%D8%B4%DB%8C-%D9%85%D9%82%D8%A7%DB%8C%D8%B3%D9%87-%D9%85%D9%88%D8%A8%D8%A7%DB%8C%D9%84-%D9%84%DB%8C%D8%B3%D8%AA-%D9%82%DB%8C%D9%85%D8%AA"><i class="fa fa-mobile"></i>
                            گوشی موبایل
                        </a>
                    </li>
                    <li class="active">
                        <a href="http://sarfejoo.com/%DA%A9%D8%A7%D9%84%D8%A7/%D9%85%D9%82%D8%A7%DB%8C%D8%B3%D9%87-%D9%84%D9%BE-%D8%AA%D8%A7%D9%BE-%D9%84%DB%8C%D8%B3%D8%AA-%D9%82%DB%8C%D9%85%D8%AA-%D9%84%D8%A8-%D8%AA%D8%A7%D8%A8-%D9%86%D9%88%D8%AA-%D8%A8%D9%88%DA%A9"><i class="fa fa-laptop"></i>
                            لپ تاپ
                        </a>
                    </li>
                    <li class="active">
                        <a href="http://sarfejoo.com/%DA%A9%D8%A7%D9%84%D8%A7/%D9%84%DB%8C%D8%B3%D8%AA-%D9%82%DB%8C%D9%85%D8%AA-%D8%AA%D8%A8%D9%84%D8%AA-%D9%85%D9%82%D8%A7%DB%8C%D8%B3%D9%87-%D8%AA%D8%A8%D9%84%D8%AA"><i class="fa fa-tablet"></i>
                            تبلت
                        </a>
                    </li>
                    <li class="active">
                        <a href="http://sarfejoo.com/%DA%A9%D8%A7%D9%84%D8%A7/%D9%85%D9%82%D8%A7%DB%8C%D8%B3%D9%87-%D8%AC%DB%8C-%D9%BE%DB%8C-%D8%A7%D8%B3-GPS-%D9%84%DB%8C%D8%B3%D8%AA-%D9%82%DB%8C%D9%85%D8%AA-gps"><i class="fa fa-map-marker"></i>
                            موقعیت یاب GPS
                        </a>
                    </li>
                    <li class="active">
                        <a href="http://sarfejoo.com/%DA%A9%D8%A7%D9%84%D8%A7/%D9%85%D9%82%D8%A7%DB%8C%D8%B3%D9%87-%D8%AF%D9%88%D8%B1%D8%A8%DB%8C%D9%86-%D9%84%DB%8C%D8%B3%D8%AA-%D9%82%DB%8C%D9%85%D8%AA-camera-%D8%AF%D9%88%D8%B1%D8%A8%DB%8C%D9%86"><i class="fa fa-camera"></i>
                            دوربین
                        </a>
                    </li>
                </ul>
                <ul class="list-unstyled hidden-xs" id="sidebar-footer">
                    <li>
                        <a href="http://www.bootply.com"><h3>Bootstrap</h3> <i class="glyphicon glyphicon-heart-empty"></i> Bootply</a>
                    </li>
                </ul>

                <!-- tiny only nav-->
                <ul class="nav visible-xs" id="xs-menu">
                    <li><a href="http://sarfejoo.com/%D8%AE%D8%AF%D9%85%D8%A7%D8%AA/%D9%85%D9%82%D8%A7%DB%8C%D8%B3%D9%87-%D8%B3%DB%8C%D9%85-%DA%A9%D8%A7%D8%B1%D8%AA-%D8%AF%D8%A7%D8%A6%D9%85%DB%8C-%D8%A7%D8%B9%D8%AA%D8%A8%D8%A7%D8%B1%DB%8C" class="text-center"><i class="fa fa-wifi"></i></a></li>
                    <li><a href="" class="text-center"><i class="fa fa-globe"></i></a></li>
                    <li><a href="" class="text-center"><i class="fa fa-soccer-ball-o"></i></a></li>
                    <li><a href="" class="text-center"><i class="fa fa-bed"></i></a></li>
                    <li><a href="" class="text-center"><i class="fa fa-mobile"></i></a></li>
                    <li><a href="" class="text-center"><i class="fa fa-laptop"></i></a></li>
                    <li><a href="" class="text-center"><i class="fa fa-tablet"></i></a></li>
                    <li><a href="" class="text-center"><i class="fa fa-map-marker"></i></a></li>
                    <li><a href="" class="text-center"><i class="fa fa-camera"></i></a></li>
                </ul>

            </div>
            <!-- /sidebar -->
            <!-- main right col -->
            <div class="column col-sm-12 col-xs-11" style="background-color: #f7f7f7;" id="main">

<div class="container  pin1-container" style="padding: 4px;">
    <div id="s-fixed" class="rs-menu hidden-xs">

        <div class="container">

        <div class="" style="overflow:inherit !important;">
            <div id="fi-links" class="s-fi-block">
                <span dir="rtl" style="color: #000000;"><?php echo $date; ?></span>
            </div>
            <div id="search" class="s-he-search top-search" style="margin-top: -2px;margin-right: 160px;display: none;">
                <div class="button-search b-search"></div>
                <input type="text" name="search" id="q-input" class="q-input" placeholder="جستجوی هوشمند کالا و خدمات..." value="<?php echo $search; ?>" />
            </div>
            <div  id="fi-left" class="s-fi-block">
                <ul>
                    <?php  if (!empty($blog_post_link) && !empty($blog_post_title)) { ?>
                    <li>
                        <a href="<?php echo $blog_post_link; ?>" >
                            <img src="catalog/view/theme/default/image/arrow-left.png" style="right:5px;margin-top:8px;position:absolute;border:0;outline:none;">
                            <?php echo $blog_post_title; ?>
                        </a>
                    </li>
                    <span class="fixedbar-seprator s-fi-block"></span>
                    <?php }?>
                    <li>
                        <a class="drop-s-m" href="http://blog.sarfejoo.com/">وبلاگ صرفه جو</a>
                        <div>
                            <ul>
                                <li>
                                    <a href="http://blog.sarfejoo.com/category/%d8%a7%d8%ae%d8%a8%d8%a7%d8%b1-%d8%b5%d8%b1%d9%81%d9%87-%d8%ac%d9%88/" >اخبار صرفه جو</a>
                                    <a href="http://blog.sarfejoo.com/category/%d8%b4%d8%a7%d8%af-%d8%b2%db%8c%d8%b3%d8%aa%d9%86/" >شاد زیستن</a>
                                    <a href="http://blog.sarfejoo.com/category/%d8%ab%d8%b1%d9%88%d8%aa%d9%85%d9%86%d8%af-%d8%b4%d9%88%db%8c%d8%af/" >ثروتمند شوید</a>
                                    <a href="http://blog.sarfejoo.com/category/%d9%85%d8%b5%d8%b1%d9%81-%d8%a8%d9%87%db%8c%d9%86%d9%87/" >مصرف بهینه</a>
                                    <a href="http://blog.sarfejoo.com/category/%d9%88%d9%82%d8%aa-%d8%b7%d9%84%d8%a7%d8%b3%d8%aa/" >وقت طلاست</a>
                                    <a href="http://blog.sarfejoo.com/category/%da%86%da%af%d9%88%d9%86%d9%87-%d8%a8%d9%87%d8%aa%d8%b1-%d8%a7%d9%86%d8%aa%d8%ae%d8%a7%d8%a8-%da%a9%d9%86%db%8c%d9%85/" >چگونه بهتر انتخاب کنیم</a>
                                    <a href="http://blog.sarfejoo.com/category/%da%a9%d8%b3%d8%a8-%d9%88-%da%a9%d8%a7%d8%b1-%d9%85%d9%88%d9%81%d9%82/" >کسب و کار موفق</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
            </div>
        </div>
    </div>
    <div class="row" id="top-div" style="margin-top: 40px;">
        <div class="col-md-3">
            <?php if ($logo) { ?>
            <a href="<?php echo $home; ?>"><img style="margin-top: -10px;width: 180px;height: 100px;" src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" /></a>
            <?php } ?>

            <!-- <div id="login-box" class="s-he-login"><?php if (!$logged) { echo $text_welcome; } else { echo $text_logged; } ?></div> -->
            <span class="flash-logo">»</span>
        </div>
        <div class="col-md-6 hidden-xs">
            <div id="search" class="s-he-search">
                <div class="button-search b-search"></div>
                <input type="text" name="search" id="q-input" class="q-input" placeholder="جستجوی هوشمند کالا و خدمات..." value="<?php echo $search; ?>" />
            </div>


        </div>
        <div class="col-md-6 visible-xs">
            <div id="search" class="s-he-search-mob">
                <div id="button-search" class="b-search-mob"></div>
                <input type="text" id="q-input" class="q-input" name="search" placeholder="جستجوی هوشمند کالا و خدمات..." />
            </div>
        </div>
        <div class="col-md-6 visible-xs">
            <!--<div id="s-he-search-mob">
                <div id="button-search" class="b-search-mob"></div>
                <input type="text" id="q-input" class="q-input" name="q-input" placeholder="جستجوی هوشمند کالا و خدمات..." />

            </div>-->
        </div>
        <div class="col-md-3" style="height: 80px;">
            <div>
                <span class="login-icon-u"></span>
                <div id="login-box" class="s-he-login">
                    <?php if (!$logged) { echo $text_welcome; } else { echo $text_logged; } ?></div>
            </div>
        </div>
    </div>
<div class="full-width-div" style="margin-top: -10px;">
    <div class="" style="">
        <div class="bar-full"></div>
    </div>
</div>
    <style>
        #nav.affix {
            position: fixed;
            top: 30px;
            z-index:10;
        }
    </style>
    <script>
    </script>
<div class="row hidden-xs" style="margin-top: 0px;width: 950px%;z-index: 20;" id="nav">
    <div class="col-md-12">
        <div class="btn-group" style="float: right;right: 0px;position: absolute;width: 895px;background-color: #FFFFFF;">
            <button type="button" style="float:right;right:0px;border-radius: 0 !important;width: 160px;height:45px;background-color: #8AB705;color: #ffffff;z-index: 20;"
                    class="btn btn-default dropdown-toggle btn-lg makeblur mj-font" data-toggle="dropdown" aria-expanded="false">
                خدمات
                <span class="caret"></span>
            </button>
            <div class="dropdown-menu" style="width: 100%;opacity: 0.9;background-color: #C2D67F;color: #000000;" role="menu">
                <div class="row">
                    <div class="col-md-6">
                        <div class="">
                            <?php foreach ($categories as $category) { ?>
                            <?php if ($category['children'] && $category['name'] == 'خدمات') { ?>
                            <?php for ($i = 0; $i < (count($category['children'])/2);$i++) { ?>
                            <li style="">
                                <?php if (isset($category['children'][$i])) { ?>
                                <!-- Begin Part 1 of the extension Header menu add level 3 sub categories extension (line to be replaced: number 84 of the header.tpl file) -->
                            <li>
                                <div style="display: inline;margin-top: 10px;">
                                    <div class="strike">
                                        <span>
                                            <i class="<?php echo $category['children'][$i]['icon_class']; ?>" ></i>
                                            <a href="<?php echo $category['children'][$i]['href']; ?>"  style="font-size: 20px;margin-right: 10px;"><?php echo $category['children'][$i]['name']; ?></a>
                                        </span>
                                    </div>
                                    <?php if ($category['children'][$i]['children_level2']) { ?>
                                    <ul class="custom-list-green row">
                                        <?php for ($wi = 0; $wi < count($category['children'][$i]['children_level2']); $wi++) { ?>
                                        <li class="col-md-4" style="display: inline;padding: 0;margin: 0;margin-top: 5px;">
                                            <a style="margin-right: 10px;margin-left: 10px;" href="<?php echo $category['children'][$i]['children_level2'][$wi]['href']; ?>"  >
                                                <?php
                                                                                mb_internal_encoding("UTF-8");
                                                                                $str = $category['children'][$i]['children_level2'][$wi]['name'];
                                                                                $trimedStr = mb_substr($category['children'][$i]['children_level2'][$wi]['name'], 0, 12);
                                                                            ?>
                                                                                <span title='<?php echo $str?>' ><?php echo $trimedStr?>
                                                                                    <?php
                                                                                if($str!=$trimedStr){
                                                                                    echo '...';
                                                                                }
                                                                            ?>
                                                                                </span>
                                            </a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                    <?php } ?>
                                </div>
                            </li>
                            <!-- END Part 1 of the extension Header menu add level 3 sub categories extension -->
                            <?php } ?>
                            </li>
                            <?php } ?>
                            <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="">
                            <?php foreach ($categories as $category) { ?>
                            <?php if ($category['children'] && $category['name'] == 'خدمات') { ?>
                            <?php for ($i = ceil(count($category['children'])/2); $i < count($category['children']);$i++) { ?>
                            <li style="">
                                <?php if (isset($category['children'][$i])) { ?>
                                <!-- Begin Part 1 of the extension Header menu add level 3 sub categories extension (line to be replaced: number 84 of the header.tpl file) -->
                            <li>
                                <div style="display: inline;margin-top: 10px;">
                                    <div class="strike">
                                        <span>
                                            <i class="<?php echo $category['children'][$i]['icon_class']; ?>"></i>
                                            <a href="<?php echo $category['children'][$i]['href']; ?>" style="font-size: 20px;margin-right:30px !important;"><?php echo $category['children'][$i]['name']; ?></a>
                                        </span>
                                    </div>
                                    <?php if ($category['children'][$i]['children_level2']) { ?>
                                    <ul class="custom-list-green row">
                                        <?php for ($wi = 0; $wi < count($category['children'][$i]['children_level2']); $wi++) { ?>
                                        <li class="col-md-4" style="display: inline;margin-top: 5px;padding: 0;margin: 0;">
                                            <a style="margin-right: 10px;margin-left: 10px;" href="<?php echo $category['children'][$i]['children_level2'][$wi]['href']; ?>"  >
                                                <?php
                                                                                mb_internal_encoding("UTF-8");
                                                                                $str = $category['children'][$i]['children_level2'][$wi]['name'];
                                                                                $trimedStr = mb_substr($category['children'][$i]['children_level2'][$wi]['name'], 0, 12);
                                                                            ?>
                                                                                <span title='<?php echo $str?>' ><?php echo $trimedStr?>
                                                                                    <?php
                                                                                if($str!=$trimedStr){
                                                                                    echo '...';
                                                                                }
                                                                            ?>
                                                                                </span>
                                            </a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                    <?php } ?>
                                </div>
                            </li>
                            <!-- END Part 1 of the extension Header menu add level 3 sub categories extension -->
                            <?php } ?>
                            </li>
                            <?php } ?>
                            <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="btn-group" style="float: right;right: 250px;position: absolute;width: 200px;">
            <button type="button" style="float:right;right:0px;border-radius: 0 !important;width: 160px;height:45px;background-color: #F4F4F4;color: #119E8B;z-index: 20;"
                    class="btn btn-default dropdown-toggle btn-lg makeblur" data-toggle="dropdown" aria-expanded="false">
                <span class="badge" id="compare-badge" style="background-color: #119E8B;color:#FFFFFF"><?php echo $text_count_compare; ?></span>
                لیست مقایسه
                <img src="catalog/view/icons/compare-icon.png" width="17" height="10" />
            </button>
            <div class="dropdown-menu" style="width: 895px;right:-250px;opacity: 0.9;background-color: #F4F4F4;color: #000000;" role="menu">
                <div class="row">
                    <div class="col-md-6" style="float: right;">
                        <div id="compare-place-1">
                        <?php if(count($compare_products)>0) { ?>
                            <div id="compare-item-1" data-compare-product-id="<?php echo $compare_products[0]['product_id']?>">
                                <a onclick="removeCompare(<?php echo $compare_products[0]['product_id']?>)" style="float: right;margin-top: 70px;"><img src="catalog/view/icons/remove-icon.png" width="30" height="30" /></a>
                                <img src="<?php echo $compare_products[0]['thumb'] ?>" width="150" height="170" style="float: right;width: 110px;height: 130px;" />
                                <a href="<?php echo $compare_products[0]['href'] ?>" style="float: right;margin-top: 70px;"><span><?php echo $compare_products[0]['name'] ?></span></a>
                            </div>
                        <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="compare-place-2">
                        <?php if(count($compare_products)>1) { ?>
                            <div id="compare-item-2" data-compare-product-id="<?php echo $compare_products[1]['product_id']?>">
                                <a onclick="removeCompare(<?php echo $compare_products[1]['product_id']?>)"  style="float: left;margin-top: 70px;"><img src="catalog/view/icons/remove-icon.png" width="30" height="30" /></a>
                                <img src="<?php echo $compare_products[1]['thumb'] ?>" width="150" height="170"  style="float: left;width: 110px;height: 130px;"/>
                                <a href="<?php echo $compare_products[1]['href'] ?>" style="float: left;margin-top: 70px;"><span><?php echo $compare_products[1]['name'] ?></span></a>
                            </div>
                        <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="row row-centered">
                    <div class="col-md-2 col-centered">
                        <a href="<?php echo $compare_link ?>" class="btn btn-success" style="background-color: #129F8C;color:#FFFFFF;" role="button">

                            صفحه مقایسه
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6" style="float: right;">
                        <div id="compare-place-3">
                        <?php if(count($compare_products)>2) { ?>
                        <div id="compare-item-3" data-compare-product-id="<?php echo $compare_products[2]['product_id']?>">
                            <a onclick="removeCompare(<?php echo $compare_products[2]['product_id']?>)" style="float: right;margin-top: 70px;"><img src="catalog/view/icons/remove-icon.png" width="30" height="30" /></a>
                            <img src="<?php echo $compare_products[2]['thumb'] ?>" width="150" height="170" style="float: right;width: 110px;height: 130px;" />
                            <a href="<?php echo $compare_products[2]['href'] ?>" style="float: right;margin-top: 70px;"><span><?php echo $compare_products[2]['name'] ?></span></a>
                        </div>
                        <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="compare-place-4">
                        <?php if(count($compare_products)>3) { ?>
                        <div id="compare-item-4" data-compare-product-id="<?php echo $compare_products[3]['product_id']?>">
                            <a onclick="removeCompare(<?php echo $compare_products[3]['product_id']?>)"  style="float: left;margin-top: 70px;"><img src="catalog/view/icons/remove-icon.png" width="30" height="30" /></a>
                            <img src="<?php echo $compare_products[3]['thumb'] ?>" width="150" height="170"  style="float: left;width: 110px;height: 130px;"/>
                            <a href="<?php echo $compare_products[3]['href'] ?>" style="float: left;margin-top: 70px;"><span><?php echo $compare_products[3]['name'] ?></span></a>
                        </div>
                        <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="btn-group" style="float: right;right: 450px;position: absolute;width: 200px;">
            <button type="button" style="float:right;right:0px;border-radius: 0 !important;width: 160px;height:45px;background-color: #F4F4F4;color: #119E8B;z-index: 20;"
                    class="btn btn-default dropdown-toggle btn-lg makeblur" data-toggle="dropdown" aria-expanded="false">
                <img src="catalog/view/icons/favorite-icon.png" width="17" height="10" />
لیست محبوب
                <span class="badge" id="favorite-badge" style="background-color: #119E8B;color:#FFFFFF"><?php echo $text_count_wishlist; ?></span>
            </button>
            <div class="dropdown-menu" style="width: 895px;right:-450px;opacity: 0.9;background-color: #F4F4F4;color: #000000;" role="menu">
                <div class="row">
                    <div class="col-md-6" style="float: right;">
                        <div id="fav-place-1">
                            <?php if(count($wish_products)>0) { ?>
                            <div id="fav-item-1" data-wish-product-id="<?php echo $wish_products[0]['product_id']?>">
                                <a onclick="removeWish(<?php echo $wish_products[0]['product_id']?>)" style="float: right;margin-top: 70px;"><img src="catalog/view/icons/remove-icon.png" width="30" height="30" /></a>
                                <img src="<?php echo $wish_products[0]['thumb'] ?>" width="150" height="170" style="float: right;width: 110px;height: 130px;" />
                                <a href="<?php echo $wish_products[0]['href'] ?>" style="float: right;margin-top: 70px;"><span><?php echo $wish_products[0]['name'] ?></span></a>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="fav-place-2">
                            <?php if(count($wish_products)>1) { ?>
                            <div id="fav-item-2" data-wish-product-id="<?php echo $wish_products[1]['product_id']?>">
                                <a onclick="removeWish(<?php echo $wish_products[1]['product_id']?>)"  style="float: left;margin-top: 70px;"><img src="catalog/view/icons/remove-icon.png" width="30" height="30" /></a>
                                <img src="<?php echo $wish_products[1]['thumb'] ?>" width="150" height="170"  style="float: left;width: 110px;height: 130px;"/>
                                <a href="<?php echo $wish_products[1]['href'] ?>" style="float: left;margin-top: 70px;"><span><?php echo $wish_products[1]['name'] ?></span></a>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="row row-centered">
                    <div class="col-md-2 col-centered">
                        <a href="<?php echo $favorite_link ?>" class="btn btn-success" style="background-color: #129F8C;color:#FFFFFF;" role="button">
                            صفحه لیست محبوب
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6" style="float: right;">
                        <div id="fav-place-3">
                            <?php if(count($wish_products)>2) { ?>
                            <div id="fav-item-3" data-wish-product-id="<?php echo $wish_products[2]['product_id']?>">
                                <a onclick="removeWish(<?php echo $wish_products[2]['product_id']?>)" style="float: right;margin-top: 70px;"><img src="catalog/view/icons/remove-icon.png" width="30" height="30" /></a>
                                <img src="<?php echo $wish_products[2]['thumb'] ?>" width="150" height="170" style="float: right;width: 110px;height: 130px;" />
                                <a href="<?php echo $wish_products[2]['href'] ?>" style="float: right;margin-top: 70px;"><span><?php echo $wish_products[2]['name'] ?></span></a>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="fav-place-4">
                            <?php if(count($wish_products)>3) { ?>
                            <div id="fav-item-4" data-wish-product-id="<?php echo $wish_products[3]['product_id']?>">
                                <a onclick="removeWish(<?php echo $compare_products[3]['product_id']?>)"  style="float: left;margin-top: 70px;"><img src="catalog/view/icons/remove-icon.png" width="30" height="30" /></a>
                                <img src="<?php echo $wish_products[3]['thumb'] ?>" width="150" height="170"  style="float: left;width: 110px;height: 130px;"/>
                                <a href="<?php echo $wish_products[3]['href'] ?>" style="float: left;margin-top: 70px;"><span><?php echo $wish_products[3]['name'] ?></span></a>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            body .blur{
                -webkit-filter: blur(7px);
                -moz-filter: blur(15px);
                -o-filter: blur(15px);
                -ms-filter: blur(15px);
                filter: blur(15px);
            }
            .custom-list-purple li:before{
                content: url(catalog/view/images/splitter.png);
            }
            .custom-list-green li:before{
                content: url(catalog/view/images/splitter2.png);
            }

            .strike {
                display: block;
                text-align: right;
                overflow: hidden;
                white-space: nowrap;
            }

            .strike > span {
                position: relative;
                display: inline-block;
                font-size: 20px;
            }

            .strike > span:before,
            .strike > span:after {
                content: "";
                position: absolute;
                top: 50%;
                width: 9999px;
                height: 2px;
                background: #FFFFFF;
            }

            .strike > span:before {
                right: 100%;
                margin-right: 15px;
            }

            .strike > span:after {
                left: 100%;
                margin-left: 15px;
            }

        </style>
        <div class="btn-group" style="float: left;position: absolute;right:0;width: 895px;z-index: 10;">
            <button type="button" style="float:left;left:0px;border-radius: 0 !important;width: 160px;height:45px;background-color: #7C2981;color: #ffffff;"
                    class="btn btn-default dropdown-toggle btn-lg mj-font" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span>
کالا
            </button>
            <div class="dropdown-menu" style="width: 100%;opacity: 0.95;background-color: #BD94C0;color: #000000;" role="menu">
                <div class="row">
                    <div class="col-md-6">
                        <div class="">
                            <?php foreach ($categories as $category) { ?>
                            <?php if ($category['children'] && $category['name'] == 'کالا') { ?>
                            <?php for ($i = 0; $i < (count($category['children'])/2);$i++) { ?>
                            <li style="">
                                <?php if (isset($category['children'][$i])) { ?>
                                <!-- Begin Part 1 of the extension Header menu add level 3 sub categories extension (line to be replaced: number 84 of the header.tpl file) -->
                            <li>
                                <div style="display: inline;margin-top: 10px;">
                                    <div class="strike">
                                        <span>
                                            <i class="<?php echo $category['children'][$i]['icon_class']; ?>"></i>
                                            <a href="<?php echo $category['children'][$i]['href']; ?>" style="font-size: 20px !important;"><?php echo $category['children'][$i]['name']; ?></a>
                                        </span>
                                    </div>
                                    <?php if ($category['children'][$i]['children_level2']) { ?>
                                    <ul class="custom-list-purple row">
                                        <?php for ($wi = 0; $wi < count($category['children'][$i]['children_level2']); $wi++) { ?>
                                        <li class="col-md-4" style="display: inline;padding: 0;margin: 0;margin-top: 5px;">
                                            <a style="margin-right: 10px;margin-left: 10px;" href="<?php echo $category['children'][$i]['children_level2'][$wi]['href']; ?>"  >
                                                <?php
                                                                                mb_internal_encoding("UTF-8");
                                                                                $str = $category['children'][$i]['children_level2'][$wi]['name'];
                                                                                $trimedStr = mb_substr($category['children'][$i]['children_level2'][$wi]['name'], 0, 12);
                                                                            ?>
                                                                                <span title='<?php echo $str?>' ><?php echo $trimedStr?>
                                                                                    <?php
                                                                                if($str!=$trimedStr){
                                                                                    echo '...';
                                                                                }
                                                                            ?>
                                                                                </span>
                                            </a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                    <?php } ?>
                                </div>
                            </li>
                            <!-- END Part 1 of the extension Header menu add level 3 sub categories extension -->
                            <?php } ?>
                            </li>
                            <?php } ?>
                            <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="">
                            <?php foreach ($categories as $category) { ?>
                                <?php if ($category['children'] && $category['name'] == 'کالا') { ?>
                                    <?php for ($i = ceil(count($category['children'])/2); $i < count($category['children']);$i++) { ?>
                                        <li style="">
                                                <?php if (isset($category['children'][$i])) { ?>
                                                    <!-- Begin Part 1 of the extension Header menu add level 3 sub categories extension (line to be replaced: number 84 of the header.tpl file) -->
                                                    <li>
                                                        <div style="display: inline;margin-top: 10px;">
                                                            <div class="strike">
                                                                <span>
                                                                    <i class="<?php echo $category['children'][$i]['icon_class']; ?>"></i>
                                                                    <a href="<?php echo $category['children'][$i]['href']; ?>" style="font-size: 20px !important;"><?php echo $category['children'][$i]['name']; ?></a>
                                                                </span>
                                                            </div>
                                                            <?php if ($category['children'][$i]['children_level2']) { ?>
                                                                <ul class="custom-list-purple row">
                                                                    <?php for ($wi = 0; $wi < count($category['children'][$i]['children_level2']); $wi++) { ?>
                                                                    <li class="col-md-4" style="display: inline;padding: 0;margin: 0;;margin-top: 5px;">
                                                                        <a style="margin-right: 10px;margin-left: 10px;" href="<?php echo $category['children'][$i]['children_level2'][$wi]['href']; ?>"  >
                                                                            <?php
                                                                                mb_internal_encoding("UTF-8");
                                                                                $str = $category['children'][$i]['children_level2'][$wi]['name'];
                                                                                $trimedStr = mb_substr($category['children'][$i]['children_level2'][$wi]['name'], 0, 12);
                                                                            ?>
                                                                                <span title='<?php echo $str?>' ><?php echo $trimedStr?>
                                                                            <?php
                                                                                if($str!=$trimedStr){
                                                                                    echo '...';
                                                                                }
                                                                            ?>
                                                                                </span>
                                                                        </a>
                                                                    </li>
                                                                    <?php } ?>
                                                                </ul>
                                                            <?php } ?>
                                                        </div>
                                                    </li>
                                                    <!-- END Part 1 of the extension Header menu add level 3 sub categories extension -->
                                                <?php } ?>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="notification"></div>

<script type="text/javascript">

function openSubMenu(id){
        //
        $('.submenu').hide();
        document.getElementById("id_menu_"+id).style.display="block";
}
function closeSubMenu(){
		$('.submenu').hide();
}


</script>

<!--[if IE 7]>
<style>
#fi-cats > ul > li > div {
width:140px!important;
}
.submenu{
   right:146px;
}
</style>
<![endif]-->
<!--[if IE 8]>
<style>
#fi-cats > ul > li > div {
width:140px!important;
}
.submenu{
   right:146px;
}
</style>
 <![endif]-->