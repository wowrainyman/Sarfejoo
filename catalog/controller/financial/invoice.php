<?php
require_once "settings.php";

/**
 * Created by PhpStorm.
 * User: Amir
 * Date: 10/9/2014
 * Time: 9:41 AM
 */
class ControllerFinancialInvoice extends Controller
{
    private $error = array();


    public function delete()
    {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('provider/profile', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        if (isset($this->request->get['id'])) {
            $id = $this->request->get['id'];
            $this->load->model('financial/pu_invoice');
            $this->model_financial_pu_invoice->delete($id);
        }
        $this->redirect($this->url->link('financial/invoice', '', 'SSL'));
    }

    public function index()
    {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('provider/profile', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }

        $this->load->model('payment/balance');
        $balance_info = $this->model_payment_balance->getBalance($this->customer->getId());
        $balance_value = $balance_info['balance'];
        if (isset($balance_value)) {
            $this->data['balance_value'] = $balance_value;
        } else {
            $this->data['balance_value'] = 0;
        }

        $this->language->load('financial/invoice');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('financial/pu_plan');
        $this->load->model('financial/pu_invoice');
        $this->load->model('provider/pu_subprofile');
        $this->load->model('catalog/product');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $total_price = 0;
            $customer_id = $this->customer->getId();
            $invoices = $this->model_financial_pu_invoice->getCustomerInvoices($customer_id);
            $invoice_infos = array();
            foreach ($invoices as $invoice) {
                if ($invoice['type'] == "subprofile") {
                    $subprofile_info = $this->model_provider_pu_subprofile->GetSubprofileByID($invoice['related_id']);
                    if ($invoice['plan_periodic_id'] != 0) {
                        $plan_info = $this->model_financial_pu_plan->getPeriodicPlanInfo($invoice['plan_periodic_id']);
                    } else {
                        $plan_info = $this->model_financial_pu_plan->getOncePlanInfo($invoice['plan_once_id']);
                    }
                    $total_price += $plan_info['price'];
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
                    $total_price += $plan_info['price'];
                    $invoice_infos[] = array(
                        'invoice' => $invoice,
                        'product' => $product_info,
                        'plan' => $plan_info
                    );
                }
            }
            if ($total_price > $balance_value) {
                $this->session->data['warning'] = $this->language->get('text_low_balance');
                $this->redirect($this->url->link('financial/invoice', '', 'SSL'));
            }
            $this->load->model('purchase/pu_transaction');
            $transaction_id = $this->model_purchase_pu_transaction->AddBuyTransaction($customer_id, $total_price, 1);
            $date = new DateTime();
            foreach ($invoice_infos as $invoice_info) {
                if (isset($invoice_info['subprofile'])) {
                    if (isset($invoice_info['plan']['duration'])) {
                        $data = array();
                        $data['plan_periodic_id'] = $invoice_info['plan']['id'];
                        $data['subprofile_id'] = $invoice_info['invoice']['related_id'];
                        $data['customer_id'] = $invoice_info['invoice']['customer_id'];
                        $data['transaction_id'] = $transaction_id;
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
                        $data['transaction_id'] = $transaction_id;
                        $data['start_date'] = date('Y-m-d H:i:s', $date->getTimestamp());
                        $data['price'] = $invoice_info['plan']['price'];
                        $data['status'] = 1;
                        $this->model_financial_pu_plan->addOnceSubprofilePlan($data);
                    }
                    $this->model_provider_pu_subprofile->UpdateSubprofilePayedStatus($invoice_info['invoice']['related_id'], 1);
                } else if (isset($invoice_info['product'])) {
                    if (isset($invoice_info['plan']['duration'])) {
                        $data = array();
                        $data['plan_periodic_id'] = $invoice_info['plan']['id'];
                        $data['subprofile_product_id'] = $invoice_info['invoice']['related_id'];
                        $data['customer_id'] = $invoice_info['invoice']['customer_id'];
                        $data['transaction_id'] = $transaction_id;
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
                        $data['transaction_id'] = $transaction_id;
                        $data['start_date'] = date('Y-m-d H:i:s', $date->getTimestamp());
                        $data['price'] = $invoice_info['plan']['price'];
                        $data['status'] = 1;
                        $this->model_financial_pu_plan->addOnceProductPlan($data);
                    }
                    $this->model_provider_pu_subprofile->UpdateProductPayedStatus($invoice_info['invoice']['related_id'], 1);
                }
                $this->model_financial_pu_invoice->PayedInvoice($invoice_info['invoice']['id'], date('Y-m-d H:i:s', $date->getTimestamp()));
                echo 'balance_value' . $balance_value . '<br />';
                echo 'total_price' . $total_price . '<br />';
            }
            $this->model_purchase_pu_transaction->UpdateCustomerBalance($customer_id, (int)$total_price * (-1));
            $this->session->data['success'] = $this->language->get('text_success');
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

        $this->load->model('provider/pu_subprofile');
        $this->load->model('catalog/product');

        $customer_id = $this->customer->getId();


        $invoices = $this->model_financial_pu_invoice->getCustomerInvoices($customer_id);
        $invoice_infos = array();
        foreach ($invoices as $invoice) {
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
        }
        $this->data['action'] = $this->url->link('financial/invoice', '', 'SSL');
        $this->data['deleteUrl'] = $this->url->link('financial/invoice/delete', '', 'SSL');
        $this->data['invoice_infos'] = $invoice_infos;
        $this->data['back'] = $this->url->link('account/account', '', 'SSL');
        $this->data['edit'] = $this->url->link('provider/subprofile/Add', '', 'SSL');
        $this->data['add'] = $this->url->link('provider/subprofile/Add', '', 'SSL');
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/financial/invoice.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/financial/invoice.tpl';
        } else {
            $this->template = 'default/template/financial/invoice.tpl';
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