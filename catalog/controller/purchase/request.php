<?php
require_once "provider.php";
require_once "settings.php";

class ControllerPurchaseRequest extends Controller
{
    private $error = array();

    public function send()
    {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('provider/profile', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        $this->language->load('purchase/request');

        $this->document->setTitle($this->language->get('heading_title'));

        $errorCode = array(
            -20 => 'api نامعتبر است',
            -21 => 'آی پی نامعتبر است',
            -22 => 'مبلغ از کف تعریف شده کمتر است',
            -23 => 'مبلغ از سقف تعریف شده بیشتر است',
            -24 => 'مبلغ نامعتبر است',
            -6 => 'ارتباط با بانک برقرار نشد',
            -26 => 'درگاه غیرفعال است',
            -27 => 'آی پی شما مسدود است',
            -9 => 'خطای ناشناخته',
            -29 => 'آدرس کال بک خالی است ',
            -30 => 'چنین تراکنشی یافت نشد',
            -31 => 'تراکنش انجام نشده ',
            -32 => 'تراکنش انجام شده اما مبلغ نادرست است ',
            //1 => "تراکنش با موفقیت انجام شده است " ,
        );
        $this->load->model('purchase/pu_transaction');
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {

            $data["customer_id"] = $this->customer->getId();
            $data["payment_gateway_id"] = $this->request->post['gateway_id'];
            $data["value"] = $this->request->post['value'];

            $transaction_id = $this->model_purchase_pu_transaction->AddTransaction($data);

            $client = new SoapClient("http://www.jahanpay.com/webservice?wsdl");
            $api = $GLOBALS['JAHANPAY_API_KEY'];
            $amount = $this->request->post['value']; //Tooman
           $callbackUrl = "http://sarfejoo.com/index.php?route=purchase/request/receive";
            $orderId = $transaction_id;
            $txt = $transaction_id;
            $res = $client->requestpayment($api, $amount, $callbackUrl, $orderId, $txt);
            $this->model_purchase_pu_transaction->UpdateTransactionGatewayId($orderId, $res);
            if ($res > 0) {
                $this->session->data['success']="";
                header("location: http://www.jahanpay.com/pay_invoice/{$res}");
            } else {
                $this->error['warning'] = $errorCode[$res];
            }
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_account'),
            'href' => $this->url->link('provider/profile', '', 'SSL'),
            'separator' => $this->language->get('text_separator')
        );

        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }


        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['text_profile'] = $this->language->get('text_profile');
        $this->data['entry_price'] = $this->language->get('entry_price');
        $this->data['entry_gateway'] = $this->language->get('entry_gateway');
        $this->data['button_submit'] = $this->language->get('button_submit');

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        if (isset($this->error['price'])) {
            $this->data['error_price'] = $this->error['price'];
        } else {
            $this->data['error_price'] = '';
        }

        $payment_gateways = $this->model_purchase_pu_transaction->GetGateways();
        $this->data['payment_gateways'] = $payment_gateways;

        $this->data['action'] = $this->url->link('purchase/request/send', '', 'SSL');

        $this->data['back'] = $this->url->link('account/account', '', 'SSL');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/purchase/pay_form.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/purchase/pay_form.tpl';
        } else {
            $this->template = 'default/template/purchase/pay_form.tpl';
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

    public function receive()
    {
        $errorCode = array(
            -20 => 'api نامعتبر است',
            -21 => 'آی پی نامعتبر است',
            -22 => 'مبلغ از کف تعریف شده کمتر است',
            -23 => 'مبلغ از سقف تعریف شده بیشتر است',
            -24 => 'مبلغ نامعتبر است',
            -6 => 'ارتباط با بانک برقرار نشد',
            -26 => 'درگاه غیرفعال است',
            -27 => 'آی پی شما مسدود است',
            -9 => 'خطای ناشناخته',
            -29 => 'آدرس کال بک خالی است ',
            -30 => 'چنین تراکنشی یافت نشد',
            -31 => 'تراکنش انجام نشده ',
            -32 => 'تراکنش انجام شده اما مبلغ نادرست است ',
            //1 => "تراکنش با موفقیت انجام شده است " ,
        );
        $orderId = (int)$_GET["order_id"];

        $this->load->model('purchase/pu_transaction');
        $transaction_info = $this->model_purchase_pu_transaction->GetTransactionInfo($orderId);
        $api = $GLOBALS['JAHANPAY_API_KEY'];
        $amount = $transaction_info['value']; //Tooman
        $client = new SoapClient("http://www.jahanpay.com/webservice?wsdl");
        $result = $client->verification($api, $amount, $_GET["au"]);
        if (! empty($result) and $result == 1) {
            $this->model_purchase_pu_transaction->UpdateSuccessfulTransaction($orderId, $_GET["au"]);
            $this->model_purchase_pu_transaction->UpdateCustomerBalance($this->customer->getId(), $amount);
            $go= "http://sarfejoo.com/index.php?route=account/account&p=$amount";
            header("Location: $go");
            die();
        } else {
            echo $errorCode[$result];
        }
    }
}

?>