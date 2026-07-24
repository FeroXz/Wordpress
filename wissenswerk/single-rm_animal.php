<?php
/**
 * Einzelansicht eines Tieres (Reptilien-Manager-Plugin).
 *
 * Der Inhalt (Steckbrief-Tabelle, Galerie, Verpaarungen usw.) wird vom
 * Plugin über dessen Beitrags-Vorlagen erzeugt; dieses Template liefert
 * den passenden Theme-Rahmen: Kopfbereich mit Art, Badges und Navigation
 * sowie verwandte Tiere derselben Art.
 *
 * @package Wissenswerk
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<main id="main" class="site-main">
		<article <?php post_class( 'single-entry animal-single' ); ?>>

			<header class="entry-hero">
				<div class="container container--narrow">
					<p class="entry-hero__eyebrow">
						<a href="<?php echo esc_url( get_post_type_archive_link( 'rm_animal' ) ); ?>"><?php esc_html_e( 'Unsere Tiere', 'wissenswerk' ); ?></a>
					</p>
					<h1 class="entry-hero__title"><?php the_title(); ?></h1>
					<?php wissenswerk_animal_badges(); ?>
					<?php wissenswerk_term_chips( 'rm_species' ); ?>
				</div>
			</header>

			<div class="container container--narrow">
				<div class="entry-content">
					<?php the_content(); ?>
				</div>

				<nav class="entry-nav">
					<?php
					$prev = get_previous_post();
					$next = get_next_post();
					if ( $prev ) {
						echo '<a class="entry-nav__link entry-nav__link--prev" href="' . esc_url( get_permalink( $prev ) ) . '"><span>&larr; ' . esc_html__( 'Vorheriges Tier', 'wissenswerk' ) . '</span>' . esc_html( get_the_title( $prev ) ) . '</a>';
					}
					if ( $next ) {
						echo '<a class="entry-nav__link entry-nav__link--next" href="' . esc_url( get_permalink( $next ) ) . '"><span>' . esc_html__( 'Nächstes Tier', 'wissenswerk' ) . ' &rarr;</span>' . esc_html( get_the_title( $next ) ) . '</a>';
					}
					?>
				</nav>
			</div>

			<?php
			// Weitere Tiere derselben Art.
			$species = wp_get_post_terms( get_the_ID(), 'rm_species', array( 'fields' => 'ids' ) );
			if ( ! empty( $species ) && ! is_wp_error( $species ) ) :
				$related = new WP_Query( array(
					'post_type'      => 'rm_animal',
					'posts_per_page' => 3,
					'post__not_in'   => array( get_the_ID() ),
					'no_found_rows'  => true,
					'orderby'        => 'rand',
					'tax_query'      => array(
						array(
							'taxonomy' => 'rm_species',
							'field'    => 'term_id',
							'terms'    => $species,
						),
					),
				) );
				if ( $related->have_posts() ) :
					?>
					<section class="container related-animals">
						<div class="section-head">
							<h2 class="section-head__title"><?php esc_html_e( 'Weitere Tiere dieser Art', 'wissenswerk' ); ?></h2>
							<a class="section-head__all" href="<?php echo esc_url( get_post_type_archive_link( 'rm_animal' ) ); ?>"><?php esc_html_e( 'Alle Tiere', 'wissenswerk' ); ?> &rarr;</a>
						</div>
						<div class="card-grid">
							<?php
							while ( $related->have_posts() ) :
								$related->the_post();
								wissenswerk_render_animal_card();
							endwhile;
							wp_reset_postdata();
							?>
						</div>
					</section>
					<?php
				endif;
			endif;
			?>

		</article>
	</main>
	<?php
endwhile;

get_footer();
