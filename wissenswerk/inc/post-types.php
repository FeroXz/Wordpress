<?php
/**
 * Custom Post Types für die drei Theme-Bereiche.
 *
 * @package Wissenswerk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registriert die Post Types: Wissen, Galerie und Neuigkeiten.
 */
function wissenswerk_register_post_types() {

	// --- Wissenssammlung -------------------------------------------------
	register_post_type( 'wissen', array(
		'labels' => array(
			'name'                  => __( 'Wissenssammlung', 'wissenswerk' ),
			'singular_name'         => __( 'Wissensartikel', 'wissenswerk' ),
			'add_new'               => __( 'Neu hinzufügen', 'wissenswerk' ),
			'add_new_item'          => __( 'Neuen Wissensartikel hinzufügen', 'wissenswerk' ),
			'edit_item'             => __( 'Wissensartikel bearbeiten', 'wissenswerk' ),
			'new_item'              => __( 'Neuer Wissensartikel', 'wissenswerk' ),
			'view_item'             => __( 'Wissensartikel ansehen', 'wissenswerk' ),
			'search_items'          => __( 'Wissen durchsuchen', 'wissenswerk' ),
			'not_found'             => __( 'Keine Artikel gefunden', 'wissenswerk' ),
			'not_found_in_trash'    => __( 'Keine Artikel im Papierkorb', 'wissenswerk' ),
			'all_items'             => __( 'Alle Wissensartikel', 'wissenswerk' ),
			'menu_name'             => __( 'Wissenssammlung', 'wissenswerk' ),
		),
		'public'        => true,
		'has_archive'   => true,
		'menu_icon'     => 'dashicons-book-alt',
		'menu_position' => 20,
		'rewrite'       => array( 'slug' => 'wissen', 'with_front' => false ),
		'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'author', 'custom-fields' ),
		'show_in_rest'  => true,
	) );

	// --- Galerie ---------------------------------------------------------
	register_post_type( 'galerie', array(
		'labels' => array(
			'name'                  => __( 'Galerie', 'wissenswerk' ),
			'singular_name'         => __( 'Galerie-Eintrag', 'wissenswerk' ),
			'add_new'               => __( 'Neu hinzufügen', 'wissenswerk' ),
			'add_new_item'          => __( 'Neuen Galerie-Eintrag hinzufügen', 'wissenswerk' ),
			'edit_item'             => __( 'Galerie-Eintrag bearbeiten', 'wissenswerk' ),
			'new_item'              => __( 'Neuer Galerie-Eintrag', 'wissenswerk' ),
			'view_item'             => __( 'Galerie-Eintrag ansehen', 'wissenswerk' ),
			'search_items'          => __( 'Galerie durchsuchen', 'wissenswerk' ),
			'not_found'             => __( 'Keine Einträge gefunden', 'wissenswerk' ),
			'not_found_in_trash'    => __( 'Keine Einträge im Papierkorb', 'wissenswerk' ),
			'all_items'             => __( 'Alle Galerie-Einträge', 'wissenswerk' ),
			'menu_name'             => __( 'Galerie', 'wissenswerk' ),
		),
		'public'        => true,
		'has_archive'   => true,
		'menu_icon'     => 'dashicons-format-gallery',
		'menu_position' => 21,
		'rewrite'       => array( 'slug' => 'galerie', 'with_front' => false ),
		'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'author' ),
		'show_in_rest'  => true,
	) );

	// --- Neuigkeiten -----------------------------------------------------
	register_post_type( 'neuigkeiten', array(
		'labels' => array(
			'name'                  => __( 'Neuigkeiten', 'wissenswerk' ),
			'singular_name'         => __( 'Neuigkeit', 'wissenswerk' ),
			'add_new'               => __( 'Neu hinzufügen', 'wissenswerk' ),
			'add_new_item'          => __( 'Neue Neuigkeit hinzufügen', 'wissenswerk' ),
			'edit_item'             => __( 'Neuigkeit bearbeiten', 'wissenswerk' ),
			'new_item'              => __( 'Neue Neuigkeit', 'wissenswerk' ),
			'view_item'             => __( 'Neuigkeit ansehen', 'wissenswerk' ),
			'search_items'          => __( 'Neuigkeiten durchsuchen', 'wissenswerk' ),
			'not_found'             => __( 'Keine Neuigkeiten gefunden', 'wissenswerk' ),
			'not_found_in_trash'    => __( 'Keine Neuigkeiten im Papierkorb', 'wissenswerk' ),
			'all_items'             => __( 'Alle Neuigkeiten', 'wissenswerk' ),
			'menu_name'             => __( 'Neuigkeiten', 'wissenswerk' ),
		),
		'public'        => true,
		'has_archive'   => true,
		'menu_icon'     => 'dashicons-megaphone',
		'menu_position' => 22,
		'rewrite'       => array( 'slug' => 'neuigkeiten', 'with_front' => false ),
		'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'author', 'comments' ),
		'show_in_rest'  => true,
	) );
}
add_action( 'init', 'wissenswerk_register_post_types' );

/**
 * Permalinks bei Theme-Aktivierung neu schreiben, damit die CPT-Slugs greifen.
 */
function wissenswerk_rewrite_flush() {
	wissenswerk_register_post_types();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'wissenswerk_rewrite_flush' );
