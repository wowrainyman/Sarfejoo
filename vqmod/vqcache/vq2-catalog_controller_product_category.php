<?php
//comment
class ControllerProductCategory extends Controller {  
	public function index() {

		$this->document->addStyle("catalog/view/theme/default/stylesheet/sarfejoo/lightbox/lib/sweet-alert.css");
		$this->document->addScript('catalog/view/theme/default/stylesheet/sarfejoo/lightbox/lib/sweet-alert.min.js');

		$this->language->load('product/category');

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

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

		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('config_catalog_limit');
		}

        $product_infos = array();
        $this->load->model('catalog/product');
        $this->load->model('tool/image');
		$this->load->model('provider/pu_subprofile');
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

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->config->get('config_url'),
			'separator' => false
		);

          $this->document->addScript('catalog/view/javascript/sarfejoo/category.js');

              // view links products
              
              $this->data['view_product_li'] = $this->language->get('view_product_li');
                $this->data['view_product_no_price'] = $this->language->get('view_product_no_price');
		if (isset($this->request->get['path'])) {
			$url = '';

				if( ! empty( $this->request->get['mfp'] ) ) {
					$url .= '&mfp=' . $this->request->get['mfp'];
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
						'text'      => $category_info['name'],
						'href'      => $this->url->link('product/category', 'path=' . $path . $url),
						'separator' => $this->language->get('text_separator')
					);
				}
			}
		} else {
			$category_id = 0;
		}


            //For Filter Range - Filter products based on slider price range
            $isAjax = false;
            if((isset($this->session->data['category_id']))&&($this->session->data['category_id']==$category_id))
            {
            if (isset($this->request->get['lower']))
	    {
		$isAjax = true;        
                $this->session->data['lower']=$this->request->get['lower'];
                $this->session->data['higher']=$this->request->get['higher'];
            }    
            }
            else {	    
           unset ($this->session->data['lower']);
           unset ($this->session->data['higher']);
            $this->session->data['category_id']=$category_id;        
            }
