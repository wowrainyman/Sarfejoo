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
                    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="plan_id" value="<?php echo $plan_id;?>" />
                        <input type="hidden" name="subprofile_id" value="<?php echo $subprofile_id;?>" />
                        <input type="hidden" name="period_id" value="<?php echo $period_id;?>" />
                        <h2>
                            پیش فاکتور
                        </h2>
                        <div class="content">
                            <table class="form">
                                <thead>
                                <td>نام پلن</td>
                                <td>مدت دوره(روز)</td>
                                <td>
                                    قیمت(تومان)
                                </td>
                                </thead>
                                <tr>
                                    <td><?php echo $plan['name']; ?></td>
                                    <td><?php echo $period['duration']; ?></td>
                                    <td><?php echo ($monthlyPrice)*(intval($period['duration']/30)); ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="buttons">
                            <div class="right">
                                <input type="submit" value="<?php echo $button_confirm; ?>" class="button"/>
                            </div>
                        </div>
                    </form>
                    <?php echo $content_bottom; ?>
                </div>
            </div>
        </div>

    </div>
</div>

<?php echo $footer; ?>
