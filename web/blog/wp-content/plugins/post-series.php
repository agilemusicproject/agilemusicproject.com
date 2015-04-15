<?php
/*
Plugin Name: Post Series
Plugin URI: http://wp.tutsplus.com/tutorials/plugins/adding-post-series-functionality-to-wordpress-with-taxonomies/
Description: Adds the "post series" functionality to WordPress with the help of a taxonomy and a shortcode.
Version: 1.0
Author: Barış Ünver
Author URI: http://beyn.org/
*/

// create the "Series" taxonomy for posts only
function series_tax() {
	$labels = array(
		'name' => _x('Series', 'taxonomy general name'),
		'singular_name' => _x('Series', 'taxonomy singular name'),
		'all_items' => __('All Series'),
		'edit_item' => __('Edit Series'), 
		'update_item' => __('Update Series'),
		'add_new_item' => __('Add New Series'),
		'new_item_name' => __('New Series Name'),
		'menu_name' => __('Series'),
	);

	register_taxonomy(
		'series',
		array('post'), /* if you want to use pages or custom post types, simple extend the array like array('post','page','custom-post-type') */
		array(
			'hierarchical' => true, /* if set to "true", you can use Series as categories; if set to "false", you can use them as tags! */
			'labels' => $labels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array('slug' => 'series'), /* you may need to flush the rewrite rules at Options -> Permalinks (just update the existing preferences without any change) */
		)
	);
} add_action('init', 'series_tax', 0);

// The shortcode function of Post Series
function series_sc($atts) {
	extract(
		shortcode_atts(
			array(
				"slug" => '',
				"id" => '',
				"title" => '',
				"title_wrap" => 'h3',
				"list" => 'ul',
				"limit" => -1,
				"future" => 'on'
			), $atts
		)
	);
	if($id) {
		// Use the "id" attribute if it exists
		$tax_query = array(array('taxonomy' => 'series', 'field' => 'id', 'terms' => $id));
	} else if ($slug) {
		// Use the "slug" attribute if "id" does not exist
		$tax_query = array(array('taxonomy' => 'series', 'field' => 'slug', 'terms' => $slug));
	} else {
		// Use post's own Series tax if neither "id" nor "slug" exist
		$terms = get_the_terms($post->ID,'series');
		if ($terms && !is_wp_error($terms)) {
			foreach ($terms as $term) {
				$tax_query = array(array('taxonomy' => 'series', 'field' => 'slug', 'terms' => $term->slug));
			}
		} else {$error = true;}
	}
	if($title) {
		// Create the title if the "title" attribute exists
		$title_output = '<'.$title_wrap.' class="post-series-title">'.$title.'</'.$title_wrap.'>';
	}
	if($future == 'on') {
		// Include the future posts if the "future" attribute is set to "on"
		$post_status = array('publish','future');
	} else {
		// Exclude the future posts if the "future" attribute is set to "off"
		$post_status = 'publish';
	}
	if($error == false) {
		$args = array(
			'tax_query' => $tax_query,
			'posts_per_page' => $limit,
			'orderby' => 'date',
			'order' => 'ASC',
			'post_status' => $post_status
		);
		$the_posts = get_posts($args);
		/* if there's more than one post with the specified "series" taxonomy, display the list. if there's just one post with the specified taxonomy, there's no need to list the only post! */
		if(count($the_posts) > 1) {
			// display the title first
			$output = $title_output;
			// create the list tag - notice the "post-series-list" class
			$output .= '<'.$list.' class="post-series-list">';
			// the loop to list the posts
			foreach($the_posts as $post) {
				setup_postdata($post);
				if($post->post_status == 'publish') {
					$output .= '<li><a href="'.get_permalink($post->ID).'">'.get_the_title($post->ID).'</a></li>';
				} else {
					/* we can't link the post if the post is not published yet! */
					$output .= '<li>Future post: '.get_the_title($post->ID).'</li>';
				}
			}
			wp_reset_query();
			// close the list tag...
			$output .= '</'.$list.'>';
			// ...and return the whole output!
			return $output;
		}
	}
} add_shortcode('series','series_sc');

function add_series_shortcode_to_series_posts ( $content ) {
  global $post;
  if ( is_object_in_term( $post->ID, 'series' ) ) {
    return '[series]' . $content . '<div class="clear-both"></div>';
  } else { 
    return $content;
  }
} add_filter( 'the_content', 'add_series_shortcode_to_series_posts' );

?>
