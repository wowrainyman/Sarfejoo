<?php
require_once "jdf.php";

class ControllerProductProduct extends Controller
{
    private $error = array();

    public function rating()
    {
        $aResponse['error'] = false;
        $aResponse['message'] = '';

// ONLY FOR THE DEMO, YOU CAN REMOVE THIS VAR
        $aResponse['server'] = '';
// END ONLY FOR DEMO


        if (isset($_POST['action'])) {
            if (htmlentities($_POST['action'], ENT_QUOTES, 'UTF-8') == 'rating') {

                /*
                * vars
                */
                $id = intval($_POST['idBox']);
                $rate = floatval($_POST['rate']);

                // YOUR MYSQL REQUEST HERE or other thing :)
                /*
                *
                */
                $this->load->model('module/rating');
                $success = $this->model_module_rating->addRate($id, $this->customer->getId(), $rate);


                // json datas send to the js file
                if ($success) {
                    $aResponse['message'] = 'رای شما با موفقیت ثبت شد :)';

                    // ONLY FOR THE DEMO, YOU CAN REMOVE THE CODE UNDER
                    $aResponse['server'] = '<strong>Success answer :</strong> Success : Your rate has been recorded. Thanks for your rate :)<br />';
                    $aResponse['server'] .= '<strong>Rate received :</strong> ' . $rate . '<br />';
                    $aResponse['server'] .= '<strong>ID to update :</strong> ' . $id;
                    // END ONLY FOR DEMO

                    echo json_encode($aResponse);
                } else {
                    $aResponse['message'] = 'رای شما قبلا ثبت شده است';

                    // ONLY FOR THE DEMO, YOU CAN REMOVE THE CODE UNDER
                    $aResponse['server'] = '<strong>Success answer :</strong> Success : Your rate has been recorded. Thanks for your rate :)<br />';
                    $aResponse['server'] .= '<strong>Rate received :</strong> ' . $rate . '<br />';
                    $aResponse['server'] .= '<strong>ID to update :</strong> ' . $id;
                    // END ONLY FOR DEMO

                    echo json_encode($aResponse);
                }
            } else {
                $aResponse['error'] = true;
                $aResponse['message'] = '"action" post data not equal to \'rating\'';

                // ONLY FOR THE DEMO, YOU CAN REMOVE THE CODE UNDER
                $aResponse['server'] = '<strong>ERROR :</strong> "action" post data not equal to \'rating\'';
                // END ONLY FOR DEMO


                echo json_encode($aResponse);
            }
        } else {
            $aResponse['error'] = true;
            $aResponse['message'] = 'not found';

            // ONLY FOR THE DEMO, YOU CAN REMOVE THE CODE UNDER
            $aResponse['server'] = '<strong>ERROR :</strong> not found';
            // END ONLY FOR DEMO


            echo json_encode($aResponse);
        }
    }

    public function index()
    {
        if (isset($this->session->data['seo'])) {
            $this->data['myurl'] = $this->session->data['seo'];
            unset($this->session->data['seo']);
        }

        $this->document->addStyle("catalog/view/css/BootstrapImageGallery/css/blueimp-gallery.min.css");
        $this->document->addScript('catalog/view/css/BootstrapImageGallery/js/jquery.blueimp-gallery.min.js');
        $this->document->addStyle("catalog/view/css/BootstrapImageGallery/css/bootstrap-image-gallery.css");
        $this->document->addScript('catalog/view/css/BootstrapImageGallery/js/bootstrap-image-gallery.js');
        $this->document->addStyle("catalog/view/javascript/jRating.jquery.css");
        $this->document->addScript('catalog/view/javascript/jRating.jquery.js');
        $this->document->addStyle("catalog/view/css/bootstrap-toggle/css/bootstrap2-toggle.css");
        $this->document->addScript('catalog/view/css/bootstrap-toggle/js/bootstrap2-toggle.js');

        $this->language->load('product/product');

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->config->get('config_url'),
            'separator' => false
        );

# Start Light Box CSS & scripts
        $this->document->addStyle("catalog/view/theme/default/stylesheet/sarfejoo/lightbox/lib/sweet-alert.css");
        $this->document->addScript('catalog/view/theme/default/stylesheet/sarfejoo/lightbox/lib/sweet-alert.min.js');
# End Light Box CSS & scripts

