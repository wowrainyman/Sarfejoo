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
      <h1><img src="view/image/customer.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('form').attr('action', '<?php echo $approve; ?>'); $('form').submit();" class="button"><?php echo $button_approve; ?></a><a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a><a onclick="$('form').attr('action', '<?php echo $delete; ?>'); $('form').submit();" class="button"><?php echo $button_delete; ?></a></div>
    </div>
    <div class="content">
      <form action="" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
              <td class="left"><?php if ($sort == 'tab1.id') { ?>
                <a href="<?php echo $sort_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_id; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_id; ?>"><?php echo $column_id; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'tab1.title') { ?>
                <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'tab2.firstname') { ?>
                <a href="<?php echo $sort_customer_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer_name; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_customer_name; ?>"><?php echo $column_customer_name; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'customer_group') { ?>
                <a href="<?php echo $sort_group; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_group; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_group; ?>"><?php echo $column_group; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'tab1.city') { ?>
                <a href="<?php echo $sort_city; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_city; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_city; ?>"><?php echo $column_city; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'tab1.status_id') { ?>
                <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'tab1.is_payed') { ?>
                <a href="<?php echo $sort_is_payed; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_is_payed; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_is_payed; ?>"><?php echo $column_is_payed; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'tab3.rate') { ?>
                <a href="<?php echo $sort_rate; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_rate; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_rate; ?>"><?php echo $column_rate; ?></a>
                <?php } ?></td>
              <td class="left"><?php echo $column_expire_date; ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr class="filter">
              <td><input type="text" name="filter_id" value="<?php echo $filter_id; ?>" /></td>
              <td><input type="text" name="filter_name" value="<?php echo $filter_name; ?>" /></td>
              <td><input type="text" name="filter_customer_name" value="<?php echo $filter_customer_name; ?>" /></td>
              <td></td>
              <td><input type="text" name="filter_city" value="<?php echo $filter_city; ?>" /></td>
              <td></td>
                <td></td>
                <td><input type="text" name="filter_rate_sarfejoo" value="<?php echo $filter_rate_sarfejoo; ?>" /></td>
                <td></td>
              <td align="right"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
            </tr>
            <?php if ($subprofiles) { ?>
            <?php foreach ($subprofiles as $subprofile) { ?>
            <tr>
                <td><?php echo $subprofile['subprofile_id'];?></td>
                <td><?php echo $subprofile['name'];?></td>
                <td><?php echo $subprofile['username'];?></td>
                <td><?php echo $subprofile['group_id'];?></td>
                <td><?php echo $subprofile['city'];?></td>
                <td><?php echo $subprofile['status_id'];?></td>
                <td><?php echo $subprofile['is_payed'];?></td>
                <td><?php echo $subprofile['rate'];?></td>
                <td><?php echo $subprofile['expire_date'];?></td>
                <td>
                  <a href="<?php echo $subprofile['edit_link']?>">[<?php echo 'Edit';?>]</a>
                  <a href="<?php echo $subprofile['product_link']?>">[<?php echo 'Products';?>]</a>
                </td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="10"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=sale/subprofile&token=<?php echo $token; ?>';
	
	var filter_id = $('input[name=\'filter_id\']').attr('value');
	
	if (filter_id) {
		url += '&filter_id=' + encodeURIComponent(filter_id);
	}
	
	var filter_name = $('input[name=\'filter_name\']').attr('value');
	
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
	
	var filter_customer_name = $('input[name=\'filter_customer_name\']').attr('value');
	
	if (filter_customer_name){
		url += '&filter_customer_name=' + encodeURIComponent(filter_customer_name);
	}	
	
	var filter_city = $('input[name=\'filter_city\']').attr('value');
	
	if (filter_city) {
		url += '&filter_city=' + encodeURIComponent(filter_city);
	}	
	
	var filter_rate_sarfejoo = $('input[name=\'filter_rate_sarfejoo\']').attr('value');
	
	if (filter_rate_sarfejoo) {
		url += '&filter_rate_sarfejoo=' + encodeURIComponent(filter_rate_sarfejoo);
	}
	
	location = url;
}
//--></script>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#date').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>
<?php echo $footer; ?> 