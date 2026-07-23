/**
 * Wissenswerk – Frontend-Interaktionen.
 * Mobile-Navigation und Dark-Mode-Umschalter.
 */
( function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		initMobileNav();
		initThemeToggle();
		initGalleryFilter();
		initLightbox();
		initWiki();
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

	/**
	 * Galerie-Filter nach Album (clientseitig).
	 */
	function initGalleryFilter() {
		var filter = document.querySelector( '.gallery-filter' );
		var grid = document.getElementById( 'galleryGrid' );
		if ( ! filter || ! grid ) {
			return;
		}

		var buttons = filter.querySelectorAll( '.chip' );
		var items = grid.querySelectorAll( '.masonry__item' );
		var empty = document.getElementById( 'galleryEmpty' );

		filter.addEventListener( 'click', function ( event ) {
			var btn = event.target.closest( '.chip' );
			if ( ! btn ) {
				return;
			}

			var value = btn.getAttribute( 'data-filter' );
			var visible = 0;

			buttons.forEach( function ( b ) {
				b.classList.toggle( 'chip--active', b === btn );
				b.setAttribute( 'aria-selected', b === btn ? 'true' : 'false' );
			} );

			items.forEach( function ( item ) {
				var albums = ( item.getAttribute( 'data-albums' ) || '' ).split( ' ' );
				var show = value === '*' || albums.indexOf( value ) !== -1;
				item.hidden = ! show;
				if ( show ) {
					visible++;
				}
			} );

			if ( empty ) {
				empty.hidden = visible !== 0;
			}
		} );
	}

	/**
	 * Lightbox für die Galerie.
	 */
	function initLightbox() {
		var lightbox = document.getElementById( 'lightbox' );
		var triggers = Array.prototype.slice.call( document.querySelectorAll( '.js-lightbox' ) );
		if ( ! lightbox || ! triggers.length ) {
			return;
		}

		var img = lightbox.querySelector( '.lightbox__img' );
		var caption = lightbox.querySelector( '.lightbox__caption' );
		var btnClose = lightbox.querySelector( '.lightbox__close' );
		var btnPrev = lightbox.querySelector( '.lightbox__nav--prev' );
		var btnNext = lightbox.querySelector( '.lightbox__nav--next' );
		var current = 0;
		var lastFocus = null;

		function usable( trigger ) {
			return trigger.getAttribute( 'data-full' );
		}

		function show( index ) {
			var total = triggers.length;
			current = ( index + total ) % total;
			var trigger = triggers[ current ];
			var src = trigger.getAttribute( 'data-full' );
			if ( ! src ) {
				return;
			}
			img.setAttribute( 'src', src );
			img.setAttribute( 'alt', trigger.getAttribute( 'data-caption' ) || '' );
			caption.textContent = trigger.getAttribute( 'data-caption' ) || '';
		}

		function open( index ) {
			lastFocus = document.activeElement;
			show( index );
			lightbox.classList.add( 'is-open' );
			lightbox.setAttribute( 'aria-hidden', 'false' );
			document.body.classList.add( 'nav-open' );
			btnClose.focus();
		}

		function close() {
			lightbox.classList.remove( 'is-open' );
			lightbox.setAttribute( 'aria-hidden', 'true' );
			document.body.classList.remove( 'nav-open' );
			if ( lastFocus ) {
				lastFocus.focus();
			}
		}

		triggers.forEach( function ( trigger, index ) {
			trigger.addEventListener( 'click', function ( event ) {
				if ( ! usable( trigger ) ) {
					return; // Kein Vollbild – normalem Link folgen.
				}
				event.preventDefault();
				open( index );
			} );
		} );

		btnClose.addEventListener( 'click', close );
		btnPrev.addEventListener( 'click', function () { show( current - 1 ); } );
		btnNext.addEventListener( 'click', function () { show( current + 1 ); } );

		lightbox.addEventListener( 'click', function ( event ) {
			if ( event.target === lightbox ) {
				close();
			}
		} );

		document.addEventListener( 'keydown', function ( event ) {
			if ( ! lightbox.classList.contains( 'is-open' ) ) {
				return;
			}
			if ( event.key === 'Escape' ) {
				close();
			} else if ( event.key === 'ArrowLeft' ) {
				show( current - 1 );
			} else if ( event.key === 'ArrowRight' ) {
				show( current + 1 );
			}
		} );
	}

	/**
	 * Wiki: mobile Navigation und aktives Hervorheben beim Scrollen.
	 */
	function initWiki() {
		var wiki = document.querySelector( '.wiki' );
		if ( ! wiki ) {
			return;
		}

		// Mobile Sidebar umschalten.
		var toggle = wiki.querySelector( '.wiki__toggle' );
		var nav = document.getElementById( 'wikiNav' );
		if ( toggle && nav ) {
			toggle.addEventListener( 'click', function () {
				var open = toggle.getAttribute( 'aria-expanded' ) === 'true';
				toggle.setAttribute( 'aria-expanded', String( ! open ) );
				nav.classList.toggle( 'is-open' );
			} );
			nav.addEventListener( 'click', function ( event ) {
				if ( event.target.tagName === 'A' ) {
					toggle.setAttribute( 'aria-expanded', 'false' );
					nav.classList.remove( 'is-open' );
				}
			} );
		}

		// Aktiven Abschnitt in der Navigation markieren (Scrollspy).
		var links = wiki.querySelectorAll( '.wiki__toc a' );
		var sections = wiki.querySelectorAll( '.wiki__section' );
		if ( ! links.length || ! sections.length || ! ( 'IntersectionObserver' in window ) ) {
			return;
		}

		var map = {};
		links.forEach( function ( link ) {
			map[ link.getAttribute( 'href' ).slice( 1 ) ] = link;
		} );

		var observer = new IntersectionObserver( function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( entry.isIntersecting && map[ entry.target.id ] ) {
					links.forEach( function ( l ) { l.classList.remove( 'is-active' ); } );
					map[ entry.target.id ].classList.add( 'is-active' );
				}
			} );
		}, { rootMargin: '-20% 0px -70% 0px' } );

		sections.forEach( function ( section ) { observer.observe( section ); } );
	}
} )();
