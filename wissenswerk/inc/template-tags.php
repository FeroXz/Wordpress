<?php
/**
 * Wiederverwendbare Template-Funktionen.
 *
 * @package Wissenswerk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gibt ein Platzhalter-Bild (SVG) aus, wenn kein Beitragsbild vorhanden ist.
 *
 * @param string $label Kurztext für den Platzhalter.
 */
function wissenswerk_placeholder_thumb( $label = '' ) {
	$initial = $label ? esc_html( mb_substr( wp_strip_all_tags( $label ), 0, 1 ) ) : '✦';
	echo '<div class="card__placeholder" aria-hidden="true"><span>' . $initial . '</span></div>';
}

/**
 * Gibt die Metazeile (Datum, Autor) eines Beitrags aus.
 */
function wissenswerk_entry_meta() {
	printf(
		'<div class="entry-meta"><time class="entry-date" datetime="%1$s">%2$s</time><span class="entry-author">%3$s</span></div>',
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() ),
		esc_html( get_the_author() )
	);
}

/**
 * Gibt die Terme einer Taxonomie als Chip-Liste aus.
 *
 * @param string $taxonomy Taxonomie-Slug.
 */
function wissenswerk_term_chips( $taxonomy ) {
	$terms = get_the_terms( get_the_ID(), $taxonomy );
	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return;
	}
	echo '<ul class="chip-list">';
	foreach ( $terms as $term ) {
		printf(
			'<li><a class="chip" href="%1$s">%2$s</a></li>',
			esc_url( get_term_link( $term ) ),
			esc_html( $term->name )
		);
	}
	echo '</ul>';
}

/**
 * Geschätzte Lesezeit eines Beitrags in Minuten.
 *
 * @return int
 */
function wissenswerk_reading_time() {
	$words   = str_word_count( wp_strip_all_tags( get_the_content() ) );
	$minutes = max( 1, (int) ceil( $words / 200 ) );
	return $minutes;
}

/**
 * Gibt eine Beitragskarte für Archive und die Startseite aus.
 *
 * @param string $badge Optionaler Badge-Text (z. B. Bereichsname).
 */
function wissenswerk_render_card( $badge = '' ) {
	?>
	<article <?php post_class( 'card' ); ?>>
		<a class="card__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
			<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'wissenswerk-card', array( 'loading' => 'lazy', 'alt' => '' ) );
			} else {
				wissenswerk_placeholder_thumb( get_the_title() );
			}
			if ( $badge ) {
				echo '<span class="card__badge">' . esc_html( $badge ) . '</span>';
			}
			?>
		</a>
		<div class="card__body">
			<h3 class="card__title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h3>
			<p class="card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
			<div class="card__footer">
				<?php wissenswerk_entry_meta(); ?>
			</div>
		</div>
	</article>
	<?php
}

/**
 * Holt aktuelle Beiträge eines Post Types.
 *
 * @param string $post_type Post-Type-Slug.
 * @param int    $count     Anzahl.
 * @return WP_Query
 */
function wissenswerk_get_recent( $post_type, $count = 3 ) {
	return new WP_Query( array(
		'post_type'           => $post_type,
		'posts_per_page'      => $count,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	) );
}

/**
 * Numerische Beitragsnavigation für Archive.
 */
function wissenswerk_pagination() {
	the_posts_pagination( array(
		'mid_size'           => 1,
		'prev_text'          => __( '&larr; Zurück', 'wissenswerk' ),
		'next_text'          => __( 'Weiter &rarr;', 'wissenswerk' ),
		'screen_reader_text' => __( 'Beitragsnavigation', 'wissenswerk' ),
	) );
}
