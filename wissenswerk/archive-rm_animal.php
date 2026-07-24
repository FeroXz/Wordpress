<?php
/**
 * Archiv der Tiere (Reptilien-Manager-Plugin, Post Type rm_animal).
 * Tierübersicht im Theme-Design mit Arten-Filter und Badges.
 *
 * @package Wissenswerk
 */

get_header();
?>

<main id="main" class="site-main container">

	<header class="archive-header">
		<p class="archive-header__eyebrow"><?php esc_html_e( 'Bereich', 'wissenswerk' ); ?></p>
		<h1 class="archive-header__title"><?php esc_html_e( 'Unsere Tiere', 'wissenswerk' ); ?></h1>
		<p class="archive-header__desc"><?php esc_html_e( 'Alle Tiere unseres Bestands – mit Art, Geschlecht, Alter und Morph.', 'wissenswerk' ); ?></p>

		<?php
		$arten = get_terms( array( 'taxonomy' => 'rm_species', 'hide_empty' => true ) );
		if ( ! empty( $arten ) && ! is_wp_error( $arten ) ) :
			?>
			<ul class="filter-bar">
				<li><a class="chip chip--active" href="<?php echo esc_url( get_post_type_archive_link( 'rm_animal' ) ); ?>"><?php esc_html_e( 'Alle Arten', 'wissenswerk' ); ?></a></li>
				<?php foreach ( $arten as $art ) : ?>
					<li><a class="chip" href="<?php echo esc_url( get_term_link( $art ) ); ?>"><?php echo esc_html( $art->name ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="card-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				wissenswerk_render_animal_card();
			endwhile;
			?>
		</div>
		<?php wissenswerk_pagination(); ?>
	<?php else : ?>
		<p class="no-results"><?php esc_html_e( 'Noch keine Tiere eingetragen.', 'wissenswerk' ); ?></p>
	<?php endif; ?>

</main>

<?php
get_footer();
