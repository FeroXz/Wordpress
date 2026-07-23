<?php
/**
 * Angepasstes Suchformular.
 *
 * @package Wissenswerk
 */

$unique_id = wp_unique_id( 'search-form-' );
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo esc_attr( $unique_id ); ?>" class="screen-reader-text"><?php esc_html_e( 'Suchen nach:', 'wissenswerk' ); ?></label>
	<input
		type="search"
		id="<?php echo esc_attr( $unique_id ); ?>"
		class="search-field"
		placeholder="<?php esc_attr_e( 'Suchen …', 'wissenswerk' ); ?>"
		value="<?php echo get_search_query(); ?>"
		name="s"
	/>
	<button type="submit" class="search-submit">
		<span class="screen-reader-text"><?php esc_html_e( 'Suchen', 'wissenswerk' ); ?></span>
		<span aria-hidden="true">🔍</span>
	</button>
</form>
