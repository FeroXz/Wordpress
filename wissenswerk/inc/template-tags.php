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
 * Liefert die URL einer Bild-Option (Customizer) oder einen Platzhalter.
 *
 * @param string $mod         Name der Theme-Mod.
 * @param string $placeholder Dateiname im Ordner assets/images/.
 * @return string Bild-URL.
 */
function wissenswerk_image_url( $mod, $placeholder ) {
	$url = get_theme_mod( $mod, '' );
	if ( empty( $url ) ) {
		$url = WISSENSWERK_URI . '/assets/images/' . $placeholder;
	}
	return $url;
}

/**
 * Gibt Geschlechts-, Alters- und Morph-Badges für ein Tier des
 * Reptilien-Manager-Plugins aus. Ohne aktives Plugin bleiben nur die
 * direkt aus den Metadaten lesbaren Angaben (Geschlecht) übrig.
 *
 * @param int $post_id Beitrags-ID (Standard: aktueller Beitrag).
 */
function wissenswerk_animal_badges( $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	if ( 'rm_animal' !== get_post_type( $post_id ) ) {
		return;
	}

	$badges = array();

	$sex = get_post_meta( $post_id, '_rm_sex', true );
	if ( 'male' === $sex ) {
		$badges[] = '<span class="animal-badge animal-badge--male">&#9794; ' . esc_html__( 'Männlich', 'wissenswerk' ) . '</span>';
	} elseif ( 'female' === $sex ) {
		$badges[] = '<span class="animal-badge animal-badge--female">&#9792; ' . esc_html__( 'Weiblich', 'wissenswerk' ) . '</span>';
	}

	if ( class_exists( 'RM_Animal_Meta' ) ) {
		$birth = get_post_meta( $post_id, '_rm_birth', true );
		if ( $birth ) {
			$age = RM_Animal_Meta::age_label( $birth );
			if ( $age ) {
				$badges[] = '<span class="animal-badge">' . esc_html( $age ) . '</span>';
			}
		}
	}

	if ( class_exists( 'RM_Genetics' ) ) {
		$morph = RM_Genetics::animal_morph_label( $post_id );
		if ( $morph ) {
			$badges[] = '<span class="animal-badge animal-badge--morph">' . esc_html( $morph ) . '</span>';
		}
	}

	if ( $badges ) {
		echo '<div class="animal-badges">' . implode( '', $badges ) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput -- Bereits oben escaped.
	}
}

/**
 * Gibt eine Tier-Karte (Reptilien-Manager) im Theme-Design aus.
 */
function wissenswerk_render_animal_card() {
	$species = get_the_terms( get_the_ID(), 'rm_species' );
	$badge   = ( ! empty( $species ) && ! is_wp_error( $species ) ) ? $species[0]->name : '';
	?>
	<article <?php post_class( 'card animal-card' ); ?>>
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
			<?php wissenswerk_animal_badges(); ?>
		</div>
	</article>
	<?php
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
