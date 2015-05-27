<?php 
class ControllerTotalXfee extends Controller { 
	private $error = array(); 
	 
	public function index() { 
		$this->language->load('total/xfee');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('xfee', $this->request->post);
		
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_none'] = $this->language->get('text_none');
		
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_cost'] = $this->language->get('entry_cost');
		$this->data['entry_cost'] = $this->language->get('entry_cost');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_tax'] = $this->language->get('entry_tax');
		
		$this->data['tab_fee'] = $this->language->get('tab_fee');
		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['text_all'] = $this->language->get('text_all');
		$this->data['entry_order_total'] = $this->language->get('entry_order_total');
		
		
		$this->data['entry_payment'] = $this->language->get('entry_payment');
		$this->data['entry_shipping'] = $this->language->get('entry_shipping');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
					
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

   		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),      		
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_total'),
			'href'      => $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('total/xfee', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('total/xfee', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL');

		for($i=1;$i<=10;$i++)
		 {
				if (isset($this->request->post['xfee_cost'.$i])) {
					$this->data['xfee_cost'.$i] = $this->request->post['xfee_cost'.$i];
				} else {
					$this->data['xfee_cost'.$i] = $this->config->get('xfee_cost'.$i);
				}
				
				if (isset($this->request->post['xfee_name'.$i])) {
					$this->data['xfee_name'.$i] = $this->request->post['xfee_name'.$i];
				} else {
					$this->data['xfee_name'.$i] = $this->config->get('xfee_name'.$i);
				}
				
				if (isset($this->request->post['xfee_free'.$i])) {
					$this->data['xfee_free'.$i] = $this->request->post['xfee_free'.$i];
				} else {
					$this->data['xfee_free'.$i] = $this->config->get('xfee_free'.$i);
				}
		
				if (isset($this->request->post['xfee_tax_class_id'.$i])) {
					$this->data['xfee_tax_class_id'.$i] = $this->request->post['xfee_tax_class_id'.$i];
				} else {
					$this->data['xfee_tax_class_id'.$i] = $this->config->get('xfee_tax_class_id'.$i);
				}
		
				if (isset($this->request->post['xfee_geo_zone_id'.$i])) {
					$this->data['xfee_geo_zone_id'.$i] = $this->request->post['xfee_geo_zone_id'.$i];
				} else {
					$this->data['xfee_geo_zone_id'.$i] = $this->config->get('xfee_geo_zone_id'.$i);
				}
				
				if (isset($this->request->post['xfee_status'.$i])) {
					$this->data['xfee_status'.$i] = $this->request->post['xfee_status'.$i];
				} else {
					$this->data['xfee_status'.$i] = $this->config->get('xfee_status'.$i);
				}
				
				if (isset($this->request->post['xfee_shipping'.$i])) {
					$this->data['xfee_shipping'.$i] = $this->request->post['xfee_shipping'.$i];
				} else {
					$this->data['xfee_shipping'.$i] = $this->config->get('xfee_shipping'.$i);
				}
				
				if (isset($this->request->post['xfee_payment'.$i])) {
					$this->data['xfee_payment'.$i] = $this->request->post['xfee_payment'.$i];
				} else {
					$this->data['xfee_payment'.$i] = $this->config->get('xfee_payment'.$i);
				}
				
				if (isset($this->request->post['xfee_total'.$i])) {
					$this->data['xfee_total'.$i] = $this->request->post['xfee_total'.$i];
				} else {
					$this->data['xfee_total'.$i] = $this->config->get('xfee_total'.$i);
				}
				
				if (isset($this->request->post['xfee_sort_order'.$i])) {
					$this->data['xfee_sort_order'.$i] = $this->request->post['xfee_sort_order'.$i];
				} else {
					$this->data['xfee_sort_order'.$i] = $this->config->get('xfee_sort_order'.$i);
				}
		 }	
		 
		 if (isset($this->request->post['xfee_status'])) {
					$this->data['xfee_status'] = $this->request->post['xfee_status'];
				} else {
					$this->data['xfee_status'] = $this->config->get('xfee_status');
				}
		if (isset($this->request->post['xfee_sort_order'])) {
					$this->data['xfee_sort_order'] = $this->request->post['xfee_sort_order'];
				} else {
					$this->data['xfee_sort_order'] = $this->config->get('xfee_sort_order');
				}						

		$this->load->model('localisation/tax_class');
		
		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
		
		$this->load->model('localisation/geo_zone');
		
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		$shipping_mods=array();
		$xshipping_installed=false;
		$result=$this->db->query("select * from " . DB_PREFIX . "extension where type='shipping'");
		if($result->rows){
		  foreach($result->rows as $row){
		     $shipping_mods[$row['code']]=$this->getModuleName($row['code'],$row['type']);  
			 if($row['code']=='xshippingpro')$xshipping_installed=true;
		  }
		}
		
		$this->data['shipping_mods'] = $shipping_mods;
		
		/*For X-Shipping Pro*/
		   if($xshipping_installed){
			   $language_id=$this->config->get('config_language_id');
			   $xshippingpro=$this->config->get('xshippingpro');
			   if($xshippingpro)
			   $xshippingpro=unserialize($xshippingpro);
			
			   if(!isset($xshippingpro['name']))$xshippingpro['name']=array();
			   if(!is_array($xshippingpro['name']))$xshippingpro['name']=array();
			   
			   $xshippingpro_methods=array();
			   foreach($xshippingpro['name'] as $no_of_tab=>$names){
				  
				   if(isset($names[$language_id]) && $names[$language_id]){
					  $code = 'xshippingpro'.'.xshippingpro'.$no_of_tab;
					  $xshippingpro_methods[$code]=$names[$language_id];
					}
			   }
	         $this->data['xshippingpro_methods'] = $xshippingpro_methods;
		   }
		/*End of X-shipping Pro*/
		
		
		$payment_mods=array();
		$result=$this->db->query("select * from " . DB_PREFIX . "extension where type='payment'");
		if($result->rows){
		  foreach($result->rows as $row){
		     $payment_mods[$row['code']]=$this->getModuleName($row['code'],$row['type']);  
		  }
		}
		
		$this->data['payment_mods'] = $payment_mods;
		

		$this->template = 'total/xfee.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'total/xfee')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
	
	function getModuleName($code,$type)
	{
	   if(!$code) return '';
	   
	   $this->language->load($type.'/'.$code);
	   return $this->language->get('heading_title');
	}
}
?>