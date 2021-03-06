<?php

class ControllerCustomextensionCustomerModules extends Controller
{
    private $error = array();

    public function index()
    {
        $this->language->load('customextension/customer_modules');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('customextension/pu_customer_modules');
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            foreach ($_POST['name'] as $key => $value) {
                $this->model_customextension_pu_customer_modules->UpdateName($key, $value);
            }
            foreach ($_POST['price'] as $key => $value) {
                $this->model_customextension_pu_customer_modules->UpdatePrice($key, $value);
            }
            foreach ($_POST['duration'] as $key => $value) {
                $this->model_customextension_pu_customer_modules->UpdateDuration($key, $value);
            }
            foreach ($_POST['description'] as $key => $value) {
                $this->model_customextension_pu_customer_modules->UpdateDescription($key, $value);
            }
            foreach ($_POST['sort_order'] as $key => $value) {
                $this->model_customextension_pu_customer_modules->UpdateSortOrder($key, $value);
            }
            foreach ($_POST['enabled'] as $key => $value) {
                $this->model_customextension_pu_customer_modules->UpdateEnabled($key, $value);
            }
        }
        $this->getList();
    }

    public function insert()
    {
        $this->language->load('customextension/customer_modules');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('customextension/pu_customer_modules');

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $name = $this->request->post['name'];
            $price = $this->request->post['price'];
            $duration = $this->request->post['duration'];
            $description = $this->request->post['description'];
            $enabled = $this->request->post['enabled'];
            $sort_order = $this->request->post['sort_order'];
            $this->model_customextension_pu_customer_modules->addModule(
                $name,
                $price,
                $duration,
                $description,
                $enabled,
                $sort_order);
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

            $this->redirect($this->url->link('customextension/customer_modules', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
            'href' => $this->url->link('customextension/customer_modules', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );

        $this->data['insert'] = $this->url->link('customextension/customer_modules/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $this->data['modules'] = array();

        $data = array(
            'filter_name' => $filter_name,
            'filter_enabled' => $filter_enabled,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit' => $this->config->get('config_admin_limit')
        );

        $this->load->model('tool/image');

        $module_total = $this->model_customextension_pu_customer_modules->getTotalModules($data);

        $results = $this->model_customextension_pu_customer_modules->getModules($data);

        $this->data['form_action'] = $this->url->link('customextension/customer_modules', 'token=' . $this->session->data['token'] . $url, 'SSL');

        foreach ($results as $result) {
            $action = array();

            $action[] = array(
                'text' => $this->language->get('text_edit'),
                'href' => $this->url->link('customextension/customer_modules/update', 'token=' . $this->session->data['token'] . '&feature_id=' . $url, 'SSL')
            );

            $this->data['modules'][] = array(
                'id' => $result['id'],
                'name' => $result['name'],
                'price' => $result['price'],
                'duration' => $result['duration'],
                'description' =>  $result['description'],
                'enabled' =>  $result['enabled'],
                'sort_order' =>  $result['sort_order'],
                'action' => $action
            );
        }

        $this->data += $this->language->load('customextension/customer_modules');

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

        $this->data['sort_name'] = $this->url->link('customextension/customer_modules', 'token=' . $this->session->data['token'] . '&sort=tab1.name' . $url, 'SSL');
        $this->data['sort_price'] = $this->url->link('customextension/customer_modules', 'token=' . $this->session->data['token'] . '&sort=tab1.price' . $url, 'SSL');
        $this->data['sort_enabled'] = $this->url->link('customextension/customer_modules', 'token=' . $this->session->data['token'] . '&sort=tab1.enabled' . $url, 'SSL');
        $this->data['sort_sort_order'] = $this->url->link('customextension/customer_modules', 'token=' . $this->session->data['token'] . '&sort=tab1.sort_order' . $url, 'SSL');

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
        $pagination->total = $module_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('customextension/customer_modules', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $this->data['pagination'] = $pagination->render();

        $this->data['filter_name'] = $filter_name;
        $this->data['filter_enabled'] = $filter_enabled;

        $this->data['sort'] = $sort;
        $this->data['order'] = $order;

        $this->template = 'customextension/customer_modules_list.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }
    protected function getForm()
    {
        $this->data += $this->language->load('customextension/customer_modules');

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        $this->data['action'] = $this->url->link('customextension/customer_modules/insert', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['cancel'] = $this->url->link('customextension/customer_modules', 'token=' . $this->session->data['token'], 'SSL');
        $this->load->model('design/layout');

        $this->data['layouts'] = $this->model_design_layout->getLayouts();

        $this->template = 'customextension/customer_modules_form.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }
}

?>