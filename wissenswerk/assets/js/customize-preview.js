/**
 * Live-Vorschau im Customizer (postMessage) für ausgewählte Felder.
 */
( function ( $ ) {
	'use strict';

	if ( ! window.wp || ! wp.customize ) {
		return;
	}

	wp.customize( 'blogname', function ( value ) {
		value.bind( function ( to ) {
			$( '.site-title a, .footer-brand__name' ).text( to );
		} );
	} );

	wp.customize( 'blogdescription', function ( value ) {
		value.bind( function ( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	wp.customize( 'wissenswerk_hero_title', function ( value ) {
		value.bind( function ( to ) {
			$( '.hero__title' ).text( to );
		} );
	} );

	wp.customize( 'wissenswerk_hero_subtitle', function ( value ) {
		value.bind( function ( to ) {
			$( '.hero__subtitle' ).text( to );
		} );
	} );
} )( jQuery );
