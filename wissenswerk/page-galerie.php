<?php
/**
 * Template Name: Galerie-Seite
 * Template Post Type: page
 *
 * Bearbeitbare Seite mit filterbarer Galerie (nach Alben) und Lightbox.
 * Der Seiteninhalt aus dem Block-Editor wird als Einleitung angezeigt;
 * darunter erscheint automatisch das Bildraster aller Galerie-Einträge.
 *
 * @package Wissenswerk
 */

get_header();

while ( have_posts() ) :
	the_post();
	$has_intro = trim( get_the_content() ) !== '';
	?>
	<main id="main" class="site-main">

		<header class="page-hero">
			<div class="container container--narrow">
				<p class="page-hero__eyebrow"><?php esc_html_e( 'Galerie', 'wissenswerk' ); ?></p>
				<h1 class="page-hero__title"><?php the_title(); ?></h1>
				<?php if ( $has_intro ) : ?>
					<div class="page-hero__intro entry-content"><?php the_content(); ?></div>
				<?php endif; ?>
			</div>
		</header>

		<div class="container">
			<?php
			$alben = get_terms( array( 'taxonomy' => 'galerie_album', 'hide_empty' => true ) );
			if ( ! empty( $alben ) && ! is_wp_error( $alben ) ) :
				?>
				<div class="gallery-filter" role="tablist" aria-label="<?php esc_attr_e( 'Nach Album filtern', 'wissenswerk' ); ?>">
					<button class="chip chip--active" data-filter="*" role="tab" aria-selected="true"><?php esc_html_e( 'Alle', 'wissenswerk' ); ?></button>
					<?php foreach ( $alben as $album ) : ?>
						<button class="chip" data-filter="album-<?php echo esc_attr( $album->slug ); ?>" role="tab" aria-selected="false"><?php echo esc_html( $album->name ); ?></button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php
			$gallery = new WP_Query( array(
				'post_type'      => 'galerie',
				'posts_per_page' => -1,
				'no_found_rows'  => true,
			) );

			if ( $gallery->have_posts() ) :
				?>
				<div class="masonry" id="galleryGrid">
					<?php
					while ( $gallery->have_posts() ) :
						$gallery->the_post();

						// Album-Slugs für den Filter sammeln.
						$post_albums = wp_get_post_terms( get_the_ID(), 'galerie_album', array( 'fields' => 'slugs' ) );
						$filter_data = array();
						foreach ( (array) $post_albums as $slug ) {
							$filter_data[] = 'album-' . $slug;
						}
						$full_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
						?>
						<figure class="masonry__item" data-albums="<?php echo esc_attr( implode( ' ', $filter_data ) ); ?>">
							<a class="masonry__link js-lightbox"
								href="<?php echo esc_url( $full_url ? $full_url : get_permalink() ); ?>"
								data-full="<?php echo esc_url( $full_url ); ?>"
								data-caption="<?php echo esc_attr( get_the_title() ); ?>"
								data-permalink="<?php the_permalink(); ?>">
								<?php
								if ( has_post_thumbnail() ) {
									the_post_thumbnail( 'wissenswerk-gallery', array( 'loading' => 'lazy', 'alt' => esc_attr( get_the_title() ) ) );
								} else {
									wissenswerk_placeholder_thumb( get_the_title() );
								}
								?>
								<figcaption class="masonry__caption">
									<span class="masonry__title"><?php the_title(); ?></span>
									<span class="masonry__zoom" aria-hidden="true">⤢</span>
								</figcaption>
							</a>
						</figure>
						<?php
					endwhile;
					wp_reset_postdata();
					?>
				</div>

				<p class="gallery-empty" id="galleryEmpty" hidden><?php esc_html_e( 'Keine Bilder in diesem Album.', 'wissenswerk' ); ?></p>

			<?php else : ?>
				<div class="notice-box">
					<p><?php esc_html_e( 'Es sind noch keine Galerie-Einträge vorhanden.', 'wissenswerk' ); ?></p>
					<?php if ( current_user_can( 'edit_posts' ) ) : ?>
						<a class="btn btn--primary" href="<?php echo esc_url( admin_url( 'post-new.php?post_type=galerie' ) ); ?>"><?php esc_html_e( 'Ersten Eintrag anlegen', 'wissenswerk' ); ?></a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>

	</main>

	<!-- Lightbox -->
	<div class="lightbox" id="lightbox" aria-hidden="true" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Bildansicht', 'wissenswerk' ); ?>">
		<button class="lightbox__close" aria-label="<?php esc_attr_e( 'Schließen', 'wissenswerk' ); ?>">&times;</button>
		<button class="lightbox__nav lightbox__nav--prev" aria-label="<?php esc_attr_e( 'Vorheriges Bild', 'wissenswerk' ); ?>">&#8249;</button>
		<figure class="lightbox__stage">
			<img class="lightbox__img" src="" alt="" />
			<figcaption class="lightbox__caption"></figcaption>
		</figure>
		<button class="lightbox__nav lightbox__nav--next" aria-label="<?php esc_attr_e( 'Nächstes Bild', 'wissenswerk' ); ?>">&#8250;</button>
	</div>
	<?php
endwhile;

get_footer();
