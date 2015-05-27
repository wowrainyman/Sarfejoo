<?php
require_once "provider.php";
require_once "settings.php";
/*
 * $this->load->model('connection/sms');
        $this->model_connection_sms->sendSms("9366275875",false,'Test');
 */
class ModelConnectionSms extends Model
{
    public function sendSms($to,$is_flash,$text)
    {
        try {
            $pu_database_name = $GLOBALS['pu_database_name'];
            $oc_database_name = $GLOBALS['oc_database_name'];
            $sms_username = $GLOBALS['sms_username'];
            $sms_password = $GLOBALS['sms_password'];
            $sms_number = $GLOBALS['sms_number'];

            $parameters['username'] = $sms_username;
            $parameters['password'] = $sms_password;
            $parameters['to'] = $to;
            $parameters['from'] = $sms_number;
            $parameters['text'] = $text;
            $parameters['isflash'] = $is_flash;

            ini_set("soap.wsdl_cache_enabled", "0");
            $sms_client = new SoapClient('http://87.107.121.54/post/send.asmx?wsdl', array('encoding'=>'UTF-8'));
            $result = $sms_client->SendSimpleSMS2($parameters)->SendSimpleSMS2Result;
            echo $result;
        }catch (SoapFault $ex) {
            echo "ERROR";
        }

    }

}

?>
