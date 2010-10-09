<?php
/**
 * The functions file is used to initialize everything in the theme.  It controls how the theme is loaded and 
 * sets up the supported features, default actions, and default filters.  If making customizations, users 
 * should create a child theme and make changes to its functions.php file (not this one).  Friends don't let 
 * friends modify parent theme files. ;)
 *
 * Child themes should do their setup on the 'after_setup_theme' hook with a priority of 11 if they want to
 * override parent theme features.  Use a priority of 9 if wanting to run before the parent theme.
 *
 * @package Prototype
 * @subpackage Functions
 */

/* Load the core theme framework. */
require_once( TEMPLATEPATH . '/library/classes/hybrid.php' );
$theme = new Hybrid();

/* Do theme setup on the 'after_setup_theme' hook. */
add_action( 'after_setup_theme', 'prototype_theme_setup' );

/**
 * Theme setup function.  This function adds support for theme features and defines the default theme
 * actions and filters.
 *
 * @since 0.1.0
 */
function prototype_theme_setup() {

	/* Get action/filter hook prefix. */
	$prefix = hybrid_get_prefix();

	/* Add theme support for core framework features. */
	add_theme_support( 'hybrid-core-menus' );
	add_theme_support( 'hybrid-core-sidebars' );
	add_theme_support( 'hybrid-core-widgets' );
	add_theme_support( 'hybrid-core-shortcodes' );
	add_theme_support( 'hybrid-core-post-meta-box' );
	add_theme_support( 'hybrid-core-meta-box-footer' );
	add_theme_support( 'hybrid-core-drop-downs' );
	add_theme_support( 'hybrid-core-print-style' );
	add_theme_support( 'hybrid-core-seo' );

	/* Add theme support for extensions. */
	add_theme_support( 'post-layouts' );
	add_theme_support( 'loop-pagination' );
	add_theme_support( 'get-the-image' );
	add_theme_support( 'entry-views' );
	add_theme_support( 'breadcrumb-trail' );

	/* Allow users to upload a custom background. */
	add_custom_background();

	/* Register menus. */
	add_action( 'init', 'prototype_register_menus' );

	/* Register sidebars. */
	add_action( 'init', 'prototype_unregister_sidebars' );
	add_action( 'init', 'prototype_register_sidebars' );

	/* Add site title and description to the header. */
	add_action( "{$prefix}_header", 'prototype_sidebar_header' );
	add_action( "{$prefix}_header", 'hybrid_site_title' );
	add_action( "{$prefix}_header", 'hybrid_site_description' );

	/* Add the breadcrumb trail just after the container is open. */
	add_action( "{$prefix}_open_container", 'breadcrumb_trail' );

	/* Add menus to specific locations. */
	add_action( "{$prefix}_before_header", 'hybrid_get_primary_menu' );
	add_action( "{$prefix}_after_header", 'prototype_menu_secondary' );
	add_action( "{$prefix}_before_footer", 'prototype_menu_subsidiary' );

	/* Add subisidiary sidebar before the footer. */
	add_action( "{$prefix}_before_footer", 'prototype_sidebar_subsidiary' );

	/* Add the footer text to the footer. */
	add_action( "{$prefix}_footer", 'hybrid_footer_insert' );

	/* Embed width/height defaults. */
	add_filter( 'embed_defaults', 'prototype_embed_defaults' );

	/* Filter the sidebar widgets. */
	add_filter( 'sidebars_widgets', 'prototype_disable_sidebars' );

	/* Filter the breadcrumb trail arguments. */
	add_filter( 'breadcrumb_trail_args', 'prototype_breadcrumb_trail_args' );
}

function prototype_unregister_sidebars() {
	unregister_sidebar( 'before-content' );
	unregister_sidebar( 'after-content' );
}

function prototype_breadcrumb_trail_args( $args ) {

	$args['before'] = __( 'You are here:', hybrid_get_textdomain() );

	return $args;
}

function prototype_disable_sidebars( $sidebars_widgets ) {

	//if ( current_theme_supports( 'post-layouts' ) && 'layout-1c' == post_layouts_get() ) {
	//	$sidebars_widgets['primary'] = false;
	//	$sidebars_widgets['secondary'] = false;
	//}

	global $wp_query;

	if ( is_singular() ) {
		$post_id = $wp_query->get_queried_object_id();

		$layout = get_post_meta( $post_id, 'Layout', true );

		if ( '1c' == $layout ) {
			$sidebars_widgets['primary'] = false;
			$sidebars_widgets['secondary'] = false;
		}
	}

	return $sidebars_widgets;
}

function prototype_sidebar_subsidiary() {
	get_sidebar( 'subsidiary' );
}

function prototype_register_sidebars() {
	register_sidebar( array( 'name' => __( 'Header', hybrid_get_textdomain() ), 'id' => 'header', 'description' => __( 'Displayed in the header area.', hybrid_get_textdomain() ), 'before_widget' => '<div id="%1$s" class="widget %2$s widget-%2$s"><div class="widget-inside">', 'after_widget' => '</div></div>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) );
}

function prototype_register_menus() {
	register_nav_menus(
		array(
			'secondary-menu' => __( 'Secondary Menu', hybrid_get_textdomain() ),
			'subsidiary-menu' => __( 'Subsidiary Menu', hybrid_get_textdomain() )
		)
	);
}

function prototype_sidebar_header() {
	get_sidebar( 'header' );
}

function prototype_menu_secondary() {
	locate_template( array( 'menu-secondary.php', 'menu.php' ), true );
}

function prototype_menu_subsidiary() {
	locate_template( array( 'menu-subsidiary.php', 'menu.php' ), true );
}

/**
 * Overwrites the default widths for embeds.  This is especially useful for making sure videos properly
 * expand the full width on video pages.  This function overwrites what the $content_width variable handles
 * with context-based widths.
 *
 * @since 0.1.0
 */
function prototype_embed_defaults( $args ) {
	if ( !is_active_sidebar( 'primary' ) && !is_active_sidebar( 'secondary' ) )
		$args['width'] = 928;
	else
		$args['width'] = 600;

	return $args;
}

?>