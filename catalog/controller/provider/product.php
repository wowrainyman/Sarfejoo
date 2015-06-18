<?php

/**
 * Created by PhpStorm.
 * User: Amir
 * Date: 10/12/2014
 * Time: 2:21 PM
 */
class ControllerProviderProduct extends Controller
{
    private $error = array();

    public function index()
    {
        $this->language->load('provider/product');

        $this->load->model('catalog/category');

        $this->load->model('catalog/product');

        $this->load->model('provider/pu_subprofile');

        $this->load->model('tool/image');

        if (isset($this->request->get['filter'])) {
            $filter = $this->request->get['filter'];
        } else {
            $filter = '';
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'p.sort_order';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        if (isset($this->request->get['id'])) {
            $id = $this->request->get['id'];
            $c_expire_date = $this->model_provider_pu_subprofile->getSubprofileExpireDate($id);
            $sub_info = $this->model_provider_pu_subprofile->GetSubprofileInfo($id);
            if($c_expire_date && strtotime($c_expire_date) > time() || $sub_info['financial_exception'] == 1) {
            }else{
                $this->redirect($this->url->link('account/account', '', 'SSL'));
            }
        } else {
            $this->redirect($this->url->link('account/account', '', 'SSL'));
        }


        if (isset($this->request->get['limit'])) {
            $limit = $this->request->get['limit'];
        } else {
            $limit = $this->config->get('config_catalog_limit');
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home'),
            'separator' => false
        );

        if (isset($this->request->get['path'])) {
            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $path = '';

            $parts = explode('_', (string)$this->request->get['path']);

            $category_id = (int)array_pop($parts);

            foreach ($parts as $path_id) {
                if (!$path) {
                    $path = (int)$path_id;
                } else {
                    $path .= '_' . (int)$path_id;
                }

                $category_info = $this->model_catalog_category->getCategory($path_id);

                if ($category_info) {
                    $this->data['breadcrumbs'][] = array(
                        'text' => $category_info['name'],
                        'href' => $this->url->link('provider/product', 'path=' . $path . $url),
                        'separator' => $this->language->get('text_separator')
                    );
                }
            }
        } else {
            $category_id = 0;
        }

        $category_info = $this->model_catalog_category->getCategory($category_id);

        if ($category_info) {
            $this->document->setTitle($category_info['name']);
            $this->document->setDescription($category_info['meta_description']);
            $this->document->setKeywords($category_info['meta_keyword']);
            $this->document->addScript('catalog/view/javascript/jquery/jquery.total-storage.min.js');

            $this->data['heading_title'] = $category_info['name'];

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
            $this->data['text_add_service'] = $this->language->get('text_add_service');

            $this->data['subprofileid'] = $this->request->get['id'];
            $this->data['add'] = $this->url->link('provider/product/AddProductToSubprofile', '', 'SSL');;

            $this->data['button_add_su'] = $this->language->get('button_add_su');
            $this->data['button_wishlist'] = $this->language->get('button_wishlist');
            $this->data['button_compare'] = $this->language->get('button_compare');
            $this->data['button_continue'] = $this->language->get('button_continue');
            $this->data['button_add_service'] = $this->url->link('provider/service/insert', '', 'SSL');

            // Set the last category breadcrumb
            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }
            if (isset($this->request->get['id'])) {
                $url .= '&id=' . $this->request->get['id'];
            }

            $this->data['breadcrumbs'][] = array(
                'text' => $category_info['name'],
                'href' => $this->url->link('provider/product', 'path=' . $this->request->get['path']),
                'separator' => $this->language->get('text_separator')
            );

            if ($category_info['image']) {
                $this->data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
            } else {
                $this->data['thumb'] = '';
            }

            $this->data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
            $this->data['compare'] = $this->url->link('product/compare');

            $url = '';

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }
            if (isset($this->request->get['id'])) {
                $url .= '&id=' . $this->request->get['id'];
            }

            $this->data['categories'] = array();

            $results = $this->model_catalog_category->getCategories($category_id);

            foreach ($results as $result) {
                $data = array(
                    'filter_category_id' => $result['category_id'],
                    'filter_sub_category' => true
                );

                $product_total = $this->model_catalog_product->getTotalProducts($data);


                $this->data['categories'][] = array(
                    'name' => $result['name'] . ($this->config->get('config_product_count') ? ' (' . $product_total . ')' : ''),
                    'href' => $this->url->link('provider/product', 'path=' . $this->request->get['path'] . '_' . $result['category_id'] . $url)
                );
            }

            $this->data['products'] = array();

            $data = array(
                'filter_category_id' => $category_id,
                'filter_filter' => $filter,
                'sort' => $sort,
                'order' => $order,
                'start' => ($page - 1) * $limit,
                'limit' => $limit,
                'id' => $id,
                'filter_sub_category' => true
            );


            $product_total = $this->model_catalog_product->getTotalProducts($data);


            $results = $this->model_catalog_product->getProducts($data);

            $allproducts = $this->model_provider_pu_subprofile->GetAllProductsOfSubprofile($this->request->get['id']);
            foreach ($results as $result) {
                $exist = false;
                foreach ($allproducts as $result2) {
                    if ($result['product_id'] == $result2['product_id']) {
                        $exist = true;
                        break;
                    }
                }
                if (!$exist || $this->request->get['path'] == 60 ) {
                    if ($result['image']) {
                        $image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
                    } else {
                        $image = false;
                    }

                    if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                        $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
                    } else {
                        $price = false;
                    }

                    if ((float)$result['special']) {
                        $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
                    } else {
                        $special = false;
                    }

                    if ($this->config->get('config_tax')) {
                        $tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
                    } else {
                        $tax = false;
                    }

                    if ($this->config->get('config_review_status')) {
                        $rating = (int)$result['rating'];
                    } else {
                        $rating = false;
                    }

                    $this->data['products'][] = array(
                        'product_id' => $result['product_id'],
                        'thumb' => $image,
                        'name' => $result['name'],
                        'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
                        'price' => $price,
                        'special' => $special,
                        'tax' => $tax,
                        'rating' => $result['rating'],
                        'reviews' => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
                        'href' => $this->url->link('product/product', 'path=' . $this->request->get['path'] . '&product_id=' . $result['product_id'] . $url)
                    );
                }
            }

