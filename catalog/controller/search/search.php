<?php
require_once('provider.php');

require_once "settings.php";


//comment
class ControllerSearchSearch extends Controller
{
    public function index()
    {
        if (isset($this->request->get['q'])) {
            $query = $this->request->get['q'];
        } else {
            $query = '';
        }
        if (isset($this->request->get['id'])) {
            $cache_id = $this->request->get['id'];
        } else {
            $cache_id = '';
        }
        $result = $this->GetTerms($query);
        $query = $result['q'];
        if (strlen($query) < 3 && $cache_id == '') {
            $this->redirect($this->url->link('error/not_found', '', 'SSL'));
        }
        $this->data['searchResult'] = array(
            'type' => 0,
            'ids' => ''
        );
        if ($cache_id == '') {
            $this->GetType($query);
        } else {
            $this->FetchCachedSearch($cache_id);
        }
        $this->data['searchResult']['ids'] = explode(",", $this->data['searchResult']['ids']);
        $this->data['searchResult']['ids'] = array_unique($this->data['searchResult']['ids']);
        $this->data['searchResult']['ids'] = implode(",", $this->data['searchResult']['ids']);
        if($cache_id == ''){
            $pu_database_name = $GLOBALS['pu_database_name'];
            $oc_database_name = $GLOBALS['oc_database_name'];
            $con_PU_db = $GLOBALS['con_PU_db'];
            $type = $this->data['searchResult']['type'];
            $ids = $this->data['searchResult']['ids'];
            $sql_insert_string = "INSERT INTO `pu_search_cache`" .
                "(`term`, `search_type`, `related_ids`)" .
                "VALUES ('$query', '$type', '$ids');";
            $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
            $id = mysqli_insert_id($con_PU_db);
            $cache_id = $id;
            $sql_insert_string = "INSERT INTO `pu_search_history`" .
                "(`term`)" .
                "VALUES ('$query');";
            $result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
        }
        if($this->data['searchResult']['type']){
            if ($this->data['searchResult']['type'] == 'product') {
                echo 1;
                if($this->data['searchResult']['ids']!=''){
                    $this->GetProductList($this->data['searchResult']['ids'],$cache_id);
                }else{
                    $this->redirect($this->url->link('error/not_found', '', 'SSL'));
                }
            } elseif ($this->data['searchResult']['type'] == 'subprofile') {
                echo 2;
                $this->GetSubprofileList($this->data['searchResult']['ids'],$cache_id);
            }
        }else {
            $this->redirect($this->url->link('error/not_found', '', 'SSL'));
        }
    }
    public function GetTerms($inQuery)
    {
        $ListOfTerms = array(
            'مقایسه' => "Related",
            'تخفیف' => "SortByRebate",
            'کوپن' => "SortByRebate",
            'کوپون' => "SortByRebate",
            'قیمت' => "PriceSearch",
            'ارزانترین' => "SortByPrice",
            'لیست' => "Nothing",
            'فروش' => "Nothing",
        );
        $terms = explode(" ", $inQuery);
        $relatedFunc = "";
        foreach ($terms as $term) {
            if (array_key_exists($term, $ListOfTerms)) {
                $relatedFunc = $ListOfTerms[$term];
                $inQuery = str_replace($term . " ", "", $inQuery);
            }
        }
        return array(
            'function' => $relatedFunc,
            'q' => $inQuery
        );
    }
    public function GetType($inQuery)
    {
        $this->SearchExactProduct($inQuery);
        $this->SearchExactSubprofile($inQuery);
        $this->SearchCustomTags($inQuery);
        $this->SearchRelatedTags($inQuery);
        $this->SearchProducts($inQuery);
        $this->SearchSubprofiles($inQuery);
    }
    public function FetchCachedSearch($id)
    {
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_select_string = "SELECT *  FROM $pu_database_name.pu_search_cache WHERE id = '$id'";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $this->data['searchResult']['type'] = $row['search_type'];
            $this->data['searchResult']['ids'] = $row['related_ids'];
            break;
        }
    }
    public function SearchExactProduct($inQuery)
    {
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_select_string = "SELECT product_id  FROM $oc_database_name.oc_product_description WHERE name = '$inQuery'";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $product_id = $row['product_id'];
            $this->data['searchResult']['type'] = 'product';
            $this->data['searchResult']['ids'] = $product_id;
            break;
        }
    }
    public function SearchExactSubprofile($inQuery)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $sql_select_string = "SELECT id  FROM pu_subprofile WHERE title = '$inQuery'";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $subprofile_id = $row['id'];
            $this->data['searchResult']['type'] = 'subprofile';
            $this->data['searchResult']['ids'] = $subprofile_id;
            break;
        }
    }
    public function SearchCustomTags($inQuery)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $isIn = false;
        $sql_select_string = "SELECT * FROM pu_custom_tags WHERE tag LIKE '%$inQuery%'";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            if ($row['products_id'] != '0') {
                $this->data['searchResult']['type'] = 'product';
                if ($this->data['searchResult']['ids'] == '') {
                    $this->data['searchResult']['ids'] = $row['products_id'];
                } else {
                    $this->data['searchResult']['ids'] .= ',' . $row['products_id'];
                }
            } elseif ($row['subprofiles_id'] != '0' && $this->data['searchResult']['type'] != 'product') {
                $this->data['searchResult']['type'] = 'subprofile';
                if ($this->data['searchResult']['ids'] == '') {
                    $this->data['searchResult']['ids'] = $row['subprofiles_id'];
                } else {
                    $this->data['searchResult']['ids'] .= ',' . $row['subprofiles_id'];
                }
            }
        }
    }
    public function SearchRelatedTags($inQuery)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $isIn = false;
        $sql_select_string2 = "SELECT tag FROM pu_related_tags WHERE related_tags LIKE '%$inQuery%'";
        $result_select2 = mysqli_query($con_PU_db, $sql_select_string2) or die(mysqli_error());
        while ($row2 = mysqli_fetch_assoc($result_select2)) {
            $tag = $row2['tag'];
            $sql_select_string = "SELECT * FROM pu_custom_tags WHERE tag LIKE '%$tag%'";
            $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
            while ($row = mysqli_fetch_assoc($result_select)) {
                if ($row['products_id'] != '0') {
                    $this->data['searchResult']['type'] = 'product';
                    if ($this->data['searchResult']['ids'] == '') {
                        $this->data['searchResult']['ids'] = $row['products_id'];
                    } else {
                        $this->data['searchResult']['ids'] .= ',' . $row['products_id'];
                    }
                } elseif ($row['subprofiles_id'] != '0' && $this->data['searchResult']['type'] != 'product') {
                    $this->data['searchResult']['type'] = 'subprofile';
                    if ($this->data['searchResult']['ids'] == '') {
                        $this->data['searchResult']['ids'] = $row['subprofiles_id'];
                    } else {
                        $this->data['searchResult']['ids'] .= ',' . $row['subprofiles_id'];
                    }
                }
            }
        }
    }

    public function SearchProducts($inQuery)
    {
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $con_PU_db = $GLOBALS['con_PU_db'];
        $isIn = false;
        $sql_select_string = "SELECT product_id  FROM $oc_database_name.oc_product_description WHERE name LIKE '%$inQuery%'";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($result_select)) {
            $this->data['searchResult']['type'] = 'product';
            if ($this->data['searchResult']['ids'] == '') {
                $this->data['searchResult']['ids'] = $row['product_id'];
            } else {
                $this->data['searchResult']['ids'] .= ',' . $row['product_id'];
            }
        }
    }

    public function SearchSubprofiles($inQuery)
    {
        $con_PU_db = $GLOBALS['con_PU_db'];
        $isIn = false;
        $sql_select_string = "SELECT id  FROM pu_subprofile WHERE title LIKE '%$inQuery%'";
        $result_select = mysqli_query($con_PU_db, $sql_select_string) or die(mysqli_error());
        $subprofiles_id = '';
        if ($this->data['searchResult']['type'] != 'product') {
            while ($row = mysqli_fetch_assoc($result_select)) {
                $this->data['searchResult']['type'] = 'subprofile';
                if ($this->data['searchResult']['ids'] == '') {
                    $this->data['searchResult']['ids'] = $row['id'];
                } else {
                    $this->data['searchResult']['ids'] .= ',' . $row['id'];
                }
            }
        }
    }


    public function GetProductList($products_id,$cache_id)
    {
        $products_id_array = explode(",", $products_id);
        rsort($products_id_array);
        $total = count($products_id_array);
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }
        $products_id_array = array_slice($products_id_array,($page-1)*20,20);
        $this->language->load('product/category');

        $this->load->model('catalog/category');

        $this->load->model('catalog/product');

        $this->load->model('tool/image');


        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home'),
            'separator' => false
        );

        // view links products

        $this->data['view_product_li'] = $this->language->get('view_product_li');
        $this->data['view_product_no_price'] = $this->language->get('view_product_no_price');

        $this->document->addScript('catalog/view/javascript/jquery/jquery.total-storage.min.js');
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

        $this->data['categories'] = array();


        $this->data['products'] = array();


        //
        $product_total = count($products_id_array);
        $results = array();
        foreach ($products_id_array as $product_id) {
            $results[] = $this->model_catalog_product->getProduct($product_id);
        }

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
                'href' => $this->url->link('product/product', '&product_id=' . $result['product_id'] . $url)
            );
        }

        $url = '';

        if (isset($this->request->get['filter'])) {
            $url .= '&filter=' . $this->request->get['filter'];
        }

        if (isset($this->request->get['limit'])) {
            $url .= '&limit=' . $this->request->get['limit'];
        }


        if ($this->config->get('config_review_status')) {
            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_rating_desc'),
                'value' => 'rating-DESC',
                'href' => $this->url->link('product/category', '&sort=rating&order=DESC' . $url)
            );

            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_rating_asc'),
                'value' => 'rating-ASC',
                'href' => $this->url->link('product/category', '&sort=rating&order=ASC' . $url)
            );
        }

        $this->data['sorts'][] = array(
            'text' => $this->language->get('text_model_asc'),
            'value' => 'p.model-ASC',
            'href' => $this->url->link('product/category', '&sort=p.model&order=ASC' . $url)
        );

        $this->data['sorts'][] = array(
            'text' => $this->language->get('text_model_desc'),
            'value' => 'p.model-DESC',
            'href' => $this->url->link('product/category', '&sort=p.model&order=DESC' . $url)
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

        $this->data['limits'] = array();

        $limits = array_unique(array($this->config->get('config_catalog_limit'), 25, 50, 75, 100));

        sort($limits);

        foreach ($limits as $value) {
            $this->data['limits'][] = array(
                'text' => $value,
                'value' => $value,
                'href' => $this->url->link('product/category', $url . '&limit=' . $value)
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

        $this->data['continue'] = $this->url->link('common/home');

        $pagination = new Pagination();
        $pagination->total = $total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('search/search', 'id=' . $cache_id . '&page={page}', 'SSL');

        $this->data['pagination'] = $pagination->render();

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/search/search_product_list.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/search/search_product_list.tpl';
        } else {
            $this->template = 'default/template/search/search_product_list.tpl';
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


    public function GetSubprofileList($subprofiles_id,$cache_id)
    {
        $subprofiles_id = explode(",", $subprofiles_id);
        rsort($subprofiles_id);
        $total = count($subprofiles_id);
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }
        $subprofiles_id = array_slice($subprofiles_id,($page-1)*20,20);

        $this->language->load('product/subprofiles');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->data['breadcrumbs'] = array();
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home'),
            'separator' => false
        );
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('product/subprofiles'),
            'separator' => $this->language->get('text_separator')
        );

# Language
        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['text_content'] = $this->language->get('text_content');
        $this->data['button_wishlist'] = $this->language->get('button_wishlist');
        $this->data['button_compare'] = $this->language->get('button_compare');
        $this->data['button_continue'] = $this->language->get('button_continue');
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

# Gets

        if (isset($this->request->get['path'])) {
            $group_id = $this->request->get['path'];
        } else {
            $group_id = 'a';
        }

        if (isset($this->request->get['limit'])) {
            $limit = $this->request->get['limit'];
        } else {
            $limit = $this->config->get('config_catalog_limit');
        }
# Models
        $this->language->load('product/category');

        $this->load->model('provider/pu_subprofile');


        foreach ($subprofiles_id as $subprofile_id)
            $subprofiles[] = $this->model_provider_pu_subprofile->GetSubprofileByID($subprofile_id);

        if (isset($subprofiles)) {
            $this->data['subprofiles'] = $subprofiles;
        }

        $pagination = new Pagination();
        $pagination->total = $total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('search/search', 'id=' . $cache_id . '&page={page}', 'SSL');

        $this->data['pagination'] = $pagination->render();

# Fallback
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/subprofiles.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/product/subprofiles.tpl';
        } else {
            $this->template = 'default/template/product/subprofiles.tpl';
        }

# Children
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

?>
     