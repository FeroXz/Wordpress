<?php
/**
 * Einzelansicht eines Galerie-Eintrags.
 *
 * @package Wissenswerk
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<main id="main" class="site-main">
		<article <?php post_class( 'single-gallery' ); ?>>

			<div class="container container--narrow">
				<p class="entry-hero__eyebrow">
					<a href="<?php echo esc_url( get_post_type_archive_link( 'galerie' ) ); ?>"><?php esc_html_e( 'Galerie', 'wissenswerk' ); ?></a>
				</p>
				<h1 class="entry-hero__title"><?php the_title(); ?></h1>
				<div class="entry-hero__meta"><?php wissenswerk_entry_meta(); ?></div>
				<?php wissenswerk_term_chips( 'galerie_album' ); ?>
			</div>

			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="gallery-hero container">
					<?php the_post_thumbnail( 'full', array( 'alt' => esc_attr( get_the_title() ) ) ); ?>
				</figure>
			<?php endif; ?>

			<div class="container container--narrow">
				<div class="entry-content"><?php the_content(); ?></div>
				<?php wissenswerk_term_chips( 'wissenswerk_tag' ); ?>
			</div>

			<?php
			// Weitere Einträge aus demselben Album.
			$albums = wp_get_post_terms( get_the_ID(), 'galerie_album', array( 'fields' => 'ids' ) );
			if ( ! empty( $albums ) ) :
				$related = new WP_Query( array(
					'post_type'      => 'galerie',
					'posts_per_page' => 6,
					'post__not_in'   => array( get_the_ID() ),
					'no_found_rows'  => true,
					'tax_query'      => array(
						array(
							'taxonomy' => 'galerie_album',
							'field'    => 'term_id',
							'terms'    => $albums,
						),
					),
				) );
				if ( $related->have_posts() ) :
					?>
					<section class="container related-gallery">
						<h2 class="section-head__title"><?php esc_html_e( 'Mehr aus diesem Album', 'wissenswerk' ); ?></h2>
						<div class="gallery-grid">
							<?php
							while ( $related->have_posts() ) :
								$related->the_post();
								?>
								<a class="gallery-item" href="<?php the_permalink(); ?>">
									<?php
									if ( has_post_thumbnail() ) {
										the_post_thumbnail( 'wissenswerk-gallery', array( 'loading' => 'lazy', 'alt' => esc_attr( get_the_title() ) ) );
									} else {
										wissenswerk_placeholder_thumb( get_the_title() );
									}
									?>
									<span class="gallery-item__caption"><?php the_title(); ?></span>
								</a>
								<?php
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
