<?php
/**
 * Footer Template
 *
 * The footer template is generally used on every page of your site. Nearly all other
 * templates call it somewhere near the bottom of the file. It is used mostly as a closing
 * wrapper, which is opened with the header.php file. It also executes key functions needed
 * by the theme, child themes, and plugins. 
 *
 * @package News
 * @subpackage Template
 */
?>
			<?php get_sidebar( 'primary' ); ?>

			<?php get_sidebar( 'secondary' ); ?>

			<?php do_atomic( 'close_container' ); // Close container hook ?>

			</div><!-- .wrap -->

		</div><!-- #container -->

		<?php do_atomic( 'after_container' ); // After container hook ?>

		<?php do_atomic( 'before_footer' ); // Before footer hook ?>

		<div id="footer">

			<?php do_atomic( 'open_footer' ); // Open footer hook ?>

			<div class="wrap">

				<?php do_atomic( 'footer' ); // Footer hook ?>

			</div><!-- .wrap -->

			<?php do_atomic( 'close_footer' ); // Close footer hook ?>

		</div><!-- #footer -->

		<?php do_atomic( 'after_footer' ); // After footer hook ?>

	</div><!-- #body-container -->

	<?php wp_footer(); // WordPress footer hook ?>
	<?php do_atomic( 'after_html' ); // After HTML hook ?>

</body>
</html>