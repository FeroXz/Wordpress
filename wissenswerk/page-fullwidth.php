<?php
/**
 * Template Name: Volle Breite
 *
 * Seite ohne schmale Inhaltsspalte: Der Inhalt nutzt die volle
 * Container-Breite, „Weite Breite"- und „Volle Breite"-Blöcke
 * brechen zusätzlich aus.
 *
 * @package Wissenswerk
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<main id="main" class="site-main">
		<article <?php post_class( 'single-entry' ); ?>>
			<header class="page-hero">
				<div class="container">
					<h1 class="page-hero__title"><?php the_title(); ?></h1>
				</div>
			</header>

			<div class="container">
				<div class="entry-content entry-content--wide">
					<?php
					the_content();
					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Seiten:', 'wissenswerk' ),
						'after'  => '</div>',
					) );
					?>
				</div>
			</div>
		</article>
	</main>
	<?php
endwhile;

get_footer();
