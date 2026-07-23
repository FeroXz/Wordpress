<?php
/**
 * Haupt-Template als Fallback für alle Ansichten.
 *
 * @package Wissenswerk
 */

get_header();
?>

<main id="main" class="site-main container">

	<?php if ( have_posts() ) : ?>

		<?php if ( is_home() && ! is_front_page() ) : ?>
			<header class="page-header">
				<h1 class="page-title"><?php single_post_title(); ?></h1>
			</header>
		<?php endif; ?>

		<div class="card-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				wissenswerk_render_card();
			endwhile;
			?>
		</div>

		<?php wissenswerk_pagination(); ?>

	<?php else : ?>

		<div class="no-results">
			<h1><?php esc_html_e( 'Nichts gefunden', 'wissenswerk' ); ?></h1>
			<p><?php esc_html_e( 'Es sind noch keine Inhalte vorhanden.', 'wissenswerk' ); ?></p>
			<?php get_search_form(); ?>
		</div>

	<?php endif; ?>

</main>

<?php
get_footer();
