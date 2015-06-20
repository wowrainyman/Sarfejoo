<?php
require_once "settings.php";

class ControllerFinancialAdvertisingPlan extends Controller
{
    private $error = array();

    public function confirm()
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

        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('provider/profile', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        $this->language->load('financial/plan');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('financial/pu_advertising');
        $this->load->model('purchase/pu_transaction');
        $this->load->model('financial/pu_subprofile_plan_subprofile_transaction');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $adPlanCustomer_id = $this->request->post['id'];
            $adPlanCustomer_info = $this->model_financial_pu_advertising->getAdPlanCustomer($adPlanCustomer_id);
            $txt = $transaction_id = $adPlanCustomer_info['transaction_id'];
            $orderId = $adPlanCustomer_id;
            $client = new SoapClient("http://www.jahanpay.com/webservice?wsdl");
            $api = $GLOBALS['JAHANPAY_API_KEY'];
            $amount =  $adPlanCustomer_info["price"]; //Tooman
            $callbackUrl = $this->url->link('financial/advertising_plan/receive', 'order_id=' . $orderId, 'SSL');
            $res = $client->requestpayment($api, $amount, $callbackUrl, $orderId, $txt);
            $this->model_purchase_pu_transaction->UpdateTransactionGatewayId($transaction_id, $res);
            if ($res > 0) {
                $this->session->data['success']="";
                header("location: http://www.jahanpay.com/pay_invoice/{$res}");
            } else {
                $this->error['warning'] = $errorCode[$res];
            }
        }else {
            if (isset($this->request->get['id'])) {
                $this->load->model('financial/pu_advertising');
                $adPlanCustomer_id = $this->request->get['id'];

                $adPlanCustomer_info = $this->model_financial_pu_advertising->getAdPlanCustomer($adPlanCustomer_id);
                $this->data['plan'] = array(
                    'id' => $adPlanCustomer_info['id'],
                    'price' => $adPlanCustomer_info['price'],
                    'name' => $adPlanCustomer_info['name']
                );
            } else {
                $this->redirect($this->url->link('account/account', '', 'SSL'));
            }
            $this->data['breadcrumbs'] = array();
            $this->data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/home'),
                'separator' => false
            );
            $this->data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_account'),
                'href' => $this->url->link('subprofile/profile', '', 'SSL'),
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
            $this->data['entry_title'] = $this->language->get('entry_title');
            $this->data['entry_province'] = $this->language->get('entry_province');
            $this->data['entry_city'] = $this->language->get('entry_city');
            $this->data['entry_address'] = $this->language->get('entry_address');
            $this->data['entry_tel'] = $this->language->get('entry_tel');
            $this->data['entry_mobile'] = $this->language->get('entry_mobile');
            $this->data['entry_email'] = $this->language->get('entry_email');
            $this->data['entry_website'] = $this->language->get('entry_website');
            $this->data['entry_picture'] = $this->language->get('entry_picture');
            $this->data['entry_logo'] = $this->language->get('entry_logo');
            $this->data['entry_persontype'] = $this->language->get('entry_persontype');
            $this->data['entry_legalperson'] = $this->language->get('entry_legalperson');
            $this->data['entry_naturalperson'] = $this->language->get('entry_naturalperson');
            $this->data['entry_edit'] = $this->language->get('entry_edit');
            $this->data['entry_status'] = $this->language->get('entry_status');
            $this->data['button_add'] = $this->language->get('button_add');
            $this->data['button_confirm'] = $this->language->get('button_confirm');
            $this->data['button_continue'] = $this->language->get('button_continue');
            $this->data['button_back'] = $this->language->get('button_back');
            if (isset($this->error['warning'])) {
                $this->data['error_warning'] = $this->error['warning'];
            } else {
                $this->data['error_warning'] = '';
            }

            $this->data['action'] = $this->url->link('financial/advertising_plan/confirm', '', 'SSL');


            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/financial/advertising_plan_confirm.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/financial/advertising_plan_confirm.tpl';
            } else {
                $this->template = 'default/template/financial/advertising_plan_confirm.tpl';
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
        $adPlanCustomer_id = $orderId;
        $this->load->model('financial/pu_advertising');
        $adPlanCustomer_info = $this->model_financial_pu_advertising->getAdPlanCustomer($adPlanCustomer_id);
        $this->load->model('purchase/pu_transaction');
        $transaction_info = $this->model_purchase_pu_transaction->GetTransactionInfo($adPlanCustomer_info['transaction_id']);
        $api = $GLOBALS['JAHANPAY_API_KEY'];
        $amount = $transaction_info['value']; //Tooman
        $client = new SoapClient("http://www.jahanpay.com/webservice?wsdl");
        $result = $client->verification($api, $amount, $_GET["au"]);
        if (! empty($result) and $result == 1) {
            $this->model_purchase_pu_transaction->UpdateSuccessfulTransaction($adPlanCustomer_info['transaction_id'], $_GET["au"]);
            $this->model_financial_pu_advertising->UpdateSuccessfulAdPlanCustomer($adPlanCustomer_id);
            $callbackUrl = $this->url->link('ad/advertising_list','', 'SSL');
            $go= $callbackUrl;
            header("Location: $go");
            die();
        } else {
            echo $errorCode[$result];
        }
    }

    protected function validate()
    {
        return true;
    }
}

?>