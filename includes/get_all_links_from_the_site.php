<?php

// disable direct file access
if (!defined('ABSPATH')) {

	exit;

}

class GetAllLinksFromSite {

	public function get_all_links() {

		$posts = new WP_Query('post_type=any&posts_per_page=-1&post_status=publish');
		$posts = $posts->posts;

		foreach ($posts as $post) {
			switch ($post->post_type) {
			case 'revision':
			case 'nav_menu_item':
				break;
			case 'page':
				$permalink = get_page_link($post->ID);
				break;
			case 'post':
				$permalink = get_permalink($post->ID);
				break;
			case 'attachment':
				$permalink = get_attachment_link($post->ID);
				break;
			default:
				$permalink = get_post_permalink($post->ID);
				break;
			}

			$new_ar[] = $permalink;
		}

		return $new_ar;
	}

//Once I have array ready, I use that to save it under options table as links_arr option.
	public function save_all_links_arr() {
		$links_arr = $this->get_all_links();
		$results_arr_ser = serialize($links_arr);

		if (!get_option('links_arr')) {
			add_option('links_arr', $results_arr_ser);
		} else {
			update_option('links_arr', $results_arr_ser);
		}
	}

}

//this should be a button for geetting latest links under wp-admin
if (isset($_GET['milos_test_ser'])) {

	$get_links_from_class = new GetAllLinksFromSite;

	add_shortcode('test', array($get_links_from_class, 'save_all_links_arr'));

}