<?php

class ControllerAdPlanBytime extends Controller
{
    private $error = array();

    public function index()
    {
        $this->language->load('ad/plan_bytime');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('ad/pu_plan_bytime');
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            foreach ($_POST['name'] as $key => $value) {
                $this->model_ad_pu_plan_bytime->UpdateName($key, $value);
            }
            foreach ($_POST['enable'] as $key => $value) {
                $this->model_ad_pu_plan_bytime->UpdateEnable($key, $value);
            }
            foreach ($_POST['sort_order'] as $key => $value) {
                $this->model_ad_pu_plan_bytime->UpdateSortOrder($key, $value);
            }
            foreach ($_POST['price'] as $key => $value) {
                $this->model_ad_pu_plan_bytime->UpdatePrice($key, $value);
            }
            foreach ($_POST['times'] as $key => $value) {
                $this->model_ad_pu_plan_bytime->Updatetimes($key, $value);
            }
        }
        $this->getList();
    }

    public function insert()
    {
        $this->language->load('ad/plan_bytime');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('ad/pu_plan_bytime');

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $name = $this->request->post['name'];
            $enable = $this->request->post['enable'];
            $sort_order = $this->request->post['sort_order'];
            $price = $this->request->post['price'];
            $times = $this->request->post['times'];
            $this->model_ad_pu_plan_bytime->addPlanBytime(
                $name,
                $enable,
                $sort_order,
                $price,
                $times);
            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
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

            $this->redirect($this->url->link('ad/plan_bytime', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        $this->getForm();
    }


    protected function getList()
    {
        if (isset($this->request->get['filter_name'])) {
            $filter_name = $this->request->get['filter_name'];
        } else {
            $filter_name = null;
        }
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'tab1.id';
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

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
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
            'href' => $this->url->link('ad/plan_bytime', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );

        $this->data['insert'] = $this->url->link('ad/plan_bytime/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $this->data['products'] = array();

        $data = array(
            'filter_name' => $filter_name,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit' => $this->config->get('config_admin_limit')
        );

        $this->load->model('tool/image');

        $plan_bytime_total = $this->model_ad_pu_plan_bytime->getTotalBytimePlans($data);

        $results = $this->model_ad_pu_plan_bytime->getBytimePlans($data);

        $this->data['form_action'] = $this->url->link('ad/plan_bytime', 'token=' . $this->session->data['token'] . $url, 'SSL');

        foreach ($results as $result) {

            $this->data['bytimes_plan'][] = array(
                'id' => $result['id'],
                'name' => $result['name'],
                'enable' => $result['enable'],
                'sort_order' => $result['sort_order'],
                'price' =>  $result['price'],
                'times' =>  $result['times']
            );
        }

        $this->data += $this->language->load('ad/plan_bytime');

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

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $this->data['sort_id'] = $this->url->link('ad/plan_bytime', 'token=' . $this->session->data['token'] . '&sort=tab1.id' . $url, 'SSL');
        $this->data['sort_name'] = $this->url->link('ad/plan_bytime', 'token=' . $this->session->data['token'] . '&sort=tab1.name' . $url, 'SSL');
        $this->data['sort_enable'] = $this->url->link('ad/plan_bytime', 'token=' . $this->session->data['token'] . '&sort=tab1.enable' . $url, 'SSL');
        $this->data['sort_sort_order'] = $this->url->link('ad/plan_bytime', 'token=' . $this->session->data['token'] . '&sort=tab1.sort_order' . $url, 'SSL');
        $this->data['sort_price'] = $this->url->link('ad/plan_bytime', 'token=' . $this->session->data['token'] . '&sort=tab1.price' . $url, 'SSL');
        $this->data['sort_times'] = $this->url->link('ad/plan_bytime', 'token=' . $this->session->data['token'] . '&sort=tab1.times' . $url, 'SSL');


        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }


        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $plan_bytime_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('ad/plan_bytime', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $this->data['pagination'] = $pagination->render();

        $this->data['filter_name'] = $filter_name;
        $this->data['sort'] = $sort;
        $this->data['order'] = $order;

        $this->template = 'ad/plan_bytime_list.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    protected function getForm()
    {
        $this->data += $this->language->load('ad/plan_bytime');

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        if (!isset($this->request->get['product_id'])) {
            $this->data['action'] = $this->url->link('ad/plan_bytime/insert', 'token=' . $this->session->data['token'], 'SSL');
        } else {
            $this->data['action'] = $this->url->link('ad/plan_bytime/update', 'token=' . $this->session->data['token'] . '&product_id=' . $this->request->get['product_id'], 'SSL');
        }

        $this->data['cancel'] = $this->url->link('ad/plan_bytime', 'token=' . $this->session->data['token'], 'SSL');
        $this->load->model('design/layout');

        $this->data['layouts'] = $this->model_design_layout->getLayouts();

        $this->template = 'ad/plan_bytime_form.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'catalog/product')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        foreach ($this->request->post['product_description'] as $language_id => $value) {
            if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 255)) {
                $this->error['name'][$language_id] = $this->language->get('error_name');
            }
        }

        if ((utf8_strlen($this->request->post['model']) < 1) || (utf8_strlen($this->request->post['model']) > 64)) {
            $this->error['model'] = $this->language->get('error_model');
        }

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_warning');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

}

?>