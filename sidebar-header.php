<?php
/**
 * After Singular Sidebar Template
 *
 * The After Singular sidebar template houses the HTML used for the 'Utility: After Singular' 
 * sidebar.  If widgets are present, they will be displayed.
 *
 * @package Prototype
 * @subpackage Template
 */

if ( is_active_sidebar( 'header' ) ) : ?>

	<div id="sidebar-header" class="sidebar utility">

		<?php dynamic_sidebar( 'header' ); ?>

	</div><!-- #sidebar-header .utility -->

<?php endif; ?>