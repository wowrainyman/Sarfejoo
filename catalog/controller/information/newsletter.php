<?php
require_once "settings.php";

/**
 * Created by PhpStorm.
 * User: Amir
 * Date: 10/9/2014
 * Time: 9:41 AM
 */
class ControllerInformationNewsletter extends Controller
{
    private $error = array();

    public function index()
    {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('provider/profile', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        $this->load->model('information/pu_newsletter');

        $this->language->load('information/newsletter');
        $plans = array();
        $results = $this->model_information_pu_newsletter->getRootNewsletters();
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $email_plans = '';
            $sms_plans = '';
            if (isset($this->request->post['email-plan'])) {
                foreach ($this->request->post['email-plan'] as $key => $value) {
                    foreach ($value as $key2 => $value2) {
                        if ($key2 == 'main') {
                            $email_plans == '' ? $email_plans = $key : $email_plans .= ',' . $key;
                        } else {
                            $id = substr($key2, 4);
                            $email_plans == '' ? $email_plans = $id : $email_plans .= ',' . $id;
                        }
                    }
                }
            }
            if (isset($this->request->post['sms-plan'])) {
                foreach ($this->request->post['sms-plan'] as $key => $value) {
                    foreach ($value as $key2 => $value2) {
                        if ($key2 == 'main') {
                            $sms_plans == '' ? $sms_plans = $key : $sms_plans .= ',' . $key;
                        } else {
                            $id = substr($key2, 4);
                            $sms_plans == '' ? $sms_plans = $id : $sms_plans .= ',' . $id;
                        }
                    }
                }
            }
            $result = $this->model_information_pu_newsletter->getCustomerNewsletterInfo($this->customer->getId());
            if ($result) {
                $this->load->model('payment/balance');
                $balance_info = $this->model_payment_balance->getBalance($this->customer->getId());
                $balance_value = $balance_info['balance'];
                $this->load->model('setting/pu_setting');
                $sms_price_setting_info = $this->model_setting_pu_setting->getSettingValue('newsletter_sms_price');
                $email_price_setting_info = $this->model_setting_pu_setting->getSettingValue('newsletter_email_price');

                $sms_price = $sms_price_setting_info[0]['value'];
                $email_price = $email_price_setting_info[0]['value'];
                $total_price = 0;

                if ($email_plans != '' && !$result[0]['email_pay_status']) {
                    $hasEmail = true;
                    $total_price += $email_price;
                }
                if ($sms_plans != '' && !$result[0]['sms_pay_status']) {
                    $hasSms = true;
                    $total_price += $sms_price;
                }
                if ($balance_value < $total_price) {
                    $this->session->data['warning'] = $this->language->get('text_low_balance');
                    $this->redirect($this->url->link('information/newsletter', '', 'SSL'));
                }

                if($hasSms || $hasEmail){
                    $this->load->model('purchase/pu_transaction');
                    $transaction_id = $this->model_purchase_pu_transaction->AddBuyTransaction($this->customer->getId(), $total_price, 1);
                    $this->load->model('purchase/pu_transaction');
                    $this->model_purchase_pu_transaction->UpdateCustomerBalance($this->customer->getId(), (int)$total_price * (-1));
                    $this->model_information_pu_newsletter->updateCustomerNewsletterSecondTransaction($result[0]['id'],$transaction_id);
                    $this->model_information_pu_newsletter->updateCustomerNewsletterPrice($result[0]['id'],$result[0]['price']+$total_price);
                    if($hasSms){
                        $this->model_information_pu_newsletter->updateCustomerNewsletterSmsPay($result[0]['id'],1);
                    }else{
                        $this->model_information_pu_newsletter->updateCustomerNewsletterEmailPay($result[0]['id'],1);
                    }
                }
                $this->model_information_pu_newsletter->updateCustomerNewsletter(
                    $result[0]['id'], $email_plans, $sms_plans);
            } else {
                $this->load->model('payment/balance');
                $balance_info = $this->model_payment_balance->getBalance($this->customer->getId());
                $balance_value = $balance_info['balance'];

                $this->load->model('setting/pu_setting');
                $sms_price_setting_info = $this->model_setting_pu_setting->getSettingValue('newsletter_sms_price');
                $email_price_setting_info = $this->model_setting_pu_setting->getSettingValue('newsletter_email_price');

                $sms_price = $sms_price_setting_info[0]['value'];
                $email_price = $email_price_setting_info[0]['value'];

                $total_price = 0;
                $hasEmail = false;
                $hasSms = false;

                if ($email_plans != '') {
                    $hasEmail = true;
                    $total_price += $email_price;
                }
                if ($sms_plans != '') {
                    $hasSms = true;
                    $total_price += $sms_price;
                }

                if ($balance_value < $total_price) {
                    $this->session->data['warning'] = $this->language->get('text_low_balance');
                    $this->redirect($this->url->link('information/newsletter', '', 'SSL'));
                }


                $start_date = new DateTime();
                $end_date = date('Y-m-d H:i:s', strtotime('+365' . ' days' . date('Y-m-d H:i:s', $start_date->getTimestamp())));
                $this->load->model('purchase/pu_transaction');
                $transaction_id = $this->model_purchase_pu_transaction->AddBuyTransaction($this->customer->getId(), $total_price, 1);

                $this->model_information_pu_newsletter->addCustomerNewsletter(
                    $this->customer->getId(), $email_plans, $sms_plans, date('Y-m-d H:i:s',
                    $start_date->getTimestamp()), $end_date, $total_price, $hasSms, $hasEmail, $transaction_id);

                $this->load->model('purchase/pu_transaction');
                $this->model_purchase_pu_transaction->UpdateCustomerBalance($this->customer->getId(), (int)$total_price * (-1));
            }
        }
        foreach ($results as $result) {
            $subs = $this->model_information_pu_newsletter->getSubNewslettersByParent($result['id']);
            $plans[] = array(
                'id' => $result['id'],
                'name' => $result['name'],
                'parent_id' => $result['parent_id'],
                'sub_plans' => $subs
            );
        }
        $this->data['plans'] = $plans;

        $customer_newsletter_info = $this->model_information_pu_newsletter->getCustomerNewsletterInfo($this->customer->getId());

        $selected_sms_plans = isset($customer_newsletter_info[0]) ? $customer_newsletter_info[0]['sms_plans'] : '';
        $selected_email_plans = isset($customer_newsletter_info[0]) ? $customer_newsletter_info[0]['email_plans'] : '';

        $selected_sms_plans = explode(",", $selected_sms_plans);
        $selected_email_plans = explode(",", $selected_email_plans);

        $this->data['selected_sms_plans'] = $selected_sms_plans;
        $this->data['selected_email_plans'] = $selected_email_plans;

        $this->document->setTitle($this->language->get('heading_title'));
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
        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }
        if (isset($this->session->data['warning'])) {
            $this->data['warning'] = $this->session->data['warning'];
            unset($this->session->data['warning']);
        } else {
            $this->data['warning'] = '';
        }
        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/newsletter.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/information/newsletter.tpl';
        } else {
            $this->template = 'default/template/information/newsletter.tpl';
        }

        $this->data['button_continue'] = $this->language->get('button_continue');
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

    protected function validate()
    {
        return true;
    }

}

?>