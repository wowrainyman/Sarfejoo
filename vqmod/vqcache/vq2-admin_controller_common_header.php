<?php 
class ControllerCommonHeader extends Controller {
	protected function index() {
		$this->data['title'] = $this->document->getTitle(); 

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$this->data['base'] = HTTPS_SERVER;
		} else {
			$this->data['base'] = HTTP_SERVER;
		}

		$this->data['description'] = $this->document->getDescription();
		$this->data['keywords'] = $this->document->getKeywords();
		$this->data['links'] = $this->document->getLinks();	
		$this->data['styles'] = $this->document->getStyles();
		$this->data['scripts'] = $this->document->getScripts();
		$this->data['lang'] = $this->language->get('code');
		$this->data['direction'] = $this->language->get('direction');

        $this->data += $this->language->load('common/header');

		$this->data['text_product'] = $this->language->get('text_product');

			$this->data['text_seopack'] = $this->language->get('text_seopack');
			$this->data['text_seoimages'] = $this->language->get('text_seoimages');
			$this->data['text_seoeditor'] = $this->language->get('text_seoeditor');
			$this->data['text_seoreport'] = $this->language->get('text_seoreport');
			$this->data['text_autolinks'] = $this->language->get('text_autolinks');
			

		if (!$this->user->isLogged() || !isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token'])) {
			$this->data['logged'] = '';

			$this->data['home'] = $this->url->link('common/login', '', 'SSL');
		} else {
			$this->data['logged'] = sprintf($this->language->get('text_logged'), $this->user->getUserName());
			$this->data['pp_express_status'] = $this->config->get('pp_express_status');

            $this->data['color'] = $this->url->link('customextension/color', 'token=' . $this->session->data['token'], 'SSL');

			$this->data['home'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['affiliate'] = $this->url->link('sale/affiliate', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['attribute'] = $this->url->link('catalog/attribute', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['attribute_group'] = $this->url->link('catalog/attribute_group', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['attribute_value'] = $this->url->link('customextension/attribute_value', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['attribute_important'] = $this->url->link('customextension/attribute_important', 'token=' . $this->session->data['token'], 'SSL');


			$this->data['features'] = $this->url->link('financial/features', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['plans'] = $this->url->link('financial/plans', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['periods'] = $this->url->link('financial/periods', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['plans_discount'] = $this->url->link('financial/plans_discount', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['plans_features'] = $this->url->link('financial/plans_features', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['plans_periods'] = $this->url->link('financial/plans_periods', 'token=' . $this->session->data['token'], 'SSL');

            $this->data['payment2'] = $this->url->link('customextension/payment', 'token=' . $this->session->data['token'], 'SSL');

			$this->data['provider_plan'] = $this->url->link('customextension/provider_plan', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['subprofile_plan'] = $this->url->link('customextension/subprofile_plan', 'token=' . $this->session->data['token'], 'SSL');

            $this->data['plan_periodic'] = $this->url->link('customextension/plan_periodic', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['plan_once'] = $this->url->link('customextension/plan_once', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['rating'] = $this->url->link('customextension/rating', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['my_setting'] = $this->url->link('customextension/setting', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['newsletter_plan'] = $this->url->link('customextension/newsletter_plan', 'token=' . $this->session->data['token'], 'SSL');

            $this->data['block'] = $this->url->link('customextension/block', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['block_attribute'] = $this->url->link('customextension/block_attribute', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['block_attribute_value'] = $this->url->link('customextension/block_attribute_value', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['subprofile_comment'] = $this->url->link('customextension/subprofile_comment', 'token=' . $this->session->data['token'], 'SSL');

            $this->data['backup'] = $this->url->link('tool/backup', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['banner'] = $this->url->link('design/banner', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['category'] = $this->url->link('catalog/category', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['country'] = $this->url->link('localisation/country', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['coupon'] = $this->url->link('sale/coupon', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['currency'] = $this->url->link('localisation/currency', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['customer'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['subprofile'] = $this->url->link('sale/subprofile', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['customer_fields'] = $this->url->link('sale/customer_field', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['customer_group'] = $this->url->link('sale/customer_group', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['customer_ban_ip'] = $this->url->link('sale/customer_ban_ip', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['custom_field'] = $this->url->link('design/custom_field', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['download'] = $this->url->link('catalog/download', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['error_log'] = $this->url->link('tool/error_log', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['feed'] = $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['filter'] = $this->url->link('catalog/filter', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['geo_zone'] = $this->url->link('localisation/geo_zone', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['information'] = $this->url->link('catalog/information', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['language'] = $this->url->link('localisation/language', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['layout'] = $this->url->link('design/layout', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['logout'] = $this->url->link('common/logout', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['contact'] = $this->url->link('sale/contact', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['manager'] = $this->url->link('extension/manager', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['manufacturer'] = $this->url->link('catalog/manufacturer', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['module'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['option'] = $this->url->link('catalog/option', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['order'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['order_status'] = $this->url->link('localisation/order_status', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['payment'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['product'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'], 'SSL');

			$this->data['seopack'] = $this->url->link('catalog/seopack', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['seoimages'] = $this->url->link('catalog/seoimages', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['seoeditor'] = $this->url->link('catalog/seoeditor', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['seoreport'] = $this->url->link('catalog/seoreport', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['autolinks'] = $this->url->link('catalog/autolinks', 'token=' . $this->session->data['token'], 'SSL');
			
            $this->data['product_attribute'] = $this->url->link('customextension/attribute', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['attribute_type'] = $this->url->link('customextension/attribute_class', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['profile'] = $this->url->link('catalog/profile', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_sale_order'] = $this->url->link('report/sale_order', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_sale_tax'] = $this->url->link('report/sale_tax', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_sale_shipping'] = $this->url->link('report/sale_shipping', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_sale_return'] = $this->url->link('report/sale_return', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_sale_coupon'] = $this->url->link('report/sale_coupon', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_product_viewed'] = $this->url->link('report/product_viewed', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_product_purchased'] = $this->url->link('report/product_purchased', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_customer_online'] = $this->url->link('report/customer_online', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_customer_order'] = $this->url->link('report/customer_order', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_customer_reward'] = $this->url->link('report/customer_reward', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_customer_credit'] = $this->url->link('report/customer_credit', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_affiliate_commission'] = $this->url->link('report/affiliate_commission', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['review'] = $this->url->link('catalog/review', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['return'] = $this->url->link('sale/return', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['return_action'] = $this->url->link('localisation/return_action', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['return_reason'] = $this->url->link('localisation/return_reason', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['return_status'] = $this->url->link('localisation/return_status', 'token=' . $this->session->data['token'], 'SSL');			
			$this->data['shipping'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['setting'] = $this->url->link('setting/store', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['store'] = HTTP_CATALOG;
			$this->data['stock_status'] = $this->url->link('localisation/stock_status', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['tax_class'] = $this->url->link('localisation/tax_class', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['tax_rate'] = $this->url->link('localisation/tax_rate', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['total'] = $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['user'] = $this->url->link('user/user', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['user_group'] = $this->url->link('user/user_permission', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['voucher'] = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['voucher_theme'] = $this->url->link('sale/voucher_theme', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['weight_class'] = $this->url->link('localisation/weight_class', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['length_class'] = $this->url->link('localisation/length_class', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['zone'] = $this->url->link('localisation/zone', 'token=' . $this->session->data['token'], 'SSL');

			$this->data['ad_plan_byclick'] = $this->url->link('ad/plan_byclick', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['ad_plan_byview'] = $this->url->link('ad/plan_byview', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['ad_plan_bytime'] = $this->url->link('ad/plan_bytime', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['ad_information'] = $this->url->link('ad/ad_information', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['ad_position'] = $this->url->link('ad/position', 'token=' . $this->session->data['token'], 'SSL');

			$this->data['openbay_show_menu'] = $this->config->get('openbaymanager_show_menu');

			$this->data['openbay_link_extension'] = $this->url->link('extension/openbay', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_orders'] = $this->url->link('extension/openbay/orderList', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_items'] = $this->url->link('extension/openbay/itemList', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_ebay'] = $this->url->link('openbay/openbay', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_ebay_settings'] = $this->url->link('openbay/openbay/settings', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_ebay_links'] = $this->url->link('openbay/openbay/viewItemLinks', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_ebay_orderimport'] = $this->url->link('openbay/openbay/viewOrderImport', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_amazon'] = $this->url->link('openbay/amazon', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_amazon_settings'] = $this->url->link('openbay/amazon/settings', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_amazon_links'] = $this->url->link('openbay/amazon/itemLinks', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_amazonus'] = $this->url->link('openbay/amazonus', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_amazonus_settings'] = $this->url->link('openbay/amazonus/settings', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_amazonus_links'] = $this->url->link('openbay/amazonus/itemLinks', 'token=' . $this->session->data['token'], 'SSL');

			$this->data['openbay_markets'] = array(
				'ebay' => $this->config->get('openbay_status'),
				'amazon' => $this->config->get('amazon_status'),
				'amazonus' => $this->config->get('amazonus_status'),
			);

			$this->data['paypal_express'] = $this->url->link('payment/pp_express', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['paypal_express_search'] = $this->url->link('payment/pp_express/search', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['recurring_profile'] = $this->url->link('sale/recurring', 'token=' . $this->session->data['token'], 'SSL');

			$this->data['stores'] = array();

			$this->load->model('setting/store');

			$results = $this->model_setting_store->getStores();

			foreach ($results as $result) {
				$this->data['stores'][] = array(
					'name' => $result['name'],
					'href' => $result['url']
				);
			}			
		}

		$this->template = 'common/header.tpl';

		$this->render();
	}
}
?>