<?php

namespace IMS_InflowCRM\Admin;

class ContactFormsView {
	function __construct() {
        // Enqueue script
		$this->IMSInflowContactFormsEnqueue_scripts();
	}

	public function IMSInflowContactFormsEnqueue_scripts() {
		// load only on specified subpage
		if (isset($_GET['page']) && $_GET['page'] == 'ims-inflowcrm' && isset($_GET['tab']) && $_GET['tab'] == 'contact-forms') {
			// CSS
			$css_url = plugin_dir_url(__FILE__) . '../../assets/css/ims-inflowcrm-admin.css';
			wp_enqueue_style('ims-inflow-contact-forms-css', $css_url, array(), '1.0.0', 'all');

			// JS
			$js_url = plugin_dir_url(__FILE__) . '../../assets/js/ims-inflowcrm-form-builder.js';
			wp_register_script('ims-inflow-contact-forms-js-form-builder', $js_url, array('jquery'), '1.0.0', true);
			wp_enqueue_script('ims-inflow-contact-forms-js-form-builder');

			wp_localize_script('ims-inflow-contact-forms-js-form-builder', 'ims_contact_forms_ajax', array(
				'ajax_url' => admin_url('admin-ajax.php'),
				'nonce'   => wp_create_nonce('ims_save_contact_form_nonce')
			));
		}
	}

	public function render_contact_forms_page() {
		?>
        <div class="wrap">
            <div class="ims-container">
                <div class="ims-row">
                    <div class="ims-col">
                        <h1>Contact forms</h1>
                    </div>
                    <div class="ims-col">
                        <a href="<?php echo admin_url('admin.php?page=ims-inflowcrm&tab=contact-forms&action=create-form'); ?>" class="button button-primary">Create new contact form</a>
                    </div>
                </div>
            </div>
        </div>

		<?php
	}

	public function create_contact_form_page() {
		?>
        <div class="wrap">
            <div class="ims-container">
                <div class="ims-row">
                    <div class="ims-col">
                        <div id="ims-alert-area"></div>
                        <h1>Create new contact form</h1>
                        <div class="ims-container">
                            <h2>Toolbar</h2>

                            <!-- Bar for add fields buttons -->
                            <div class="ims-toolbar">
                                <button class="ims-add-field" data-type="text">Add new text field</button>
                                <button class="ims-add-field" data-type="numeric">Add new numeric field</button>
                                <button class="ims-add-field" data-type="telephone">Add new telephone field</button>
                                <button class="ims-add-field" data-type="email">Add new e-mail field</button>
                            </div>

                            <!-- Pleace where fields will appear -->
                            <form id="ims-form-builder">
                                <div id="ims-fields-container"></div>
                            </form>

                            <button id="ims-save-form">Create form</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
		<?php
	}
}

?>
