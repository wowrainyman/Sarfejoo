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
                        <h2><?php echo $text_profile; ?> </h2>
                        <div class="content">
                            <table class="form">
                                <?php if (isset($customer_infos)) { ?>
                                <thead>
                                <td><?php echo $entry_title; ?></td>
                                <td><?php echo $entry_city; ?></td>
                                <!--
                                <td><?php echo $entry_address; ?></td>
                                <td><?php echo $entry_tel; ?></td>
                                <td><?php echo $entry_mobile; ?></td>
                                -->
                                <!--<td><?php echo $entry_status; ?></td>-->
                                <td></td>
                                <td>
                                    <?php echo $entry_expire_date; ?>
                                </td>
                                <td></td>
                                <td></td>
                                </thead>
                                <?php foreach ($customer_infos as $customer_info) { ?>
                                <tr>
                                    <td><?php echo $customer_info['title']; ?></td>
                                    <td><?php echo $customer_info['city']; ?></td>
                                    <!--
                                     <td><?php echo $customer_info['address']; ?></td>
                                     <td><?php echo $customer_info['tel']; ?></td>
                                     <td><?php echo $customer_info['mobile']; ?></td>
                                                             -->
                                    <!--<td><?php echo $statusArr[$customer_info['id']]['name']; ?></td>-->
                                    <?php if ($customer_info['legalperson_id']) { ?>
                                    <td><?php echo $entry_naturalperson; ?></td>
                                    <?php } else { ?>
                                    <td><?php echo $entry_legalperson; ?></td>
                                    <?php }?>
                                    <td>
                                        <?php echo $expire_date[$customer_info['id']]; ?>
                                    </td>
                                    <?php $id=$customer_info['id']; ?>
                                    <td>
                                        <a href="<?php echo $add_credit; ?>&<?php echo "id=$id" ?>" class="button left"><?php echo $entry_add_credit; ?></a>
                                    </td>
                                    <td>
                                        <a href="<?php echo $edit; ?>&<?php echo "id=$id" ?>" class="button left"><?php echo $entry_edit; ?></a>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php } ?>
                            </table>
                        </div>
                        <div class="buttons">
                            <div class="left"><a href="<?php echo $back; ?>" class="button"><?php echo $button_back; ?></a></div>
                            <div class="right">
                                <a href="<?php echo $add; ?>" class="button"><?php echo $button_add; ?></a>
                            </div>
                        </div>
                    </form>
                    <?php echo $content_bottom; ?>
                </div></div>
        </div>

    </div>
</div>

<?php echo $footer; ?>
