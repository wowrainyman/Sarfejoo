<?php
class ControllerLinkRelayExternal extends Controller {

    private $error = array();
    public function index() {

# language
     $this->language->load('linkrelay/external');
     $this->data['text_header'] = $this->language->get('text_header');
     $this->data['text_dec'] = $this->language->get('text_dec');
     $this->data['text_back_site'] = $this->language->get('text_back_site');
     $this->data['text_remove_frame'] = $this->language->get('text_remove_frame');

# pass data to view
     if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
          $server = HTTPS_IMAGE;
     } else {
          $server = HTTP_IMAGE;
     }	

     if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
          $this->data['logo'] = $server . $this->config->get('config_logo');
     } else {
          $this->data['logo'] = '';
     }
    if (isset($this->request->get['return_id'])) {
        $return_id  =$this->request->get['return_id'];
    } else {
        $return_id = HTTP_SERVER;
    }

     $this->data['site_link'] = $this->url->link('product/product', '&product_id=' . $return_id);

     if (isset($this->request->get['url'])) {
          $relay_url  =$this->request->get['url'];
     } else {
          $relay_url = HTTP_SERVER;
     }



     if (isset($this->request->get['type'])) {
          $type = $this->request->get['type'];
     } else {
          $relay_url = HTTP_SERVER;
     }

     $this->data['relay_url']  = $relay_url;

# model
     $this->load->model('linkrelay/external');  
     switch ($type) {
          case 'website':
               $website = $relay_url;
               $this->model_linkrelay_external->UpdateSiteLinkViewCount($website);
          break;
          case 'buy':
               $buy_link = $relay_url;
               $this->model_linkrelay_external->UpdateBuyLinkViewCount($buy_link);
          break;
     } 

# render
     if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/linkrelay/external.tpl')) {
       $this->template = $this->config->get('config_template') . '/template/linkrelay/external.tpl';
     } else {
       $this->template = 'default/template/linkrelay/external.tpl';
     }
     $this->response->setOutput($this->render());
     }        
}
?>