<?php

class ControllerModuleSearchSuggestion extends Controller {

	public function index() {
		$this->id = 'search_suggestion';

		$this->document->addScript('catalog/view/javascript/search_suggestion.js');

		if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/search_suggestion.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/search_suggestion.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/search_suggestion.css');
		}
	}
	
	public function ajax() {

		$this->language->load('module/search_suggestion');

		$json = array();
		$this->data['products'] = array();

		if (isset($this->request->get['keyword'])) {

			$options = $this->config->get('search_suggestion_options');

			$this->load->model('catalog/search_suggestion');

			if (isset($options['search_where']['name'])) {
				$data_search['filter_name'] = $this->request->get['keyword'];
			}
			if (isset($options['search_order'])) {
				if ($options['search_order'] == 'rating') {
					$data_search['sort'] = 'rating';
				} else if ($options['search_order'] == 'name') {
					$data_search['sort'] = 'pd.name';
				} else if ($options['search_order'] == 'relevance') {
					$data_search['sort'] = 'relevance';
				}
			}
			if (isset($options['search_order_dir'])) {
				if ($options['search_order_dir'] == 'asc') {
					$data_search['order'] = 'ASC';
				} else if ($options['search_order_dir'] == 'desc') {
					$data_search['order'] = 'DESC';
				}
			}
			if (isset($options['search_limit'])) {
				$data_search['limit'] = $options['search_limit'];
			}
			$data_search['start'] = 0;

			$search_model = 'model_catalog_search_suggestion';

			// if sort is by relevance and module "search with morphology and relevance" exists 
			if ($data_search['sort'] == 'relevance' && $this->config->get('search_mr_options')) {
				$this->load->model('catalog/search_mr');
				$data_search['search_mr_options'] = $this->config->get('search_mr_options');
				// for relevance always use DESC order
				$data_search['order'] = 'DESC';
				$search_model = 'model_catalog_search_mr';
			}

			$product_total = $this->$search_model->getTotalProducts($data_search);

			if ($product_total) {

				$results = $this->$search_model->getProducts($data_search);

				foreach ($results as $result) {

					if (isset($options['search_field']['show_name'])) {
						$name = htmlspecialchars_decode($result['name']);
					} else {
						$name = '';
					}

					if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && isset($options['search_field']['show_price'])) {
						$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$price = '';
					}

					if ((float) $result['special'] && isset($options['search_field']['show_price'])) {
						$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$special = '';
					}

					$this->data['products'][] = array(
						'product_id' => $result['product_id'],
						'name' => $name,
						'price' => $price,
						'special' => $special,
						'href' => str_replace('&amp;', '&', $this->url->link('product/product', 'product_id=' . $result['product_id']))
					);
				}
			}
		}

		if (empty($this->data['products'])) {
			$this->data['products'][] = array(
				'product_id' => '',
				'name' => $this->language->get('text_no_result'),
				'price' => '',
				'special' => '',
				'href' => ''
			);
		} else if ($product_total > count($this->data['products'])) {
			$remainder_cnt = $product_total - count($this->data['products']);
			if ($remainder_cnt > 0) {
				$this->data['products'][] = array(
					'product_id' => '',
					'name' => $remainder_cnt . $this->language->get('more_results'),
					'price' => '',
					'special' => '',
					'href' => str_replace('&amp;', '&', $this->url->link('product/search', 'search=' . $this->request->get['keyword']))
				);
			}
		}

		$this->response->setOutput(json_encode($this->data['products']));
	}	
}