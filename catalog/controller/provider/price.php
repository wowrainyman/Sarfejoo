<?php

/**
 * Created by PhpStorm.
 * User: Sarfejoo1
 * Date: 10/14/2014
 * Time: 11:00 AM
 */
class ControllerProviderPrice extends Controller
{
    protected function isCustomerPayed($id){
        $this->load->model('account/customer');
        $expire_date = $this->model_account_customer->getCustomerExpireDate($id);
        if(!$expire_date)
            return false;
        $expire_date = strtotime($expire_date);
        $current_date = new DateTime();
        if($expire_date>date_timestamp_get($current_date))
        {
            return true;
        }else{
            return false;
        }
    }
    public function index()
    {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('provider/profile', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        if (!$this->isCustomerPayed($this->customer->getId()))
        {
            $this->redirect($this->url->link('account/account', '', 'SSL'));
        }
        $this->language->load('provider/price_allsubprofiles');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('provider/pu_subprofile');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

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


        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['text_price_profile'] = $this->language->get('text_price_profile');
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
        $this->data['entry_viewprices'] = $this->language->get('entry_viewprices');


        $this->data['button_add'] = $this->language->get('button_add');
        $this->data['button_continue'] = $this->language->get('button_continue');
        $this->data['button_back'] = $this->language->get('button_back');


        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        if (isset($this->error['firstname'])) {
            $this->data['error_firstname'] = $this->error['firstname'];
        } else {
            $this->data['error_firstname'] = '';
        }


        if ($this->request->server['REQUEST_METHOD'] != 'POST') {
            $customer_info = $this->model_provider_pu_subprofile->GetCustomerSubProfiles($this->customer->getId());//from pu
        }

        if (isset($customer_info)) {
            $this->data['customer_infos'] = $customer_info;
        }
        foreach ($customer_info as $c) {
            $c_expire_date = $this->model_provider_pu_subprofile->getSubprofileExpireDate($c['id']);
            if($c_expire_date && strtotime($c_expire_date) > time() || $c['financial_exception'] == 1) {
                $expire_date[$c['id']] = true;
            }else{
                $expire_date[$c['id']] = false;
            }
        }

        $this->data['expire_date'] = $expire_date;

        $this->data['add'] = $this->url->link('provider/price/listsubprofileproduct', '', 'SSL');


        $this->data['back'] = $this->url->link('account/account', '', 'SSL');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/provider/price_allsubprofiles.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/provider/price_allsubprofiles.tpl';
        } else {
            $this->template = 'default/template/provider/price_allsubprofiles.tpl';
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

    public function listsubprofileproduct()
    {
        if (!$this->isCustomerPayed($this->customer->getId()))
        {
            $this->redirect($this->url->link('account/account', '', 'SSL'));
        }
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('provider/profile', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }


        if (isset($this->request->get['limit'])) {
            $limit = $this->request->get['limit'];
        } else {
            $limit = $this->config->get('config_catalog_limit');
        }


        $this->language->load('provider/price_listsubprofileproduct');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('provider/pu_subprofile');
        $this->load->model('provider/pu_attribute');
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            foreach ($_POST['price'] as $key => $value) {
                $this->model_provider_pu_subprofile->UpdateProductPrice($key, $value);
            }
            foreach ($_POST['availability'] as $key => $value) {
                $this->model_provider_pu_subprofile->UpdateProductAvailability($key, $value);
            }
            foreach ($_POST['description'] as $key => $value) {
                $this->model_provider_pu_subprofile->UpdateProductDescription($key, $value);
            }
            foreach ($_POST['buy_link'] as $key => $value) {
                $this->model_provider_pu_subprofile->UpdateProductBuyLink($key, $value);
            }
            foreach ($_POST['attribute'] as $key => $value) {
                if (is_array($value)) {
                    $value = implode(",", $value);
                }
                echo $value;
                $this->model_provider_pu_attribute->UpdateCustomAttribute($key, $value);
            }

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
        $url = '';
        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }
        if (isset($this->request->get['limit'])) {
            $url .= '&limit=' . $this->request->get['limit'];
        }
        if (isset($this->request->get['id'])) {
            $url .= '&id=' . $this->request->get['id'];
        }


        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }
        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['text_profile'] = $this->language->get('text_profile');
        $this->data['text_limit'] = $this->language->get('text_limit');
        $this->data['entry_name'] = $this->language->get('entry_name');
        $this->data['entry_yourprice'] = $this->language->get('entry_yourprice');
        $this->data['entry_availability'] = $this->language->get('entry_availability');
        $this->data['entry_link'] = $this->language->get('entry_link');
        $this->data['entry_minimumprice'] = $this->language->get('entry_minimumprice');
        $this->data['entry_maximumprice'] = $this->language->get('entry_maximumprice');
        $this->data['entry_averageprice'] = $this->language->get('entry_averageprice');
        $this->data['entry_description'] = $this->language->get('entry_description');
        $this->data['entry_available'] = $this->language->get('entry_available');
        $this->data['entry_unavailable'] = $this->language->get('entry_unavailable');
        $this->data['entry_soon'] = $this->language->get('entry_soon');
        $this->data['button_add'] = $this->language->get('button_add');
        $this->data['button_continue'] = $this->language->get('button_continue');
        $this->data['button_back'] = $this->language->get('button_back');


        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        if (isset($this->error['firstname'])) {
            $this->data['error_firstname'] = $this->error['firstname'];
        } else {
            $this->data['error_firstname'] = '';
        }


        $subprofileid = $this->request->get['id'];
        $c_expire_date = $this->model_provider_pu_subprofile->getSubprofileExpireDate($subprofileid);
        $sub_info = $this->model_provider_pu_subprofile->GetSubprofileInfo($subprofileid);
        if($c_expire_date && strtotime($c_expire_date) > time() || $sub_info['financial_exception'] == 1) {
        }else{
            $this->redirect($this->url->link('account/account', '', 'SSL'));
        }
        $productinfos = array();
        $data = array(
            'start' => ($page - 1) * $limit,
            'limit' => $limit
        );
        $total_products_res = $this->model_provider_pu_subprofile->GetCountProductsOfSubprofile($subprofileid);
        foreach ($total_products_res as $product) {
            $total_products = $product['total'];
            break;
        }
        if ($this->request->server['REQUEST_METHOD'] != 'POST') {
            $allproducts = $this->model_provider_pu_subprofile->GetProductsOfSubprofile($subprofileid, $data);
        }
        $this->load->model('catalog/product');
        $this->load->model('tool/image');
        $this->load->model('provider/pu_attribute');
        $this->load->model('catalog/category');
        $this->load->model('customextension/pu_attribute');
        if (isset($allproducts)) {
            $this->data['allproducts'] = $allproducts;
            $attributes = array();
            foreach ($allproducts as $product) {
                $customAttributes = null;
                $blockAttributesId = '';
                if ($this->model_provider_pu_attribute->isCustomProduct($product['product_id'])) {
                    $categories = $this->model_catalog_product->getCategories($product['product_id']);
                    $categoryid = $categories[0]['category_id'];
                    $category_info = $this->model_catalog_category->getCategory($categoryid);
                    $parent = $this->model_catalog_category->getCategory($category_info['parent_id']);
                    $parentId = $parent['category_id'];
                    $sortOrder = $parent['sort_order'];
                    $num_length = strlen((string)$sortOrder);
                    if ($parentId == 60) {
                        $destCategory = $categoryid;
                    } else {
                        $destCategory = $parentId;
                    }
                    while ($num_length > 2) {
                        $category_info = $this->model_catalog_category->getCategory($parentId);
                        $parent = $this->model_catalog_category->getCategory($category_info['parent_id']);
                        $parentId = $parent['category_id'];
                        $sortOrder = $parent['sort_order'];
                        $num_length = strlen((string)$sortOrder);
                        $destCategory = $parentId;
                    }
                    $attribute_infos = array();
                    $allCustomAttributes = $this->model_provider_pu_attribute->getCustomAttributes($destCategory);
                    foreach ($allCustomAttributes as $cAttribute) {
                        $attribute_infos[] = $this->model_provider_pu_attribute->getCustomAttribute($cAttribute['attribute_id']);
                    }
                    $attributes = array();
                    foreach ($attribute_infos as $attribute_info) {
                        if ($attribute_info) {
                            $value_infos = $this->model_provider_pu_attribute->getCustomAttributeValues($attribute_info['attribute_id']);
                            $values = array();
                            foreach ($value_infos as $value_info) {
                                $values[] = array(
                                    'id' => $value_info['id'],
                                    'value' => $value_info['value']
                                );
                            }
                            if ($this->model_customextension_pu_attribute->isBlockAttribute($attribute_info['attribute_id'])) {
                                $isBlockAttribute = true;
                                if ($blockAttributesId == '') {
                                    $blockAttributesId = $attribute_info['attribute_id'];
                                } else {
                                    $blockAttributesId .= ',' . $attribute_info['attribute_id'];
                                }
                            }
                            $selected_value = $this->model_provider_pu_attribute->getAttributeValue($subprofileid, $product['product_id'], $attribute_info['attribute_id']);
                            $attributes[] = array(
                                'attribute_id' => $attribute_info['attribute_id'],
                                'name' => $attribute_info['name'],
                                'type' => $attribute_info['type'],
                                'class' => $attribute_info['class'],
                                'values' => $values,
                                'selected_value' => $selected_value
                            );
                        }
                    }
                    $customAttributes = $attributes;
                }


                $product_info = $this->model_catalog_product->getProduct($product['product_id']);
                $minprice = $this->model_provider_pu_subprofile->GetMinimumPriceOfProduct($product['product_id']);
                $maxprice = $this->model_provider_pu_subprofile->GetMaximumPriceOfProduct($product['product_id']);
                $price_avg = $this->model_provider_pu_subprofile->GetAveragepricePriceOfProduct($product['product_id']);


                $productinfos[] = array(
                    'id' => $product['id'],
                    'name' => $product_info['name'],
                    'description' => $product['description'],
                    'image' => $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height')),
                    'availability' => $product['availability'],
                    'product_id' => $product['product_id'],
                    'yourprice' => $product['price'],
                    'buy_link' => $product['buy_link'],
                    'averageprice' => $price_avg,
                    'minimumprice' => $minprice['MIN(price)'],
                    'maximumprice' => $maxprice['MAX(price)'],
                    'customAttributes' => $customAttributes
                );
            }
        }

        $this->data['limits'] = array();

        $limits = array_unique(array($this->config->get('config_catalog_limit'), 25, 50, 75, 100));

        sort($limits);

        foreach ($limits as $value) {
            $this->data['limits'][] = array(
                'text' => $value,
                'value' => $value,
                'href' => $this->url->link('provider/price/listsubprofileproduct', $url . '&limit=' . $value)
            );
        }

        $this->data["productinfos"] = $productinfos;

        $pagination = new Pagination();
        $pagination->total = $total_products;
        $pagination->page = $page;
        $pagination->limit = $limit;
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('provider/price/listsubprofileproduct', $url . '&page={page}');

        $this->data['limit'] = $limit;

        $this->data['pagination'] = $pagination->render();

        $this->data['add'] = $this->url->link('provider/price/', '', 'SSL');
        $this->data['action'] = $this->url->link('provider/price/listsubprofileproduct', '', 'SSL');

        $this->data['back'] = $this->url->link('account/account', '', 'SSL');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/provider/price_listsubprofileproduct.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/provider/price_listsubprofileproduct.tpl';
        } else {
            $this->template = 'default/template/provider/price_listsubprofileproduct.tpl';
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

}

?>