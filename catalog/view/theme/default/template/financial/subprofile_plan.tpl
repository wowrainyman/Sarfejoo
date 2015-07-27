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

                        <!-- Table Content -->
                        <?php foreach ($plan_structures as $plan_structure) { ?>
                        <tr>
                            <?php foreach ($plan_structure as $pstr) { ?>
                                <td class="<?php if($pstr['is_recommended']) echo 'recommended' ?>">
                                    <?php echo $pstr['title']; ?>
                                    <br/>
                                    <strong>
                                        <?php echo $pstr['value']; ?>
                                    </strong>
                                </td>
                            <?php } ?>
                        </tr>
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

                        <!-- Table Content -->
                        <?php foreach ($plan_price_structures as $plan_price_structure) { ?>
                        <tr>
                            <?php foreach ($plan_price_structure as $pstr) { ?>
                            <td class="<?php if($pstr['is_recommended']) echo 'recommended' ?>">
                                <?php echo $pstr['name']; ?>
                                <br/>
                                <h4>
                                    <strong>
                                        <?php echo intval($pstr['value']/1000); ?>
                                        <sup><?php echo str_pad($pstr['value']%1000, 3, '0', STR_PAD_LEFT);?></sup>
                                    </strong>
                                </h4>
                                درماه
                            </td>
                            <?php } ?>
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
            <?php $count=0;foreach ($featuredPlans as $plan) { ?>
            <div class="final-step-<?php echo $plan['id'];?>" style="display: none;">
                <form action="<?php echo $action;?>" method="get">
                    <input type="hidden" name="route" value="financial/subprofile_plan/confirm" />
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
                            <?php foreach ($periods as $period) { ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="radio" name="period_id" value="<?php echo $period['id']; ?>">
                                        <?php echo $period['name']; ?>
                                    </div>
                                    <div class="col-md-6">
                                        <label id="price-<?php echo $count . '-' . $period['id']; ?>"></label>
                                        <script type="text/javascript">
                                            $("#price-<?php echo $count . '-' . $period['id']; ?>").html(prices[<?php echo $count;?>][<?php echo $period['id'];?>]);
                                        </script>
                                        تومان
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin: 10px;">
                        <div class="col-md-4" style="margin: 10px;">
                            <input type="submit" value="<?php echo $button_continue; ?>" class="button"/>
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
