<?php
require_once "jdf.php";
class ControllerCommonHeader extends Controller
{
    protected function index()
    {
        $this->load->model('tool/image');
        $this->data['title'] = $this->document->getTitle();
        $this->data['date'] = jdate("l - j F o");

        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $this->data['base'] = $this->config->get('config_ssl');
        } else {
            $this->data['base'] = $this->config->get('config_url');
        }

        $this->data['description'] = $this->document->getDescription();
        $this->data['keywords'] = $this->document->getKeywords();
        $this->data['links'] = $this->document->getLinks();
        $this->data['styles'] = $this->document->getStyles();
        $this->data['scripts'] = $this->document->getScripts();
        $this->data['lang'] = $this->language->get('code');
        $this->data['direction'] = $this->language->get('direction');
        $this->data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');

          $category_blog_id = 0;
          if (!empty($this->request->get['path'])) {
               $cbi_explode   =    explode('_', $this->request->get['path']);
               $category_blog_id = (int) array_pop($cbi_explode);
          }

          $this->load->model('blog/blog');
          $category_blog_how_to = $this->model_blog_blog->getCateguryHowToBuyLink($category_blog_id);
             while ($row = mysqli_fetch_assoc($category_blog_how_to)) {
                  $this->data['blog_post_title'] =$row ['title'];
                  $this->data['blog_post_link'] =$row ['link'];
              }
              
        // Load balance
        if ($this->customer->isLogged()) {
            $this->load->model('payment/balance');
            $balance_info = $this->model_payment_balance->getBalance($this->customer->getId());
            $balance_value = $balance_info['balance'];
        }
        if (isset($balance_value)) {
            $this->data['balance_value'] = $balance_value;
        } else {
            $this->data['balance_value'] = 0;
        }
        // Whos Online
        if ($this->config->get('config_customer_online')) {
            $this->load->model('tool/online');

            if (isset($this->request->server['REMOTE_ADDR'])) {
                $ip = $this->request->server['REMOTE_ADDR'];
            } else {
                $ip = '';
            }

            if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
                $url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
            } else {
                $url = '';
            }

            if (isset($this->request->server['HTTP_REFERER'])) {
                $referer = $this->request->server['HTTP_REFERER'];
            } else {
                $referer = '';
            }

