<?php
/**
 * Header Template
 *
 * The header template is generally used on every page of your site. Nearly all other
 * templates call it somewhere near the top of the file. It is used mostly as an opening
 * wrapper, which is closed with the footer.php file. It also executes key functions needed
 * by the theme, child themes, and plugins. 
 *
 * @package Prototype
 * @subpackage Template
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />

<title><?php hybrid_document_title(); ?></title>

<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="all" />

<?php wp_head(); // WP head hook ?>

</head>

<body class="<?php hybrid_body_class(); ?>">

	<?php do_atomic( 'open_body' ); // Open body hook ?>

	<div id="container">

		<?php get_template_part( 'menu', 'primary' ); ?>

		<?php do_atomic( 'before_header' ); // Before header hook ?>

		<div id="header">

			<?php do_atomic( 'open_header' ); // Open header hook ?>

			<div class="wrap">

				<div id="branding">
					<?php hybrid_site_title(); ?>
					<?php hybrid_site_description(); ?>
				</div>

				<?php get_sidebar( 'header' ); ?>

				<?php do_atomic( 'header' ); // Header hook ?>

			</div><!-- .wrap -->

			<?php do_atomic( 'close_header' ); // Close header hook ?>

		</div><!-- #header -->

		<?php do_atomic( 'after_header' ); // After header hook ?>

		<?php get_template_part( 'menu', 'secondary' ); ?>

		<?php do_atomic( 'before_main' ); // Before main hook ?>

		<div id="main">

			<div class="wrap">

			<?php do_atomic( 'open_main' ); // Open main hook ?>