<?php
/**
 * Created by PhpStorm.
 * User: Amir
 * Date: 11/5/2014
 * Time: 8:56 AM
 */
class ControllerProviderIdea extends Controller {
    private $error = array();

    public function index() {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('provider/profile', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        $this->language->load('provider/idea');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('provider/pu_idea');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $title = $this->request->post['title'];
            $content = $this->request->post['content'];
            $customer_id = $this->customer->getId();
            $id = $this->model_provider_pu_idea->insert($customer_id,$title,$content);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->redirect($this->url->link('account/account', '', 'SSL'));
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_account'),
            'href'      => $this->url->link('provider/profile', '', 'SSL'),
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
        $this->data['entry_content'] = $this->language->get('entry_content');


        $this->data['button_add'] = $this->language->get('button_add');
        $this->data['button_continue'] = $this->language->get('button_continue');
        $this->data['button_back'] = $this->language->get('button_back');


        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }



        $this->data['action'] = $this->url->link('provider/idea', '', 'SSL');

        $this->data['back'] = $this->url->link('account/account', '', 'SSL');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/provider/idea.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/provider/idea.tpl';
        } else {
            $this->template = 'default/template/provider/idea.tpl';
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

    protected function validate() {
        return true;
    }

}
?>