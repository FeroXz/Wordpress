<?php
/**
 * Startseite (Landingpage) – vollständig über den Customizer bearbeitbar.
 * Bereich: Design → Customizer → Landingpage.
 *
 * @package Wissenswerk
 */

get_header();

// --- Hero-Einstellungen ---
$hero_eyebrow  = get_theme_mod( 'wissenswerk_hero_eyebrow', '' );
$hero_title    = get_theme_mod( 'wissenswerk_hero_title', __( 'Wissen, das bleibt.', 'wissenswerk' ) );
$hero_subtitle = get_theme_mod( 'wissenswerk_hero_subtitle', __( 'Eine kuratierte Sammlung aus Wissen, Bildern und Neuigkeiten – an einem Ort.', 'wissenswerk' ) );
$hero_style    = get_theme_mod( 'wissenswerk_hero_style', 'dusk' );

$btn1_text = get_theme_mod( 'wissenswerk_hero_btn1_text', __( 'Wissenssammlung öffnen', 'wissenswerk' ) );
$btn1_url  = get_theme_mod( 'wissenswerk_hero_btn1_url', '' );
$btn2_text = get_theme_mod( 'wissenswerk_hero_btn2_text', __( 'Galerie ansehen', 'wissenswerk' ) );
$btn2_url  = get_theme_mod( 'wissenswerk_hero_btn2_url', '' );

if ( '' === $btn1_url ) {
	$btn1_url = get_post_type_archive_link( 'wissen' );
}
if ( '' === $btn2_url ) {
	$btn2_url = get_post_type_archive_link( 'galerie' );
}

$hero_image   = wissenswerk_image_url( 'wissenswerk_hero_image', 'placeholder-hero.svg' );
$hero_overlay = (int) get_theme_mod( 'wissenswerk_hero_overlay', 60 ) / 100;
?>

