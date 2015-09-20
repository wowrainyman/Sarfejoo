<?php

class ControllerAccountAccount extends Controller
{
    public function index()
    {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        $this->data += $this->language->load('account/account');
        $this->data += $this->language->load('provider');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->data['breadcrumbs'] = array();
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->config->get('config_url'),
            'separator' => false
        );
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_account'),
            'href' => $this->url->link('account/account', '', 'SSL'),
            'separator' => $this->language->get('text_separator')
        );
        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }
        
         if (isset($this->request->get['p'])) {
            $this->data['success'] = ' حساب شما مبلغ ' . $this->request->get['p'] . ' تومان شارژ شد. ';
        } else {
            $this->data['success'] = '';
        }
       
        
        if ($this->customer->isLogged()) {
            $CustomerGroupId = $this->customer->getCustomerGroupId();
        } else {
            $CustomerGroupId = '0';
        }


        $this->data['Customer_Group_Id'] = $CustomerGroupId;

        $this->data['edit'] = $this->url->link('account/edit', '', 'SSL');
        $this->data['password'] = $this->url->link('account/password', '', 'SSL');
        $this->data['address'] = $this->url->link('account/address', '', 'SSL');
        $this->data['wishlist'] = $this->url->link('account/wishlist');
        $this->data['order'] = $this->url->link('account/order', '', 'SSL');
        $this->data['download'] = $this->url->link('account/download', '', 'SSL');
        $this->data['return'] = $this->url->link('account/return', '', 'SSL');
        $this->data['transaction'] = $this->url->link('account/transaction', '', 'SSL');
        $this->data['newsletter'] = $this->url->link('information/newsletter', '', 'SSL');
        $this->data['ad'] = $this->url->link('ad/advertising_list', '', 'SSL');
        $this->data['recurring'] = $this->url->link('account/recurring', '', 'SSL');
        $this->data['profile'] = $this->url->link('provider/profile', '', 'SSL');
        $this->data['subprofile'] = $this->url->link('provider/subprofile', '', 'SSL');
        $this->data['allsubprofiles'] = $this->url->link('provider/product/allsubprofiles', '', 'SSL');
        $this->data['price'] = $this->url->link('provider/price', '', 'SSL');
        $this->data['rebate'] = $this->url->link('provider/rebate', '', 'SSL');
        $this->data['etrust'] = $this->url->link('provider/etrust', '', 'SSL');
        $this->data['buy_plan_link'] = $this->url->link('financial/provider_plan', '', 'SSL');
        $this->data['customer_modules'] = $this->url->link('provider/customer_modules', '', 'SSL');
        if ($this->config->get('reward_status')) {
            $this->data['reward'] = $this->url->link('account/reward', '', 'SSL');
        } else {
            $this->data['reward'] = '';
        }
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/account.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/account/account.tpl';
        } else {
            $this->template = 'default/template/account/account.tpl';
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

?>