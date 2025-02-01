<?php

namespace IMS_InflowCRM\Admin;

/**
 * Class Settings
 *
 * Configure the plugin settings page.
 */
class Settings {
    /**
     * Capability required by the user to access the My Plugin menu entry.
     *
     * @var string $capability
     */
    private $capability = 'manage_options';

    /**
     * Array of fields that should be displayed in the settings page.
     *
     * @var array $fields
     */
    private $fields = [
        [
            'id' => 'inflow_crm_api_key',
            'label' => 'API Key',
            'description' => 'API Key of InflowCRM instance',
            'type' => 'text',
        ],
        [
            'id' => 'inflow_crm_instance_url',
            'label' => 'URL',
            'description' => 'Public accesable URL of InflowCRM instance',
            'type' => 'text',
        ],
    ];

    /**
     * The Plugin Settings constructor.
     */
    public function __construct() {
        add_action('admin_menu', [$this, 'add_plugin_menu'], 99);
        add_action('admin_init', [$this, 'register_settings']);
    }

    /**
     * Add the plugin settings page to the admin menu.
     */
    public function add_plugin_menu() {
        add_menu_page(
            'Inflow CRM Settings',
            'Inflow CRM',
            $this->capability,
            'inflowcrm-settings',
            [$this, 'settings_page'],
            'dashicons-admin-generic'
        );
    }

    /**
     * Register the plugin settings.
     */
    public function register_settings() {
        register_setting(
            'ims_inflowcrm_options_group',
            'ims_inflowcrm_options',
            [$this, 'sanitize_options']
        );

        // Rejestracja sekcji
        add_settings_section(
            'ims_inflowcrm_section',
            '',
            function() {
                echo '<p>Settings of InflowCRM integration.</p>';
            },
            'inflowcrm-settings'
        );

        // Register settings fields
        foreach ($this->fields as $field) {
            add_settings_field(
                $field['id'],
                $field['label'],
                [$this, 'render_field'],
                'inflowcrm-settings',
                'ims_inflowcrm_section',
                $field
            );
        }
    }

    /**
     * Sanitize options before saving.
     *
     * @param array $options
     * @return array
     */
    public function sanitize_options($input) {
        // Sanitize before saving
        // TO DO: Add sanitize for all fields and check before saving is that valid
        $output = [];
        foreach ($this->fields as $field) {
            if (isset($input[$field['id']])) {
                $output[$field['id']] = sanitize_text_field($input[$field['id']]);
            }
        }
        return $output;
    }

    /**
     * Render a single field.
     *
     * @param array $field
     */
    public function render_field($field) {
        $options = get_option('ims_inflowcrm_options');
        $value = isset($options[$field['id']]) ? esc_attr($options[$field['id']]) : '';

        // Render field based on type
        switch ($field['type']) {
            case 'text':
                echo '<input type="text" name="ims_inflowcrm_options[' . $field['id'] . ']" value="' . $value . '" />';
                break;
            //TO DO: Add more fields type like checkboxes, selects, numeric
        }

        if (!empty($field['description'])) {
            echo '<p class="description">' . $field['description'] . '</p>';
        }
    }

    /**
     * Display the settings page.
     */
    public function settings_page() {
        ?>
        <div class="wrap">
            <h1>Inflow CRM Settings</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('ims_inflowcrm_options_group');
                do_settings_sections('inflowcrm-settings');
                submit_button();
                ?>
            </form>

        </div>
        <?php
    }

}

