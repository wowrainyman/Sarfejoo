<?php 
class ControllerCustomextensionSetting extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('customextension/setting');

		$this->document->setTitle($this->language->get('heading_title')); 

		$this->load->model('customextension/pu_setting');
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            foreach ($_POST['value'] as $key => $value) {
                $this->model_customextension_pu_setting->UpdateValue($key, $value);
            }
            foreach ($_POST['key'] as $key => $value) {
                $this->model_customextension_pu_setting->UpdateKey($key, $value);
            }
        }
		$this->getList();
	}

	public function insert() {
		$this->language->load('customextension/setting');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('customextension/pu_setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $key=$this->request->post['key'];
            $value=$this->request->post['value'];
            $this->model_customextension_pu_setting->addSetting($key,$value);

			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('customextension/setting', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}



	protected function getList() {
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
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('customextension/attribute_value', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );

        $this->data['insert'] = $this->url->link('customextension/setting/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $this->data['settings'] = array();

        $data = array(
            'sort'  => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit' => $this->config->get('config_admin_limit')
        );

        $setting_total = $this->model_customextension_pu_setting->getTotalSettings();

        $results = $this->model_customextension_pu_setting->getSettings($data);

        foreach ($results as $result) {
            $action = array();

            $action[] = array(
                'text' => $this->language->get('text_edit'),
                'href' => $this->url->link('customextension/setting/update', 'token=' . $this->session->data['token']  . $url, 'SSL')
            );

            $this->data['settings'][] = array(
                'id'              => $result['id'],
                'key'  => $result['key'],
                'value'    => $result['value'],
                'action'          => $action
            );
        }

		$this->data += $this->language->load('customextension/setting');

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

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $this->data['sort_id'] = $this->url->link('customextension/setting', 'token=' . $this->session->data['token'] . '&sort=tab1.id' . $url, 'SSL');
        $this->data['sort_key'] = $this->url->link('customextension/setting', 'token=' . $this->session->data['token'] . '&sort=tab1.key' . $url, 'SSL');
        $this->data['sort_value'] = $this->url->link('customextension/setting', 'token=' . $this->session->data['token'] . '&sort=tab1.value' . $url, 'SSL');

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $setting_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('customextension/setting', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $this->data['form_action']=$this->url->link('customextension/setting', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $this->data['pagination'] = $pagination->render();

        $this->data['sort'] = $sort;
        $this->data['order'] = $order;

        $this->template = 'customextension/setting_list.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
	}

	protected function getForm() {
        $this->data += $this->language->load('customextension/setting');

		$url = '';

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
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);
        $this->data['action'] = $this->url->link('customextension/setting/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->load->model('design/layout');

		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		$this->template = 'customextension/setting_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
		$this->response->setOutput($this->render());
	}

}
?>