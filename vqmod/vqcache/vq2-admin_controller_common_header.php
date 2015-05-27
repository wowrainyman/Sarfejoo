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

		$this->language->load('common/header');


			$query = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "product_description WHERE field = 'custom_alt'");
			$exists = 0;
			foreach ($query->rows as $index) {$exists++;}
			if (!$exists) {$this->db->query("ALTER TABLE " . DB_PREFIX . "product_description ADD COLUMN `custom_alt` varchar(255) NULL DEFAULT '';");}
			

			$query = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "product_description WHERE field = 'custom_h1'");
			$exists = 0;
			foreach ($query->rows as $index) {$exists++;}
			if (!$exists) {$this->db->query("ALTER TABLE " . DB_PREFIX . "product_description ADD COLUMN `custom_h1` varchar(255) NULL DEFAULT '';");}
			
		$this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_payment'] = $this->language->get('text_payment');
		$this->data['text_affiliate'] = $this->language->get('text_affiliate');
		$this->data['text_attribute'] = $this->language->get('text_attribute');
		$this->data['text_attribute_group'] = $this->language->get('text_attribute_group');
        $this->data['text_attribute_value'] = $this->language->get('text_attribute_value');
        $this->data['text_attribute_important'] = $this->language->get('text_attribute_important');

        $this->data['text_plan'] = $this->language->get('text_plan');
        $this->data['text_plan_periodic'] = $this->language->get('text_plan_periodic');
        $this->data['text_plan_once'] = $this->language->get('text_plan_once');
		$this->data['text_provider_plan'] = $this->language->get('text_provider_plan');
		$this->data['text_subprofile_plan'] = $this->language->get('text_subprofile_plan');

        $this->data['text_rating'] = $this->language->get('text_rating');
		$this->data['text_my_setting'] = $this->language->get('text_my_setting');
		$this->data['text_newsletter_plan'] = $this->language->get('text_newsletter_plan');

		$this->data['text_subprofile_comment'] = $this->language->get('text_subprofile_comment');

        $this->data['text_block'] = $this->language->get('text_block');
        $this->data['text_block_attribute'] = $this->language->get('text_block_attribute');
        $this->data['text_block_attribute_value'] = $this->language->get('text_block_attribute_value');
		$this->data['text_backup'] = $this->language->get('text_backup');
		$this->data['text_banner'] = $this->language->get('text_banner');
		$this->data['text_catalog'] = $this->language->get('text_catalog');
		$this->data['text_category'] = $this->language->get('text_category');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_country'] = $this->language->get('text_country');
		$this->data['text_coupon'] = $this->language->get('text_coupon');
		$this->data['text_currency'] = $this->language->get('text_currency');
		$this->data['text_customer'] = $this->language->get('text_customer');
        $this->data['text_subprofile'] = $this->language->get('text_subprofile');
		$this->data['text_customer_group'] = $this->language->get('text_customer_group');
		$this->data['text_customer_field'] = $this->language->get('text_customer_field');
		$this->data['text_customer_ban_ip'] = $this->language->get('text_customer_ban_ip');
		$this->data['text_custom_field'] = $this->language->get('text_custom_field');
		$this->data['text_sale'] = $this->language->get('text_sale');
		$this->data['text_design'] = $this->language->get('text_design');
		$this->data['text_documentation'] = $this->language->get('text_documentation');
		$this->data['text_download'] = $this->language->get('text_download');
		$this->data['text_error_log'] = $this->language->get('text_error_log');
		$this->data['text_extension'] = $this->language->get('text_extension');
		$this->data['text_feed'] = $this->language->get('text_feed');
		$this->data['text_filter'] = $this->language->get('text_filter');
		$this->data['text_front'] = $this->language->get('text_front');
		$this->data['text_geo_zone'] = $this->language->get('text_geo_zone');
		$this->data['text_dashboard'] = $this->language->get('text_dashboard');
		$this->data['text_help'] = $this->language->get('text_help');
		$this->data['text_advertising'] = $this->language->get('text_advertising');
		$this->data['text_information'] = $this->language->get('text_information');
		$this->data['text_language'] = $this->language->get('text_language');
		$this->data['text_layout'] = $this->language->get('text_layout');
		$this->data['text_localisation'] = $this->language->get('text_localisation');
		$this->data['text_logout'] = $this->language->get('text_logout');
		$this->data['text_contact'] = $this->language->get('text_contact');
		$this->data['text_manager'] = $this->language->get('text_manager');
		$this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$this->data['text_module'] = $this->language->get('text_module');
		$this->data['text_option'] = $this->language->get('text_option');
		$this->data['text_order'] = $this->language->get('text_order');
		$this->data['text_order_status'] = $this->language->get('text_order_status');
		$this->data['text_opencart'] = $this->language->get('text_opencart');
		$this->data['text_payment'] = $this->language->get('text_payment');
		$this->data['text_product'] = $this->language->get('text_product');

			$this->data['text_seopack'] = $this->language->get('text_seopack');
			$this->data['text_seoimages'] = $this->language->get('text_seoimages');
			$this->data['text_seoeditor'] = $this->language->get('text_seoeditor');
			$this->data['text_seoreport'] = $this->language->get('text_seoreport');
			$this->data['text_autolinks'] = $this->language->get('text_autolinks');
			
        $this->data['text_product_attribute'] = $this->language->get('text_product_attribute');
        $this->data['text_attribute_type'] = $this->language->get('text_attribute_type');
        $this->data['text_profile'] = $this->language->get('text_profile');
		$this->data['text_reports'] = $this->language->get('text_reports');
		$this->data['text_report_sale_order'] = $this->language->get('text_report_sale_order');
		$this->data['text_report_sale_tax'] = $this->language->get('text_report_sale_tax');
		$this->data['text_report_sale_shipping'] = $this->language->get('text_report_sale_shipping');
		$this->data['text_report_sale_return'] = $this->language->get('text_report_sale_return');
		$this->data['text_report_sale_coupon'] = $this->language->get('text_report_sale_coupon');
		$this->data['text_report_product_viewed'] = $this->language->get('text_report_product_viewed');
		$this->data['text_report_product_purchased'] = $this->language->get('text_report_product_purchased');
		$this->data['text_report_customer_online'] = $this->language->get('text_report_customer_online');
		$this->data['text_report_customer_order'] = $this->language->get('text_report_customer_order');
		$this->data['text_report_customer_reward'] = $this->language->get('text_report_customer_reward');
		$this->data['text_report_customer_credit'] = $this->language->get('text_report_customer_credit');
		$this->data['text_report_affiliate_commission'] = $this->language->get('text_report_affiliate_commission');
		$this->data['text_report_sale_return'] = $this->language->get('text_report_sale_return');
		$this->data['text_report_product_viewed'] = $this->language->get('text_report_product_viewed');
		$this->data['text_report_customer_order'] = $this->language->get('text_report_customer_order');
		$this->data['text_review'] = $this->language->get('text_review');
		$this->data['text_return'] = $this->language->get('text_return');
		$this->data['text_return_action'] = $this->language->get('text_return_action');
		$this->data['text_return_reason'] = $this->language->get('text_return_reason');
		$this->data['text_return_status'] = $this->language->get('text_return_status');
		$this->data['text_support'] = $this->language->get('text_support');
		$this->data['text_shipping'] = $this->language->get('text_shipping');
		$this->data['text_setting'] = $this->language->get('text_setting');
		$this->data['text_stock_status'] = $this->language->get('text_stock_status');
		$this->data['text_system'] = $this->language->get('text_system');
		$this->data['text_tax'] = $this->language->get('text_tax');
		$this->data['text_tax_class'] = $this->language->get('text_tax_class');
		$this->data['text_tax_rate'] = $this->language->get('text_tax_rate');
		$this->data['text_total'] = $this->language->get('text_total');
		$this->data['text_user'] = $this->language->get('text_user');
		$this->data['text_user_group'] = $this->language->get('text_user_group');
		$this->data['text_users'] = $this->language->get('text_users');
		$this->data['text_voucher'] = $this->language->get('text_voucher');
		$this->data['text_voucher_theme'] = $this->language->get('text_voucher_theme');
		$this->data['text_weight_class'] = $this->language->get('text_weight_class');
		$this->data['text_length_class'] = $this->language->get('text_length_class');
		$this->data['text_zone'] = $this->language->get('text_zone');
