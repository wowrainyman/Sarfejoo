<?php
class Modelgiftbox extends Model {
	public function getTotal(&$total_data, &$total, &$taxes) {
		if (($this->cart->getSubTotal() < $this->config->get('handling_total')) && ($this->cart->getSubTotal() > 0)) {
			$this->language->load('total/giftbox');

			$total_data[] = array( 
				'code'       => 'giftbox',
				'title'      => $this->language->get('text_giftbox'),
				'text'       => $this->currency->format($this->config->get('giftbox_fee')),
				'value'      => $this->config->get('giftbox_fee'),
				'sort_order' => $this->config->get('giftbox_sort_order')
			);

			if ($this->config->get('giftbox_tax_class_id')) {
				$tax_rates = $this->tax->getRates($this->config->get('giftbox_fee'), $this->config->get('giftbox_tax_class_id'));

				foreach ($tax_rates as $tax_rate) {
					if (!isset($taxes[$tax_rate['tax_rate_id']])) {
						$taxes[$tax_rate['tax_rate_id']] = $tax_rate['amount'];
					} else {
						$taxes[$tax_rate['tax_rate_id']] += $tax_rate['amount'];
					}
				}
			}

			$total += $this->config->get('giftbox_fee');
		}
	}
}
?>