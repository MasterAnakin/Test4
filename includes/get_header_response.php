<?php

// disable direct file access
if (!defined('ABSPATH')) {

	exit;
}

include_once "simplehtmldom_1_9/simple_html_dom.php";

class GetSingleLink {

	public function do_not_return_if_checked_in_last_x_time() {
		$x_time = 86400;
		$timestamp = time() - $x_time;
		return $timestamp;

	}

	public function get_single_link_from_db() {

		global $wpdb;

		$timestamp = $this->do_not_return_if_checked_in_last_x_time();

		$sql = "SELECT single_link FROM list_links WHERE timestamp < %s LIMIT 1";

		$sql = $wpdb->prepare($sql, $timestamp);
		$result = $wpdb->get_row($sql);

		$single_link_from_db = isset($result->single_link) ? $result->single_link : 'NULL';
		return $single_link_from_db;

	}

	public function get_single_link_from_db_if_exists() {
		$single_link_from_db = $this->get_single_link_from_db();

		if ($single_link_from_db == 'NULL') {
			return false;
		} else {
			return $single_link_from_db;
		}
	}

}

class CheckHeadersResponse {

	public $single_link = false;

//get single URL from the single page from the array of get_single_page_links_arr
	public function __construct($single_link) {
		$this->single_link = $single_link;
	}

	public function get_header_response() {
		$headers = get_headers($this->single_link, 1);

		if ($headers) {
			return $headers[0];
		}

		return false;
	}

	public function insert_header_reesponse() {
		global $wpdb;

		$single_link = $this->single_link;
		$header_response = $this->get_header_response();
		$timestamp = time();

		$sql = "Update list_links set status_code=%s, timestamp=%s  WHERE single_link = %s";

		$sql = $wpdb->prepare($sql, $header_response, $timestamp, $single_link);
		// var_dump($sql); // debug
		$result = $wpdb->query($sql);

		if (FALSE === $result) {
			echo ("Failed!");
		} else {
			echo ("Great success!");
		}
	}
}
/*
function get_results() {
for ($k = 0; $k < 2; $k++) {
//calling class and array of links from the single page
$page_link = get_single_link_from_db();
$new_url = new CheckHeadersResponse($page_link);
$page_link_check = $new_url->get_header_response();
print_r($page_link_check);
}
 */
function get_results_2() {
	$new_check = new GetSingleLink();
	$single_link = $new_check->get_single_link_from_db_if_exists();
//calling class and array of links from the single page

	if ($single_link == true) {
		$new_url = new CheckHeadersResponse($single_link);
		$new_url->get_header_response();
		$new_url->insert_header_reesponse();
	}

	//print_r($page_link_check);

}

add_shortcode('milos1', 'get_results_2');

/*

function bpr_wpcron($schedules) {

// one minute
$one_minute = array(
'interval' => 5,
'display' => 'One Minute',
);

$schedules['one_minute'] = $one_minute;

//daily
$daily = array(
'interval' => 86400,
'display' => 'Daily',
);

$schedules['daily'] = $daily;

// return data
return $schedules;

}

add_filter('cron_schedules', 'bpr_wpcron');

if (!wp_next_scheduled('bpr_time_set')) {
wp_schedule_event(time(), 'one_minute', 'bpr_time_set');
}

function bpr_run_cron() {

}

add_action('bpr_time_set', 'insert_header_reesponse');

 */

//run this on cron as well same number as the insert.