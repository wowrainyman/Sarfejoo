<?php

class ControllerProductCompare extends Controller
{
    public function index()
    {
        $this->language->load('product/compare');

        $this->load->model('catalog/product');

        $this->load->model('tool/image');
        $this->load->model('provider/pu_subprofile');

        if (!isset($this->session->data['compare'])) {
            $this->session->data['compare'] = array();
        }

        if (isset($this->request->get['remove'])) {
            $key = array_search($this->request->get['remove'], $this->session->data['compare']);

            if ($key !== false) {
                unset($this->session->data['compare'][$key]);
            }

            $this->session->data['success'] = $this->language->get('text_remove');

            $this->redirect($this->url->link('product/compare'));
        }

        $this->document->setTitle($this->language->get('heading_title'));

        $this->data['breadcrumbs'] = array();

        $this->document->addStyle("catalog/view/css/bootstrap-toggle/css/bootstrap2-toggle.css");
        $this->document->addScript('catalog/view/css/bootstrap-toggle/js/bootstrap2-toggle.js');
        
          $this->document->addScript('catalog/view/javascript/sarfejoo/compare.js');
          
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->config->get('config_url'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('product/compare'),
            'separator' => $this->language->get('text_separator')
        );

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_product'] = $this->language->get('text_product');
        $this->data['text_name'] = $this->language->get('text_name');
        $this->data['text_image'] = $this->language->get('text_image');
        $this->data['text_price'] = $this->language->get('text_price');
        $this->data['text_providers'] = $this->language->get('text_providers');
        $this->data['text_model'] = $this->language->get('text_model');
        $this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
        $this->data['text_availability'] = $this->language->get('text_availability');
        $this->data['text_rating'] = $this->language->get('text_rating');
        $this->data['text_summary'] = $this->language->get('text_summary');
        $this->data['text_weight'] = $this->language->get('text_weight');
        $this->data['text_dimension'] = $this->language->get('text_dimension');
        $this->data['text_empty'] = $this->language->get('text_empty');
        $this->data['entry_buy_link'] = $this->language->get('entry_buy_link');
        $this->data['text_toggle_dif'] = $this->language->get('text_toggle_dif');
        $this->data['text_fast_compare'] = $this->language->get('text_fast_compare');
        $this->data['text_all_provider'] = $this->language->get('text_all_provider');

        $this->data['button_continue'] = $this->language->get('button_continue');
        $this->data['button_cart'] = $this->language->get('button_cart');
        $this->data['button_remove'] = $this->language->get('button_remove');

        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }

        $this->data['review_status'] = $this->config->get('config_review_status');

        $this->data['products'] = array();

        $this->data['attribute_groups'] = array();

