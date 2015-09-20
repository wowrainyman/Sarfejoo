<?php
header('Content-Type: text/html; charset=utf-8');
class ControllerCommonHome extends Controller
{
    public function index()
    {
        if (isset($this->request->get['u'])){
            $this->load->model('common/seo');
            $this->data['url'] = $this->request->get['u'];
            $this->data['url'] = str_ireplace("www.","", $this->data['url']);
            $results = $this->model_common_seo->GetProductsByLink($this->request->get['u']);
            if(count($results)>0){
                $index = rand(0,count($results)-1);
                $product_id = $results[$index]['product_id'];
                $this->session->data['seo'] = str_replace("&amp;","&",$results[$index]['buy_link']);
                $this->data['url'] = $this->url->link('product/product', '&product_id=' . $product_id);
                $this->data['url']=str_replace("&amp;","&",$this->data['url']);
            }else{
                $this->data['url'] = $this->url->link('product/category', '&path=59_66');
                $this->data['url']=str_replace("&amp;","&",$this->data['url']);
            }
        }
        if (isset($this->request->get['lifetime'])){
            $this->session->data['lifetime'] = "true";
        }
        if (isset($this->request->get['unsetlifetime'])){
            unset($this->session->data['lifetime']);
        }

			//if (isset($this->session->data['proute']) && (($this->session->data['proute'] == 'product/product') || ($this->session->data['proute'] == 'product/category') || ($this->session->data['proute'] == 'product/manufacturer/product') || ($this->session->data['proute'] == 'information/information') || ($this->session->data['proute'] == 'product/manufacturer/info'))) {unset($this->request->post['redirect']);$this->session->data['proute'] = '';}
			$this->session->data['proute'] = 'common/home';
			$titles = $this->config->get('config_title');
			
        $this->document->setTitle($titles[$this->config->get('config_language_id')]);

				$this->document->addLink($this->config->get('config_url'), 'canonical');
$meta_descriptions = $this->config->get('config_meta_description');
$this->document->setKeywords($this->config->get('config_meta_keywords'));
        $this->document->setDescription($meta_descriptions[$this->config->get('config_language_id')]);

        $this->data['heading_title'] = $titles[$this->config->get('config_language_id')];

        $this->data['text_he_most_visited'] = $this->language->get('text_he_most_visited');
        $this->data['text_he_product'] = $this->language->get('text_he_product');
        $this->data['text_he_service'] = $this->language->get('text_he_service');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/home.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/common/home.tpl';
        } else {
            $this->template = 'default/template/common/home.tpl';
        }

        $this->load->model('module/home');
        $recent_updates = $this->model_module_home->GetRecentSubprofilesUpdate();
//Recent Updates
        foreach ($recent_updates as $up_subprofile) {
            $subprofile_product_id = $up_subprofile['subprofile_product_id'];
            $sql_old_prices = $this->model_module_home->GetOldPrice($subprofile_product_id);


            if ($sql_old_prices == 0) {
                $sql_old_prices = $up_subprofile['new_price'];
            }
            $percentage = $up_subprofile['new_price'] - $sql_old_prices;
            $percentage_price = ($percentage / $sql_old_prices) * 100;

            $list_updates[] = array(
                'href'  =>  $this->url->link('product/subprofile', 'subprofile_id=' . $up_subprofile['id']),
                'new_price' => $up_subprofile['new_price'],
                'name' => $up_subprofile['name'],
                'product_id' => $up_subprofile['product_id'],
                'update_date' => $up_subprofile['update_date'],
                'title' => $up_subprofile['title'],
                'id' => $up_subprofile['id'],
                'logo' => $up_subprofile['logo'],
                'customer_id' => $up_subprofile['customer_id'],
                'price' => round($percentage_price, 2)
            );
        }

        $this->load->model('catalog/product');
        $this->load->model('tool/image');
        $this->load->model('provider/pu_subprofile');
        $this->load->model('account/customer');

//Two selective product
        $data = array(
            'filter_category_id' => '59',
            'filter_sub_category' => true,
            'filter_filter'      => '',
            'sort'               => 'p.in_home',
            'order'              => 'DESC',
            'start'              => '0',
            'limit'              => '4'
        );
        $topProducts_info = $this->model_catalog_product->getProducts($data);

