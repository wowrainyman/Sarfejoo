<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/11/2014
 * Time: 2:12 PM
 */

class ControllerModuleNewsletter extends Controller   {
    public function validateNewsletter() {
        $this->language->load('module/newsletter');

        $this->load->model('module/newsletter');

        $json = array();

        if ((strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
            $json['error']['warning'] = $this->language->get('error_email');
        } elseif (strlen($this->request->post['subject']) < 3) {
            $json['error']['warning'] = $this->language->get('error_message');
        }
        if(!$json) {
            if($this->model_module_newsletter->select($this->request->post)) {
                $json['error']['warning'] = $this->language->get('error_duplicate');
            }else{
                $this->model_module_newsletter->insert($this->request->post);
                $json['success'] = $this->language->get('text_subscribe');
            }
        }

        $this->response->setOutput(json_encode($json));
    }

} 