<main id="main" class="site-main">

	<!-- Hero -->
	<section class="hero hero--image hero--<?php echo esc_attr( $hero_style ); ?>" style="--hero-image:url('<?php echo esc_url( $hero_image ); ?>');--hero-overlay:<?php echo esc_attr( $hero_overlay ); ?>;">
		<div class="hero__bg" aria-hidden="true"></div>
		<div class="hero__orbs" aria-hidden="true"><span></span><span></span><span></span></div>
		<div class="hero__inner container">
			<p class="hero__eyebrow"><?php echo esc_html( $hero_eyebrow ? $hero_eyebrow : get_bloginfo( 'name' ) ); ?></p>
			<h1 class="hero__title"><?php echo esc_html( $hero_title ); ?></h1>
			<?php if ( $hero_subtitle ) : ?>
				<p class="hero__subtitle"><?php echo esc_html( $hero_subtitle ); ?></p>
			<?php endif; ?>
			<div class="hero__actions">
				<?php if ( $btn1_text ) : ?>
					<a class="btn btn--primary" href="<?php echo esc_url( $btn1_url ); ?>"><?php echo esc_html( $btn1_text ); ?></a>
				<?php endif; ?>
				<?php if ( $btn2_text ) : ?>
					<a class="btn btn--ghost" href="<?php echo esc_url( $btn2_url ); ?>"><?php echo esc_html( $btn2_text ); ?></a>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<!-- Bereichs-Kacheln (bild-gefüllt) -->
	<?php if ( get_theme_mod( 'wissenswerk_areas_show', true ) ) : ?>
		<section class="areas container">
			<?php
			$cards = array(
				'wissen'      => array( '📚', 'wissenswerk_area_wissen_title', __( 'Wissenssammlung', 'wissenswerk' ), 'wissenswerk_area_wissen_text', __( 'Fundiertes Wissen, klar strukturiert und durchsuchbar.', 'wissenswerk' ), __( 'Entdecken', 'wissenswerk' ), 'wissenswerk_area_wissen_image', 'placeholder-1.svg' ),
				'galerie'     => array( '🖼️', 'wissenswerk_area_galerie_title', __( 'Galerie', 'wissenswerk' ), 'wissenswerk_area_galerie_text', __( 'Eindrücke und Bilder in einer eleganten Ansicht.', 'wissenswerk' ), __( 'Ansehen', 'wissenswerk' ), 'wissenswerk_area_galerie_image', 'placeholder-2.svg' ),
				'neuigkeiten' => array( '📣', 'wissenswerk_area_neuigkeiten_title', __( 'Neuigkeiten', 'wissenswerk' ), 'wissenswerk_area_neuigkeiten_text', __( 'Aktuelles und Ankündigungen auf einen Blick.', 'wissenswerk' ), __( 'Lesen', 'wissenswerk' ), 'wissenswerk_area_neuigkeiten_image', 'placeholder-3.svg' ),
			);
			foreach ( $cards as $type => $c ) :
				$card_image = wissenswerk_image_url( $c[6], $c[7] );
				?>
				<a class="area-card area-card--<?php echo esc_attr( $type ); ?> reveal" href="<?php echo esc_url( get_post_type_archive_link( $type ) ); ?>" style="--card-image:url('<?php echo esc_url( $card_image ); ?>');">
					<span class="area-card__icon" aria-hidden="true"><?php echo esc_html( $c[0] ); ?></span>
					<h2 class="area-card__title"><?php echo esc_html( get_theme_mod( $c[1], $c[2] ) ); ?></h2>
					<p class="area-card__text"><?php echo esc_html( get_theme_mod( $c[3], $c[4] ) ); ?></p>
					<span class="area-card__link"><?php echo esc_html( $c[5] ); ?> &rarr;</span>
				</a>
			<?php endforeach; ?>
		</section>
	<?php endif; ?>

	<!-- Showcase-Bildmosaik -->
	<?php if ( get_theme_mod( 'wissenswerk_showcase_show', true ) ) : ?>
		<section class="home-section home-section--muted">
			<div class="container">
				<div class="section-head">
					<h2 class="section-head__title"><?php echo esc_html( get_theme_mod( 'wissenswerk_showcase_heading', __( 'Impressionen', 'wissenswerk' ) ) ); ?></h2>
					<a class="section-head__all" href="<?php echo esc_url( get_post_type_archive_link( 'galerie' ) ); ?>"><?php esc_html_e( 'Zur Galerie', 'wissenswerk' ); ?> &rarr;</a>
				</div>
				<div class="mosaic-showcase">
					<?php
					for ( $i = 1; $i <= 6; $i++ ) :
						$img     = wissenswerk_image_url( 'wissenswerk_showcase_' . $i, 'placeholder-' . $i . '.svg' );
						$caption = get_theme_mod( 'wissenswerk_showcase_' . $i . '_caption', '' );
						?>
						<figure class="mosaic-showcase__item reveal" style="background-image:url('<?php echo esc_url( $img ); ?>');">
							<?php if ( $caption ) : ?>
								<figcaption class="mosaic-showcase__caption"><?php echo esc_html( $caption ); ?></figcaption>
							<?php endif; ?>
						</figure>
					<?php endfor; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<!-- Wissenssammlung -->
	<?php
	if ( get_theme_mod( 'wissenswerk_sec_wissen_show', true ) ) :
		$count  = (int) get_theme_mod( 'wissenswerk_sec_wissen_count', 3 );
		$wissen = wissenswerk_get_recent( 'wissen', $count > 0 ? $count : 3 );
		if ( $wissen->have_posts() ) :
			?>
			<section class="home-section container">
				<div class="section-head">
					<h2 class="section-head__title"><?php echo esc_html( get_theme_mod( 'wissenswerk_sec_wissen_heading', __( 'Aus der Wissenssammlung', 'wissenswerk' ) ) ); ?></h2>
					<a class="section-head__all" href="<?php echo esc_url( get_post_type_archive_link( 'wissen' ) ); ?>"><?php esc_html_e( 'Alle Artikel', 'wissenswerk' ); ?> &rarr;</a>
				</div>
				<div class="card-grid">
					<?php
					while ( $wissen->have_posts() ) :
						$wissen->the_post();
						echo '<div class="reveal">';
						wissenswerk_render_card( __( 'Wissen', 'wissenswerk' ) );
						echo '</div>';
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</section>
			<?php
		endif;
	endif;
	?>

	<!-- Unsere Tiere (Reptilien-Manager-Plugin, nur wenn aktiv) -->
	<?php
	if ( post_type_exists( 'rm_animal' ) && get_theme_mod( 'wissenswerk_sec_tiere_show', true ) ) :
		$count = (int) get_theme_mod( 'wissenswerk_sec_tiere_count', 3 );
		$tiere = wissenswerk_get_recent( 'rm_animal', $count > 0 ? $count : 3 );
		if ( $tiere->have_posts() ) :
			?>
			<section class="home-section container">
				<div class="section-head">
					<h2 class="section-head__title"><?php echo esc_html( get_theme_mod( 'wissenswerk_sec_tiere_heading', __( 'Unsere Tiere', 'wissenswerk' ) ) ); ?></h2>
					<a class="section-head__all" href="<?php echo esc_url( get_post_type_archive_link( 'rm_animal' ) ); ?>"><?php esc_html_e( 'Alle Tiere', 'wissenswerk' ); ?> &rarr;</a>
				</div>
				<div class="card-grid">
					<?php
					while ( $tiere->have_posts() ) :
						$tiere->the_post();
						echo '<div class="reveal">';
						wissenswerk_render_animal_card();
						echo '</div>';
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</section>
			<?php
		endif;
	endif;
	?>

	<!-- Galerie -->
	<?php
	if ( get_theme_mod( 'wissenswerk_sec_galerie_show', true ) ) :
		$count   = (int) get_theme_mod( 'wissenswerk_sec_galerie_count', 6 );
		$galerie = wissenswerk_get_recent( 'galerie', $count > 0 ? $count : 6 );
		if ( $galerie->have_posts() ) :
			?>
			<section class="home-section home-section--muted">
				<div class="container">
					<div class="section-head">
						<h2 class="section-head__title"><?php echo esc_html( get_theme_mod( 'wissenswerk_sec_galerie_heading', __( 'Aus der Galerie', 'wissenswerk' ) ) ); ?></h2>
						<a class="section-head__all" href="<?php echo esc_url( get_post_type_archive_link( 'galerie' ) ); ?>"><?php esc_html_e( 'Ganze Galerie', 'wissenswerk' ); ?> &rarr;</a>
					</div>
					<div class="gallery-grid">
						<?php
						while ( $galerie->have_posts() ) :
							$galerie->the_post();
							?>
							<a class="gallery-item reveal" href="<?php the_permalink(); ?>">
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
			<?php
		endif;
	endif;
	?>

	<!-- Neuigkeiten -->
	<?php
	if ( get_theme_mod( 'wissenswerk_sec_neuigkeiten_show', true ) ) :
		$count = (int) get_theme_mod( 'wissenswerk_sec_neuigkeiten_count', 3 );
		$news  = wissenswerk_get_recent( 'neuigkeiten', $count > 0 ? $count : 3 );
		if ( $news->have_posts() ) :
			?>
			<section class="home-section container">
				<div class="section-head">
					<h2 class="section-head__title"><?php echo esc_html( get_theme_mod( 'wissenswerk_sec_neuigkeiten_heading', __( 'Neuigkeiten', 'wissenswerk' ) ) ); ?></h2>
					<a class="section-head__all" href="<?php echo esc_url( get_post_type_archive_link( 'neuigkeiten' ) ); ?>"><?php esc_html_e( 'Alle Neuigkeiten', 'wissenswerk' ); ?> &rarr;</a>
				</div>
				<div class="news-list">
					<?php
					while ( $news->have_posts() ) :
						$news->the_post();
						?>
						<article <?php post_class( 'news-item reveal' ); ?>>
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
			<?php
		endif;
	endif;
	?>

	<?php
	// Falls die Startseite als statische Seite mit Block-Inhalt genutzt wird.
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			if ( trim( get_the_content() ) !== '' ) :
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
