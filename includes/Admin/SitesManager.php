<?php
namespace IMS_InflowCRM\Admin;

use IMS_InflowCRM\Templates\AdminHorizontalNavigationMenu;
class SitesManager
{
    private $horizontal_navigation_menu;
    public function __construct()
    {
        $this->horizontal_navigation_menu = new AdminHorizontalNavigationMenu();
    }

    // settings home view
    public function admin_home_view() {
        // horizontal menu
        echo $this->horizontal_navigation_menu->NavigationMenu();

        require plugin_dir_path(__FILE__) . '../../templates/admin/admin-home-view.php';
    }
    // settings help view
    public function admin_help_view() {
        // horizontal menu
        echo $this->horizontal_navigation_menu->NavigationMenu();

        require plugin_dir_path(__FILE__) . '../../templates/admin/admin-help-view.php';
    }
    // inflowcrm connection page
    public function admin_inflowcrm_connection_view() {
        // horizontal menu
        echo $this->horizontal_navigation_menu->NavigationMenu();

        require plugin_dir_path(__FILE__) . '../../templates/admin/admin-inflow-connection-view.php';
    }
}