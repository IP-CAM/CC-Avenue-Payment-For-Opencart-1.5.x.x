<?php

class ControllerPaymentCcavenuepay extends Controller {
	protected $error = array(  );

	function index() {
		$this->load->language( 'payment/ccavenuepay' );
		$this->document->setTitle( $this->language->get( 'heading_title' ) );
		$this->load->model( 'setting/setting' );

		if (( $this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate(  ) )) {
			$this->getUpdateBzCustomerModule(  );
			$this->model_setting_setting->editSetting( 'ccavenuepay', $this->request->post );
			$this->session->data['success'] = $this->language->get( 'text_success' );
			$this->redirect( $this->url->link( 'extension/payment', 'token=' . $this->session->data['token'], 'SSL' ) );
		}

		$this->data['heading_title'] = $this->language->get( 'heading_title' );
		$this->data['text_enabled'] = $this->language->get( 'text_enabled' );
		$this->data['text_disabled'] = $this->language->get( 'text_disabled' );
		$this->data['text_all_zones'] = $this->language->get( 'text_all_zones' );
		$this->data['text_yes'] = $this->language->get( 'text_yes' );
		$this->data['text_no'] = $this->language->get( 'text_no' );
		$this->data['entry_failed_status'] = $this->language->get( 'entry_failed_status' );
		$this->data['entry_pending_status'] = $this->language->get( 'entry_pending_status' );
		$this->data['entry_completed_status'] = $this->language->get( 'entry_completed_status' );
		$this->data['button_save'] = $this->language->get( 'button_save' );
		$this->data['button_cancel'] = $this->language->get( 'button_cancel' );
		$this->data['entry_status'] = $this->language->get( 'entry_status' );
		$this->data['entry_merchant_id'] = $this->language->get( 'entry_merchant_id' );
		$this->data['entry_access_code'] = $this->language->get( 'entry_access_code' );
		$this->data['entry_encryption_key'] = $this->language->get( 'entry_encryption_key' );
		$this->data['entry_payment_confirmation_mail'] = $this->language->get( 'entry_payment_confirmation_mail' );
		$this->data['entry_geo_zone'] = $this->language->get( 'entry_geo_zone' );
		$this->data['entry_sort_order'] = $this->language->get( 'entry_sort_order' );
		$this->data['entry_total'] = $this->language->get( 'entry_total' );

		if (isset( $this->error['warning'] )) {
			$this->data['error_warning'] = $this->error['warning'];
		}
		else {
			$this->data['error_warning'] = '';
		}


		if (isset( $this->error['merchant_id'] )) {
			$this->data['error_merchant_id'] = $this->error['merchant_id'];
		}
		else {
			$this->data['error_merchant_id'] = '';
		}


		if (isset( $this->error['access_code'] )) {
			$this->data['error_access_code'] = $this->error['access_code'];
		}
		else {
			$this->data['error_access_code'] = '';
		}


		if (isset( $this->error['encryption_key'] )) {
			$this->data['error_encryption_key'] = $this->error['encryption_key'];
		}
		else {
			$this->data['error_encryption_key'] = '';
		}

		$this->data['breadcrumbs'] = array(  );
		$this->data['breadcrumbs'][] = array( 'text' => $this->language->get( 'text_home' ), 'href' => $this->url->link( 'common/home', 'token=' . $this->session->data['token'], 'SSL' ), 'separator' => false );
		$this->data['breadcrumbs'][] = array( 'text' => $this->language->get( 'text_payment' ), 'href' => $this->url->link( 'extension/payment', 'token=' . $this->session->data['token'], 'SSL' ), 'separator' => ' :: ' );
		$this->data['breadcrumbs'][] = array( 'text' => $this->language->get( 'heading_title' ), 'href' => $this->url->link( 'payment/ccavenuepay', 'token=' . $this->session->data['token'], 'SSL' ), 'separator' => ' :: ' );
		$this->data['action'] = $this->url->link( 'payment/ccavenuepay', 'token=' . $this->session->data['token'], 'SSL' );
		$this->data['cancel'] = $this->url->link( 'extension/payment', 'token=' . $this->session->data['token'], 'SSL' );

		if (isset( $this->request->post['ccavenuepay_status'] )) {
			$this->data['ccavenuepay_status'] = $this->request->post['ccavenuepay_status'];
		}
		else {
			$this->data['ccavenuepay_status'] = $this->config->get( 'ccavenuepay_status' );
		}


		if (isset( $this->request->post['ccavenuepay_merchant_id'] )) {
			$this->data['ccavenuepay_merchant_id'] = $this->request->post['ccavenuepay_merchant_id'];
		}
		else {
			$this->data['ccavenuepay_merchant_id'] = $this->config->get( 'ccavenuepay_merchant_id' );
		}


		if (isset( $this->request->post['ccavenuepay_access_code'] )) {
			$this->data['ccavenuepay_access_code'] = $this->request->post['ccavenuepay_access_code'];
		}
		else {
			$this->data['ccavenuepay_access_code'] = $this->config->get( 'ccavenuepay_access_code' );
		}


		if (isset( $this->request->post['ccavenuepay_encryption_key'] )) {
			$this->data['ccavenuepay_encryption_key'] = $this->request->post['ccavenuepay_encryption_key'];
		}
		else {
			$this->data['ccavenuepay_encryption_key'] = $this->config->get( 'ccavenuepay_encryption_key' );
		}


		if (isset( $this->request->post['ccavenuepay_payment_confirmation_mail'] )) {
			$this->data['ccavenuepay_payment_confirmation_mail'] = $this->request->post['ccavenuepay_payment_confirmation_mail'];
		}
		else {
			$this->data['ccavenuepay_payment_confirmation_mail'] = $this->config->get( 'ccavenuepay_payment_confirmation_mail' );
		}


		if (isset( $this->request->post['ccavenuepay_total'] )) {
			$this->data['ccavenuepay_total'] = $this->request->post['ccavenuepay_total'];
		}
		else {
			$this->data['ccavenuepay_total'] = $this->config->get( 'ccavenuepay_total' );
		}


		if (isset( $this->request->post['ccavenuepay_completed_status_id'] )) {
			$this->data['ccavenuepay_completed_status_id'] = $this->request->post['ccavenuepay_completed_status_id'];
		}
		else {
			$this->data['ccavenuepay_completed_status_id'] = $this->config->get( 'ccavenuepay_completed_status_id' );
		}


		if (isset( $this->request->post['pp_standard_failed_status_id'] )) {
			$this->data['ccavenuepay_failed_status_id'] = $this->request->post['ccavenuepay_failed_status_id'];
		}
		else {
			$this->data['ccavenuepay_failed_status_id'] = $this->config->get( 'ccavenuepay_failed_status_id' );
		}


		if (isset( $this->request->post['pp_standard_pending_status_id'] )) {
			$this->data['ccavenuepay_pending_status_id'] = $this->request->post['ccavenuepay_pending_status_id'];
		}
		else {
			$this->data['ccavenuepay_pending_status_id'] = $this->config->get( 'ccavenuepay_pending_status_id' );
		}

		$this->load->model( 'localisation/order_status' );
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses(  );

		if (isset( $this->request->post['ccavenuepay_geo_zone_id'] )) {
			$this->data['ccavenuepay_geo_zone_id'] = $this->request->post['ccavenuepay_geo_zone_id'];
		}
		else {
			$this->data['ccavenuepay_geo_zone_id'] = $this->config->get( 'ccavenuepay_geo_zone_id' );
		}

		$this->load->model( 'localisation/geo_zone' );
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones(  );

		if (isset( $this->request->post['ccavenuepay_sort_order'] )) {
			$this->data['ccavenuepay_sort_order'] = $this->request->post['ccavenuepay_sort_order'];
		}
		else {
			$this->data['ccavenuepay_sort_order'] = $this->config->get( 'ccavenuepay_sort_order' );
		}

		$this->template = 'payment/ccavenuepay.tpl';
		$this->children = array( 'common/header', 'common/footer' );
		$this->response->setOutput( $this->render(  ) );
	}

	function validate() {
		if (!$this->user->hasPermission( 'modify', 'payment/ccavenuepay' )) {
			$this->error['warning'] = $this->language->get( 'error_permission' );
		}


		if (!$this->request->post['ccavenuepay_merchant_id']) {
			$this->error['merchant_id'] = $this->language->get( 'error_merchant_id' );
		}


		if (!$this->request->post['ccavenuepay_encryption_key']) {
			$this->error['encryption_key'] = $this->language->get( 'error_encryption_key' );
		}


		if (!$this->request->post['ccavenuepay_access_code']) {
			$this->error['access_code'] = $this->language->get( 'error_access_code' );
		}


		if (!$this->error) {
			return true;
		}

		return false;
	}

}

?>
