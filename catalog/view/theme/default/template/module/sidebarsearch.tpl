<div class="box">
  <div class="box-heading"><?php echo $heading_title; ?></div>
  <div class="box-content">
  <div id="sidebarsearch">
    <!-- Basic search box -->
	<div class="button-sidebarsearch" style="position: absolute; background: url('catalog/view/theme/default/image/button-search.png') center center no-repeat; width: 28px; height: 24px; border-left: 1px solid #CCCCCC; cursor: pointer;"></div>
    <input type="text" name="sidebarsearch_name" value="<?php echo $text_searchbox; ?>" onclick="this.value = '';" onkeydown="this.style.color = '#000000';" />
	 <!-- Advanced Options -->
	 <?php if($options == 1){ ?>
	 <div id="dropdown-categories" style="padding: 10px 0px;width: 176px;">
		<select name="filter_category_id" style="width: 168px;">
        <option value="0"><?php echo $text_categorytop; ?></option>
        <?php foreach ($categories as $category_1) { ?>
        <option value="<?php echo $category_1['category_id']; ?>"><?php echo $category_1['name']; ?></option>
        <?php foreach ($category_1['children'] as $category_2) { ?>
        <option value="<?php echo $category_2['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
        <?php foreach ($category_2['children'] as $category_3) { ?>
        <option value="<?php echo $category_3['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
        <?php } ?>
        <?php } ?>
        <?php } ?>
      </select>
	  </div>
	  <div id="checkbox-subcategories" style="padding: 0px 0px 10px 0px;">
		<input type="checkbox" name="filter_sub_category" value="1" id="sub_category" />
		<label for="sub_category"><?php echo $text_subsYN; ?></label>
	  </div>
	  <div id="checkbox-description" style="padding: 0px 0px 10px 0px;">
		<input type="checkbox" name="filter_description" value="1" id="description" />
		<label for="description"><?php echo $text_descripYN; ?></label>
	</div>
	<?php } ?>
  </div>
  </div>
</div>