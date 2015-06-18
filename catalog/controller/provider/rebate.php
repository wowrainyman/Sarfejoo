<?php

/**
 * Created by PhpStorm.
 * User: Sarfejoo1
 * Date: 10/14/2014
 * Time: 1:33 PM
 */
class ControllerProviderRebate extends Controller
{
    private $error = array();
    public function index()
    {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('provider/profile', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        $this->language->load('provider/rebate_allsubprofiles');

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
        $this->data['entry_add_rebate'] = $this->language->get('entry_add_rebate');
        $this->data['entry_add_rebate_product'] = $this->language->get('entry_add_rebate_product');


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


        if ($this->request->server['REQUEST_METHOD'] != 'POST') {
            $customer_info = $this->model_provider_pu_subprofile->GetCustomerSubProfiles($this->customer->getId());//from pu
        }

        if (isset($customer_info)) {
            $this->data['customer_infos'] = $customer_info;
        }

        $this->data['add'] = $this->url->link('provider/rebate/listsubprofileproduct', '', 'SSL');
        $this->data['add2'] = $this->url->link('provider/rebate/submitrebate', '', 'SSL');

        $this->data['back'] = $this->url->link('account/account', '', 'SSL');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/provider/rebate_allsubprofiles.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/provider/rebate_allsubprofiles.tpl';
        } else {
            $this->template = 'default/template/provider/rebate_allsubprofiles.tpl';
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

    public function listsubprofileproduct()
    {

        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('provider/profile', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        $this->language->load('provider/rebate_listsubprofileproduct');

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
        $this->data['entry_name'] = $this->language->get('entry_name');
        $this->data['entry_yourprice'] = $this->language->get('entry_yourprice');
        $this->data['entry_minimumprice'] = $this->language->get('entry_minimumprice');
        $this->data['entry_maximumprice'] = $this->language->get('entry_maximumprice');
        $this->data['entry_averageprice'] = $this->language->get('entry_averageprice');
        $this->data['entry_add_rebate'] = $this->language->get('entry_add_rebate');


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

        $subprofileid = $this->request->get['id'];
        $productinfos = array();


        if ($this->request->server['REQUEST_METHOD'] != 'POST') {
            $allproducts = $this->model_provider_pu_subprofile->GetAllProductsOfSubprofile($subprofileid);
        }
        $this->load->model('catalog/product');
        if (isset($allproducts)) {
            $this->data['allproducts'] = $allproducts;

            foreach ($allproducts as $product) {
                $product_info = $this->model_catalog_product->getProduct($product['product_id']);
                $minprice = $this->model_provider_pu_subprofile->GetMinimumPriceOfProduct($product['product_id']);
                $maxprice = $this->model_provider_pu_subprofile->GetMaximumPriceOfProduct($product['product_id']);
                $productinfos[] = array(
                    'product_id' => $product['product_id'],
                    'yourprice' => $product['price'],
                    'averageprice' => $product_info['price'],
                    'name' => $product_info['name'],
                    'minimumprice' => $minprice['MIN(price)'],
                    'maximumprice' => $maxprice['MAX(price)'],
                );
            }
        }

        $this->data["subprofileid"] = $this->request->get['id'];

        $this->data["productinfos"] = $productinfos;

        $this->data['add'] = $this->url->link('provider/rebate/submitrebate', '', 'SSL');


        $this->data['back'] = $this->url->link('account/account', '', 'SSL');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/provider/rebate_listsubprofileproduct.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/provider/rebate_listsubprofileproduct.tpl';
        } else {
            $this->template = 'default/template/provider/rebate_listsubprofileproduct.tpl';
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

    public function submitrebate()
    {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('provider/profile', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        $this->language->load('provider/rebate_submitrebate');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('provider/pu_rebate');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->submitrebatevalidate()) {
            $product_id=$this->request->post["productid"];
            $subprofile_id=$this->request->post["subprofileid"];
            $title=$this->request->post["title"];
            $startdate=$this->request->post["startdate"];
            $enddate=$this->request->post["enddate"];
            $percent=$this->request->post["percent"];

            $data=array(
                "product_id"        =>$product_id,
                "subprofile_id"     =>$subprofile_id,
                "title"             =>$title,
                "startdate"         =>$startdate,
                "enddate"           =>$enddate,
                "percent"           =>$percent
             );
            //if rebate type = 0 add rebate for subprofile and if rebate type  =1 add rebate for a product
            $rebateType=0;
            if($product_id) {
                $rebateType=1;
            }
            $this->model_provider_pu_rebate->AddRebate($data,$rebateType);

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
        $this->data['entry_startdate'] = $this->language->get('entry_startdate');
        $this->data['entry_enddate'] = $this->language->get('entry_enddate');
        $this->data['entry_percent'] = $this->language->get('entry_percent');


        $this->data['button_add'] = $this->language->get('button_add');
        $this->data['button_continue'] = $this->language->get('button_continue');
        $this->data['button_back'] = $this->language->get('button_back');




        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        if (isset($this->error['title'])) {
            $this->data['error_title'] = $this->error['title'];
        } else {
            $this->data['error_title'] = '';
        }

        if (isset($this->error['startdate'])) {
            $this->data['error_startdate'] = $this->error['startdate'];
        } else {
            $this->data['error_startdate'] = '';
        }
        if (isset($this->error['enddate'])) {
            $this->data['error_enddate'] = $this->error['enddate'];
        } else {
            $this->data['error_enddate'] = '';
        }
        if (isset($this->error['percent'])) {
            $this->data['error_percent'] = $this->error['percent'];
        } else {
            $this->data['error_percent'] = '';
        }


        $this->data['title'] = '';
        $this->data['startdate'] = '';
        $this->data['enddate'] = '';
        $this->data['percent'] = '';

        $this->load->model('provider/pu_subprofile');
        if ($this->request->server['REQUEST_METHOD'] != 'POST') {
            $customer_info = $this->model_provider_pu_subprofile->GetCustomerSubProfiles($this->customer->getId());//from pu
        }

        if (isset($this->request->get["productid"])) {
            $this->data["productid"]=$this->request->get["productid"];
        }
        if (isset($this->request->get["subprofileid"])) {
            $this->data["subprofileid"]=$this->request->get["subprofileid"];
        }


        if (isset($customer_info)) {
            $this->data['customer_infos'] = $customer_info;
        }

        $this->data['action'] = $this->url->link('provider/rebate/submitrebate', '', 'SSL');

        $this->data['add'] = $this->url->link('provider/rebate/listsubprofileproduct', '', 'SSL');
        $this->data['add2'] = $this->url->link('provider/rebate/submitrebate', '', 'SSL');

        $this->data['back'] = $this->url->link('account/account', '', 'SSL');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/provider/rebate_submitrebate.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/provider/rebate_submitrebate.tpl';
        } else {
            $this->template = 'default/template/provider/rebate_submitrebate.tpl';
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

    protected function submitrebatevalidate() {
        if ((utf8_strlen($this->request->post['title']) < 1) || (utf8_strlen($this->request->post['title']) > 32)) {
            $this->error['title'] = $this->language->get('error_title');
        }

        if ($this->request->post['percent'] < 1 || $this->request->post['percent'] > 99) {
            $this->error['percent'] = $this->language->get('error_percent');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
}

?>