<?php
/**
 *
 * @ IonCube v8.3 Loader By DoraemonPT
 * @ PHP 5.3
 * @ Decoder version : 1.0.0.7
 * @ Author     : DoraemonPT
 * @ Release on : 09.05.2014
 * @ Website    : http://EasyToYou.eu
 *
 **/

class ModelPaymentCcavenuepay extends Model {
	function getMethod($address, $total) {
		$this->load->language( 'payment/ccavenuepay' );
		$query = $this->db->query( 'SELECT * FROM ' . DB_PREFIX . 'zone_to_geo_zone WHERE geo_zone_id = \'' . (int)$this->config->get( 'ccavenuepay_geo_zone_id' ) . '\' AND country_id = \'' . (int)$address['country_id'] . '\' AND (zone_id = \'' . (int)$address['zone_id'] . '\' OR zone_id = \'0\')' );

		if ($total < $this->config->get( 'ccavenuepay_total' )) {
			$status = false;
		}
		else {
			if (!$this->config->get( 'ccavenuepay_geo_zone_id' )) {
				$status = true;
			}
			else {
				if ($query->num_rows) {
					$status = true;
				}
				else {
					$status = false;
				}
			}
		}

		$status = TRUE;
		$method_data = array(  );

		if ($status) {
			$method_data = array( 'code' => 'ccavenuepay', 'title' => $this->language->get( 'text_title' ), 'sort_order' => $this->config->get( 'ccavenuepay_sort_order' ) );
		}

		return $method_data;
	}
}

?>
