<?php
include_once('ipgphp/ipg/enpayment.php');
require_once "settings.php";

/**
 * Created by PhpStorm.
 * User: Amir
 * Date: 10/9/2014
 * Time: 9:41 AM
 */
class ControllerFinancialSubprofilePlan extends Controller
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
        $this->load->model('financial/pu_subprofile_plan');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->session->data['success'] = $this->language->get('text_success');
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

        $this->load->model('provider/pu_subprofile');

        $this->load->model('financial/pu_feature_based_plan');

        $featuredPlans = $this->model_financial_pu_feature_based_plan->getPlans();
        $this->data['featuredPlans'] = $featuredPlans;
        $features = $this->model_financial_pu_feature_based_plan->getFeatures();
        $periods = $this->model_financial_pu_feature_based_plan->getPeriods();
        $this->data['periods'] = $periods;
        foreach ($features as $feature) {
            $plan_structure = array();
            foreach ($featuredPlans as $plan) {
                $value = $this->model_financial_pu_feature_based_plan->getPlanFeatureValue($plan['id'], $feature['id']);
                $value = $value['value'];
                $featureWithValue = $feature;
                $featureWithValue['value'] = $value;
                $featureWithValue['is_recommended'] = $plan['is_recommended'];
                $plan_structure[] = $featureWithValue;
            }
            $plan_structures[] = $plan_structure;
        }
        foreach ($periods as $period) {
            $plan_price_structure = array();
            foreach ($featuredPlans as $plan) {
                $value = $this->model_financial_pu_feature_based_plan->getPlanPeriodValue($plan['id'], $period['id']);
                $value = $value[0]['value'];
                $periodWithValue = $period;
                $periodWithValue['value'] = $value;
                $periodWithValue['is_recommended'] = $plan['is_recommended'];
                $plan_price_structure[] = $periodWithValue;

            }
            $plan_price_structures[] = $plan_price_structure;
        }
        $this->data['plan_price_structures'] = $plan_price_structures;
        $this->data['plan_structures'] = $plan_structures;
        $subprofile_id = $this->request->get['id'];

        $subprofile_info = $this->model_provider_pu_subprofile->GetSubprofileInfo($subprofile_id);

        $this->data['subprofile_id'] = $subprofile_id;

        if ($subprofile_info['group_id'])
            $results = $this->model_financial_pu_subprofile_plan->getPlans(0);
        else
            $results = $this->model_financial_pu_subprofile_plan->getPlans(1);


        $this->data['action'] = $this->url->link('financial/subprofile_plan/confirm', '', 'SSL');
        $this->data['action1'] = $this->url->link('financial/subprofile_plan_jahanpay/confirm', '', 'SSL');

        foreach ($results as $result) {
            $this->data['plans'][] = array(
                'id' => $result['id'],
                'name' => $result['name'],
                'duration' => $result['duration'],
                'price' => $result['price']
            );
        }

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/financial/subprofile_plan.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/financial/subprofile_plan.tpl';
        } else {
            $this->template = 'default/template/financial/subprofile_plan.tpl';
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
        $this->load->model('financial/pu_subprofile_plan');
        $this->load->model('purchase/pu_transaction');
        $this->load->model('financial/pu_subprofile_plan_subprofile_transaction');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            if (isset($this->request->post['plan_id'])) {
                $this->data['plan_id'] = $this->request->post['plan_id'];
                $plan_id = $this->request->post['plan_id'];
            } else {
                $this->redirect($this->url->link('account/account', '', 'SSL'));
            }
            if (isset($this->request->post['period_id'])) {
                $this->data['period_id'] = $this->request->post['period_id'];
                $period_id = $this->request->post['period_id'];
            } else {
                $this->redirect($this->url->link('account/account', '', 'SSL'));
            }
            if (isset($this->request->post['subprofile_id'])) {
                $this->data['subprofile_id'] = $this->request->post['subprofile_id'];
                $subprofile_id = $this->request->post['subprofile_id'];
            } else {
                $this->redirect($this->url->link('account/account', '', 'SSL'));
            }

            $this->load->model('financial/pu_feature_based_plan');
            $plan = $this->model_financial_pu_feature_based_plan->getPlan($plan_id);
            $period = $this->model_financial_pu_feature_based_plan->getPeriod($period_id);
            $monthlyPrice = $this->model_financial_pu_feature_based_plan->getPlanPeriodValue($plan_id, $period_id);
            $total_price = ($monthlyPrice[0]['value']) * (intval($period['duration'] / 30));

            $result = $this->model_financial_pu_subprofile_plan->getPlan($plan_id);
            $customer_id = $this->customer->getId();
            $data["customer_id"] = $customer_id;
            $data["payment_gateway_id"] = 2;
            $data["value"] = $total_price;

            $transaction_id = $this->model_purchase_pu_transaction->AddTransaction($data);

            $history_id = $this->model_financial_pu_feature_based_plan->addSubprofileHistory($customer_id,
                $subprofile_id,
                $plan_id,
                $period_id,
                $total_price,
                $period['duration'],
                $transaction_id,
                0);


            $resNum = $transaction_id;
            $redirectUrl = $this->url->link('financial/subprofile_plan/receive', 'order_id=' . $transaction_id, 'SSL');
            $amount = $total_price * 10;


/////////////////state1

            $payment = new Payment();

            $login = $payment->login(username, password);
            $login = $login['return'];

            $params['resNum'] = $resNum;
            $params['amount'] = $amount;
            $params['redirectUrl'] = $redirectUrl;

            $getPurchaseParamsToSign = $payment->getPurchaseParamsToSign($params);


            $getPurchaseParamsToSign = $getPurchaseParamsToSign['return'];
            $uniqueId = $getPurchaseParamsToSign['uniqueId'];
            $dataToSign = $getPurchaseParamsToSign['dataToSign'];


///////////////////////state2

            $fm = fopen("msg.txt", "w");
            fwrite($fm, $dataToSign);
            fclose($fm);

            $fs = fopen("signed.txt", "w");
            fwrite($fs, "test");
            fclose($fs);

//
            openssl_pkcs7_sign(realpath("msg.txt"), realpath("signed.txt"), 'file://' . realpath('.') . '/ipgphp/' . "certs/Sarfejoo.pem",
                array('file://' . realpath('.') . '/ipgphp/' . "certs/Sarfejoo.pem", "Sarfejoo@222066"),
                array(), PKCS7_NOSIGS
            );

            $data = file_get_contents("signed.txt");

            $parts = explode("\n\n", $data, 2);
            $string = $parts[1];

            $parts1 = explode("\n\n", $string, 2);
            $signature = $parts1[0];

///////////////////////state3
            $login = $payment->login(username, password);
            $login = $login['return'];

            $params['signature'] = $signature;
            $params['login'] = $login;
            $params['resNum'] = $resNum;
            $params['amount'] = $amount;
            $params['uniqueId'] = $uniqueId;
            $params['redirectUrl'] = $redirectUrl;


            $generateSignedPurchaseToken = $payment->generateSignedPurchaseToken($params);
            $generateSignedPurchaseToken = $generateSignedPurchaseToken['return'];
            $generateSignedPurchaseToken = $generateSignedPurchaseToken['token'];
            $this->model_purchase_pu_transaction->UpdateTransactionGatewayId($transaction_id, $uniqueId);
            $this->model_purchase_pu_transaction->UpdateToken($transaction_id, $generateSignedPurchaseToken);
            $this->data['uniqueId'] = $uniqueId;
            $this->data['token'] = $generateSignedPurchaseToken;
            $this->data['language'] = "fa";
            $this->data['action'] = "https://pna.shaparak.ir/CardServices/tokenController";


            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/financial/subprofile_plan_confirm_redirect.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/financial/subprofile_plan_confirm_redirect.tpl';
            } else {
                $this->template = 'default/template/financial/subprofile_plan_confirm_redirect.tpl';
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
        } else {
            if (isset($this->request->get['plan_id'])) {
                $this->data['plan_id'] = $this->request->get['plan_id'];
                $plan_id = $this->request->get['plan_id'];
            } else {
                $this->redirect($this->url->link('account/account', '', 'SSL'));
            }
            if (isset($this->request->get['period_id'])) {
                $this->data['period_id'] = $this->request->get['period_id'];
                $period_id = $this->request->get['period_id'];
            } else {
                $this->redirect($this->url->link('account/account', '', 'SSL'));
            }
            if (isset($this->request->get['subprofile_id'])) {
                $this->data['subprofile_id'] = $this->request->get['subprofile_id'];
                $subprofile_id = $this->request->get['subprofile_id'];
            } else {
                $this->redirect($this->url->link('account/account', '', 'SSL'));
            }
            $this->load->model('financial/pu_feature_based_plan');
            $plan = $this->model_financial_pu_feature_based_plan->getPlan($plan_id);
            $period = $this->model_financial_pu_feature_based_plan->getPeriod($period_id);
            $monthlyPrice = $this->model_financial_pu_feature_based_plan->getPlanPeriodValue($plan_id, $period_id);
            $this->data['plan'] = $plan;
            $this->data['period'] = $period;
            $this->data['monthlyPrice'] = $monthlyPrice[0]['value'];


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

            $this->data['action'] = $this->url->link('financial/subprofile_plan/confirm', '', 'SSL');


            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/financial/subprofile_plan_confirm.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/financial/subprofile_plan_confirm.tpl';
            } else {
                $this->template = 'default/template/financial/subprofile_plan_confirm.tpl';
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
        if(isset($_POST['RefNum'])) {
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
            $token = $_POST['token'];
            $ref_number = $_POST['RefNum'];


            $this->load->model('purchase/pu_transaction');

            $this->load->model('financial/pu_subprofile_plan_subprofile_transaction');
            $this->load->model('financial/pu_subprofile_plan');
            $this->load->model('provider/pu_subprofile');
            $transaction_info = $this->model_purchase_pu_transaction->getTransactionByToken($token);
            $transaction_id = $transaction_info['id'];
            $payment = new Payment();

            $login = $payment->login(username, password);

            $login = $login['return'];

            $params['login'] = $login;
            $params['amount'] = $transaction_info['value']*10;
            $params['token'] = $_POST['token'];
            $params['RefNum'] = $_POST['RefNum'];

            $this->model_purchase_pu_transaction->UpdateStoreTrackingNumber($transaction_id, $_POST['RefNum']);
            $VerifyTrans = $payment->tokenPurchaseVerifyTransaction($params);

            $VerifyTrans = $VerifyTrans['return'];
            $VerifyTrans = $VerifyTrans['resultTotalAmount'];
            if ($VerifyTrans == $transaction_info['value'] * 10) {

                $this->model_purchase_pu_transaction->UpdateSuccessfulTransaction($transaction_id);
                $this->load->model('financial/pu_feature_based_plan');
                $history = $this->model_financial_pu_feature_based_plan->getHistoryByTransactionId($transaction_id);
                $plan = $this->model_financial_pu_feature_based_plan->getPlan($history['plan_id']);
                $period = $this->model_financial_pu_feature_based_plan->getPeriod($history['period_id']);
                $currentDate = new DateTime();
                $currentDate = $currentDate->getTimestamp();
                $expire_date = date('Y-m-d H:i:s', strtotime('+' . $period['duration'] . ' days' . date('Y-m-d H:i:s', $currentDate)));
                $this->model_provider_pu_subprofile->setSubprofileExpireDate($history['subprofile_id'], $expire_date, $history['plan_id'], $history['period_id']);
                $this->model_financial_pu_feature_based_plan->updateSuccessfulPayHistory($history['id']);
                $subprofile_info = $this->model_provider_pu_subprofile->GetSubprofileInfo($history['subprofile_id']);

                $features = $this->model_financial_pu_feature_based_plan->getFeatures();
                foreach ($features as $feature) {
                    $value = $this->model_financial_pu_feature_based_plan->getPlanFeatureValue($history['plan_id'], $feature['id']);
                    $this->model_financial_pu_feature_based_plan->addSubprofileFeatureValue($history['subprofile_id'], $feature['id'], $value['value']);
                }
                $logout = $payment->logout($login);
                if ($subprofile_info['address'] == '') {
                    $callbackUrl = $this->url->link('provider/subprofile/Add', '', 'SSL');
                    $callbackUrl .= '&id=' . $history['subprofile_id'];
                    $go = $callbackUrl;
                    header("Location: $go");
                    die();
                }
                $callbackUrl = $this->url->link('provider/subprofile', '', 'SSL');
                $go = $callbackUrl;
                header("Location: $go");
                die();
            } else {
                $logout = $payment->logout($login);
                $callbackUrl = $this->url->link('provider/subprofile', '', 'SSL');
                $go = $callbackUrl;
                header("Location: $go");
                die();
            }
            $callbackUrl = $this->url->link('provider/subprofile', '', 'SSL');
            $go = $callbackUrl;
            header("Location: $go");
            die();
        }else{
            $callbackUrl = $this->url->link('provider/subprofile', '', 'SSL');
            $go = $callbackUrl;
            header("Location: $go");
            die();
        }
    }

    protected function validate()
    {
        return true;
    }
}

?>