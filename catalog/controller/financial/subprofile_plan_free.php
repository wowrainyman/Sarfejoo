<?php
include_once('ipgphp/ipg/enpayment.php');
require_once "settings.php";

/**
 * Created by PhpStorm.
 * User: Amir

 */
class ControllerFinancialSubprofilePlanFree extends Controller
{
    private $error = array();

    public function index()
    {
        $this->load->model('financial/pu_subprofile_plan_free');
        $this->load->model('provider/pu_subprofile');
        $this->load->model('financial/pu_feature_based_plan');
        $canUseFreeAccount = $this->model_financial_pu_subprofile_plan_free->canUserGetFreeAccount($this->customer->getId());
        if($canUseFreeAccount){
            $this->model_financial_pu_subprofile_plan_free->setUserFreeAccount($this->customer->getId());
            $subprofile_id = $this->request->get['id'];
            $this->load->model('financial/pu_feature_based_plan');
            $plan = $this->request->get['plan_id'];
            $period = 14;
            $currentDate = new DateTime();
            $currentDate = $currentDate->getTimestamp();
            $expire_date = date('Y-m-d H:i:s', strtotime('+' . '14' . ' days' . date('Y-m-d H:i:s', $currentDate)));
            $this->model_provider_pu_subprofile->setSubprofileExpireDate($subprofile_id, $expire_date, $plan, $period);
            $subprofile_info = $this->model_provider_pu_subprofile->GetSubprofileInfo($subprofile_id);
            $features = $this->model_financial_pu_feature_based_plan->getFeatures();
            print_r($features);
            foreach ($features as $feature) {
                $value = $this->model_financial_pu_feature_based_plan->getPlanFeatureValue($plan, $feature['id']);
                $this->model_financial_pu_feature_based_plan->addSubprofileFeatureValue($subprofile_id, $feature['id'], $value['value']);
            }
            if ($subprofile_info['address'] == '') {
                $callbackUrl = $this->url->link('provider/subprofile/Add', '', 'SSL');
                $callbackUrl .= '&id=' . $subprofile_id;
                $go = $callbackUrl;
                header("Location: $go");
                die();
            }
            $callbackUrl = $this->url->link('provider/subprofile', '', 'SSL');
            $go = $callbackUrl;
            header("Location: $go");
            die();
        }else{
            $this->session->data['success'] = 'شما مجاز به استفاده از اکانت مجانی نمی باشید.';
            $callbackUrl = $this->url->link('provider/subprofile', '', 'SSL');
            $go = $callbackUrl;
            header("Location: $go");
            die();
        }
    }


    public function receive()
    {

    }

    protected function validate()
    {
        return true;
    }
}

?>