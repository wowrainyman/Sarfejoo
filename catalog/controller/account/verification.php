<?php 
class ControllerAccountVerification extends Controller { 
	public function index() {
		$this->language->load('account/verification');
		$this->document->setTitle($this->language->get('heading_title'));
			
		if ($this->customer->isLogged()) {  
      		$error = $this->language->get('error_verified_before');
          }
          
		if (isset($this->request->get['key']) && isset($this->request->get['u'])){
			if(strlen($this->request->get['key']) !== 64 || intval($this->request->get['u']) <= 0) {
				$error = $this->language->get('error_wrong_data');
			}
		} else {
			$error = $this->language->get('error_wrong_access');
		}
		
		if ($this->customer->isLogged()) {  
      		$error = $this->language->get('error_verified_before');
          }
                     
		if(!isset($error)) {
			$customer_id = $this->request->get['u'];
			$verification_key = $this->request->get['key'];
			$gen_key = md5(md5($customer_id)) . md5($customer_id);
                    if($verification_key == $gen_key) {
                         $is_verification = 1;
                    } else {
                         $is_verification = 0;
                    }

                    $this->load->model('account/customer');
                    $verification_status = $this->model_account_customer->GetCustomerEmailStatus($customer_id);
                                       
                    if ($verification_status ==1) {
                    $is_verification = 0;
                    }
                    
			$this->data['heading_title'] = $this->language->get('heading_title');
			$this->data['text_account_verificaiton'] = $this->language->get('text_account_verificaiton');
			$this->data['text_account_verified'] = $this->language->get('text_account_verified');
			$this->data['login'] = $this->url->link('account/login', '', 'SSL');
		} else {
		     $this->data['heading_title'] = $this->language->get('heading_title');
			$this->data['error_verification'] = $error;
			$this->data['error_wrong_data'] = $this->language->get('error_wrong_data');
		}
			
                    if (isset($is_verification) && $is_verification ==1) {
                         $this->data['verification'] = 1;
                         $set_verification_status = $this->model_account_customer->SetCustomerEmailStatus($customer_id);
                    } else {
                         $this->data['verification'] = 0;
                         $this->data['error_wrong_data_check'] = $this->language->get('error_wrong_data_check');
                    }
		
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/verification.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/verification.tpl';
		} else {
			$this->template = 'default/template/account/verification.tpl';
		}
		
		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'		
		);
				
		$this->response->setOutput($this->render());
  	}
}
?>