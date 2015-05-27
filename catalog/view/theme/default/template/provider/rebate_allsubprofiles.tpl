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
                        <?php echo $breadcrumb['separator']; ?><a
                                href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
                        <?php } ?>
                    </div>
                    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                        <h2><?php echo $text_profile; ?></h2>

                        <div class="content">
                            <table class="form">
                                <?php if (isset($customer_infos)) { ?>
                                <thead>
                                <td><?php echo $entry_title; ?></td>
                                <td></td>
                                </thead>
                                <?php foreach ($customer_infos as $customer_info) { ?>
                                <tr>
                                    <td><?php echo $customer_info['title']; ?></td>
                                    <?php $id=$customer_info['id']; ?>
                                    <td><br />
                                        <a href="<?php echo $add; ?>&<?php echo " id=$id" ?>"
                                            class="button left"><?php echo $entry_add_rebate_product; ?></a><br /><br />
                                        <a href="<?php echo $add2; ?>&<?php echo "subprofileid=$id" ?>&productid=0"
                                            class="button left"><?php echo $entry_add_rebate; ?></a><br /><br />
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php } ?>
                            </table>
                        </div>
                    </form>
                    <?php echo $content_bottom; ?>
                </div>
            </div>
        </div>

    </div>
</div>

<?php echo $footer; ?>
