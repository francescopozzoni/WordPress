/**
 * Comparsa allo scorrimento: blocchi del contenuto e schede degli articoli
 * che si trovano sotto il bordo dello schermo entrano con una dissolvenza
 * quando ci si arriva. Quelli già visibili al caricamento non si animano.
 * Senza JavaScript, o con "riduci movimento", tutto resta visibile.
 */
( function () {
	if ( ! ( 'IntersectionObserver' in window ) || window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
		return;
	}

	var selector = [
		'.entry-content > :not(.wp-block-sanfilipponeri-slider)',
		'.entry-content .wp-block-latest-posts > li',
		'.entry-content .display-posts-listing > .listing-item',
		'.entry-content .ultp-block-item',
		'.search .site-main > article',
		'.widget-area .widget',
	].join( ',' );

	var observer = new IntersectionObserver(
		function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( ! entry.isIntersecting ) {
					return;
				}
				var el = entry.target;
				observer.unobserve( el );
				el.classList.add( 'sfn-revealed' );
				el.addEventListener(
					'transitionend',
					function done( event ) {
						if ( event.target === el && 'opacity' === event.propertyName ) {
							el.classList.remove( 'sfn-reveal', 'sfn-revealed' );
							el.style.transitionDelay = '';
							el.removeEventListener( 'transitionend', done );
						}
					}
				);
			} );
		},
		{ rootMargin: '0px 0px -8% 0px' }
	);

	var siblingsIndex = new Map();

	document.querySelectorAll( selector ).forEach( function ( el ) {
		// Un elemento dentro un altro già animato non si anima due volte.
		if ( el.parentElement && el.parentElement.closest( '.sfn-reveal' ) ) {
			return;
		}
		if ( el.getBoundingClientRect().top < window.innerHeight ) {
			return;
		}

		// Schede affiancate: piccolo ritardo progressivo.
		var parent = el.parentElement;
		var index = siblingsIndex.get( parent ) || 0;
		siblingsIndex.set( parent, index + 1 );
		el.style.transitionDelay = ( index % 4 ) * 70 + 'ms';

		el.classList.add( 'sfn-reveal' );
		observer.observe( el );
	} );
} )();
