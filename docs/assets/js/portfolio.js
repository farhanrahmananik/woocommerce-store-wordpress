/**
 * DeskNest portfolio page — progressive enhancements only.
 * 1. Compact mobile navigation toggle (nav stays fully usable without JS).
 * 2. Screenshot preview in a native <dialog> (every screenshot also links
 *    directly to its full image, so the gallery works without JS).
 * No dependencies, no tracking, no network requests.
 */
( function () {
	'use strict';

	// CSS gates the compact-nav behaviour on this class, so a missing or
	// failed script leaves the full navigation visible.
	document.documentElement.classList.add( 'js' );

	/* ------------------------------------------------------------------
	   Mobile navigation toggle
	   ------------------------------------------------------------------ */
	var navToggle = document.querySelector( '.nav-toggle' );
	var siteNav = document.getElementById( 'site-nav' );

	if ( navToggle && siteNav ) {
		var closeNav = function () {
			navToggle.setAttribute( 'aria-expanded', 'false' );
			siteNav.classList.remove( 'is-open' );
		};

		navToggle.addEventListener( 'click', function () {
			var isOpen = navToggle.getAttribute( 'aria-expanded' ) === 'true';
			navToggle.setAttribute( 'aria-expanded', String( ! isOpen ) );
			siteNav.classList.toggle( 'is-open', ! isOpen );
		} );

		// Close after choosing a section so the page is visible again.
		siteNav.addEventListener( 'click', function ( event ) {
			if ( event.target && event.target.closest( 'a' ) ) {
				closeNav();
			}
		} );

		document.addEventListener( 'keydown', function ( event ) {
			if ( 'Escape' === event.key ) {
				closeNav();
			}
		} );
	}

	/* ------------------------------------------------------------------
	   Screenshot dialog
	   ------------------------------------------------------------------ */
	var dialog = document.getElementById( 'shot-dialog' );
	var dialogImage = document.getElementById( 'shot-dialog-image' );
	var dialogCaption = document.getElementById( 'shot-dialog-caption' );
	var dialogClose = document.getElementById( 'shot-dialog-close' );

	var dialogSupported =
		dialog && dialogImage && dialogCaption && dialogClose &&
		'function' === typeof dialog.showModal;

	if ( dialogSupported ) {
		var openDialog = function ( link ) {
			var img = link.querySelector( 'img' );
			var figure = link.closest( 'figure' );
			var caption = figure ? figure.querySelector( 'figcaption' ) : null;

			dialogImage.src = link.getAttribute( 'href' );
			dialogImage.alt = img ? img.alt : '';
			if ( img && img.getAttribute( 'width' ) && img.getAttribute( 'height' ) ) {
				dialogImage.width = parseInt( img.getAttribute( 'width' ), 10 );
				dialogImage.height = parseInt( img.getAttribute( 'height' ), 10 );
			}
			dialogCaption.textContent = caption ? caption.textContent : '';
			dialog.showModal();
		};

		document.querySelectorAll( '.shot__link' ).forEach( function ( link ) {
			link.addEventListener( 'click', function ( event ) {
				// Let modified clicks (new tab etc.) use the direct image link.
				if ( event.metaKey || event.ctrlKey || event.shiftKey || event.altKey ) {
					return;
				}
				event.preventDefault();
				openDialog( link );
			} );
		} );

		dialogClose.addEventListener( 'click', function () {
			dialog.close();
		} );

		// Clicking the backdrop (the dialog element itself, outside its
		// content) closes the preview; Escape is handled natively.
		dialog.addEventListener( 'click', function ( event ) {
			if ( event.target === dialog ) {
				dialog.close();
			}
		} );
	}
}() );
