<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<div id="s-page-content" class="s-row">
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content" class="s-pc-c-center">
<?php echo $content_top; ?>
  <div class="breadcrumb s-pc-c-c-bread">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="type" value="<?php echo $type; ?>" />
        <input type="hidden" name="related_id" value="<?php echo $related_id; ?>" />
        <h2><?php echo $text_profile; ?> </h2>
        <div class="content">
            <table class="form">
                <?php if (isset($priodic_plans)) { ?>
                    <thead>
                        <td>            پلن های دوره ای</td>
                        <td>نام پلن</td>
                        <td>مدت دوره(روز)</td>
                        <td>قیمت</td>
                    </thead>
                    <?php foreach ($priodic_plans as $priodic_plan) { ?>
                        <tr>
                            <td><input type="radio" name="plan" value="priodic-<?php echo $priodic_plan['id']; ?>"></td>
                            <td><?php echo $priodic_plan['name']; ?></td>
                            <td><?php echo $priodic_plan['duration']; ?></td>
                            <td><?php echo $priodic_plan['price']; ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </table>
            <table class="form">
                <?php if (isset($once_plans)) { ?>
                    <thead>
                        <td>پلن های دائم</td>
                        <td>نام پلن</td>
                        <td></td>
                        <td>قیمت</td>
                    </thead>
                    <?php foreach ($once_plans as $once_plan) { ?>
                        <tr>
                            <td><input type="radio" name="plan" value="once-<?php echo $once_plan['id']; ?>"></td>
                            <td><?php echo $once_plan['name']; ?></td>
                            <td></td>
                            <td><?php echo $once_plan['price']; ?></td>
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
<?php echo $footer; ?>