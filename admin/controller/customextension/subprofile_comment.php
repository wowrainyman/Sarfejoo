<?php 
class ControllerCustomextensionSubprofileComment extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('customextension/subprofile_comment');

		$this->document->setTitle($this->language->get('heading_title')); 

		$this->load->model('customextension/pu_subprofile_comment');
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            foreach ($this->request->post['approved'] as $key => $value) {
                $this->model_customextension_pu_subprofile_comment->UpdateApproved($key, $value);
            }
        }
		$this->getList();
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




        $this->data['settings'] = array();

        $data = array(
            'sort'  => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit' => $this->config->get('config_admin_limit')
        );

        $subprofile_comment_total = $this->model_customextension_pu_subprofile_comment->getTotalComment();

        $results = $this->model_customextension_pu_subprofile_comment->getComments($data);

        foreach ($results as $result) {


            $this->data['comments'][] = array(
                'id'              => $result['id'],
                'customer_name'  => $result['firstname'] . " " .$result['lastname'],
                'subprofile_name'    => $result['title'],
                'comment'    => $result['comment'],
                'approved'    => $result['approved']
            );
        }

		$this->data += $this->language->load('customextension/subprofile_comment');

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

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $subprofile_comment_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('customextension/subprofile_comment', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $this->data['form_action']=$this->url->link('customextension/subprofile_comment', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $this->data['pagination'] = $pagination->render();

        $this->data['sort'] = $sort;
        $this->data['order'] = $order;

        $this->template = 'customextension/subprofile_comment_list.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
	}


}
?>