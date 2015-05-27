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
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="content">
                            <table class="form">
                                <thead>
                                <td colspan="2">نام</td>
                                <td>Email</td>
                                <td>Sms</td>
                                </thead>
                                <?php foreach ($plans as $plan) { ?>
                                <tr>
                                    <td colspan="2"><?php echo $plan['name']; ?></td>
                                    <td><input type="checkbox" id="email-<?php echo $plan['id']; ?>" name="email-plan[<?php echo $plan['id']; ?>][main]"/></td>
                                    <td><input type="checkbox" id="sms-<?php echo $plan['id']; ?>" name="sms-plan[<?php echo $plan['id']; ?>][main]"/></td>
                                </tr>
                                <?php foreach ($plan['sub_plans'] as $sub_plan) { ?>
                                <tr>
                                    <td></td>
                                    <td><?php echo $sub_plan['name']; ?></td>
                                    <td><input type="checkbox" id="email-<?php echo $sub_plan['id']; ?>" name="email-plan[<?php echo $plan['id']; ?>][<?php echo 'sub-' . $sub_plan['id']; ?>]"/></td>
                                    <td><input type="checkbox" id="sms-<?php echo $sub_plan['id']; ?>" name="sms-plan[<?php echo $plan['id']; ?>][<?php echo 'sub-' . $sub_plan['id'];?>]"/></td>
                                </tr>
                                <?php } ?>
                                <?php } ?>
                            </table>
                        </div>
                        <div class="buttons">
                            <div class="right">
                                <input type="submit" value="<?php echo $button_continue; ?>" class="button"/>
                            </div>
                        </div>
                    </form>
                    <?php echo $content_bottom; ?>
                </div></div>
            <script type="text/javascript">
                $x=$("input[name^='email-plan']");
                $y=$("input[name^='sms-plan']");
                $(document).ready(function(){
                    $.each($x,function(){
                        $(this).change(function() {
                            if(this.checked) {
                                id=$(this).attr("name").match(/\d+/)[0];
                                if($(this).attr("name") == "email-plan["+id+"][main]"){
                                    selector=$("[name^='email-plan["+id+"]']");
                                    selector.attr('checked', true);
                                    selector.attr("disabled", true);
                                    $("[name='email-plan["+id+"][main]']").removeAttr("disabled");
                                }
                                if($(this).attr("name") == "sms-plan["+id+"][main]"){
                                    selector=$("[name^='sms-plan["+id+"]']");
                                    selector.attr('checked', true);
                                    selector.attr("disabled", true);
                                    $("[name='sms-plan["+id+"][main]']").removeAttr("disabled");
                                }
                            }else{
                                id=$(this).attr("name").match(/\d+/)[0];
                                if($(this).attr("name") == "email-plan["+id+"][main]"){
                                    selector=$("[name^='email-plan["+id+"]']");
                                    selector.attr('checked', false);
                                    selector.removeAttr("disabled");
                                }
                                if($(this).attr("name") == "sms-plan["+id+"][main]"){
                                    selector=$("[name^='sms-plan["+id+"]']");
                                    selector.attr('checked', false);
                                    selector.removeAttr("disabled");
                                }
                            }
                        });
                    });

                    $.each($y,function(){
                        $(this).change(function() {
                            if(this.checked) {
                                id=$(this).attr("name").match(/\d+/)[0];
                                if($(this).attr("name") == "sms-plan["+id+"][main]"){
                                    selector=$("[name^='sms-plan["+id+"]']");
                                    selector.attr('checked', true);
                                    selector.attr("disabled", true);
                                    $("[name='sms-plan["+id+"][main]']").removeAttr("disabled");
                                }
                            }else{
                                id=$(this).attr("name").match(/\d+/)[0];
                                if($(this).attr("name") == "sms-plan["+id+"][main]"){
                                    selector=$("[name^='sms-plan["+id+"]']");
                                    selector.attr('checked', false);
                                    selector.removeAttr("disabled");
                                }
                            }
                        });
                    });

                    <?php foreach ($selected_sms_plans as $selected_sms_plan) { ?>
                        $('#sms-<?php echo $selected_sms_plan; ?>').trigger('click');
                    <?php } ?>

                    <?php foreach ($selected_email_plans as $selected_email_plan) { ?>
                        $('#email-<?php echo $selected_email_plan; ?>').trigger('click');
                    <?php } ?>

                });

            </script>
        </div>

    </div>
</div>

<?php echo $footer; ?>