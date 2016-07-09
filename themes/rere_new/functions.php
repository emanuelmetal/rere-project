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

/* Theme setup */
//add_action( 'after_setup_theme', 'wpt_setup' );
//    if ( ! function_exists( 'wpt_setup' ) ):
//		function wpt_setup() {
//			register_nav_menu( 'primary', __( 'Primary navigation', 'wptuts' ) );
//		} endif;

function wpt_register_js() {
	wp_register_script('bootstrap', get_template_directory_uri() . '/bower_components/bootstrap/dist/js/bootstrap.min.js', 'jquery');
	wp_register_script('parsley', get_template_directory_uri() . '/bower_components/parsleyjs/parsley.min.js', 'jquery');
	wp_register_script('jquery-serialize-object', get_template_directory_uri() . '/bower_components/jquery-serialize-object/jquery.serialize-object.js', 'jquery');
}
add_action( 'init', 'wpt_register_js' );
//function wpt_register_css() {
//	wp_register_style( 'bootstrap.min', get_template_directory_uri() . '/css/bootstrap.min.css' );
//	wp_enqueue_style( 'bootstrap.min' );
//}
add_action( 'wp_enqueue_scripts');

require_once('wp_bootstrap_navwalker.php');


add_filter( 'posts_where' , 'posts_where_statement' );

function posts_where_statement( $where ) {
	$used_posts = "'17303-2',
			'letter-from-the-editor',
			'streets-locator',
			'media-books-films-tv',
			'books',
			'films',
			'television-series',
			'celebrity-homes',
			'stars-on-the-upper-east-side',
			'stars-on-the-upper-west-side',
			'stars-in-lower-manhattan',
			'stars-in-midtown',
			'stars-of-downtown',
			'dowload-mastering-manhattan',
			'highlights',
			'highlights-of-downtown-east-and-west',
			'highlights-of-downtown-west',
			'highlights-of-midtown-east',
			'highlights-of-midtown-west',
			'highlights-of-the-upper-east-side',
			'highlights',
			'highlights-of-uptown',
			'highlights-of-upper-manhattan',
			'lower-manhattan-gallery',
			'downtown-east-gallery',
			'downtown-west-gallery',
			'midtown-east-gallery',
			'midtown-west-gallery',
			'upper-east-side-gallery',
			'upper-west-side-gallery',
			'uptown-gallery',
			'uptown-gallery',
			'manhattan-real-estate-condo-coop-history-lower-manhattan',
			'manhattan-real-estate-condo-coop-history-lower-manhattan',
			'manhattan-real-estate-downtown-history',
			'manhattan-real-estate-condo-coop-history-midtown-east',
			'manhattan-real-estate-condo-coop-history-midtown-west',
			'manhattan-real-estate-condo-coop-history-upper-east-side',
			'manhattan-real-estate-condo-coop-history-upper-west-side',
			'manhattan-real-estate-condo-coop-history-uptown',
			'manhattan-real-estate-condo-coop-history-upper-manhattan',
			'parks-of-lower-manhattan',
			'parks-of-downtown-east',
			'parks-of-downtown-west',
			'parks-of-midtown-east',
			'parks-of-midtown-west',
			'parks-of-the-upper-east-side',
			'parks',
			'parks-of-uptown',
			'parks-of-upper-manhattan',
			'lower-manhattan-historic-districts',
			'historic-districts-of-downtown-east',
			'historic-districts-of-downtown-west',
			'historic-districts-of-midtown-east',
			'historic-districts-of-midtown-east',
			'historic-districts-of-the-upper-east-side',
			'historic-districts',
			'historic-districts-of-uptown',
			'historic-districts-of-uptown',
			'community-services-in-lower-manhattan',
			'community-services-in-downtown-east',
			'community-services-in-downtown-west',
			'community-services-in-midtown-east',
			'community-services-of-midtown-west',
			'community-services-of-the-upper-east-side',
			'community-service-2',
			'community-services-of-uptown',
			'community-services-in-upper-manhattan',
			'neighborhood-zip-code-maps',
			'historic-maps',
			'downtown-manhattan-real-estate-condo-coop-types',
			'downtown-manhattan-real-estate-coop-condo-history',
			'time-lines-and-sidebars',
			'downtown-manhattan-real-estate-history-central-park',
			'house-plans-by-zip-code',
			'image-galleries',
			'manhattan-central-park-photographs-gallery',
			'parks-gallery',
			'enclaves-gallery',
			'monumental-midtown-gallery',
			'distinguishing-dwellings-gallery',
			'upper-east-side-gallery',
			'midtown-east-gallery',
			'downtown-east-gallery',
			'lower-manhattan-gallery',
			'downtown-west-gallery',
			'midtown-east-gallery',
			'downtown-east-gallery',
			'lower-manhattan-gallery',
			'downtown-west-gallery',
			'midtown-west-gallery',
			'upper-west-side-gallery',
			'uptown-gallery',
			'lofts-gallery',
			'townhouses-east-70th',
			'townhouses-westside-historic-districts',
			'townhouses-west-76th-street',
			'townhouses-east-19th-street',
			'townhouses-upper-west-side',
			'townhouses-downtown-west',
			'townhouses-upper-east-side',
			'manhattan-town-houses-interiors-upper-east-side',
			'manhattan-town-house-interiors-downtown',
			'manhattan-town-house-interiors-uws',
			'manhattan-coop-condo-rental-property',
			'rental-building-links',
			'new-development-links',
			'manhattan-coop-condo-rental-property-developers',
			'manhattan-coop-condo-rental-property-developers-3',
			'manhattan-coop-condo-pre-war-homes',
			'manhattan-coop-condo-pre-war-homes-broadway',
			'manhattan-coop-condo-pre-war-homes-midtown',
			'manhattan-coop-condo-pre-war-homes-east-side',
			'manhattan-coop-condo-pre-war-homes-upper-west-side',
			'manhattan-coop-condo-pre-war-homes-morningside-heights',
			'manhattan-coop-condo-pre-war-homes-uptown',
			'manhattan-coop-condo-pre-war-homes-upper-manhattan',
			'manhattan-coop-condo-pre-war-homes-historic-photographs',
			'second-homes',
			'around-me',
			'property-search',
			'blog',
			'blog-2',
			'urbane-development',
			'mortgage-mire',
			'manhattan-living',
			'recommended-reading',
			'10128-2',
			'10065-2',
			'10029-2',
			'10028-2',
			'10025-2',
			'10024-2',
			'10023-2',
			'10022-2',
			'10021-2',
			'10019-2',
			'10017-2',
			'10016-2',
			'10014-2',
			'10012-2',
			'10011-2',
			'10003-2',
			'personal-planners',
			'findme-a-match',
			'manhattan-coop-condo-advertisements',
			'manhattan-real-estate-search-hints-tips-conventional-wisoms',
			'sitemap'";
	//gets the global query var object
	global $wp_query;

	//gets the front page id set in options
//	$front_page_id = get_option('page_on_front');
//
//	//checks the context before altering the query
//	if ( 'page' != get_option('show_on_front') || $front_page_id != $wp_query->query_vars['page_id'] )
//		return $where;

	//changes the where statement
	if (is_search()) {
		$where .= " AND wp_posts.post_name IN ({$used_posts}) OR wp_posts.ID > 17610 ";
	}
	//removes the actions hooked on the '__after_loop' (post navigation)
	remove_all_actions ( '__after_loop');

	return $where;
}

