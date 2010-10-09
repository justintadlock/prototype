<?php
/**
 * Primary Menu Template
 *
 * Displays the Primary Menu if it has active menu items.
 *
 * @package Prototype
 * @subpackage Template
 */

if ( has_nav_menu( 'primary-menu' ) ) : ?>

	<?php do_atomic( 'before_menu_primary' ); // Before primary menu hook ?>

	<div id="menu-primary" class="menu-container">

		<div class="wrap">

			<?php do_atomic( 'open_menu_primary' ); // Open primary menu hook ?>

			<?php wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container_class' => 'menu', 'menu_class' => '', 'menu_id' => 'menu-primary-items', 'fallback_cb' => '' ) ); ?>

			<?php do_atomic( 'close_menu_primary' ); // Close primary menu hook ?>

		</div>

	</div><!-- #menu-primary .menu-container -->

	<?php do_atomic( 'after_menu_primary' ); // After primary menu hook ?>

<?php endif; ?>