// BOF - Zappo - vQModerator - ONE LINE - Added vQModerator Text
		$this->data['text_vqmoderator'] = $this->language->get('text_vqmoderator');

        
		// Admin Enhanced
		$this->data['edate'] = $this->config->get('config_edate');
		$this->data['egana'] = $this->config->get('config_egana');
		$this->data['eprod7'] = $this->config->get('config_eprod7');
		$this->data['ecats4'] = $this->config->get('config_ecats4');
		$this->data['emisc1'] = $this->config->get('config_emisc1');
		$this->data['emisc4'] = $this->config->get('config_emisc4');
		$this->data['emisc6'] = $this->config->get('config_emisc6');
		$this->data['text_january'] = $this->language->get('text_january');
		$this->data['text_february'] = $this->language->get('text_february');
		$this->data['text_march'] = $this->language->get('text_march');
		$this->data['text_april'] = $this->language->get('text_april');
		$this->data['text_may'] = $this->language->get('text_may');
		$this->data['text_june'] = $this->language->get('text_june');
		$this->data['text_july'] = $this->language->get('text_july');
		$this->data['text_august'] = $this->language->get('text_august');
		$this->data['text_september'] = $this->language->get('text_september');
		$this->data['text_october'] = $this->language->get('text_october');
		$this->data['text_november'] = $this->language->get('text_november');
		$this->data['text_december'] = $this->language->get('text_december');
		$this->data['text_year'] = $this->language->get('text_year');
		// Admin Enhanced
		
      	
		$this->data['text_openbay_extension'] = $this->language->get('text_openbay_extension');
		$this->data['text_openbay_dashboard'] = $this->language->get('text_openbay_dashboard');
		$this->data['text_openbay_orders'] = $this->language->get('text_openbay_orders');
		$this->data['text_openbay_items'] = $this->language->get('text_openbay_items');
		$this->data['text_openbay_ebay'] = $this->language->get('text_openbay_ebay');
		$this->data['text_openbay_amazon'] = $this->language->get('text_openbay_amazon');
		$this->data['text_openbay_amazonus'] = $this->language->get('text_openbay_amazonus');
		$this->data['text_openbay_settings'] = $this->language->get('text_openbay_settings');
		$this->data['text_openbay_links'] = $this->language->get('text_openbay_links');
		$this->data['text_openbay_report_price'] = $this->language->get('text_openbay_report_price');
		$this->data['text_openbay_order_import'] = $this->language->get('text_openbay_order_import');

		$this->data['text_paypal_express'] = $this->language->get('text_paypal_manage');
		$this->data['text_paypal_express_search'] = $this->language->get('text_paypal_search');
		$this->data['text_recurring_profile'] = $this->language->get('text_recurring_profile');

		$this->data['text_ad_plans'] = $this->language->get('text_ad_plans');

		$this->data['text_ad_plan_byclick'] = $this->language->get('text_ad_plan_byclick');
		$this->data['text_ad_plan_byview'] = $this->language->get('text_ad_plan_byview');
		$this->data['text_ad_plan_bytime'] = $this->language->get('text_ad_plan_bytime');

        $this->data['text_ad_position'] = $this->language->get('text_ad_position');

		$this->data['text_ad_information'] = $this->language->get('text_ad_information');

		if (!$this->user->isLogged() || !isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token'])) {
			$this->data['logged'] = '';

			$this->data['home'] = $this->url->link('common/login', '', 'SSL');
		} else {
			$this->data['logged'] = sprintf($this->language->get('text_logged'), $this->user->getUserName());
			$this->data['pp_express_status'] = $this->config->get('pp_express_status');

			$this->data['home'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['affiliate'] = $this->url->link('sale/affiliate', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['attribute'] = $this->url->link('catalog/attribute', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['attribute_group'] = $this->url->link('catalog/attribute_group', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['attribute_value'] = $this->url->link('customextension/attribute_value', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['attribute_important'] = $this->url->link('customextension/attribute_important', 'token=' . $this->session->data['token'], 'SSL');

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


        
		// Admin Enhanced
		$this->data['edate'] = $this->config->get('config_edate');
		$this->data['egana'] = $this->config->get('config_egana');
		$this->data['eprod7'] = $this->config->get('config_eprod7');
		$this->data['ecats4'] = $this->config->get('config_ecats4');
		$this->data['emisc1'] = $this->config->get('config_emisc1');
		$this->data['emisc4'] = $this->config->get('config_emisc4');
		$this->data['emisc6'] = $this->config->get('config_emisc6');
		$this->data['text_january'] = $this->language->get('text_january');
		$this->data['text_february'] = $this->language->get('text_february');
		$this->data['text_march'] = $this->language->get('text_march');
		$this->data['text_april'] = $this->language->get('text_april');
		$this->data['text_may'] = $this->language->get('text_may');
		$this->data['text_june'] = $this->language->get('text_june');
		$this->data['text_july'] = $this->language->get('text_july');
		$this->data['text_august'] = $this->language->get('text_august');
		$this->data['text_september'] = $this->language->get('text_september');
		$this->data['text_october'] = $this->language->get('text_october');
		$this->data['text_november'] = $this->language->get('text_november');
		$this->data['text_december'] = $this->language->get('text_december');
		$this->data['text_year'] = $this->language->get('text_year');
		// Admin Enhanced
		
      	
// BOF - Zappo - vQModerator - ONE LINE - Added vQModerator Link
			$this->data['vqmoderator'] = $this->url->link('tool/vqmod', 'token=' . $this->session->data['token'], 'SSL');
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