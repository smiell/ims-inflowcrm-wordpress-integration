<?php

namespace IMS_InflowCRM\Admin;

use IMS_InflowCRM\Db\ImsInflowDbHandler;

class ContactForm {
	private $db_handler;
	public function __construct() {
		// initialize db hanlder
		$this->db_handler = new ImsInflowDbHandler();
	}
	public static function handle_save_contact_form() {
		// check fo nonce
		if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'ims_save_contact_form_nonce')) {
			wp_send_json_error(
				['message' => 'Unauthorized request.']
			);
			wp_die();
		}

		// check is form data passed
		if (!isset($_POST['formData'])) {
			wp_send_json_error(
				['message' => 'No data passed.']
			);
			return;
		}

		// json decode
		$decoded_json = json_decode(stripslashes($_POST['formData']), true);
		if (json_last_error() !== JSON_ERROR_NONE) {
			wp_send_json_error(
				['message' => 'JSON decode error: ' . json_last_error_msg()]
			);
		}

		// create a field in db
		$contact_form = new self();
		$result = $contact_form->create_contact_form($decoded_json);

		if ($result['success']) {
			wp_send_json_success(
				['message' => 'A new form was successfully saved!!', 'form_id' => $result['form_id']]
			);
		} else {
			wp_send_json_error(['message' => 'Saving error: ' . $result['message']]);
		}

		wp_die(); // wp die after all
	}

	public function create_contact_form($data) {
		// store a new form in db
		return ['success' => true, 'form_id' => 123]; // Symulacja sukcesu
	}

}