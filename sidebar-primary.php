<?php
/**
 * Primary Sidebar Template
 *
 * The Primary sidebar template houses the HTML used for the 'Primary' sidebar.
 * It will first check if the sidebar is active before displaying anything.
 *
 * @package Prototype
 * @subpackage Template
 */

if ( is_active_sidebar( 'primary' ) ) : ?>

	<?php do_atomic( 'before_sidebar_primary' ); // Before primary sidebar hook ?>

	<div id="sidebar-primary" class="sidebar aside">

		<?php do_atomic( 'open_sidebar_primary' ); // Open primary sidebar hook ?>

		<?php dynamic_sidebar( 'primary' ); ?>

		<?php do_atomic( 'close_sidebar_primary' ); // Close primary sidebar hook ?>

	</div><!-- #sidebar-primary .aside -->

	<?php do_atomic( 'after_sidebar_primary' ); // After primary sidebar hook ?>

<?php endif; ?>