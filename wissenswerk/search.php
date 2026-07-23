<?php
/**
 * Suchergebnis-Template.
 *
 * @package Wissenswerk
 */

get_header();
?>

<main id="main" class="site-main container">

	<header class="archive-header">
		<h1 class="archive-header__title">
			<?php
			/* translators: %s: Suchbegriff. */
			printf( esc_html__( 'Suchergebnisse für: %s', 'wissenswerk' ), '<span>' . esc_html( get_search_query() ) . '</span>' );
			?>
		</h1>
		<div class="archive-search"><?php get_search_form(); ?></div>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="card-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				$type_obj = get_post_type_object( get_post_type() );
				$badge    = $type_obj ? $type_obj->labels->singular_name : '';
				wissenswerk_render_card( $badge );
			endwhile;
			?>
		</div>
		<?php wissenswerk_pagination(); ?>
	<?php else : ?>
		<div class="no-results">
			<p><?php esc_html_e( 'Keine Ergebnisse gefunden. Bitte versuche es mit anderen Suchbegriffen.', 'wissenswerk' ); ?></p>
		</div>
	<?php endif; ?>

</main>

<?php
get_footer();
