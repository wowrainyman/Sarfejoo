<?php

class ControllerFinancialPlansDiscount extends Controller
{
    private $error = array();

    public function index()
    {
        $this->language->load('financial/plans_discount');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('financial/pu_plans_discount');
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            foreach ($_POST['plan_id'] as $key => $value) {
                $this->model_financial_pu_plans_discount->UpdatePlanId($key, $value);
            }
            foreach ($_POST['name'] as $key => $value) {
                $this->model_financial_pu_plans_discount->UpdateName($key, $value);
            }
            foreach ($_POST['valid_until'] as $key => $value) {
                $this->model_financial_pu_plans_discount->UpdatePriceValidUntil($key, $value);
            }
            foreach ($_POST['value'] as $key => $value) {
                $this->model_financial_pu_plans_discount->UpdateValue($key, $value);
            }
            foreach ($_POST['description'] as $key => $value) {
                $this->model_financial_pu_plans_discount->UpdateDescription($key, $value);
            }
            foreach ($_POST['enabled'] as $key => $value) {
                $this->model_financial_pu_plans_discount->UpdateEnabled($key, $value);
            }
        }
        $this->getList();
    }

    public function insert()
    {
        $this->language->load('financial/plans_discount');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('financial/pu_plans_discount');

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $plan_id = $this->request->post['plan_id'];
            $name = $this->request->post['name'];
            $valid_until = $this->request->post['valid_until'];
            $value = $this->request->post['value'];
            $description = $this->request->post['description'];
            $enabled = $this->request->post['enabled'];
            $this->model_financial_pu_plans_discount->addPlanDiscount(
                $plan_id,
                $name,
                $valid_until,
                $value,
                $description,
                $enabled,
                $enabled);
            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_enabled'])) {
                $url .= '&filter_enabled=' . urlencode(html_entity_decode($this->request->get['filter_enabled'], ENT_QUOTES, 'UTF-8'));
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

            $this->redirect($this->url->link('financial/plans_discount', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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

        if (isset($this->request->get['filter_enabled'])) {
            $filter_enabled = $this->request->get['filter_enabled'];
        } else {
            $filter_enabled = null;
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

        if (isset($this->request->get['filter_enabled'])) {
            $url .= '&filter_enabled=' . urlencode(html_entity_decode($this->request->get['filter_enabled'], ENT_QUOTES, 'UTF-8'));
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
            'href' => $this->url->link('financial/plans_discount', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );

        $this->data['insert'] = $this->url->link('financial/plans_discount/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $this->data['plans_discount'] = array();

        $data = array(
            'filter_name' => $filter_name,
            'filter_enabled' => $filter_enabled,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit' => $this->config->get('config_admin_limit')
        );

        $this->load->model('tool/image');

        $plan_discount_total = $this->model_financial_pu_plans_discount->getTotalPlansDiscount($data);

        $plans_results = $this->model_financial_pu_plans_discount->getPlans($data);

        $results = $this->model_financial_pu_plans_discount->getPlansDiscount($data);

        $this->data['form_action'] = $this->url->link('financial/plans_discount', 'token=' . $this->session->data['token'] . $url, 'SSL');

        foreach ($plans_results as $result) {
            $this->data['plans'][] = array(
                'id' => $result['id'],
                'name' => $result['name']
            );

        }

        foreach ($results as $result) {
            $action = array();

            $action[] = array(
                'text' => $this->language->get('text_edit'),
                'href' => $this->url->link('financial/plans_discount/update', 'token=' . $this->session->data['token'] . '&feature_id=' . $url, 'SSL')
            );

            $this->data['plans_discount'][] = array(
                'id' => $result['id'],
                'plan_id' => $result['plan_id'],
                'name' => $result['name'],
                'valid_until' => $result['valid_until'],
                'value' => $result['value'],
                'description' => $result['description'],
                'enabled' => $result['enabled'],
                'action' => $action
            );
        }

        $this->data += $this->language->load('financial/plans_discount');

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

        $this->data['sort_name'] = $this->url->link('financial/plans_discount', 'token=' . $this->session->data['token'] . '&sort=tab1.name' . $url, 'SSL');
        $this->data['sort_valid_until'] = $this->url->link('financial/plans_discount', 'token=' . $this->session->data['token'] . '&sort=tab1.valid_until' . $url, 'SSL');
        $this->data['sort_value'] = $this->url->link('financial/plans_discount', 'token=' . $this->session->data['token'] . '&sort=tab1.value' . $url, 'SSL');
        $this->data['sort_enabled'] = $this->url->link('financial/plans_discount', 'token=' . $this->session->data['token'] . '&sort=tab1.enabled' . $url, 'SSL');

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }
        if (isset($this->request->get['filter_enabled'])) {
            $url .= '&filter_enabled=' . urlencode(html_entity_decode($this->request->get['filter_enabled'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $plan_discount_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('financial/plans_discount', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $this->data['pagination'] = $pagination->render();

        $this->data['filter_name'] = $filter_name;
        $this->data['filter_enabled'] = $filter_enabled;

        $this->data['sort'] = $sort;
        $this->data['order'] = $order;

        $this->template = 'financial/plans_discount_list.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    protected function getForm()
    {
        $this->data += $this->language->load('financial/plans_discount');

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        $this->data['action'] = $this->url->link('financial/plans_discount/insert', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['cancel'] = $this->url->link('financial/plans_discount', 'token=' . $this->session->data['token'], 'SSL');
        $this->load->model('design/layout');

        $this->data['layouts'] = $this->model_design_layout->getLayouts();

        $this->template = 'financial/plans_discount_form.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }
}

?>