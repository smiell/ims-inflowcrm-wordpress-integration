<?php
/**
 * Plugin Name: IMS InflowCRM Wordpress Integration
 * Plugin URI:  https://imspartner.pl
 * Description: Integracja WordPress z InflowCRM.
 * Version:     1.0
 * Author:      Internship Management Solutions SP. Z O.O
 * Author URI:  https://imspartner.pl
 */

if (!defined('ABSPATH')) exit;

// Autload
spl_autoload_register( function($class) {
    $prefix = 'IMS_InflowCRM\\';
    $base_dir = __DIR__ . '/includes/';
    if(strpos($class, $prefix) !== 0) return;
    $relative_class = str_replace($prefix, '', $class);
    $file = $base_dir . str_replace( '\\', '/', $relative_class) . '.php';
    if(file_exists($file)) require $file;
});

// Plugin initial
function ims_inflowcrm_init() {
    new IMS_InflowCRM\Admin\AdminMenu();
    //new IMS_InflowCRM\Frontend\Shortcode();
    new IMS_InflowCRM\Admin\Settings();
}

add_action('plugins_loaded', 'ims_inflowcrm_init');