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

                        <div class="content">
                            <table class="form">
                                <?php if (isset($user_ads)) { ?>
                                <thead>
                                <td><?php echo $entry_plan_type; ?></td>
                                <td><?php echo $entry_plan_name; ?></td>
                                <td><?php echo $entry_file; ?></td>
                                <td><?php echo $entry_dest_click; ?></td>
                                <td><?php echo $entry_current_click; ?></td>
                                <td><?php echo $entry_dest_view; ?></td>
                                <td><?php echo $entry_current_view; ?></td>
                                <td><?php echo $entry_start_date; ?></td>
                                <td><?php echo $entry_end_date; ?></td>
                                <td><?php echo $entry_status_id; ?></td>
                                <td><?php echo $entry_position_name; ?></td>
                                </thead>
                                <?php foreach ($user_ads as $user_ad) { ?>
                                <tr>
                                    <td><?php echo $user_ad['plan_type']; ?></td>
                                    <td><?php echo $user_ad['plan_name']; ?></td>
                                    <td>
                                        <img width="144" height="18"  data-magnify-src="<?php echo 'ProvidersScans/' . $user_ad['customer_id'] . '/advertising/ad_' . $user_ad['file_90_728']; ?>" src="<?php echo 'ProvidersScans/' . $user_ad['customer_id'] . '/advertising/ad_' . $user_ad['file_90_728']; ?>" alt="" />
                                        <br />
                                        <img width="92" height="12"  data-magnify-src="<?php echo 'ProvidersScans/' . $user_ad['customer_id'] . '/advertising/ad_' . $user_ad['file_60_468']; ?>" src="<?php echo 'ProvidersScans/' . $user_ad['customer_id'] . '/advertising/ad_' . $user_ad['file_60_468']; ?>" alt="" />
                                        <br />
                                        <img width="24" height="48"  data-magnify-src="<?php echo 'ProvidersScans/' . $user_ad['customer_id'] . '/advertising/ad_' . $user_ad['file_240_120']; ?>" src="<?php echo 'ProvidersScans/' . $user_ad['customer_id'] . '/advertising/ad_' . $user_ad['file_240_120']; ?>" alt="" />
                                        <img width="24" height="24"  data-magnify-src="<?php echo 'ProvidersScans/' . $user_ad['customer_id'] . '/advertising/ad_' . $user_ad['file_125_125']; ?>" src="<?php echo 'ProvidersScans/' . $user_ad['customer_id'] . '/advertising/ad_' . $user_ad['file_125_125']; ?>" alt="" />
                                    </td>
                                    <td><?php echo $user_ad['dest_click']; ?></td>
                                    <td><?php echo $user_ad['current_click']; ?></td>
                                    <td><?php echo $user_ad['dest_view']; ?></td>
                                    <td><?php echo $user_ad['current_view']; ?></td>
                                    <td><?php echo $user_ad['start_date']; ?></td>
                                    <td><?php echo $user_ad['end_date']; ?></td>
                                    <td><?php echo $user_ad['status_id']; ?></td>
                                    <td><?php echo $user_ad['position_name']; ?></td>
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
            <script type="text/javascript">
                $(document).ready(function() {
                    $('img').magnify();
                });
            </script>
        </div>

    </div>
</div>

<?php echo $footer; ?>