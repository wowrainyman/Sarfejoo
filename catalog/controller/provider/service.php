<?php

/**
 * Created by PhpStorm.
 * User: Amir
 * Date: 11/8/2014
 * Time: 9:17 AM
 */
class ControllerProviderService extends Controller
{
    private $error = array();

    public function insert()
    {
        $this->language->load('provider/service');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('provider/pu_product');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $product_id = $this->model_provider_pu_product->addProduct($this->request->post);

            if (!empty ($_FILES)) {
                //upload nationalcard pic
                if ($_FILES ["image"] ["error"] > 0) {
                    echo "Return Code: " . $_FILES ["image"] ["error"] . "<br>";
                } else {

                    $fileName = "1";
                    $folderName = $product_id;
                    $folderPlace = $_SERVER['DOCUMENT_ROOT'] . "/sarfejoo" . "/image" . "/data";
                    $finalFilePath = $folderPlace . "/" . $folderName . "/" . $fileName;
                    if (!is_dir($folderPlace . "/" . $folderName)) {
                        mkdir($folderPlace . "/" . $folderName);
                    }
                    $path = $_FILES['image']['name'];
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    move_uploaded_file($_FILES ["image"] ["tmp_name"], $finalFilePath . "." . $ext);
                    $databasePath = "data/" . $product_id . "/1." . $ext;
                    $this->model_provider_pu_product->updateImage($product_id,$databasePath);
                }
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_model'])) {
                $url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_price'])) {
                $url .= '&filter_price=' . $this->request->get['filter_price'];
            }

            if (isset($this->request->get['filter_quantity'])) {
                $url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
            }

            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status=' . $this->request->get['filter_status'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->redirect($this->url->link('account/account', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getForm();
    }