            $url = '';

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }
            if (isset($this->request->get['id'])) {
                $url .= '&id=' . $this->request->get['id'];
            }

            $this->data['sorts'] = array();

            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_default'),
                'value' => 'p.sort_order-ASC',
                'href' => $this->url->link('provider/product', 'path=' . $this->request->get['path'] . '&sort=p.sort_order&order=ASC' . $url)
            );

            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_name_asc'),
                'value' => 'pd.name-ASC',
                'href' => $this->url->link('provider/product', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=ASC' . $url)
            );

            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_name_desc'),
                'value' => 'pd.name-DESC',
                'href' => $this->url->link('provider/product', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=DESC' . $url)
            );

            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_price_asc'),
                'value' => 'p.price-ASC',
                'href' => $this->url->link('provider/product', 'path=' . $this->request->get['path'] . '&sort=p.price&order=ASC' . $url)
            );

            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_price_desc'),
                'value' => 'p.price-DESC',
                'href' => $this->url->link('provider/product', 'path=' . $this->request->get['path'] . '&sort=p.price&order=DESC' . $url)
            );

            if ($this->config->get('config_review_status')) {
                $this->data['sorts'][] = array(
                    'text' => $this->language->get('text_rating_desc'),
                    'value' => 'rating-DESC',
                    'href' => $this->url->link('provider/product', 'path=' . $this->request->get['path'] . '&sort=rating&order=DESC' . $url)
                );

                $this->data['sorts'][] = array(
                    'text' => $this->language->get('text_rating_asc'),
                    'value' => 'rating-ASC',
                    'href' => $this->url->link('provider/product', 'path=' . $this->request->get['path'] . '&sort=rating&order=ASC' . $url)
                );
            }

            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_model_asc'),
                'value' => 'p.model-ASC',
                'href' => $this->url->link('provider/product', 'path=' . $this->request->get['path'] . '&sort=p.model&order=ASC' . $url)
            );

            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_model_desc'),
                'value' => 'p.model-DESC',
                'href' => $this->url->link('provider/product', 'path=' . $this->request->get['path'] . '&sort=p.model&order=DESC' . $url)
            );

            $url = '';

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['id'])) {
                $url .= '&id=' . $this->request->get['id'];
            }

            $this->data['limits'] = array();

            $limits = array_unique(array($this->config->get('config_catalog_limit'), 25, 50, 75, 100));

            sort($limits);

            foreach ($limits as $value) {
                $this->data['limits'][] = array(
                    'text' => $value,
                    'value' => $value,
                    'href' => $this->url->link('provider/product', 'path=' . $this->request->get['path'] . $url . '&limit=' . $value)
                );
            }

            $url = '';

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }
            if (isset($this->request->get['id'])) {
                $url .= '&id=' . $this->request->get['id'];
            }

            $pagination = new Pagination();
            $pagination->total = $product_total;
            $pagination->page = $page;
            $pagination->limit = $limit;
            $pagination->text = $this->language->get('text_pagination');
            $pagination->url = $this->url->link('provider/product', 'path=' . $this->request->get['path'] . $url . '&page={page}');

            $this->data['pagination'] = $pagination->render();

            $this->data['sort'] = $sort;
            $this->data['order'] = $order;
            $this->data['limit'] = $limit;
            $this->data['path'] = $this->request->get['path'];

            $this->data['continue'] = $this->url->link('common/home');

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/provider/product.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/provider/product.tpl';
            } else {
                $this->template = 'default/template/provider/product.tpl';
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
        } else {
            $url = '';

            if (isset($this->request->get['id'])) {
                $url .= '&id=' . $this->request->get['id'];
            }

            if (isset($this->request->get['path'])) {
                $url .= '&path=' . $this->request->get['path'];
            }

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
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

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $this->data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_error'),
                'href' => $this->url->link('provider/product', $url),
                'separator' => $this->language->get('text_separator')
            );

            $this->document->setTitle($this->language->get('text_error'));

            $this->data['heading_title'] = $this->language->get('text_error');

            $this->data['text_error'] = $this->language->get('text_error');

            $this->data['button_continue'] = $this->language->get('button_continue');

            $this->data['continue'] = $this->url->link('common/home');

            $this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 404 Not Found');

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
            } else {
                $this->template = 'default/template/error/not_found.tpl';
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

    protected function AddProductToSubprofilevalidate()
    {
        return true;
        if ((utf8_strlen($this->request->post['price']) < 1) || (utf8_strlen($this->request->post['price']) > 32)) {
            $this->error['price'] = $this->language->get('error_price');
        }

        if ((utf8_strlen($this->request->post['description']) < 1) || (utf8_strlen($this->request->post['description']) > 32)) {
            $this->error['description'] = $this->language->get('error_description');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    public function AddProductToSubprofile()
    {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('provider/profile', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        $this->language->load('provider/AddProductToSubprofile');
        $this->data += $this->language->load('provider/AddProductToSubprofile');
        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('provider/pu_subprofile');
        $this->load->model('provider/pu_attribute');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->AddProductToSubprofilevalidate()) {
            $this->session->data['success'] = $this->language->get('text_success');
            $s_p_id = $this->model_provider_pu_subprofile->AddProductToSubprofile($this->request->post);

            $product_id = $this->request->post['product_id'];
            $subprofile_id = $this->request->post['subprofile_id'];

            foreach ($_POST['attribute'] as $key => $value) {
                if (is_array($value)) {
                    $value = implode(",", $value);
                }
                $this->model_provider_pu_attribute->addCustomAttribute($subprofile_id, $product_id, $key, $value);
            }
            $isBlockAttribute = $this->request->post['isBlockAttribute'];
            $blockAttributesId = $this->request->post['blockAttributesId'];
            if ($isBlockAttribute) {
                $this->redirect($this->url->link('provider/product/blockAttribute&' . 'blockAttributesId=' . $blockAttributesId .
                    '&product_id=' . $product_id .
                    '&id=' . $s_p_id .
                    '&subprofile_id=' . $subprofile_id, '', 'SSL'));
            } else {
                $this->redirect($this->url->link('provider/product/allsubprofiles', "", 'SSL'));
                //$this->redirect($this->url->link('financial/plan', "type=product&id=$s_p_id", 'SSL'));
            }
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
        $this->data['text_select'] = $this->language->get('text_select');
        $this->data['entry_buy_link'] = $this->language->get('entry_buy_link');


        $this->data['entry_price'] = $this->language->get('entry_price');
        $this->data['entry_description'] = $this->language->get('entry_description');
        $this->data['entry_availability'] = $this->language->get('entry_availability');
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

        if (isset($this->error['price'])) {
            $this->data['error_price'] = $this->error['price'];
        } else {
            $this->data['error_price'] = '';
        }
        if (isset($this->error['description'])) {
            $this->data['error_description'] = $this->error['description'];
        } else {
            $this->data['error_description'] = '';
        }
        if (isset($this->error['availability'])) {
            $this->data['error_availability'] = $this->error['availability'];
        } else {
            $this->data['error_availability'] = '';
        }

        $this->data['action'] = $this->url->link('provider/product/AddProductToSubprofile', '', 'SSL');

        if ($this->request->server['REQUEST_METHOD'] != 'POST') {
            if (isset($this->request->get['id']))
                $customer_info = $this->model_provider_pu_subprofile->GetCustomerSubProfile($this->request->get['id']);
        }
        $this->load->model('provider/pu_attribute');
        $this->load->model('catalog/product');
        $this->load->model('catalog/category');
        $this->load->model('customextension/pu_attribute');
        $isBlockAttribute = false;
        $blockAttributesId = '';
        if (isset($this->request->get['productid'])) {
            $this->data['product_id'] = $this->request->get['productid'];
            $product_id = $this->request->get['productid'];
            if ($this->model_provider_pu_attribute->isCustomProduct($product_id)) {
                $categories = $this->model_catalog_product->getCategories($this->request->get['productid']);
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

                        $attributes[] = array(
                            'attribute_id' => $attribute_info['attribute_id'],
                            'name' => $attribute_info['name'],
                            'type' => $attribute_info['type'],
                            'class' => $attribute_info['class'],
                            'values' => $values
                        );
                    }
                }
                $this->data['attributes'] = $attributes;
            }
        } else {
            $this->data['product_id'] = '';
        }
        if (isset($this->request->get['subprofileid'])) {
            $this->data['subprofile_id'] = $this->request->get['subprofileid'];
        } else {
            $this->data['subprofile_id'] = '';
        }
        if (isset($this->request->post['price'])) {
            $this->data['price'] = $this->request->post['price'];
        } elseif (isset($customer_info)) {
            $this->data['price'] = $customer_info['price'];
        } else {
            $this->data['price'] = '';
        }
        if (isset($this->request->post['buy_link'])) {
            $this->data['buy_link'] = $this->request->post['buy_link'];
        } elseif (isset($customer_info)) {
            $this->data['buy_link'] = $customer_info['buy_link'];
        } else {
            $this->data['buy_link'] = '';
        }
        if (isset($this->request->post['description'])) {
            $this->data['description'] = $this->request->post['description'];
        } elseif (isset($customer_info)) {
            $this->data['description'] = $customer_info['description'];
        } else {
            $this->data['description'] = '';
        }
        $this->data['isBlockAttribute'] = $isBlockAttribute;
        $this->data['blockAttributesId'] = $blockAttributesId;


        $this->data['back'] = $this->url->link('account/account', '', 'SSL');
        $this->data['add'] = $this->url->link('provider/subprofile/Add', '', 'SSL');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/provider/AddProductToSubprofile.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/provider/AddProductToSubprofile.tpl';
        } else {
            $this->template = 'default/template/provider/AddProductToSubprofile.tpl';
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

    public function AllSubProfiles()
    {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('provider/profile', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        $this->language->load('provider/product_allsubprofiles');

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
        $this->data['entry_addproduct'] = $this->language->get('entry_addproduct');


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
            $sub_info = $this->model_provider_pu_subprofile->GetSubprofileInfo($c['id']);
            if(($c_expire_date && strtotime($c_expire_date) > time()) || $sub_info['financial_exception'] == 1) {
                $expire_date[$c['id']] = true;
            }else{
                $expire_date[$c['id']] = false;
            }
        }

        $this->data['expire_date'] = $expire_date;
        $this->data['add'] = $this->url->link('provider/product', '', 'SSL');


        $this->data['back'] = $this->url->link('account/account', '', 'SSL');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/provider/product_allsubprofiles.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/provider/product_allsubprofiles.tpl';
        } else {
            $this->template = 'default/template/provider/product_allsubprofiles.tpl';
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
//        if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
//            $this->error['firstname'] = $this->language->get('error_firstname');
//        }
//
//        if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 32)) {
//            $this->error['lastname'] = $this->language->get('error_lastname');
//        }
//
//        //national code checking
//        if (!preg_match("/^\d{10}$/", $this->request->post['nationalcode'])) {
//            $this->error['nationalcode'] = $this->language->get('error_nationalcode');
//        }
//        else
//        {
//            $input=$this->request->post['nationalcode'];
//            $check = (int) $input[9];
//            $sum = array_sum(array_map(function ($x) use ($input) {
//                    return ((int) $input[$x]) * (10 - $x);
//                }, range(0, 8))) % 11;
//            if(!($sum < 2 && $check == $sum || $sum >= 2 && $check + $sum == 11))
//            {
//                $this->error['nationalcode'] = $this->language->get('error_nationalcode');
//            }
//        }
//
//        if ((utf8_strlen($this->request->post['birthplace']) < 1) || (utf8_strlen($this->request->post['birthplace']) > 32)) {
//            $this->error['birthplace'] = $this->language->get('error_birthplace');
//        }
//
//        if ((utf8_strlen($this->request->post['fathername']) < 1) || (utf8_strlen($this->request->post['fathername']) > 32)) {
//            $this->error['fathername'] = $this->language->get('error_fathername');
//        }
//        if (!$this->error) {
//            return true;
//        } else {
//            return false;
//        }
    }

    public function blockAttribute()
    {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('provider/profile', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        $this->language->load('provider/blockAttribute');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('provider/pu_subprofile');
        $this->load->model('provider/pu_attribute');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->AddProductToSubprofilevalidate()) {
            $this->load->model('customextension/pu_block_attribute_subprofile_value');
            $maximum = $this->model_customextension_pu_block_attribute_subprofile_value->maxRow();
            $maximum++;
            $id = $this->request->post['id'];
            $subprofile_id = $this->request->post['subprofile_id'];
            $product_id = $this->request->post['product_id'];
            $this->session->data['success'] = $this->language->get('text_success');
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
            $this->redirect($this->url->link('financial/plan', "type=product&id=$id", 'SSL'));
        }
        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }
        $id = $this->request->get['id'];
        $attributesId = $this->request->get['blockAttributesId'];
        $product_id = $this->request->get['product_id'];
        $subprofile_id = $this->request->get['subprofile_id'];
        $this->data['id'] = $id;
        $this->data['product_id'] = $product_id;
        $this->data['subprofile_id'] = $subprofile_id;
        $attributesId = explode(',', $attributesId);
        $this->load->model('customextension/pu_block');
        $this->load->model('customextension/pu_block_attribute');
        $this->load->model('customextension/pu_block_attribute_value');
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
        $this->data['text_select'] = $this->language->get('text_select');
        $this->data['entry_buy_link'] = $this->language->get('entry_buy_link');
        $this->data['entry_price'] = $this->language->get('entry_price');
        $this->data['entry_description'] = $this->language->get('entry_description');
        $this->data['entry_availability'] = $this->language->get('entry_availability');
        $this->data['entry_available'] = $this->language->get('entry_available');
        $this->data['entry_unavailable'] = $this->language->get('entry_unavailable');
        $this->data['entry_soon'] = $this->language->get('entry_soon');
        $this->data['button_add'] = $this->language->get('button_add');
        $this->data['button_continue'] = $this->language->get('button_continue');
        $this->data['button_back'] = $this->language->get('button_back');
        $this->data['action'] = $this->url->link('provider/product/blockAttribute', '', 'SSL');
        $this->data['back'] = $this->url->link('account/account', '', 'SSL');
        $this->data['add'] = $this->url->link('provider/subprofile/Add', '', 'SSL');
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/provider/blockAttribute.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/provider/blockAttribute.tpl';
        } else {
            $this->template = 'default/template/provider/blockAttribute.tpl';
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

    public function autocomplete()
    {
        $json = array();
        if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model']) || isset($this->request->get['filter_category_id'])) {
            $this->load->model('provider/pu_product');
            $this->load->model('provider/pu_option');
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
            $results = $this->model_provider_pu_product->getProducts($data);
            foreach ($results as $result) {
                $option_data = array();
                $product_options = $this->model_provider_pu_product->getProductOptions($result['product_id']);
                foreach ($product_options as $product_option) {
                    $option_info = $this->model_provider_pu_option->getOption($product_option['option_id']);
                    if ($option_info) {
                        if ($option_info['type'] == 'select' || $option_info['type'] == 'radio' || $option_info['type'] == 'checkbox' || $option_info['type'] == 'image') {
                            $option_value_data = array();
                            foreach ($product_option['product_option_value'] as $product_option_value) {
                                $option_value_info = $this->model_provider_pu_option->getOptionValue($product_option_value['option_value_id']);
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