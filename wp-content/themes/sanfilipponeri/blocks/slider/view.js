/**
 * Comportamento dello slider della homepage (ex template-parts/slider/slider.js).
 * La scheda attiva viene ricordata tra una visita e l'altra.
 */
( function () {
	var STORAGE_KEY = 'slideIndex';

	function readIndex() {
		try {
			return parseInt( window.localStorage.getItem( STORAGE_KEY ), 10 ) || 0;
		} catch ( e ) {
			return 0;
		}
	}

	function saveIndex( n ) {
		try {
			window.localStorage.setItem( STORAGE_KEY, String( n ) );
		} catch ( e ) {}
	}

	function init( root ) {
		var slides = root.querySelectorAll( '.odn-slide' );
		var dots = root.querySelectorAll( '.odn-dot' );
		var links = root.querySelectorAll( '.odn-navlink' );
		var bodies = root.querySelectorAll( '.odn-slider-body' );
		var bodiesContainer = root.querySelector( '#odn-bodies' );

		if ( ! slides.length ) {
			return;
		}

		// Il vecchio slider salvava l'indice partendo da 1.
		function show( n ) {
			if ( n > slides.length ) {
				n = 1;
			}
			if ( n < 1 ) {
				n = slides.length;
			}
			for ( var i = 0; i < slides.length; i++ ) {
				var active = i === n - 1;
				slides[ i ].style.display = active ? 'inline-block' : 'none';
				if ( bodies[ i ] ) {
					bodies[ i ].style.display = active ? 'inline-block' : 'none';
				}
				if ( dots[ i ] ) {
					dots[ i ].classList.toggle( 'active', active );
					dots[ i ].setAttribute( 'aria-pressed', active ? 'true' : 'false' );
				}
				if ( links[ i ] ) {
					links[ i ].classList.toggle( 'highlight', active );
					links[ i ].setAttribute( 'aria-pressed', active ? 'true' : 'false' );
				}
			}
			saveIndex( n );
		}

		root.addEventListener( 'click', function ( event ) {
			var target = event.target.closest( '[data-index]' );
			if ( target && root.contains( target ) ) {
				show( parseInt( target.getAttribute( 'data-index' ), 10 ) + 1 );
				return;
			}
			if ( event.target.closest( '.odn-button' ) && bodiesContainer ) {
				bodiesContainer.scrollIntoView( { behavior: 'smooth' } );
			}
		} );

		root.addEventListener( 'keydown', function ( event ) {
			var target = event.target.closest( '[data-index]' );
			if ( target && ( event.key === 'Enter' || event.key === ' ' ) ) {
				event.preventDefault();
				target.click();
			}
		} );

		show( readIndex() || 1 );
	}

	function boot() {
		document.querySelectorAll( '.wp-block-sanfilipponeri-slider' ).forEach( init );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', boot );
	} else {
		boot();
	}
} )();
