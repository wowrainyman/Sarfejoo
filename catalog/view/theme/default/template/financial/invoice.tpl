<?php echo $header; ?>
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
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content" class="s-pc-c-center">
<?php echo $content_top; ?>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="type" value="<?php echo $type; ?>" />
        <input type="hidden" name="related_id" value="<?php echo $related_id; ?>" />
        <h2><?php echo $text_profile;$r=1;$total_price=0; ?> </h2>
        <div class="content">
            <table class="form">
                <?php if (isset($invoice_infos)) { ?>
                    <thead>
                        <td>ردیف</td>
                        <td>نام طرح</td>
                        <td>نوع</td>
                        <td>مربوط به</td>
                        <td>مدت دوره</td>
                        <td>قیمت</td>
                        <td>حدف</td>
                    </thead>
                    <?php foreach ($invoice_infos as $invoice_info) { ?>
                        <tr>
                            <td><?php echo $r++; ?></td>
                            <?php if(isset($invoice_info['subprofile'])) { ?>
                                <td><?php echo $invoice_info['plan']['name']; ?></td>
                                <td>زیر پروفایل</td>
                                <td><?php echo $invoice_info['subprofile']['title']; ?></td>
                                <?php if(isset($invoice_info['plan']['duration'])) { ?>
                                    <td><?php echo $invoice_info['plan']['duration']; ?></td>
                                <?php }else{ ?>
                                    <td>دائم</td>
                                <?php } ?>
                                <td><?php echo $invoice_info['plan']['price'];$total_price+=$invoice_info['plan']['price']; ?></td>
                            <?php }else if(isset($invoice_info['product'])){ ?>
                                <td><?php echo $invoice_info['plan']['name']; ?></td>
                                <td>کالا</td>
                                <td><?php echo $invoice_info['product']['name']; ?></td>
                                <?php if(isset($invoice_info['plan']['duration'])) { ?>
                                    <td><?php echo $invoice_info['plan']['duration']; ?></td>
                                <?php }else{ ?>
                                    <td>دائم</td>
                                <?php } ?>
                                <td><?php echo $invoice_info['plan']['price'];$total_price+=$invoice_info['plan']['price']; ?></td>
                            <?php } ?>
                            <td><a href="<?php echo $deleteUrl;?>&id=<?php echo $invoice_info['invoice']['id'];?>"><img class="h-remove" src="image/style/remove-hi.png" alt="حذف"  /></a></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>جمع کل</td>
                        <td colspan="2"><?php echo $total_price;?></td>
                    </tr>
                <?php } ?>
            </table>
                              <span>
                      اعتبارشما:
                  </span>
                  <span id="menu-balance-value">
                      <?php echo number_format($balance_value); ?>
                  </span>
                  <span>
                      تومان
                  </span>
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