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
      <div class="buttons"></div>
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
              <td class="left"><?php if ($sort == 'tab2.name') { ?>
                <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                <?php } ?></td>
              <td class="left"><?php echo $column_price; ?></td>
              <td class="left"><?php if ($sort == 'tab1.view_count') { ?>
                <a href="<?php echo $sort_view_count; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_view_count; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_view_count; ?>"><?php echo $column_view_count; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'tab1.update_date') { ?>
                <a href="<?php echo $sort_update_date; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_update_date; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_update_date; ?>"><?php echo $column_update_date; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'tab1.availability') { ?>
                <a href="<?php echo $sort_availability; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_availability; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_availability; ?>"><?php echo $column_availability; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'tab1.status_id') { ?>
                <a href="<?php echo $sort_status_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status_id; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_status_id; ?>"><?php echo $column_status_id; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'tab1.is_payed') { ?>
                <a href="<?php echo $sort_is_payed; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_is_payed; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_is_payed; ?>"><?php echo $column_is_payed; ?></a>
                <?php } ?></td>
              <td class="left"><?php echo $column_expire_date; ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr class="filter">
              <td><input type="text" name="filter_id" value="<?php echo $filter_id; ?>" /></td>
              <td><input type="text" name="filter_name" value="<?php echo $filter_name; ?>" /></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
                <td></td>
                <td></td>
                <td></td>
              <td align="right"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
            </tr>
            <?php if ($products) { ?>
            <?php foreach ($products as $product) { ?>
            <tr>
                <td><?php echo $product['id'];?></td>
                <td><?php echo $product['name'];?></td>
                <td><?php echo $product['price'];?></td>
                <td><?php echo $product['view_count'];?></td>
                <td><?php echo $product['update_date'];?></td>
              <td><?php echo $product['availability'];?></td>
                <td><?php echo $product['status_id'];?></td>
                <td><?php echo $product['is_payed'];?></td>
                <td><?php echo $product['expire_date'];?></td>
                <td>
                  <a href="<?php echo $product['edit_link']?>">[<?php echo 'Edit';?>]</a>
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
	url = 'index.php?route=sale/product&subprofile_id=<?php echo $subprofile_id; ?>&token=<?php echo $token; ?>';
	
	var filter_id = $('input[name=\'filter_id\']').attr('value');
	
	if (filter_id) {
		url += '&filter_id=' + encodeURIComponent(filter_id);
	}
	
	var filter_name = $('input[name=\'filter_name\']').attr('value');
	
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
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