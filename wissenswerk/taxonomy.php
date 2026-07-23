<?php
/**
 * Template für Taxonomie-Archive (Themengebiete, Alben, Rubriken, Schlagworte).
 * Passt die Darstellung an den jeweiligen Post-Type an.
 *
 * @package Wissenswerk
 */

get_header();

$term       = get_queried_object();
$is_gallery = ( isset( $term->taxonomy ) && 'galerie_album' === $term->taxonomy );
?>

<main id="main" class="site-main container">

	<header class="archive-header">
		<p class="archive-header__eyebrow"><?php single_term_title( '', true ); ?></p>
		<h1 class="archive-header__title"><?php echo esc_html( $term->name ); ?></h1>
		<?php if ( ! empty( $term->description ) ) : ?>
			<p class="archive-header__desc"><?php echo esc_html( $term->description ); ?></p>
		<?php endif; ?>
	</header>

	<?php if ( have_posts() ) : ?>

		<?php if ( $is_gallery ) : ?>
			<div class="gallery-grid gallery-grid--archive">
				<?php
				while ( have_posts() ) :
					the_post();
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
				?>
			</div>
		<?php else : ?>
			<div class="card-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					wissenswerk_render_card();
				endwhile;
				?>
			</div>
		<?php endif; ?>

		<?php wissenswerk_pagination(); ?>

	<?php else : ?>
		<p class="no-results"><?php esc_html_e( 'Keine Inhalte in diesem Bereich.', 'wissenswerk' ); ?></p>
	<?php endif; ?>

</main>

<?php
get_footer();
