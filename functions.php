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
 * @package News
 * @subpackage Functions
 */

/* Load the core theme framework. */
require_once( TEMPLATEPATH . '/library/classes/hybrid.php' );
$theme = new Hybrid();

/* Do theme setup on the 'after_setup_theme' hook. */
add_action( 'after_setup_theme', 'news_theme_setup' );

/**
 * Theme setup function.  This function adds support for theme features and defines the default theme
 * actions and filters.
 *
 * @since 0.1.0
 */
function news_theme_setup() {

	/* Get action/filter hook prefix. */
	$prefix = hybrid_get_prefix();

	/* Load shortcodes file. */
	require_once( THEME_DIR . '/functions/shortcodes.php' );

	/* Load admin functions. */
	if ( is_admin() )
		require_once( THEME_DIR . '/functions/admin.php' );

	/* Add theme support for core framework features. */
	add_theme_support( 'hybrid-core-menus' );
	add_theme_support( 'hybrid-core-sidebars' );
	add_theme_support( 'hybrid-core-widgets' );
	add_theme_support( 'hybrid-core-shortcodes' );
	add_theme_support( 'hybrid-core-post-meta-box' );
	add_theme_support( 'hybrid-core-meta-box-footer' );
	add_theme_support( 'hybrid-core-print-style' );
	add_theme_support( 'hybrid-core-seo' );

	/* Add theme support for extensions. */
	add_theme_support( 'loop-pagination' );
	add_theme_support( 'get-the-image' );
	add_theme_support( 'entry-views' );
	add_theme_support( 'breadcrumb-trail' );

	/* Register custom post types. */
	add_action( 'init', 'news_register_post_types' );

	/* Register sidebars. */
	add_action( 'init', 'news_unregister_sidebars' );
	add_action( 'init', 'news_register_sidebars' );

	/* Register nav menus. */
	add_action( 'init', 'news_register_menus' );

	/* Register shortcodes. */
	add_action( 'init', 'news_register_shortcodes' );

	/* Register new image sizes. */
	add_action( 'init', 'news_register_image_sizes' );

	/* Register additional widgets. */
	add_action( 'widgets_init', 'news_register_widgets' );

	/* Load JavaScript. */
	add_action( 'template_redirect', 'news_enqueue_script' );

	/* Print stylesheet. */
	add_filter( "{$prefix}_print_style", 'news_print_stylesheet' );

	/* Site description. */
	add_action( "{$prefix}_before_menu_secondary", 'hybrid_site_description' );

	/* Header. */
	add_action( "{$prefix}_header", 'hybrid_site_title' );
	add_action( "{$prefix}_header", 'news_get_header_sidebar' );

	/* Hook additional items to the nav menus. */
	add_filter( 'wp_nav_menu', 'news_nav_menu_add_items', 10, 2 );

	/* Breadcrumb trail. */
	add_action( "{$prefix}_open_container", 'breadcrumb_trail' );
	add_filter( 'breadcrumb_trail_args', 'news_breadcrumb_trail_args' );

	/* Add menus to the theme. */
	add_action( "{$prefix}_after_header", 'hybrid_get_primary_menu' );
	add_action( "{$prefix}_before_header", 'news_get_secondary_menu' );
	add_action( "{$prefix}_open_footer", 'news_get_subsidiary_menu' );

	/* Content. */
	add_action( "{$prefix}_singular-post_after_loop", 'news_singular_post_tags' );

	/* Footer. */
	add_action( "{$prefix}_footer", 'hybrid_footer_insert' );

	/* Tag cloud. */
	add_filter( 'wp_tag_cloud', 'news_add_span_to_tag_cloud' );
	add_filter( 'term_links-post_tag', 'news_add_span_to_tag_cloud' );

	/* Embed width/height defaults. */
	add_filter( 'embed_defaults', 'news_embed_defaults' );

	/* Allow all post types to have shortlinks. Do this early so plugins can still override. */
	add_filter( 'get_shortlink', 'news_filter_shortlink', 1, 3 );
}

/**
 * Registers additional image sizes, in particular, the 'news-thumbnail' and 'news-slideshow' sizes.
 *
 * @since 0.1.0
 */
function news_register_image_sizes() {
	add_image_size( 'news-slideshow', 600, 400, true );
	add_image_size( 'news-thumbnail', 100, 75, true );
}

/**
 * Unregisters default sidebars.
 *
 * @since 0.1.0
 */