        $product_infos = array();
        $this->load->model('catalog/product');
        $this->load->model('tool/image');
        if (isset($this->session->data['compare'])) {
            foreach ($this->session->data['compare'] as $product_id) {
                $product_info = $this->model_catalog_product->getProduct($product_id);
                if ($product_info['image']) {
                    $product_info['thumb'] = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));
                } else {
                    $product_info['thumb'] = '';
                }
                $product_infos[] = $product_info;
            }
        }
        $this->data['product_infos'] = $product_infos;


        $this->load->model('catalog/category');

        $this->load->model('provider/pu_subprofile');

        if (isset($this->request->get['path'])) {
            $path = '';

            $parts = explode('_', (string)$this->request->get['path']);

            $category_id = (int)array_pop($parts);

            foreach ($parts as $path_id) {
                if (!$path) {
                    $path = $path_id;
                } else {
                    $path .= '_' . $path_id;
                }

                $category_info = $this->model_catalog_category->getCategory($path_id);

                if ($category_info) {
                    $this->data['breadcrumbs'][] = array(
                        'text' => $category_info['name'],
                        'href' => $this->url->link('product/category', 'path=' . $path),
                        'separator' => $this->language->get('text_separator')
                    );
                }
            }

            // Set the last category breadcrumb
            $category_info = $this->model_catalog_category->getCategory($category_id);

            if ($category_info) {
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

                $this->data['breadcrumbs'][] = array(
                    'text' => $category_info['name'],
                    'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url),
                    'separator' => $this->language->get('text_separator')
                );
            }
        }

        $this->load->model('catalog/manufacturer');

        if (isset($this->request->get['manufacturer_id'])) {
            $this->data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_brand'),
                'href' => $this->url->link('product/manufacturer'),
                'separator' => $this->language->get('text_separator')
            );

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

            $manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($this->request->get['manufacturer_id']);

            if ($manufacturer_info) {
                $this->data['breadcrumbs'][] = array(
                    'text' => $manufacturer_info['name'],
                    'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . $url),
                    'separator' => $this->language->get('text_separator')
                );
            }
        }

        if (isset($this->request->get['search']) || isset($this->request->get['tag'])) {
            $url = '';

            if (isset($this->request->get['search'])) {
                $url .= '&search=' . $this->request->get['search'];
            }

            if (isset($this->request->get['tag'])) {
                $url .= '&tag=' . $this->request->get['tag'];
            }

            if (isset($this->request->get['description'])) {
                $url .= '&description=' . $this->request->get['description'];
            }

            if (isset($this->request->get['category_id'])) {
                $url .= '&category_id=' . $this->request->get['category_id'];
            }

            if (isset($this->request->get['sub_category'])) {
                $url .= '&sub_category=' . $this->request->get['sub_category'];
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
                'text' => $this->language->get('text_search'),
                'href' => $this->url->link('product/search', $url),
                'separator' => $this->language->get('text_separator')
            );
        }

        if (isset($this->request->get['product_id'])) {
            $product_id = (int)$this->request->get['product_id'];
        } else {
            $product_id = 0;
        }

        $this->load->model('catalog/product');

        $product_info = $this->model_catalog_product->getProduct($product_id);

        $this->data['date_added'] = jdate("l - j F o", strtotime($product_info['date_added']));


        if ($product_info) {
            $this->data['stext'] = $this->generateSeoText($product_info['seo_generator'], $product_info['rss_link']);
            $url = '';

            if (isset($this->request->get['path'])) {
                $url .= '&path=' . $this->request->get['path'];
            }

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['manufacturer_id'])) {
                $url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
            }

            if (isset($this->request->get['search'])) {
                $url .= '&search=' . $this->request->get['search'];
            }

            if (isset($this->request->get['tag'])) {
                $url .= '&tag=' . $this->request->get['tag'];
            }

            if (isset($this->request->get['description'])) {
                $url .= '&description=' . $this->request->get['description'];
            }

            if (isset($this->request->get['category_id'])) {
                $url .= '&category_id=' . $this->request->get['category_id'];
            }

            if (isset($this->request->get['sub_category'])) {
                $url .= '&sub_category=' . $this->request->get['sub_category'];
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
                'text' => $product_info['name'],
                'href' => $this->url->link('product/product', $url . '&product_id=' . $this->request->get['product_id']),
                'separator' => $this->language->get('text_separator')
            );
            ($product_info['custom_title'] == '')?$this->document->setTitle(((isset($category_info['name']))?($category_info['name'].' : '):'').$product_info['name']):$this->document->setTitle($product_info['custom_title']);
            $this->document->setDescription($product_info['meta_description']);
            $this->document->setKeywords($product_info['meta_keyword']);
            $this->document->addLink($this->url->link('product/product', 'product_id=' . $this->request->get['product_id']), 'canonical');
            $this->document->addScript('catalog/view/javascript/jquery/tabs.js');
            $this->document->addScript('catalog/view/javascript/jquery/colorbox/jquery.colorbox-min.js');
            $this->document->addStyle('catalog/view/javascript/jquery/colorbox/colorbox.css');
            $this->data['heading_title'] = ($product_info['custom_h1'] <> '')?$product_info['custom_h1']:$product_info['name'];
            $this->data['text_he_notif'] = $this->language->get('text_he_notif');
