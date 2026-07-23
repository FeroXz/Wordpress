<?php
/**
 * Template für 404-Fehler (Seite nicht gefunden).
 *
 * @package Wissenswerk
 */

get_header();
?>

<main id="main" class="site-main container">
	<div class="error-404 no-results">
		<p class="error-404__code">404</p>
		<h1 class="error-404__title"><?php esc_html_e( 'Seite nicht gefunden', 'wissenswerk' ); ?></h1>
		<p><?php esc_html_e( 'Die angeforderte Seite existiert nicht oder wurde verschoben.', 'wissenswerk' ); ?></p>
		<div class="archive-search"><?php get_search_form(); ?></div>
		<div class="hero__actions" style="justify-content:center;margin-top:1.5rem;">
			<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Zur Startseite', 'wissenswerk' ); ?></a>
		</div>
	</div>
</main>

<?php
get_footer();
