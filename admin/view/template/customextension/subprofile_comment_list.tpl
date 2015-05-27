<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="success"><?php echo $success; ?></div>
    <?php } ?>
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
                        <td class="left"><?php echo $column_id; ?></td>
                        <td class="left"><?php echo $column_customer; ?></td>
                        <td class="left"><?php echo $column_subprofile; ?></td>
                        <td class="left"><?php echo $column_comment; ?></td>
                        <td class="left"><?php echo $column_approved; ?></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($comments) { ?>
                        <?php foreach ($comments as $comment) { ?>
                        <tr>
                            <td class="left"><?php echo $comment['id']; ?></td>
                            <td class="left"><?php echo $comment['customer_name']; ?></td>
                            <td class="left"><?php echo $comment['subprofile_name']; ?></td>
                            <td class="left"><?php echo $comment['comment']; ?></td>
                            <td class="left"><input type="text" name="approved[<?php echo $comment['id']; ?>]" value="<?php echo $comment['approved']; ?>" /></td>
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