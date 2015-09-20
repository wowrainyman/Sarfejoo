<?php
require_once "settings.php";

require_once "jdf.php";
/**
 * Created by PhpStorm.
 * User: Amir
 * Date: 10/9/2014
 * Time: 9:41 AM
 */
class ControllerProviderCustomerModules extends Controller
{
    private $error = array();
    public function index()
    {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('provider/profile', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        $this->language->load('provider/subprofile');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('provider/pu_subprofile');
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
        $this->data['entry_add_credit'] = $this->language->get('entry_add_credit');
        $this->data['entry_status'] = $this->language->get('entry_status');
        $this->data['entry_expire_date'] = $this->language->get('entry_expire_date');
        $this->data['button_add'] = $this->language->get('button_add');
        $this->data['button_continue'] = $this->language->get('button_continue');
        $this->data['button_back'] = $this->language->get('button_back');
        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }
        if (isset($this->error['firstname'])) {
            $this->data['error_firstname'] = $this->error['firstname'];
        } else {
            $this->data['error_firstname'] = '';
        }
        $this->data['action'] = $this->url->link('provider/subprofile', '', 'SSL');
        $this->load->model('provider/pu_status');
        $statusArr = array();
        if ($this->request->server['REQUEST_METHOD'] != 'POST') {
            $customer_info = $this->model_provider_pu_subprofile->GetCustomerSubProfiles($this->customer->getId());//from pu
            foreach ($customer_info as $c) {
                $statusArr[$c['id']] = $this->model_provider_pu_status->GetStatus($c['status_id']);
                $c_expire_date = $this->model_provider_pu_subprofile->getSubprofileExpireDate($c['id']);
                if($c_expire_date && strtotime($c_expire_date) > time()) {
                    $expire_date[$c['id']] = jdate("l - j F o",strtotime($c_expire_date));
                }else{
                    $expire_date[$c['id']] = "منقضی شده";
                }
            }
        }
        if (isset($customer_info)) {
            $this->data['customer_infos'] = $customer_info;
            $this->data['statusArr'] = $statusArr;
            $this->data['expire_date'] = $expire_date;
        }
        $this->data['back'] = $this->url->link('account/account', '', 'SSL');
        $this->data['edit'] = $this->url->link('provider/subprofile/Add', '', 'SSL');
        $this->data['add_modules'] = $this->url->link('financial/subprofile_plan', '', 'SSL');
        $this->data['add'] = $this->url->link('provider/subprofile/Add', '', 'SSL');
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/provider/customer_modules.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/provider/customer_modules.tpl';
        } else {
            $this->template = 'default/template/provider/customer_modules.tpl';
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
    protected function validate()
    {
        return true;
    }
}

?>