<?php
/**
 * Taxonomien für die Theme-Bereiche.
 *
 * @package Wissenswerk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registriert Kategorien und Schlagworte für die Custom Post Types.
 */
function wissenswerk_register_taxonomies() {

	// Themengebiete für die Wissenssammlung (hierarchisch).
	register_taxonomy( 'wissen_thema', 'wissen', array(
		'labels' => array(
			'name'          => __( 'Themengebiete', 'wissenswerk' ),
			'singular_name' => __( 'Themengebiet', 'wissenswerk' ),
			'search_items'  => __( 'Themengebiete durchsuchen', 'wissenswerk' ),
			'all_items'     => __( 'Alle Themengebiete', 'wissenswerk' ),
			'edit_item'     => __( 'Themengebiet bearbeiten', 'wissenswerk' ),
			'add_new_item'  => __( 'Neues Themengebiet', 'wissenswerk' ),
			'menu_name'     => __( 'Themengebiete', 'wissenswerk' ),
		),
		'hierarchical'      => true,
		'public'            => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'thema', 'with_front' => false ),
	) );

	// Alben für die Galerie (hierarchisch).
	register_taxonomy( 'galerie_album', 'galerie', array(
		'labels' => array(
			'name'          => __( 'Alben', 'wissenswerk' ),
			'singular_name' => __( 'Album', 'wissenswerk' ),
			'search_items'  => __( 'Alben durchsuchen', 'wissenswerk' ),
			'all_items'     => __( 'Alle Alben', 'wissenswerk' ),
			'edit_item'     => __( 'Album bearbeiten', 'wissenswerk' ),
			'add_new_item'  => __( 'Neues Album', 'wissenswerk' ),
			'menu_name'     => __( 'Alben', 'wissenswerk' ),
		),
		'hierarchical'      => true,
		'public'            => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'album', 'with_front' => false ),
	) );

	// Rubriken für Neuigkeiten (hierarchisch).
	register_taxonomy( 'neuigkeiten_rubrik', 'neuigkeiten', array(
		'labels' => array(
			'name'          => __( 'Rubriken', 'wissenswerk' ),
			'singular_name' => __( 'Rubrik', 'wissenswerk' ),
			'search_items'  => __( 'Rubriken durchsuchen', 'wissenswerk' ),
			'all_items'     => __( 'Alle Rubriken', 'wissenswerk' ),
			'edit_item'     => __( 'Rubrik bearbeiten', 'wissenswerk' ),
			'add_new_item'  => __( 'Neue Rubrik', 'wissenswerk' ),
			'menu_name'     => __( 'Rubriken', 'wissenswerk' ),
		),
		'hierarchical'      => true,
		'public'            => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'rubrik', 'with_front' => false ),
	) );

	// Gemeinsame Schlagworte über alle Bereiche hinweg.
	register_taxonomy( 'wissenswerk_tag', array( 'wissen', 'galerie', 'neuigkeiten' ), array(
		'labels' => array(
			'name'          => __( 'Schlagworte', 'wissenswerk' ),
			'singular_name' => __( 'Schlagwort', 'wissenswerk' ),
			'menu_name'     => __( 'Schlagworte', 'wissenswerk' ),
		),
		'hierarchical'      => false,
		'public'            => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'schlagwort', 'with_front' => false ),
	) );
}
add_action( 'init', 'wissenswerk_register_taxonomies' );
