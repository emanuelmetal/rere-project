<?php

include( TEMPLATEPATH.'/constants.php' );
include( TEMPLATEPATH.'/classes.php' );
include( TEMPLATEPATH.'/widgets.php' );

/**
 * Disable automatic general feed link outputting.
 */
automatic_feed_links( false );

//remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'wp_generator');

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'id' => 'login',
		'name' => 'login',
		'before_widget' => '<div class="widget %2$s" id="%1$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>'
	));
	register_sidebar(array(
		'id' => 'simple-right',
		'name' => 'simple-right',
		'before_widget' => '<div class="widget %2$s" id="%1$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>'
	));
	register_sidebar(array(
		'id' => 'socials',
		'name' => 'Socials',
		'before_widget' => '<div class="widget %2$s" id="%1$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>'
	));
}

if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 50, 50, true ); // Normal post thumbnails
	add_image_size( 'single-post-thumbnail', 400, 9999, true );
	add_image_size( 'post-thumbnails', 106, 80, true );
	add_image_size( 'gallery-thumbnails', 636, 270, true );	
}

register_nav_menus( array(
	'main' => __( 'Main Menu', 'RegardingRealEstate.com' ),
	'footer' => __( 'Footer Menu', 'RegardingRealEstate.com' ),
) );


//add [email]...[/email] shortcode
function shortcode_email($atts, $content) {
	$result = '';
	for ($i=0; $i<strlen($content); $i++) {
		$result .= '&#'.ord($content{$i}).';';
	}
	return $result;
}
add_shortcode('email', 'shortcode_email');

// register tag [template-url]
function filter_template_url($text) {
	return str_replace('[template-url]',get_bloginfo('template_url'), $text);
}
add_filter('the_content', 'filter_template_url');
add_filter('get_the_content', 'filter_template_url');
add_filter('widget_text', 'filter_template_url');

// register tag [site-url]
function filter_site_url($text) {
	return str_replace('[site-url]',get_bloginfo('url'), $text);
}
add_filter('the_content', 'filter_site_url');
add_filter('get_the_content', 'filter_site_url');
add_filter('widget_text', 'filter_site_url');


/* Replace Standart WP Menu Classes */
function change_menu_classes($css_classes) {
        $css_classes = str_replace("current-menu-item", "active", $css_classes);
        $css_classes = str_replace("current-menu-parent", "active", $css_classes);
        return $css_classes;
}
add_filter('nav_menu_css_class', 'change_menu_classes');


//allow tags in category description
$filters = array('pre_term_description', 'pre_link_description', 'pre_link_notes', 'pre_user_description');
foreach ( $filters as $filter ) {
    remove_filter($filter, 'wp_filter_kses');
}

add_action('init', 'Gallery_init');
function Gallery_init() 
{
  $labels = array(
    'name' => _x('Gallery', 'post type general name'),
    'singular_name' => _x('Post', 'post type singular name'),
    'add_new' => _x('Add New', 'Post'),
    'add_new_item' => __('Add New Post'),
    'edit_item' => __('Edit Post'),
    'new_item' => __('New Post'),
    'view_item' => __('View Post'),
    'search_items' => __('Search Post'),
    'not_found' =>  __('No Posts found'),
    'not_found_in_trash' => __('No Posts found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => 'Gallery'
  );
  
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'),
    'taxonomies' => array('category')
  ); 
  register_post_type('Gallery',$args);
}

?>