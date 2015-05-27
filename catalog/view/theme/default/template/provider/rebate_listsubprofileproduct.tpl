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
                <?php if (isset($productinfos)) { ?>
                    <thead>
                        <td><?php echo $entry_name; ?></td>
                        <td><?php echo $entry_yourprice; ?></td>
                        <td><?php echo $entry_averageprice; ?></td>
                        <td><?php echo $entry_minimumprice; ?></td>
                        <td><?php echo $entry_maximumprice; ?></td>
                        <td></td>
                    </thead>
                    <?php foreach ($productinfos as $productinfo) { ?>
                        <tr>
                            <td><?php echo $productinfo['name']; ?></td>
                            <td><?php echo $productinfo['yourprice']; ?></td>
                            <td><?php echo $productinfo['averageprice']; ?></td>
                            <td><?php echo $productinfo['minimumprice']; ?></td>
                            <td><?php echo $productinfo['maximumprice']; ?></td>
                            <td><a href="<?php echo $add; ?>&productid=<?php echo $productinfo['product_id'] ?>&subprofileid=<?php echo $subprofileid ?>"
                                class="button"><?php echo $entry_add_rebate; ?></a></td>
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