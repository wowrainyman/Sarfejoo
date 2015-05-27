<?php
//require_once(DIR_SYSTEM.'library/nuSoap/nusoap.php');
class ControllerPaymentJahanpay extends Controller {
	protected function index() {
		$this->language->load('payment/jahanpay');
    	$this->data['button_confirm'] = $this->language->get('button_confirm');
		
		$this->data['text_wait'] = $this->language->get('text_wait');
		$this->data['text_ersal'] = $this->language->get('text_ersal');
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/jahanpay.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/jahanpay.tpl';
		} else {
			$this->template = 'default/template/payment/jahanpay.tpl';
		}
		
		$this->render();
}
public function confirm() {
		
		$this->load->model('checkout/order');
		
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		
		$this->load->library('encryption');
		
		$encryption = new Encryption($this->config->get('config_encryption'));
		
		
		
		
		$this->data['Amount'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);		//echo $this->data['Amount'];
			//$amount = intval($Amount) /$order_info['currency_value'];
			if($this->currency->getCode()=='RLS') {
		$this->data['Amount']=$this->data['Amount'] / 10;
	}
		
		$this->data['PIN']=$this->config->get('jahanpay_PIN');
		
		
		$this->data['ResNum'] = $this->session->data['order_id'];

		$this->data['return'] = $this->url->link('checkout/success', '', 'SSL');
		//$this->data['return'] = HTTPS_SERVER . 'index.php?route=checkout/success';
		
		$this->data['cancel_return'] = $this->url->link('checkout/payment', '', 'SSL');
		//$this->data['cancel_return'] = HTTPS_SERVER . 'index.php?route=checkout/payment';

		$this->data['back'] = $this->url->link('checkout/payment', '', 'SSL');

		$amount = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);		//echo $this->data['Amount'];
			//$amount = intval($Amount) /$order_info['currency_value'];
			if($this->currency->getCode()=='RLS') {
		$amount=$amount / 10;
	}
	
		$this->load->model('checkout/order');
		
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
	
	
	$Description = $order_info['comment'];
	
	
	
		$this->data['order_id'] = $encryption->encrypt($this->session->data['order_id']);
		$callbackUrl  =  $this->url->link('payment/jahanpay/callback', 'order_id=' . $this->data['order_id'], 'SSL');
		
		
	$client = new SoapClient('http://jahanpay.com/index.php/webservice?wsdl');

	$res = $client->requestpayment($this->data['PIN'],$amount,$callbackUrl,$order_info['order_id'],$Description);

	$PayPath = 'http://www.jahanpay.com/pay_invoice/'.$res;
	$Status = $res;
	
	if($Status > 1 )
	{

		$this->data['action'] = $PayPath;
		$json = array();
		$json['success']= $this->data['action'];	
	
		$this->response->setOutput(json_encode($json));
		
		} else {
			
			$this->CheckState($Status);
			//die();
		}

//
		
	
		
}

	public function CheckState($status) {
		$json = array();
		$json['error']= 'کد خطا :'.$status;
		$this->response->setOutput(json_encode($json));

	
	}	
			
		
	


function verify_payment($authority, $amount){

	if($authority){
		 $client = new nusoap_client('http://jahanpay.com/index.php/webservice?wsdl', true);	
		if ((!$client))
			{echo  "Error: can not connect to jahanpay.<br>";return false;}
		
		else {
			$this->data['PIN'] = $this->config->get('jahanpay_PIN');
			$parameters = array(
			$this->data['PIN'],
			$amount,
			$authority);
		$res = $client->call('verification', $parameters);
		
			$this->CheckState($res);
			
			if($res==1)
				return true;

			else {
				return false;
			}
		
		}
	} 
	
	else {
		return false;
	}
	
	
	return false;
}

	public function callback() {
		$this->load->library('encryption');

		$encryption = new Encryption($this->config->get('config_encryption'));
		
		//$order_id = $encryption->decrypt($this->request->get['order_id']);
		$MerchantID=$this->config->get('jahanpay_PIN');
	    if($_GET['au']!== ''){
		$au = $_GET['au'];
		
//Your Order ID
          $order_id=$this->session->data['order_id'];
        $this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($order_id);
	$amount = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);		//echo $this->data['Amount'];
			//$amount = intval($Amount) /$order_info['currency_value'];
			if($this->currency->getCode()=='RLS') {
		$amount=$amount / 10;
	
			}
		$client = new SoapClient('http://jahanpay.com/index.php/webservice?wsdl');

		$res = $client->verification($MerchantID,$amount,$au );
		
		//$Amount = $this->currency->format($order_info['total'], 'RLS', $order_info['value'], FALSE);
		
		
		
			
		$Status = $res;
		if($Status == 1)// Your Peyment Code Only This Event
		{
				$this->model_checkout_order->confirm($order_id, $this->config->get('jahanpay_order_status_id'),'شماره رسيد ديجيتالي; au: '.$au);
				
				$this->response->setOutput('<html><head><meta http-equiv="refresh" CONTENT="2; url=' . $this->url->link('checkout/success') . '"></head><body><table border="0" width="100%"><tr><td>&nbsp;</td><td style="border: 1px solid gray; font-family: tahoma;background: #EDEBFE; font-size: 14px; direction: rtl; text-align: right;">با تشکر پرداخت تکمیل شد.لطفا چند لحظه صبر کنید و یا  <a href="' . $this->url->link('checkout/success') . '"><b>اینجا کلیک نمایید</b></a></td><td>&nbsp;</td></tr><tr><td colspan="2"> شماره رسيد ديجيتالي:'.$au.'</td></tr></table></body></html>');
			}
		else {
			$this->response->setOutput('<html><body><table border="0" width="100%"><tr><td>&nbsp;</td><td style="border: 1px solid gray;background: #EDEBFE; font-family: tahoma; font-size: 14px; direction: rtl; text-align: right;">خطا در عملیات پردازش پرداخت:<br />کد خطا:'.$Status.'<br /><br /><a href="' . $this->url->link('checkout/cart').  '"><b>بازگشت به فروشگاه</b></a></td><td>&nbsp;</td></tr></table></body></html>');
		}
	}
		 else {
			$this->response->setOutput('<html><body><table border="0" width="100%"><tr><td>&nbsp;</td><td style="border: 1px solid gray;background: #EDEBFE; font-family: tahoma; font-size: 14px; direction: rtl; text-align: right;">.		بازگشت از عمليات پرداخت، خطا در انجام عملیات پرداخت ( پرداخت ناموق ) !<br /><br /><a href="' . $this->url->link('checkout/cart').  '"><b>بازگشت به فروشگاه</b></a></td><td>&nbsp;</td></tr></table></body></html>');
		}
	}
	
}
?>