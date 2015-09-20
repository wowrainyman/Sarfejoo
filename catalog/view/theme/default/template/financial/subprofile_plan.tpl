<?php echo $header; ?>
<script type="text/javascript">
    function Create2DArray(rows) {
        var arr = [];

        for (var i=0;i<rows;i++) {
            arr[i] = [];
        }

        return arr;
    }
    var prices = Create2DArray(100);
    <?php foreach ($plan_price_structures as $plan_price_structure) {
        $count = 0; ?>
    <?php foreach ($plan_price_structure as $pps) { ?>
            prices[<?php echo $count; ?>][<?php echo $pps['id']; ?>] = <?php echo ($pps['value'])*(intval($pps['duration']/30)); ?>;
            <?php $count++; ?>
        <?php } ?>
    <?php } ?>
</script>
<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet'>
<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet'>

<link rel="stylesheet" href="catalog/view/theme/default/stylesheet/pricingTable/master.css" media="screen">
<link rel="stylesheet" href="catalog/view/theme/default/stylesheet/pricingTable/reset.css" media="screen">

<script type="text/javascript" src="catalog/view/theme/default/stylesheet/pricingTable/css-browser-select.js"></script>
<div class="row" style="margin-top: 40px;">
    <div class="col-md-12 box-shadow" style="padding: 4px;">
        <div class="col-md-12" id="first-step">
            <div id="pageContainer">
                <div id="tableContainer">
                    <?php foreach ($featuredPlans as $plan) { ?>
                    <div class="tableCell<?php if($plan['is_recommended']) echo ' recommended' ?>">
                        <div class="tableHeading">
                            <h2>
                                <?php echo $plan['name']; ?>
                            </h2>

                            <div class="price1 priceContainer">
                                <p>

                                    <sup><?php echo str_pad($plan['price']%1000, 3, '0', STR_PAD_LEFT);?></sup>
                                    <?php echo intval($plan['price']/1000); ?>
                                </p>
                                <span>
ماهانه
                                </span>
                            </div>
                            <!-- end price1 -->
                        </div>
                        <!-- end tableHeading -->
                    </div>
                    <?php } ?>

                    <div class="cl"><!-- --></div>

                    <table class="pricingTableContent" dir="ltr">
                        <tr class="signUpRow">
                            <td>
                                <a href="" class="signUpButton first-signup">
