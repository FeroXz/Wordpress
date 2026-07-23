<?php
/**
 * Template Name: Wissens-Wiki
 * Template Post Type: page
 *
 * Wiki-Layout für die Wissenssammlung: fixierte Themen-Seitenleiste mit
 * Suche und Sprungnavigation, im Hauptbereich die nach Themengebieten
 * gegliederten Wissensartikel. Der Seiteninhalt (Block-Editor) erscheint
 * als bearbeitbare Einleitung.
 *
 * @package Wissenswerk
 */

get_header();

$themen = get_terms( array(
	'taxonomy'   => 'wissen_thema',
	'hide_empty' => true,
	'orderby'    => 'name',
	'order'      => 'ASC',
) );

// Artikel ohne Themenzuordnung.
$ohne_thema = new WP_Query( array(
	'post_type'      => 'wissen',
	'posts_per_page' => -1,
	'no_found_rows'  => true,
	'orderby'        => 'title',
	'order'          => 'ASC',
	'tax_query'      => array(
		array(
			'taxonomy' => 'wissen_thema',
			'operator' => 'NOT EXISTS',
		),
	),
) );

while ( have_posts() ) :
	the_post();
	$has_intro = trim( get_the_content() ) !== '';
	?>
	<main id="main" class="site-main">
		<div class="wiki container">

			<!-- Seitenleiste -->
			<button class="wiki__toggle" aria-controls="wikiNav" aria-expanded="false">
				<span aria-hidden="true">☰</span> <?php esc_html_e( 'Inhalt', 'wissenswerk' ); ?>
			</button>

			<aside class="wiki__sidebar" id="wikiNav" aria-label="<?php esc_attr_e( 'Wiki-Navigation', 'wissenswerk' ); ?>">
				<div class="wiki__search">
					<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<input type="search" name="s" placeholder="<?php esc_attr_e( 'Wissen durchsuchen …', 'wissenswerk' ); ?>" aria-label="<?php esc_attr_e( 'Wissen durchsuchen', 'wissenswerk' ); ?>" />
						<input type="hidden" name="post_type" value="wissen" />
					</form>
				</div>

				<nav class="wiki__nav" aria-label="<?php esc_attr_e( 'Themengebiete', 'wissenswerk' ); ?>">
					<p class="wiki__nav-title"><?php esc_html_e( 'Themengebiete', 'wissenswerk' ); ?></p>
					<ul class="wiki__toc">
						<?php if ( ! empty( $themen ) && ! is_wp_error( $themen ) ) : ?>
							<?php foreach ( $themen as $thema ) : ?>
								<li>
									<a href="#thema-<?php echo esc_attr( $thema->slug ); ?>">
										<?php echo esc_html( $thema->name ); ?>
										<span class="wiki__count"><?php echo esc_html( $thema->count ); ?></span>
									</a>
								</li>
							<?php endforeach; ?>
						<?php endif; ?>
						<?php if ( $ohne_thema->have_posts() ) : ?>
							<li><a href="#thema-weitere"><?php esc_html_e( 'Weitere Artikel', 'wissenswerk' ); ?></a></li>
						<?php endif; ?>
					</ul>
				</nav>
			</aside>

			<!-- Hauptbereich -->
			<div class="wiki__main">
				<header class="wiki__header">
					<p class="wiki__eyebrow"><?php esc_html_e( 'Wissenssammlung', 'wissenswerk' ); ?></p>
					<h1 class="wiki__title"><?php the_title(); ?></h1>
					<?php if ( $has_intro ) : ?>
						<div class="entry-content wiki__intro"><?php the_content(); ?></div>
					<?php endif; ?>
				</header>

				<?php if ( ( empty( $themen ) || is_wp_error( $themen ) ) && ! $ohne_thema->have_posts() ) : ?>
					<div class="notice-box">
						<p><?php esc_html_e( 'Es sind noch keine Wissensartikel vorhanden.', 'wissenswerk' ); ?></p>
						<?php if ( current_user_can( 'edit_posts' ) ) : ?>
							<a class="btn btn--primary" href="<?php echo esc_url( admin_url( 'post-new.php?post_type=wissen' ) ); ?>"><?php esc_html_e( 'Ersten Artikel anlegen', 'wissenswerk' ); ?></a>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php
				if ( ! empty( $themen ) && ! is_wp_error( $themen ) ) :
					foreach ( $themen as $thema ) :
						$artikel = new WP_Query( array(
							'post_type'      => 'wissen',
							'posts_per_page' => -1,
							'no_found_rows'  => true,
							'orderby'        => 'title',
							'order'          => 'ASC',
							'tax_query'      => array(
								array(
									'taxonomy' => 'wissen_thema',
									'field'    => 'term_id',
									'terms'    => $thema->term_id,
								),
							),
						) );
						if ( ! $artikel->have_posts() ) {
							continue;
						}
						?>
						<section class="wiki__section" id="thema-<?php echo esc_attr( $thema->slug ); ?>">
							<h2 class="wiki__section-title">
								<?php echo esc_html( $thema->name ); ?>
								<a class="wiki__section-all" href="<?php echo esc_url( get_term_link( $thema ) ); ?>"><?php esc_html_e( 'Alle ansehen', 'wissenswerk' ); ?> &rarr;</a>
							</h2>
							<?php if ( ! empty( $thema->description ) ) : ?>
								<p class="wiki__section-desc"><?php echo esc_html( $thema->description ); ?></p>
							<?php endif; ?>
							<ul class="wiki__articles">
								<?php
								while ( $artikel->have_posts() ) :
									$artikel->the_post();
									?>
									<li class="wiki__article">
										<a href="<?php the_permalink(); ?>">
											<span class="wiki__article-title"><?php the_title(); ?></span>
											<span class="wiki__article-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></span>
										</a>
									</li>
									<?php
								endwhile;
								wp_reset_postdata();
								?>
							</ul>
						</section>
						<?php
					endforeach;
				endif;
				?>

				<?php if ( $ohne_thema->have_posts() ) : ?>
					<section class="wiki__section" id="thema-weitere">
						<h2 class="wiki__section-title"><?php esc_html_e( 'Weitere Artikel', 'wissenswerk' ); ?></h2>
						<ul class="wiki__articles">
							<?php
							while ( $ohne_thema->have_posts() ) :
								$ohne_thema->the_post();
								?>
								<li class="wiki__article">
									<a href="<?php the_permalink(); ?>">
										<span class="wiki__article-title"><?php the_title(); ?></span>
										<span class="wiki__article-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></span>
									</a>
								</li>
								<?php
							endwhile;
							wp_reset_postdata();
							?>
						</ul>
					</section>
				<?php endif; ?>
			</div>

		</div>
	</main>
	<?php
endwhile;

get_footer();
