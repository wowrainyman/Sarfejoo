<?php
require_once "settings.php";
require_once "jdf.php";

/**
 * Created by PhpStorm.
 * User: Amir
 * Date: 10/9/2014
 * Time: 9:41 AM
 */
class ControllerAdAdvertising extends Controller
{
    private $error = array();
    public function index()
    {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('provider/profile', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        $this->load->model('ad/pu_advertising');
        $this->language->load('ad/advertising');
        $this->data += $this->language->load('ad/advertising');
        $date = new DateTime();
        $this->data['positions'] = $this->model_ad_pu_advertising->getPositions();
        $position_dates = array();
        $position_timestamps = array();
        $position_plans = array();
        foreach ($this->data['positions'] as $position) {
            if ($this->model_ad_pu_advertising->getPositionAvailableDate($position['id']) != 0) {
                $timestamp = strtotime($this->model_ad_pu_advertising->getPositionAvailableDate($position['id']));
                $position_timestamps[$position['id']] = $timestamp;
                $persian_info = jgetdate($timestamp, "", "Asia/Tehran", "fa");
                $position_dates[$position['id']] = $persian_info['year'] . '/' . $persian_info['mon'] . '/' . $persian_info['mday'];
                $position_info = $this->model_ad_pu_advertising->getPositionInfo($position['id']);
                $byclick_plans = $position_info['byclick_plans'];
                $byview_plans = $position_info['byview_plans'];
                $bytime_plans = $position_info['bytime_plans'];
                $byclick_plans = explode(",", $byclick_plans);
                $byview_plans = explode(",", $byview_plans);
                $bytime_plans = explode(",", $bytime_plans);
                foreach ($byclick_plans as $byclick_plan) {
                    if ($byclick_plan != 0 && $byclick_plan != '')
                        $position_plans[$position['id']]['byclick_plans'][] = $this->model_ad_pu_advertising->getClickPlanInfo($byclick_plan);
                }
                foreach ($byview_plans as $byview_plan) {
                    if ($byview_plan != 0 && $byview_plan != '')
                        $position_plans[$position['id']]['byview_plans'][] = $this->model_ad_pu_advertising->getViewPlanInfo($byview_plan);
                }
                foreach ($bytime_plans as $bytime_plan) {
                    if ($bytime_plan != 0 && $bytime_plan != '')
                        $position_plans[$position['id']]['bytime_plans'][] = $this->model_ad_pu_advertising->getTimePlanInfo($bytime_plan);
                }
            } else {
                $position_timestamps[$position['id']] = $date->getTimestamp();
                $position_dates[$position['id']] = 'امروز';
                $position_info = $this->model_ad_pu_advertising->getPositionInfo($position['id']);
                $byclick_plans = $position_info['byclick_plans'];
                $byview_plans = $position_info['byview_plans'];
                $bytime_plans = $position_info['bytime_plans'];
                $byclick_plans = explode(",", $byclick_plans);
                $byview_plans = explode(",", $byview_plans);
                $bytime_plans = explode(",", $bytime_plans);

                foreach ($byclick_plans as $byclick_plan) {
                    $position_plans[$position['id']]['byclick_plans'][] = $this->model_ad_pu_advertising->getClickPlanInfo($byclick_plan);
                }
                foreach ($byview_plans as $byview_plan) {
                    $position_plans[$position['id']]['byview_plans'][] = $this->model_ad_pu_advertising->getViewPlanInfo($byview_plan);
                }
                foreach ($bytime_plans as $bytime_plan) {
                    $position_plans[$position['id']]['bytime_plans'][] = $this->model_ad_pu_advertising->getTimePlanInfo($bytime_plan);
                }
            }
        }
        $this->data['position_plans'] = $position_plans;
        $this->data['position_dates'] = $position_dates;
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            print_r($this->request->post);
            if (isset($this->request->post['pages'])) {
                if (!empty ($_FILES)) {
                    $file = array();
                    $fileName = "ad_" . $date->getTimestamp();
                    $folderName = $this->customer->getId();
                    $subfolder = 'advertising';
                    $folderPlace = $GLOBALS['providers_scans_folder'];
                    $finalFilePath = $folderPlace . "/" . $folderName . "/" . $subfolder . "/" . $fileName;
                    if (!is_dir($folderPlace)) {
                        mkdir($folderPlace);
                    }
                    if (!is_dir($folderPlace . "/" . $folderName)) {
                        mkdir($folderPlace . "/" . $folderName);
                    }
                    if (!is_dir($folderPlace . "/" . $folderName . "/" . $subfolder)) {
                        mkdir($folderPlace . "/" . $folderName . "/" . $subfolder);
                    }
                    if (isset($_FILES['picture_90_728'])) {
                        $path = $_FILES['picture_90_728']['name'];
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        move_uploaded_file($_FILES ["picture_90_728"] ["tmp_name"], $finalFilePath . "_90_728" . "." . $ext);
                        $file['_90_728'] = $date->getTimestamp() . "_90_728" . '.' . $ext;
                    }
                    if (isset($_FILES['picture_60_468'])) {
                        $path = $_FILES['picture_60_468']['name'];
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        move_uploaded_file($_FILES ["picture_60_468"] ["tmp_name"], $finalFilePath . "_60_468" . "." . $ext);
                        $file['_60_468'] = $date->getTimestamp() . "_60_468" . '.' . $ext;
                    }
                    if (isset($_FILES['picture_240_120'])) {
                        $path = $_FILES['picture_240_120']['name'];
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        move_uploaded_file($_FILES ["picture_240_120"] ["tmp_name"], $finalFilePath . "_240_120" . "." . $ext);
                        $file['_240_120'] = $date->getTimestamp() . "_240_120" . '.' . $ext;
                    }
                    if (isset($_FILES['picture_125_125'])) {
                        $path = $_FILES['picture_125_125']['name'];
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        move_uploaded_file($_FILES ["picture_125_125"] ["tmp_name"], $finalFilePath . "_125_125" . "." . $ext);
                        $file['_125_125'] = $date->getTimestamp() . "_125_125" . '.' . $ext;
                    }
                    $file_90_728 = isset($file['_90_728']) ? $file['_90_728'] : '';
                    $file_60_468 = isset($file['_60_468']) ? $file['_60_468'] : '';
                    $file_240_120 = isset($file['_240_120']) ? $file['_240_120'] : '';
                    $file_125_125 = isset($file['_125_125']) ? $file['_125_125'] : '';
                    if ($this->request->post['pages'] == 'all') {
                        if (isset($this->request->post['all-pages-type'])) {
                            $all_pages_type = $this->request->post['all-pages-type'];
                            if ($all_pages_type == 'click') {
                                $plan_type = 1;
                                $plan_id = $this->request->post['all-pages-click-plan'];
                                $plan_info = $this->model_ad_pu_advertising->getClickPlanInfo($plan_id);
                                $real_price = (double)$plan_info['price'];
                                $this->load->model('purchase/pu_transaction');
                                $transaction_id = $this->model_purchase_pu_transaction->AddBuyTransaction($this->customer->getId(), $real_price, 1);
                                $added_id = $this->model_ad_pu_advertising->AddAdPlanCustomer($this->customer->getId(),
                                    $plan_type, $plan_id, $file_90_728, $file_60_468, $file_240_120, $file_125_125, $plan_info['clicks'], 0, date('Y-m-d H:i:s',
                                        $date->getTimestamp()), 0, $transaction_id, 0, $real_price, 0);
                                $this->redirect($this->url->link('financial/advertising_plan/confirm', '&id=' . $added_id, 'SSL'));
                            } elseif ($all_pages_type == 'view') {
                                $plan_type = 2;
                                $plan_id = $this->request->post['all-pages-view-plan'];
                                $plan_info = $this->model_ad_pu_advertising->getViewPlanInfo($plan_id);
                                $real_price = (double)$plan_info['price'];
                                $this->load->model('purchase/pu_transaction');
                                $transaction_id = $this->model_purchase_pu_transaction->AddBuyTransaction($this->customer->getId(), $real_price, 1);
                                $added_id = $this->model_ad_pu_advertising->AddAdPlanCustomer($this->customer->getId(),
                                    $plan_type, $plan_id, $file_90_728, $file_60_468, $file_240_120, $file_125_125, 0, $plan_info['views'], date('Y-m-d H:i:s',
                                        $date->getTimestamp()), 0, $transaction_id, 0, $real_price, 0);
                                $this->redirect($this->url->link('financial/advertising_plan/confirm', '&id=' . $added_id, 'SSL'));
                            } elseif ($all_pages_type == 'time') {
                                $plan_type = 3;
                                $plan_id = $this->request->post['all-pages-time-plan'];
                                $plan_info = $this->model_ad_pu_advertising->getTimePlanInfo($plan_id);
                                $real_price = (double)$plan_info['price'];
                                $this->load->model('purchase/pu_transaction');
                                $transaction_id = $this->model_purchase_pu_transaction->AddBuyTransaction($this->customer->getId(), $real_price, 1);
                                $end_date = date('Y-m-d H:i:s', strtotime('+' . $plan_info['times'] . ' days' . date('Y-m-d H:i:s', $date->getTimestamp())));
                                $added_id = $this->model_ad_pu_advertising->AddAdPlanCustomer($this->customer->getId(),
                                    $plan_type, $plan_id, $file_90_728, $file_60_468, $file_240_120, $file_125_125, 0, 0, date('Y-m-d H:i:s',
                                        $date->getTimestamp()), $end_date, $transaction_id, 0, $real_price, 0);
                                $this->redirect($this->url->link('financial/advertising_plan/confirm', '&id=' . $added_id, 'SSL'));
                            }
                        }
                    } elseif ($this->request->post['pages'] == 'special') {
                        if (isset($this->request->post['special-page-position']) &&
                            isset($this->request->post['special-pages-type'])
                        ) {
                            $special_page_position = $this->request->post['special-page-position'];
                            $special_pages_type = $this->request->post['special-pages-type'];
                            if ($special_pages_type == 'click') {
                                $plan_type = 1;
                                $plan_id = $this->request->post['special-pages-click-plan'];
                                $plan_info = $this->model_ad_pu_advertising->getClickPlanInfo($plan_id);
                                $position_info = $this->model_ad_pu_advertising->getPositionInfo($special_page_position);
                                $real_price = (double)$plan_info['price'] * (double)$position_info['factor'];
                                $this->load->model('purchase/pu_transaction');
                                $transaction_id = $this->model_purchase_pu_transaction->AddBuyTransaction($this->customer->getId(), $real_price, 1);
                                $added_id = $this->model_ad_pu_advertising->AddAdPlanCustomer($this->customer->getId(),
                                    $plan_type, $plan_id, $file_90_728, $file_60_468, $file_240_120, $file_125_125, $plan_info['clicks'], 0, date('Y-m-d H:i:s',
                                        $date->getTimestamp()), 0, $transaction_id, $special_page_position, $real_price, 0);
                                $this->redirect($this->url->link('financial/advertising_plan/confirm', '&id=' . $added_id, 'SSL'));
                            } elseif ($special_pages_type == 'view') {
                                $plan_type = 2;
                                $plan_id = $this->request->post['special-pages-view-plan'];
                                $plan_info = $this->model_ad_pu_advertising->getViewPlanInfo($plan_id);
                                $position_info = $this->model_ad_pu_advertising->getPositionInfo($special_page_position);
                                $real_price = (double)$plan_info['price'] * (double)$position_info['factor'];
                                $this->load->model('purchase/pu_transaction');
                                $transaction_id = $this->model_purchase_pu_transaction->AddBuyTransaction($this->customer->getId(), $real_price, 1);
                                $added_id = $this->model_ad_pu_advertising->AddAdPlanCustomer($this->customer->getId(),
                                    $plan_type, $plan_id, $file_90_728, $file_60_468, $file_240_120, $file_125_125, 0, $plan_info['views'], date('Y-m-d H:i:s',
                                        $date->getTimestamp()), 0, $transaction_id, $special_page_position, $real_price, 0);
                                $this->redirect($this->url->link('financial/advertising_plan/confirm', '&id=' . $added_id, 'SSL'));
                            } elseif ($special_pages_type == 'time') {
                                $plan_type = 3;
                                $plan_id = $this->request->post['special-pages-time-plan'];
                                $plan_info = $this->model_ad_pu_advertising->getTimePlanInfo($plan_id);
                                $position_info = $this->model_ad_pu_advertising->getPositionInfo($special_page_position);
                                $real_price = (double)$plan_info['price'] * (double)$position_info['factor'];
                                $this->load->model('purchase/pu_transaction');
                                $transaction_id = $this->model_purchase_pu_transaction->AddBuyTransaction($this->customer->getId(), $real_price, 1);
                                $available_timestamp = $position_timestamps[$special_page_position];
                                $end_date = date('Y-m-d H:i:s', strtotime('+' . $plan_info['times'] . ' days' . date('Y-m-d H:i:s', $available_timestamp)));
                                $added_id = $this->model_ad_pu_advertising->AddAdPlanCustomer($this->customer->getId(),
                                    $plan_type, $plan_id, $file_90_728, $file_60_468, $file_240_120, $file_125_125, 0, 0, date('Y-m-d H:i:s',
                                        $available_timestamp), $end_date, $transaction_id, $special_page_position, $real_price, 0);
                                $this->redirect($this->url->link('financial/advertising_plan/confirm', '&id=' . $added_id, 'SSL'));
                            }
                        }
                    }
                }
            }
            $this->redirect($this->url->link('ad/advertising_list', '', 'SSL'));
        }
        $this->data['click_plans'] = $this->model_ad_pu_advertising->getClickPlans();
        $this->data['view_plans'] = $this->model_ad_pu_advertising->getViewPlans();
        $this->data['time_plans'] = $this->model_ad_pu_advertising->getTimePlans();
        $this->data['back'] = $this->url->link('ad/advertising_list', '', 'SSL');
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
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/ad/advertising.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/ad/advertising.tpl';
        } else {
            $this->template = 'default/template/ad/advertising.tpl';
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