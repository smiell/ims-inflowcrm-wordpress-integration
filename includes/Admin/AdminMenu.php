<?php
namespace IMS_InflowCRM\Admin;

use IMS_InflowCRM\Admin\SitesManager;

class AdminMenu {
    private $capability;

    public function __construct() {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        $this->capability = 'manage_options';
    }

    public function add_admin_menu() {
        add_menu_page(
            'IMS InflowCRM',
            'IMS InflowCRM',
            $this->capability,
            'ims-inflowcrm',
            [$this, 'ims_inflow_router'],
            'dashicons-admin-generic'
        );
    }

    public function ims_inflow_router() {
        if (!is_admin()) {
            return;
        }
        $sites_manager = new SitesManager(); // New instance of Sites Manager page class

        // Check is 'tab' parameter passed
        if (isset($_GET['tab'])) {
            $tab = sanitize_text_field($_GET['tab']); // xss

            switch ($tab) {
                case 'inflow-connection':
                    $sites_manager->admin_inflowcrm_connection_view();
                    break;
                case 'help':
                    $sites_manager->admin_help_view();
                    break;
                default:
                    $sites_manager->admin_home_view();
                    break;
            }
        } else {
            // by default show home page
            $sites_manager->admin_home_view();
        }
    }

}
