<?php
/**
 * Archiv der Neuigkeiten.
 *
 * @package Wissenswerk
 */

get_header();
?>

<main id="main" class="site-main container">

	<header class="archive-header">
		<p class="archive-header__eyebrow"><?php esc_html_e( 'Bereich', 'wissenswerk' ); ?></p>
		<h1 class="archive-header__title"><?php esc_html_e( 'Neuigkeiten', 'wissenswerk' ); ?></h1>
		<p class="archive-header__desc"><?php esc_html_e( 'Aktuelles, Ankündigungen und Berichte.', 'wissenswerk' ); ?></p>

		<?php
		$rubriken = get_terms( array( 'taxonomy' => 'neuigkeiten_rubrik', 'hide_empty' => true ) );
		if ( ! empty( $rubriken ) && ! is_wp_error( $rubriken ) ) :
			?>
			<ul class="filter-bar">
				<li><a class="chip chip--active" href="<?php echo esc_url( get_post_type_archive_link( 'neuigkeiten' ) ); ?>"><?php esc_html_e( 'Alle', 'wissenswerk' ); ?></a></li>
				<?php foreach ( $rubriken as $rubrik ) : ?>
					<li><a class="chip" href="<?php echo esc_url( get_term_link( $rubrik ) ); ?>"><?php echo esc_html( $rubrik->name ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="news-list news-list--archive">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article <?php post_class( 'news-item' ); ?>>
					<div class="news-item__date">
						<span class="news-item__day"><?php echo esc_html( get_the_date( 'd' ) ); ?></span>
						<span class="news-item__month"><?php echo esc_html( get_the_date( 'M' ) ); ?></span>
						<span class="news-item__year"><?php echo esc_html( get_the_date( 'Y' ) ); ?></span>
					</div>
					<div class="news-item__body">
						<?php wissenswerk_term_chips( 'neuigkeiten_rubrik' ); ?>
						<h2 class="news-item__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p class="news-item__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 32 ) ); ?></p>
						<a class="news-item__more" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Weiterlesen', 'wissenswerk' ); ?> &rarr;</a>
					</div>
				</article>
				<?php
			endwhile;
			?>
		</div>
		<?php wissenswerk_pagination(); ?>
	<?php else : ?>
		<p class="no-results"><?php esc_html_e( 'Noch keine Neuigkeiten vorhanden.', 'wissenswerk' ); ?></p>
	<?php endif; ?>

</main>

<?php
get_footer();
