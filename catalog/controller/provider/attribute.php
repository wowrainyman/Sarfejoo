<?php 
class ControllerProviderAttribute extends Controller {
	private $error = array();

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('provider/pu_attribute');

			$data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);

			$json = array();

			$results = $this->model_provider_pu_attribute->getAttributes($data);

			foreach ($results as $result) {
				$json[] = array(
					'attribute_id'    => $result['attribute_id'], 
					'name'            => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'attribute_group' => $result['attribute_group']
				);		
			}		
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->setOutput(json_encode($json));
	}		  
}
?>