<?php
require_once "settings.php";
/**
 * Created by PhpStorm.
 * User: Amir
 * Date: 10/9/2014
 * Time: 9:41 AM
 */
class ControllerFinancialProviderPlan extends Controller
{
    private $error = array();
    public function index()
    {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('provider/profile', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        $this->language->load('financial/plan');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('financial/pu_provider_plan');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->session->data['success'] = $this->language->get('text_success');
            $type = $this->request->post['type'];
            $related_id = $this->request->post['related_id'];
            $customer_id = $this->customer->getId();

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
        $this->data['button_continue'] = $this->language->get('button_continue');
        $this->data['button_back'] = $this->language->get('button_back');
        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        $results = $this->model_financial_pu_provider_plan->getPlans();

        $this->data['action'] = $this->url->link('financial/provider_plan/confirm', '', 'SSL');

        foreach ($results as $result) {
            $this->data['plans'][] = array(
                'id' => $result['id'],
                'name' => $result['name'],
                'duration' => $result['duration'],
                'price' =>  $result['price']
            );
        }

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/financial/provider_plan.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/financial/provider_plan.tpl';
        } else {
            $this->template = 'default/template/financial/provider_plan.tpl';
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
        $this->load->model('financial/pu_provider_plan');
        $this->load->model('purchase/pu_transaction');
        $this->load->model('financial/pu_provider_plan_customer_transaction');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $orderId = $this->request->post['order_id'];
            $transaction_info = $this->model_purchase_pu_transaction->GetTransactionInfo($orderId);
            $res = $transaction_info['transaction_gateway_id'];
            if ($res > 0) {
                $this->session->data['success']="";
                header("location: http://www.jahanpay.com/pay_invoice/{$res}");
            } else {
                $this->error['warning'] = $errorCode[$res];
            }
        }else {
            if (isset($this->request->get['plan_id'])) {
                $plan_id = $this->request->get['plan_id'];
                $result = $this->model_financial_pu_provider_plan->getPlan($plan_id);
                $this->data['plan'] = $result;
                $customer_id = $this->customer->getId();

                $data["customer_id"] = $this->customer->getId();
                $data["payment_gateway_id"] = 1;
                $data["value"] = $result["price"];
                $transaction_id = $this->model_purchase_pu_transaction->AddTransaction($data);
                $this->model_financial_pu_provider_plan_customer_transaction->add($plan_id,
                    $transaction_id,
                    $this->customer->getId());
                $client = new SoapClient("http://www.jahanpay.com/webservice?wsdl");
                $api = $GLOBALS['JAHANPAY_API_KEY'];
                $amount =  $result["price"];
                $callbackUrl = $this->url->link('financial/provider_plan/receive', 'order_id=' . $transaction_id, 'SSL');
                $orderId = $transaction_id;
                $txt = $transaction_id;
                $res = $client->requestpayment($api, $amount, $callbackUrl, $orderId, $txt);
                $this->model_purchase_pu_transaction->UpdateTransactionGatewayId($orderId, $res);
                $this->data['order_id'] = $orderId;
                $this->data['res'] = $res;

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

            $results = $this->model_financial_pu_provider_plan->getPlans();

            $this->data['action'] = $this->url->link('financial/provider_plan/confirm', '', 'SSL');


            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/financial/provider_plan_confirm.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/financial/provider_plan_confirm.tpl';
            } else {
                $this->template = 'default/template/financial/provider_plan_confirm.tpl';
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

        $this->load->model('purchase/pu_transaction');

        $this->load->model('financial/pu_provider_plan_customer_transaction');
        $this->load->model('financial/pu_provider_plan');
        $this->load->model('account/customer');
        $transaction_info = $this->model_purchase_pu_transaction->GetTransactionInfo($orderId);
        $api = $GLOBALS['JAHANPAY_API_KEY'];
        $amount = $transaction_info['value']; //Tooman
        $client = new SoapClient("http://www.jahanpay.com/webservice?wsdl");
        $result = $client->verification($api, $amount, $_GET["au"]);
        if (! empty($result) and $result == 1) {
            $this->model_purchase_pu_transaction->UpdateSuccessfulTransaction($orderId, $_GET["au"]);
            $plan_id = $this->model_financial_pu_provider_plan_customer_transaction->getPlanId($transaction_info['id']);
            $plan_info = $this->model_financial_pu_provider_plan->getPlan($plan_id);
            $currentDate = new DateTime();
            $currentDate = $currentDate->getTimestamp();
            echo '+' . $plan_info['duration'] . ' days' . date('Y-m-d H:i:s', $currentDate);
            $expire_date = date('Y-m-d H:i:s', strtotime('+' . $plan_info['duration'] . ' days' . date('Y-m-d H:i:s', $currentDate)));

            $this->model_account_customer->setCustomerExpireDate($this->customer->getId(),$expire_date);
            $go= "http://sarfejoo.com/index.php?route=account/account&p=$amount";
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