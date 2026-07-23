<?php
/**
 * Startseite mit Hero und den drei Themenbereichen.
 *
 * @package Wissenswerk
 */

get_header();

$hero_title    = get_theme_mod( 'wissenswerk_hero_title', __( 'Wissen, das bleibt.', 'wissenswerk' ) );
$hero_subtitle = get_theme_mod( 'wissenswerk_hero_subtitle', __( 'Eine kuratierte Sammlung aus Wissen, Bildern und Neuigkeiten – an einem Ort.', 'wissenswerk' ) );
?>

<main id="main" class="site-main">

	<!-- Hero -->
	<section class="hero">
		<div class="hero__inner container">
			<p class="hero__eyebrow"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></p>
			<h1 class="hero__title"><?php echo esc_html( $hero_title ); ?></h1>
			<p class="hero__subtitle"><?php echo esc_html( $hero_subtitle ); ?></p>
			<div class="hero__actions">
				<a class="btn btn--primary" href="<?php echo esc_url( get_post_type_archive_link( 'wissen' ) ); ?>"><?php esc_html_e( 'Wissenssammlung öffnen', 'wissenswerk' ); ?></a>
				<a class="btn btn--ghost" href="<?php echo esc_url( get_post_type_archive_link( 'galerie' ) ); ?>"><?php esc_html_e( 'Galerie ansehen', 'wissenswerk' ); ?></a>
			</div>
		</div>
	</section>

	<!-- Bereichsübersicht -->
	<section class="areas container">
		<a class="area-card area-card--wissen" href="<?php echo esc_url( get_post_type_archive_link( 'wissen' ) ); ?>">
			<span class="area-card__icon" aria-hidden="true">📚</span>
			<h2 class="area-card__title"><?php esc_html_e( 'Wissenssammlung', 'wissenswerk' ); ?></h2>
			<p class="area-card__text"><?php esc_html_e( 'Fundiertes Wissen, klar strukturiert und durchsuchbar.', 'wissenswerk' ); ?></p>
			<span class="area-card__link"><?php esc_html_e( 'Entdecken', 'wissenswerk' ); ?> &rarr;</span>
		</a>
		<a class="area-card area-card--galerie" href="<?php echo esc_url( get_post_type_archive_link( 'galerie' ) ); ?>">
			<span class="area-card__icon" aria-hidden="true">🖼️</span>
			<h2 class="area-card__title"><?php esc_html_e( 'Galerie', 'wissenswerk' ); ?></h2>
			<p class="area-card__text"><?php esc_html_e( 'Eindrücke und Bilder in einer eleganten Ansicht.', 'wissenswerk' ); ?></p>
			<span class="area-card__link"><?php esc_html_e( 'Ansehen', 'wissenswerk' ); ?> &rarr;</span>
		</a>
		<a class="area-card area-card--neuigkeiten" href="<?php echo esc_url( get_post_type_archive_link( 'neuigkeiten' ) ); ?>">
			<span class="area-card__icon" aria-hidden="true">📣</span>
			<h2 class="area-card__title"><?php esc_html_e( 'Neuigkeiten', 'wissenswerk' ); ?></h2>
			<p class="area-card__text"><?php esc_html_e( 'Aktuelles und Ankündigungen auf einen Blick.', 'wissenswerk' ); ?></p>
			<span class="area-card__link"><?php esc_html_e( 'Lesen', 'wissenswerk' ); ?> &rarr;</span>
		</a>
	</section>

	<!-- Wissenssammlung -->
	<?php
	$wissen = wissenswerk_get_recent( 'wissen', 3 );
	if ( $wissen->have_posts() ) :
		?>
		<section class="home-section container">
			<div class="section-head">
				<h2 class="section-head__title"><?php esc_html_e( 'Aus der Wissenssammlung', 'wissenswerk' ); ?></h2>
				<a class="section-head__all" href="<?php echo esc_url( get_post_type_archive_link( 'wissen' ) ); ?>"><?php esc_html_e( 'Alle Artikel', 'wissenswerk' ); ?> &rarr;</a>
			</div>
			<div class="card-grid">
				<?php
				while ( $wissen->have_posts() ) :
					$wissen->the_post();
					wissenswerk_render_card( __( 'Wissen', 'wissenswerk' ) );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</section>
	<?php endif; ?>

	<!-- Galerie -->
	<?php
	$galerie = wissenswerk_get_recent( 'galerie', 6 );
	if ( $galerie->have_posts() ) :
		?>
		<section class="home-section home-section--muted">
			<div class="container">
				<div class="section-head">
					<h2 class="section-head__title"><?php esc_html_e( 'Aus der Galerie', 'wissenswerk' ); ?></h2>
					<a class="section-head__all" href="<?php echo esc_url( get_post_type_archive_link( 'galerie' ) ); ?>"><?php esc_html_e( 'Ganze Galerie', 'wissenswerk' ); ?> &rarr;</a>
				</div>
				<div class="gallery-grid">
					<?php
					while ( $galerie->have_posts() ) :
						$galerie->the_post();
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
			</div>
		</section>
	<?php endif; ?>

	<!-- Neuigkeiten -->
	<?php
	$news = wissenswerk_get_recent( 'neuigkeiten', 3 );
	if ( $news->have_posts() ) :
		?>
		<section class="home-section container">
			<div class="section-head">
				<h2 class="section-head__title"><?php esc_html_e( 'Neuigkeiten', 'wissenswerk' ); ?></h2>
				<a class="section-head__all" href="<?php echo esc_url( get_post_type_archive_link( 'neuigkeiten' ) ); ?>"><?php esc_html_e( 'Alle Neuigkeiten', 'wissenswerk' ); ?> &rarr;</a>
			</div>
			<div class="news-list">
				<?php
				while ( $news->have_posts() ) :
					$news->the_post();
					?>
					<article <?php post_class( 'news-item' ); ?>>
						<div class="news-item__date">
							<span class="news-item__day"><?php echo esc_html( get_the_date( 'd' ) ); ?></span>
							<span class="news-item__month"><?php echo esc_html( get_the_date( 'M' ) ); ?></span>
						</div>
						<div class="news-item__body">
							<h3 class="news-item__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p class="news-item__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 26 ) ); ?></p>
						</div>
					</article>
					<?php
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</section>
	<?php endif; ?>

	<?php
	// Falls die Startseite als statische Seite mit Inhalt genutzt wird.
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			$content = get_the_content();
			if ( trim( $content ) !== '' ) :
				?>
				<section class="home-section container">
					<div class="entry-content"><?php the_content(); ?></div>
				</section>
				<?php
			endif;
		endwhile;
	endif;
	?>

</main>

<?php
get_footer();
