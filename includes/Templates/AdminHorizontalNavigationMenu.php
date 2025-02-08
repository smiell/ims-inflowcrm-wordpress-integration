<?php

namespace IMS_InflowCRM\Templates;

class AdminHorizontalNavigationMenu
{
    public function NavigationMenu()
    {
        // current tab
        $current_tab = isset($_GET['tab']) ? $_GET['tab'] : 'home';

        // mark as active curently open tab
        $home_active = ($current_tab === 'home' || !isset($_GET['tab'])) ? 'nav-tab-active' : '';
        $help_active = ($current_tab === 'help') ? 'nav-tab-active' : '';
        $api_active = ($current_tab === 'inflow-connection') ? 'nav-tab-active' : '';
        $contact_forms_active = ($current_tab === 'contact-forms') ? 'nav-tab-active' : '';

        echo '<nav class="nav-tab-wrapper">';
        echo '<a href="admin.php?page=ims-inflowcrm" class="nav-tab ' . $home_active . '">Home</a>';
        echo '<a href="admin.php?page=ims-inflowcrm&tab=help" class="nav-tab ' . $help_active . '">Pomoc</a>';
        echo '<a href="admin.php?page=ims-inflowcrm&tab=inflow-connection" class="nav-tab ' . $api_active . '">InflowCRM API</a>';
        echo '<a href="admin.php?page=ims-inflowcrm&tab=contact-forms" class="nav-tab ' . $contact_forms_active . '">Contact Forms</a>';
        echo '</nav>';
    }
}