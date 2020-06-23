<?php // MyPlugin - Settings Callbacks

// disable direct file access
if (!defined('ABSPATH')) {

	exit;

}

// callback: login section
function myplugin_callback_section_login() {

	echo '<p>List all links and response codes.</p>';

}

// callback: admin section
/*
function myplugin_callback_section_admin() {

echo '<p>These settings enable you to customize the WP Admin Area.</p>';

}

 */

function myplugin_callback_section_admin() {

// This function creates the output for the admin page.
	// It also checks the value of the $_POST variable to see whether
	// there has been a form submission.

// The check_admin_referer is a WordPress function that does some security
	// checking and is recommended good practice.

// General check for user permissions.

// Start building the page

// Check whether the button has been pressed AND also check the nonce
	if (isset($_POST['test_button'])) {
// the button has been pressed AND we've passed the security check
		get_results_2();
	}

	if (isset($_POST['test_button_2'])) {
		$get_links_from_class = new GetAllLinksFromSite;
		$get_links_from_class->save_all_links_arr();
		run_db_import();
	}
//	echo '<form action="options-general.php?page=link-checker" method="post">';

// this is a WordPress security feature - see: https://codex.wordpress.org/WordPress_Nonces
	//wp_nonce_field('test_button_clicked');
	//echo '<input type="hidden" value="true" name="test_button" />';
	//	submit_button('Call Function');

}

function test_button_action() {
	echo "likoovcsopc";
}

// callback: text field
function myplugin_callback_field_text($args) {

	global $wpdb;
	$rows = $wpdb->get_results("SELECT * FROM list_links");
	foreach ($rows as $row) {
		echo '
    <tr>
      <td>' . $row->single_link . '</td>
      <td>' . $row->status_code . '</td>
   </tr>';}

}

/*
// callback: radio field
function myplugin_callback_field_radio($args) {

$options = get_option('myplugin_options', myplugin_options_default());

$id = isset($args['id']) ? $args['id'] : '';
$label = isset($args['label']) ? $args['label'] : '';

$selected_option = isset($options[$id]) ? sanitize_text_field($options[$id]) : '';

$radio_options = array(

'enable' => 'Enable custom styles',
'disable' => 'Disable custom styles',

);

foreach ($radio_options as $value => $label) {

$checked = checked($selected_option === $value, true, false);

echo '<label><input name="myplugin_options[' . $id . ']" type="radio" value="' . $value . '"' . $checked . '> ';
echo '<span>' . $label . '</span></label><br />';

}

}

// callback: textarea field
function myplugin_callback_field_textarea($args) {

$options = get_option('myplugin_options', myplugin_options_default());

$id = isset($args['id']) ? $args['id'] : '';
$label = isset($args['label']) ? $args['label'] : '';

$allowed_tags = wp_kses_allowed_html('post');

$value = isset($options[$id]) ? wp_kses(stripslashes_deep($options[$id]), $allowed_tags) : '';

echo '<textarea id="myplugin_options_' . $id . '" name="myplugin_options[' . $id . ']" rows="5" cols="50">' . $value . '</textarea><br />';
echo '<label for="myplugin_options_' . $id . '">' . $label . '</label>';

}

// callback: checkbox field
function myplugin_callback_field_checkbox($args) {

$options = get_option('myplugin_options', myplugin_options_default());

$id = isset($args['id']) ? $args['id'] : '';
$label = isset($args['label']) ? $args['label'] : '';

$checked = isset($options[$id]) ? checked($options[$id], 1, false) : '';

echo '<input id="myplugin_options_' . $id . '" name="myplugin_options[' . $id . ']" type="checkbox" value="1"' . $checked . '> ';
echo '<label for="myplugin_options_' . $id . '">' . $label . '</label>';

}

// callback: select field
function myplugin_callback_field_select($args) {

$options = get_option('myplugin_options', myplugin_options_default());

$id = isset($args['id']) ? $args['id'] : '';
$label = isset($args['label']) ? $args['label'] : '';

$selected_option = isset($options[$id]) ? sanitize_text_field($options[$id]) : '';

$select_options = array(

'default' => 'Default',
'light' => 'Light',
'blue' => 'Blue',
'coffee' => 'Coffee',
'ectoplasm' => 'Ectoplasm',
'midnight' => 'Midnight',
'ocean' => 'Ocean',
'sunrise' => 'Sunrise',

);

echo '<select id="myplugin_options_' . $id . '" name="myplugin_options[' . $id . ']">';

foreach ($select_options as $value => $option) {

$selected = selected($selected_option === $value, true, false);

echo '<option value="' . $value . '"' . $selected . '>' . $option . '</option>';

}

echo '</select> <label for="myplugin_options_' . $id . '">' . $label . '</label>';

}
 */