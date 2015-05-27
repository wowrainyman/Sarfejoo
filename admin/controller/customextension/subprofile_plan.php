<?php

class ControllerCustomextensionSubprofilePlan extends Controller
{
    private $error = array();

    public function index()
    {
        $this->language->load('customextension/subprofile_plan');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('customextension/pu_subprofile_plan');
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            foreach ($_POST['name'] as $key => $value) {
                $this->model_customextension_pu_subprofile_plan->UpdateName($key, $value);
            }
            foreach ($_POST['price'] as $key => $value) {
                $this->model_customextension_pu_subprofile_plan->UpdatePrice($key, $value);
            }
            foreach ($_POST['duration'] as $key => $value) {
                $this->model_customextension_pu_subprofile_plan->UpdateDuration($key, $value);
            }
            foreach ($_POST['active'] as $key => $value) {
                $this->model_customextension_pu_subprofile_plan->UpdateActive($key, $value);
            }
            foreach ($_POST['sort_order'] as $key => $value) {
                $this->model_customextension_pu_subprofile_plan->UpdateSortOrder($key, $value);
            }
            foreach ($_POST['is_product'] as $key => $value) {
                $this->model_customextension_pu_subprofile_plan->UpdateIsProduct($key, $value);
            }
        }
        $this->getList();
    }

    public function insert()
    {
        $this->language->load('customextension/subprofile_plan');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('customextension/pu_subprofile_plan');

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $name = $this->request->post['name'];
            $duration = $this->request->post['duration'];
            $price = $this->request->post['price'];
            $active = $this->request->post['active'];
            $sort_order = $this->request->post['sort_order'];
            $is_product = $this->request->post['is_product'];
            $this->model_customextension_pu_subprofile_plan->addPlan(
                $name,
                $duration,
                $price,
                $active,
                $sort_order,
                $is_product);
            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_duration'])) {
                $url .= '&filter_duration=' . urlencode(html_entity_decode($this->request->get['filter_duration'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_price'])) {
                $url .= '&filter_price=' . urlencode(html_entity_decode($this->request->get['filter_price'], ENT_QUOTES, 'UTF-8'));
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

            $this->redirect($this->url->link('customextension/subprofile_plan', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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

        if (isset($this->request->get['filter_duration'])) {
            $filter_duration = $this->request->get['filter_duration'];
        } else {
            $filter_duration = null;
        }

        if (isset($this->request->get['filter_price'])) {
            $filter_price = $this->request->get['filter_price'];
        } else {
            $filter_price = null;
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

        if (isset($this->request->get['filter_duration'])) {
            $url .= '&filter_duration=' . urlencode(html_entity_decode($this->request->get['filter_duration'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_price'])) {
            $url .= '&filter_price=' . urlencode(html_entity_decode($this->request->get['filter_price'], ENT_QUOTES, 'UTF-8'));
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
            'href' => $this->url->link('customextension/subprofile_plan', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );

        $this->data['insert'] = $this->url->link('customextension/subprofile_plan/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $this->data['products'] = array();

        $data = array(
            'filter_name' => $filter_name,
            'filter_duration' => $filter_duration,
            'filter_price' => $filter_price,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit' => $this->config->get('config_admin_limit')
        );

        $this->load->model('tool/image');

        $plan_total = $this->model_customextension_pu_subprofile_plan->getTotalPlans($data);

        $results = $this->model_customextension_pu_subprofile_plan->getPlans($data);

        $this->data['form_action'] = $this->url->link('customextension/subprofile_plan', 'token=' . $this->session->data['token'] . $url, 'SSL');

        foreach ($results as $result) {
            $action = array();

            $action[] = array(
                'text' => $this->language->get('text_edit'),
                'href' => $this->url->link('customextension/subprofile_plan/update', 'token=' . $this->session->data['token'] . '&plan_id=' . $url, 'SSL')
            );

            $this->data['plans'][] = array(
                'id' => $result['id'],
                'name' => $result['name'],
                'duration' => $result['duration'],
                'price' =>  $result['price'],
                'active' =>  $result['active'],
                'sort_order' =>  $result['sort_order'],
                'is_product' =>  $result['is_product'],
                'action' => $action
            );
        }

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_no_results'] = $this->language->get('text_no_results');
        $this->data['text_image_manager'] = $this->language->get('text_image_manager');

        $this->data['column_id'] = $this->language->get('column_id');
        $this->data['column_name'] = $this->language->get('column_name');
        $this->data['column_duration'] = $this->language->get('column_duration');
        $this->data['column_price'] = $this->language->get('column_price');
        $this->data['column_active'] = $this->language->get('column_active');
        $this->data['column_sort_order'] = $this->language->get('column_sort_order');
        $this->data['column_is_product'] = $this->language->get('column_is_product');

        $this->data['button_insert'] = $this->language->get('button_insert');
        $this->data['button_filter'] = $this->language->get('button_filter');
        $this->data['text_edit'] = $this->language->get('text_edit');

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
        if (isset($this->request->get['filter_duration'])) {
            $url .= '&filter_duration=' . urlencode(html_entity_decode($this->request->get['filter_duration'], ENT_QUOTES, 'UTF-8'));
        }
        if (isset($this->request->get['filter_price'])) {
            $url .= '&filter_price=' . urlencode(html_entity_decode($this->request->get['filter_price'], ENT_QUOTES, 'UTF-8'));
        }

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $this->data['sort_name'] = $this->url->link('customextension/subprofile_plan', 'token=' . $this->session->data['token'] . '&sort=tab1.name' . $url, 'SSL');
        $this->data['sort_duration'] = $this->url->link('customextension/subprofile_plan', 'token=' . $this->session->data['token'] . '&sort=tab1.duration' . $url, 'SSL');
        $this->data['sort_price'] = $this->url->link('customextension/subprofile_plan', 'token=' . $this->session->data['token'] . '&sort=tab1.price' . $url, 'SSL');
        $this->data['sort_sort_order'] = $this->url->link('customextension/subprofile_plan', 'token=' . $this->session->data['token'] . '&sort=tab1.sort_order' . $url, 'SSL');

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }
        if (isset($this->request->get['sort_duration'])) {
            $url .= '&sort_duration=' . urlencode(html_entity_decode($this->request->get['sort_duration'], ENT_QUOTES, 'UTF-8'));
        }
        if (isset($this->request->get['sort_price'])) {
            $url .= '&sort_price=' . urlencode(html_entity_decode($this->request->get['sort_price'], ENT_QUOTES, 'UTF-8'));
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
        $pagination->url = $this->url->link('customextension/subprofile_plan', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $this->data['pagination'] = $pagination->render();

        $this->data['filter_name'] = $filter_name;
        $this->data['filter_duration'] = $filter_duration;
        $this->data['filter_price'] = $filter_price;

        $this->data['sort'] = $sort;
        $this->data['order'] = $order;

        $this->template = 'customextension/subprofile_plan_list.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }
    protected function getForm()
    {
        $this->data += $this->language->load('customextension/subprofile_plan');

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        $this->data['action'] = $this->url->link('customextension/subprofile_plan/insert', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['cancel'] = $this->url->link('customextension/subprofile_plan', 'token=' . $this->session->data['token'], 'SSL');
        $this->load->model('design/layout');

        $this->data['layouts'] = $this->model_design_layout->getLayouts();

        $this->template = 'customextension/subprofile_plan_form.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }
}

?>