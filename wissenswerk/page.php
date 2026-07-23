<?php
/**
 * Template für statische Seiten.
 *
 * @package Wissenswerk
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<main id="main" class="site-main">
		<article <?php post_class( 'single-entry' ); ?>>
			<header class="entry-hero entry-hero--compact">
				<div class="container container--narrow">
					<h1 class="entry-hero__title"><?php the_title(); ?></h1>
				</div>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="entry-featured container"><?php the_post_thumbnail( 'wissenswerk-hero' ); ?></figure>
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
