<?php
/**
 * Einzelansicht für Standard-Beiträge.
 *
 * @package Wissenswerk
 */

get_header();
?>

<main id="main" class="site-main">
	<div class="container container--with-sidebar">
		<div class="content-area">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article <?php post_class( 'single-entry' ); ?>>
					<header class="entry-hero entry-hero--compact">
						<h1 class="entry-hero__title"><?php the_title(); ?></h1>
						<div class="entry-hero__meta"><?php wissenswerk_entry_meta(); ?></div>
					</header>

					<?php if ( has_post_thumbnail() ) : ?>
						<figure class="entry-featured"><?php the_post_thumbnail( 'wissenswerk-hero' ); ?></figure>
					<?php endif; ?>

					<div class="entry-content">
						<?php
						the_content();
						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_html__( 'Seiten:', 'wissenswerk' ),
							'after'  => '</div>',
						) );
						?>
					</div>

					<footer class="entry-footer">
						<?php
						the_tags( '<div class="chip-list">', '', '</div>' );
						?>
					</footer>

					<?php
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
					?>
				</article>
				<?php
			endwhile;
			?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</main>

<?php
get_footer();
