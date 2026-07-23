<?php
/**
 * Wissenswerk - zentrale Theme-Funktionen.
 *
 * @package Wissenswerk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direktzugriff verhindern.
}

define( 'WISSENSWERK_VERSION', '1.0.0' );
define( 'WISSENSWERK_DIR', get_template_directory() );
define( 'WISSENSWERK_URI', get_template_directory_uri() );

/**
 * Grundlegende Theme-Unterstützung registrieren.
 */
function wissenswerk_setup() {
	load_theme_textdomain( 'wissenswerk', WISSENSWERK_DIR . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array(
		'height'      => 60,
		'width'       => 220,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/main.css' );

	// Bildgrößen für die Bereiche.
	add_image_size( 'wissenswerk-card', 720, 480, true );
	add_image_size( 'wissenswerk-gallery', 800, 800, true );
	add_image_size( 'wissenswerk-hero', 1600, 900, true );

	register_nav_menus( array(
		'primary' => __( 'Hauptmenü', 'wissenswerk' ),
		'footer'  => __( 'Footer-Menü', 'wissenswerk' ),
	) );
}
add_action( 'after_setup_theme', 'wissenswerk_setup' );

/**
 * Content-Breite für eingebettete Medien setzen.
 */
function wissenswerk_content_width() {
	$GLOBALS['content_width'] = 1200;
}
add_action( 'after_setup_theme', 'wissenswerk_content_width', 0 );

/**
 * Styles und Scripts einbinden.
 */
function wissenswerk_assets() {
	// Web-Schriften (Inter + Merriweather) via Google Fonts.
	wp_enqueue_style(
		'wissenswerk-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Merriweather:wght@400;700&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'wissenswerk-style',
		WISSENSWERK_URI . '/assets/css/main.css',
		array( 'wissenswerk-fonts' ),
		WISSENSWERK_VERSION
	);

	// Der Theme-Header (style.css) für WP-Kompatibilität.
	wp_enqueue_style(
		'wissenswerk-theme',
		get_stylesheet_uri(),
		array( 'wissenswerk-style' ),
		WISSENSWERK_VERSION
	);

	wp_enqueue_script(
		'wissenswerk-navigation',
		WISSENSWERK_URI . '/assets/js/main.js',
		array(),
		WISSENSWERK_VERSION,
		true
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wissenswerk_assets' );

/**
 * Widget-Bereiche registrieren.
 */
function wissenswerk_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Seitenleiste', 'wissenswerk' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Wird auf Beiträgen und Archiven angezeigt.', 'wissenswerk' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer', 'wissenswerk' ),
		'id'            => 'footer-1',
		'description'   => __( 'Widgets im Footer-Bereich.', 'wissenswerk' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'wissenswerk_widgets_init' );

/**
 * Body-Klassen erweitern.
 */
function wissenswerk_body_classes( $classes ) {
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	if ( is_front_page() ) {
		$classes[] = 'is-front-page';
	}
	return $classes;
}
add_filter( 'body_class', 'wissenswerk_body_classes' );

// Modularisierte Theme-Bestandteile laden.
require WISSENSWERK_DIR . '/inc/post-types.php';
require WISSENSWERK_DIR . '/inc/taxonomies.php';
require WISSENSWERK_DIR . '/inc/template-tags.php';
require WISSENSWERK_DIR . '/inc/customizer.php';
