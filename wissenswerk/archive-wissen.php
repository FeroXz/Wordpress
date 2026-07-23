<?php
/**
 * Archiv der Wissenssammlung.
 *
 * @package Wissenswerk
 */

get_header();
?>

<main id="main" class="site-main container">

	<header class="archive-header">
		<p class="archive-header__eyebrow"><?php esc_html_e( 'Bereich', 'wissenswerk' ); ?></p>
		<h1 class="archive-header__title"><?php esc_html_e( 'Wissenssammlung', 'wissenswerk' ); ?></h1>
		<p class="archive-header__desc"><?php esc_html_e( 'Fundierte Artikel und Anleitungen – strukturiert nach Themengebieten.', 'wissenswerk' ); ?></p>

		<?php
		$themen = get_terms( array( 'taxonomy' => 'wissen_thema', 'hide_empty' => true ) );
		if ( ! empty( $themen ) && ! is_wp_error( $themen ) ) :
			?>
			<ul class="filter-bar">
				<li><a class="chip chip--active" href="<?php echo esc_url( get_post_type_archive_link( 'wissen' ) ); ?>"><?php esc_html_e( 'Alle', 'wissenswerk' ); ?></a></li>
				<?php foreach ( $themen as $thema ) : ?>
					<li><a class="chip" href="<?php echo esc_url( get_term_link( $thema ) ); ?>"><?php echo esc_html( $thema->name ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<div class="archive-search"><?php get_search_form(); ?></div>
	</header>

	<?php if ( have_posts() ) : ?>
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
		<p class="no-results"><?php esc_html_e( 'Noch keine Wissensartikel vorhanden.', 'wissenswerk' ); ?></p>
	<?php endif; ?>

</main>

<?php
get_footer();
