<?php
/**
 * Archiv der Galerie.
 *
 * @package Wissenswerk
 */

get_header();
?>

<main id="main" class="site-main container">

	<header class="archive-header">
		<p class="archive-header__eyebrow"><?php esc_html_e( 'Bereich', 'wissenswerk' ); ?></p>
		<h1 class="archive-header__title"><?php esc_html_e( 'Galerie', 'wissenswerk' ); ?></h1>
		<p class="archive-header__desc"><?php esc_html_e( 'Bilder und Eindrücke – geordnet nach Alben.', 'wissenswerk' ); ?></p>

		<?php
		$alben = get_terms( array( 'taxonomy' => 'galerie_album', 'hide_empty' => true ) );
		if ( ! empty( $alben ) && ! is_wp_error( $alben ) ) :
			?>
			<ul class="filter-bar">
				<li><a class="chip chip--active" href="<?php echo esc_url( get_post_type_archive_link( 'galerie' ) ); ?>"><?php esc_html_e( 'Alle', 'wissenswerk' ); ?></a></li>
				<?php foreach ( $alben as $album ) : ?>
					<li><a class="chip" href="<?php echo esc_url( get_term_link( $album ) ); ?>"><?php echo esc_html( $album->name ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</header>

	<?php if ( have_posts() ) : ?>
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
		<?php wissenswerk_pagination(); ?>
	<?php else : ?>
		<p class="no-results"><?php esc_html_e( 'Noch keine Galerie-Einträge vorhanden.', 'wissenswerk' ); ?></p>
	<?php endif; ?>

</main>

<?php
get_footer();
