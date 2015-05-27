<?php echo $header; ?>
<div class="row" style="margin-top: 40px;">
    <div class="col-md-3" style="padding: 4px;">
        <div class="col-md-12 box-shadow" style="padding: 4px;">
            <div class="row">
                <?php echo $column_left; ?>
            </div>
            <div class="row">
                <?php echo $column_right; ?>
            </div>

        </div>
    </div>
    <div class="col-md-9">
        <div class="col-md-12 box-shadow" style="padding: 4px;">
            <?php if ($warning) { ?>
            <div class="warning"><?php echo $warning; ?></div>
            <?php } ?>
            <?php if ($error_warning) { ?>
            <div class="warning"><?php echo $error_warning; ?></div>
            <?php } ?>
            <?php if ($success) { ?>
            <div class="success"><?php echo $success; ?></div>
            <?php } ?>
            <div id="s-page-content" class="s-row">
                <div id="content" class="s-pc-c-center">
                    <?php echo $content_top; ?>
                    <div class="breadcrumb s-pc-c-c-bread">
                        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                        <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
                        <?php } ?>
                    </div>
                    <form action="" method="post"  enctype="multipart/form-data">
                        <div class="content">
                            <table class="form">
                                <tr>
                                    <td><span class="required">*</span>تصویر تبلیغ(90*728) </td>
                                    <td><input type="file" name="picture_90_728" accept="image/gif, image/jpeg" id="picture_90_728"/></td>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span>تصویر تبلیغ(60*468)</td>
                                    <td><input type="file" name="picture_60_468" accept="image/gif, image/jpeg" id="picture_468_60"/></td>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span>تصویر تبلیغ(240*120)</td>
                                    <td><input type="file" name="picture_240_120" accept="image/gif, image/jpeg" id="picture_120_240"/></td>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span>تصویر تبلیغ(125*125)</td>
                                    <td><input type="file" name="picture_125_125" accept="image/gif, image/jpeg" id="picture_125_125"/></td>
                                </tr>
                            </table>
                            <table class="form">
                                <tr>
                                    <td><input type="radio" name="pages" value="all">نمایش در کلیه صفحات</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="pages" value="special">نمایش در جایگاه های هدفمند</td>
                                </tr>
                            </table>
                            <div style="display:none;" class="all-pages-plans">
                                <table class="form">
                                    <tr>
                                        <td><input type="radio" name="all-pages-type" value="click" />پلن های بر اساس کلیک</td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" name="all-pages-type" value="view" />پلن های بر اساس تعداد بازدید</td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" name="all-pages-type" value="time" />پلن های بر اساس مدت زمان نمایش</td>
                                    </tr>
                                </table>
                            </div>
                            <div style="display:none;" class="all-pages-byclick-plans">
                                <table class="form">
                                    <?php foreach ($click_plans as $click_plan) { ?>
                                    <tr>
                                        <td>
                                            <input type="radio" class="final-level-all" data-price="<?php echo $click_plan['price']; ?>" name="all-pages-click-plan" value="<?php echo $click_plan['id']; ?>" />
                                            <?php echo $click_plan['name']; ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </table>
                            </div>
                            <div style="display:none;" class="all-pages-byview-plans">
                                <table class="form">
                                    <?php foreach ($view_plans as $view_plan) { ?>
                                    <tr>
                                        <td>
                                            <input type="radio" class="final-level-all" data-price="<?php echo $view_plan['price']; ?>" name="all-pages-view-plan" value="<?php echo $view_plan['id']; ?>" />
                                            <?php echo $view_plan['name']; ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </table>
                            </div>
                            <div style="display:none;" class="all-pages-bytime-plans">
                                <table class="form">
                                    <?php foreach ($time_plans as $time_plan) { ?>
                                    <tr>
                                        <td>
                                            <input type="radio" class="final-level-all" data-price="<?php echo $time_plan['price']; ?>" name="all-pages-time-plan" value="<?php echo $time_plan['id']; ?>" />
                                            <?php echo $time_plan['name']; ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </table>
                            </div>


                            <div style="display:none;" class="special-pages-positions">
                                <table class="form">
                                    <?php foreach ($positions as $position) { ?>
                                    <tr>
                                        <td>
                                            <input type="radio" class="final-level-all" data-pid="<?php echo $position['id']; ?>" data-available="<?php echo $position_dates[$position['id']]; ?>" data-factor="<?php echo $position['factor']; ?>" name="special-page-position" value="<?php echo $position['id']; ?>" />
                                            <?php echo $position['name']; ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </table>
                            </div>


                            <div style="display:none;" class="special-pages-plans">
                                <table class="form">
                                    <tr>
                                        <td><input type="radio" name="special-pages-type" value="click" />پلن های بر اساس کلیک</td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" name="special-pages-type" value="view" />پلن های بر اساس تعداد بازدید</td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" name="special-pages-type" value="time" />پلن های بر اساس مدت زمان نمایش</td>
                                    </tr>
                                </table>
                            </div>
                            <?php foreach ($positions as $position) { ?>
                            <div style="display:none;" class="special-pages-byclick-plans<?php echo $position['id']; ?>">
                                <table class="form">
                                    <?php if (isset($position_plans[$position['id']]['byclick_plans'])) { ?>
                                    <?php foreach ($position_plans[$position['id']]['byclick_plans'] as $click_plan) { ?>
                                    <?php if ($click_plan['id']!='') { ?>
                                    <tr>
                                        <td>
                                            <input type="radio" class="final-level-special" data-price="<?php echo $click_plan['price']; ?>" name="special-pages-click-plan" value="<?php echo $click_plan['id']; ?>" />
                                            <?php echo $click_plan['name']; ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <?php } ?>
                                    <?php } ?>
                                </table>
                            </div>
                            <div style="display:none;" class="special-pages-byview-plans<?php echo $position['id']; ?>">
                                <table class="form">
                                    <?php if (isset($position_plans[$position['id']]['byview_plans'])) { ?>
                                    <?php foreach ($position_plans[$position['id']]['byview_plans'] as $view_plan) { ?>
                                    <?php if ($view_plan['id']!='') { ?>
                                    <tr>
                                        <td>
                                            <input type="radio" class="final-level-special" data-price="<?php echo $view_plan['price']; ?>" name="special-pages-view-plan" value="<?php echo $view_plan['id']; ?>" />
                                            <?php echo $view_plan['name']; ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <?php } ?>
                                    <?php } ?>
                                </table>
                            </div>
                            <div style="display:none;" class="special-pages-bytime-plans<?php echo $position['id']; ?>">
                                <table class="form">
                                    <?php if (isset($position_plans[$position['id']]['bytime_plans'])) { ?>
                                    <?php foreach ($position_plans[$position['id']]['bytime_plans'] as $time_plan) { ?>
                                    <?php if ($time_plan['id']!='') { ?>
                                    <tr>
                                        <td>
                                            <input type="radio" class="final-level-special" data-price="<?php echo $time_plan['price']; ?>" name="special-pages-time-plan" value="<?php echo $time_plan['id']; ?>" />
                                            <?php echo $time_plan['name']; ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <?php } ?>
                                    <?php } ?>
                                </table>
                            </div>
                            <?php } ?>
                            <div class="price">
                                <table class="form">
                                    <tr>
                                        <td>
                                            <span>قیمت</span>
                                        </td>
                                        <td>
                                            <span id="price"></span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="price">
                                <table class="form">
                                    <tr>
                                        <td>
                                            <span></span>
                                        </td>
                                        <td>
                                            <span id="info"></span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="buttons">
                            <div class="left"><a href="<?php echo $back; ?>" class="button"><?php echo $button_back; ?></a></div>
                            <div class="right">
                                <input type="submit" value="<?php echo $button_continue; ?>" class="button"/>
                            </div>
                        </div>
                    </form>
                    <?php echo $content_bottom; ?>
                </div></div>
            <script type="text/javascript">
                $(document).ready(function(){
                    $('input:radio[name="pages"]').change(
                            function(){
                                $('#info').text("");
                                $('#price').text('');
                                $(".all-pages-plans").css("display","none");
                                $(".special-pages-positions").css("display","none");

                                $(".all-pages-byclick-plans").css("display","none");
                                $(".all-pages-byview-plans").css("display","none");
                                $(".all-pages-bytime-plans").css("display","none");

                                $(".special-pages-plans").css("display","none");

                                $(".special-pages-byclick-plans").css("display","none");
                                $(".special-pages-byview-plans").css("display","none");
                                $(".special-pages-bytime-plans").css("display","none");

                                if ($(this).is(':checked') && $(this).val() == 'all') {
                                    $(".all-pages-plans").css("display","block");
                                    $('input:radio[name="all-pages-type"]').prop('checked', false);

                                }else if ($(this).is(':checked') && $(this).val() == 'special') {
                                    $('input:radio[name="special-page-position"]').prop('checked', false);
                                    $('input:radio[name="special-pages-type"]').prop('checked', false);
                                    $(".special-pages-positions").css("display","block");

                                }
                            });
                    $('input:radio[name="all-pages-type"]').change(
                            function(){
                                $('#info').text("");
                                $('#price').text('');
                                $('input:radio[name="all-pages-click-plan"]').prop('checked', false);
                                $('input:radio[name="all-pages-view-plan"]').prop('checked', false);
                                $('input:radio[name="all-pages-time-plan"]').prop('checked', false);
                                $(".all-pages-byclick-plans").css("display","none");
                                $(".all-pages-byview-plans").css("display","none");
                                $(".all-pages-bytime-plans").css("display","none");
                                if ($(this).is(':checked') && $(this).val() == 'click') {
                                    $(".all-pages-byclick-plans").css("display","block");
                                }else if ($(this).is(':checked') && $(this).val() == 'view') {
                                    $(".all-pages-byview-plans").css("display","block");
                                }else if ($(this).is(':checked') && $(this).val() == 'time') {
                                    $(".all-pages-bytime-plans").css("display","block");
                                }
                            });
                    $('input:radio[name="special-page-position"]').change(
                            function(){
                                $('#info').text("");
                                $('#price').text('');
                                if ($(this).is(':checked')) {
                                    $(".special-pages-plans").css("display","block");
                                    $('input:radio[name="special-pages-type"]').prop('checked', false);
                                }
                            });

                    $('input:radio[name="special-pages-type"]').change(
                            function(){
                                $('#info').text("");
                                $('#price').text('');
                                $('input:radio[name="special-pages-click-plan"]').prop('checked', false);
                                $('input:radio[name="special-pages-view-plan"]').prop('checked', false);
                                $('input:radio[name="special-pages-time-plan"]').prop('checked', false);
                                var pid = $('input:radio[name="special-page-position"]:checked').data("pid");

                                $(".special-pages-byclick-plans").css("display","none");
                                $(".special-pages-byview-plans").css("display","none");
                                $(".special-pages-bytime-plans").css("display","none");

                                $('[class^="special-pages-byclick-plans"]').css("display","none");
                                $('[class^="special-pages-byview-plans"]').css("display","none");
                                $('[class^="special-pages-bytime-plans"]').css("display","none");

                                if ($(this).is(':checked') && $(this).val() == 'click') {
                                    $(".special-pages-byclick-plans"+pid).css("display","block");
                                }else if ($(this).is(':checked') && $(this).val() == 'view') {
                                    $(".special-pages-byview-plans"+pid).css("display","block");
                                }else if ($(this).is(':checked') && $(this).val() == 'time') {
                                    $(".special-pages-bytime-plans"+pid).css("display","block");
                                }
                            });


                    $('.final-level-all').change(
                            function(){
                                $('#price').text($(this).data('price'));
                            });

                    $('.final-level-special').change(
                            function(){
                                var price = $(this).data('price') * $('input:radio[name="special-page-position"]:checked').data('factor');
                                if($('input:radio[name="special-pages-type"]:checked').val() == "time"){
                                    $('#price').text(price);
                                    $('#info').text( "موجود است از : " + $('input:radio[name="special-page-position"]:checked').data('available'));
                                }else{
                                    $('#price').text(price);
                                    $('#info').text("");

                                }
                            });


                    $('input:radio[name="special-pages-type"]').change(
                            function(){
                                $('#price').text('');
                                $(".special-pages-byclick-plans").css("display","none");
                                $(".special-pages-byview-plans").css("display","none");
                                $(".special-pages-bytime-plans").css("display","none");
                                if ($(this).is(':checked') && $(this).val() == 'click') {
                                    $(".special-pages-byclick-plans").css("display","block");
                                }else if ($(this).is(':checked') && $(this).val() == 'view') {
                                    $(".special-pages-byview-plans").css("display","block");
                                }else if ($(this).is(':checked') && $(this).val() == 'time') {
                                    $(".special-pages-bytime-plans").css("display","block");
                                }
                            });

                });

            </script>
        </div>

    </div>
</div>

<?php echo $footer; ?>
