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
                <td class="left"><?php if ($sort == 'tab1.id') { ?>
                    <a href="<?php echo $sort_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_id; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_id; ?>"><?php echo $column_id; ?></a>
                    <?php } ?></td>
                <td class="left"><?php if ($sort == 'tab2.lastname') { ?>
                <a href="<?php echo $sort_lastname; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_lastname; ?>"><?php echo $column_name; ?></a>
                <?php } ?></td>
                <td class="left"><?php if ($sort == 'tab1.plan_type') { ?>
                    <a href="<?php echo $sort_plan_type; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_plan_type; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_plan_type; ?>"><?php echo $column_plan_type; ?></a>
                    <?php } ?></td>
                <td class="left"><?php if ($sort == 'tab1.dest_click') { ?>
                    <a href="<?php echo $sort_dest_click; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_dest_click; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_dest_click; ?>"><?php echo $column_dest_click; ?></a>
                    <?php } ?></td>
                <td class="left"><?php if ($sort == 'tab1.current_click') { ?>
                    <a href="<?php echo $sort_current_click; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_current_click; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_current_click; ?>"><?php echo $column_current_click; ?></a>
                    <?php } ?></td>
                <td class="left"><?php if ($sort == 'tab1.dest_view') { ?>
                    <a href="<?php echo $sort_dest_view; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_dest_view; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_dest_view; ?>"><?php echo $column_dest_view; ?></a>
                    <?php } ?></td>
                <td class="left"><?php if ($sort == 'tab1.current_view') { ?>
                    <a href="<?php echo $sort_current_view; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_current_view; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_current_view; ?>"><?php echo $column_current_view; ?></a>
                    <?php } ?></td>
                <td class="left"><?php if ($sort == 'tab1.start_date') { ?>
                    <a href="<?php echo $sort_start_date; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_start_date; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_start_date; ?>"><?php echo $column_start_date; ?></a>
                    <?php } ?></td>
                <td class="left"><?php if ($sort == 'tab1.end_date') { ?>
                    <a href="<?php echo $sort_end_date; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_end_date; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_end_date; ?>"><?php echo $column_end_date; ?></a>
                    <?php } ?></td>
                <td class="left"><?php if ($sort == 'tab1.transaction_id') { ?>
                    <a href="<?php echo $sort_transaction_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_transaction_id; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_transaction_id; ?>"><?php echo $column_transaction_id; ?></a>
                    <?php } ?></td>
                <td class="left"><?php if ($sort == 'tab1.status_id') { ?>
                    <a href="<?php echo $sort_status_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status_id; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_status_id; ?>"><?php echo $column_status_id; ?></a>
                    <?php } ?></td>
                <td class="left"><?php if ($sort == 'tab1.periority') { ?>
                    <a href="<?php echo $sort_periority; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_periority; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_periority; ?>"><?php echo $column_periority; ?></a>
                    <?php } ?></td>
                <td class="left"><?php if ($sort == 'tab1.position_id') { ?>
                    <a href="<?php echo $sort_position_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_position_id; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_position_id; ?>"><?php echo $column_position_id; ?></a>
                    <?php } ?></td>
                <td></td>
            </tr>
          </thead>
          <tbody>
            <tr class="filter">
                <td></td>
                <td><input type="text" name="filter_customer_name" value="<?php echo $filter_customer_name; ?>" /></td>
                <td><input type="text" name="filter_plan_type" value="<?php echo $filter_plan_type; ?>" /></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><input type="text" name="filter_position_id" value="<?php echo $filter_position_id; ?>" /></td>
              <td align="right"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
            </tr>
            <?php if (isset($plan_customers)) { ?>
                <?php foreach ($plan_customers as $plan_customer) { ?>
                    <tr>
                        <td class="left"><?php echo $plan_customer['id']; ?></td>
                        <td class="left"><?php echo $plan_customer['name']; ?></td>
                        <td class="left"><?php echo $plan_customer['plan_type']; ?></td>
                        <td class="left"><?php echo $plan_customer['dest_click']; ?></td>
                        <td class="left"><?php echo $plan_customer['current_click']; ?></td>
                        <td class="left"><?php echo $plan_customer['dest_view']; ?></td>
                        <td class="left"><?php echo $plan_customer['current_view']; ?></td>
                        <td class="left"><?php echo $plan_customer['start_date']; ?></td>
                        <td class="left"><?php echo $plan_customer['end_date']; ?></td>
                        <td class="left"><?php echo $plan_customer['transaction_id']; ?></td>
                        <td class="left"><input type="text" maxlength="2" size="2" name="status_id[<?php echo $plan_customer['id']; ?>]" value="<?php echo $plan_customer['status_id']; ?>" /></td>
                        <td class="left"><input type="text" maxlength="10" size="10" name="periority[<?php echo $plan_customer['id']; ?>]" value="<?php echo $plan_customer['periority']; ?>" /></td>
                        <td class="left"><?php echo $plan_customer['position_id']; ?></td>
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
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
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
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=ad/plan_byclick&token=<?php echo $token; ?>';
	
	var filter_name = $('input[name=\'filter_name\']').attr('value');
	
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
	location = url;
}
//--></script>
<?php echo $footer; ?>