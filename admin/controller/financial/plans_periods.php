<?php

class ControllerFinancialPlansPeriods extends Controller
{
    private $error = array();

    public function index()
    {
        $this->language->load('financial/plans');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('financial/pu_plans');
        $this->getList();
    }
    public function update()
    {
        $this->load->model('financial/pu_plans_periods');
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $plan_id = $this->request->post['plan_id'];
            foreach ($_POST['value'] as $key => $value) {
                $this->model_financial_pu_plans_periods->updatePlansPeriodsValue($plan_id,$key,$value);
            }
            $this->redirect($this->url->link('financial/plans_periods', 'token=' . $this->session->data['token'], 'SSL'));
        }
        if (isset($this->request->get['plan_id'])) {
            $plan_id = $this->request->get['plan_id'];;
            $this->data["plan_id"] = $plan_id;
        } else {
            $this->redirect($this->url->link('financial/plans_periods', 'token=' . $this->session->data['token'], 'SSL'));
        }
        $this->language->load('financial/plans');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('financial/pu_plans');
        $this->load->model('financial/pu_periods');

        $results = $this->model_financial_pu_periods->getPeriods();
        foreach ($results as $result) {
            $value = $this->model_financial_pu_plans_periods->getPlansPeriodsValue($plan_id,$result['id']);
            $this->data['features'][] = array(
                'id' => $result['id'],
                'name' => $result['name'],
                'value' => $value
            );
        }
        $this->getForm();
    }
    protected function getForm()
    {
        $this->data += $this->language->load('financial/features');

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        $this->data['action'] = $this->url->link('financial/plans_periods/update', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['cancel'] = $this->url->link('financial/plans_periods', 'token=' . $this->session->data['token'], 'SSL');
        $this->load->model('design/layout');

        $this->data['layouts'] = $this->model_design_layout->getLayouts();

        $this->template = 'financial/plans_periods_form.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
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
            'href' => $this->url->link('financial/plans', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );

        $this->data['plans'] = array();

        $data = array(
            'filter_name' => $filter_name,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit' => $this->config->get('config_admin_limit')
        );

        $this->load->model('tool/image');

        $plan_total = $this->model_financial_pu_plans->getTotalPlans($data);

        $results = $this->model_financial_pu_plans->getPlans($data);

        foreach ($results as $result) {

            $this->data['plans'][] = array(
                'id' => $result['id'],
                'name' => $result['name'],
                'action' => $this->url->link('financial/plans_periods/update', 'token=' . $this->session->data['token'] . '&plan_id=' . $result['id'], 'SSL')
            );
        }

        $this->data += $this->language->load('financial/plans');

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
        if (isset($this->request->get['filter_enabled'])) {
            $url .= '&filter_enabled=' . urlencode(html_entity_decode($this->request->get['filter_enabled'], ENT_QUOTES, 'UTF-8'));
        }

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $this->data['sort_name'] = $this->url->link('financial/plans_periods', 'token=' . $this->session->data['token'] . '&sort=tab1.name' . $url, 'SSL');

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
        $pagination->total = $plan_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('financial/plans_periods', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $this->data['pagination'] = $pagination->render();

        $this->data['filter_name'] = $filter_name;

        $this->data['sort'] = $sort;
        $this->data['order'] = $order;

        $this->template = 'financial/plans_periods_list.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }


}

?>