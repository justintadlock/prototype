<?php
/**
 * secondary Menu Template
 *
 * Displays the secondary Menu if it has active menu items.
 *
 * @package Prototype
 * @subpackage Template
 */

if ( has_nav_menu( 'secondary' ) ) : ?>

	<?php do_atomic( 'before_menu_secondary' ); // Before secondary menu hook ?>

	<div id="menu-secondary" class="menu-container">

		<div class="wrap">

			<?php do_atomic( 'open_menu_secondary' ); // Open secondary menu hook ?>

			<?php wp_nav_menu( array( 'theme_location' => 'secondary', 'container_class' => 'menu', 'menu_class' => '', 'menu_id' => 'menu-secondary-items', 'fallback_cb' => '' ) ); ?>

			<?php do_atomic( 'close_menu_secondary' ); // Close secondary menu hook ?>

		</div>

	</div><!-- #menu-secondary .menu-container -->

	<?php do_atomic( 'after_menu_secondary' ); // After secondary menu hook ?>

<?php endif; ?>