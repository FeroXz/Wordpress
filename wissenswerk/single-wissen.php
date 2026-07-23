<?php
/**
 * Einzelansicht eines Wissensartikels.
 *
 * @package Wissenswerk
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<main id="main" class="site-main">
		<article <?php post_class( 'single-entry' ); ?>>

			<header class="entry-hero">
				<div class="container container--narrow">
					<p class="entry-hero__eyebrow">
						<a href="<?php echo esc_url( get_post_type_archive_link( 'wissen' ) ); ?>"><?php esc_html_e( 'Wissenssammlung', 'wissenswerk' ); ?></a>
					</p>
					<h1 class="entry-hero__title"><?php the_title(); ?></h1>
					<div class="entry-hero__meta">
						<?php wissenswerk_entry_meta(); ?>
						<span class="reading-time"><?php printf( esc_html__( '%d Min. Lesezeit', 'wissenswerk' ), wissenswerk_reading_time() ); ?></span>
					</div>
					<?php wissenswerk_term_chips( 'wissen_thema' ); ?>
				</div>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="entry-featured container">
					<?php the_post_thumbnail( 'wissenswerk-hero', array( 'alt' => esc_attr( get_the_title() ) ) ); ?>
				</figure>
			<?php endif; ?>

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
			</div>

		</article>
	</main>
	<?php
endwhile;

get_footer();
