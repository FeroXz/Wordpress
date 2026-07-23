<?php
/**
 * Kopfbereich des Themes.
 *
 * @package Wissenswerk
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<script>document.documentElement.classList.add('has-js');</script>

<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Zum Inhalt springen', 'wissenswerk' ); ?></a>

<header class="site-header" id="top">
	<div class="site-header__inner">
		<div class="site-branding">
			<?php
			if ( has_custom_logo() ) {
				the_custom_logo();
			} else {
				if ( is_front_page() && is_home() ) {
					echo '<h1 class="site-title"><a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . esc_html( get_bloginfo( 'name' ) ) . '</a></h1>';
				} else {
					echo '<p class="site-title"><a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . esc_html( get_bloginfo( 'name' ) ) . '</a></p>';
				}
				$description = get_bloginfo( 'description', 'display' );
				if ( $description ) {
					echo '<p class="site-description">' . esc_html( $description ) . '</p>';
				}
			}
			?>
		</div>

		<button class="nav-toggle" aria-controls="primary-menu" aria-expanded="false">
			<span class="nav-toggle__bar"></span>
			<span class="screen-reader-text"><?php esc_html_e( 'Menü umschalten', 'wissenswerk' ); ?></span>
		</button>

		<nav class="main-navigation" aria-label="<?php esc_attr_e( 'Hauptmenü', 'wissenswerk' ); ?>">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'container'      => false,
					'menu_class'     => 'nav-menu',
				) );
			} else {
				// Fallback: automatisch auf die Bereiche verlinken.
				echo '<ul id="primary-menu" class="nav-menu">';
				echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Start', 'wissenswerk' ) . '</a></li>';
				echo '<li><a href="' . esc_url( get_post_type_archive_link( 'wissen' ) ) . '">' . esc_html__( 'Wissenssammlung', 'wissenswerk' ) . '</a></li>';
				echo '<li><a href="' . esc_url( get_post_type_archive_link( 'galerie' ) ) . '">' . esc_html__( 'Galerie', 'wissenswerk' ) . '</a></li>';
				echo '<li><a href="' . esc_url( get_post_type_archive_link( 'neuigkeiten' ) ) . '">' . esc_html__( 'Neuigkeiten', 'wissenswerk' ) . '</a></li>';
				echo '</ul>';
			}
			?>
		</nav>

		<button class="theme-toggle" aria-label="<?php esc_attr_e( 'Dunkelmodus umschalten', 'wissenswerk' ); ?>" title="<?php esc_attr_e( 'Dunkelmodus umschalten', 'wissenswerk' ); ?>">
			<span class="theme-toggle__icon" aria-hidden="true">◐</span>
		</button>
	</div>
</header>

<div id="content" class="site-content">
