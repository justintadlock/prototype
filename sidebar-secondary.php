<?php
/**
 * Secondary Sidebar Template
 *
 * The Secondary sidebar template houses the HTML used for the 'Secondary' sidebar.
 * It will first check if the sidebar is active before displaying anything.
 *
 * @package Prototype
 * @subpackage Template
 */

if ( is_active_sidebar( 'secondary' ) ) : ?>

	<?php do_atomic( 'before_sidebar_secondary' ); // Before secondary sidebar hook ?>

	<div id="sidebar-secondary" class="sidebar aside">

		<?php do_atomic( 'open_sidebar_secondary' ); // Open secondary sidebar hook ?>

		<?php dynamic_sidebar( 'secondary' ); ?>

		<?php do_atomic( 'close_sidebar_secondary' ); // Close secondary sidebar hook ?>

	</div><!-- #sidebar-secondary .aside -->

	<?php do_atomic( 'after_sidebar_secondary' ); // After secondary sidebar hook ?>

<?php endif; ?>