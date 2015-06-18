<?php
require_once "settings.php";

require_once "jdf.php";
/**
 * Created by PhpStorm.
 * User: Amir
 * Date: 10/9/2014
 * Time: 9:41 AM
 */
class ControllerProviderSubprofile extends Controller
{
    private $error = array();
    public function index()
    {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('provider/profile', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        $this->language->load('provider/subprofile');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('provider/pu_subprofile');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->session->data['success'] = $this->language->get('text_success');
            $this->redirect($this->url->link('account/account', '', 'SSL'));
        }
        $this->data['breadcrumbs'] = array();
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home'),
            'separator' => false
        );
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_account'),
            'href' => $this->url->link('provider/profile', '', 'SSL'),
            'separator' => $this->language->get('text_separator')
        );
        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }
        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['text_profile'] = $this->language->get('text_profile');
        $this->data['entry_title'] = $this->language->get('entry_title');
        $this->data['entry_province'] = $this->language->get('entry_province');
        $this->data['entry_city'] = $this->language->get('entry_city');
        $this->data['entry_address'] = $this->language->get('entry_address');
        $this->data['entry_tel'] = $this->language->get('entry_tel');
        $this->data['entry_mobile'] = $this->language->get('entry_mobile');
        $this->data['entry_email'] = $this->language->get('entry_email');
        $this->data['entry_website'] = $this->language->get('entry_website');
        $this->data['entry_picture'] = $this->language->get('entry_picture');
        $this->data['entry_logo'] = $this->language->get('entry_logo');
        $this->data['entry_persontype'] = $this->language->get('entry_persontype');
        $this->data['entry_legalperson'] = $this->language->get('entry_legalperson');
        $this->data['entry_naturalperson'] = $this->language->get('entry_naturalperson');
        $this->data['entry_edit'] = $this->language->get('entry_edit');
        $this->data['entry_add_credit'] = $this->language->get('entry_add_credit');
        $this->data['entry_status'] = $this->language->get('entry_status');
        $this->data['entry_expire_date'] = $this->language->get('entry_expire_date');
        $this->data['button_add'] = $this->language->get('button_add');
        $this->data['button_continue'] = $this->language->get('button_continue');
        $this->data['button_back'] = $this->language->get('button_back');
        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }
        if (isset($this->error['firstname'])) {
            $this->data['error_firstname'] = $this->error['firstname'];
        } else {
            $this->data['error_firstname'] = '';
        }
        $this->data['action'] = $this->url->link('provider/subprofile', '', 'SSL');
        $this->load->model('provider/pu_status');
        $statusArr = array();
        if ($this->request->server['REQUEST_METHOD'] != 'POST') {
            $customer_info = $this->model_provider_pu_subprofile->GetCustomerSubProfiles($this->customer->getId());//from pu
            foreach ($customer_info as $c) {
                $statusArr[$c['id']] = $this->model_provider_pu_status->GetStatus($c['status_id']);
                $c_expire_date = $this->model_provider_pu_subprofile->getSubprofileExpireDate($c['id']);
                if($c_expire_date && strtotime($c_expire_date) > time()) {
                    $expire_date[$c['id']] = jdate("l - j F o",strtotime($c_expire_date));
                }else{
                    $expire_date[$c['id']] = "منقضی شده";
                }
            }
        }
        if (isset($customer_info)) {
            $this->data['customer_infos'] = $customer_info;
            $this->data['statusArr'] = $statusArr;
            $this->data['expire_date'] = $expire_date;
        }
        $this->data['back'] = $this->url->link('account/account', '', 'SSL');
        $this->data['edit'] = $this->url->link('provider/subprofile/Add', '', 'SSL');
        $this->data['add_credit'] = $this->url->link('financial/subprofile_plan', '', 'SSL');
        $this->data['add'] = $this->url->link('provider/subprofile/Add', '', 'SSL');
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/provider/subprofile.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/provider/subprofile.tpl';
        } else {
            $this->template = 'default/template/provider/subprofile.tpl';
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
    protected function validate()
    {
        return true;
    }
    protected function Addvalidate()
    {
        return true;
        if ((utf8_strlen($this->request->post['title']) < 1) || (utf8_strlen($this->request->post['title']) > 32)) {
            $this->error['title'] = $this->language->get('error_title');
        }
        if ((utf8_strlen($this->request->post['city']) < 1) || (utf8_strlen($this->request->post['city']) > 32)) {
            $this->error['city'] = $this->language->get('error_city');
        }
        if ((utf8_strlen($this->request->post['address']) < 1) || (utf8_strlen($this->request->post['address']) > 32)) {
            $this->error['address'] = $this->language->get('error_address');
        }
        if ((utf8_strlen($this->request->post['tel']) < 1) || !preg_match('/^[1-9][0-9]*$/', $this->request->post['tel'])) {
            $this->error['tel'] = $this->language->get('error_tel');
        }
        if ((utf8_strlen($this->request->post['mobile']) < 1) || !preg_match('/^[1-9][0-9]*$/', $this->request->post['mobile'])) {
            $this->error['mobile'] = $this->language->get('error_mobile');
        }
        if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
            $this->error['email'] = $this->language->get('error_email');
        }
        if ((utf8_strlen($this->request->post['website']) < 1) || (utf8_strlen($this->request->post['website']) > 32)) {
            $this->error['website'] = $this->language->get('error_website');
        }
        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
    protected function EditLegalPersonvalidate()
    {
        if ((utf8_strlen($this->request->post['registrationid']) < 1) || (utf8_strlen($this->request->post['registrationid']) > 32)) {
            $this->error['registrationid'] = $this->language->get('error_registrationid');
        }
        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
    public function Add()
    {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('provider/profile', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        $this->language->load('provider/subprofile_add');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('provider/pu_subprofile');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->Addvalidate()) {
            $this->session->data['success'] = $this->language->get('text_success');
            $date = new DateTime();
            if (!empty ($_FILES)) {
                //upload nationalcard pic
                if ($_FILES ["picture"] ["error"] > 0) {
                    echo "Return Code: " . $_FILES ["picture"] ["error"] . "<br>";
                } else {
                    $fileName = "picture_" . $date->getTimestamp();
                    $folderName = $this->customer->getId();
                    $subfolder = $this->request->post["id"];
                    $folderPlace = $GLOBALS['providers_scans_folder'];
                    $finalFilePath = $folderPlace . "/" . $folderName . "/" . $subfolder . "/" . $fileName;
                    if (!is_dir($folderPlace)) {
                        mkdir($folderPlace);
                    }
                    if (!is_dir($folderPlace . "/" . $folderName)) {
                        mkdir($folderPlace . "/" . $folderName);
                    }
                    if (!is_dir($folderPlace . "/" . $folderName . "/" . $subfolder)) {
                        mkdir($folderPlace . "/" . $folderName . "/" . $subfolder);
                    }
                    $path = $_FILES['picture']['name'];
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    if (file_exists($finalFilePath . "." . $ext)) {
                        // Amir ////////////////if we want to check exist of an image we must do script here
                    } else {
                        // Amir ////////////////if we want to check image on server side we must do this script
                        /*                        $info = getimagesize($_FILES['nationalcardpic']['tmp_name']);
                                                if ($info === FALSE) {
                                                    die("Unable to determine image type of uploaded file");
                                                }
                                                if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
                                                    die("Not a gif/jpeg/png");
                                                }*/
                        move_uploaded_file($_FILES ["picture"] ["tmp_name"], $finalFilePath . "." . $ext);
                        $picext = $ext;
                        $isPictureChanged = true;
                    }
                }
                //upload agreement pic
                if ($_FILES ["logo"] ["error"] > 0) {
                    echo "Return Code: " . $_FILES ["logo"] ["error"] . "<br>";
                } else {
                    $fileName = "logo_" . $date->getTimestamp();
                    $folderName = $this->customer->getId();
                    $subfolder = $this->request->post["id"];
                    $folderPlace = $GLOBALS['providers_scans_folder'];
                    $finalFilePath = $folderPlace . "/" . $folderName . "/" . $subfolder . "/" . $fileName;
                    if (!is_dir($folderPlace)) {
                        mkdir($folderPlace);
                    }
                    if (!is_dir($folderPlace . "/" . $folderName)) {
                        mkdir($folderPlace . "/" . $folderName);
                    }
                    if (!is_dir($folderPlace . "/" . $folderName . "/" . $subfolder)) {
                        mkdir($folderPlace . "/" . $folderName . "/" . $subfolder);
                    }
                    $path = $_FILES['logo']['name'];
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    if (file_exists($finalFilePath . "." . $ext)) {
                        // Amir ////////////////if we want to check exist of an image we must do script here
                    } else {
                        // Amir ////////////////if we want to check image on server side we must do this script
                        /*                        $info = getimagesize($_FILES['nationalcardpic']['tmp_name']);
                                                if ($info === FALSE) {
                                                    die("Unable to determine image type of uploaded file");
                                                }
                                                if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
                                                    die("Not a gif/jpeg/png");
                                                }*/
                        move_uploaded_file($_FILES ["logo"] ["tmp_name"], $finalFilePath . "." . $ext);
                        $logoext = $ext;
                        $isLogoChanged = true;
                    }
                }
            }
            if (isset($this->request->post['id'])) {
                if ($this->request->post['id']) {
                    echo $this->request->post['id'];
                    $id = $this->request->post['id'];
                    $this->model_provider_pu_subprofile->EditSubprofile($this->request->post);
                    if ($isLogoChanged)
                        $this->model_provider_pu_subprofile->EditLogo($id, $date->getTimestamp() . '.' . $logoext);
                    if ($isPictureChanged)
                        $this->model_provider_pu_subprofile->EditPicture($id, $date->getTimestamp() . '.' . $picext);
                    $folderName = $this->customer->getId();
                    $subfolder = $id;
                    $folderPlace = $GLOBALS['providers_scans_folder'];
                    $finalFilePath = $folderPlace . "/" . $folderName . "/" . $subfolder . "/" . "map.png";
                    if (!is_dir($folderPlace . "/" . $folderName)) {
                        mkdir($folderPlace . "/" . $folderName);
                    }
                    if (!is_dir($folderPlace . "/" . $folderName . "/" . $subfolder)) {
                        mkdir($folderPlace . "/" . $folderName . "/" . $subfolder);
                    }
                    $lat = $this->request->post['lat'];
                    $lon = $this->request->post['lon'];
                    $zoom = $this->request->post['zoom'];
                    $zoom -= 2;
                    copy("https://maps.googleapis.com/maps/api/staticmap?center=$lat,$lon&zoom=$zoom&size=300x250", $finalFilePath);
                    if ($this->request->post['legalperson_id'] == "1") {
                        $this->redirect($this->url->link('provider/subprofile/EditLegalPerson', "id=$id", 'SSL'));
                    }
                } else {
                    $id = $this->model_provider_pu_subprofile->AddSubprofile($this->request->post);
                    if ($isLogoChanged)
                        $this->model_provider_pu_subprofile->EditLogo($id, $date->getTimestamp() . '.' . $logoext);
                    if ($isPictureChanged)
                        $this->model_provider_pu_subprofile->EditPicture($id, $date->getTimestamp() . '.' . $picext);
                    $folderName = $this->customer->getId();
                    $subfolder = $id;
                    $folderPlace = $GLOBALS['providers_scans_folder'];
                    $finalFilePath = $folderPlace . "/" . $folderName . "/" . $subfolder . "/" . "map.png";
                    if (!is_dir($folderPlace . "/" . $folderName)) {
                        mkdir($folderPlace . "/" . $folderName);
                    }
                    if (!is_dir($folderPlace . "/" . $folderName . "/" . $subfolder)) {
                        mkdir($folderPlace . "/" . $folderName . "/" . $subfolder);
                    }
                    $lat = $this->request->post['lat'];
                    $lon = $this->request->post['lon'];
                    $zoom = $this->request->post['zoom'];
                    $zoom -= 2;
                    copy("https://maps.googleapis.com/maps/api/staticmap?center=$lat,$lon&zoom=$zoom&size=300x250", $finalFilePath);
                    $visitors = $this->model_provider_pu_subprofile->GetAllVisitors();
                    $is_visitor = false;
                    foreach($visitors as $visitor){
                        if($visitor['customer_id'] == $this->customer->getId()){
                            $is_visitor = true;
                            break;
                        }
                    }
                    if ($is_visitor) {
                        $this->model_provider_pu_subprofile->UpdateSubprofilePayedStatus($id,1);
                        $this->model_provider_pu_subprofile->EditSubprofileStatus($id,1);
                    }
                    if ($this->request->post['legalperson_id'] == "1"){
                        $this->redirect($this->url->link('provider/subprofile/EditLegalPerson', "id=$id", 'SSL'));
                    }else{
                        $this->redirect($this->url->link('provider/subprofile', "", 'SSL'));
                        //$this->redirect($this->url->link('financial/plan', "type=subprofile&id=$id", 'SSL'));
                    }
                }
            }
            $this->redirect($this->url->link('account/account', '', 'SSL'));
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home'),
            'separator' => false
        );
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_account'),
            'href' => $this->url->link('provider/profile', '', 'SSL'),
            'separator' => $this->language->get('text_separator')
        );
        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }
        $this->load->model('localisation/zone');
        $this->data['provinces'] = $this->model_localisation_zone->getZonesByCountryId(101);
        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['text_profile'] = $this->language->get('text_profile');
        $this->data['text_select'] = $this->language->get('text_select');
        $this->data['entry_subprofilegroup'] = $this->language->get('entry_subprofilegroup');
        $this->data['entry_subprofile_group1'] = $this->language->get('entry_subprofile_group1');
        $this->data['entry_subprofile_group2'] = $this->language->get('entry_subprofile_group2');
        $this->data['entry_title'] = $this->language->get('entry_title');
        $this->data['entry_province'] = $this->language->get('entry_province');
        $this->data['entry_city'] = $this->language->get('entry_city');
        $this->data['entry_address'] = $this->language->get('entry_address');
        $this->data['entry_tel'] = $this->language->get('entry_tel');
        $this->data['entry_mobile'] = $this->language->get('entry_mobile');
        $this->data['entry_email'] = $this->language->get('entry_email');
        $this->data['entry_website'] = $this->language->get('entry_website');
        $this->data['entry_picture'] = $this->language->get('entry_picture');
        $this->data['entry_logo'] = $this->language->get('entry_logo');
        $this->data['entry_persontype'] = $this->language->get('entry_persontype');
        $this->data['entry_legalperson'] = $this->language->get('entry_legalperson');
        $this->data['entry_naturalperson'] = $this->language->get('entry_naturalperson');
        $this->data['button_add'] = $this->language->get('button_add');
        $this->data['button_continue'] = $this->language->get('button_continue');
        $this->data['button_back'] = $this->language->get('button_back');
        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }
        if (isset($this->error['title'])) {
            $this->data['error_title'] = $this->error['title'];
        } else {
            $this->data['error_title'] = '';
        }
        if (isset($this->error['country'])) {
            $this->data['error_country'] = $this->error['country'];
        } else {
            $this->data['error_country'] = '';
        }
        if (isset($this->error['city'])) {
            $this->data['error_city'] = $this->error['city'];
        } else {
            $this->data['error_city'] = '';
        }
        if (isset($this->error['address'])) {
            $this->data['error_address'] = $this->error['address'];
        } else {
            $this->data['error_address'] = '';
        }
        if (isset($this->error['tel'])) {
            $this->data['error_tel'] = $this->error['tel'];
        } else {
            $this->data['error_tel'] = '';
        }
        if (isset($this->error['mobile'])) {
            $this->data['error_mobile'] = $this->error['mobile'];
        } else {
            $this->data['error_mobile'] = '';
        }
        if (isset($this->error['email'])) {
            $this->data['error_email'] = $this->error['email'];
        } else {
            $this->data['error_email'] = '';
        }
        if (isset($this->error['website'])) {
            $this->data['error_website'] = $this->error['website'];
        } else {
            $this->data['error_website'] = '';
        }
        $this->data['action'] = $this->url->link('provider/subprofile/Add', '', 'SSL');
        if ($this->request->server['REQUEST_METHOD'] != 'POST') {
            if (isset($this->request->get['id']))
                $customer_info = $this->model_provider_pu_subprofile->GetCustomerSubProfile($this->request->get['id']);
        }
        if (isset($this->request->post['id'])) {
            $this->data['id'] = $this->request->post['id'];
        } elseif (isset($customer_info)) {
            $this->data['id'] = $customer_info['id'];
        } else {
            $this->data['id'] = '';
        }
        if (isset($this->request->post['group_id'])) {
            $this->data['group_id'] = $this->request->post['group_id'];
        } elseif (isset($customer_info)) {
            $this->data['group_id'] = $customer_info['group_id'];
        } else {
            $this->data['group_id'] = '';
        }
        if (isset($this->request->post['title'])) {
            $this->data['title'] = $this->request->post['title'];
        } elseif (isset($customer_info)) {
            $this->data['title'] = $customer_info['title'];
        } else {
            $this->data['title'] = '';
        }
        if (isset($this->request->post['legalperson_id'])) {
            $this->data['legalperson_id'] = $this->request->post['legalperson_id'];
        } elseif (isset($customer_info)) {
            $this->data['legalperson_id'] = $customer_info['legalperson_id'];
        } else {
            $this->data['legalperson_id'] = '';
        }
        if (isset($this->request->post['province_id'])) {
            $this->data['province_id'] = $this->request->post['province_id'];
        } elseif (isset($customer_info)) {
            $this->data['province_id'] = $customer_info['province_id'];
        } else {
            $this->data['province_id'] = '';
        }
        if (isset($this->request->post['city'])) {
            $this->data['city'] = $this->request->post['city'];
        } elseif (isset($customer_info)) {
            $this->data['city'] = $customer_info['city'];
        } else {
            $this->data['city'] = '';
        }
        if (isset($this->request->post['address'])) {
            $this->data['address'] = $this->request->post['address'];
        } elseif (isset($customer_info)) {
            $this->data['address'] = $customer_info['address'];
        } else {
            $this->data['address'] = '';
        }
        if (isset($this->request->post['lat'])) {
            $this->data['lat'] = $this->request->post['lat'];
        } elseif (isset($customer_info)) {
            $this->data['lat'] = $customer_info['lat'];
        } else {
            $this->data['lat'] = '';
        }
        if (isset($this->request->post['lon'])) {
            $this->data['lon'] = $this->request->post['lon'];
        } elseif (isset($customer_info)) {
            $this->data['lon'] = $customer_info['lon'];
        } else {
            $this->data['lon'] = '';
        }
        if (isset($this->request->post['zoom'])) {
            $this->data['zoom'] = $this->request->post['zoom'];
        } elseif (isset($customer_info)) {
            $this->data['zoom'] = $customer_info['zoom'];
        } else {
            $this->data['zoom'] = '';
        }
        if (isset($this->request->post['tel'])) {
            $this->data['tel'] = $this->request->post['tel'];
        } elseif (isset($customer_info)) {
            $this->data['tel'] = $customer_info['tel'];
        } else {
            $this->data['tel'] = '';
        }
        if (isset($this->request->post['mobile'])) {
            $this->data['mobile'] = $this->request->post['mobile'];
        } elseif (isset($customer_info)) {
            $this->data['mobile'] = $customer_info['mobile'];
        } else {
            $this->data['mobile'] = '';
        }
        if (isset($this->request->post['lat'])) {
            $this->data['lat'] = $this->request->post['lat'];
        } elseif (isset($customer_info)) {
            $this->data['lat'] = $customer_info['lat'];
        } else {
            $this->data['lat'] = '';
        }
       if (isset($this->request->post['lon'])) {
            $this->data['lon'] = $this->request->post['lon'];
        } elseif (isset($customer_info)) {
            $this->data['lon'] = $customer_info['lon'];
        } else {
            $this->data['lon'] = '';
        }
       if (isset($this->request->post['zoom'])) {
            $this->data['zoom'] = $this->request->post['zoom'];
        } elseif (isset($customer_info)) {
            $this->data['zoom'] = $customer_info['zoom'];
        } else {
            $this->data['zoom'] = '';
        }
        if (isset($this->request->post['email'])) {
            $this->data['email'] = $this->request->post['email'];
        } elseif (isset($customer_info)) {
            $this->data['email'] = $customer_info['email'];
        } else {
            $this->data['email'] = '';
        }
        if (isset($this->request->post['website'])) {
            $this->data['website'] = $this->request->post['website'];
        } elseif (isset($customer_info)) {
            $this->data['website'] = $customer_info['website'];
        } else {
            $this->data['website'] = '';
        }
        $this->data['back'] = $this->url->link('account/account', '', 'SSL');
        $this->data['add'] = $this->url->link('provider/subprofile/Add', '', 'SSL');
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/provider/subprofile_add.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/provider/subprofile_add.tpl';
        } else {
            $this->template = 'default/template/provider/subprofile_add.tpl';
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
    public function EditLegalPerson()
    {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('provider/profile', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        $this->language->load('provider/subprofile_editlegalperson');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('provider/pu_subprofile');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->EditLegalPersonvalidate()) {

            $this->session->data['success'] = $this->language->get('text_success');
            $date = new DateTime();
            if (isset($this->request->post['subprofileid'])) {
                if (!empty ($_FILES)) {
                    //upload nationalcard pic
                    if ($_FILES ["agreement"] ["error"] > 0) {
                        echo "Return Code: " . $_FILES ["agreement"] ["error"] . "<br>";
                    } else {

                        $fileName = "agreement_" . $date->getTimestamp();
                        $folderName = $this->customer->getId();
                        $subfolder = $this->request->post['subprofileid'];
                        $folderPlace = $GLOBALS['providers_scans_folder'];
                        $finalFilePath = $folderPlace . "/" . $folderName . "/" . $subfolder . "/" . $fileName;
                        $var = $finalFilePath;
                        if (!is_dir($folderPlace)) {
                            mkdir($folderPlace);
                        }
                        if (!is_dir($folderPlace . "/" . $folderName)) {
                            mkdir($folderPlace . "/" . $folderName);
                        }
                        if (!is_dir($folderPlace . "/" . $folderName . "/" . $subfolder)) {
                            mkdir($folderPlace . "/" . $folderName . "/" . $subfolder);
                        }
                        $path = $_FILES['agreement']['name'];
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        if (file_exists($finalFilePath . "." . $ext)) {
                            // Amir ////////////////if we want to check exist of an image we must do script here
                        } else {
                            // Amir ////////////////if we want to check image on server side we must do this script
                            /*                        $info = getimagesize($_FILES['nationalcardpic']['tmp_name']);
                                                    if ($info === FALSE) {
                                                        die("Unable to determine image type of uploaded file");
                                                    }
                                                    if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
                                                        die("Not a gif/jpeg/png");
                                                    }*/
                            move_uploaded_file($_FILES ["agreement"] ["tmp_name"], $finalFilePath . "." . $ext);
                            $isagreementChanged = true;
                        }
                    }

                    //upload agreement pic
                    if ($_FILES ["newspaper"] ["error"] > 0) {
                        echo "Return Code: " . $_FILES ["newspaper"] ["error"] . "<br>";
                    } else {
                        $fileName = "newspaper_" . $date->getTimestamp();
                        $folderName = $this->customer->getId();
                        $subfolder = $this->request->post['subprofileid'];
                        $folderPlace = $GLOBALS['providers_scans_folder'];
                        $finalFilePath = $folderPlace . "/" . $folderName . "/" . $subfolder . "/" . $fileName;

                        if (!is_dir($folderPlace)) {
                            mkdir($folderPlace);
                        }
                        if (!is_dir($folderPlace . "/" . $folderName)) {
                            mkdir($folderPlace . "/" . $folderName);
                        }
                        if (!is_dir($folderPlace . "/" . $folderName . "/" . $subfolder)) {
                            mkdir($folderPlace . "/" . $folderName . "/" . $subfolder);
                        }
                        $path = $_FILES['newspaper']['name'];
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        if (file_exists($finalFilePath . "." . $ext)) {
                            // Amir ////////////////if we want to check exist of an image we must do script here
                        } else {
                            // Amir ////////////////if we want to check image on server side we must do this script
                            /*                        $info = getimagesize($_FILES['nationalcardpic']['tmp_name']);
                                                    if ($info === FALSE) {
                                                        die("Unable to determine image type of uploaded file");
                                                    }
                                                    if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
                                                        die("Not a gif/jpeg/png");
                                                    }*/
                            move_uploaded_file($_FILES ["newspaper"] ["tmp_name"], $finalFilePath . "." . $ext);
                            $isnewspaperChanged = true;
                        }
                    }
                }
                $subprofileid = $this->request->post['subprofileid'];
                $customer_info = $this->model_provider_pu_subprofile->GetCustomerSubProfile($subprofileid);
                $legalpersonid = $customer_info['legalperson_id'];

                if ($legalpersonid) {

                    $legalpersoninfo = $this->model_provider_pu_subprofile->GetLegalPersonInfo($legalpersonid);
                    $timestamp = $date->format('Y-m-d H:i:s');//get current timestamp
                    if ($isnewspaperChanged)
                        $legalpersoninfo['newspaperstamp'] = $timestamp;
                    if ($isagreementChanged)
                        $legalpersoninfo['agreementstamp'] = $timestamp;

                    $legalpersoninfo['registrationid'] = $this->request->post['registrationid'];
                    $this->model_provider_pu_subprofile->EditLegalPersonInfo($legalpersonid, $legalpersoninfo);
                } else {
                    $timestamp = $date->format('Y-m-d H:i:s');//get current timestamp
                    $legalpersoninfo = array();
                    $legalpersoninfo['agreementstamp'] = $timestamp;
                    $legalpersoninfo['newspaperstamp'] = $timestamp;
                    $legalpersoninfo['registrationid'] = $this->request->post['registrationid'];
                    $legalpersoninfo['adminmessage'] = "";

                    $newId = $this->model_provider_pu_subprofile->AddLegalPersonInfo($legalpersoninfo);
                    $this->model_provider_pu_subprofile->SetSubprofileLegalperson($subprofileid, $newId);
                }
                $sub_info = $this->model_provider_pu_subprofile->GetSubprofileInfo($subprofileid);
                if($sub_info['status_id'] == 0)
                    $this->redirect($this->url->link('provider/subprofile', "", 'SSL'));
            }
            $this->redirect($this->url->link('account/account', '', 'SSL'));
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_account'),
            'href' => $this->url->link('provider/profile', '', 'SSL'),
            'separator' => $this->language->get('text_separator')
        );

        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }


        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['text_profile'] = $this->language->get('text_profile');
        $this->data['text_select'] = $this->language->get('text_select');


        $this->data['entry_registrationid'] = $this->language->get('entry_registrationid');
        $this->data['entry_agreement'] = $this->language->get('entry_agreement');
        $this->data['entry_newspaper'] = $this->language->get('entry_newspaper');


        $this->data['button_add'] = $this->language->get('button_add');
        $this->data['button_continue'] = $this->language->get('button_continue');
        $this->data['button_back'] = $this->language->get('button_back');


        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        if (isset($this->error['registrationid'])) {
            $this->data['error_registrationid'] = $this->error['registrationid'];
        } else {
            $this->data['error_registrationid'] = '';
        }

        $this->data['action'] = $this->url->link('provider/subprofile/EditLegalPerson', '', 'SSL');

        if ($this->request->server['REQUEST_METHOD'] != 'POST') {
            $customer_info = $this->model_provider_pu_subprofile->GetLegalPersonInfo($this->request->get['id']);
        }

        if (isset($this->request->post['registrationid'])) {
            $this->data['registrationid'] = $this->request->post['registrationid'];
        } elseif (isset($customer_info)) {
            $this->data['registrationid'] = $customer_info['registrationid'];
        } else {
            $this->data['registrationid'] = '';
        }

        if (isset($this->request->get['id'])) {
            $this->data['subprofileid'] = $this->request->get['id'];
        } else {
            $this->data['subprofileid'] = '';
        }


        $this->data['back'] = $this->url->link('account/account', '', 'SSL');
        $this->data['add'] = $this->url->link('provider/subprofile/EditLegalPerson', '', 'SSL');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/provider/subprofile_editlegalperson.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/provider/subprofile_editlegalperson.tpl';
        } else {
            $this->template = 'default/template/provider/subprofile_editlegalperson.tpl';
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

?>