            $this->model_tool_online->whosonline($ip, $this->customer->getId(), $url, $referer);
        }

        $this->language->load('common/header');

        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $server = HTTPS_IMAGE;
        } else {
            $server = HTTP_IMAGE;
        }

        if ($this->config->get('config_icon') && file_exists(DIR_IMAGE . $this->config->get('config_icon'))) {
            $this->data['icon'] = $server . $this->config->get('config_icon');
        } else {
            $this->data['icon'] = '';
        }

        $this->data['name'] = $this->config->get('config_name');

        if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
            $this->data['logo'] = $server . $this->config->get('config_logo');
        } else {
            $this->data['logo'] = '';
        }



        $this->data['text_home'] = $this->language->get('text_home');
        $this->data['text_he_notif'] = $this->language->get('text_he_notif');
        $this->data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
        $this->data['text_count_wishlist'] = isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0;
        $this->data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
        $this->data['text_search'] = $this->language->get('text_search');
        $this->data['text_blog'] = $this->language->get('text_blog');


        $this->data['text_welcome'] = sprintf($this->language->get('text_welcome'), $this->url->link('account/login', '', 'SSL'), $this->url->link('account/register', '', 'SSL'));
        $this->data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', 'SSL'), $this->customer->getFirstName(), $this->url->link('account/logout', '', 'SSL'));
        $this->data['text_account'] = $this->language->get('text_account');
        $this->data['text_checkout'] = $this->language->get('text_checkout');

        $this->data['home'] = $this->url->link('common/home');
        $this->data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
        $this->data['logged'] = $this->customer->isLogged();
        $this->data['account'] = $this->url->link('account/account', '', 'SSL');
        $this->data['shopping_cart'] = $this->url->link('checkout/cart');
        $this->data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');

        if (isset($this->request->get['filter_name'])) {
            $this->data['filter_name'] = $this->request->get['filter_name'];
        } else {
            $this->data['filter_name'] = '';
        }

        // Menu
        $this->load->model('module/home');

        $this->load->model('catalog/product');

        $this->data['categories'] = array();

        $categories = $this->model_catalog_category->getCategories(0);

        foreach ($categories as $category) {
            if ($category['top']) {
                $children_data = array();

                $children = $this->model_catalog_category->getCategories($category['category_id']);

                foreach ($children as $child) {
                    $data = array(
                        'filter_category_id' => $child['category_id'],
                        'filter_sub_category' => true
                    );
                    /*Begin of the extension Header menu add level 3 sub categories extension code  to be replaced:
                    
				$mfp = NULL;
				
				if( isset( $this->request->get['mfp'] ) ) {
					$mfp = $this->request->get['mfp'];
					unset( $this->request->get['mfp'] );
				}
				
				$product_total = $this->model_catalog_product->getTotalProducts($data);
				
				if( $mfp !== NULL ) {
					$this->request->get['mfp'] = $mfp;
				}
			

                    $children_data[] = array(
                        'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $product_total . ')' : ''),
                        'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
                    );
                    */
                    // Level 2
                    $children_level2 = $this->model_catalog_category->getCategories($child['category_id']);
                    $children_data_level2 = array();
                    foreach ($children_level2 as $child_level2) {
                        $data_level2 = array(
                            'filter_category_id' => $child_level2['category_id'],
                            'filter_sub_category' => true
                        );
                        $product_total_level2 = '';
                        if ($this->config->get('config_product_count')) {
                            $product_total_level2 = ' (' . $this->model_catalog_product->getTotalProducts($data_level2) . ')';
                        }

                        $children_data_level2[] = array(
                            'name' => $child_level2['name'] . $product_total_level2,
                            'href' => $this->url->link('product/category', 'path=' . $child['category_id'] . '_' . $child_level2['category_id']),
                            'id' => $category['category_id'] . '_' . $child['category_id'] . '_' . $child_level2['category_id']
                        );
                    }
                    $children_data[] = array (
                        'name' => $child['name'],
                        'icon_class' => $child['icon_class'],
                        'href' => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id']),
                        'id' => $category['category_id'] . '_' . $child['category_id'],
                        'children_level2' => $children_data_level2,
                    );
                    //END of the extension Header menu add level 3 sub categories extension

                }

                // Level 1
                $this->data['categories'][] = array(
                    'name' => $category['name'],
                    'children' => $children_data,
                    'column' => $category['column'] ? $category['column'] : 1,
                    'href' => $this->url->link('product/category', 'path=' . $category['category_id'])
                );
            }
        }

        $this->children = array(
            'module/language',
            'module/currency',
            'module/cart'
        );

        // Compare
        $this->data['compare'] = $this->url->link('product/compare');
        $this->data['text_compare'] = $this->language->get('text_compare');
        $this->data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
        $this->data['text_count_compare'] = isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0;


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
                $this->data['compare_products'][] = array(
                    'product_id' => $product_info['product_id'],
                    'name' => $product_info['name'],
                    'thumb' => $image,
                    'price' => $price,
                    'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, 200) . '..',
                    'model' => $product_info['model'],
                    'manufacturer' => $product_info['manufacturer'],
                    'rating' => (int)$product_info['rating'],
                    'reviews' => sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']),
                    'weight' => $this->weight->format($product_info['weight'], $product_info['weight_class_id']),
                    'length' => $this->length->format($product_info['length'], $product_info['length_class_id']),
                    'width' => $this->length->format($product_info['width'], $product_info['length_class_id']),
                    'height' => $this->length->format($product_info['height'], $product_info['length_class_id']),
                    'href' => $this->url->link('product/product', 'product_id=' . $product_id),
                    'remove' => $this->url->link('product/compare', 'remove=' . $product_id)
                );
            } else {
                unset($this->session->data['compare'][$key]);
            }
        }

        foreach ($this->session->data['wishlist'] as $key => $product_id) {
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
                $this->data['wish_products'][] = array(
                    'product_id' => $product_info['product_id'],
                    'name' => $product_info['name'],
                    'thumb' => $image,
                    'price' => $price,
                    'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, 200) . '..',
                    'model' => $product_info['model'],
                    'manufacturer' => $product_info['manufacturer'],
                    'rating' => (int)$product_info['rating'],
                    'reviews' => sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']),
                    'weight' => $this->weight->format($product_info['weight'], $product_info['weight_class_id']),
                    'length' => $this->length->format($product_info['length'], $product_info['length_class_id']),
                    'width' => $this->length->format($product_info['width'], $product_info['length_class_id']),
                    'height' => $this->length->format($product_info['height'], $product_info['length_class_id']),
                    'href' => $this->url->link('product/product', 'product_id=' . $product_id),
                    'remove' => $this->url->link('product/compare', 'remove=' . $product_id)
                );
            } else {
                unset($this->session->data['compare'][$key]);
            }
        }
        $this->data['compare_link'] = $this->url->link('product/compare', '');
        $this->data['favorite_link'] = $this->url->link('account/wishlist', '');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/common/header.tpl';
        } else {
            $this->template = 'default/template/common/header.tpl';
        }

        $this->render();
    }
}

?>