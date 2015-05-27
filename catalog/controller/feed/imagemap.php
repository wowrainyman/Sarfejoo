<?php

/**
 * ImageMap Extension
 * 
 * @version   	0.2
 * @author 		Ivan Ivanov - BiteMedia Dev Team (office@bite-media.com)
 * @copyright 	Copyright (c) 2014 BiteMedia
 * 
 *   
 */


class ControllerFeedImagemap extends Controller { 


	/* Smart Caption Configuration
	-------------------------------------------------------------------- */

	// Change it to FALSE to disable the Smart Caption functionality
	// Example private $smart_caption 	= FALSE;
	private $smart_caption 		= TRUE;

	// This is the delimiter between the product name and the humanized filename. 
	// Example: " : " or " - " 
	private $smart_delimiter 	= ' - ';

	// Don't touch this without consulting us if you don't understand enough
	private $smart_separators 	= array('_', '-');




	//preparation for a dirty fix with some vodoo html entitites magic (for PHP < 5.4)
	private $allowed_entities 	= array('&', '"', "'", '<', '>');
	private $replacement_entities 	= array('&amp;', '&quot;', '&apos;', '&lt;', '&gt;');




	public function index() {

		if (isset($_GET['lang'])) {
			$this->load->model('localisation/language');
			$languages = $this->model_localisation_language->getLanguages();

			if(isset($languages[$_GET['lang']])) {
				$language = $languages[$_GET['lang']];
				$this->config->set('config_language_id', $language['language_id']);
			}
		}



		$output = $this->generate();

		$this->response->addHeader('Content-Type: application/xml');
		$this->response->setOutput($output);
		
	}


	private function generate() {

		$sitemap = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n";
		$sitemap.= "\t<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" xmlns:image=\"http://www.google.com/schemas/sitemap-image/1.1\" >\r\n";

		$sitemap.= "\t<!-- Category images -->\r\n";
		$sitemap.= $this->categories();

		$sitemap.= "\t<!-- Products images -->\r\n";
		$sitemap.= $this->products();

		$sitemap.= "\t</urlset>";

		return $sitemap;      
	}



	private function products() {

		$this->load->model('catalog/product');

		$output = '';
		

		foreach ( $this->model_catalog_product->getProducts() as $product) {

			$images = array(array('image' => $product['image']));
			$images = array_merge($images, $this->model_catalog_product->getProductImages($product['product_id']));
			
			$product_url = $this->url->link('product/product', 'product_id=' . $product['product_id']);
			$caption = $product['name'];

			$output .= $this->node($product_url, $images, $caption);
		}

		return $output;        
	}

	private function categories() {

		$this->load->model('catalog/category');

		$output = '';

		foreach ($this->model_catalog_category->getCategories(array()) as $category) {
			
			$category_url = $this->url->link('product/category', 'path=' . $category['category_id']);
			$images = array(array('image' => $category['image']));
			$caption = $category['name'];

			$output .= $this->node($category_url, $images, $caption);
		}

		return $output;        

	}

	private function node($link, $images = array(), $caption = '') {

		if(!$images)
			return;

		$base = $this->getCatalogUrl() . 'image/';
		$link = str_replace("&", "&amp;", $link);
		
		// don't ask ...
		$caption = html_entity_decode($caption, ENT_COMPAT, 'UTF-8');
		$caption = html_entity_decode($caption, ENT_COMPAT, 'UTF-8');
		$caption = str_replace($this->allowed_entities, $this->replacement_entities, $caption);

		$output = "";  
		$output .= "\t<url>\r\n";     
		$output .= "\t\t<loc>" . $link . "</loc>\r\n";
		

		foreach ($images as $image) {
			
			$image_caption = $caption;
			if($this->smart_caption) {
				$filename = explode(".", pathinfo($image['image'], PATHINFO_FILENAME));
				$image_caption .= $this->smart_delimiter . str_replace($this->smart_separators, ' ', end($filename));
			}

			$image_loc = $base . str_replace("&", "&amp;", $image['image']);
			
			$output .= "\t\t<image:image>\r\n";
			$output .= "\t\t\t<image:loc>" .  $image_loc . "</image:loc>\r\n";
			$output .= "\t\t\t<image:caption>" . $image_caption . "</image:caption>\r\n";
			$output .= "\t\t</image:image>\r\n"; 
		}

		$output .= "\t</url>\r\n";

		return $output;        
	}



	private function getCatalogUrl() {
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1')))
		{
			$base = $this->config->get('config_ssl') ? $this->config->get('config_ssl') : HTTPS_CATALOG;
		}
		else 
		{
			$base = $this->config->get('config_url') ? $this->config->get('config_url') : HTTP_CATALOG;
		}

		return $base;
	}

}

?>