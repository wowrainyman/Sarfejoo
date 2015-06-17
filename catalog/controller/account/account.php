<?php

class ControllerAccountAccount extends Controller
{
    public function index()
    {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        $this->language->load('account/account');
        $this->language->load('provider');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->data['breadcrumbs'] = array();
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home'),
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
        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['text_profile'] = $this->language->get('text_profile');
        $this->data['text_menu_profiles'] = $this->language->get('text_menu_profiles');
        $this->data['text_menu_sub_profiles'] = $this->language->get('text_menu_sub_profiles');
        $this->data['text_menu_add_products'] = $this->language->get('text_menu_add_products');
        $this->data['text_menu_set_prices'] = $this->language->get('text_menu_set_prices');
        $this->data['text_menu_set_discounts'] = $this->language->get('text_menu_set_discounts');
        $this->data['text_menu_pofiles_stat'] = $this->language->get('text_menu_pofiles_stat');
        $this->data['text_menu_inbox'] = $this->language->get('text_menu_inbox');
        $this->data['text_menu_bank'] = $this->language->get('text_menu_bank');
        $this->data['text_menu_advertisments'] = $this->language->get('text_menu_advertisments');
        $this->data['text_menu_namads'] = $this->language->get('text_menu_namads');
        $this->data['text_my_account'] = $this->language->get('text_my_account');
        $this->data['text_my_orders'] = $this->language->get('text_my_orders');
        $this->data['text_my_newsletter'] = $this->language->get('text_my_newsletter');
        $this->data['text_edit'] = $this->language->get('text_edit');
        $this->data['text_password'] = $this->language->get('text_password');
        $this->data['text_address'] = $this->language->get('text_address');
        $this->data['text_wishlist'] = $this->language->get('text_wishlist');
        $this->data['text_order'] = $this->language->get('text_order');
        $this->data['text_download'] = $this->language->get('text_download');
        $this->data['text_reward'] = $this->language->get('text_reward');
        $this->data['text_return'] = $this->language->get('text_return');
        $this->data['text_transaction'] = $this->language->get('text_transaction');
        $this->data['text_newsletter'] = $this->language->get('text_newsletter');
        $this->data['text_ad'] = $this->language->get('text_ad');
        $this->data['text_recurring'] = $this->language->get('text_recurring');
        $this->data['text_user_not_payed'] = $this->language->get('text_user_not_payed');
        $this->data['text_link'] = $this->language->get('text_link');
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