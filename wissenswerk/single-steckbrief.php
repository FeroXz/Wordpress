<?php
/**
 * Template Name: Steckbrief (Profil)
 * Template Post Type: post, wissen
 *
 * Profil-Ansicht: Links eine fixierte Karte mit Foto und Eckdaten,
 * rechts der Inhalt. Ideal für Tier-Profile, Personen oder Produkte.
 *
 * @package Wissenswerk
 */

get_header();

while ( have_posts() ) :
	the_post();

	$tax_map  = array(
		'wissen' => 'wissen_thema',
		'post'   => 'category',
	);
	$taxonomy = isset( $tax_map[ get_post_type() ] ) ? $tax_map[ get_post_type() ] : '';
	?>
	<main id="main" class="site-main">
		<article <?php post_class(); ?>>
			<div class="steckbrief container">

				<aside class="steckbrief__aside">
					<div class="steckbrief__photo">
						<?php
						if ( has_post_thumbnail() ) {
							the_post_thumbnail( 'large', array( 'alt' => esc_attr( get_the_title() ) ) );
						} else {
							wissenswerk_placeholder_thumb( get_the_title() );
						}
						?>
					</div>

					<dl class="steckbrief__facts">
						<div class="steckbrief__fact">
							<dt><?php esc_html_e( 'Veröffentlicht', 'wissenswerk' ); ?></dt>
							<dd><time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></dd>
						</div>
						<div class="steckbrief__fact">
							<dt><?php esc_html_e( 'Autor', 'wissenswerk' ); ?></dt>
							<dd><?php the_author(); ?></dd>
						</div>
						<div class="steckbrief__fact">
							<dt><?php esc_html_e( 'Lesezeit', 'wissenswerk' ); ?></dt>
							<dd><?php printf( esc_html__( '%d Min.', 'wissenswerk' ), wissenswerk_reading_time() ); ?></dd>
						</div>
					</dl>

					<?php
					if ( $taxonomy ) {
						wissenswerk_term_chips( $taxonomy );
					}
					wissenswerk_term_chips( 'wissenswerk_tag' );
					?>
				</aside>

				<div class="steckbrief__body">
					<header class="steckbrief__header">
						<h1 class="steckbrief__title"><?php the_title(); ?></h1>
					</header>

					<div class="entry-content">
						<?php
						the_content();
						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_html__( 'Seiten:', 'wissenswerk' ),
							'after'  => '</div>',
						) );
						?>
					</div>

					<?php
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
					?>
				</div>

			</div>
		</article>
	</main>
	<?php
endwhile;

get_footer();
