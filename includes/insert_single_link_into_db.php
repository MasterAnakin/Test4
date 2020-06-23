<?php

// disable direct file access
if (!defined('ABSPATH')) {

	exit;

}

class InsertSingleLinkIntoDB {

	public function get_array_links() {

		$links_arr = get_option('links_arr');

		$link_array = unserialize($links_arr);

		return $link_array;
	}

//get the count I can use to control entires
	public function get_array_count() {

		$link_array = $this->get_array_links();
		$number_of_elements_array = count($link_array);

		return $number_of_elements_array;

		//$count_minus_first_zero_element = $number_of_elements_array - 2;

		//return $count_minus_first_zero_element;
	}

	public function get_array_count_offset() {

		$count_minus_two_elements = $this->get_array_count() - 2;

		return $count_minus_two_elements;
	}

//if the key is not set, or if we stored all the elements already and we need to stop the function
	public function reset_the_key_if_needed() {

		$existing_array_order_value = get_option('array_order');

		if (!get_option('array_order')) {
			add_option('array_order', '-1');
		}

		if ($existing_array_order_value > $this->get_array_count_offset()) {
			update_option('array_order', '-1');
		}
	}

//insert single link based on the array_order option - key
	public function insert_single_link() {

		$link_array = $this->get_array_links();
		$key = get_option('array_order');
		$single_link = $link_array[$key];
		echo $link_array[$key];

		global $wpdb;

		$sql = "INSERT INTO list_links (single_link) SELECT * FROM (SELECT %s) AS tmp WHERE NOT EXISTS ( SELECT single_link FROM list_links WHERE single_link = %s ) LIMIT 1";

		$sql = $wpdb->prepare($sql, $single_link, $single_link);

		$result = $wpdb->query($sql);

		if (FALSE === $result) {
			echo ("Failed!");
		} else {
			echo ("Great success!");
		}

	}

//set the next array_order - key value
	public function add_array_order_value() {

		$this->reset_the_key_if_needed();

		$existing_array_order_value = get_option('array_order');

		$new_array_order_value = $existing_array_order_value + 1;
		update_option('array_order', $new_array_order_value);
		echo get_option('array_order');

	}
}

function run_db_import() {

	$get_arr = new InsertSingleLinkIntoDB;
	$links_arr = $get_arr->get_array_links();
	//better to use for
	//$test_arr = array("http://localhost:8888/project/", "http://localhost:8888/project/new-page/", "http://localhost:8888/project/sample-page/", "http://localhost:8888/project/2019/07/03/video/", "http://localhost:8888/project/2019/05/01/test3/");
	foreach ($links_arr as $page_link_single) {

		$milos = new InsertSingleLinkIntoDB;
		$milos->add_array_order_value();
		$milos->insert_single_link();
	}
}

add_shortcode('shutdown', 'run_db_import');