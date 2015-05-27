<?php  
class ControllerModulepumenu extends Controller {
	protected function index() {
		$this->language->load('module/pumenu');

   $this->data['heading_title'] = $this->language->get('heading_title');

   $this->data['text_menu_sub_profiles'] = $this->language->get('text_menu_sub_profiles');
   $this->data['text_menu_profiles'] = $this->language->get('text_menu_profiles');
   $this->data['text_menu_add_products'] = $this->language->get('text_menu_add_products');
   $this->data['text_menu_set_prices'] = $this->language->get('text_menu_set_prices');
   $this->data['text_menu_set_discounts'] = $this->language->get('text_menu_set_discounts');
   $this->data['text_menu_pofiles_stat'] = $this->language->get('text_menu_pofiles_stat');
   $this->data['text_menu_inbox'] = $this->language->get('text_menu_inbox');
   $this->data['text_menu_bank'] = $this->language->get('text_menu_bank');
   $this->data['text_menu_advertisments'] = $this->language->get('text_menu_advertisments');
   $this->data['text_menu_namads'] = $this->language->get('text_menu_namads');

		if($this->customer->isLogged()) {
        $CustomerGroupId = $this->customer->getCustomerGroupId();
    } else {
        $CustomerGroupId = '0';
    }
    
    $this->data['Customer_Group_Id'] = $CustomerGroupId;
   		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/pumenu.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/pumenu.tpl';
		} else {
			$this->template = 'default/template/module/pumenu.tpl';
		}
		
		$this->render();
	}
}
?>