//End  Filter Range - Filter products based on slider price range
            
		$category_info = $this->model_catalog_category->getCategory($category_id);

		if ($category_info) {
            $this->data['stext'] = $this->generateSeoText($category_info['seo_generator'],$category_info['rss_link']);
			($category_info['custom_title'] == '')?$this->document->setTitle($category_info['name']):$this->document->setTitle($category_info['custom_title']);
			$this->document->setDescription($category_info['meta_description']);
			$this->document->setKeywords($category_info['meta_keyword']);

				$pathx = explode('_', $this->request->get['path']);
				$pathx = end($pathx);
				$this->document->addLink($this->url->link('product/category', 'path=' . $pathx ), 'canonical');
			
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
			$this->data['price_avg_sarfejoo'] = $this->language->get('price_avg_sarfejoo');
               $this->data['text_without_price'] = $this->language->get('text_without_price');

			$this->data['button_cart'] = $this->language->get('button_cart');
			$this->data['button_wishlist'] = $this->language->get('button_wishlist');
			$this->data['button_compare'] = $this->language->get('button_compare');
			$this->data['button_continue'] = $this->language->get('button_continue');

			// Set the last category breadcrumb		
			$url = '';

				if( ! empty( $this->request->get['mfp'] ) ) {
					$url .= '&mfp=' . $this->request->get['mfp'];
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
				'text'      => $category_info['name'],
				'href'      => $this->url->link('product/category', 'path=' . $this->request->get['path']),
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

				if( ! empty( $this->request->get['mfp'] ) ) {
					$url .= '&mfp=' . $this->request->get['mfp'];
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

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
            if (isset($this->request->get['subprofile_id'])) {
                if($this->request->get['subprofile_id']!=0){
                    $myurl = $url . '&subprofile_id=' . $this->request->get['subprofile_id'];
                }
            }


				$fmSettings = $this->config->get('mega_filter_settings');
				
				if( ! empty( $fmSettings['not_remember_filter_for_subcategories'] ) && false !== ( $mfpPos = strpos( $url, '&mfp=' ) ) ) {
					$mfUrlBeforeChange = $url;
					$mfSt = mb_strpos( $url, '&', $mfpPos+1, 'utf-8');
					$url = $mfSt === false ? '' : mb_substr($url, $mfSt, mb_strlen( $url, 'utf-8' ), 'utf-8');
				}
			
			$this->data['categories'] = array();

			$results = $this->model_catalog_category->getCategories($category_id);

			foreach ($results as $result) {
				$data = array(
					'filter_category_id'  => $result['category_id'],
					'filter_sub_category' => true
				);


				$fmSettings = $this->config->get('mega_filter_settings');
		
				if( ! empty( $fmSettings['show_products_from_subcategories'] ) ) {
					if( ! empty( $fmSettings['level_products_from_subcategories'] ) ) {
						$fmLevel = (int) $fmSettings['level_products_from_subcategories'];
						$fmPath = explode( '_', empty( $this->request->get['path'] ) ? '' : $this->request->get['path'] );

						if( $fmPath && count( $fmPath ) >= $fmLevel ) {
							$data['filter_sub_category'] = '1';
						}
					} else {
						$data['filter_sub_category'] = '1';
					}
				}
				
				if( ! empty( $this->request->get['manufacturer_id'] ) ) {
					$data['filter_manufacturer_id'] = (int) $this->request->get['manufacturer_id'];
				}
				
				if( ! empty( $fmSettings['in_stock_default_selected'] ) ) {
					$this->data['column_left'] = $this->getChild('common/column_left');
					$this->data['column_right'] = $this->getChild('common/column_right');
					$this->data['content_top'] = $this->getChild('common/content_top');
					$this->data['mfp_column_left'] = true;
					$this->data['mfp_column_right'] = true;
					$this->data['mfp_content_top'] = true;
				}
			
				$product_total = $this->model_catalog_product->getTotalProducts($data);				

				$this->data['categories'][] = array(
					'name'  => $result['name'] . ($this->config->get('config_product_count') ? ' (' . $product_total . ')' : ''),
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '_' . $result['category_id'] . $url)
				);
			}
            $filter_subprofile=false;
            if (isset($this->request->get['subprofile_id'])) {
                if($this->request->get['subprofile_id']!=0){
                    $filter_subprofile = $this->request->get['subprofile_id'];
                }
            }

				if( isset( $mfUrlBeforeChange ) ) {
					$url = $mfUrlBeforeChange;
					unset( $mfUrlBeforeChange );
				}
			
			$this->data['products'] = array();

            $data = array(
                'filter_category_id'    => $category_id,
                'filter_sub_category'   => true,
                'filter_filter'         => $filter,
                'sort'                  => $sort,
                'order'                 => $order,
                'start'                 => ($page - 1) * $limit,
                'limit'                 => $limit
            );
            $allproducts = $this->model_catalog_product->getProducts($data);
            $allproductsIds = array();
            foreach($allproducts as $prod){
                $allproductsIds[]=$prod['product_id'];
            }
            $allsubs = $this->model_catalog_product->getAllSubprofiles($allproductsIds);
            $this->data['allsubs'] = $allsubs;
            $this->data['filter_subprofile'] = $filter_subprofile;

			$data = array(
				'filter_category_id'    => $category_id,
                'filter_subprofile'    => $filter_subprofile,
				'filter_sub_category'   => true,
				'filter_filter'         => $filter,
				'sort'                  => $sort,
				'order'                 => $order,
				'start'                 => ($page - 1) * $limit,
				'limit'                 => $limit
			);

				$fmSettings = $this->config->get('mega_filter_settings');
		
				if( ! empty( $fmSettings['show_products_from_subcategories'] ) ) {
					if( ! empty( $fmSettings['level_products_from_subcategories'] ) ) {
						$fmLevel = (int) $fmSettings['level_products_from_subcategories'];
						$fmPath = explode( '_', empty( $this->request->get['path'] ) ? '' : $this->request->get['path'] );

						if( $fmPath && count( $fmPath ) >= $fmLevel ) {
							$data['filter_sub_category'] = '1';
						}
					} else {
						$data['filter_sub_category'] = '1';
					}
				}
				
				if( ! empty( $this->request->get['manufacturer_id'] ) ) {
					$data['filter_manufacturer_id'] = (int) $this->request->get['manufacturer_id'];
				}
				
				if( ! empty( $fmSettings['in_stock_default_selected'] ) ) {
					$this->data['column_left'] = $this->getChild('common/column_left');
					$this->data['column_right'] = $this->getChild('common/column_right');
					$this->data['content_top'] = $this->getChild('common/content_top');
					$this->data['mfp_column_left'] = true;
					$this->data['mfp_column_right'] = true;
					$this->data['mfp_content_top'] = true;
				}
			
			$product_total = $this->model_catalog_product->getTotalProducts($data);


			$results = $this->model_catalog_product->getProducts($data);

			foreach ($results as $result) {
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
				$minprice = $this->model_provider_pu_subprofile->GetMinimumPriceOfProduct($result['product_id']);
				$minprice = $minprice['MIN(price)'];
				$maxprice = $this->model_provider_pu_subprofile->GetMaximumPriceOfProduct($result['product_id']);
				$maxprice = $maxprice['MAX(price)'];
				$avg_price = $this->model_provider_pu_subprofile->GetAveragepricePriceOfProduct($result['product_id']);
				$providers = $this->model_provider_pu_subprofile->GetAllSubprofileOfProducts($result['product_id']);
				$providers_count = count($providers);

				$this->data['products'][] = array(
					'product_id'  		=> $result['product_id'],
					'thumb'       		=> $image,
					'name'        		=> $result['name'],
					'description' 		=> utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
					'price'       		=> $price,
					'special'     		=> $special,
					'tax'         		=> $tax,
					'rating'      		=> $result['rating'],
					'reviews'     		=> sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
					'href'        		=> $this->url->link('product/product', 'path=' . $this->request->get['path'] . '&product_id=' . $result['product_id'] . $url),
					'minprice'   		=> $minprice,
					'maxprice'   		=> $maxprice,
					'avg_price'  		=> $avg_price,
					'providers_count'	=> $providers_count,

				);
			}
			foreach($this->data['products'] as $p){

			}

			$url = '';

				if( ! empty( $this->request->get['mfp'] ) ) {
					$url .= '&mfp=' . $this->request->get['mfp'];
				}
			

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
            if (isset($this->request->get['subprofile_id'])) {
                if($this->request->get['subprofile_id']!=0){
                    $myurl = $url . '&subprofile_id=' . $this->request->get['subprofile_id'];
                }
            }

			$this->data['sorts'] = array();

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.sort_order&order=ASC' . $url)
			);

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=ASC' . $url)
			);

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=DESC' . $url)
			);

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=ASC' . $url)
			); 

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=DESC' . $url)
			); 

			if ($this->config->get('config_review_status')) {
				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=DESC' . $url)
				); 

				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=ASC' . $url)
				);
			}

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=ASC' . $url)
			);

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=DESC' . $url)
			);

			$url = '';

				if( ! empty( $this->request->get['mfp'] ) ) {
					$url .= '&mfp=' . $this->request->get['mfp'];
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
            if (isset($this->request->get['subprofile_id'])) {
                if($this->request->get['subprofile_id']!=0){
                    $myurl = $url . '&subprofile_id=' . $this->request->get['subprofile_id'];
                }
            }

			$this->data['limits'] = array();

			$limits = array_unique(array($this->config->get('config_catalog_limit'), 25, 50, 75, 100));

			sort($limits);

			foreach($limits as $value){
				$this->data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&limit=' . $value)
				);
			}

			$url = '';

				if( ! empty( $this->request->get['mfp'] ) ) {
					$url .= '&mfp=' . $this->request->get['mfp'];
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

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
            if (isset($this->request->get['subprofile_id'])) {
                if($this->request->get['subprofile_id']!=0){
                    $myurl = $url . '&subprofile_id=' . $this->request->get['subprofile_id'];
                }
            }

			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&page={page}');

            $this->data['currentUrl'] = $this->url->link('product/category', 'path=' . $this->request->get['path'] . $myurl);
            $this->data['Url'] = $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url);
			$this->data['pagination'] = $pagination->render();

			$this->data['sort'] = $sort;
			$this->data['order'] = $order;
			$this->data['limit'] = $limit;

			$this->data['continue'] = $this->config->get('config_url');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/category.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/product/category.tpl';
			} else {
				$this->template = 'default/template/product/category.tpl';
			}

			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);


				if( isset( $this->request->get['mfilterAjax'] ) ) {
					$settings	= $this->config->get('mega_filter_settings');
					$baseTypes	= array( 'stock_status', 'manufacturers', 'rating', 'attributes', 'price', 'options', 'filters' );
		
					if( isset( $this->request->get['mfilterBTypes'] ) ) {
						$baseTypes = explode( ',', $this->request->get['mfilterBTypes'] );
					}
					
					if( ! empty( $settings['calculate_number_of_products'] ) || in_array( 'categories:tree', $baseTypes ) ) {
						if( empty( $settings['calculate_number_of_products'] ) ) {
							$baseTypes = array( 'categories:tree' );
						}
				
						$this->load->model( 'module/mega_filter' );

						$idx = 0;
		
						if( isset( $this->request->get['mfilterIdx'] ) )
							$idx = (int) $this->request->get['mfilterIdx'];
						
						$this->data['mfilter_json'] = json_encode( MegaFilterCore::newInstance( $this, NULL )->getJsonData($baseTypes, $idx) );
					}
				
					foreach( $this->children as $mf_child ) {
						$mf_child = explode( '/', $mf_child );
						$mf_child = array_pop( $mf_child );
						$this->data[$mf_child] = '';
					}
						
					$this->children=array();
					$this->data['header'] = $this->data['column_left'] = $this->data['column_right'] = $this->data['content_top'] = $this->data['content_bottom'] = $this->data['footer'] = '';
				}
				
				if( ! empty( $this->data['breadcrumbs'] ) && ! empty( $this->request->get['mfp'] ) ) {
					
					foreach( $this->data['breadcrumbs'] as $mfK => $mfBreadcrumb ) {
						$mfReplace = preg_replace( '/path\[[^\]]+\],?/', '', $this->request->get['mfp'] );
						$mfFind = ( mb_strpos( $mfBreadcrumb['href'], '?mfp=', 0, 'utf-8' ) !== false ? '?mfp=' : '&mfp=' );
						
						$this->data['breadcrumbs'][$mfK]['href'] = str_replace(array(
							$mfFind . $this->request->get['mfp'],
							'&amp;mfp=' . $this->request->get['mfp'],
							$mfFind . urlencode( $this->request->get['mfp'] ),
							'&amp;mfp=' . urlencode( $this->request->get['mfp'] )
						), $mfReplace ? $mfFind . $mfReplace : '', $mfBreadcrumb['href'] );
					}
				}
			
			$this->response->setOutput($this->render());										
		} else {
			$url = '';

				if( ! empty( $this->request->get['mfp'] ) ) {
					$url .= '&mfp=' . $this->request->get['mfp'];
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
				'text'      => $this->language->get('text_error'),
				'href'      => $this->url->link('product/category', $url),
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


				if( isset( $this->request->get['mfilterAjax'] ) ) {
					$settings	= $this->config->get('mega_filter_settings');
					$baseTypes	= array( 'stock_status', 'manufacturers', 'rating', 'attributes', 'price', 'options', 'filters' );
		
					if( isset( $this->request->get['mfilterBTypes'] ) ) {
						$baseTypes = explode( ',', $this->request->get['mfilterBTypes'] );
					}
					
					if( ! empty( $settings['calculate_number_of_products'] ) || in_array( 'categories:tree', $baseTypes ) ) {
						if( empty( $settings['calculate_number_of_products'] ) ) {
							$baseTypes = array( 'categories:tree' );
						}
				
						$this->load->model( 'module/mega_filter' );

						$idx = 0;
		
						if( isset( $this->request->get['mfilterIdx'] ) )
							$idx = (int) $this->request->get['mfilterIdx'];
						
						$this->data['mfilter_json'] = json_encode( MegaFilterCore::newInstance( $this, NULL )->getJsonData($baseTypes, $idx) );
					}
				
					foreach( $this->children as $mf_child ) {
						$mf_child = explode( '/', $mf_child );
						$mf_child = array_pop( $mf_child );
						$this->data[$mf_child] = '';
					}
						
					$this->children=array();
					$this->data['header'] = $this->data['column_left'] = $this->data['column_right'] = $this->data['content_top'] = $this->data['content_bottom'] = $this->data['footer'] = '';
				}
				
				if( ! empty( $this->data['breadcrumbs'] ) && ! empty( $this->request->get['mfp'] ) ) {
					
					foreach( $this->data['breadcrumbs'] as $mfK => $mfBreadcrumb ) {
						$mfReplace = preg_replace( '/path\[[^\]]+\],?/', '', $this->request->get['mfp'] );
						$mfFind = ( mb_strpos( $mfBreadcrumb['href'], '?mfp=', 0, 'utf-8' ) !== false ? '?mfp=' : '&mfp=' );
						
						$this->data['breadcrumbs'][$mfK]['href'] = str_replace(array(
							$mfFind . $this->request->get['mfp'],
							'&amp;mfp=' . $this->request->get['mfp'],
							$mfFind . urlencode( $this->request->get['mfp'] ),
							'&amp;mfp=' . urlencode( $this->request->get['mfp'] )
						), $mfReplace ? $mfFind . $mfReplace : '', $mfBreadcrumb['href'] );
					}
				}
			
			$this->response->setOutput($this->render());
		}
	}

    public function generateSeoText($seo_generator_terms,$rss_link){
        $text="";
        $terms = explode("-", $seo_generator_terms);
        if(count($terms)==5){
            $content = file_get_contents($rss_link);
            $x = new SimpleXmlElement($content);
            $text = "";
            foreach($x->channel->item as $entry) {
                $text .= $entry->description;
            }
            $text = strip_tags($text);

            $all_words = explode(" ", $text);
            $all_words_count = count($all_words);
            $ac = intval(($all_words_count/100)*3.5);
            $ad = intval(($all_words_count/100)*3);
            $ae = intval(($all_words_count/100)*2.5);
            $bc = intval(($all_words_count/100)*2);
            $bd = intval(($all_words_count/100)*1.5);
            $be = intval(($all_words_count/100)*1);
            for($i=0;$i<$ac;$i++){
                $place = rand(0,$all_words_count-1);
                $all_words[$place] = ' ' . $terms[0] . ' ' . $terms[2] . ' ';
            }
            for($i=0;$i<$ad;$i++){
                $place = rand(0,$all_words_count-1);
                $all_words[$place] = ' ' . $terms[0] . ' ' . $terms[3] . ' ';
            }
            for($i=0;$i<$ae;$i++){
                $place = rand(0,$all_words_count-1);
                $all_words[$place] = ' ' . $terms[0] . ' ' . $terms[4] . ' ';
            }

            for($i=0;$i<$bc;$i++){
                $place = rand(0,$all_words_count-1);
                $all_words[$place] = ' ' . $terms[1] . ' ' . $terms[2] . ' ';
            }
            for($i=0;$i<$bd;$i++){
                $place = rand(0,$all_words_count-1);
                $all_words[$place] = ' ' . $terms[1] . ' ' . $terms[3] . ' ';
            }
            for($i=0;$i<$be;$i++){
                $place = rand(0,$all_words_count-1);
                $all_words[$place] = ' ' . $terms[1] . ' ' . $terms[4] . ' ';
            }

            $text = implode(" ",$all_words);
        }
        return $text;
    }

}
?>