        foreach ($this->session->data['compare'] as $key => $product_id) {
            $product_info = $this->model_catalog_product->getProduct($product_id);

            if ($product_info) {
                if ($product_info['image']) {
                    $image = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_compare_width'), $this->config->get('config_image_compare_height'));
                } else {
                    $image = false;
                }

                if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                    $price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
                } else {
                    $price = false;
                }

                if ((float)$product_info['special']) {
                    $special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
                } else {
                    $special = false;
                }

                if ($product_info['quantity'] <= 0) {
                    $availability = $product_info['stock_status'];
                } elseif ($this->config->get('config_stock_display')) {
                    $availability = $product_info['quantity'];
                } else {
                    $availability = $this->language->get('text_instock');
                }

                $attribute_data = array();

                $attribute_groups = $this->model_catalog_product->getProductAttributes($product_id);

                foreach ($attribute_groups as $attribute_group) {
                    foreach ($attribute_group['attribute'] as $attribute) {
                        $attribute_data[$attribute['attribute_id']] = $attribute['text'];
                    }
                }

                $subprofile_data = array();
                $subprofiles = $this->model_provider_pu_subprofile->GetTopSubprofileOfProducts($product_id,2);

                foreach ($subprofiles as $subprofile) {
                    $subprofile_data[]= array(
                        'subprofile_id' => $subprofile['subprofile_id'],
                        'title' => $subprofile['title'],
                        'buy_link' => $subprofile['buy_link'],
                        'logo' => $subprofile['logo'],
                        'price' => $subprofile['price'],
                        'c_id' => $subprofile['customer_id']
                    );
                }

                $this->data['products'][$product_id] = array(
                    'product_id' => $product_info['product_id'],
                    'name' => $product_info['name'],
                    'thumb' => $image,
                    'price' => $price,
                    'special' => $special,
                    'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, 200) . '..',
                    'model' => $product_info['model'],
                    'manufacturer' => $product_info['manufacturer'],
                    'availability' => $availability,
                    'rating' => (int)$product_info['rating'],
                    'reviews' => sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']),
                    'weight' => $this->weight->format($product_info['weight'], $product_info['weight_class_id']),
                    'length' => $this->length->format($product_info['length'], $product_info['length_class_id']),
                    'width' => $this->length->format($product_info['width'], $product_info['length_class_id']),
                    'height' => $this->length->format($product_info['height'], $product_info['length_class_id']),
                    'attribute' => $attribute_data,
                    'href' => $this->url->link('product/product', 'product_id=' . $product_id),
                    'remove' => $this->url->link('product/compare', 'remove=' . $product_id),
                    'providers' => $subprofile_data
                );

                foreach ($attribute_groups as $attribute_group) {
                    $this->data['attribute_groups'][$attribute_group['attribute_group_id']]['name'] = $attribute_group['name'];

                    foreach ($attribute_group['attribute'] as $attribute) {
                        $this->data['attribute_groups'][$attribute_group['attribute_group_id']]['attribute'][$attribute['attribute_id']]['name'] = $attribute['name'];
                    }
                }
            } else {
                unset($this->session->data['compare'][$key]);
            }
        }

        $this->data['continue'] = $this->config->get('config_url');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/compare.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/product/compare.tpl';
        } else {
            $this->template = 'default/template/product/compare.tpl';
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

    public function add()
    {
        $this->language->load('product/compare');

        $json = array();

        if (!isset($this->session->data['compare'])) {
            $this->session->data['compare'] = array();
        }

        if (isset($this->request->post['product_id'])) {
            $product_id = $this->request->post['product_id'];
        } else {
            $product_id = 0;
        }

        $this->load->model('catalog/product');
        $this->load->model('catalog/category');

        $product_info = $this->model_catalog_product->getProduct($product_id);

        if ($product_info) {

            if (!in_array($this->request->post['product_id'], $this->session->data['compare'])) {


                if(count($this->session->data['compare']) >= 1){
                    $current_product_category = 0;
                    $categories = $this->model_catalog_product->getCategories($product_id);
                    $categoryid = $categories[0]['category_id'];
                    $category_info = $this->model_catalog_category->getCategory($categoryid);
                    $parent = $this->model_catalog_category->getCategory($category_info['parent_id']);
                    $parentId = $parent['category_id'];
                    $sortOrder = $parent['sort_order'];
                    $num_length = strlen((string)$sortOrder);
                    if ($parentId == 60 || $parentId == 59) {
                        $current_product_category = $categoryid;
                    } else {
                        $current_product_category = $parentId;
                    }
                    while ($num_length > 2) {
                        $category_info = $this->model_catalog_category->getCategory($parentId);
                        $parent = $this->model_catalog_category->getCategory($category_info['parent_id']);
                        $parentId = $parent['category_id'];
                        $sortOrder = $parent['sort_order'];
                        $num_length = strlen((string)$sortOrder);
                        $current_product_category = $parentId;
                    }


                    $exist_product = $this->session->data['compare'][0];
                    $exist_product_category = 0;
                    $categories = $this->model_catalog_product->getCategories($exist_product);
                    $categoryid = $categories[0]['category_id'];
                    $category_info = $this->model_catalog_category->getCategory($categoryid);
                    $parent = $this->model_catalog_category->getCategory($category_info['parent_id']);
                    $parentId = $parent['category_id'];
                    $sortOrder = $parent['sort_order'];
                    $num_length = strlen((string)$sortOrder);
                    if ($parentId == 60 || $parentId == 59) {
                        $exist_product_category = $categoryid;
                    } else {
                        $exist_product_category = $parentId;
                    }
                    while ($num_length > 2) {
                        $category_info = $this->model_catalog_category->getCategory($parentId);
                        $parent = $this->model_catalog_category->getCategory($category_info['parent_id']);
                        $parentId = $parent['category_id'];
                        $sortOrder = $parent['sort_order'];
                        $num_length = strlen((string)$sortOrder);
                        $exist_product_category = $parentId;
                    }

                    if($exist_product_category != $current_product_category){
                        $json['error'] = "سبد مقایسه شما حاوی کالایی نامربوط با کالای انتخاب شده است";
                        $this->response->setOutput(json_encode($json));
                        return;
                    }
                }
                $json['shifted'] = false;

                if (count($this->session->data['compare']) >= 4) {
                    array_shift($this->session->data['compare']);
                    $json['shifted'] = true;
                }
                $this->session->data['compare'][] = $this->request->post['product_id'];
                $json['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('product/compare'));
                $json['total'] = isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0;
            }else{
                $json['error'] = "duplicate";
            }
        }
        $this->response->setOutput(json_encode($json));
    }

    public function removeAndAdd()
    {
        unset($this->session->data['compare']);
        $this->language->load('product/compare');

        $json = array();

        if (!isset($this->session->data['compare'])) {
            $this->session->data['compare'] = array();
        }

        if (isset($this->request->post['product_id'])) {
            $product_id = $this->request->post['product_id'];
        } else {
            $product_id = 0;
        }

        $this->load->model('catalog/product');
        $this->load->model('catalog/category');

        $product_info = $this->model_catalog_product->getProduct($product_id);

        if ($product_info) {
            if (!in_array($this->request->post['product_id'], $this->session->data['compare'])) {
                if(count($this->session->data['compare']) >= 1){
                    $current_product_category = 0;
                    $categories = $this->model_catalog_product->getCategories($product_id);
                    $categoryid = $categories[0]['category_id'];
                    $category_info = $this->model_catalog_category->getCategory($categoryid);
                    $parent = $this->model_catalog_category->getCategory($category_info['parent_id']);
                    $parentId = $parent['category_id'];
                    $sortOrder = $parent['sort_order'];
                    $num_length = strlen((string)$sortOrder);
                    if ($parentId == 60 || $parentId == 59) {
                        $current_product_category = $categoryid;
                    } else {
                        $current_product_category = $parentId;
                    }
                    while ($num_length > 2) {
                        $category_info = $this->model_catalog_category->getCategory($parentId);
                        $parent = $this->model_catalog_category->getCategory($category_info['parent_id']);
                        $parentId = $parent['category_id'];
                        $sortOrder = $parent['sort_order'];
                        $num_length = strlen((string)$sortOrder);
                        $current_product_category = $parentId;
                    }
                    $exist_product = $this->session->data['compare'][0];
                    $exist_product_category = 0;
                    $categories = $this->model_catalog_product->getCategories($exist_product);
                    $categoryid = $categories[0]['category_id'];
                    $category_info = $this->model_catalog_category->getCategory($categoryid);
                    $parent = $this->model_catalog_category->getCategory($category_info['parent_id']);
                    $parentId = $parent['category_id'];
                    $sortOrder = $parent['sort_order'];
                    $num_length = strlen((string)$sortOrder);
                    if ($parentId == 60 || $parentId == 59) {
                        $exist_product_category = $categoryid;
                    } else {
                        $exist_product_category = $parentId;
                    }
                    while ($num_length > 2) {
                        $category_info = $this->model_catalog_category->getCategory($parentId);
                        $parent = $this->model_catalog_category->getCategory($category_info['parent_id']);
                        $parentId = $parent['category_id'];
                        $sortOrder = $parent['sort_order'];
                        $num_length = strlen((string)$sortOrder);
                        $exist_product_category = $parentId;
                    }
                    if($exist_product_category != $current_product_category){
                        $json['error'] = "سبد مقایسه شما حاوی کالایی نامربوط با کالای انتخاب شده است";
                        $this->response->setOutput(json_encode($json));
                        return;
                    }
                }

                if (count($this->session->data['compare']) >= 4) {
                    array_shift($this->session->data['compare']);
                }
                $this->session->data['compare'][] = $this->request->post['product_id'];
                $json['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('product/compare'));
                $json['total'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
            }else{
                $json['error'] = "duplicate";
            }
        }
        $this->response->setOutput(json_encode($json));
    }

    public function remove()
    {
        $this->language->load('product/compare');
        if (isset($this->request->get['remove'])) {
            $json = array();
            $key = array_search($this->request->get['remove'], $this->session->data['compare']);
            if ($key !== false) {
                unset($this->session->data['compare'][$key]);
                $json['success'] = true;
            }
            $this->session->data['success'] = $this->language->get('text_remove');
            $json['total'] = isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0;
            $this->response->setOutput(json_encode($json));
        }
    }
}

?>