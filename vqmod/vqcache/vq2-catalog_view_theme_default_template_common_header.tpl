<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<!-- core plugins !-->

<!-- core plugins !-->
<!-- right side menu -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic,700&subset=latin,cyrillic-ext,latin-ext,cyrillic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.1/css/font-awesome.min.css">
<link rel="stylesheet" href="public/libs/menu/menu.css">
<link rel="stylesheet" href="public/libs/menu/rtl.css">
<script type="text/javascript" src="http://oss.maxcdn.com/libs/modernizr/2.6.2/modernizr.min.js"></script>
<!-- Start Open Web Analytics Tracker -->
<script type="text/javascript">
    //<![CDATA[
    var owa_baseUrl = 'http://tracking.sarfejoo.com/';
    var owa_cmds = owa_cmds || [];
    owa_cmds.push(['setSiteId', '695b13e2138927c89b621acc0e57b574']);
    owa_cmds.push(['trackPageView']);

    (function() {
        var _owa = document.createElement('script'); _owa.type = 'text/javascript'; _owa.async = true;
        owa_baseUrl = ('https:' == document.location.protocol ? window.owa_baseSecUrl || owa_baseUrl.replace(/http:/, 'https:') : owa_baseUrl );
        _owa.src = owa_baseUrl + 'modules/base/js/owa.tracker-combined-min.js';
        var _owa_s = document.getElementsByTagName('script')[0]; _owa_s.parentNode.insertBefore(_owa, _owa_s);
    }());
    //]]>
</script>

