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

    public function invitedUser(){
        if (!$this->customer->isLogged()) {
            $this->session->data['warning'] = "ابتدا باید در وبسایت عضو شوید";
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        if (!isset($this->request->get['key'])) {
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        $this->load->model('information/pu_newsletter');
        $this->load->model('financial/pu_newsletter');
        $key = $this->request->get['key'];
        $result = $this->model_information_pu_newsletter->getCustomerNewsletterStatusByKey($key);
        if(isset($result)&&isset($result[0]['customer_id'])){
            $this->model_financial_pu_newsletter->UpdateSuccessfulNewsletter($this->customer->getId(),0,$result[0]['customer_id']);
            $this->redirect($this->url->link('information/newsletter', '', 'SSL'));
        }

    }

    public function index()
    {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('provider/profile', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        if(!$this->canUseNewsletter()){
            $this->session->data['redirect'] = $this->url->link('provider/profile', '', 'SSL');
            $this->redirect($this->url->link('financial/newsletter_plan/confirm', '', 'SSL'));
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
                $this->model_information_pu_newsletter->updateCustomerNewsletter(
                    $result[0]['id'], $email_plans, $sms_plans);
            } else {
                $this->model_information_pu_newsletter->addCustomerNewsletter(
                    $this->customer->getId(), $email_plans, $sms_plans);
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
        $result = $this->model_information_pu_newsletter->getCustomerNewsletterStatus($this->customer->getId());
        $customer_key = $result[0]['invitation_key'];
        $invitation_link = $this->url->link('information/newsletter/invitedUser','' , 'SSL');
        $invitation_link .= '&key=' . $customer_key;
        $this->data['invitation_link'] = $invitation_link;
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

    public function canUseNewsletter(){
        $this->load->model('information/pu_newsletter');
        $result = $this->model_information_pu_newsletter->getCustomerNewsletterStatus($this->customer->getId());
        if(isset($result)&&$result!=null&&$result){
            return true;
        }else{
            return false;
        }
    }

}

?>