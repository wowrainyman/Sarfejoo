<?php

class ControllerSaleProduct extends Controller
{
    private $error = array();

    public function index()
    {
        if (!isset($this->request->get['subprofile_id'])) {
            $this->redirect($this->url->link('sale/subprofile', 'token=' . $this->session->data['token'], 'SSL'));
        }
        $this->language->load('sale/product');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('sale/product');

        $this->getList();
    }

    public function update()
    {
        $this->language->load('sale/product');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('sale/product');
        $this->load->model('provider/pu_attribute');

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $subprofile_product_id = $this->request->post['subprofile_product_id'];
            $this->model_sale_product->UpdateProductPrice($subprofile_product_id, $this->request->post['price']);
            $this->model_sale_product->UpdateProductAvailability($subprofile_product_id, $this->request->post['availability']);
            $this->model_sale_product->UpdateProductDescription($subprofile_product_id, $this->request->post['description']);
            $this->model_sale_product->UpdateProductBuyLink($subprofile_product_id, $this->request->post['buy_link']);
            foreach ($_POST['attribute'] as $key => $value) {
                if (is_array($value)) {
                    $value = implode(",", $value);
                }
                echo $value;
                $this->model_provider_pu_attribute->UpdateCustomAttribute($key, $value);
            }
            $this->redirect($this->url->link('sale/subprofile', 'token=' . $this->session->data['token'], 'SSL'));
        } else {
            $this->getForm();
        }
    }

    protected function getList()
    {
        if (isset($this->request->get['filter_id'])) {
            $filter_id = $this->request->get['filter_id'];
        } else {
            $filter_id = null;
        }
        if (isset($this->request->get['filter_name'])) {
            $filter_name = $this->request->get['filter_name'];
        } else {
            $filter_name = null;
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'name';
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

        $url = '';

        if (isset($this->request->get['filter_id'])) {
            $url .= '&filter_id=' . urlencode(html_entity_decode($this->request->get['filter_id'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
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
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );

        $this->load->model('sale/customer');
        $this->data['customers'] = array();

        $data = array(
            'filter_id' => $filter_id,
            'filter_name' => $filter_name,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit' => $this->config->get('config_admin_limit')
        );
        $this->data['subprofile_id'] = $this->request->get['subprofile_id'];
        $product_total = $this->model_sale_product->GetAllProducts($data, $this->request->get['subprofile_id']);

        $results = $this->model_sale_product->GetProducts($data, $this->request->get['subprofile_id']);
        foreach ($results as $result) {
            $action = array();

            $action[] = array(
                'text' => $this->language->get('text_edit'),
            );
            $expireDate = $this->model_sale_product->GetProductExpireDate($result['id']);
            $this->data['products'][] = array(
                'id' => $result['id'],
                'product_id' => $result['product_id'],
                'subprofile_id' => $result['subprofile_id'],
                'name' => $result['name'],
                'price' => $result['price'],
                'description' => $result['description'],
                'buy_link' => $result['buy_link'],
                'view_count' => $result['view_count'],
                'availability' => $result['availability'],
                'update_date' => $result['update_date'],
                'status_id' => $result['status_id'],
                'is_payed' => $result['is_payed'],
                'expire_date' => $expireDate == 0 ? 'Unlimited' : $expireDate,
                'edit_link' => $this->url->link('sale/product/update', 'token=' . $this->session->data['token'] . '&subprofile_product_id=' . $result['id'] . $url, 'SSL'),
                'action' => $action
            );
        }

        $this->data += $this->language->load('sale/product');

        $this->data['token'] = $this->session->data['token'];

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }

        $url = '';

        if (isset($this->request->get['filter_id'])) {
            $url .= '&filter_id=' . urlencode(html_entity_decode($this->request->get['filter_id'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $url .= '&subprofile_id=' . $this->request->get['subprofile_id'];

        $this->data['sort_id'] = $this->url->link('sale/product', 'token=' . $this->session->data['token'] . '&sort=tab1.id' . $url, 'SSL');
        $this->data['sort_name'] = $this->url->link('sale/product', 'token=' . $this->session->data['token'] . '&sort=tab2.name' . $url, 'SSL');
        $this->data['sort_product_id'] = $this->url->link('sale/product', 'token=' . $this->session->data['token'] . '&sort=tab1.product_id' . $url, 'SSL');
        $this->data['sort_view_count'] = $this->url->link('sale/product', 'token=' . $this->session->data['token'] . '&sort=tab1.view_count' . $url, 'SSL');
        $this->data['sort_update_date'] = $this->url->link('sale/product', 'token=' . $this->session->data['token'] . '&sort=tab1.update_date' . $url, 'SSL');
        $this->data['sort_availability'] = $this->url->link('sale/product', 'token=' . $this->session->data['token'] . '&sort=tab1.availability' . $url, 'SSL');
        $this->data['sort_status_id'] = $this->url->link('sale/product', 'token=' . $this->session->data['token'] . '&sort=tab1.status_id' . $url, 'SSL');
        $this->data['sort_is_payed'] = $this->url->link('sale/product', 'token=' . $this->session->data['token'] . '&sort=tab1.is_payed' . $url, 'SSL');

        $url = '';

        if (isset($this->request->get['filter_id'])) {
            $url .= '&filter_id=' . urlencode(html_entity_decode($this->request->get['filter_id'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $product_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('sale/product', 'token=' . $this->session->data['token'] . $url . '&page={page}&subprofile_id=' . $this->request->get['subprofile_id'], 'SSL');

        $this->data['pagination'] = $pagination->render();

        $this->data['filter_id'] = $filter_id;
        $this->data['filter_name'] = $filter_name;


        $this->data['sort'] = $sort;
        $this->data['order'] = $order;

        $this->template = 'sale/product_list.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    protected function getForm()
    {
        $this->data += $this->language->load('sale/product');
        $this->data['token'] = $this->session->data['token'];
        if (isset($this->request->get['subprofile_product_id'])) {
            $this->data['subprofile_product_id'] = $this->request->get['subprofile_product_id'];
        } else {
            $this->data['subprofile_product_id'] = 0;
        }


        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('sale/customer', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['action'] = $this->url->link('sale/product/update', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['cancel'] = $this->url->link('sale/product', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['subprofile_product_id'] = $this->request->get['subprofile_product_id'];
        if (isset($this->request->get['subprofile_product_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $subprofile_product_info = $this->model_sale_product->GetSubprofileProduct($this->request->get['subprofile_product_id']);
        }

        foreach ($subprofile_product_info as $key => $value) {
            if (isset($this->request->post[$key])) {
                $this->data[$key] = $this->request->post[$key];
            } elseif (!empty($subprofile_product_info)) {
                $this->data[$key] = $value;
            } else {
                $this->data[$key] = '';
            }
        }
        $this->load->model('provider/pu_attribute');
        $this->load->model('catalog/product');
        $this->load->model('catalog/category');
        $this->load->model('customextension/pu_attribute');
        $customAttributes = null;
        $blockAttributesId = '';
        if ($this->model_provider_pu_attribute->isCustomProduct($subprofile_product_info['product_id'])) {
            $categories = $this->model_catalog_product->getCategories($subprofile_product_info['product_id']);
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
                    $selected_value = $this->model_provider_pu_attribute->getAttributeValue($subprofile_product_info['subprofile_id'], $subprofile_product_info['product_id'], $attribute_info['attribute_id']);
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
        $this->data['customAttributes'] = $customAttributes;
        $this->template = 'sale/product_form.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

}

?>