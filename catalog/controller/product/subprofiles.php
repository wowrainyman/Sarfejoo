<?php

require_once "settings.php";

class ControllerProductSubprofiles extends Controller {
    public function index() {
    
        $this->language->load('product/subprofiles');
 
        $this->document->setTitle($this->language->get('heading_title')); 
 
        $this->data['breadcrumbs'] = array();
        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home'),
            'separator' => false
        );
        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('product/subprofiles'),
            'separator' => $this->language->get('text_separator')
        );
 
# Language
     $this->data['heading_title'] = $this->language->get('heading_title'); 
     $this->data['text_content']  = $this->language->get('text_content');
     $this->data['button_wishlist'] = $this->language->get('button_wishlist');
     $this->data['button_compare'] = $this->language->get('button_compare');
     $this->data['button_continue'] = $this->language->get('button_continue');
     $this->data['text_refine'] = $this->language->get('text_refine');
     $this->data['text_empty'] = $this->language->get('text_empty');			
     $this->data['text_quantity'] = $this->language->get('text_quantity');
     $this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
     $this->data['text_model'] = $this->language->get('text_model');
     $this->data['text_price'] = $this->language->get('text_price');
     $this->data['text_tax'] = $this->language->get('text_tax');
     $this->data['text_points'] = $this->language->get('text_points');
     $this->data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
     $this->data['text_display'] = $this->language->get('text_display');
     $this->data['text_list'] = $this->language->get('text_list');
     $this->data['text_grid'] = $this->language->get('text_grid');
     $this->data['text_sort'] = $this->language->get('text_sort');
     $this->data['text_limit'] = $this->language->get('text_limit');
     $this->data['price_avg_sarfejoo'] = $this->language->get('price_avg_sarfejoo');
     $this->data['text_without_price'] = $this->language->get('text_without_price');
			
# Gets
			
      if (isset($this->request->get['path'])) {
          $group_id  =$this->request->get['path'];
     } else {
          $group_id = 'a';
     }

     if (isset($this->request->get['limit'])) {
          $limit = $this->request->get['limit'];
     } else {
          $limit = $this->config->get('config_catalog_limit');
     }
# Models 
     $this->language->load('product/category');
     $this->load->model('provider/pu_subprofile');
     
     $this->data['limits'] = array();
     $limits = array_unique(array($this->config->get('config_catalog_limit'), 25, 50, 75, 100));

     sort($limits);

     foreach($limits as $value){
          $this->data['limits'][] = array(
               'text'  => $value,
               'value' => $value,
               'href'  => $this->url->link('product/subprofiles', 'path=' . $group_id . '&limit=' . $value)
          );
     }
			
     $subprofiles = $this->model_provider_pu_subprofile->GetAllSubprofileList($group_id, $limit);
     
     /* $subprofiles = $this->model_provider_pu_subprofile->GetSubprofileByID($subprofile_id);  */

       if (isset($subprofiles)) {
           $this->data['subprofiles'] = $subprofiles;
       }
 
# Fallback
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/subprofiles.tpl')) { 
            $this->template = $this->config->get('config_template') . '/template/product/subprofiles.tpl';
        } else {
            $this->template = 'default/template/product/subprofiles.tpl'; 
        }
 
# Children
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
}
?>