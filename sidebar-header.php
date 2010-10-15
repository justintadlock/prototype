<?php
/**
 * Sidebar Header Template
 *
 * @package Prototype
 * @subpackage Template
 */

if ( is_active_sidebar( 'header' ) ) : ?>

	<div id="sidebar-header" class="sidebar">

		<?php dynamic_sidebar( 'header' ); ?>

	</div><!-- #sidebar-header -->

<?php endif; ?>