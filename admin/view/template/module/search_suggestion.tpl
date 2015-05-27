<?php echo $header; ?>
<style>
.disable {
  background-color: #EFEFEF !important;
}
.information {
  color: #FF0000;
  font-weight: bold;
}
</style>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">

      <div id="tabs" class="htabs">
        <a href="#tab-general"><?php echo $tab_general; ?></a>
        <a href="#tab-where"><?php echo $tab_where; ?></a>
        <a href="#tab-fields"><?php echo $tab_fields; ?></a>
        <a href="#tab-support"><?php echo $tab_support; ?></a>
      </div>

      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">

        <div id="tab-general">  
					<div class="commercial"><span class="information">*</span> - <?php echo $text_commercial; ?></div>
					<br />
          <table id="general" class="list">
            <tbody >
              <tr>
                <td width="50"><?php echo $search_order; ?></td>
                <td class="left">
                  <select name="search_suggestion_options[search_order]">
                    <option value="name" <?php echo (isset($options['search_order']) && $options['search_order'] == 'name') ? 'selected="selected"' : "" ;?>><?php echo $search_order_name; ?></option>
                    <option value="rating" <?php echo (isset($options['search_order']) && $options['search_order'] == 'rating') ? 'selected="selected"' : "" ;?>><?php echo $search_order_rating; ?></option>
                    <option value="relevance" <?php echo (isset($options['search_order']) && $options['search_order'] == 'relevance') ? 'selected="selected"' : "" ;?>><?php echo $search_order_relevance; ?></option>
                  </select>
                  <select name="search_suggestion_options[search_order_dir]">
                    <option value="asc" <?php echo (isset($options['search_order_dir']) && $options['search_order_dir'] == 'asc') ? 'selected="selected"' : "" ;?>><?php echo $search_order_dir_asc; ?></option>
                    <option value="desc" <?php echo (isset($options['search_order_dir']) && $options['search_order_dir'] == 'desc') ? 'selected="selected"' : "" ;?>><?php echo $search_order_dir_desc; ?></option>
                  </select>              
                </td>  
              </tr>

              <tr>
                <td class="left"><?php echo $search_limit; ?></td>              
                <td width="50">
                  <input type="text" name="search_suggestion_options[search_limit]" value="<?php echo isset($options['search_limit']) ? $options['search_limit'] : 0;?>">
                </td>
              </tr>

              <tr>
                <td class="left disable"><span class="information">*</span> <?php echo $search_logic; ?></td>             
                <td width="50" class="disable" >
                  <select name="search_suggestion_options[search_logic]">
                    <option disabled="disabled"><?php echo $search_logic_or; ?></option>
                    <option disabled="disabled"><?php echo $search_logic_and; ?></option>
                  </select>              

                </td>
              </tr>

              <tr>
                <td class="left"><?php echo $search_cache; ?></td>              
                <td width="50">
                  <input type="checkbox" name="search_suggestion_options[search_cache]" value="1" <?php echo isset($options['search_cache']) && $options['search_cache'] ? "checked=checked" : "" ;?> />
                </td>
              </tr>

            </tbody>
          </table>

          <table id="module" class="list">
            <thead>
              <tr>
                <td width="1" style="text-align: center;">
                  <input type="checkbox" onclick="$('input[type=checkbox][name*=\'search_suggestion_module\']').attr('checked', this.checked);" />
                </td>
                <td class="left"><?php echo $entry_layout; ?></td>  
              </tr>
            </thead>
            <tbody >
              <?php foreach ($modules as $key => $module) { ?>          
              <?php foreach ($layouts as $layout) { ?>
              <?php if ($module['layout_id'] == $layout['layout_id']) { ?>
              <tr>
                <td style="text-align: center;">
                  <input type="checkbox" name="search_suggestion_module[<?php echo $key; ?>][status]" value="1" <?php echo (isset($module['status']) && $module['status']) ? "checked=checked" : "" ;?> />
                         <input type="hidden" name="search_suggestion_module[<?php echo $key; ?>][layout_id]" value="<?php echo $module['layout_id']; ?>"/>
                  <input type="hidden" name="search_suggestion_module[<?php echo $key; ?>][position]" value="<?php echo $module['position']; ?>"/>
                  <input type="hidden" name="search_suggestion_module[<?php echo $key; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>"/>
                </td>    
                <td class="left"><?php echo $layout['name']; ?></td>
              </tr>
              <?php } ?>  
              <?php } ?>
              <?php } ?>
            </tbody>
          </table>
        </div>

        <div id="tab-where">
					<div class="commercial"><span class="information">*</span> - <?php echo $text_commercial; ?></div>
					<br />
          <table id="where" class="list">
            <thead>
              <tr>
                <td width="1" style="text-align: center;">
                  <input type="checkbox" onclick="$('input[type=checkbox][name*=\'search_suggestion_options[searh_where]\']').attr('checked', this.checked);" />
                </td>
                <td class="left"><?php echo $search_where; ?></td>  
                <td class="left"><?php echo $relevance_weight; ?></td>
              </tr>
            </thead>
            <tbody >
              <tr>
                <td width="1" style="text-align: center;">
                  <input type="checkbox" name="search_suggestion_options[search_where][name]" value="1" <?php echo (isset($options['search_where']['name']) && $options['search_where']['name']) ? "checked=checked" : "" ;?> />
                </td>
                <td class="left"><?php echo $search_where_name; ?></td>  
                <td class="left"><?php echo $relevance_weight_mr; ?></td>
              </tr>
              <tr>
                <td width="1" style="text-align: center;" class="disable">
                  <input type="checkbox" disabled="disabled" />
                </td>
                <td class="left disable"><span class="information">*</span> <?php echo $search_where_tags; ?></td>
                <td class="left disable"><?php echo $relevance_weight_mr; ?></td>
              </tr>
              <tr>
                <td width="1" style="text-align: center;" class="disable">
                  <input type="checkbox" disabled="disabled" />
                </td>
                <td class="left disable"><span class="information">*</span> <?php echo $search_where_description; ?></td>  
                <td class="left disable"><?php echo $relevance_weight_mr; ?></td>
              </tr>
              <tr>
                <td width="1" style="text-align: center;" class="disable">
                  <input type="checkbox" disabled="disabled" />
                </td>
                <td class="left disable"><span class="information">*</span> <?php echo $search_where_model; ?></td> 
                <td class="left disable"><?php echo $relevance_weight_mr; ?></td>              
              </tr>
              <tr>
                <td width="1" style="text-align: center;" class="disable">
                  <input type="checkbox" disabled="disabled" />
                </td>
                <td class="left disable"><span class="information">*</span> <?php echo $search_where_sku; ?></td>  
                <td class="left disable"><?php echo $relevance_weight_mr; ?></td>              
              </tr>

            </tbody>
          </table>
          <?php echo $tab_where_help; ?>  
        </div>

        <div id="tab-fields">
					<div class="commercial"><span class="information">*</span> - <?php echo $text_commercial; ?></div>
					<br />
          <table id="fields" class="list">
            <thead>
              <tr>
                <td class="left"><?php echo $search_fields; ?></td>              
                <td width="1" style="text-align: center;">
                  <input type="checkbox" onclick="$('input[type=checkbox][name*=\'search_suggestion_options[search_field]\']').attr('checked', this.checked);" />
                </td>
                <td class="left"><?php echo $search_fields_settings; ?></td>  
              </tr>
            </thead>
            <tbody >
              <tr>
                <td class="left"><?php echo $search_field_name; ?></td>              
                <td width="1" style="text-align: center;">
                  <input type="checkbox" name="search_suggestion_options[search_field][show_name]" value="1" <?php echo (isset($options['search_field']['show_name']) && $options['search_field']['show_name']) ? "checked=checked" : "" ;?> />
                </td>
                <td class="left"></td>  
              </tr>
              <tr>
                <td class="left"><?php echo $search_field_price; ?></td>              
                <td width="1" style="text-align: center;">
                  <input type="checkbox" name="search_suggestion_options[search_field][show_price]" value="1" <?php echo (isset($options['search_field']['show_price']) && $options['search_field']['show_price']) ? "checked=checked" : "" ;?> />
                </td>
                <td class="left"></td>  
              </tr>
              <tr>
                <td class="left disable"><span class="information">*</span> <?php echo $search_field_image; ?></td>              
                <td width="1" style="text-align: center;" class="disable">
                  <input type="checkbox" disabled="disabled" />
                </td>
                <td class="left disable">
                  <?php echo $search_field_image_width; ?>: <input type="text" disabled="disabled" size="3">  
                  <?php echo $search_field_image_height; ?>: <input type="text" disabled="disabled" size="3">    
                </td>  
              </tr>
              <tr>
                <td class="left disable"><span class="information">*</span> <?php echo $search_field_description; ?></td>              
                <td width="1" style="text-align: center;" class="disable">
                  <input type="checkbox" disabled="disabled"  />
                </td>
                <td class="left disable">
                  <?php echo $search_fields_cut; ?>: <input type="text" disabled="disabled"  size="4">
                </td>  
              </tr>
              <tr>
                <td class="left disable"><span class="information">*</span> <?php echo $search_field_attributes; ?></td>              
                <td width="1" style="text-align: center;" class="disable">
                  <input type="checkbox" disabled="disabled" />
                </td>
                <td class="left disable">
                  <?php echo $search_fields_cut; ?>: <input type="text" disabled="disabled" size="4">
                  <?php echo $search_fields_separator; ?>: <input type="text" disabled="disabled" size="2">
                </td>  
              </tr>

            </tbody>
          </table>

          <table id="fields_attributes" class="list">
            <thead>
              <tr>
                <td class="left"><span class="information">*</span> <?php echo $search_field_attributes; ?></td>              
                <td class="left"><?php echo $search_fields_attributes_show; ?></td>
                <td class="left"><?php echo $search_fields_attributes_replace_text; ?></td>  
              </tr>
            </thead>
            <tbody>

              <?php foreach($attributes as $attribute) {?>
              <tr>
                <td class="left disable"><?php echo $attribute['name']; ?></td>              
                <td class="left disable">

                  <select>

                    <option disabled="disabled"><?php echo $search_fields_attributes_hide; ?></option>
                    <option disabled="disabled"><?php echo $search_fields_attributes_show; ?></option>
                    <option disabled="disabled"><?php echo $search_fields_attributes_replace; ?></option>

                  </select>

                </td>

                <td class="left disable">
                  <input type="text" disabled="disabled">
                </td>  

              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>

        <div id="tab-support">
          <?php echo $support_text; ?>
        </div>

      </form>
    </div>
  </div>
  <div id="copyright"></div>
</div>

<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script> 
<?php echo $footer; ?>