    protected function getForm()
    {
        $this->data['heading_title'] = $this->language->get('heading_title');


        $this->data['text_default'] = $this->language->get('text_default');
        $this->data['text_browse'] = $this->language->get('text_browse');
        $this->data['text_clear'] = $this->language->get('text_clear');
        $this->data['text_select'] = $this->language->get('text_select');

        $this->data['entry_name'] = $this->language->get('entry_name');
        $this->data['entry_description'] = $this->language->get('entry_description');
        $this->data['entry_keyword'] = $this->language->get('entry_keyword');
        $this->data['entry_model'] = $this->language->get('entry_model');
        $this->data['entry_location'] = $this->language->get('entry_location');
        $this->data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
        $this->data['entry_price'] = $this->language->get('entry_price');
        $this->data['entry_subtract'] = $this->language->get('entry_subtract');
        $this->data['entry_image'] = $this->language->get('entry_image');
        $this->data['entry_category'] = $this->language->get('entry_category');
        $this->data['entry_filter'] = $this->language->get('entry_filter');
        $this->data['entry_related'] = $this->language->get('entry_related');
        $this->data['entry_attribute'] = $this->language->get('entry_attribute');
        $this->data['entry_text'] = $this->language->get('entry_text');
        $this->data['entry_option'] = $this->language->get('entry_option');
        $this->data['entry_option_value'] = $this->language->get('entry_option_value');
        $this->data['entry_required'] = $this->language->get('entry_required');
        $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $this->data['entry_status'] = $this->language->get('entry_status');
        $this->data['entry_priority'] = $this->language->get('entry_priority');
        $this->data['entry_tag'] = $this->language->get('entry_tag');
        $this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
        $this->data['entry_reward'] = $this->language->get('entry_reward');
        $this->data['entry_layout'] = $this->language->get('entry_layout');
        $this->data['entry_profile'] = $this->language->get('entry_profile');

        $this->data['text_recurring_help'] = $this->language->get('text_recurring_help');
        $this->data['text_recurring_title'] = $this->language->get('text_recurring_title');
        $this->data['text_recurring_trial'] = $this->language->get('text_recurring_trial');
        $this->data['entry_recurring'] = $this->language->get('entry_recurring');
        $this->data['entry_recurring_price'] = $this->language->get('entry_recurring_price');
        $this->data['entry_recurring_freq'] = $this->language->get('entry_recurring_freq');
        $this->data['entry_recurring_cycle'] = $this->language->get('entry_recurring_cycle');
        $this->data['entry_recurring_length'] = $this->language->get('entry_recurring_length');
        $this->data['entry_trial'] = $this->language->get('entry_trial');
        $this->data['entry_trial_price'] = $this->language->get('entry_trial_price');
        $this->data['entry_trial_freq'] = $this->language->get('entry_trial_freq');
        $this->data['entry_trial_length'] = $this->language->get('entry_trial_length');
        $this->data['entry_trial_cycle'] = $this->language->get('entry_trial_cycle');

        $this->data['text_length_day'] = $this->language->get('text_length_day');
        $this->data['text_length_week'] = $this->language->get('text_length_week');
        $this->data['text_length_month'] = $this->language->get('text_length_month');
        $this->data['text_length_month_semi'] = $this->language->get('text_length_month_semi');
        $this->data['text_length_year'] = $this->language->get('text_length_year');

        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');
        $this->data['button_add_attribute'] = $this->language->get('button_add_attribute');
        $this->data['button_add_option'] = $this->language->get('button_add_option');
        $this->data['button_add_option_value'] = $this->language->get('button_add_option_value');
        $this->data['button_add_discount'] = $this->language->get('button_add_discount');
        $this->data['button_add_special'] = $this->language->get('button_add_special');
        $this->data['button_add_image'] = $this->language->get('button_add_image');
        $this->data['button_remove'] = $this->language->get('button_remove');
        $this->data['button_add_profile'] = $this->language->get('button_add_profile');

        $this->data['tab_general'] = $this->language->get('tab_general');
        $this->data['tab_data'] = $this->language->get('tab_data');
        $this->data['tab_attribute'] = $this->language->get('tab_attribute');
        $this->data['tab_links'] = $this->language->get('tab_links');

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        if (isset($this->error['name'])) {
            $this->data['error_name'] = $this->error['name'];
        } else {
            $this->data['error_name'] = array();
        }

        if (isset($this->error['meta_description'])) {
            $this->data['error_meta_description'] = $this->error['meta_description'];
        } else {
            $this->data['error_meta_description'] = array();
        }

        if (isset($this->error['description'])) {
            $this->data['error_description'] = $this->error['description'];
        } else {
            $this->data['error_description'] = array();
        }

        if (isset($this->error['model'])) {
            $this->data['error_model'] = $this->error['model'];
        } else {
            $this->data['error_model'] = '';
        }

        if (isset($this->error['date_available'])) {
            $this->data['error_date_available'] = $this->error['date_available'];
        } else {
            $this->data['error_date_available'] = '';
        }

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_model'])) {
            $url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_price'])) {
            $url .= '&filter_price=' . $this->request->get['filter_price'];
        }

