<?php
/**
 * Einzelansicht einer Neuigkeit.
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
						<a href="<?php echo esc_url( get_post_type_archive_link( 'neuigkeiten' ) ); ?>"><?php esc_html_e( 'Neuigkeiten', 'wissenswerk' ); ?></a>
					</p>
					<?php wissenswerk_term_chips( 'neuigkeiten_rubrik' ); ?>
					<h1 class="entry-hero__title"><?php the_title(); ?></h1>
					<div class="entry-hero__meta"><?php wissenswerk_entry_meta(); ?></div>
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
