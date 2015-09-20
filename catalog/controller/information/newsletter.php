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

        $this->data['gmailclientid'] = '505281806589-shr3dvgg47ho13luhm25n8g59vfva2sc.apps.googleusercontent.com';
        $this->data['gmailclientsecret'] = '2nGItEpzAsC9pnGopuSyzShx';
        $this->data['gmailredirecturi'] = 'http://sarfejoo.com/index.php?route=information/newsletter&#38;gmail=true';
        $this->data['gmailmaxresults'] = 5000; // Number of mailid you want to display.

        $this->data['hotmailclient_id'] = '0000000048168780';
        $this->data['hotmailclient_secret'] = '34zRwo62appzMKA4QQ4dS575xVzsr2xA';
        $this->data['hotmailredirect_uri'] = 'http://sarfejoo.com/index.php?route=information/newsletter&#38;hotmail=true';

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

    public function campaign(){
        $this->load->model('information/pu_newsletter');
        $email = $this->request->post['email'];
        $result = $this->model_information_pu_newsletter->addFirstCampaignEmail($email);
        if(isset($result)&&$result!=null&&$result){
            return true;
        }else{
            return false;
        }
    }

    public function gmail(){
        $clientid = '505281806589-shr3dvgg47ho13luhm25n8g59vfva2sc.apps.googleusercontent.com';
        $clientsecret = '2nGItEpzAsC9pnGopuSyzShx';
        $redirecturi = 'http://sarfejoo.com/index.php?route=information/newsletter&gmail=true';
        $maxresults = 5000; // Number of mailid you want to display.
        echo "<a href='https://accounts.google.com/o/oauth2/auth?client_id=$clientid&redirect_uri=$redirecturi&scope=https://www.google.com/m8/feeds/&response_type=code'>دعوت از طریق گوگل</a>";
    }
    public function gmailresult(){
        $clientid = '505281806589-shr3dvgg47ho13luhm25n8g59vfva2sc.apps.googleusercontent.com';
        $clientsecret = '2nGItEpzAsC9pnGopuSyzShx';
        $redirecturi = 'http://sarfejoo.com/index.php?route=information/newsletter/gmailresult';
        $maxresults = 5000; // Number of mailid you want to display.
        $authcode = $_GET["code"];
        $fields=array(
            'code'=> urlencode($authcode),
            'client_id'=> urlencode($clientid),
            'client_secret'=> urlencode($clientsecret),
            'redirect_uri'=> urlencode($redirecturi),
            'grant_type'=> urlencode('authorization_code') );

        $fields_string = '';
        foreach($fields as $key=>$value){ $fields_string .= $key.'='.$value.'&'; }
        $fields_string = rtrim($fields_string,'&');

        $headers[0] = 'Content-Type: application/x-www-form-urlencoded';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, 'https://accounts.google.com/o/oauth2/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        $result = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($result);
        $accesstoken = $response->access_token;
        if( $accesstoken!='')
            $_SESSION['token']= $accesstoken;
        $result = file_get_contents('https://www.google.com/m8/feeds/contacts/default/full?max-results=10000&oauth_token='. $_SESSION['token']);

        $xml=  new SimpleXMLElement($result);
        $xml->registerXPathNamespace('gd', 'http://schemas.google.com/g/2005');
        $count=0;
        foreach($xml->entry as $entry)
        {
            $count++;
            $title = $entry->title;
            $subs = $entry->children('gd', true);
            $phone = $subs->phoneNumber;
            $email = $subs->attributes()->address;

            echo '('.$count.') -> '.$title.' -> '.$phone.' -> '.$email.'<br/>';
        }
    }

}

?>