$this->data['custom_alt'] = $product_info['custom_alt'];
            $this->data['text_select'] = $this->language->get('text_select');
            $this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
            $this->data['text_model'] = $this->language->get('text_model');
            $this->data['text_reward'] = $this->language->get('text_reward');
            $this->data['text_points'] = $this->language->get('text_points');
            $this->data['text_discount'] = $this->language->get('text_discount');
            $this->data['text_stock'] = $this->language->get('text_stock');
            $this->data['text_price'] = $this->language->get('text_price');
            $this->data['text_tax'] = $this->language->get('text_tax');
            $this->data['text_discount'] = $this->language->get('text_discount');
            $this->data['text_option'] = $this->language->get('text_option');
            $this->data['text_qty'] = $this->language->get('text_qty');
            $this->data['text_minimum'] = sprintf($this->language->get('text_minimum'), $product_info['minimum']);
            $this->data['text_or'] = $this->language->get('text_or');
            $this->data['text_write'] = $this->language->get('text_write');
            $this->data['text_note'] = $this->language->get('text_note');
            $this->data['text_share'] = $this->language->get('text_share');
            $this->data['text_wait'] = $this->language->get('text_wait');
            $this->data['text_tags'] = $this->language->get('text_tags');
            $this->data['text_last_update'] = $this->language->get('text_last_update');
            $this->data['entry_name'] = $this->language->get('entry_name');
            $this->data['entry_review'] = $this->language->get('entry_review');
            $this->data['entry_rating'] = $this->language->get('entry_rating');
            $this->data['entry_good'] = $this->language->get('entry_good');
            $this->data['entry_bad'] = $this->language->get('entry_bad');
            $this->data['entry_captcha'] = $this->language->get('entry_captcha');
            $this->data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
            $this->data['button_cart'] = $this->language->get('button_cart');
            $this->data['button_wishlist'] = $this->language->get('button_wishlist');
            $this->data['button_compare'] = $this->language->get('button_compare');
            $this->data['button_upload'] = $this->language->get('button_upload');
            $this->data['button_continue'] = $this->language->get('button_continue');
            $this->data['compare'] = $this->url->link('product/compare');
            $this->load->model('catalog/review');
            $this->data['tab_description'] = $this->language->get('tab_description');
            $this->data['tab_attribute'] = $this->language->get('tab_attribute');
            $this->data['tab_review'] = sprintf($this->language->get('tab_review'), $product_info['reviews']);
            $this->data['tab_related'] = $this->language->get('tab_related');
            $this->data['tab_map'] = $this->language->get('tab_map');
            $this->data['product_id'] = $this->request->get['product_id'];
            $this->data['manufacturer'] = $product_info['manufacturer'];
            $this->data['manufacturers'] = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $product_info['manufacturer_id']);
            $this->data['model'] = $product_info['model'];
            $this->data['name'] = $product_info['name'];
            $this->data['reward'] = $product_info['reward'];
            $this->data['points'] = $product_info['points'];

			
				$this->data['mbreadcrumbs'] = array();

				$this->data['mbreadcrumbs'][] = array(
					'text'      => $this->language->get('text_home'),
					'href'      => $this->url->link('common/home')
				);
				
				if ($this->model_catalog_product->getFullPath($this->request->get['product_id'])) {
					
					$path = '';
			
					$parts = explode('_', (string)$this->model_catalog_product->getFullPath($this->request->get['product_id']));
					
					$category_id = (int)array_pop($parts);
											
					foreach ($parts as $path_id) {
						if (!$path) {
							$path = $path_id;
						} else {
							$path .= '_' . $path_id;
						}
						
						$category_info = $this->model_catalog_category->getCategory($path_id);
						
						if ($category_info) {
							$this->data['mbreadcrumbs'][] = array(
								'text'      => $category_info['name'],
								'href'      => $this->url->link('product/category', 'path=' . $path)								
							);
						}
					}
					
					$category_info = $this->model_catalog_category->getCategory($category_id);
					
					if ($category_info) {			
						$url = '';
											
						$this->data['mbreadcrumbs'][] = array(
							'text'      => $category_info['name'],
							'href'      => $this->url->link('product/category', 'path=' . $this->model_catalog_product->getFullPath($this->request->get['product_id']))						
						);
					}
			
				
				} else {
				$this->data['mbreadcrumb'] = false;
				}
				
				$this->data['review_no'] = $product_info['reviews'];		
				$this->data['quantity'] = $product_info['quantity'];						
			
			
            if ($product_info['quantity'] <= 0) {
                $this->data['stock'] = $product_info['stock_status'];
            } elseif ($this->config->get('config_stock_display')) {
                $this->data['stock'] = $product_info['quantity'];
            } else {
                $this->data['stock'] = $this->language->get('text_instock');
            }
            $this->load->model('tool/image');
            if ($product_info['image']) {
                $this->data['popup'] = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
            } else {
                $this->data['popup'] = '';
            }
            if ($product_info['image']) {
                $this->data['thumb'] = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));
            } else {
                $this->data['thumb'] = '';
            }
            $this->data['href'] = $this->url->link('product/product', 'product_id=' . $product_id);
            $this->data['images'] = array();
            $related_products = $this->model_catalog_product->getProductRelated($this->request->get['product_id']);
            foreach ($related_products as $result) {
                if ($result['image']) {
                    $image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
                } else {
                    $image = false;
                }
                $this->data['related_products'][] = array(
                    'product_id' => $result['product_id'],
                    'thumb' => $image,
                    'name' => $result['name'],
                    'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
                    'rating' => $result['rating'],
                    'reviews' => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
                    'href' => $this->url->link('product/product', '&product_id=' . $result['product_id'] . $url),
                );
            }

            $results = $this->model_catalog_product->getProductImages($this->request->get['product_id']);
            foreach ($results as $result) {
                $this->data['images'][] = array(
                    'popup' => $this->model_tool_image->resize($result['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')),
                    'thumb' => $this->model_tool_image->resize($result['image'], $this->config->get('config_image_additional_width'), $this->config->get('config_image_additional_height'))
                );
            }
            if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                $this->data['price'] = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
            } else {
                $this->data['price'] = false;
            }
            $this->data['lastUpdate'] = jdate("l - j F o", strtotime($this->model_provider_pu_subprofile->getLastUpdateTimeOfProduct($this->request->get['product_id'])));
