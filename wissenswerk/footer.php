<?php
/**
 * Fußbereich des Themes.
 *
 * @package Wissenswerk
 */

?>
</div><!-- .site-content -->

<footer class="site-footer">
	<div class="site-footer__inner">
		<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
			<div class="footer-widgets">
				<?php dynamic_sidebar( 'footer-1' ); ?>
			</div>
		<?php endif; ?>

		<div class="footer-bottom">
			<div class="footer-brand">
				<span class="footer-brand__name"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
				<?php
				$footer_text = get_theme_mod( 'wissenswerk_footer_text' );
				if ( $footer_text ) {
					echo '<div class="footer-custom-text">' . wp_kses_post( wpautop( $footer_text ) ) . '</div>';
				}
				?>
			</div>

			<?php
			if ( has_nav_menu( 'footer' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'footer',
					'container'      => 'nav',
					'container_class' => 'footer-navigation',
					'menu_class'     => 'footer-menu',
					'depth'          => 1,
				) );
			}
			?>

			<p class="footer-copyright">
				&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?>.
				<?php esc_html_e( 'Alle Rechte vorbehalten.', 'wissenswerk' ); ?>
			</p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
