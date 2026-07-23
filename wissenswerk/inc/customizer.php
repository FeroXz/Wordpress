<?php
/**
 * Theme-Customizer-Optionen (Hero der Startseite, Footer).
 *
 * @package Wissenswerk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registriert Customizer-Einstellungen.
 *
 * @param WP_Customize_Manager $wp_customize Customizer-Instanz.
 */
function wissenswerk_customize_register( $wp_customize ) {

	$wp_customize->add_section( 'wissenswerk_hero', array(
		'title'       => __( 'Startseite: Hero', 'wissenswerk' ),
		'priority'    => 30,
		'description' => __( 'Text im großen Kopfbereich der Startseite.', 'wissenswerk' ),
	) );

	$wp_customize->add_setting( 'wissenswerk_hero_title', array(
		'default'           => __( 'Wissen, das bleibt.', 'wissenswerk' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'wissenswerk_hero_title', array(
		'label'   => __( 'Hero-Überschrift', 'wissenswerk' ),
		'section' => 'wissenswerk_hero',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'wissenswerk_hero_subtitle', array(
		'default'           => __( 'Eine kuratierte Sammlung aus Wissen, Bildern und Neuigkeiten – an einem Ort.', 'wissenswerk' ),
		'sanitize_callback' => 'sanitize_textarea_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'wissenswerk_hero_subtitle', array(
		'label'   => __( 'Hero-Untertitel', 'wissenswerk' ),
		'section' => 'wissenswerk_hero',
		'type'    => 'textarea',
	) );

	$wp_customize->add_setting( 'wissenswerk_footer_text', array(
		'default'           => '',
		'sanitize_callback' => 'wp_kses_post',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'wissenswerk_footer_text', array(
		'label'       => __( 'Footer-Text', 'wissenswerk' ),
		'description' => __( 'Zusätzlicher Text unten im Footer.', 'wissenswerk' ),
		'section'     => 'title_tagline',
		'type'        => 'textarea',
	) );
}
add_action( 'customize_register', 'wissenswerk_customize_register' );
