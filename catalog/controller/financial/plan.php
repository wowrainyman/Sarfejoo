<?php
require_once "settings.php";
/**
 * Created by PhpStorm.
 * User: Amir
 * Date: 10/9/2014
 * Time: 9:41 AM
 */
class ControllerFinancialPlan extends Controller
{
    private $error = array();
    public function index()
    {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('provider/profile', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        $this->language->load('financial/plan');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('financial/pu_plan');
        $this->load->model('financial/pu_invoice');
        $this->load->model('provider/pu_subprofile');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->session->data['success'] = $this->language->get('text_success');
            $type = $this->request->post['type'];
            $related_id = $this->request->post['related_id'];
            $customer_id = $this->customer->getId();
            $plan = $this->request->post['plan'];
            if (strpos($plan,"priodic-") !== false) {
                $plan = str_replace("priodic-", "", $plan);
                $plan_info = $this->model_financial_pu_plan->getPeriodicPlanInfo($plan);
                if($plan_info['price']){
                    $this->model_financial_pu_invoice->addInvoice($plan,0,$type,$related_id,$customer_id);
                }else{
                    $invoice = array();
                    $invoice['plan_periodic_id'] = $plan;
                    $invoice['plan_once_id'] = 0;
                    $invoice['type'] = $type;
                    $invoice['related_id'] = $related_id;
                    $invoice['customer_id'] = $customer_id;
                    if ($invoice['type'] == "subprofile") {
                        $subprofile_info = $this->model_provider_pu_subprofile->GetSubprofileByID($invoice['related_id']);
                        if ($invoice['plan_periodic_id'] != 0) {
                            $plan_info = $this->model_financial_pu_plan->getPeriodicPlanInfo($invoice['plan_periodic_id']);
                        } else {
                            $plan_info = $this->model_financial_pu_plan->getOncePlanInfo($invoice['plan_once_id']);
                        }
                        $invoice_infos[] = array(
                            'invoice' => $invoice,
                            'subprofile' => $subprofile_info,
                            'plan' => $plan_info
                        );
                    }
                    if ($invoice['type'] == "product") {
                        $product_info = $this->model_catalog_product->getProduct($invoice['related_id']);
                        if ($invoice['plan_periodic_id'] != 0) {
                            $plan_info = $this->model_financial_pu_plan->getPeriodicPlanInfo($invoice['plan_periodic_id']);
                        } else {
                            $plan_info = $this->model_financial_pu_plan->getOncePlanInfo($invoice['plan_once_id']);
                        }
                        $invoice_infos[] = array(
                            'invoice' => $invoice,
                            'product' => $product_info,
                            'plan' => $plan_info
                        );
                    }
                    $date = new DateTime();
                    foreach ($invoice_infos as $invoice_info) {
                        if (isset($invoice_info['subprofile'])) {
                            if (isset($invoice_info['plan']['duration'])) {
                                $data = array();
                                $data['plan_periodic_id'] = $invoice_info['plan']['id'];
                                $data['subprofile_id'] = $invoice_info['invoice']['related_id'];
                                $data['customer_id'] = $invoice_info['invoice']['customer_id'];
                                $data['transaction_id'] = 0;
                                $data['start_date'] = date('Y-m-d H:i:s', $date->getTimestamp());
                                $data['price'] = $invoice_info['plan']['price'];
                                $data['end_date'] = date('Y-m-d H:i:s', strtotime('+' . $invoice_info['plan']['duration'] . ' days' . date('Y-m-d H:i:s', $date->getTimestamp())));
                                $data['status'] = 1;
                                $this->model_financial_pu_plan->addPeriodicSubprofilePlan($data);
                            } else {
                                $data = array();
                                $data['plan_once_id'] = $invoice_info['plan']['id'];
                                $data['subprofile_id'] = $invoice_info['invoice']['related_id'];
                                $data['customer_id'] = $invoice_info['invoice']['customer_id'];
                                $data['transaction_id'] = 0;
                                $data['start_date'] = date('Y-m-d H:i:s', $date->getTimestamp());
                                $data['price'] = $invoice_info['plan']['price'];
                                $data['status'] = 1;
                                $this->model_financial_pu_plan->addOnceSubprofilePlan($data);
                            }
                            $this->model_provider_pu_subprofile->UpdateSubprofileStatus($invoice_info['invoice']['related_id'], 1);
                        } else if (isset($invoice_info['product'])) {
                            if (isset($invoice_info['plan']['duration'])) {
                                $data = array();
                                $data['plan_periodic_id'] = $invoice_info['plan']['id'];
                                $data['subprofile_product_id'] = $invoice_info['invoice']['related_id'];
                                $data['customer_id'] = $invoice_info['invoice']['customer_id'];
                                $data['transaction_id'] = 0;
                                $data['start_date'] = date('Y-m-d H:i:s', $date->getTimestamp());
                                $data['price'] = $invoice_info['plan']['price'];
                                $data['end_date'] = date('Y-m-d H:i:s', strtotime('+' . $invoice_info['plan']['duration'] . ' days' . date('Y-m-d H:i:s', $date->getTimestamp())));
                                $data['status'] = 1;
                                $this->model_financial_pu_plan->addPeriodicProductPlan($data);
                            } else {
                                $data = array();
                                $data['plan_once_id'] = $invoice_info['plan']['id'];
                                $data['subprofile_product_id'] = $invoice_info['invoice']['related_id'];
                                $data['customer_id'] = $invoice_info['invoice']['customer_id'];
                                $data['transaction_id'] = 0;
                                $data['start_date'] = date('Y-m-d H:i:s', $date->getTimestamp());
                                $data['price'] = $invoice_info['plan']['price'];
                                $data['status'] = 1;
                                $this->model_financial_pu_plan->addOnceProductPlan($data);
                            }
                            $this->model_provider_pu_subprofile->UpdateProductStatus($invoice_info['invoice']['related_id'], 1);
                        }
                    }
                }
            }elseif(strpos($plan,"once-") !== false){
                $plan = str_replace("once-", "", $plan);
                $plan_info = $this->model_financial_pu_plan->getOncePlanInfo($plan);
                if($plan_info['price']){
                    $this->model_financial_pu_invoice->addInvoice(0,$plan,$type,$related_id,$customer_id);
                }else{
                    $invoice = array();
                    $invoice['plan_periodic_id'] = 0;
                    $invoice['plan_once_id'] = $plan;
                    $invoice['type'] = $type;
                    $invoice['related_id'] = $related_id;
                    $invoice['customer_id'] = $customer_id;
                    if ($invoice['type'] == "subprofile") {
                        $subprofile_info = $this->model_provider_pu_subprofile->GetSubprofileByID($invoice['related_id']);
                        if ($invoice['plan_periodic_id'] != 0) {
                            $plan_info = $this->model_financial_pu_plan->getPeriodicPlanInfo($invoice['plan_periodic_id']);
                        } else {
                            $plan_info = $this->model_financial_pu_plan->getOncePlanInfo($invoice['plan_once_id']);
                        }
                        $invoice_infos[] = array(
                            'invoice' => $invoice,
                            'subprofile' => $subprofile_info,
                            'plan' => $plan_info
                        );
                    }
                    if ($invoice['type'] == "product") {
                        $product_info = $this->model_catalog_product->getProduct($invoice['related_id']);
                        if ($invoice['plan_periodic_id'] != 0) {
                            $plan_info = $this->model_financial_pu_plan->getPeriodicPlanInfo($invoice['plan_periodic_id']);
                        } else {
                            $plan_info = $this->model_financial_pu_plan->getOncePlanInfo($invoice['plan_once_id']);
                        }
                        $invoice_infos[] = array(
                            'invoice' => $invoice,
                            'product' => $product_info,
                            'plan' => $plan_info
                        );
                    }
                    $date = new DateTime();
                    foreach ($invoice_infos as $invoice_info) {
                        if (isset($invoice_info['subprofile'])) {
                            if (isset($invoice_info['plan']['duration'])) {
                                $data = array();
                                $data['plan_periodic_id'] = $invoice_info['plan']['id'];
                                $data['subprofile_id'] = $invoice_info['invoice']['related_id'];
                                $data['customer_id'] = $invoice_info['invoice']['customer_id'];
                                $data['transaction_id'] = 0;
                                $data['start_date'] = date('Y-m-d H:i:s', $date->getTimestamp());
                                $data['price'] = $invoice_info['plan']['price'];
                                $data['end_date'] = date('Y-m-d H:i:s', strtotime('+' . $invoice_info['plan']['duration'] . ' days' . date('Y-m-d H:i:s', $date->getTimestamp())));
                                $data['status'] = 1;
                                $this->model_financial_pu_plan->addPeriodicSubprofilePlan($data);
                            } else {
                                $data = array();
                                $data['plan_once_id'] = $invoice_info['plan']['id'];
                                $data['subprofile_id'] = $invoice_info['invoice']['related_id'];
                                $data['customer_id'] = $invoice_info['invoice']['customer_id'];
                                $data['transaction_id'] = 0;
                                $data['start_date'] = date('Y-m-d H:i:s', $date->getTimestamp());
                                $data['price'] = $invoice_info['plan']['price'];
                                $data['status'] = 1;
                                $this->model_provider_pu_subprofile->UpdateSubprofilePayedStatus($data['subprofile_id'],1);
                            }
                            //$this->model_provider_pu_subprofile->UpdateSubprofileStatus($invoice_info['invoice']['related_id'], 1);
                        } else if (isset($invoice_info['product'])) {
                            if (isset($invoice_info['plan']['duration'])) {
                                $data = array();
                                $data['plan_periodic_id'] = $invoice_info['plan']['id'];
                                $data['subprofile_product_id'] = $invoice_info['invoice']['related_id'];
                                $data['customer_id'] = $invoice_info['invoice']['customer_id'];
                                $data['transaction_id'] = 0;
                                $data['start_date'] = date('Y-m-d H:i:s', $date->getTimestamp());
                                $data['price'] = $invoice_info['plan']['price'];
                                $data['end_date'] = date('Y-m-d H:i:s', strtotime('+' . $invoice_info['plan']['duration'] . ' days' . date('Y-m-d H:i:s', $date->getTimestamp())));
                                $data['status'] = 1;
                                $this->model_financial_pu_plan->addPeriodicProductPlan($data);
                            } else {
                                $data = array();
                                $data['plan_once_id'] = $invoice_info['plan']['id'];
                                $data['subprofile_product_id'] = $invoice_info['invoice']['related_id'];
                                $data['customer_id'] = $invoice_info['invoice']['customer_id'];
                                $data['transaction_id'] = 0;
                                $data['start_date'] = date('Y-m-d H:i:s', $date->getTimestamp());
                                $data['price'] = $invoice_info['plan']['price'];
                                $data['status'] = 1;
                                $this->model_financial_pu_plan->addOnceProductPlan($data);
                            }
                            $this->model_provider_pu_subprofile->UpdateProductPayedStatus($invoice_info['invoice']['related_id'], 1);
                        }
                    }
                }
            }
            $this->redirect($this->url->link('account/account', '', 'SSL'));
        }
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
        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['text_profile'] = $this->language->get('text_profile');
        $this->data['entry_title'] = $this->language->get('entry_title');
        $this->data['entry_province'] = $this->language->get('entry_province');
        $this->data['entry_city'] = $this->language->get('entry_city');
        $this->data['entry_address'] = $this->language->get('entry_address');
        $this->data['entry_tel'] = $this->language->get('entry_tel');
        $this->data['entry_mobile'] = $this->language->get('entry_mobile');
        $this->data['entry_email'] = $this->language->get('entry_email');
        $this->data['entry_website'] = $this->language->get('entry_website');
        $this->data['entry_picture'] = $this->language->get('entry_picture');
        $this->data['entry_logo'] = $this->language->get('entry_logo');
        $this->data['entry_persontype'] = $this->language->get('entry_persontype');
        $this->data['entry_legalperson'] = $this->language->get('entry_legalperson');
        $this->data['entry_naturalperson'] = $this->language->get('entry_naturalperson');
        $this->data['entry_edit'] = $this->language->get('entry_edit');
        $this->data['entry_status'] = $this->language->get('entry_status');
        $this->data['button_add'] = $this->language->get('button_add');
        $this->data['button_continue'] = $this->language->get('button_continue');
        $this->data['button_back'] = $this->language->get('button_back');
        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }
        if (isset($this->request->get['type']) && isset($this->request->get['id'])) {
            $type = $this->request->get['type'];
            $id = $this->request->get['id'];
            $priodic_plans=$this->model_financial_pu_plan->getAllPeriodicPlans($type);
            $once_plans=$this->model_financial_pu_plan->getAllOncePlans($type);
        }
        else{
            $this->redirect($this->url->link('account/account', '', 'SSL'));
        }
        $this->data['action'] = $this->url->link('financial/plan', '', 'SSL');
        $this->data['priodic_plans'] = $priodic_plans;
        $this->data['once_plans'] = $once_plans;
        $this->data['type'] = $type;
        $this->data['related_id'] = $id;
        $this->data['back'] = $this->url->link('account/account', '', 'SSL');
        $this->data['edit'] = $this->url->link('provider/subprofile/Add', '', 'SSL');
        $this->data['add'] = $this->url->link('provider/subprofile/Add', '', 'SSL');
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/financial/plan.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/financial/plan.tpl';
        } else {
            $this->template = 'default/template/financial/plan.tpl';
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
    protected function validate()
    {
        return true;
    }
}

?>