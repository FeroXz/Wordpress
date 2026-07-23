<?php
/**
 * Theme-Customizer: Landingpage vollständig bearbeitbar + Footer.
 *
 * @package Wissenswerk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sanitize-Callback für Checkboxen.
 *
 * @param mixed $value Eingabewert.
 * @return bool
 */
function wissenswerk_sanitize_checkbox( $value ) {
	return ( isset( $value ) && ( true === $value || '1' === $value || 1 === $value ) );
}

/**
 * Registriert alle Customizer-Einstellungen.
 *
 * @param WP_Customize_Manager $wp_customize Customizer-Instanz.
 */
function wissenswerk_customize_register( $wp_customize ) {

	// Live-Vorschau für die Textfelder.
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	/* =========================================================
	   Panel: Landingpage
	   ========================================================= */
	$wp_customize->add_panel( 'wissenswerk_landing', array(
		'title'       => __( 'Landingpage', 'wissenswerk' ),
		'description' => __( 'Inhalte und Abschnitte der Startseite bearbeiten.', 'wissenswerk' ),
		'priority'    => 25,
	) );

	/* ---- Abschnitt: Hero ---- */
	$wp_customize->add_section( 'wissenswerk_hero', array(
		'title' => __( 'Hero (Kopfbereich)', 'wissenswerk' ),
		'panel' => 'wissenswerk_landing',
	) );

	$hero_fields = array(
		'wissenswerk_hero_eyebrow'   => array( __( 'Kleiner Text über der Überschrift', 'wissenswerk' ), '', 'text' ),
		'wissenswerk_hero_title'     => array( __( 'Überschrift', 'wissenswerk' ), __( 'Wissen, das bleibt.', 'wissenswerk' ), 'text', 'postMessage' ),
		'wissenswerk_hero_subtitle'  => array( __( 'Untertitel', 'wissenswerk' ), __( 'Eine kuratierte Sammlung aus Wissen, Bildern und Neuigkeiten – an einem Ort.', 'wissenswerk' ), 'textarea', 'postMessage' ),
		'wissenswerk_hero_btn1_text' => array( __( 'Button 1 – Text', 'wissenswerk' ), __( 'Wissenssammlung öffnen', 'wissenswerk' ), 'text' ),
		'wissenswerk_hero_btn1_url'  => array( __( 'Button 1 – Link', 'wissenswerk' ), '', 'url' ),
		'wissenswerk_hero_btn2_text' => array( __( 'Button 2 – Text', 'wissenswerk' ), __( 'Galerie ansehen', 'wissenswerk' ), 'text' ),
		'wissenswerk_hero_btn2_url'  => array( __( 'Button 2 – Link', 'wissenswerk' ), '', 'url' ),
	);
	foreach ( $hero_fields as $id => $conf ) {
		$type      = isset( $conf[2] ) ? $conf[2] : 'text';
		$transport = isset( $conf[3] ) ? $conf[3] : 'refresh';
		$sanitize  = ( 'url' === $type ) ? 'esc_url_raw' : ( ( 'textarea' === $type ) ? 'sanitize_textarea_field' : 'sanitize_text_field' );
		$wp_customize->add_setting( $id, array(
			'default'           => $conf[1],
			'sanitize_callback' => $sanitize,
			'transport'         => $transport,
		) );
		$wp_customize->add_control( $id, array(
			'label'   => $conf[0],
			'section' => 'wissenswerk_hero',
			'type'    => ( 'url' === $type ) ? 'url' : $type,
		) );
	}

	$wp_customize->add_setting( 'wissenswerk_hero_style', array(
		'default'           => 'dusk',
		'sanitize_callback' => 'sanitize_key',
	) );
	$wp_customize->add_control( 'wissenswerk_hero_style', array(
		'label'   => __( 'Hero-Hintergrund', 'wissenswerk' ),
		'section' => 'wissenswerk_hero',
		'type'    => 'select',
		'choices' => array(
			'dusk'  => __( 'Dämmerung (dunkel)', 'wissenswerk' ),
			'brand' => __( 'Marke (bunt)', 'wissenswerk' ),
		),
	) );

	/* ---- Abschnitt: Bereichs-Kacheln ---- */
	$wp_customize->add_section( 'wissenswerk_areas', array(
		'title' => __( 'Bereichs-Kacheln', 'wissenswerk' ),
		'panel' => 'wissenswerk_landing',
	) );

	$wp_customize->add_setting( 'wissenswerk_areas_show', array(
		'default'           => true,
		'sanitize_callback' => 'wissenswerk_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'wissenswerk_areas_show', array(
		'label'   => __( 'Kacheln anzeigen', 'wissenswerk' ),
		'section' => 'wissenswerk_areas',
		'type'    => 'checkbox',
	) );

	$area_fields = array(
		'wissenswerk_area_wissen_title'      => array( __( 'Kachel Wissen – Titel', 'wissenswerk' ), __( 'Wissenssammlung', 'wissenswerk' ) ),
		'wissenswerk_area_wissen_text'       => array( __( 'Kachel Wissen – Text', 'wissenswerk' ), __( 'Fundiertes Wissen, klar strukturiert und durchsuchbar.', 'wissenswerk' ) ),
		'wissenswerk_area_galerie_title'     => array( __( 'Kachel Galerie – Titel', 'wissenswerk' ), __( 'Galerie', 'wissenswerk' ) ),
		'wissenswerk_area_galerie_text'      => array( __( 'Kachel Galerie – Text', 'wissenswerk' ), __( 'Eindrücke und Bilder in einer eleganten Ansicht.', 'wissenswerk' ) ),
		'wissenswerk_area_neuigkeiten_title' => array( __( 'Kachel Neuigkeiten – Titel', 'wissenswerk' ), __( 'Neuigkeiten', 'wissenswerk' ) ),
		'wissenswerk_area_neuigkeiten_text'  => array( __( 'Kachel Neuigkeiten – Text', 'wissenswerk' ), __( 'Aktuelles und Ankündigungen auf einen Blick.', 'wissenswerk' ) ),
	);
	foreach ( $area_fields as $id => $conf ) {
		$wp_customize->add_setting( $id, array(
			'default'           => $conf[1],
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( $id, array(
			'label'   => $conf[0],
			'section' => 'wissenswerk_areas',
			'type'    => 'text',
		) );
	}

	/* ---- Abschnitte je Bereich (Wissen / Galerie / Neuigkeiten) ---- */
	$sections = array(
		'wissen'      => array( __( 'Abschnitt: Wissenssammlung', 'wissenswerk' ), __( 'Aus der Wissenssammlung', 'wissenswerk' ), 3 ),
		'galerie'     => array( __( 'Abschnitt: Galerie', 'wissenswerk' ), __( 'Aus der Galerie', 'wissenswerk' ), 6 ),
		'neuigkeiten' => array( __( 'Abschnitt: Neuigkeiten', 'wissenswerk' ), __( 'Neuigkeiten', 'wissenswerk' ), 3 ),
	);
	foreach ( $sections as $key => $conf ) {
		$section_id = 'wissenswerk_sec_' . $key;
		$wp_customize->add_section( $section_id, array(
			'title' => $conf[0],
			'panel' => 'wissenswerk_landing',
		) );

		$wp_customize->add_setting( $section_id . '_show', array(
			'default'           => true,
			'sanitize_callback' => 'wissenswerk_sanitize_checkbox',
		) );
		$wp_customize->add_control( $section_id . '_show', array(
			'label'   => __( 'Abschnitt anzeigen', 'wissenswerk' ),
			'section' => $section_id,
			'type'    => 'checkbox',
		) );

		$wp_customize->add_setting( $section_id . '_heading', array(
			'default'           => $conf[1],
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( $section_id . '_heading', array(
			'label'   => __( 'Überschrift', 'wissenswerk' ),
			'section' => $section_id,
			'type'    => 'text',
		) );

		$wp_customize->add_setting( $section_id . '_count', array(
			'default'           => $conf[2],
			'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( $section_id . '_count', array(
			'label'       => __( 'Anzahl der Beiträge', 'wissenswerk' ),
			'section'     => $section_id,
			'type'        => 'number',
			'input_attrs' => array( 'min' => 1, 'max' => 12, 'step' => 1 ),
		) );
	}

	/* =========================================================
	   Footer-Text (unter Titel & Tagline)
	   ========================================================= */
	$wp_customize->add_setting( 'wissenswerk_footer_text', array(
		'default'           => '',
		'sanitize_callback' => 'wp_kses_post',
	) );
	$wp_customize->add_control( 'wissenswerk_footer_text', array(
		'label'       => __( 'Footer-Text', 'wissenswerk' ),
		'description' => __( 'Zusätzlicher Text unten im Footer.', 'wissenswerk' ),
		'section'     => 'title_tagline',
		'type'        => 'textarea',
	) );
}
add_action( 'customize_register', 'wissenswerk_customize_register' );

/**
 * Live-Vorschau-Skript im Customizer einbinden.
 */
function wissenswerk_customize_preview_js() {
	wp_enqueue_script(
		'wissenswerk-customize-preview',
		WISSENSWERK_URI . '/assets/js/customize-preview.js',
		array( 'customize-preview' ),
		WISSENSWERK_VERSION,
		true
	);
}
add_action( 'customize_preview_init', 'wissenswerk_customize_preview_js' );