        foreach($topProducts_info as $product){
            $product['image'] = $this->model_tool_image->resize($product['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
            $product['href'] = $this->url->link('product/product', '&product_id=' . $product['product_id']);
            $product['minprice'] = $this->model_provider_pu_subprofile->GetMinimumPriceOfProduct($product['product_id']);
            $product['maxprice'] = $this->model_provider_pu_subprofile->GetMaximumPriceOfProduct($product['product_id']);
            $product['avg_price'] = $this->model_provider_pu_subprofile->GetAveragepricePriceOfProduct($product['product_id']);
            $providers = $this->model_provider_pu_subprofile->GetAllSubprofileOfProducts($product['product_id']);
            $product['providers_count'] = count($providers);
            $twoProducts[] = $product;
        }
        $this->data['twoProducts'] = $twoProducts;

//Two selective service
        $data = array(
            'filter_category_id' => '60',
            'filter_sub_category' => true,
            'filter_filter'      => '',
            'sort'               => 'p.in_home',
            'order'              => 'DESC',
            'start'              => '0',
            'limit'              => '2'
        );
        $topServices_info = $this->model_catalog_product->getProducts($data);

        foreach($topServices_info as $service){
            $service['image'] = $this->model_tool_image->resize($service['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
            $service['href'] = $this->url->link('product/product', '&product_id=' . $service['product_id']);
            $service['minprice'] = $this->model_provider_pu_subprofile->GetMinimumPriceOfProduct($service['product_id']);
            $service['minprice'] = $service['minprice']['MIN(price)'];
            $service['maxprice'] = $this->model_provider_pu_subprofile->GetMaximumPriceOfProduct($service['product_id']);
            $service['maxprice'] = $service['maxprice']['MAX(price)'];
            $service['avg_price'] = $this->model_provider_pu_subprofile->GetAveragepricePriceOfProduct($service['product_id']);
            $providers = $this->model_provider_pu_subprofile->GetAllSubprofileOfProducts($service['product_id']);
            $service['providers_count'] = count($providers);
            $twoServices[] = $service;
        }
        $this->data['twoServices'] = $twoServices;

//Top 6 Products
        $data = array(
            'filter_category_id' => '59',
            'filter_sub_category' => true,
            'filter_filter'      => '',
            'sort'               => 'p.viewed',
            'order'              => 'DESC',
            'start'              => '0',
            'limit'              => '6'
        );
        $topProducts_info = $this->model_catalog_product->getProducts($data);

        foreach($topProducts_info as $topProduct){
            $topProduct['image'] = $this->model_tool_image->resize($topProduct['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
            $topProduct['href'] = $this->url->link('product/product', '&product_id=' . $topProduct['product_id']);
            $topProducts[] = $topProduct;
        }
        $this->data['topProducts'] = $topProducts;


//Top 6 Services
        $data = array(
            'filter_category_id' => '60',
            'filter_sub_category' => true,
            'filter_filter'      => '',
            'sort'               => 'p.viewed',
            'order'              => 'DESC',
            'start'              => '0',
            'limit'              => '6'
        );
        $topServices_info = $this->model_catalog_product->getProducts($data);
        foreach($topServices_info as $topService){
            $topService['image'] = $this->model_tool_image->resize($topService['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
            $topService['href'] = $this->url->link('product/product', '&product_id=' . $topService['product_id']);
            $topServices[] = $topService;
        }
        $this->data['topServices'] = $topServices;

//total Products
        /*$data = array(
            'filter_category_id' => '59',
            'filter_sub_category' => true,
            'filter_filter'      => '',
            'sort'               => 'p.viewed',
            'order'              => 'DESC',
            'start'              => '0',
            'limit'              => '10000'
        );
        $topProducts_info = $this->model_catalog_product->getProducts($data);*/
        $this->data['totalProducts'] = "1140";

//total Services
       /* $data = array(
            'filter_category_id' => '60',
            'filter_sub_category' => true,
            'filter_filter'      => '',
            'sort'               => 'p.viewed',
            'order'              => 'DESC',
            'start'              => '0',
            'limit'              => '10000'
        );
        $topServices_info = $this->model_catalog_product->getProducts($data);*/
        $this->data['totalServices'] = "881";

//total subprofiles
        $subs = $this->model_provider_pu_subprofile->GetCountSubprofiles();
        $this->data['totalSubprofiles'] = $subs['COUNT(id)'];

//total customers
        $customers = $this->model_account_customer->GetCountCustomers();

        $this->data['stext'] = $this->generateSeoText();

        $this->data['totalCustomers'] = $customers[0]['COUNT(customer_id)'];

        $this->data['list_updates'] = $list_updates;

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
    public function generateSeoText()
    {
        $text = "";
        $terms[]= 'لیست قیمت گوشی';
        $terms[]= 'لیست قیمت گوشی موبایل';
        $terms[]= 'مقایسه قیمت';
        $terms[]= 'مقایسه گوشی';
        $terms[]= 'صرفه جویی';
        if (count($terms) > 0) {
            $content = file_get_contents("homeseo.xml");
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
}

?>