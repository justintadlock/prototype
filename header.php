<?php
/**
 * Header Template
 *
 * The header template is generally used on every page of your site. Nearly all other
 * templates call it somewhere near the top of the file. It is used mostly as an opening
 * wrapper, which is closed with the footer.php file. It also executes key functions needed
 * by the theme, child themes, and plugins. 
 *
 * @package News
 * @subpackage Template
 */

hybrid_doctype(); ?>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes( 'xhtml' ); ?>>
<head profile="<?php hybrid_profile_uri(); ?>">
<title><?php hybrid_document_title(); ?></title>

<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen" />

<?php do_atomic( 'head' ); // Head hook ?>
<?php wp_head(); // WP head hook ?>

</head>

<body class="<?php hybrid_body_class(); ?>">

	<?php do_atomic( 'before_html' ); // Before HTML hook ?>

	<div id="body-container">

		<?php do_atomic( 'before_header' ); // Before header hook ?>

		<div id="header">

			<?php do_atomic( 'open_header' ); // Open header hook ?>

			<div class="wrap">

				<?php do_atomic( 'header' ); // Header hook ?>

			</div><!-- .wrap -->

			<?php do_atomic( 'close_header' ); // Close header hook ?>

		</div><!-- #header -->

		<?php do_atomic( 'after_header' ); // After header hook ?>

		<?php do_atomic( 'before_container' ); // Before container hook ?>

		<div id="container">

			<div class="wrap">

			<?php do_atomic( 'open_container' ); // Open container hook ?>