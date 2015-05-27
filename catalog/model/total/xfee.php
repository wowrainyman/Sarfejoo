<?php
class ModelTotalXfee extends Model {
	public function getTotal(&$total_data, &$total, &$taxes) {
	
	    $this->language->load('total/xfee');
		
		$shipping_method=isset($_SESSION['shipping_method']['code'])?$_SESSION['shipping_method']['code']:'';
		$payment_method=isset($_SESSION['payment_method']['code'])?$_SESSION['payment_method']['code']:'';
                
       
        if(!isset($this->session->data['shipping_country_id']))$country_id=0;
		else $country_id=$this->session->data['shipping_country_id'];
		
		if(!isset($this->session->data['shipping_zone_id']))$zone_id=0;
		else $zone_id=$this->session->data['shipping_zone_id'];
		
		/* For admin only*/
		if(isset($_POST['shipping_code']) && $_POST['shipping_code'])$shipping_method=$_POST['shipping_code'];
		if(isset($_POST['payment_code']) && $_POST['payment_code'])$payment_method=$_POST['payment_code'];
		
		
		
		if ($this->cart->getSubTotal()) {
			
		 	
		  for($i=1;$i<=10;$i++)
			   {	
			           $xfee_total=(float)$this->config->get('xfee_total'.$i);
				       if(empty($xfee_total))$xfee_total=0;
					   
					   if(!$this->config->get('xfee_name'.$i)) continue;
					   if($xfee_total>$this->cart->getSubTotal()) continue;
					   
					   
					   
					   if($this->config->get('xfee_payment'.$i) && $this->config->get('xfee_payment'.$i)!=$payment_method) continue;
					   if($this->config->get('xfee_shipping'.$i) && $this->config->get('xfee_shipping'.$i).'.'.$this->config->get('xfee_shipping'.$i)!=$shipping_method && $this->config->get('xfee_shipping'.$i)!=$shipping_method) continue;
						
                                           if($this->config->get('xfee_geo_zone_id'.$i)){
					      
                                               $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id='".(int)$this->config->get('xfee_geo_zone_id'.$i)."' AND country_id = '" . (int)$country_id . "' AND (zone_id = '" . (int)$zone_id . "' OR zone_id = '0')"); 
                                               if ($query->num_rows==0) continue;
                                               
                                            }
			                
				          
								
				           
                                                       
						$tax_vat=0;
						if ($this->config->get('xfee_tax_class_id'.$i)) {
							$tax_rates = $this->tax->getRates($this->config->get('xfee_cost'.$i), $this->config->get('xfee_tax_class_id'.$i));
							
							foreach ($tax_rates as $tax_rate) {
								if (!isset($taxes[$tax_rate['tax_rate_id']])) {
									$taxes[$tax_rate['tax_rate_id']] = $tax_rate['amount'];
									$tax_vat+=$tax_rate['amount'];
								} else {
									$taxes[$tax_rate['tax_rate_id']] += $tax_rate['amount'];
									$tax_vat+=$tax_rate['amount'];
								}
							}
						}
						
						$total_data[] = array( 
							'code'       => 'xfee'.$i,
							'title'      => $this->config->get('xfee_name'.$i),
							'text'       => $this->currency->format(($this->config->get('xfee_cost'.$i)+$tax_vat)),
							'value'      => $this->config->get('xfee_cost'.$i)+$tax_vat,
							'sort_order' => $this->config->get('xfee_sort_order'.$i)
						);
						
						$total += $this->config->get('xfee_cost'.$i);
		  
		      }
		
		}
	}
}
?>