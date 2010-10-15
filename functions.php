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
require_once( TEMPLATEPATH . '/library/hybrid.php' );
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
	add_theme_support( 'hybrid-core-theme-settings' );
	add_theme_support( 'hybrid-core-meta-box-footer' );
	add_theme_support( 'hybrid-core-drop-downs' );
	add_theme_support( 'hybrid-core-seo' );
	add_theme_support( 'hybrid-core-template-hierarchy' );

	/* Add theme support for extensions. */
	add_theme_support( 'post-layouts' );
	add_theme_support( 'post-stylesheets' );
	add_theme_support( 'dev-stylesheet' );
	add_theme_support( 'loop-pagination' );
	add_theme_support( 'get-the-image' );
	add_theme_support( 'breadcrumb-trail' );

	/* Add theme support for WordPress features. */
	add_theme_support( 'automatic-feed-links' );
	add_custom_background();

	/* Register menus. */
	add_action( 'init', 'prototype_register_menus' );

	/* Register sidebars. */
	add_action( 'init', 'prototype_unregister_sidebars' );
	add_action( 'init', 'prototype_register_sidebars' );

	/* Add the breadcrumb trail just after the container is open. */
	add_action( "{$prefix}_open_main", 'breadcrumb_trail' );

	/* Embed width/height defaults. */
	add_filter( 'embed_defaults', 'prototype_embed_defaults' );

	/* Filter the sidebar widgets. */
	add_filter( 'sidebars_widgets', 'prototype_disable_sidebars' );
	add_action( 'template_redirect', 'prototype_one_column' );

	/* Filter the breadcrumb trail arguments. */
	add_filter( 'breadcrumb_trail_args', 'prototype_breadcrumb_trail_args' );
}

/**
 * Unregisters some of the core framework sidebars that the theme doesn't use.
 *
 * @since 0.1.0
 */
function prototype_unregister_sidebars() {
	unregister_sidebar( 'before-content' );
	unregister_sidebar( 'after-content' );
}

/**
 * Custom breadcrumb trail arguments.
 *
 * @since 0.1.0
 */
function prototype_breadcrumb_trail_args( $args ) {

	/* Change the text before the breadcrumb trail. */
	$args['before'] = __( 'You are here:', hybrid_get_textdomain() );

	/* Return the filtered arguments. */
	return $args;
}

/**
 * Function for deciding which pages should have a one-column layout.
 *
 * @since 0.1.0
 */
function prototype_one_column() {

	if ( !is_active_sidebar( 'primary' ) && !is_active_sidebar( 'secondary' ) )
		add_filter( 'get_post_layout', 'prototype_post_layout_one_column' );

	elseif ( is_attachment() )
		add_filter( 'get_post_layout', 'prototype_post_layout_one_column' );
}

/**
 * Filters 'get_post_layout' by returning 'layout-1c'.
 *
 * @since 0.1.0
 */
function prototype_post_layout_one_column( $layout ) {
	return 'layout-1c';
}

/**
 * Disables sidebars if viewing a one-column page.
 *
 * @since 0.1.0
 */
function prototype_disable_sidebars( $sidebars_widgets ) {
	global $wp_query;

	if ( current_theme_supports( 'post-layouts' ) ) {

		if ( 'layout-1c' == post_layouts_get_layout() ) {
			$sidebars_widgets['primary'] = false;
			$sidebars_widgets['secondary'] = false;
		}
	}

	return $sidebars_widgets;
}

/**
 * Registers new sidebars for the theme.
 *
 * @since 0.1.0.
 */
function prototype_register_sidebars() {
	register_sidebar( array( 'name' => __( 'Header', hybrid_get_textdomain() ), 'id' => 'header', 'description' => __( 'Displayed in the header area.', hybrid_get_textdomain() ), 'before_widget' => '<div id="%1$s" class="widget %2$s widget-%2$s"><div class="widget-inside">', 'after_widget' => '</div></div>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) );
}

/**
 * Registers new nav menus for the theme.
 *
 * @since 0.1.0
 */
function prototype_register_menus() {
	register_nav_menus(
		array(
			'secondary' => __( 'Secondary Menu', hybrid_get_textdomain() ),
			'subsidiary' => __( 'Subsidiary Menu', hybrid_get_textdomain() )
		)
	);
}

/**
 * Overwrites the default widths for embeds.  This is especially useful for making sure videos properly
 * expand the full width on video pages.  This function overwrites what the $content_width variable handles
 * with context-based widths.
 *
 * @since 0.1.0
 */
function prototype_embed_defaults( $args ) {

	if ( current_theme_supports( 'post-layouts' ) ) {

		$layout = post_layouts_get_layout();

		if ( 'layout-3c-l' == $layout || 'layout-3c-r' == $layout || 'layout-3c-c' == $layout )
			$args['width'] = 500;
		elseif ( 'layout-1c' == $layout )
			$args['width'] = 928;
		else
			$args['width'] = 600;
	}
	else
		$args['width'] = 600;

	return $args;
}

?>