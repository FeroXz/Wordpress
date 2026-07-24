<?php
/**
 * Template Name: Leere Leinwand (ohne Titel)
 *
 * Zeigt ausschließlich den Block-Inhalt – ohne Seitentitel und ohne
 * Inhaltsspalte. Ideal, um eigene Landingpages komplett im
 * Block-Editor zu gestalten: Normale Blöcke bleiben angenehm schmal,
 * „Weite Breite" und „Volle Breite" brechen gezielt aus.
 *
 * @package Wissenswerk
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<main id="main" class="site-main site-main--flush">
		<article <?php post_class(); ?>>
			<div class="canvas-content">
				<?php the_content(); ?>
			</div>
		</article>
	</main>
	<?php
endwhile;

get_footer();