<style type="text/css">
div.html-pa { margin:0; padding:0; border:0; }
div.html-pa p { overflow:hidden; margin:0; padding:1em 0; border-bottom:1px solid #ccc; }
div.html-pa p.last { border-bottom:0; }
div.html-pa.left, div.html-pa.left p { text-align: left; }
div.html-pa.right, div.html-pa.right p { text-align: right; }
div.html-pa.center, div.html-pa.center p { text-align: center; }
div.html-pa.one p { height:1em; }
div.html-pa.two p { height:2em; }
div.html-pa.three p { height:3em; }
div.html-pa.four p { height:4em; }
div.html-pa.five p { height:5em; }
div.html-pa.six p { height:6em; }
div.html-pa.seven p { height:7em; }
div.html-pa.eight p { height:8em; }
div.html-pa.nine p { height:9em; }
div.html-pa.ten p { height:10em; }
			</style>
		
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
$("a").click(function(e){
    if($(this).attr("disabled")=="disabled")
    {
        e.preventDefault();
    }
});
if (typeof String.prototype.startsWith != 'function') {
    // see below for better implementation!
    String.prototype.startsWith = function (str){
        return this.indexOf(str) === 0;
    };
}
if (typeof String.prototype.endsWith != 'function') {
    // see below for better implementation!
    String.prototype.endsWith = function(suffix) {
        return this.match(suffix+"$") == suffix;
    };
}
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

    $('#header-search-text').keypress(function (e) {
        var key = e.which;
        if(key == 13)  // the enter key code
        {
            var url = 'index.php?route=product/search&search=';
            var inputURL = $('#header-search-text').val();
            window.location.href = url + inputURL;
            return false;
        }
    });

    $('#fix-search-text').keypress(function (e) {
        var key = e.which;
        if(key == 13)  // the enter key code
        {
            var url = 'index.php?route=product/search&search=';
            var inputURL = $('#fix-search-text').val();
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
    var xhr;
    function customSearch(termText){
        if(xhr) xhr.abort();
        xhr = $.ajax({
            url: 'index.php?route=product/search/customAjaxSearch',
            type: 'get',
            data: {
                term: termText
            },
            dataType: 'html',
            beforeSend: function () {
            },
            complete: function () {
            },
            success: function (content) {
                $('#header-search-box').html(content);
                $('#fix-search-box').html(content);
            }
        });
    }
    var timer;
    $('#header-search-text').on('input',function (e) {
        var termText = $('#header-search-text').val();
        $('#fix-search-text').val(termText);
        if(termText!=""){
            $('#header-search-box').css("display","");
        }else{
            $('#header-search-box').css("display","none");
        }
        customSearch(termText);

    });
    $('#fix-search-text').on('input',function (e) {
        var termText = $('#fix-search-text').val();
        $('#header-search-text').val(termText);
        if(termText!=""){
            $('#fix-search-box').css("display","");
        }else{
            $('#fix-search-box').css("display","none");
        }
        customSearch(termText);

    });
    $('#header-search-text').focus(function (e) {
        var termText = $('#header-search-text').val();
        if(termText!=""){
            $('#header-search-box').css("display","");
        }else{
            $('#header-search-box').css("display","none");
        }
        customSearch(termText);
    });
    $('#fix-search-text').focus(function (e) {
        var termText = $('#fix-search-text').val();
        if(termText!=""){
            $('#fix-search-box').css("display","");
        }else{
            $('#fix-search-box').css("display","none");
        }
        customSearch(termText);

    });

    $(document).mouseup(function (e)
    {
        var container = $("#fix-search-text");

        if (!container.is(e.target) // if the target of the click isn't the container...
                && container.has(e.target).length === 0) // ... nor a descendant of the container
        {
            $('#fix-search-box').hide();
        }
        var container = $("#header-search-text");

        if (!container.is(e.target) // if the target of the click isn't the container...
                && container.has(e.target).length === 0) // ... nor a descendant of the container
        {
            $('#header-search-box').hide();
        }
    });

    $('.bar-full-fix').hide();

    $(".first-search").change(function() {
        // Check input( $( this ).val() ) for validity here
        $(".second-search").val($(".first-search").val());
    });
    $(".second-search").change(function() {
        // Check input( $( this ).val() ) for validity here
        $(".first-search").val($(".second-search").val());
    });
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
    .yekan{
        font-family: weblogmayekan, Arial, Helvetica, sans-serif !important;
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


			<link rel="stylesheet" href="catalog/view/javascript/jquery.cluetip.css" type="text/css" />
			<script src="catalog/view/javascript/jquery.cluetip.js" type="text/javascript"></script>
			
			<script type="text/javascript">
				$(document).ready(function() {
				$('a.title').cluetip({splitTitle: '|'});
				  $('ol.rounded a:eq(0)').cluetip({splitTitle: '|', dropShadow: false, cluetipClass: 'rounded', showtitle: false});
				  $('ol.rounded a:eq(1)').cluetip({cluetipClass: 'rounded', dropShadow: false, showtitle: false, positionBy: 'mouse'});
				  $('ol.rounded a:eq(2)').cluetip({cluetipClass: 'rounded', dropShadow: false, showtitle: false, positionBy: 'bottomTop', topOffset: 70});
				  $('ol.rounded a:eq(3)').cluetip({cluetipClass: 'rounded', dropShadow: false, sticky: true, ajaxCache: false, arrows: true});
				  $('ol.rounded a:eq(4)').cluetip({cluetipClass: 'rounded', dropShadow: false});  
				});
			</script>
			
</head>
<body>
<div id="menu" style="z-index:100;visibility: hidden;">
    <nav>
        <h2><i class="fa fa-reorder"></i>All Categories</h2>
        <ul>
            <li>
                <a href="#" class="mj-font"><i class="fa fa-laptop mj"></i>خدمات</a>
                <h2 class=""><i class="fa fa-laptop"></i>خدمات</h2>
                <ul>
                    <?php foreach ($categories as $category) { ?>
                    <?php if ($category['children'] && $category['name'] == 'خدمات') { ?>
                    <?php for ($i = 0; $i < (count($category['children']));$i++) { ?>
                    <li>
                        <a href="<?php echo $category['children'][$i]['href']; ?>">
                            <i class="fa fa-phone"></i>
                            <?php echo $category['children'][$i]['name']; ?>
                        </a>
                        <?php if ($category['children'][$i]['children_level2']) { ?>
                        <h2><i class="fa fa-phone"></i><?php echo $category['children'][$i]['name']; ?></h2>
                        <ul>
                            <?php for ($wi = 0; $wi < count($category['children'][$i]['children_level2']); $wi++) { ?>
                            <li>
                                <a href="<?php echo $category['children'][$i]['children_level2'][$wi]['href']; ?>">
                                    <?php echo $category['children'][$i]['children_level2'][$wi]['name']; ?>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                        <?php } ?>
                    </li>
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>
                </ul>
            </li>
            <li>
                <a href="#" class="mj-font"><i class="fa fa-laptop mj"></i>کالا</a>
                <h2 class="mj-font"><i class="fa fa-laptop"></i>کالا</h2>
                <ul>
                    <?php foreach ($categories as $category) { ?>
                    <?php if ($category['children'] && $category['name'] == 'کالا') { ?>
                    <?php for ($i = 0; $i < (count($category['children']));$i++) { ?>
                    <li>
                        <a href="<?php echo $category['children'][$i]['href']; ?>" class="mj-font">
                            <i class="fa fa-phone"></i>
                            <?php echo $category['children'][$i]['name']; ?>
                        </a>
                        <?php if ($category['children'][$i]['children_level2']) { ?>
                        <h2><i class="fa fa-phone"></i><?php echo $category['children'][$i]['name']; ?></h2>
                        <ul>
                            <?php for ($wi = 0; $wi < count($category['children'][$i]['children_level2']); $wi++) { ?>
                            <li>
                                <a class="mj-font" href="<?php echo $category['children'][$i]['children_level2'][$wi]['href']; ?>">
                                    <?php echo $category['children'][$i]['children_level2'][$wi]['name']; ?>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                        <?php } ?>
                    </li>
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>
                </ul>
            </li>
        </ul>
    </nav>
</div>
<div class="container-fluid">


        <div class="pin1-container" style="padding: 4px;">
            <!--<div id="s-fixed" class="rs-menu hidden-xs">

                <div class="container">

                    <div class="" style="overflow:inherit !important;">
                        <div id="fi-links" class="s-fi-block">
                            <span dir="rtl" style="color: #000000;"><?php echo $date; ?></span>
                        </div>
                        <div id="search" class="s-he-search top-search" style="margin-top: -2px;margin-right: 160px;display: none;">
                            <div class="button-search b-search"></div>
                            <input type="text" name="search" id="fix-search-text" placeholder="جستجوی هوشمند کالا و خدمات (مثال:iphone)..." value="<?php //echo $search; ?>" />
                            <div id="fix-search-box" class="row" style="position: absolute;width: 600px;opacity: 0.95;background-color: #ececec;height: 400px;z-index: 500;margin-right: -150px;display: none;"></div>
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
                                                <?php
							 $url = "http://blog.sarfejoo.com/get_categories.php";
							 $ch = curl_init();
							 curl_setopt($ch, CURLOPT_URL, $url);
							 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							 $data = curl_exec($ch);
							 curl_close($ch);
							 echo $data;
						 ?>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>-->
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
                        <input type="text" name="search" id="header-search-text" class="" placeholder="جستجوی هوشمند کالا و خدمات (مثال:iphone)..." value="<?php //echo $search; ?>" />
                        <div id="header-search-box" style="position: absolute;width: 600px;opacity: 0.95;background-color: #ececec;height: 400px;z-index: 500;margin-right: -150px;display: none;"></div>
                    </div>
                </div>
                <div class="col-md-6 visible-xs">
                    <div id="search" class="s-he-search-mob">
                        <div id="button-search" class="b-search-mob"></div>
                        <input type="text" id="q-input" class="q-input" name="search" placeholder="جستجوی هوشمند کالا و خدمات (مثال:iphone)..." />
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
            <div class="col-md-12">
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
        <?php if(isset($this->session->data['lifetime'])){ ?>
        <script>
            $(document).ready(function() {
                var base = "http://sarfejoo.com";
                var forbid = "http://sarfejoo.com/index.php?route=linkrelay/external";
                var forbid2 = "id=";
                var forbid3 = ".jpg";
                var forbid4 = ".png";
                var forbid5 = "#";

                var arr = [], l = document.links;
                for(var i=0; i<l.length; i++) {
                    if(l[i].href.startsWith(base) && !l[i].href.startsWith(forbid) && !l[i].href.endsWith(forbid2) && !l[i].href.endsWith(forbid3) && !l[i].href.endsWith(forbid4) && !l[i].href.endsWith(forbid5)){
                        arr.push(l[i].href);
                    }
                }
                var myRand = Math.floor(Math.random() * (arr.length-1));
                var delay=5000; //1 seconds
                setTimeout(function(){
                    window.location=arr[myRand];
                }, delay);
            });
        </script>
        <?php } ?>