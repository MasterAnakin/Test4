<?php
/*
Plugin Name:  Link Checker Milos
Description:  Check status codes of links
Plugin URI:   https://valet.io/
Author:       Josh & Milos
Version:      2.0
Text Domain:  wpmilos
Domain Path:  /languages
License:      GPL v2 or later
License URI:  https://www.gnu.org/licenses/gpl-2.0.txt
 */

// disable direct file access
if (!defined('ABSPATH')) {

	exit;

}

// if admin area
if (is_admin()) {

// include plugin dependencies
	require_once plugin_dir_path(__FILE__) . 'admin/admin-menu.php';
	require_once plugin_dir_path(__FILE__) . 'admin/settings-page.php';
	require_once plugin_dir_path(__FILE__) . 'admin/settings-register.php';
	require_once plugin_dir_path(__FILE__) . 'admin/settings-callbacks.php';
	require_once plugin_dir_path(__FILE__) . 'admin/settings-validate.php';

}

//if (is_admin()) {
// include plugin dependencies
require_once plugin_dir_path(__FILE__) . 'includes/get_all_links_from_the_site.php';
require_once plugin_dir_path(__FILE__) . 'includes/insert_single_link_into_db.php';
require_once plugin_dir_path(__FILE__) . 'includes/get_header_response.php';

//}

// default plugin options
function myplugin_options_default() {

	return array(
		'custom_url' => 'https://wordpress.org/',
		'custom_title' => 'Powered by WordPress',
		'custom_style' => 'disable',
		'custom_message' => '<p class="custom-message">My custom message</p>',
		'custom_footer' => 'Special message for users',
		'custom_toolbar' => false,
		'custom_scheme' => 'default',
	);

}