        if (isset($this->request->get['filter_quantity'])) {
            $url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
        }

        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('account/account', '', 'SSL'),
            'separator' => false
        );

        if (!isset($this->request->get['product_id'])) {
            $this->data['action'] = $this->url->link('provider/service/insert', $url, 'SSL');
        } else {
            $this->data['action'] = $this->url->link('provider/service/update', '&product_id=' . $this->request->get['product_id'] . $url, 'SSL');
        }

        $this->data['cancel'] = $this->url->link('account/account','', 'SSL');

        if (isset($this->request->get['product_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $product_info = $this->model_provider_pu_product->getProduct($this->request->get['product_id']);
        }


        $this->load->model('provider/pu_language');

        $this->data['languages'] = $this->model_provider_pu_language->getLanguages();

        if (isset($this->request->post['product_description'])) {
            $this->data['product_description'] = $this->request->post['product_description'];
        } elseif (isset($this->request->get['product_id'])) {
            $this->data['product_description'] = $this->model_provider_pu_product->getProductDescriptions($this->request->get['product_id']);
        } else {
            $this->data['product_description'] = array();
        }

        if (isset($this->request->post['model'])) {
            $this->data['model'] = $this->request->post['model'];
        } elseif (!empty($product_info)) {
            $this->data['model'] = $product_info['model'];
        } else {
            $this->data['model'] = '';
        }

        if (isset($this->request->post['location'])) {
            $this->data['location'] = $this->request->post['location'];
        } elseif (!empty($product_info)) {
            $this->data['location'] = $product_info['location'];
        } else {
            $this->data['location'] = '';
        }

        $this->load->model('provider/pu_store');

        $this->data['stores'] = $this->model_provider_pu_store->getStores();

        if (isset($this->request->post['product_store'])) {
            $this->data['product_store'] = $this->request->post['product_store'];
        } elseif (isset($this->request->get['product_id'])) {
            $this->data['product_store'] = $this->model_provider_pu_product->getProductStores($this->request->get['product_id']);
        } else {
            $this->data['product_store'] = array(0);
        }

        if (isset($this->request->post['keyword'])) {
            $this->data['keyword'] = $this->request->post['keyword'];
        } elseif (!empty($product_info)) {
            $this->data['keyword'] = $product_info['keyword'];
        } else {
            $this->data['keyword'] = '';
        }

        if (isset($this->request->post['image'])) {
            $this->data['image'] = $this->request->post['image'];
        } elseif (!empty($product_info)) {
            $this->data['image'] = $product_info['image'];
        } else {
            $this->data['image'] = '';
        }

        $this->load->model('tool/image');

        if (isset($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
            $this->data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
        } elseif (!empty($product_info) && $product_info['image'] && file_exists(DIR_IMAGE . $product_info['image'])) {
            $this->data['thumb'] = $this->model_tool_image->resize($product_info['image'], 100, 100);
        } else {
            $this->data['thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
        }

        if (isset($this->request->post['shipping'])) {
            $this->data['shipping'] = $this->request->post['shipping'];
        } elseif (!empty($product_info)) {
            $this->data['shipping'] = $product_info['shipping'];
        } else {
            $this->data['shipping'] = 1;
        }

        if (isset($this->request->post['price'])) {
            $this->data['price'] = $this->request->post['price'];
        } elseif (!empty($product_info)) {
            $this->data['price'] = $product_info['price'];
        } else {
            $this->data['price'] = '';
        }

        $this->load->model('provider/pu_profile');

        $this->data['profiles'] = $this->model_provider_pu_profile->getProfiles();

        if (isset($this->request->post['product_profiles'])) {
            $this->data['product_profiles'] = $this->request->post['product_profiles'];
        } elseif (!empty($product_info)) {
            $this->data['product_profiles'] = $this->model_provider_pu_product->getProfiles($product_info['product_id']);
        } else {
            $this->data['product_profiles'] = array();
        }

        $this->load->model('provider/pu_tax_class');

        $this->data['tax_classes'] = $this->model_provider_pu_tax_class->getTaxClasses();

        if (isset($this->request->post['tax_class_id'])) {
            $this->data['tax_class_id'] = $this->request->post['tax_class_id'];
        } elseif (!empty($product_info)) {
            $this->data['tax_class_id'] = $product_info['tax_class_id'];
        } else {
            $this->data['tax_class_id'] = 0;
        }

        if (isset($this->request->post['date_available'])) {
            $this->data['date_available'] = $this->request->post['date_available'];
        } elseif (!empty($product_info)) {
            $this->data['date_available'] = date('Y-m-d', strtotime($product_info['date_available']));
        } else {
            $this->data['date_available'] = date('Y-m-d', time() - 86400);
        }

        if (isset($this->request->post['quantity'])) {
            $this->data['quantity'] = $this->request->post['quantity'];
        } elseif (!empty($product_info)) {
            $this->data['quantity'] = $product_info['quantity'];
        } else {
            $this->data['quantity'] = 1;
        }

        if (isset($this->request->post['minimum'])) {
            $this->data['minimum'] = $this->request->post['minimum'];
        } elseif (!empty($product_info)) {
            $this->data['minimum'] = $product_info['minimum'];
        } else {
            $this->data['minimum'] = 1;
        }

        if (isset($this->request->post['subtract'])) {
            $this->data['subtract'] = $this->request->post['subtract'];
        } elseif (!empty($product_info)) {
            $this->data['subtract'] = $product_info['subtract'];
        } else {
            $this->data['subtract'] = 1;
        }

        if (isset($this->request->post['sort_order'])) {
            $this->data['sort_order'] = $this->request->post['sort_order'];
        } elseif (!empty($product_info)) {
            $this->data['sort_order'] = $product_info['sort_order'];
        } else {
            $this->data['sort_order'] = 1;
        }

        $this->load->model('provider/pu_stock_status');

        $this->data['stock_statuses'] = $this->model_provider_pu_stock_status->getStockStatuses();

        if (isset($this->request->post['stock_status_id'])) {
            $this->data['stock_status_id'] = $this->request->post['stock_status_id'];
        } elseif (!empty($product_info)) {
            $this->data['stock_status_id'] = $product_info['stock_status_id'];
        } else {
            $this->data['stock_status_id'] = $this->config->get('config_stock_status_id');
        }

        if (isset($this->request->post['status'])) {
            $this->data['status'] = $this->request->post['status'];
        } elseif (!empty($product_info)) {
            $this->data['status'] = $product_info['status'];
        } else {
            $this->data['status'] = 1;
        }

        if (isset($this->request->post['weight'])) {
            $this->data['weight'] = $this->request->post['weight'];
        } elseif (!empty($product_info)) {
            $this->data['weight'] = $product_info['weight'];
        } else {
            $this->data['weight'] = '';
        }

        $this->load->model('provider/pu_weight_class');

        $this->data['weight_classes'] = $this->model_provider_pu_weight_class->getWeightClasses();

        if (isset($this->request->post['weight_class_id'])) {
            $this->data['weight_class_id'] = $this->request->post['weight_class_id'];
        } elseif (!empty($product_info)) {
            $this->data['weight_class_id'] = $product_info['weight_class_id'];
        } else {
            $this->data['weight_class_id'] = $this->config->get('config_weight_class_id');
        }

        if (isset($this->request->post['length'])) {
            $this->data['length'] = $this->request->post['length'];
        } elseif (!empty($product_info)) {
            $this->data['length'] = $product_info['length'];
        } else {
            $this->data['length'] = '';
        }

        if (isset($this->request->post['width'])) {
            $this->data['width'] = $this->request->post['width'];
        } elseif (!empty($product_info)) {
            $this->data['width'] = $product_info['width'];
        } else {
            $this->data['width'] = '';
        }

        if (isset($this->request->post['height'])) {
            $this->data['height'] = $this->request->post['height'];
        } elseif (!empty($product_info)) {
            $this->data['height'] = $product_info['height'];
        } else {
            $this->data['height'] = '';
        }

        $this->load->model('provider/pu_length_class');

        $this->data['length_classes'] = $this->model_provider_pu_length_class->getLengthClasses();

        if (isset($this->request->post['length_class_id'])) {
            $this->data['length_class_id'] = $this->request->post['length_class_id'];
        } elseif (!empty($product_info)) {
            $this->data['length_class_id'] = $product_info['length_class_id'];
        } else {
            $this->data['length_class_id'] = $this->config->get('config_length_class_id');
        }

        $this->load->model('catalog/manufacturer');

        if (isset($this->request->post['manufacturer_id'])) {
            $this->data['manufacturer_id'] = $this->request->post['manufacturer_id'];
        } elseif (!empty($product_info)) {
            $this->data['manufacturer_id'] = $product_info['manufacturer_id'];
        } else {
            $this->data['manufacturer_id'] = 0;
        }

        if (isset($this->request->post['manufacturer'])) {
            $this->data['manufacturer'] = $this->request->post['manufacturer'];
        } elseif (!empty($product_info)) {
            $manufacturer_info = $this->model_provider_pu_manufacturer->getManufacturer($product_info['manufacturer_id']);

            if ($manufacturer_info) {
                $this->data['manufacturer'] = $manufacturer_info['name'];
            } else {
                $this->data['manufacturer'] = '';
            }
        } else {
            $this->data['manufacturer'] = '';
        }

        // Categories
        $this->load->model('provider/pu_category');

        if (isset($this->request->post['product_category'])) {
            $categories = $this->request->post['product_category'];
        } elseif (isset($this->request->get['product_id'])) {
            $categories = $this->modelprovider_pu_product->getProductCategories($this->request->get['product_id']);
        } else {
            $categories = array();
        }

        $this->data['product_categories'] = array();

        foreach ($categories as $category_id) {
            $category_info = $this->model_provider_pu_category->getCategory($category_id);

            if ($category_info) {
                $this->data['product_categories'][] = array(
                    'category_id' => $category_info['category_id'],
                    'name' => ($category_info['path'] ? $category_info['path'] . ' &gt; ' : '') . $category_info['name']
                );
            }
        }

        // Filters
        $this->load->model('provider/pu_filter');

        if (isset($this->request->post['product_filter'])) {
            $filters = $this->request->post['product_filter'];
        } elseif (isset($this->request->get['product_id'])) {
            $filters = $this->model_provider_pu_product->getProductFilters($this->request->get['product_id']);
        } else {
            $filters = array();
        }

        $this->data['product_filters'] = array();

        foreach ($filters as $filter_id) {
            $filter_info = $this->model_provider_pu_filter->getFilter($filter_id);

            if ($filter_info) {
                $this->data['product_filters'][] = array(
                    'filter_id' => $filter_info['filter_id'],
                    'name' => $filter_info['group'] . ' &gt; ' . $filter_info['name']
                );
            }
        }

        // Attributes
        $this->load->model('provider/pu_attribute');

        if (isset($this->request->post['product_attribute'])) {
            $product_attributes = $this->request->post['product_attribute'];
        } elseif (isset($this->request->get['product_id'])) {
            $product_attributes = $this->model_provider_pu_product->getProductAttributes($this->request->get['product_id']);
        } else {
            $product_attributes = array();
        }

        $this->data['product_attributes'] = array();

        foreach ($product_attributes as $product_attribute) {
            $attribute_info = $this->model_provider_pu_attribute->getAttribute($product_attribute['attribute_id']);

            if ($attribute_info) {
                $this->data['product_attributes'][] = array(
                    'attribute_id' => $product_attribute['attribute_id'],
                    'name' => $attribute_info['name'],
                    'product_attribute_description' => $product_attribute['product_attribute_description']
                );
            }
        }

        // Options
        $this->load->model('provider/pu_option');

        if (isset($this->request->post['product_option'])) {
            $product_options = $this->request->post['product_option'];
        } elseif (isset($this->request->get['product_id'])) {
            $product_options = $this->model_provider_pu_product->getProductOptions($this->request->get['product_id']);
        } else {
            $product_options = array();
        }

        $this->data['product_options'] = array();

        foreach ($product_options as $product_option) {
            if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
                $product_option_value_data = array();

                foreach ($product_option['product_option_value'] as $product_option_value) {
                    $product_option_value_data[] = array(
                        'product_option_value_id' => $product_option_value['product_option_value_id'],
                        'option_value_id' => $product_option_value['option_value_id'],
                        'quantity' => $product_option_value['quantity'],
                        'subtract' => $product_option_value['subtract'],
                        'price' => $product_option_value['price'],
                        'price_prefix' => $product_option_value['price_prefix'],
                        'points' => $product_option_value['points'],
                        'points_prefix' => $product_option_value['points_prefix'],
                        'weight' => $product_option_value['weight'],
                        'weight_prefix' => $product_option_value['weight_prefix']
                    );
                }

                $this->data['product_options'][] = array(
                    'product_option_id' => $product_option['product_option_id'],
                    'product_option_value' => $product_option_value_data,
                    'option_id' => $product_option['option_id'],
                    'name' => $product_option['name'],
                    'type' => $product_option['type'],
                    'required' => $product_option['required']
                );
            } else {
                $this->data['product_options'][] = array(
                    'product_option_id' => $product_option['product_option_id'],
                    'option_id' => $product_option['option_id'],
                    'name' => $product_option['name'],
                    'type' => $product_option['type'],
                    'option_value' => $product_option['option_value'],
                    'required' => $product_option['required']
                );
            }
        }

        $this->data['option_values'] = array();

        foreach ($this->data['product_options'] as $product_option) {
            if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
                if (!isset($this->data['option_values'][$product_option['option_id']])) {
                    $this->data['option_values'][$product_option['option_id']] = $this->model_provider_pu_option->getOptionValues($product_option['option_id']);
                }
            }
        }

        $this->load->model('provider/pu_customer_group');

        $this->data['customer_groups'] = $this->model_provider_pu_customer_group->getCustomerGroups();

        if (isset($this->request->post['product_discount'])) {
            $this->data['product_discounts'] = $this->request->post['product_discount'];
        } elseif (isset($this->request->get['product_id'])) {
            $this->data['product_discounts'] = $this->model_provider_pu_product->getProductDiscounts($this->request->get['product_id']);
        } else {
            $this->data['product_discounts'] = array();
        }

        if (isset($this->request->post['product_special'])) {
            $this->data['product_specials'] = $this->request->post['product_special'];
        } elseif (isset($this->request->get['product_id'])) {
            $this->data['product_specials'] = $this->model_provider_pu_product->getProductSpecials($this->request->get['product_id']);
        } else {
            $this->data['product_specials'] = array();
        }

        // Images
        if (isset($this->request->post['product_image'])) {
            $product_images = $this->request->post['product_image'];
        } elseif (isset($this->request->get['product_id'])) {
            $product_images = $this->model_provider_pu_product->getProductImages($this->request->get['product_id']);
        } else {
            $product_images = array();
        }

        $this->data['product_images'] = array();

        foreach ($product_images as $product_image) {
            if ($product_image['image'] && file_exists(DIR_IMAGE . $product_image['image'])) {
                $image = $product_image['image'];
            } else {
                $image = 'no_image.jpg';
            }

            $this->data['product_images'][] = array(
                'image' => $image,
                'thumb' => $this->model_tool_image->resize($image, 100, 100),
                'sort_order' => $product_image['sort_order']
            );
        }

        $this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

        // Downloads
        $this->load->model('provider/pu_download');

        if (isset($this->request->post['product_download'])) {
            $product_downloads = $this->request->post['product_download'];
        } elseif (isset($this->request->get['product_id'])) {
            $product_downloads = $this->model_provider_pu_product->getProductDownloads($this->request->get['product_id']);
        } else {
            $product_downloads = array();
        }

        $this->data['product_downloads'] = array();

        foreach ($product_downloads as $download_id) {
            $download_info = $this->model_provider_pu_download->getDownload($download_id);

            if ($download_info) {
                $this->data['product_downloads'][] = array(
                    'download_id' => $download_info['download_id'],
                    'name' => $download_info['name']
                );
            }
        }

        if (isset($this->request->post['product_related'])) {
            $products = $this->request->post['product_related'];
        } elseif (isset($this->request->get['product_id'])) {
            $products = $this->model_provider_pu_product->getProductRelated($this->request->get['product_id']);
        } else {
            $products = array();
        }

        $this->data['product_related'] = array();

        foreach ($products as $product_id) {
            $related_info = $this->model_provider_pu_product->getProduct($product_id);

            if ($related_info) {
                $this->data['product_related'][] = array(
                    'product_id' => $related_info['product_id'],
                    'name' => $related_info['name']
                );
            }
        }

        if (isset($this->request->post['points'])) {
            $this->data['points'] = $this->request->post['points'];
        } elseif (!empty($product_info)) {
            $this->data['points'] = $product_info['points'];
        } else {
            $this->data['points'] = '';
        }

        if (isset($this->request->post['product_reward'])) {
            $this->data['product_reward'] = $this->request->post['product_reward'];
        } elseif (isset($this->request->get['product_id'])) {
            $this->data['product_reward'] = $this->model_provider_pu_product->getProductRewards($this->request->get['product_id']);
        } else {
            $this->data['product_reward'] = array();
        }

        if (isset($this->request->post['product_layout'])) {
            $this->data['product_layout'] = $this->request->post['product_layout'];
        } elseif (isset($this->request->get['product_id'])) {
            $this->data['product_layout'] = $this->model_provider_pu_product->getProductLayouts($this->request->get['product_id']);
        } else {
            $this->data['product_layout'] = array();
        }


        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/provider/product_form.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/provider/product_form.tpl';
        } else {
            $this->template = 'default/template/provider/product_form.tpl';
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

    protected function validateForm()
    {
        foreach ($this->request->post['product_description'] as $language_id => $value) {
            if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 255)) {
                $this->error['name'][$language_id] = $this->language->get('error_name');
            }
        }

        if ((utf8_strlen($this->request->post['model']) < 1) || (utf8_strlen($this->request->post['model']) > 64)) {
            $this->error['model'] = $this->language->get('error_model');
        }

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_warning');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    public function autocomplete()
    {
        $json = array();

        if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model']) || isset($this->request->get['filter_category_id'])) {
            $this->load->model('catalog/product');
            $this->load->model('catalog/option');

            if (isset($this->request->get['filter_name'])) {
                $filter_name = $this->request->get['filter_name'];
            } else {
                $filter_name = '';
            }

            if (isset($this->request->get['filter_model'])) {
                $filter_model = $this->request->get['filter_model'];
            } else {
                $filter_model = '';
            }

            if (isset($this->request->get['limit'])) {
                $limit = $this->request->get['limit'];
            } else {
                $limit = 20;
            }

            $data = array(
                'filter_name' => $filter_name,
                'filter_model' => $filter_model,
                'start' => 0,
                'limit' => $limit
            );

            $results = $this->model_catalog_product->getProducts($data);

            foreach ($results as $result) {
                $option_data = array();

                $product_options = $this->model_catalog_product->getProductOptions($result['product_id']);

                foreach ($product_options as $product_option) {
                    $option_info = $this->model_catalog_option->getOption($product_option['option_id']);

                    if ($option_info) {
                        if ($option_info['type'] == 'select' || $option_info['type'] == 'radio' || $option_info['type'] == 'checkbox' || $option_info['type'] == 'image') {
                            $option_value_data = array();

                            foreach ($product_option['product_option_value'] as $product_option_value) {
                                $option_value_info = $this->model_catalog_option->getOptionValue($product_option_value['option_value_id']);

                                if ($option_value_info) {
                                    $option_value_data[] = array(
                                        'product_option_value_id' => $product_option_value['product_option_value_id'],
                                        'option_value_id' => $product_option_value['option_value_id'],
                                        'name' => $option_value_info['name'],
                                        'price' => (float)$product_option_value['price'] ? $this->currency->format($product_option_value['price'], $this->config->get('config_currency')) : false,
                                        'price_prefix' => $product_option_value['price_prefix']
                                    );
                                }
                            }

                            $option_data[] = array(
                                'product_option_id' => $product_option['product_option_id'],
                                'option_id' => $product_option['option_id'],
                                'name' => $option_info['name'],
                                'type' => $option_info['type'],
                                'option_value' => $option_value_data,
                                'required' => $product_option['required']
                            );
                        } else {
                            $option_data[] = array(
                                'product_option_id' => $product_option['product_option_id'],
                                'option_id' => $product_option['option_id'],
                                'name' => $option_info['name'],
                                'type' => $option_info['type'],
                                'option_value' => $product_option['option_value'],
                                'required' => $product_option['required']
                            );
                        }
                    }
                }

                $json[] = array(
                    'product_id' => $result['product_id'],
                    'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
                    'model' => $result['model'],
                    'option' => $option_data,
                    'price' => $result['price']
                );
            }
        }

        $this->response->setOutput(json_encode($json));
    }

}

?>