اعمال تخفیف دوره ای
                                </a>
                            </td>
                            <td>
                                <a href="" class="signUpButton first-signup">
                                    اعمال تخفیف دوره ای
                                </a>
                            </td>
                            <td class="recommended">
                                <a href="" class="signUpButton first-signup">
                                    اعمال تخفیف دوره ای
                                </a>
                            </td>
                            <td>
                                <a href="" class="signUpButton first-signup">
                                    اعمال تخفیف دوره ای
                                </a>
                            </td>
                        </tr>
                        <?php $counter = 0; ?>
                        <!-- Table Content -->
                        <?php foreach ($plan_structures as $plan_structure) { ?>
                        <tr class="<?php if($counter%2) echo 'altRow'; ?>">
                            <?php foreach ($plan_structure as $pstr) { ?>
                                <td class="<?php if($pstr['is_recommended']) echo 'recommended' ?>">
                                    <?php echo $pstr['title']; ?>
                                    <br/>
                                    <strong dir="rtl">
                                        <?php switch ($pstr['type']) {
                                                case 'int':
                                                    if($pstr['value']== -1){
                                                        echo 'نامحدود' . '&nbsp;';
                                                    }else{
                                                        echo $pstr['value'] . '&nbsp;';
                                                        echo 'عدد' . '&nbsp;';
                                                    }
                                                    break;
                                                case 'person':
                                                    if($pstr['value']== -1){
                                                        echo 'نامحدود' . '&nbsp;';
                                                    }else{
                                                        echo $pstr['value'] . '&nbsp;';
                                                        echo 'نفر' . '&nbsp;';
                                                    }
                                                    break;
                                                case 'time':
                                                    if($pstr['value']== -1){
                                                        echo 'نامحدود' . '&nbsp;';
                                                    }else{
                                                        echo $pstr['value'] . '&nbsp;';
                                                        echo 'بار' . '&nbsp;';
                                                    }
                                                    break;
                                                case 'perc':
                                                if($pstr['value']== -1){
                                                    echo 'نامحدود' . '&nbsp;';
                                                }else{
                                                    echo $pstr['value'] . '&nbsp;';
                                                    echo '%' . '&nbsp;';
                                                }
                                                break;
                                                case 'hour':
                                                    echo $pstr['value'] . '&nbsp;';
                                                    break;
                                                case 'bool':
                                                    if($pstr['value']== 1){
                                                        echo '<img src="catalog/view/icons/check-icon.png" width="15" height="15">';
                                                    }else{
                                                        echo '<img src="catalog/view/icons/delete-icon.png" width="15" height="15">';
                                                    }
                                                    break;
                                            } ?>
                                    </strong>
                                </td>
                            <?php } ?>
                        </tr>
                        <?php $counter++; ?>
                        <?php } ?>
                        <!-- Table Footer -->
                        <tfoot>
                        <tr>
                            <?php foreach ($featuredPlans as $plan) { ?>
                            <td class="<?php if($plan['is_recommended']) echo ' recommended' ?>">
                                <h4>
                                <?php echo intval($plan['price']/1000); ?>
                                    <sup><?php echo str_pad($plan['price']%1000, 3, '0', STR_PAD_LEFT);?></sup>
                                </h4>
                                <span>
ماهانه
                                </span>

                                <a href="" class="signUpButton first-signup">
                                    اعمال تخفیف دوره ای
                                </a>
                            </td>
                            <?php } ?>
                        </tr>
                        </tfoot>
                    </table>

                </div>
                <!-- end tableContainer -->

            </div>
            <!-- end pageContainer -->
        </div>
        <div class="col-md-12" id="second-step" style="display: none;">
            <div id="pageContainer">
                <div id="tableContainer">
                    <?php foreach ($featuredPlans as $plan) { ?>
                    <div class="tableCell<?php if($plan['is_recommended']) echo ' recommended' ?>">
                        <div class="tableHeading">
                            <h2>
                                <?php echo $plan['name']; ?>
                            </h2>

                            <div class="price1 priceContainer">
                                <p>

                                    <sup><?php echo str_pad($plan['price']%1000, 3, '0', STR_PAD_LEFT);?></sup>
                                    <?php echo intval($plan['price']/1000); ?>
                                </p>
                                <span>
ماهانه
                                </span>
                            </div>
                            <!-- end price1 -->
                        </div>
                        <!-- end tableHeading -->
                    </div>
                    <?php } ?>

                    <div class="cl"><!-- --></div>

                    <table class="pricingTableContent" dir="ltr">
                        <tr class="signUpRow">
                            <td>
                            </td>
                            <td>

                            </td>
                            <td class="recommended">
                            </td>
                            <td>
                            </td>
                        </tr>
                        <?php $counter = 0; ?>
                        <!-- Table Content -->
                        <?php foreach ($plan_price_structures as $plan_price_structure) { ?>
                        <tr class="<?php if($counter%2) echo 'altRow'; ?>">
                            <?php foreach ($plan_price_structure as $pstr) { ?>
                            <td class="<?php if($pstr['is_recommended']) echo 'recommended' ?>">
                                <?php echo $pstr['name']; ?>
                                <br/>
                                <h4>
                                    <strong style="font-size: x-large;">
                                        <?php echo intval($pstr['value']/1000); ?>
                                        <sup><?php echo str_pad($pstr['value']%1000, 3, '0', STR_PAD_LEFT);?></sup>
                                    </strong>
                                </h4>
                                درماه
                            </td>
                            <?php } ?>
                            <?php $counter++; ?>
                        </tr>
                        <?php } ?>
                        <!-- Table Footer -->
                        <tfoot>
                        <tr>
                            <?php foreach ($featuredPlans as $plan) { ?>
                            <td class="<?php if($plan['is_recommended']) echo ' recommended' ?>">
                                <a href="" class="signUpButton signUpButton-<?php echo $plan['id']; ?> second-signup">
                                    انتخاب
                                </a>
                            </td>
                            <?php } ?>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- end tableContainer -->

            </div>
            <div class="col-md-12" style="margin: 10px;">
                <div class="col-md-4" style="margin: 10px;">
                </div>
                <div class="col-md-3" style="margin: 10px;">
                </div>
                <div class="col-md-4" style="margin: 10px;float: left;">
                    <a class="button back-button-2">
