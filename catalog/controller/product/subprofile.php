<?php

require_once "settings.php";

class ControllerProductSubprofile extends Controller
{

    public function index()
    {

        $this->language->load('product/subprofile');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->data['breadcrumbs'] = array();
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home'),
            'separator' => false
        );

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

        $this->load->model('provider/pu_subprofile');
        $this->load->model('provider/pu_rating');

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            if (isset($this->request->post['comment'])) {
                $subprofile_id = $this->request->post['subprofile_id'];
                $this->model_provider_pu_subprofile->AddSubprofileComments($this->customer->getId(),$subprofile_id,$this->request->post['comment']);
            } else {
                $subprofile_id = $this->request->post['subprofile_id'];
                foreach ($_POST['select'] as $key => $value) {
                    if (!$this->model_provider_pu_rating->isUserRate($this->customer->getId(), $subprofile_id, $key)) {
                        $this->model_provider_pu_rating->addUserRate($this->customer->getId(), $subprofile_id, $key, $value);
                        $this->model_provider_pu_rating->updateSubprofileRate($subprofile_id, $key, $value);
                    } else {
                        $user_rate = $this->model_provider_pu_rating->getUserRate($this->customer->getId(), $subprofile_id, $key);
                        $this->model_provider_pu_rating->updateUserRate($this->customer->getId(), $subprofile_id, $key, $value);
                        $this->model_provider_pu_rating->updateExistSubprofileRate($subprofile_id, $key, $value, $user_rate['rate']);
                    }
                }
            }

        } else {
            if (isset($this->request->get['id'])) {
                $subprofile_id = $this->request->get['id'];
            } else {
                $subprofile_id = '0';
            }
        }

# Language

        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['text_rank_all'] = $this->language->get('text_rank_all');
        $this->data['text_products'] = $this->language->get('text_products');
        $this->data['text_map'] = $this->language->get('text_map');
        $this->data['text_cmments'] = $this->language->get('text_cmments');
        $this->data['p_contact_login'] = $this->language->get('p_contact_login');
        $this->data['p_address'] = $this->language->get('p_address');
        $this->data['p_contact_tel'] = $this->language->get('p_contact_tel');
        $this->data['p_contact_mobile'] = $this->language->get('p_contact_mobile');
        $this->data['p_contact_email'] = $this->language->get('p_contact_email');
        $this->data['p_contact'] = $this->language->get('p_contact');
        $this->data['p_contact_limit'] = $this->language->get('p_contact_limit');

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


# Models 
        $this->language->load('product/category');

        $subprofile = $this->model_provider_pu_subprofile->GetSubprofileByID($subprofile_id);


        if (isset($subprofile)) {
            $this->data['subprofile'] = $subprofile;
        }
        $this->data['subprofile_id'] = $subprofile_id;

        $rating_items = $this->model_provider_pu_rating->getRatingItems();

        $rates_info = array();

        foreach ($rating_items as $rating_item) {
            $rating_info = $this->model_provider_pu_rating->getSubprofileRating($subprofile['id'], $rating_item['id']);
            $user_rate_info = null;
            if ($this->customer->isLogged()) {
                $user_rate_info = $this->model_provider_pu_rating->getUserRate($this->customer->getId(), $subprofile['id'], $rating_item['id']);
                $rates_info[] = array(
                    'rating_item' => $rating_item,
                    'rating_info' => $rating_info,
                    'user_rate_info' => $user_rate_info
                );
            } else {
                $rates_info[] = array(
                    'rating_item' => $rating_item,
                    'rating_info' => $rating_info
                );
            }

        }
        $this->data['rates_info'] = $rates_info;

        $total = $this->model_provider_pu_subprofile->CountGetListOfProductsOfSubprofileByID($subprofile_id);
        $products = $this->model_provider_pu_subprofile->GetListOfProductsOfSubprofileByID($subprofile_id,$page,$limit);
        for($i=0;$i<count($products)-1;$i++){
            $info = $this->model_provider_pu_subprofile->GetSpecificProductsOfSubprofile($subprofile_id,$products[$i]['product_id']);
            $products[$i]['sub_price'] = $info['price'];
            $products[$i]['buy_link'] = $info['buy_link'];
            $products[$i]['description'] = $info['description'];
            $products[$i]['update_date'] = $info['update_date'];
        }

        $this->data['comments'] = $this->model_provider_pu_subprofile->GetSubprofileComments($subprofile_id);
        if (isset($products)) {
            $this->data['products'] = $products;
        }
        if ($this->customer->isLogged()) {
            $this->data['p_login_c'] = '1';
        } else {
            $this->data['p_login_c'] = '0';
        }
# Fallback
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/subprofile.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/product/subprofile.tpl';
        } else {
            $this->template = 'default/template/product/subprofile.tpl';
        }
        $this->data['total'] = $total;

        $pagination = new Pagination();
        $pagination->total = $total;
        $pagination->page = $page;
        $pagination->limit = $limit;
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('product/subprofile', 'id=' . $subprofile_id . '&page={page}');
        $this->data['pagination'] = $pagination->render();

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