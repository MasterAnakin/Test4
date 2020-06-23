<?php // MyPlugin - Settings Page

// disable direct file access
if (!defined('ABSPATH')) {

	exit;

}

// display the plugin settings page
function myplugin_display_settings_page() {

	// check if user is allowed access
	if (!current_user_can('manage_options')) {
		return;
	}

	?>

	<div class="wrap">


	<?php

	// output security fields
	settings_fields('myplugin_options');

	// output setting sections
	do_settings_sections('myplugin');

	// submit button
	submit_button();

	//echo "/options-general.php?page=link-checker?milos_test_ser"

	// This function creates the output for the admin page.
	// It also checks the value of the $_POST variable to see whether
	// there has been a form submission.

	// The check_admin_referer is a WordPress function that does some security
	// checking and is recommended good practice.

	// General check for user permissions.

	echo '<form action="options-general.php?page=link-checker" method="post">';

// this is a WordPress security feature - see: https://codex.wordpress.org/WordPress_Nonces
	//wp_nonce_field('test_button_clicked');
	echo '<input type="hidden" value="true" name="test_button" />';
	submit_button('Call Function');
	echo '</form>';

	echo '<form action="options-general.php?page=link-checker" method="post">';

// this is a WordPress security feature - see: https://codex.wordpress.org/WordPress_Nonces
	//wp_nonce_field('test_button_clicked');
	echo '<input type="hidden" value="true" name="test_button_2" />';
	submit_button('Call Function 2');
	echo '</form>';

	echo '</div>';

}
