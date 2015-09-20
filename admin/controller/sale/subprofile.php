<?php

class ControllerSaleSubprofile extends Controller
{
    private $error = array();
    public function index()
    {

        $this->language->load('sale/subprofile');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('sale/subprofile');
        $this->getList();
    }
    public function update()
    {
        $this->language->load('sale/subprofile');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('sale/subprofile');
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $this->model_sale_subprofile->EditSubprofile($this->request->post['id'], $this->request->post);

            if(isset($this->request->post['status_sms'])){
                $this->load->model('connection/sms');
                $subprofile_info = $this->model_sale_subprofile->GetSubprofileInfo($this->request->post['id']);
                if($subprofile_info['status_id'])
                    $this->model_connection_sms->sendSms($subprofile_info['mobile'],false,$this->language->get('status_ok'));
                else
                    $this->model_connection_sms->sendSms($subprofile_info['mobile'],false,$this->language->get('status_problem'));
            }

            if(isset($this->request->post['pay_sms'])){
                $this->load->model('connection/sms');
                $subprofile_info = $this->model_sale_subprofile->GetSubprofileInfo($this->request->post['id']);
                if($subprofile_info['is_payed'])
                    $this->model_connection_sms->sendSms($subprofile_info['mobile'],false,$this->language->get('payed_ok'));
                else
                    $this->model_connection_sms->sendSms($subprofile_info['mobile'],false,$this->language->get('payed_problem'));
            }
            if(isset($this->request->post['adminmessage_sms'])){
                $this->load->model('connection/sms');
                $subprofile_info = $this->model_sale_subprofile->GetSubprofileInfo($this->request->post['id']);
                $this->model_connection_sms->sendSms($subprofile_info['mobile'],false,$subprofile_info['adminmessage']);
            }

            if(isset($this->request->post['status_email'])){
                $this->load->model('connection/sms');
                $subprofile_info = $this->model_sale_subprofile->GetSubprofileInfo($this->request->post['id']);
                if($subprofile_info['status_id'])
                    $this->model_connection_email->sendEmail(null,$subprofile_info['mobile'],$subprofile_info['title'],$this->language->get('status_ok'));
                else
                    $this->model_connection_email->sendEmail(null,$subprofile_info['mobile'],$subprofile_info['title'],$this->language->get('status_problem'));
            }
            if(isset($this->request->post['pay_email'])){
                $this->load->model('connection/sms');
                $subprofile_info = $this->model_sale_subprofile->GetSubprofileInfo($this->request->post['id']);
                if($subprofile_info['is_payed'])
                    $this->model_connection_email->sendEmail(null,$subprofile_info['mobile'],$subprofile_info['title'],$this->language->get('payed_ok'));
                else
                    $this->model_connection_email->sendEmail(null,$subprofile_info['mobile'],$subprofile_info['title'],$this->language->get('payed_problem'));
            }
            if(isset($this->request->post['adminmessage_email'])){
                $this->load->model('connection/sms');
                $subprofile_info = $this->model_sale_subprofile->GetSubprofileInfo($this->request->post['id']);
                $this->model_connection_email->sendEmail(null,$subprofile_info['mobile'],$subprofile_info['title'],$subprofile_info['adminmessage']);
            }
            $this->session->data['success'] = $this->language->get('text_success');
            $url = '';
            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }
            if (isset($this->request->get['filter_email'])) {
                $url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
            }
            if (isset($this->request->get['filter_customer_group_id'])) {
                $url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
            }
            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status=' . $this->request->get['filter_status'];
            }
            if (isset($this->request->get['filter_approved'])) {
                $url .= '&filter_approved=' . $this->request->get['filter_approved'];
            }
            if (isset($this->request->get['filter_ip'])) {
                $url .= '&filter_ip=' . $this->request->get['filter_ip'];
            }
            if (isset($this->request->get['filter_date_added'])) {
                $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
            }
            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
            $this->redirect($this->url->link('sale/subprofile', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }else{
            $this->getForm();
        }
    }

    protected function getList()
    {

        if (isset($this->request->get['filter_id'])) {
            $filter_id = $this->request->get['filter_id'];
        } else {
            $filter_id = null;
        }
        if (isset($this->request->get['filter_name'])) {
            $filter_name = $this->request->get['filter_name'];
        } else {
            $filter_name = null;
        }

        if (isset($this->request->get['filter_customer_name'])) {
            $filter_customer_name = $this->request->get['filter_customer_name'];
        } else {
            $filter_customer_name = null;
        }

        if (isset($this->request->get['filter_group_id'])) {
            $filter_group_id = $this->request->get['filter_group_id'];
        } else {
            $filter_group_id = null;
        }

        if (isset($this->request->get['filter_city'])) {
            $filter_city = $this->request->get['filter_city'];
        } else {
            $filter_city = null;
        }


        if (isset($this->request->get['filter_expire_date'])) {
            $filter_expire_date = $this->request->get['filter_expire_date'];
        } else {
            $filter_expire_date = null;
        }

        if (isset($this->request->get['filter_rate_sarfejoo'])) {
            $filter_rate_sarfejoo = $this->request->get['filter_rate_sarfejoo'];
        } else {
            $filter_rate_sarfejoo = null;
        }

        if (isset($this->request->get['filter_product_count'])) {
            $filter_product_count = $this->request->get['filter_product_count'];
        } else {
            $filter_product_count = null;
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'name';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['filter_id'])) {
            $url .= '&filter_id=' . urlencode(html_entity_decode($this->request->get['filter_id'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_customer_name'])) {
            $url .= '&filter_customer_name=' . urlencode(html_entity_decode($this->request->get['filter_customer_name'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_group_id'])) {
            $url .= '&filter_group_id=' . $this->request->get['filter_group_id'];
        }

        if (isset($this->request->get['filter_city'])) {
            $url .= '&filter_city=' . $this->request->get['filter_city'];
        }

        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }

        if (isset($this->request->get['filter_expire_date'])) {
            $url .= '&filter_expire_date=' . $this->request->get['filter_expire_date'];
        }

        if (isset($this->request->get['filter_rate_sarfejoo'])) {
            $url .= '&filter_rate_sarfejoo=' . $this->request->get['filter_rate_sarfejoo'];
        }

        if (isset($this->request->get['filter_product_count'])) {
            $url .= '&filter_product_count=' . $this->request->get['filter_product_count'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }
        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );

        $this->data['approve'] = $this->url->link('sale/subprofile/approve', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $this->data['insert'] = $this->url->link('sale/subprofile/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $this->data['delete'] = $this->url->link('sale/subprofile/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $this->load->model('sale/customer');
        $this->data['customers'] = array();

        $data = array(
            'filter_id' => $filter_id,
            'filter_name' => $filter_name,
            'filter_customer_name' => $filter_customer_name,
            'filter_group_id' => $filter_group_id,
            'filter_city' => $filter_city,
            'filter_expire_date' => $filter_expire_date,
            'filter_rate_sarfejoo' => $filter_rate_sarfejoo,
            'filter_product_count' => $filter_product_count,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit' => $this->config->get('config_admin_limit')
        );


        $subprofile_total = $this->model_sale_subprofile->GetAllSubprofiles($data);

        $results = $this->model_sale_subprofile->GetSubprofiles($data);

        foreach ($results as $result) {
            $action = array();

            $action[] = array(
                'text' => $this->language->get('text_edit'),
                'href' => $this->url->link('sale/customer/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $result['customer_id'] . $url, 'SSL')
            );



            $expireDate = $this->model_sale_subprofile->GetSubprofileExpireDate($result['id']);
            $this->data['subprofiles'][] = array(
                'subprofile_id' => $result['id'],
                'name' => $result['title'],
                'username' => $result['username'],
                'group_id' => $result['group_id'],
                'website' => $result['website'],
                'city' => $result['city'],
                'email' => $result['email'],
                'rate' => $result['rate'],
                'status_id' => $result['status_id'],
                'is_payed' => $result['is_payed'],
                'expire_date' => $expireDate == 0 ? 'Unlimited' : $expireDate,
                'edit_link' => $this->url->link('sale/subprofile/update', 'token=' . $this->session->data['token'] . '&subprofile_id=' . $result['id'] . $url, 'SSL'),
                'product_link' => $this->url->link('sale/product', 'token=' . $this->session->data['token'] . '&subprofile_id=' . $result['id'] . $url, 'SSL'),
                'action' => $action
            );
        }


        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_yes'] = $this->language->get('text_yes');
        $this->data['text_no'] = $this->language->get('text_no');
        $this->data['text_select'] = $this->language->get('text_select');
        $this->data['text_default'] = $this->language->get('text_default');
        $this->data['text_no_results'] = $this->language->get('text_no_results');

        $this->data['column_id'] = $this->language->get('column_id');
        $this->data['column_name'] = $this->language->get('column_name');
        $this->data['column_customer_name'] = $this->language->get('column_customer_name');
        $this->data['column_group'] = $this->language->get('column_group_id');
        $this->data['column_website'] = $this->language->get('column_website');
        $this->data['column_city'] = $this->language->get('column_city');
        $this->data['column_email'] = $this->language->get('column_email');
        $this->data['column_status'] = $this->language->get('column_status');
        $this->data['column_is_payed'] = $this->language->get('column_is_payed');
        $this->data['column_expire_date'] = $this->language->get('column_expire_date');
        $this->data['column_rate_sarfejoo'] = $this->language->get('column_rate_sarfejoo');
        $this->data['column_product_count'] = $this->language->get('column_product_count');
        $this->data['column_login'] = $this->language->get('column_login');
        $this->data['column_rate'] = $this->language->get('column_rate');
        $this->data['column_action'] = $this->language->get('column_action');

        $this->data['button_approve'] = $this->language->get('button_approve');
        $this->data['button_insert'] = $this->language->get('button_insert');
        $this->data['button_delete'] = $this->language->get('button_delete');
        $this->data['button_filter'] = $this->language->get('button_filter');

        $this->data['token'] = $this->session->data['token'];

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }

        $url = '';

        if (isset($this->request->get['filter_id'])) {
            $url .= '&filter_id=' . urlencode(html_entity_decode($this->request->get['filter_id'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_customer_name'])) {
            $url .= '&filter_customer_name=' . urlencode(html_entity_decode($this->request->get['filter_customer_name'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_group_id'])) {
            $url .= '&filter_group_id=' . $this->request->get['filter_group_id'];
        }

        if (isset($this->request->get['filter_city'])) {
            $url .= '&filter_city=' . $this->request->get['filter_city'];
        }

        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }

        if (isset($this->request->get['filter_expire_date'])) {
            $url .= '&filter_expire_date=' . $this->request->get['filter_expire_date'];
        }

        if (isset($this->request->get['filter_rate_sarfejoo'])) {
            $url .= '&filter_rate_sarfejoo=' . $this->request->get['filter_rate_sarfejoo'];
        }

        if (isset($this->request->get['filter_product_count'])) {
            $url .= '&filter_product_count=' . $this->request->get['filter_product_count'];
        }

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $this->data['sort_id'] = $this->url->link('sale/subprofile', 'token=' . $this->session->data['token'] . '&sort=tab1.id' . $url, 'SSL');
        $this->data['sort_name'] = $this->url->link('sale/subprofile', 'token=' . $this->session->data['token'] . '&sort=tab1.title' . $url, 'SSL');
        $this->data['sort_customer_name'] = $this->url->link('sale/subprofile', 'token=' . $this->session->data['token'] . '&sort=tab2.firstname' . $url, 'SSL');
        $this->data['sort_group'] = $this->url->link('sale/subprofile', 'token=' . $this->session->data['token'] . '&sort=tab1.group_id' . $url, 'SSL');
        $this->data['sort_city'] = $this->url->link('sale/subprofile', 'token=' . $this->session->data['token'] . '&sort=tab1.city' . $url, 'SSL');
        $this->data['sort_email'] = $this->url->link('sale/subprofile', 'token=' . $this->session->data['token'] . '&sort=tab1.email' . $url, 'SSL');
        $this->data['sort_status'] = $this->url->link('sale/subprofile', 'token=' . $this->session->data['token'] . '&sort=tab1.status_id' . $url, 'SSL');
        $this->data['sort_is_payed'] = $this->url->link('sale/subprofile', 'token=' . $this->session->data['token'] . '&sort=tab1.is_payed' . $url, 'SSL');
        $this->data['sort_rate'] = $this->url->link('sale/subprofile', 'token=' . $this->session->data['token'] . '&sort=tab3.rate' . $url, 'SSL');
        $this->data['sort_expire_date'] = $this->url->link('sale/subprofile', 'token=' . $this->session->data['token'] . '&sort=expire_date' . $url, 'SSL');

        $url = '';

        if (isset($this->request->get['filter_id'])) {
            $url .= '&filter_id=' . urlencode(html_entity_decode($this->request->get['filter_id'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_customer_name'])) {
            $url .= '&filter_customer_name=' . urlencode(html_entity_decode($this->request->get['filter_customer_name'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_group_id'])) {
            $url .= '&filter_group_id=' . $this->request->get['filter_group_id'];
        }

        if (isset($this->request->get['filter_city'])) {
            $url .= '&filter_city=' . $this->request->get['filter_city'];
        }

        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }

        if (isset($this->request->get['filter_expire_date'])) {
            $url .= '&filter_expire_date=' . $this->request->get['filter_expire_date'];
        }

        if (isset($this->request->get['filter_rate_sarfejoo'])) {
            $url .= '&filter_rate_sarfejoo=' . $this->request->get['filter_rate_sarfejoo'];
        }

        if (isset($this->request->get['filter_product_count'])) {
            $url .= '&filter_product_count=' . $this->request->get['filter_product_count'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $subprofile_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('sale/subprofile', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $this->data['pagination'] = $pagination->render();

        $this->data['filter_id'] = $filter_id;
        $this->data['filter_name'] = $filter_name;
        $this->data['filter_customer_name'] = $filter_customer_name;
        $this->data['filter_group_id'] = $filter_group_id;
        $this->data['filter_city'] = $filter_city;
        $this->data['filter_rate_sarfejoo'] = $filter_rate_sarfejoo;
        $this->data['filter_product_count'] = $filter_product_count;


        $this->data['sort'] = $sort;
        $this->data['order'] = $order;

        $this->template = 'sale/subprofile_list.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    protected function getForm()
    {

        $this->data += $this->language->load('sale/subprofile');

        $this->data['token'] = $this->session->data['token'];

        if (isset($this->request->get['customer_id'])) {
            $this->data['customer_id'] = $this->request->get['customer_id'];
        } else {
            $this->data['customer_id'] = 0;
        }

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_email'])) {
            $url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_customer_group_id'])) {
            $url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
        }

        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }

        if (isset($this->request->get['filter_approved'])) {
            $url .= '&filter_approved=' . $this->request->get['filter_approved'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );

        $this->data['action'] = $this->url->link('sale/subprofile/update', 'token=' . $this->session->data['token'] . '&subprofile_id=' . $this->request->get['subprofile_id'] . $url, 'SSL');

        $this->data['cancel'] = $this->url->link('sale/subprofile', 'token=' . $this->session->data['token'] . $url, 'SSL');

        if (isset($this->request->get['subprofile_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $subprofile_info = $this->model_sale_subprofile->GetSubprofileInfo($this->request->get['subprofile_id']);
        }

        foreach($subprofile_info as $key => $value){
            if (isset($this->request->post[$key])) {
                $this->data[$key] = $this->request->post[$key];
            } elseif (!empty($subprofile_info)) {
                $this->data[$key] = $value;
            } else {
                $this->data[$key] = '';
            }
        }
        $this->data['allproducts'] = $this->model_sale_subprofile->GetProductsOfSubprofile($this->request->get['subprofile_id'], null);

        $this->template = 'sale/subprofile_form.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

}

?>