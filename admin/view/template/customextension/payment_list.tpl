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
      <h1><img src="view/image/product.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $form_action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
              <td class="left"><?php if ($sort == 'tab1.subject') { ?>
                <a href="<?php echo $sort_subject; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_subject; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_subject; ?>"><?php echo $column_subject; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'tab1.is_on') { ?>
                <a href="<?php echo $sort_is_on; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_is_on; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_is_on; ?>"><?php echo $column_is_on; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'tab1.cost') { ?>
                <a href="<?php echo $sort_cost; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_cost; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_cost; ?>"><?php echo $column_cost; ?></a>
                <?php } ?></td>
              <td class="right"></td>
            </tr>
          </thead>
          <tbody>
            <tr class="filter">
              <td><input type="text" name="filter_subject" value="<?php echo $filter_subject; ?>" /></td>
                <td></td>
                <td></td>
              <td align="right"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
            </tr>
            <?php if (isset($payments)) { ?>
                <?php foreach ($payments as $payment) { ?>
                    <tr>
                      <td class="left"><input type="text" name="subject[<?php echo $payment['id']; ?>]" value="<?php echo $payment['subject']; ?>" /></td>
                        <td class="left"><input type="text" name="ison[<?php echo $payment['id']; ?>]" value="<?php echo $payment['is_on']; ?>" /></td>
                      <td class="left"><input type="text" name="cost[<?php echo $payment['id']; ?>]" value="<?php echo $payment['cost']; ?>" /></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                  <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
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
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=customextension/payment&token=<?php echo $token; ?>';
	
	var filter_subject = $('input[name=\'filter_subject\']').attr('value');
	
	if (filter_subject) {
		url += '&filter_subject=' + encodeURIComponent(filter_subject);
	}
	location = url;
}
//--></script>
<?php echo $footer; ?>