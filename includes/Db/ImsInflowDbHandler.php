<?php

namespace IMS_InflowCRM\Db;

if(!defined('ABSPATH')) {
	exit;
}

class ImsInflowDbHandler {

	/**
	 * @var string Name of contact forms table
	 */
	private $contact_forms_table_name = 'inflowcrm_contact_forms';
	/**
	 * @var string Prefix of InflowCRM table names
	 */
	private $ims_inflowcrm_table_prefix = 'ims_';
	private $currentDateTime;
	public function __construct() {
		$this->currentDateTime = date("Y-m-d H:i:s");
	}

	public function IMSInflowPrepareDb() {
		// Run all quiries
		$this->CreateContactFormsTable();
	}

	public function IMSInflowUninstall() {
		// Run all queries
		$this->RemoveContactFormsTabel();
	}

	public function CreateContactFormsTable() {
		global $wpdb;
		$table_name = $this->ims_inflowcrm_table_prefix . $this->contact_forms_table_name;
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
        id INT AUTO_INCREMENT PRIMARY KEY,
        form_id CHAR(36) NOT NULL UNIQUE, 
        form_name VARCHAR(255) NOT NULL,
        description TEXT DEFAULT NULL,
        form_fields LONGTEXT NOT NULL,
        form_html LONGTEXT DEFAULT NULL,
        status ENUM('active', 'inactive') DEFAULT 'active',
        created_by BIGINT UNSIGNED NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (created_by) REFERENCES {$wpdb->prefix}users(ID) ON DELETE CASCADE
    ) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta($sql);
	}

	public function RemoveContactFormsTabel() {
		global $wpdb;
		$table_name = $this->ims_inflowcrm_table_prefix . $this->contact_forms_table_name;
		$wpdb->query("DROP TABLE IF EXISTS $table_name");
	}

	// Save new contact form
	public function saveContactForm($form_name, $form_fields, $created_by, $description = '', $form_html = '', $status = 'active') {
		global $wpdb;
		$table_name = $this->ims_inflowcrm_table_prefix . $this->contact_forms_table_name;

		// Walidacja
		if (empty($form_name) || empty($form_fields) || empty($created_by)) {
			return ['success' => false, 'message' => 'Missing rqeuired fields.'];
		}

		// Unikalne ID formularza
		$form_id = wp_generate_uuid4();

		// Przygotowanie danych
		$data = [
			'form_id' => $form_id,
			'form_name' => sanitize_text_field($form_name),
			'description' => sanitize_textarea_field($description),
			'form_fields' => maybe_serialize($form_fields),
			'form_html' => maybe_serialize($form_html),
			'status' => in_array($status, ['active', 'inactive']) ? $status : 'active',
			'created_by' => intval($created_by),
			'created_at' => current_time('mysql'),
			'updated_at' => current_time('mysql'),
		];

		// Zapis do bazy
		$inserted = $wpdb->insert($table_name, $data);

		if ($inserted) {
			return ['success' => true, 'message' => 'Formularz zapisany.', 'form_id' => $form_id];
		} else {
			return ['success' => false, 'message' => 'Błąd zapisu formularza: ' . $wpdb->last_error];
		}
	}


}