/**
 * Wissenswerk – Frontend-Interaktionen.
 * Mobile-Navigation und Dark-Mode-Umschalter.
 */
( function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		initMobileNav();
		initThemeToggle();
	} );

	/**
	 * Mobiles Menü ein- und ausblenden.
	 */
	function initMobileNav() {
		var toggle = document.querySelector( '.nav-toggle' );
		var nav = document.querySelector( '.main-navigation' );

		if ( ! toggle || ! nav ) {
			return;
		}

		toggle.addEventListener( 'click', function () {
			var isOpen = toggle.getAttribute( 'aria-expanded' ) === 'true';
			toggle.setAttribute( 'aria-expanded', String( ! isOpen ) );
			nav.classList.toggle( 'is-open' );
			document.body.classList.toggle( 'nav-open' );
		} );

		// Menü schließen, wenn ein Link angeklickt wird.
		nav.addEventListener( 'click', function ( event ) {
			if ( event.target.tagName === 'A' ) {
				toggle.setAttribute( 'aria-expanded', 'false' );
				nav.classList.remove( 'is-open' );
				document.body.classList.remove( 'nav-open' );
			}
		} );
	}

	/**
	 * Hell-/Dunkelmodus umschalten und Auswahl speichern.
	 */
	function initThemeToggle() {
		var toggle = document.querySelector( '.theme-toggle' );
		var root = document.documentElement;
		var storageKey = 'wissenswerk-theme';

		// Gespeicherte oder vom System bevorzugte Einstellung anwenden.
		var stored = null;
		try {
			stored = window.localStorage.getItem( storageKey );
		} catch ( e ) {}

		if ( stored ) {
			root.setAttribute( 'data-theme', stored );
		} else if ( window.matchMedia && window.matchMedia( '(prefers-color-scheme: dark)' ).matches ) {
			root.setAttribute( 'data-theme', 'dark' );
		}

		if ( ! toggle ) {
			return;
		}

		toggle.addEventListener( 'click', function () {
			var current = root.getAttribute( 'data-theme' ) === 'dark' ? 'dark' : 'light';
			var next = current === 'dark' ? 'light' : 'dark';
			root.setAttribute( 'data-theme', next );
			try {
				window.localStorage.setItem( storageKey, next );
			} catch ( e ) {}
		} );
	}
} )();
