<?php
class ControllerProviderProfile extends Controller {
    protected function isCustomerPayed($id){
        $this->load->model('account/customer');
        $expire_date = $this->model_account_customer->getCustomerExpireDate($id);
        if(!$expire_date)
            return false;
        $expire_date = strtotime($expire_date);
        $current_date = new DateTime();
        if($expire_date>date_timestamp_get($current_date))
        {
            return true;
        }else{
            return false;
        }
    }
    private $error = array();
    public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('provider/profile', '', 'SSL');
			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}
        if (!$this->isCustomerPayed($this->customer->getId()))
        {
            $this->redirect($this->url->link('account/account', '', 'SSL'));
        }
		$this->language->load('provider/profile');

		$this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('provider/pu_customer');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

            $date = new DateTime();
            //upload agreement and nationalcard scans to server
            if (! empty ( $_FILES )) {
                //upload nationalcard pic
                if ($_FILES ["nationalcard"] ["error"] > 0) {
                    echo "Return Code: " . $_FILES ["nationalcard"] ["error"] . "<br>";
                } else {

                    $fileName="ncard_" . $date->getTimestamp();
                    $folderName=$this->customer->getId();
                    $folderPlace=$_SERVER['DOCUMENT_ROOT'] . "/sarfejoo" . "/ProvidersScans";
                    $finalFilePath= $folderPlace . "/" . $folderName . "/" . $fileName;

                    if ( ! is_dir($folderPlace)) {
                        mkdir($folderPlace);
                    }
                    if ( ! is_dir($folderPlace . "/" . $folderName)) {
                        mkdir($folderPlace . "/" . $folderName);
                    }
                    $path = $_FILES['nationalcard']['name'];
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
                        move_uploaded_file($_FILES ["nationalcard"] ["tmp_name"],$finalFilePath . "." . $ext);
                    }
                }

                //upload agreement pic
                if ($_FILES ["agreement"] ["error"] > 0) {
                    echo "Return Code: " . $_FILES ["agreement"] ["error"] . "<br>";
                } else {
                    $fileName="agreement_" . $date->getTimestamp();
                    $folderName=$this->customer->getId();
                    $folderPlace=$_SERVER['DOCUMENT_ROOT'] . "/sarfejoo" . "/ProvidersScans";
                    $finalFilePath= $folderPlace . "/" . $folderName . "/" . $fileName;

                    if ( ! is_dir($folderPlace)) {
                        mkdir($folderPlace);
                    }
                    if ( ! is_dir($folderPlace . "/" . $folderName)) {
                        mkdir($folderPlace . "/" . $folderName);
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
                        move_uploaded_file($_FILES ["agreement"] ["tmp_name"],$finalFilePath . "." . $ext);
                    }
                }
            }

            //edit customer details on oc database
            $this->load->model('account/customer');
            $customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
            $customer_info["firstname"]=$this->request->post["firstname"];
            $customer_info["lastname"]=$this->request->post["lastname"];
            $this->model_account_customer->editCustomer($customer_info);

             $birthday =  $this->request->post['birthday'];
            //edit customer details on pu database
            $id = $this->customer->getId();//get customer_id
            $timestamp=$date->format('Y-m-d H:i:s');//get current timestamp
            $this->model_provider_pu_customer->EditCustomer($this->request->post);
            $this->model_provider_pu_customer->EditCustomer_nationalcardstamp($timestamp,$id);
            $this->model_provider_pu_customer->EditCustomer_approvementstamp($timestamp,$id);
            $this->model_provider_pu_customer->EditCustomer_agreementstamp($timestamp,$id);
            $this->model_provider_pu_customer->EditCustomer_birthday($birthday,$id);
            $this->model_provider_pu_customer->EditCustomer_status_id(0,$id);
            $this->model_provider_pu_customer->EditCustomer_user_id(0,$id);
            $this->model_provider_pu_customer->EditCustomer_adminmessage("در صف انتظار",$id);

            $this->session->data['success'] = $this->language->get('text_success');
            $this->redirect($this->url->link('account/account', '', 'SSL'));
        }

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('provider/profile', '', 'SSL'),
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
        $this->data['entry_firstname'] = $this->language->get('entry_firstname');
        $this->data['entry_lastname'] = $this->language->get('entry_lastname');
        $this->data['entry_nationalcode'] = $this->language->get('entry_nationalcode');
        $this->data['entry_birthplace'] = $this->language->get('entry_birthplace');
        $this->data['entry_birthday'] = $this->language->get('entry_birthday');
        $this->data['entry_fathername'] = $this->language->get('entry_fathername');
        $this->data['entry_nationalcard'] = $this->language->get('entry_nationalcard');
        $this->data['entry_agreement'] = $this->language->get('entry_agreement');
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

        if (isset($this->error['lastname'])) {
            $this->data['error_lastname'] = $this->error['lastname'];
        } else {
            $this->data['error_lastname'] = '';
        }

        if (isset($this->error['nationalcode'])) {
            $this->data['error_nationalcode'] = $this->error['nationalcode'];
        } else {
            $this->data['error_nationalcode'] = '';
        }

        if (isset($this->error['birthplace'])) {
            $this->data['error_birthplace'] = $this->error['birthplace'];
        } else {
            $this->data['error_birthplace'] = '';
        }

        if (isset($this->error['birthday'])) {
            $this->data['error_birthday'] = $this->error['birthday'];
        } else {
            $this->data['error_birthday'] = '';
        }

        if (isset($this->error['fathername'])) {
            $this->data['error_fathername'] = $this->error['fathername'];
        } else {
            $this->data['error_fathername'] = '';
        }

        if (isset($this->error['agreement'])) {
            $this->data['error_agreement'] = $this->error['agreement'];
        } else {
            $this->data['error_agreement'] = '';
        }

        if (isset($this->error['nationalcard'])) {
            $this->data['error_nationalcard'] = $this->error['nationalcard'];
        } else {
            $this->data['error_nationalcard'] = '';
        }


        $this->data['action'] = $this->url->link('provider/profile', '', 'SSL');


        if ($this->request->server['REQUEST_METHOD'] != 'POST') {
            $customer_info = $this->model_provider_pu_customer->GetCustomer($this->customer->getId());//from pu

            $this->load->model('account/customer');
            $base_customer_info=$this->model_account_customer->getCustomer($this->customer->getId());//from oc
        }
        
        # Some User Data 
        
       $this->data['f_id'] = $this->customer->getId();
       $this->data['f_firstname'] = $base_customer_info['firstname'];
       $this->data['f_lastname'] = $base_customer_info['lastname'];
       $this->data['f_email'] = $base_customer_info['email'];


        if (isset($this->request->post['firstname'])) {
            $this->data['firstname'] = $this->request->post['firstname'];
        } elseif (isset($customer_info)) {
            $this->data['firstname'] = $base_customer_info['firstname'];
        } else {
            $this->data['firstname'] = '';
        }

     
        if (isset($this->request->post['lastname'])) {
            $this->data['lastname'] = $this->request->post['lastname'];
        } elseif (isset($customer_info)) {
            $this->data['lastname'] = $base_customer_info['lastname'];
        } else {
            $this->data['lastname'] = '';
        }

        if (isset($this->request->post['nationalcode'])) {
            $this->data['nationalcode'] = $this->request->post['nationalcode'];
        } elseif (isset($customer_info)) {
            $this->data['nationalcode'] = $customer_info['nationalcode'];
        } else {
            $this->data['nationalcode'] = '';
        }

        if (isset($this->request->post['birthplace'])) {
            $this->data['birthplace'] = $this->request->post['birthplace'];
        } elseif (isset($customer_info)) {
            $this->data['birthplace'] = $customer_info['birthplace'];
        } else {
            $this->data['birthplace'] = '';
        }

        if (isset($this->request->post['birthday'])) {
            $this->data['birthday'] = $this->request->post['birthday'];
        } else {
            $this->data['birthday'] = $customer_info['birthday'];
        }

        if (isset($this->request->post['fathername'])) {
            $this->data['fathername'] = $this->request->post['fathername'];
        } elseif (isset($customer_info)) {
            $this->data['fathername'] = $customer_info['fathername'];
        } else {
            $this->data['fathername'] = '';
        }



        $this->data['back'] = $this->url->link('account/account', '', 'SSL');


		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/provider/profile.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/provider/profile.tpl';
		} else {
			$this->template = 'default/template/provider/profile.tpl';
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


    protected function validate() {
        if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
            $this->error['firstname'] = $this->language->get('error_firstname');
        }

        if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 32)) {
            $this->error['lastname'] = $this->language->get('error_lastname');
        }

        //national code checking
        if (!preg_match("/^\d{10}$/", $this->request->post['nationalcode'])) {
            $this->error['nationalcode'] = $this->language->get('error_nationalcode');
        }
        else
        {
            $input=$this->request->post['nationalcode'];
            $check = (int) $input[9];
            $sum = array_sum(array_map(function ($x) use ($input) {
                    return ((int) $input[$x]) * (10 - $x);
                }, range(0, 8))) % 11;
            if(!($sum < 2 && $check == $sum || $sum >= 2 && $check + $sum == 11))
            {
                $this->error['nationalcode'] = $this->language->get('error_nationalcode');
            }
        }



        if ((utf8_strlen($this->request->post['birthplace']) < 1) || (utf8_strlen($this->request->post['birthplace']) > 32)) {
            $this->error['birthplace'] = $this->language->get('error_birthplace');
        }

        if ((utf8_strlen($this->request->post['fathername']) < 1) || (utf8_strlen($this->request->post['fathername']) > 32)) {
            $this->error['fathername'] = $this->language->get('error_fathername');
        }

        if (empty ( $_FILES )) {
            $this->error['nationalcard'] = $this->language->get('error_nationalcard');
            $this->error['agreement'] = $this->language->get('error_agreement');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }


}
?>