<?php
/**
 * Template Name: Cover (großes Titelbild)
 * Template Post Type: post, wissen, neuigkeiten, galerie, rm_animal
 *
 * Immersive Einzelansicht: Das Beitragsbild füllt den Kopfbereich als
 * großflächiges Cover mit Titel-Overlay, darunter folgt schmaler, gut
 * lesbarer Inhalt.
 *
 * @package Wissenswerk
 */

get_header();

while ( have_posts() ) :
	the_post();

	$cover = get_the_post_thumbnail_url( get_the_ID(), 'full' );
	if ( ! $cover ) {
		$cover = WISSENSWERK_URI . '/assets/images/placeholder-hero.svg';
	}

	$tax_map  = array(
		'wissen'      => 'wissen_thema',
		'galerie'     => 'galerie_album',
		'neuigkeiten' => 'neuigkeiten_rubrik',
		'post'        => 'category',
		'rm_animal'   => 'rm_species',
	);
	$taxonomy = isset( $tax_map[ get_post_type() ] ) ? $tax_map[ get_post_type() ] : '';
	?>
	<main id="main" class="site-main site-main--flush">
		<article <?php post_class( 'single-entry' ); ?>>

			<header class="cover-hero" style="background-image:url('<?php echo esc_url( $cover ); ?>');">
				<div class="cover-hero__inner container container--narrow">
					<?php
					if ( $taxonomy ) {
						wissenswerk_term_chips( $taxonomy );
					}
					?>
					<h1 class="cover-hero__title"><?php the_title(); ?></h1>
					<div class="cover-hero__meta">
						<?php wissenswerk_entry_meta(); ?>
						<span class="reading-time"><?php printf( esc_html__( '%d Min. Lesezeit', 'wissenswerk' ), wissenswerk_reading_time() ); ?></span>
					</div>
				</div>
			</header>

			<div class="container container--narrow">
				<div class="entry-content">
					<?php
					the_content();
					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Seiten:', 'wissenswerk' ),
						'after'  => '</div>',
					) );
					?>
				</div>

				<?php wissenswerk_term_chips( 'wissenswerk_tag' ); ?>

				<nav class="entry-nav">
					<?php
					$prev = get_previous_post();
					$next = get_next_post();
					if ( $prev ) {
						echo '<a class="entry-nav__link entry-nav__link--prev" href="' . esc_url( get_permalink( $prev ) ) . '"><span>&larr; ' . esc_html__( 'Vorheriger', 'wissenswerk' ) . '</span>' . esc_html( get_the_title( $prev ) ) . '</a>';
					}
					if ( $next ) {
						echo '<a class="entry-nav__link entry-nav__link--next" href="' . esc_url( get_permalink( $next ) ) . '"><span>' . esc_html__( 'Nächster', 'wissenswerk' ) . ' &rarr;</span>' . esc_html( get_the_title( $next ) ) . '</a>';
					}
					?>
				</nav>

				<?php
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
				?>
			</div>

		</article>
	</main>
	<?php
endwhile;

get_footer();
