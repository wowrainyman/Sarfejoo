<?php

/**
 * Created by PhpStorm.
 * User: Sarfejoo1
 * Date: 10/14/2014
 * Time: 11:00 AM
 */
class ControllerProviderPrice extends Controller
{
    public function index()
    {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('provider/profile', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
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

    public function editsubprofileproduct()
    {
        if (!$this->isCustomerPayed($this->customer->getId()))
        {
            $this->redirect($this->url->link('account/account', '', 'SSL'));
        }
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('provider/profile', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        $this->load->model('provider/pu_subprofile');
        $this->load->model('provider/pu_attribute');
        $this->load->model('catalog/product');
        $this->load->model('tool/image');
        $this->load->model('catalog/category');
        $this->load->model('customextension/pu_attribute');
        $this->data += $this->language->load('provider/price_editsubprofileproduct');

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
            foreach ($_POST['price'] as $key => $value) {
                $this->model_provider_pu_subprofile->UpdateProductPrice($key, $value);
            }
            foreach ($_POST['guarantee_status'] as $key => $value) {
                $this->model_provider_pu_subprofile->UpdateProductGuaranteeStatus($key, $value);
            }
            foreach ($_POST['guarantee_price'] as $key => $value) {
                $this->model_provider_pu_subprofile->UpdateProductGuaranteePrice($key, $value);
            }
            foreach ($_POST['guarantee_time'] as $key => $value) {
                $this->model_provider_pu_subprofile->UpdateProductGuaranteeTime($key, $value);
            }
            foreach ($_POST['guarantee_time_type'] as $key => $value) {
                $this->model_provider_pu_subprofile->UpdateProductGuaranteeTimeType($key, $value);
            }
            foreach ($_POST['guarantee_description'] as $key => $value) {
                $this->model_provider_pu_subprofile->UpdateProductGuaranteeDescription($key, $value);
            }

            foreach ($_POST['attribute'] as $key => $value) {
                if (is_array($value)) {
                    $value = implode(",", $value);
                }
                $this->model_provider_pu_attribute->UpdateCustomAttribute($key, $value);
            }



            $this->load->model('customextension/pu_block_attribute_subprofile_value');
            $id = $this->request->post['id'];
            $subprofile_id = $this->request->post['subprofile_id'];
            $product_id = $this->request->post['product_id'];
            $this->session->data['success'] = $this->language->get('text_success');
            $this->model_customextension_pu_block_attribute_subprofile_value->removeAll($subprofile_id,$product_id);
            $maximum = $this->model_customextension_pu_block_attribute_subprofile_value->maxRow();
            $maximum++;
            foreach ($_POST['subs'] as $key => $value) {
                $row = $maximum;
                echo "< br/>";
                foreach ($value as $key2 => $value2) {
                    if (is_array($value2)) {
                        $subAttrId = $key2;
                        $val = "";
                        foreach ($value2 as $key3 => $value3) {
                            if ($val == "") {
                                $name = $value3['name'];
                                $star = $value3['star'];
                                $val = $name . "$" . $star;
                            } else {
                                $name = $value3['name'];
                                $star = $value3['star'];
                                $val .= "," . $name . "$" . $star;
                            }
                        }
                        $this->model_customextension_pu_block_attribute_subprofile_value->add($subprofile_id,
                            $product_id,
                            $subAttrId,
                            $val,
                            $row);
                    } else {
                        $subAttrId = $key2;
                        $subAttrValue = $value2;
                        $this->model_customextension_pu_block_attribute_subprofile_value->add($subprofile_id,
                            $product_id,
                            $subAttrId,
                            $subAttrValue,
                            $row);
                    }
                }
                $maximum++;
            }

            $this->session->data['success'] = $this->language->get('text_success');
            $this->redirect($this->url->link('provider/price', '', 'SSL'));
        }


        $subprofileProductId = $this->request->get['id'];
        $product = $this->model_provider_pu_subprofile->GetProductOfSubprofile($subprofileProductId);
        $isBlockAttribute = false;
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
            $this->load->model('customextension/pu_block');
            $this->load->model('customextension/pu_block_attribute');
            $this->load->model('customextension/pu_block_attribute_value');
            $this->load->model('customextension/pu_block_attribute_subprofile_value');
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
                    $is_block = false;
                    if ($this->model_customextension_pu_attribute->isBlockAttribute($attribute_info['attribute_id'])) {
                        $is_block = true;
                        $isBlockAttribute = true;
                        if ($blockAttributesId == '') {
                            $blockAttributesId = $attribute_info['attribute_id'];
                        } else {
                            $blockAttributesId .= ',' . $attribute_info['attribute_id'];
                        }
                        $selected_value = $this->model_customextension_pu_block_attribute_subprofile_value->get($product['subprofile_id'],$product['product_id'],$attribute_info['attribute_id']);
                        $selected_value2=array();
                        $first_attr_name = $selected_value[0]['subattribute_name'];
                        $subs = array();
                        $cnt=0;

                        foreach ($selected_value as $this_selected_value) {
                            if($this_selected_value['subattribute_name'] == $first_attr_name && $cnt!=0){
                                $selected_value2[] = $subs;
                                $subs = array();
                            }
                            $cnt++;
                            $subs[] = array(
                                'id' => $this_selected_value['id'],
                                'subprofile_id' => $this_selected_value['subprofile_id'],
                                'product_id' => $this_selected_value['product_id'],
                                'block_attribute_id' => $this_selected_value['block_attribute_id'],
                                'value' => $this_selected_value['value'],
                                'row' => $this_selected_value['row'],
                                'block_id' => $this_selected_value['block_id'],
                                'subattribute_name' => $this_selected_value['subattribute_name'],
                                'type' => $this_selected_value['type'],
                                'class' => $this_selected_value['class'],
                                'sort_order' => $this_selected_value['sort_order'],
                                'attribute_id' => $this_selected_value['attribute_id'],
                                'block_name' => $this_selected_value['block_name']
                            );
                        }
                        $selected_value2[] = $subs;
                        $selected_value=$selected_value2;
                    }else{
                        $selected_value = $this->model_provider_pu_attribute->getAttributeValue($product['subprofile_id'], $product['product_id'], $attribute_info['attribute_id']);
                    }

                    $attributes[] = array(
                        'attribute_id' => $attribute_info['attribute_id'],
                        'name' => $attribute_info['name'],
                        'type' => $attribute_info['type'],
                        'class' => $attribute_info['class'],
                        'values' => $values,
                        'selected_value' => $selected_value,
                        'is_block' => $is_block
                    );
                }
            }
            $customAttributes = $attributes;
        }

