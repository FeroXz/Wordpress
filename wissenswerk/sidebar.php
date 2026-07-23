<?php
/**
 * Seitenleiste.
 *
 * @package Wissenswerk
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>
<aside class="sidebar widget-area" aria-label="<?php esc_attr_e( 'Seitenleiste', 'wissenswerk' ); ?>">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
