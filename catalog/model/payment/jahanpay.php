<?php 
class ModelPaymentJahanpay extends Model {
  	public function getMethod() {
		$this->load->language('payment/jahanpay');

		if ($this->config->get('jahanpay_status')) {
      		  	$status = TRUE;
      	} else {
			$status = FALSE;
		}
		
		$method_data = array();
	
		if ($status) {  
      		$method_data = array( 
        		'code'         => 'jahanpay',
        		'title'      => $this->language->get('text_title'),
				'sort_order' => $this->config->get('jahanpay_sort_order')
      		);
    	}
   
    	return $method_data;
  	}
}
?>