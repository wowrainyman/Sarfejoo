<?php
require_once "settings.php";
require_once "jdf.php";

/**
 * Created by PhpStorm.
 * User: Amir
 * Date: 10/9/2014
 * Time: 9:41 AM
 */
class ControllerAdAdvertisingList extends Controller
{
    private $error = array();

    public function index()
    {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('provider/profile', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        $this->document->addStyle('catalog/view/javascript/magnify/css/magnify.css');
        $this->document->addScript('catalog/view/javascript/magnify/js/jquery.magnify.js');
        $this->load->model('ad/pu_advertising');
        $this->language->load('ad/advertising');

        $user_ads = $this->model_ad_pu_advertising->getUserAds($this->customer->getId());

        $this->data += $this->language->load('ad/advertising');

        foreach($user_ads as $user_ad){
            if($user_ad['plan_type'] == 1){
                $plan_type = 'بر اساس کلیک';
                $plan_info = $this->model_ad_pu_advertising->getClickPlanInfo($user_ad['plan_id']);
            }elseif($user_ad['plan_type'] == 2){
                $plan_type = 'بر اساس بازدید';
                $plan_info = $this->model_ad_pu_advertising->getViewPlanInfo($user_ad['plan_id']);
            }elseif($user_ad['plan_type'] == 3){
                $plan_type = 'بر اساس زمان';
                $plan_info = $this->model_ad_pu_advertising->getTimePlanInfo($user_ad['plan_id']);
            }

            if($user_ad['position_id'] != 0){
                $position_info = $this->model_ad_pu_advertising->getPositionInfo($user_ad['position_id']);
                $position_name = $position_info['name'];
            }else{
                $position_name = 'تمامی صفحات';
            }
            $this->data['user_ads'][]=array(
                'id'                =>$user_ad['id'],
                'customer_id'       =>$user_ad['customer_id'],
                'plan_type'         =>$plan_type,
                'plan_type_id'      =>$user_ad['plan_type'],
                'plan_name'         =>$plan_info['name'],
                'file_90_728'       =>$user_ad['file_90_728'],
                'file_60_468'       =>$user_ad['file_60_468'],
                'file_240_120'      =>$user_ad['file_240_120'],
                'file_125_125'      =>$user_ad['file_125_125'],
                'dest_click'        =>$user_ad['dest_click'],
                'current_click'     =>$user_ad['current_click'],
                'dest_view'         =>$user_ad['dest_view'],
                'current_view'      =>$user_ad['current_view'],
                'start_date'        =>$user_ad['start_date'],
                'end_date'          =>$user_ad['end_date'],
                'end_date'          =>$user_ad['end_date'],
                'status_id'         =>$user_ad['status_id'],
                'position_name'     =>$position_name
            );
        }

        $this->data['back'] = $this->url->link('account/account', '', 'SSL');
        $this->data['add'] = $this->url->link('ad/advertising', '', 'SSL');

        $this->document->setTitle($this->language->get('heading_title'));
        $this->data['breadcrumbs'] = array();
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home'),
            'separator' => false
        );
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_account'),
            'href' => $this->url->link('provider/profile', '', 'SSL'),
            'separator' => $this->language->get('text_separator')
        );
        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }
        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }
        if (isset($this->session->data['warning'])) {
            $this->data['warning'] = $this->session->data['warning'];
            unset($this->session->data['warning']);
        } else {
            $this->data['warning'] = '';
        }
        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/ad/advertising_list.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/ad/advertising_list.tpl';
        } else {
            $this->template = 'default/template/ad/advertising_list.tpl';
        }

        $this->data['button_continue'] = $this->language->get('button_continue');
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

    protected function validate()
    {
        return true;
    }

}

?>