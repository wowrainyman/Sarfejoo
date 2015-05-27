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
        <h2><?php echo $text_profile; ?></h2>
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
                        <td><?php echo $entry_status; ?></td>
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
                            <td><?php echo $statusArr[$customer_info['id']]['name']; ?></td>
                            <?php if ($customer_info['legalperson_id']) { ?>
                                <td><?php echo $entry_naturalperson; ?></td>
                            <?php } else { ?>
                                <td><?php echo $entry_legalperson; ?></td>
                            <?php }?>
                            <?php $id=$customer_info['id']; ?>
                            <td>
                                <a href="<?php echo $edit; ?>&<?php echo "id=$id" ?>" class="button left"><?php echo $entry_view; ?></a>
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
<?php echo $footer; ?>