<?php

class ControllerAdAdInformation extends Controller
{
    private $error = array();

    public function index()
    {
        $this->language->load('ad/ad_information');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('ad/pu_ad_information');
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            foreach ($_POST['status_id'] as $key => $value) {
                $this->model_ad_pu_ad_information->UpdateStatusId($key, $value);
            }
            foreach ($_POST['periority'] as $key => $value) {
                $this->model_ad_pu_ad_information->UpdatePeriority($key, $value);
            }
        }
        $this->getList();
    }

    protected function getList()
    {
        if (isset($this->request->get['filter_customer_name'])) {
            $filter_customer_name = $this->request->get['filter_customer_name'];
        } else {
            $filter_customer_name = null;
        }

        if (isset($this->request->get['filter_plan_type'])) {
            $filter_plan_type = $this->request->get['filter_plan_type'];
        } else {
            $filter_plan_type = null;
        }

        if (isset($this->request->get['filter_position_id'])) {
            $filter_position_id = $this->request->get['filter_position_id'];
        } else {
            $filter_position_id = null;
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

        if (isset($this->request->get['filter_customer_name'])) {
            $url .= '&filter_customer_name=' . urlencode(html_entity_decode($this->request->get['filter_customer_name'], ENT_QUOTES, 'UTF-8'));
        }
        if (isset($this->request->get['filter_plan_type'])) {
            $url .= '&filter_plan_type=' . urlencode(html_entity_decode($this->request->get['filter_plan_type'], ENT_QUOTES, 'UTF-8'));
        }
        if (isset($this->request->get['filter_position_id'])) {
            $url .= '&filter_position_id=' . urlencode(html_entity_decode($this->request->get['filter_position_id'], ENT_QUOTES, 'UTF-8'));
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
            'href' => $this->url->link('ad/plan_byclick', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );

        $this->data['products'] = array();
        $this->data['form_action'] = $this->url->link('ad/ad_information', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $data = array(
            'filter_customer_name' => $filter_customer_name,
            'filter_plan_type' => $filter_plan_type,
            'filter_position_id' => $filter_position_id,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit' => $this->config->get('config_admin_limit')
        );
        $this->load->model('tool/image');

        $plan_customer_total = $this->model_ad_pu_ad_information->getTotalPlanCustomers($data);

        $results = $this->model_ad_pu_ad_information->getPlanCustomers($data);


        $this->data['plan_customers'] = $results;

        $this->data += $this->language->load('ad/plan_byclick');

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

        if (isset($this->request->get['filter_customer_name'])) {
            $url .= '&filter_customer_name=' . urlencode(html_entity_decode($this->request->get['filter_customer_name'], ENT_QUOTES, 'UTF-8'));
        }
        if (isset($this->request->get['filter_plan_type'])) {
            $url .= '&filter_plan_type=' . urlencode(html_entity_decode($this->request->get['filter_plan_type'], ENT_QUOTES, 'UTF-8'));
        }
        if (isset($this->request->get['filter_position_id'])) {
            $url .= '&filter_position_id=' . urlencode(html_entity_decode($this->request->get['filter_position_id'], ENT_QUOTES, 'UTF-8'));
        }

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $this->data['sort_id'] = $this->url->link('ad/ad_information', 'token=' . $this->session->data['token'] . '&sort=tab1.id' . $url, 'SSL');
        $this->data['sort_lastname'] = $this->url->link('ad/ad_information', 'token=' . $this->session->data['token'] . '&sort=tab2.lastname' . $url, 'SSL');
        $this->data['sort_plan_type'] = $this->url->link('ad/ad_information', 'token=' . $this->session->data['token'] . '&sort=tab1.plan_type' . $url, 'SSL');
        $this->data['sort_dest_click'] = $this->url->link('ad/ad_information', 'token=' . $this->session->data['token'] . '&sort=tab1.dest_click' . $url, 'SSL');
        $this->data['sort_current_click'] = $this->url->link('ad/ad_information', 'token=' . $this->session->data['token'] . '&sort=tab1.current_click' . $url, 'SSL');
        $this->data['sort_dest_view'] = $this->url->link('ad/ad_information', 'token=' . $this->session->data['token'] . '&sort=tab1.dest_view' . $url, 'SSL');
        $this->data['sort_current_view'] = $this->url->link('ad/ad_information', 'token=' . $this->session->data['token'] . '&sort=tab1.current_view' . $url, 'SSL');
        $this->data['sort_start_date'] = $this->url->link('ad/ad_information', 'token=' . $this->session->data['token'] . '&sort=tab1.start_date' . $url, 'SSL');
        $this->data['sort_end_date'] = $this->url->link('ad/ad_information', 'token=' . $this->session->data['token'] . '&sort=tab1.end_date' . $url, 'SSL');
        $this->data['sort_transaction_id'] = $this->url->link('ad/ad_information', 'token=' . $this->session->data['token'] . '&sort=tab1.transaction_id' . $url, 'SSL');
        $this->data['sort_status_id'] = $this->url->link('ad/ad_information', 'token=' . $this->session->data['token'] . '&sort=tab1.status_id' . $url, 'SSL');
        $this->data['sort_periority'] = $this->url->link('ad/ad_information', 'token=' . $this->session->data['token'] . '&sort=tab1.periority' . $url, 'SSL');
        $this->data['sort_position_id'] = $this->url->link('ad/ad_information', 'token=' . $this->session->data['token'] . '&sort=tab1.position_id' . $url, 'SSL');


        $url = '';

        if (isset($this->request->get['filter_customer_name'])) {
            $url .= '&filter_customer_name=' . urlencode(html_entity_decode($this->request->get['filter_customer_name'], ENT_QUOTES, 'UTF-8'));
        }
        if (isset($this->request->get['filter_plan_type'])) {
            $url .= '&filter_plan_type=' . urlencode(html_entity_decode($this->request->get['filter_plan_type'], ENT_QUOTES, 'UTF-8'));
        }
        if (isset($this->request->get['filter_position_id'])) {
            $url .= '&filter_position_id=' . urlencode(html_entity_decode($this->request->get['filter_position_id'], ENT_QUOTES, 'UTF-8'));
        }


        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $plan_customer_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('ad/ad_information', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $this->data['pagination'] = $pagination->render();

        $this->data['filter_customer_name'] = $filter_customer_name;
        $this->data['filter_plan_type'] = $filter_plan_type;
        $this->data['filter_position_id'] = $filter_position_id;

        $this->data['sort'] = $sort;
        $this->data['order'] = $order;

        $this->template = 'ad/ad_information_list.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }
}

?>