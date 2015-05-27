<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <div class="box">
        <div class="heading">
            <h1><img src="view/image/order.png" alt="" /> <?php echo $heading_title; ?></h1>
            <div class="buttons"><a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a></div>
        </div>
        <div class="content">
            <form action="<?php echo $form_action; ?>" method="post" enctype="multipart/form-data" id="form">
                <table class="list">
                    <thead>
                    <tr>
                        <td class="left"><?php if ($sort == 'tab1.id') { ?>
                            <a href="<?php echo $sort_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_id; ?></a>
                            <?php } else { ?>
                            <a href="<?php echo $sort_id; ?>"><?php echo $column_id; ?></a>
                            <?php } ?></td>
                        <td class="left"><?php if ($sort == 'tab1.name') { ?>
                            <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                            <?php } else { ?>
                            <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                            <?php } ?></td>
                        <td class="left"><?php if ($sort == 'tab1.parent_id') { ?>
                            <a href="<?php echo $sort_parent_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_parent_id; ?></a>
                            <?php } else { ?>
                            <a href="<?php echo $sort_parent_id; ?>"><?php echo $column_parent_id; ?></a>
                            <?php } ?></td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($newsletter_plans) && $newsletter_plans) { ?>
                    <?php foreach ($newsletter_plans as $newsletter_plan) { ?>
                    <tr>
                        <td class="left"><?php echo $newsletter_plan['id']; ?></td>
                        <td class="left"><input type="text" name="name[<?php echo $newsletter_plan['id']; ?>]" value="<?php echo $newsletter_plan['name']; ?>" /></td>
                        <td><select name="parent_id[<?php echo $newsletter_plan['id']; ?>]">
                                <option value="0" selected>ندارد</option>
                        <?php foreach ($allPlans as $allPlan) { ?>
                                <?php if ($allPlan['id'] == $newsletter_plan['parent_id']) { ?>
                                    <option value="<?php echo $allPlan['id']; ?>" selected><?php echo $allPlan['name']; ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $allPlan['id']; ?>"><?php echo $allPlan['name']; ?></option>
                                <?php } ?>
                        <?php } ?>
                        </select> </td>
                        <td>
                            <?php if ($newsletter_plan['parent_id'] == 0) { ?>
                                [<a href="<?php echo $newsletter_plan['mail_link'];?>">ویرایش ایمیل</a>]
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php } else { ?>
                    <tr>
                        <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="right"><input type="submit" class="button" value="<?php echo $text_edit; ?>" /></td>
                    </tr>
                    </tbody>
                </table>
            </form>
            <div class="pagination"><?php echo $pagination; ?></div>
        </div>
    </div>
</div>
<?php echo $footer; ?>