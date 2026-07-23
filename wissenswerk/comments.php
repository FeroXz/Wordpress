<?php
/**
 * Kommentarbereich.
 *
 * @package Wissenswerk
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			$comment_count = get_comments_number();
			printf(
				esc_html( _n( '%s Kommentar', '%s Kommentare', $comment_count, 'wissenswerk' ) ),
				esc_html( number_format_i18n( $comment_count ) )
			);
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments( array(
				'style'      => 'ol',
				'short_ping' => true,
				'avatar_size' => 48,
			) );
			?>
		</ol>

		<?php
		the_comments_navigation( array(
			'prev_text' => __( '&larr; Ältere Kommentare', 'wissenswerk' ),
			'next_text' => __( 'Neuere Kommentare &rarr;', 'wissenswerk' ),
		) );
		?>

	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Kommentare sind geschlossen.', 'wissenswerk' ); ?></p>
	<?php endif; ?>

	<?php
	comment_form( array(
		'title_reply' => __( 'Schreibe einen Kommentar', 'wissenswerk' ),
		'class_submit' => 'btn btn--primary',
	) );
	?>

</div>