function news_unregister_sidebars() {
	unregister_sidebar( 'subsidiary' );
	unregister_sidebar( 'before-content' );
	unregister_sidebar( 'after-content' );
}

/**
 * Registers additional sidebars.
 *
 * @since 0.1.0
 */
function news_register_sidebars() {
	register_sidebar( array( 'name' => __( 'Utility: Header', hybrid_get_textdomain() ), 'id' => 'header', 'description' => __( 'The header widget area.', hybrid_get_textdomain() ), 'before_widget' => '<div id="%1$s" class="widget %2$s widget-%2$s"><div class="widget-inside">', 'after_widget' => '</div></div>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) );
}

/**
 * Register additional menus.
 *
 * @since 0.1.0
 */
function news_register_menus() {
	register_nav_menus(
		array(
			'secondary-menu' => __( 'Secondary Menu', hybrid_get_textdomain() ),
			'footer-menu' => __( 'Subsidiary Menu', hybrid_get_textdomain() )
		)
	);
}

/**
 * Loads extra widget files and registers the widgets.
 * 
 * @since 0.1.0
 */
function news_register_widgets() {

	/* Load the popular tabs widget. */
	if ( current_theme_supports( 'entry-views' ) ) {
		require_once( THEME_DIR . '/classes/widget-popular-tabs.php' );
		register_widget( 'News_Widget_Popular_Tabs' );
	}

	/* Load the image stream widget. */
	require_once( THEME_DIR . '/classes/widget-image-stream.php' );
	register_widget( 'News_Widget_Image_Stream' );

	/* Load the newsletter widget. */
	require_once( THEME_DIR . '/classes/widget-newsletter.php' );
	register_widget( 'News_Widget_Newsletter' );
}

/**
 * Loads the theme JavaScript files.
 *
 * WordPress 3.0 doesn't use the most up-to-date version of jQuery UI, which separates the Widget 
 * Factory out of UI Core into its own file.  And, Widget Factory is not dependent on UI Core to work.
 * In WordPress 3.1, we should be able to just use the built-in UI Tabs in WP, but for now, let's use a
 * custom file and not overwrite what WP's doing so we don't conflict with plugins.  This shouldn't 
 * conflict with other plugins using UI Tabs.
 *
 * @since 0.1.0
 */
function news_enqueue_script() {
	wp_enqueue_script( 'jquery-ui-widget', THEME_URI . '/js/ui.widget.js', array( 'jquery' ), 0.1, true );
	wp_enqueue_script( 'jquery-ui-news-tabs', THEME_URI . '/js/ui.tabs.js', array( 'jquery-ui-widget' ), 0.1, true );
	wp_enqueue_script( 'news-theme', THEME_URI . '/js/news-theme.js', array( 'jquery' ), 0.1, true );
}

/**
 * Returns the URL to the print stylesheet.
 *
 * @since 0.1.0
 */
function news_print_stylesheet( $stylesheet ) {
	return THEME_URI . '/css/print.css';
}

/**
 * Loads the header sidebar.
 *
 * @since 0.1.0
 */
function news_get_header_sidebar() {
	get_sidebar( 'header' );
}

/**
 * Loads the Secondary Menu.
 *
 * @since 0.1.0
 */
function news_get_secondary_menu() {
	locate_template( array( 'menu-secondary.php', 'menu.php' ), true );
}

/**
 * Loads the Subsidiary Menu.
 *
 * @since 0.1.0
 */
function news_get_subsidiary_menu() {
	locate_template( array( 'menu-footer.php', 'menu.php' ), true );
}

/**
 * Adds a log in/out link to the secondary menu.
 *
 * @since 0.1.0
 */
function news_nav_menu_add_items( $menu, $args ) {

	if ( 'secondary-menu' == $args->theme_location ) {
		$links = '<li class="loginout">' . wp_loginout( site_url( esc_url( $_SERVER['REQUEST_URI'] ) ), false ) . '</li>';
		$menu = str_replace( '</ul></div>', $links . '</ul></div>', $menu );
	}

	return $menu;
}

/**
 * Filters the breadcrumb trail arguments.
 *
 * @since 0.1.0
 */
function news_breadcrumb_trail_args( $args ) {
	$args['before'] = '<span class="breadcrumb-title">' . __( 'Browsing:', hybrid_get_textdomain() ) . '</span> <span class="sep">/</span>';
	return $args;
}

/**
 * Displays the post tags for singular posts.
 *
 * @since 0.1.0
 */
function news_singular_post_tags() {
	echo '<div class="entry-tags">' . do_shortcode( '[entry-terms type="post_tag" separator=""]' ) . '</div>';
}

/**
 * Wraps tag cloud links with a span for easier background image styling.
 *
 * @todo If anyone can figure out a way to style this without the <span>, we can remove this.
 *
 * @since 0.1.0
 */
function news_add_span_to_tag_cloud( $cloud ) {
	$cloud = preg_replace( "/>(.*?)<\/a>/", "><span>$1</span></a>", $cloud );
	return $cloud;
}

/**
 * Filters 'get_shortlink' because WordPress only creates shortlinks for the 'post' post type. We need
 * a shortlink for pages and attachments.  Note that this doesn't handle custom post types since we 
 * wouldn't really be making them "short" anyway.  Most users looking for good shortlink solutions should
 * use a shortlink plugin, especially when dealing with custom post types.
 *
 * @since 0.1.0
 */
function news_filter_shortlink( $shortlink, $id, $context ) {
	global $wp_query;

	$post = get_post( $id );

	if ( 'page' == $post->post_type )
		$shortlink = home_url( "?page_id={$id}" );

	elseif ( 'attachment' == $post->post_type )
		$shortlink = home_url( "?attachment_id={$id}" );

	return $shortlink;
}

/**
 * Overwrites the default widths for embeds.  This is especially useful for making sure videos properly
 * expand the full width on video pages.
 *
 * @since 0.1.0
 */
function news_embed_defaults( $args ) {
	if ( is_singular( 'video' ) || is_singular( 'slideshow' ) )
		$args['width'] = 640;
	else
		$args['width'] = 600;

	return $args;
}

/**
 * Registers custom post types for the theme.  We're registering the Video and Slideshow post types.
 *
 * @since 0.1.0
 */
function news_register_post_types() {

	$domain = hybrid_get_textdomain();
	$prefix = hybrid_get_prefix();

	/* Labels for the video post type. */
	$video_labels = array(
		'name' => __( 'Videos', $domain ),
		'singular_name' => __( 'Video', $domain ),
		'add_new' => __( 'Add New', $domain ),
		'add_new_item' => __( 'Add New Video', $domain ),
		'edit' => __( 'Edit', $domain ),
		'edit_item' => __( 'Edit Video', $domain ),
		'new_item' => __( 'New Video', $domain ),
		'view' => __( 'View Video', $domain ),
		'view_item' => __( 'View Video', $domain ),
		'search_items' => __( 'Search Videos', $domain ),
		'not_found' => __( 'No videos found', $domain ),
		'not_found_in_trash' => __( 'No videos found in Trash', $domain ),
	);

	/* Arguments for the video post type. */
	$video_args = array(
		'labels' => $video_labels,
		'capability_type' => 'post',
		'public' => true,
		'can_export' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'videos', 'with_front' => false ),
		'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'comments', 'trackbacks', "{$prefix}-post-settings", 'entry-views' ),
	);

	/* Labels for the slideshow post type. */
	$slideshow_labels = array(
		'name' => __( 'Slideshows', $domain ),
		'singular_name' => __( 'Slideshow', $domain ),
		'add_new' => __( 'Add New', $domain ),
		'add_new_item' => __( 'Add New Slideshow', $domain ),
		'edit' => __( 'Edit', $domain ),
		'edit_item' => __( 'Edit Slideshow', $domain ),
		'new_item' => __( 'New Slideshow', $domain ),
		'view' => __( 'View Slideshow', $domain ),
		'view_item' => __( 'View Slideshow', $domain ),
		'search_items' => __( 'Search Slideshows', $domain ),
		'not_found' => __( 'No slideshows found', $domain ),
		'not_found_in_trash' => __( 'No slideshows found in Trash', $domain ),
	);

	/* Arguments for the slideshow post type. */
	$slideshow_args = array(
		'labels' => $slideshow_labels,
		'capability_type' => 'post',
		'public' => true,
		'can_export' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'slideshows', 'with_front' => false ),
		'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'comments', 'trackbacks', "{$prefix}-post-settings", 'entry-views' ),
	);

	/* Register the video post type. */
	register_post_type( apply_filters( 'news_video_post_type', 'video' ), apply_filters( 'news_video_post_type_args', $video_args ) );

	/* Register the slideshow post type. */
	register_post_type( apply_filters( 'news_slideshow_post_type', 'slideshow' ), apply_filters( 'news_slideshow_post_type_args', $slideshow_args ) );
}

?>