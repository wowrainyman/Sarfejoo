<?php  
class ControllerModuleSidebarSearch extends Controller {
	protected function index($setting) {
	
		$this->data['options'] = $setting['options'];
	
		/* Language */
		
		$this->language->load('module/sidebarsearch');		

    	$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_searchbox'] = $this->language->get('text_searchbox');
		$this->data['text_categorytop'] = $this->language->get('text_categorytop');
		$this->data['text_subsYN'] = $this->language->get('text_subsYN');
		$this->data['text_descripYN'] = $this->language->get('text_descripYN');

		/* Categories Dropdown */
		
		$this->load->model('catalog/category');
		
		// 3 Level Category Search
		$this->data['categories'] = array();
					
		$categories_1 = $this->model_catalog_category->getCategories(0);
		
		foreach ($categories_1 as $category_1) {
			$level_2_data = array();
			
			$categories_2 = $this->model_catalog_category->getCategories($category_1['category_id']);
			
			foreach ($categories_2 as $category_2) {
				$level_3_data = array();
				
				$categories_3 = $this->model_catalog_category->getCategories($category_2['category_id']);
				
				foreach ($categories_3 as $category_3) {
					$level_3_data[] = array(
						'category_id' => $category_3['category_id'],
						'name'        => $category_3['name'],
					);
				}
				
				$level_2_data[] = array(
					'category_id' => $category_2['category_id'],	
					'name'        => $category_2['name'],
					'children'    => $level_3_data
				);					
			}
			
			$this->data['categories'][] = array(
				'category_id' => $category_1['category_id'],
				'name'        => $category_1['name'],
				'children'    => $level_2_data
			);
		}		
		
		
		$this->data['sidebarsearch'] = array();

		/* Load Template */
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/sidebarsearch.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/sidebarsearch.tpl';
		} else {
			$this->template = 'default/template/module/sidebarsearch.tpl';
		}

		$this->render();
  	}
}
?>