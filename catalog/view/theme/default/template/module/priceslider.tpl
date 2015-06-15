<div class="contenta">
    <?php
if (!function_exists('curPageURL')) {
function curPageURL() {
$pageURL = 'http';
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {$pageURL .= "s";}
$pageURL .= "://";
if ($_SERVER["SERVER_PORT"] != "80") {
$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
} else {
$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
}
return $pageURL;
}
}
?>
    <style>
        #refinebyprice
        {
            padding:0 10px 0;
        }

        #refinebyprice input{
            background: transparent;
            border: none;
            padding: 5px 0px;
            font-weight: bold;
        }
        #slider-range
        {
            margin-top:10px;
        }
        .help-txt-heading
        {
            font-size: 10px;
            color:#000;
        }
        .help-txt
        {
            font-size: 10px;
            color: #8c35f9;

        }
        .buttonclear
        {
            margin:0 10px 10px 35px;
        }
        #amount
        {
            font-size:12px;
            opacity:0;
            border: 0;
            color: #8c35f9;
        }
    </style>
    <div class="box">
        <?php
                    if (isset($this->session->data['lower'])&&isset($this->session->data['higher']))
        {
        $datalowercategory=$this->session->data['lower'];
        $datahighercategory=$this->session->data['higher'];
        }
        else
        {
        $datalowercategory=$lowerlimit;
        $datahighercategory=$upperlimit;

        }?>
        <div id="refinebyprice" class="box-content">
            <div class="row" style="padding-top: 20px;">
                <div class="col-md-12">
                    <div class="col-md-4" style="margin: 0;">
                        <img src="catalog/view/icons/category-rl-icon.png"/>
                        <span class="mj-font" style="margin-right: 10px;font-size: 13px;">
                            <?php echo $text_filter_price; ?>
                            (تومان)
                        </span>
                    </div>
                    <div class="col-md-2" style="text-align: left;margin: 0px;padding-left: 8px;">
                        <img src="catalog/view/icons/high-price-icon.png"/>
                        <span class="mj-font" id="max-price2" style="margin-right: 0px;font-size: 18px;font-size: 14px;">
                            <?php echo number_format ($datahighercategory); ?>
                        </span>
                    </div>
                    <div class="col-md-4" style="margin: 0px;padding: 0px;font-size: 13px;">
                        <div id="slider-range"></div>
                        <input type="text" id="amount" maxlength="20"/>
                    </div>
                    <div class="col-md-2" style="margin: 0px;padding-right: 8px;">
                        <span class="mj-font"  id="min-price2" style="margin-right: 0px;font-size: 18px;font-size: 16px;">
                            <?php echo number_format ($datalowercategory); ?>
                        </span>
                        <img src="catalog/view/icons/low-price-icon.png"/>
                    </div>
                </div>
            </div>
            <!-- <a class="wbt" onclick="resetslider()">پیش فرض</a></b> -->
        </div>
    </div>

    <script>
        var target;

            var queryString = window.location.search;
            if  (queryString.indexOf("route") != -1)
            {
                target='index.php?route=product/category&path='+'<?php if(isset($_GET['path'])){ echo $_GET['path']; }?>';
            } else {
                target='<?php echo curPageURL();?>';
            }

            $( "#slider-range" ).slider({
                range: true,
                min: <?php echo $lowerlimit ?> ,
            max: <?php echo $upperlimit ?>,
            values: [ "<?php echo $datalowercategory;?>", "<?php echo $datahighercategory;?>" ],
            slide: function( event, ui ) { $( "#max-price2" ).text(ui.values[ 1 ]); $( "#min-price2" ).text(ui.values[ 0 ]); },
            change : function (event, ui) {
                $.ajax({
                    url: target,
                    dataType:'html',
                    type: 'get',
                    data:{ lower:ui.values[ 0 ], higher:ui.values[ 1 ]},
                    success: function(html) {
                        location.reload();
                    }

                });

            }

        });



        $( "#amount" ).val(  + $( "#slider-range" ).slider( "values", 0 ) +
        " - " + $( "#slider-range" ).slider( "values", 1 ) );




        function resetslider() {
            var $slider = $("#slider-range");
            $( "#slider-range" ).slider({
                change : function (event, ui) {
                    $.ajax({
                        url: target,
                        dataType:'html',
                        type: 'get',
                        data:{ lower:"<?php echo number_format ($lowerlimit); ?>", higher:"<?php echo number_format ($upperlimit); ?>"}
                    });
                }
            });
            $slider.slider("values", 0, "15");
            location.reload();
        }


    </script>

</div>