        $product_info = $this->model_catalog_product->getProduct($product['product_id']);
        $minprice = $this->model_provider_pu_subprofile->GetMinimumPriceOfProduct($product['product_id']);
        $maxprice = $this->model_provider_pu_subprofile->GetMaximumPriceOfProduct($product['product_id']);
        $price_avg = $this->model_provider_pu_subprofile->GetAveragepricePriceOfProduct($product['product_id']);



        $productinfo = array(
            'id' => $product['id'],
            'name' => $product_info['name'],
            'description' => $product['description'],
            'image' => $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height')),
            'availability' => $product['availability'],
            'product_id' => $product['product_id'],
            'yourprice' => $product['price'],
            'buy_link' => $product['buy_link'],
            'guarantee_status' => $product['guarantee_status'],
            'guarantee_price' => $product['guarantee_price'],
            'guarantee_time' => $product['guarantee_time'],
            'guarantee_time_type' => $product['guarantee_time_type'],
            'guarantee_description' => $product['guarantee_description'],
            'averageprice' => $price_avg,
            'minimumprice' => $minprice['MIN(price)'],
            'maximumprice' => $maxprice['MAX(price)'],
            'customAttributes' => $customAttributes
        );

        $this->data['productinfo'] = $productinfo;


        if($isBlockAttribute){
            $id = $product['id'];
            $attributesId = $blockAttributesId;
            $product_id = $product['product_id'];
            $subprofile_id = $product['subprofile_id'];
            $this->data['id'] = $id;
            $this->data['product_id'] = $product_id;
            $this->data['subprofile_id'] = $subprofile_id;
            $attributesId = explode(',', $attributesId);

            $blocks = array();
            foreach ($attributesId as $attributeId) {
                $currentBlock = $this->model_customextension_pu_block->getBlock($attributeId);
                $subattributes = $this->model_customextension_pu_block_attribute->getSubAttributes($currentBlock['id']);
                $subs = array();
                foreach ($subattributes as $subattribute) {
                    $values = array();
                    $subattributeValues = $this->model_customextension_pu_block_attribute_value->getSubattributeValues($subattribute['id']);
                    foreach ($subattributeValues as $subattributeValue) {
                        $values[] = array(
                            'id' => $subattributeValue['id'],
                            'value' => $subattributeValue['value']
                        );
                    }
                    $subs[] = array(
                        'subattribute_id' => $subattribute['id'],
                        'subattribute_name' => $subattribute['subattribute_name'],
                        'subattribute_type' => $subattribute['type'],
                        'subattribute_class' => $subattribute['class'],
                        'values' => $values
                    );
                }
                $blocks[] = array(
                    'block_id' => $currentBlock['id'],
                    'block_name' => $currentBlock['block_name'],
                    'subattributes' => $subs
                );
            }
            $this->data['blocks'] = $blocks;
        }



        $this->data['action'] = $this->url->link('provider/price/editsubprofileproduct', '', 'SSL');

        $this->data['back'] = $this->url->link('provider/price/listsubprofileproduct', '', 'SSL');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/provider/price_editsubprofileproduct.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/provider/price_editsubprofileproduct.tpl';
        } else {
            $this->template = 'default/template/provider/price_editsubprofileproduct.tpl';
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
                $product_info = $this->model_catalog_product->getProduct($product['product_id']);

                $productinfos[] = array(
                    'id' => $product['id'],
                    'name' => $product_info['name'],
                    'image' => $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height')),
                    'editHref' =>   $this->url->link('provider/price/editsubprofileproduct', '&id=' . $product['id'])
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