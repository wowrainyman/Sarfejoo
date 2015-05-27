<?php
class ControllerModuleRecentSearches extends Controller {

	protected function index($setting) {
		$this->language->load('module/recent_searches');
 
      	$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_clear_recent_searches'] = $this->language->get('text_clear_recent_searches');	
		$this->data['link_search_url'] = $this->url->link('product/search', 'filter_name=');
	
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/recent_searches.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/recent_searches.tpl';
		} else {
			$this->template = 'default/template/module/recent_searches.tpl';
		}
		$this->render();
	}
}