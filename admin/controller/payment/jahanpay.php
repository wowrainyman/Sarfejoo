<?php 
class ControllerPaymentJahanpay extends Controller {
	private $error = array(); 

	public function index() {
		$this->load->language('payment/jahanpay');


		$this->document->setTitle = $this->language->get('heading_title');
		
		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->load->model('setting/setting');
			
			$this->model_setting_setting->editSetting('jahanpay', $this->request->post);							
			
			$this->session->data['success'] = $this->language->get('text_success');

			//$this->redirect(HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token']);
			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		
		$this->data['entry_PIN'] = $this->language->get('entry_PIN');
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');		
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['help_encryption'] = $this->language->get('help_encryption');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');
		
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->error['PIN'])) {
			$this->data['error_PIN'] = $this->error['PIN'];
		} else {
			$this->data['error_PIN'] = '';
		}
	
		
		//$this->document->breadcrumbs = array();
        $this->data['breadcrumbs'] = array();
   	$this->document->breadcrumbs[] = array(
       		//'href'      => $this->url->https('common/home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		//'href'      => $this->url->https('extension/payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('text_payment'),
      		'separator' => ' :: '
   		);

   		$this->document->breadcrumbs[] = array(
       		
			'href'      => $this->url->link('payment/jahanpay', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
			
				
			$this->data['action'] = $this->url->link('payment/jahanpay', 'token=' . $this->session->data['token'], 'SSL');
		
		  $this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['jahanpay_PIN'])) {
			$this->data['jahanpay_PIN'] = $this->request->post['jahanpay_PIN'];
		} else {
			$this->data['jahanpay_PIN'] = $this->config->get('jahanpay_PIN');
		}
			if (isset($this->request->post['jahanpay_PIN'])) {
			$this->data['jahanpay_PIN'] = $this->request->post['jahanpay_PIN'];
		} else {
			$this->data['jahanpay_PIN'] = $this->config->get('jahanpay_PIN');
		}
		
		if (isset($this->request->post['jahanpay_order_status_id'])) {
			$this->data['jahanpay_order_status_id'] = $this->request->post['jahanpay_order_status_id'];
		} else {
			$this->data['jahanpay_order_status_id'] = $this->config->get('jahanpay_order_status_id'); 
		} 

		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->post['jahanpay_status'])) {
			$this->data['jahanpay_status'] = $this->request->post['jahanpay_status'];
		} else {
			$this->data['jahanpay_status'] = $this->config->get('jahanpay_status');
		}
		
		if (isset($this->request->post['jahanpay_sort_order'])) {
			$this->data['jahanpay_sort_order'] = $this->request->post['jahanpay_sort_order'];
		} else {
			$this->data['jahanpay_sort_order'] = $this->config->get('jahanpay_sort_order');
		}
		
		$this->template = 'payment/jahanpay.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		//$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
		$this->response->setOutput($this->render());
	}

	private function validate() {

		if (!$this->user->hasPermission('modify', 'payment/jahanpay')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->request->post['jahanpay_PIN']) {
			$this->error['PIN'] = $this->language->get('error_PIN');
		}		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
}
?>