# Start Prices
            $this->data['minprice'] = $this->model_provider_pu_subprofile->GetMinimumPriceOfProduct($this->request->get['product_id']);
            $this->data['maxprice'] = $this->model_provider_pu_subprofile->GetMaximumPriceOfProduct($this->request->get['product_id']);
            $this->data['avg_price'] = $this->model_provider_pu_subprofile->GetAveragepricePriceOfProduct($this->request->get['product_id']);
            $this->data['max_p_price'] = $this->language->get('max_p_price');
            $this->data['min_p_price'] = $this->language->get('min_p_price');
            $this->data['toman'] = $this->language->get('toman');
            $this->data['price_avg_sarfejoo'] = $this->language->get('price_avg_sarfejoo');
            $this->data['avg_p_price'] = $this->language->get('avg_p_price');
            $this->data['p_buy_online'] = $this->language->get('p_buy_online');
# End  Prices

#Start Providers List
            $this->data['tab_provider'] = $this->language->get('tab_provider');
            $this->load->model('provider/pu_product');
            $this->load->model('provider/pu_subprofile');
            $this->load->model('provider/pu_attribute');
            $this->load->model('customextension/pu_attribute');

            $this->load->model('customextension/pu_block_attribute_subprofile_value');

            $is_service = false;
            $providers = $this->model_provider_pu_subprofile->GetAllSubprofileOfProducts($this->request->get['product_id']);
            $important_attributes = $this->model_provider_pu_attribute->getImportantAttribute($this->request->get['product_id']);
            $importants = array();
            foreach ($important_attributes as $important_attribute) {
                $importants[] = $important_attribute['attribute_id'];
            }
            if (isset($providers)) {
                $count = 0;
                $provCounter = 0;
                foreach ($providers as $provider) {
                    $providers[$provCounter]['href'] = $this->url->link('product/subprofile', 'subprofile_id=' . $provider['subprofile_id']);
                    $provCounter++;
                    $this->data['providers'] = $providers;
                    $customAttributes = null;
                    $blockAttributesId = '';
                    if ($this->model_provider_pu_attribute->isCustomProduct($this->request->get['product_id'])) {
                        $is_service = true;
                        $categories = $this->model_catalog_product->getCategories($this->request->get['product_id']);
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
                            //echo '3';
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
                                    $selected_value = $this->model_customextension_pu_block_attribute_subprofile_value->get($provider['subprofile_id'], $this->request->get['product_id'], $attribute_info['attribute_id']);
                                    $selected_value2 = array();
                                    $first_attr_name = $selected_value[0]['subattribute_name'];
                                    $subs = array();
                                    $cnt = 0;
                                    foreach ($selected_value as $this_selected_value) {
                                        if ($this_selected_value['subattribute_name'] == $first_attr_name && $cnt != 0) {
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
                                    $selected_value = $selected_value2;
                                } else {

                                    $selected_value = $this->model_provider_pu_attribute->getAttributeValue($provider['subprofile_id'], $this->request->get['product_id'], $attribute_info['attribute_id']);
                                }

                                //echo $is_important;
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
                        $providers[$count]['custom_attributes'] = $attributes;

                        $count++;
                    }
                }
            }
            if (!isset($this->request->get['path'])) $this->request->get['path'] = '';
            $this->data['url'] = $this->url->link('product/product', 'path=' . $this->request->get['path'] . '&product_id=' . $this->request->get['product_id']);
            if (isset($this->request->get['sort']) && $this->request->get['sort'] == "date") {
                foreach ($providers as $key => $row) {
                    $update_date[$key] = $row['update_date'];
                }
                array_multisort($update_date, SORT_DESC, $providers);
            } else if (isset($this->request->get['sort']) && isset($this->request->get['order']) && $this->request->get['sort'] == "price" && $this->request->get['order'] == "ASC") {
                foreach ($providers as $key => $row) {
                    $price[$key] = $row['price'];
                }
                array_multisort($price, SORT_ASC, $providers);
            } else if (isset($this->request->get['sort']) && isset($this->request->get['order']) && $this->request->get['sort'] == "price" && $this->request->get['order'] == "DESC") {
                foreach ($providers as $key => $row) {
                    $price[$key] = $row['price'];
                }
                array_multisort($price, SORT_DESC, $providers);
            } else if (isset($this->request->get['sort']) && $this->request->get['sort'] == "title") {
                foreach ($providers as $key => $row) {
                    $title[$key] = $row['title'];
                }
                array_multisort($title, SORT_DESC, $providers);
            }
            if (isset($this->request->get['sort'])) {
                $this->data['sort'] = $this->request->get['sort'];
            } else {
                $this->data['sort'] = '';
            }
            if (isset($this->request->get['order'])) {
                $this->data['order'] = $this->request->get['order'];
            } else {
                $this->data['order'] = '';
            }

            $this->data['providers'] = $providers;
            $this->data['is_service'] = $is_service;
            //print_r($providers);
            $this->data['p_website'] = $this->language->get('p_website');
            $this->data['p_description'] = $this->language->get('p_description');
            $this->data['p_price'] = $this->language->get('p_price');
            $this->data['p_availability'] = $this->language->get('p_availability');
            $this->data['p_availability_notset'] = $this->language->get('p_availability_notset');
            $this->data['p_availability_yes'] = $this->language->get('p_availability_yes');
            $this->data['p_availability_soon'] = $this->language->get('p_availability_soon');
            $this->data['p_availability_no'] = $this->language->get('p_availability_no');
            $this->data['p_address'] = $this->language->get('p_address');
            $this->data['p_contact'] = $this->language->get('p_contact');
            $this->data['p_contact_limit'] = $this->language->get('p_contact_limit');
            $this->data['p_contact_tel'] = $this->language->get('p_contact_tel');
            $this->data['p_contact_mobile'] = $this->language->get('p_contact_mobile');
            $this->data['p_contact_email'] = $this->language->get('p_contact_email');
            $this->data['p_contact_login'] = $this->language->get('p_contact_login');
            if ($this->customer->isLogged()) {
                $this->data['p_login_c'] = '1';
            } else {
                $this->data['p_login_c'] = '0';
            }
#End Providers List
            if ((float)$product_info['special']) {
                $this->data['special'] = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
            } else {
                $this->data['special'] = false;
            }
            if ($this->config->get('config_tax')) {
                $this->data['tax'] = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price']);
            } else {
                $this->data['tax'] = false;
            }
            $discounts = $this->model_catalog_product->getProductDiscounts($this->request->get['product_id']);
            $this->data['discounts'] = array();
            foreach ($discounts as $discount) {
                $this->data['discounts'][] = array(
                    'quantity' => $discount['quantity'],
                    'price' => $this->currency->format($this->tax->calculate($discount['price'], $product_info['tax_class_id'], $this->config->get('config_tax')))
                );
            }
            $this->data['options'] = array();
            foreach ($this->model_catalog_product->getProductOptions($this->request->get['product_id']) as $option) {
                if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') {
                    $option_value_data = array();
                    foreach ($option['option_value'] as $option_value) {
                        if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
                            if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
                                $price = $this->currency->format($this->tax->calculate($option_value['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
                            } else {
                                $price = false;
                            }
                            $option_value_data[] = array(
                                'product_option_value_id' => $option_value['product_option_value_id'],
                                'option_value_id' => $option_value['option_value_id'],
                                'name' => $option_value['name'],
                                'image' => $this->model_tool_image->resize($option_value['image'], 50, 50),
                                'price' => $price,
                                'price_prefix' => $option_value['price_prefix']
                            );
                        }
                    }
                    $this->data['options'][] = array(
                        'product_option_id' => $option['product_option_id'],
                        'option_id' => $option['option_id'],
                        'name' => $option['name'],
                        'type' => $option['type'],
                        'option_value' => $option_value_data,
                        'required' => $option['required']
                    );
                } elseif ($option['type'] == 'text' || $option['type'] == 'textarea' || $option['type'] == 'file' || $option['type'] == 'date' || $option['type'] == 'datetime' || $option['type'] == 'time') {
                    $this->data['options'][] = array(
                        'product_option_id' => $option['product_option_id'],
                        'option_id' => $option['option_id'],
                        'name' => $option['name'],
                        'type' => $option['type'],
                        'option_value' => $option['option_value'],
                        'required' => $option['required']
                    );
                }
            }
            if ($product_info['minimum']) {
                $this->data['minimum'] = $product_info['minimum'];
            } else {
                $this->data['minimum'] = 1;
            }
            $this->data['review_status'] = $this->config->get('config_review_status');
            $this->data['reviews'] = sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']);
            $this->data['rating'] = (int)$product_info['rating'];
            
			$this->data['description'] = '<h2>'.$product_info['name'].'</h2>'.html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8');
			
            $this->data['attribute_groups'] = $this->model_catalog_product->getProductAttributes($this->request->get['product_id']);
            $this->data['products'] = array();
            $results = $this->model_catalog_product->getProductRelated($this->request->get['product_id']);
            foreach ($results as $result) {
                if ($result['image']) {
                    $image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height'));
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

                if ($this->config->get('config_review_status')) {
                    $rating = (int)$result['rating'];
                } else {
                    $rating = false;
                }

                $this->data['products'][] = array(
                    'product_id' => $result['product_id'],
                    'thumb' => $image,
                    'name' => $result['name'],
                    'price' => $price,
                    'special' => $special,
                    'rating' => $rating,
                    'reviews' => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
                    'href' => $this->url->link('product/product', 'product_id=' . $result['product_id'])
                );
            }

            $this->data['tags'] = array();

            if ($product_info['tag']) {
                $tags = explode(',', $product_info['tag']);

                foreach ($tags as $tag) {
                    $this->data['tags'][] = array(
                        'tag' => trim($tag),
                        'href' => $this->url->link('product/search', 'tag=' . trim($tag))
                    );
                }
            }
            $CanUseNewsletter = false;
            if ($this->canUseNewsletter() && $this->customer->isLogged()) {
                $CanUseNewsletter = true;
            }

            $this->data['canUseNewslette'] = $CanUseNewsletter;

            $this->data['text_payment_profile'] = $this->language->get('text_payment_profile');
            $this->data['profiles'] = $this->model_catalog_product->getProfiles($product_info['product_id']);

            $this->model_catalog_product->updateViewed($this->request->get['product_id']);

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/product.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/product/product.tpl';
            } else {
                $this->template = 'default/template/product/product.tpl';
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

            if (isset($this->request->get['path'])) {
                $url .= '&path=' . $this->request->get['path'];
            }

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['manufacturer_id'])) {
                $url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
            }

            if (isset($this->request->get['search'])) {
                $url .= '&search=' . $this->request->get['search'];
            }

            if (isset($this->request->get['tag'])) {
                $url .= '&tag=' . $this->request->get['tag'];
            }

            if (isset($this->request->get['description'])) {
                $url .= '&description=' . $this->request->get['description'];
            }

            if (isset($this->request->get['category_id'])) {
                $url .= '&category_id=' . $this->request->get['category_id'];
            }

            if (isset($this->request->get['sub_category'])) {
                $url .= '&sub_category=' . $this->request->get['sub_category'];
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
                'href' => $this->url->link('product/product', $url . '&product_id=' . $product_id),
                'separator' => $this->language->get('text_separator')
            );

            $this->document->setTitle($this->language->get('text_error'));

            $this->data['heading_title'] = $this->language->get('text_error');

            $this->data['text_error'] = $this->language->get('text_error');

            $this->data['button_continue'] = $this->language->get('button_continue');

            $this->data['continue'] = $this->config->get('config_url');

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

    public function review()
    {
        $this->language->load('product/product');

        $this->load->model('catalog/review');

        $this->data['text_on'] = $this->language->get('text_on');
        $this->data['text_no_reviews'] = $this->language->get('text_no_reviews');

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $this->data['reviews'] = array();

        $review_total = $this->model_catalog_review->getTotalReviewsByProductId($this->request->get['product_id']);

        $results = $this->model_catalog_review->getReviewsByProductId($this->request->get['product_id'], ($page - 1) * 5, 5);

        foreach ($results as $result) {
            $this->data['reviews'][] = array(
                'author' => $result['author'],
                'text' => $result['text'],
                'rating' => (int)$result['rating'],
                'reviews' => sprintf($this->language->get('text_reviews'), (int)$review_total),
                'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
            );
        }

        $pagination = new Pagination();
        $pagination->total = $review_total;
        $pagination->page = $page;
        $pagination->limit = 5;
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('product/product/review', 'product_id=' . $this->request->get['product_id'] . '&page={page}');

        $this->data['pagination'] = $pagination->render();

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/review.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/product/review.tpl';
        } else {
            $this->template = 'default/template/product/review.tpl';
        }

        $this->response->setOutput($this->render());
    }

    public function getRecurringDescription()
    {
        $this->language->load('product/product');
        $this->load->model('catalog/product');

        if (isset($this->request->post['product_id'])) {
            $product_id = $this->request->post['product_id'];
        } else {
            $product_id = 0;
        }

        if (isset($this->request->post['profile_id'])) {
            $profile_id = $this->request->post['profile_id'];
        } else {
            $profile_id = 0;
        }

        if (isset($this->request->post['quantity'])) {
            $quantity = $this->request->post['quantity'];
        } else {
            $quantity = 1;
        }

        $product_info = $this->model_catalog_product->getProduct($product_id);
        $profile_info = $this->model_catalog_product->getProfile($product_id, $profile_id);

        $json = array();

        if ($product_info && $profile_info) {

            if (!$json) {
                $frequencies = array(
                    'day' => $this->language->get('text_day'),
                    'week' => $this->language->get('text_week'),
                    'semi_month' => $this->language->get('text_semi_month'),
                    'month' => $this->language->get('text_month'),
                    'year' => $this->language->get('text_year'),
                );

                if ($profile_info['trial_status'] == 1) {
                    $price = $this->currency->format($this->tax->calculate($profile_info['trial_price'] * $quantity, $product_info['tax_class_id'], $this->config->get('config_tax')));
                    $trial_text = sprintf($this->language->get('text_trial_description'), $price, $profile_info['trial_cycle'], $frequencies[$profile_info['trial_frequency']], $profile_info['trial_duration']) . ' ';
                } else {
                    $trial_text = '';
                }

                $price = $this->currency->format($this->tax->calculate($profile_info['price'] * $quantity, $product_info['tax_class_id'], $this->config->get('config_tax')));

                if ($profile_info['duration']) {
                    $text = $trial_text . sprintf($this->language->get('text_payment_description'), $price, $profile_info['cycle'], $frequencies[$profile_info['frequency']], $profile_info['duration']);
                } else {
                    $text = $trial_text . sprintf($this->language->get('text_payment_until_canceled_description'), $price, $profile_info['cycle'], $frequencies[$profile_info['frequency']], $profile_info['duration']);
                }

                $json['success'] = $text;
            }
        }

        $this->response->setOutput(json_encode($json));
    }

    public function write()
    {
        $this->language->load('product/product');

        $this->load->model('catalog/review');

        $json = array();

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 25)) {
                $json['error'] = $this->language->get('error_name');
            }

            if ((utf8_strlen($this->request->post['text']) < 25) || (utf8_strlen($this->request->post['text']) > 1000)) {
                $json['error'] = $this->language->get('error_text');
            }

            if (empty($this->request->post['rating'])) {
                $json['error'] = $this->language->get('error_rating');
            }

            if (empty($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha'])) {
                $json['error'] = $this->language->get('error_captcha');
            }

            if (!isset($json['error'])) {
                $this->model_catalog_review->addReview($this->request->get['product_id'], $this->request->post);

                $json['success'] = $this->language->get('text_success');
            }
        }

        $this->response->setOutput(json_encode($json));
    }

    public function captcha()
    {
        $this->load->library('captcha');

        $captcha = new Captcha();

        $this->session->data['captcha'] = $captcha->getCode();

        $captcha->showImage();
    }

    public function upload()
    {
        $this->language->load('product/product');

        $json = array();

        if (!empty($this->request->files['file']['name'])) {
            $filename = basename(preg_replace('/[^a-zA-Z0-9\.\-\s+]/', '', html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8')));

            if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 64)) {
                $json['error'] = $this->language->get('error_filename');
            }

            // Allowed file extension types
            $allowed = array();

            $filetypes = explode("\n", $this->config->get('config_file_extension_allowed'));

            foreach ($filetypes as $filetype) {
                $allowed[] = trim($filetype);
            }

            if (!in_array(substr(strrchr($filename, '.'), 1), $allowed)) {
                $json['error'] = $this->language->get('error_filetype');
            }

            // Allowed file mime types
            $allowed = array();

            $filetypes = explode("\n", $this->config->get('config_file_mime_allowed'));

            foreach ($filetypes as $filetype) {
                $allowed[] = trim($filetype);
            }

            if (!in_array($this->request->files['file']['type'], $allowed)) {
                $json['error'] = $this->language->get('error_filetype');
            }

            // Check to see if any PHP files are trying to be uploaded
            $content = file_get_contents($this->request->files['file']['tmp_name']);

            if (preg_match('/\<\?php/i', $content)) {
                $json['error'] = $this->language->get('error_filetype');
            }

            if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
                $json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
            }
        } else {
            $json['error'] = $this->language->get('error_upload');
        }

        if (!$json && is_uploaded_file($this->request->files['file']['tmp_name']) && file_exists($this->request->files['file']['tmp_name'])) {
            $file = basename($filename) . '.' . md5(mt_rand());

            // Hide the uploaded file name so people can not link to it directly.
            $json['file'] = $this->encryption->encrypt($file);

            move_uploaded_file($this->request->files['file']['tmp_name'], DIR_DOWNLOAD . $file);

            $json['success'] = $this->language->get('text_upload');
        }

        $this->response->setOutput(json_encode($json));
    }

    public function generateSeoText($seo_generator_terms, $rss_link)
    {
        $text = "";
        $terms = explode("$", $seo_generator_terms);
        if (count($terms) > 0 && $rss_link) {
            $content = file_get_contents($rss_link);
            $x = new SimpleXmlElement($content);
            $text = "";
            foreach ($x->channel->item as $entry) {
                $text .= $entry->description;
            }
            $text = strip_tags($text);

            $all_words = explode(" ", $text);
            $all_words_count = count($all_words);
            $percentage = array();
            $percentage[0] = intval(($all_words_count / 100) * 4);
            $percentage[1] = intval(($all_words_count / 100) * 3.5);
            $percentage[2] = intval(($all_words_count / 100) * 3);
            $percentage[3] = intval(($all_words_count / 100) * 2.5);
            $percentage[4] = intval(($all_words_count / 100) * 2);
            $percentage[5] = intval(($all_words_count / 100) * 1.5);
            $percentage[6] = intval(($all_words_count / 100) * 1);
            for ($i = 0; $i < count($terms); $i++) {
                if ($i <= 6) {
                    for ($j = 0; $j < $percentage[$i]; $j++) {
                        $place = rand(0, $all_words_count - 1);
                        $all_words[$place] = $all_words[$place] . ' ' . $terms[$i] . ' ';
                    }
                } else {

                }
            }
            $text = implode(" ", $all_words);
        }
        return $text;
    }

    public function canUseNewsletter()
    {
        if ($this->customer->isLogged()) {
            $this->load->model('information/pu_newsletter');
            $result = $this->model_information_pu_newsletter->getCustomerNewsletterStatus($this->customer->getId());
            if (isset($result) && $result != null && $result) {
                return true;
            } else {
                return false;
            }
        }
    }
    public function AddCustomerProductAvailableRemind(){
        $json = array();
        $json['result'] = 'error';
        if ($this->customer->isLogged()) {
            $product_id = $this->request->post['product_id'];
            $customer_id = $this->customer->getId();
            $this->load->model('information/pu_newsletter');
            $result = $this->model_information_pu_newsletter->addAvailableReminder($customer_id,$product_id);
            $json['result'] = 'success';
        }
        $this->response->setOutput(json_encode($json));
    }
    public function RemoveCustomerProductAvailableRemind(){
        $json = array();
        $json['result'] = 'error';
        if ($this->customer->isLogged()) {
            $product_id = $this->request->post['product_id'];
            $customer_id = $this->customer->getId();
            $this->load->model('information/pu_newsletter');
            $result = $this->model_information_pu_newsletter->removeAvailableReminder($customer_id,$product_id);
            $json['result'] = 'success';
        }
        $this->response->setOutput(json_encode($json));
    }
    public function AddCustomerPriceLowerRemind(){
        $json = array();
        $json['result'] = 'error';
        if ($this->customer->isLogged()) {
            $product_id = $this->request->post['product_id'];
            $customer_id = $this->customer->getId();
            $price = $this->request->post['price'];
            $this->load->model('information/pu_newsletter');
            $result = $this->model_information_pu_newsletter->addPriceLowerReminder($customer_id,$product_id,$price);
            $json['result'] = 'success';
        }
        $this->response->setOutput(json_encode($json));
    }
}

?>