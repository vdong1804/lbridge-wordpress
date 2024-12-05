<?php 
/** 
 * SETUP THEME
 */

function vtrealestate_setup(){
    // Makes VT Realestate available for translation.
    load_theme_textdomain('giavu', get_template_directory() . '/languages');
    // Adds RSS feed links to <head> for posts and comments.
    add_theme_support('automatic-feed-links');
    // This theme uses post thumbnail.
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'vtrealestate_setup');


/** Function title for theme
 *
 */
function vtrealestate_wp_title($title, $sep){
	global $paged, $page;
    if (is_feed())
    	return $title;

    // Add the site name.
    $title .= get_bloginfo('name', 'display');

    // Add the site description for the home/front page.
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && (is_home() || is_front_page()))
    	$title = "$title $sep $site_description";

	// Add a page number if necessary.
    if (($paged >= 2 || $page >= 2) && !is_404())
    	$title = "$title $sep " . sprintf(__('Page %s', 'vtrealestate'), max($paged, $page));
    return $title;
}
add_filter('wp_title', 'vtrealestate_wp_title', 10, 2);