مشاهده مجدد خصوصیات طرح ها
                    </a>
                </div>
            </div>
            <!-- end pageContainer -->
        </div>
        <div class="col-md-12" id="third-step" style="display: none;">
            <?php $count=0;foreach ($featuredPlans as $plan) { $plan_id=$plan['id']; ?>
            <div class="final-step-<?php echo $plan['id'];?>" style="display: none;">
                <form action="<?php echo $action;?>" method="get">
                    <input type="hidden" id="route" name="route" value="financial/subprofile_plan/confirm" />
                    <input type="hidden" name="subprofile_id" value="<?php echo $subprofile_id;?>" />
                    <input type="hidden" name="plan_id" value="<?php echo $plan['id'];?>" />
                    <div class="col-md-12" style="margin: 10px;">
                        <div class="col-md-4" style="margin: 10px;">
                            نام طرح:
                        </div>
                        <div class="col-md-4" style="margin: 10px;">
                            <?php echo $plan['name']; ?>
                        </div>
                    </div>
                    <br/>
                    <div class="col-md-12" style="margin: 10px;">
                        <div class="col-md-4" style="margin: 10px;">
مدت دوره:
                        </div>
                        <div class="col-md-4" style="margin: 10px;">
                            <?php $innercount = 0; foreach ($periods as $period) { ?>
                                <div class="row row-<?php echo $count . '-' . $period['id']; ?>">
                                    <div class="col-md-6 div-<?php echo $count . '-' . $period['id']; ?>">
                                        <input type="radio" name="period_id" value="<?php echo $period['id']; ?>">
                                        <?php echo $period['name']; ?>
                                    </div>
                                    <div class="col-md-6 div-<?php echo $count . '-' . $period['id']; ?>">
                                        <label id="price-<?php echo $count . '-' . $period['id']; ?>"></label>
                                        <script type="text/javascript">
                                            $("#price-<?php echo $count . '-' . $period['id']; ?>").html(prices[<?php echo $count;?>][<?php echo $period['id'];?>]);
                                            if(prices[<?php echo $count;?>][<?php echo $period['id'];?>] == 0){
                                                $(".div-<?php echo $count . '-' . $period['id']; ?>").remove();
                                                if(<?php echo $innercount; ?> == 0){
                                                    $(".row-<?php echo $count . '-' . $period['id']; ?>").append('<a class="btn bt-default button" href="index.php?route=financial/subprofile_plan_free&id=<?php echo $subprofile_id;?>&plan_id=<?php echo $plan_id;?>">' +
                                                    'ثبت اکانت ' +
                                                    'رایگان ' +
                                                    'به مدت دو هفته' +
                                                    '</a>');
                                                }
                                            }
                                        </script>
                                        تومان
                                    </div>
                                </div>
                            <?php $innercount++; } ?>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin: 10px;">
                        <div class="col-md-4" style="margin: 10px;">
                            <input type="submit" class="btn bt-default button" value="پرداخت از طریق بانک اقتصاد نوین" />
                            <br/>
                            <br/>
                            <!--<button id="jahanpay<?php echo $count;?>" onclick='$("#route<?php echo $count;?>").val("financial/subprofile_plan_jahanpay/confirm");$("#myForm<?php echo $count;?>").submit();' class="button back-button">
پرداخت از طریق درگاه جهان پی
                            </button>-->
                        </div>
                        <div class="col-md-3" style="margin: 10px;">
                        </div>
                        <div class="col-md-4" style="margin: 10px;float: left;">
                            <a class="button back-button">
مشاهده مجدد قیمت طرح ها
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <?php $count++; } ?>
        </div>

    </div>
</div>
<script type="text/javascript">

    $(document).ready(function() {
        $( ".first-signup" ).click(function(event) {
            event.preventDefault();
            $( "#first-step").hide();
            $( "#second-step").fadeIn(600);
        });
        $( ".second-signup" ).click(function(event) {
            event.preventDefault();
            $( "#second-step").hide();
            $( "#third-step").fadeIn(600);
        });
        $( ".back-button" ).click(function(event) {
            event.preventDefault();
            $( "#third-step").hide();
            $( "#second-step").fadeIn(600);
        });
        $( ".back-button-2" ).click(function(event) {
            event.preventDefault();
            $( "#second-step").hide();
            $( "#first-step").fadeIn(600);
        });
        <?php foreach ($featuredPlans as $plan) { ?>
            $(".signUpButton-<?php echo $plan['id']; ?>").click(function(event) {
                event.preventDefault();
                <?php foreach ($featuredPlans as $plan2) { ?>
                    $(".final-step-<?php echo $plan2['id'];?>").hide();
                <?php } ?>
                $(".final-step-<?php echo $plan['id'];?>").show();
            });
        <?php } ?>
    });
</script>
<?php echo $footer; ?>
