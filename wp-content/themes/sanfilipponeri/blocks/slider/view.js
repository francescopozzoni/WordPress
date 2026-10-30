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
					bodies[ i ].style.display = active ? 'block' : 'none';
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

		/*
		 * Altezza uniforme: le schede che differiscono dalla più alta di non più
		 * di "cutoff" pixel prendono la sua altezza, così cambiando scheda la
		 * pagina non salta; quelle molto più corte restano compatte.
		 */
		var cutoff = parseInt( root.getAttribute( 'data-height-cutoff' ), 10 );
		cutoff = isNaN( cutoff ) ? 100 : cutoff;

		function equalizeHeights() {
			if ( ! bodiesContainer || ! bodies.length ) {
				return;
			}

			var heights = [];
			var tallest = 0;
			var i;

			// Misura ogni scheda alla larghezza reale, anche quelle nascoste.
			bodiesContainer.style.position = 'relative';
			for ( i = 0; i < bodies.length; i++ ) {
				var body = bodies[ i ];
				var previousDisplay = body.style.display;
				body.style.minHeight = '';
				if ( 'none' === getComputedStyle( body ).display ) {
					body.style.visibility = 'hidden';
					body.style.position = 'absolute';
					body.style.left = '0';
					body.style.right = '0';
					body.style.display = 'block';
					heights[ i ] = body.offsetHeight;
					body.style.visibility = '';
					body.style.position = '';
					body.style.left = '';
					body.style.right = '';
					body.style.display = previousDisplay;
				} else {
					heights[ i ] = body.offsetHeight;
				}
				tallest = Math.max( tallest, heights[ i ] );
			}

			for ( i = 0; i < bodies.length; i++ ) {
				bodies[ i ].style.minHeight = tallest - heights[ i ] <= cutoff ? tallest + 'px' : '';
			}
		}

		var resizeTimer;
		function scheduleEqualize() {
			clearTimeout( resizeTimer );
			resizeTimer = setTimeout( equalizeHeights, 150 );
		}

		window.addEventListener( 'resize', scheduleEqualize );
		// Immagini e font cambiano le altezze dopo il caricamento.
		window.addEventListener( 'load', equalizeHeights );
		if ( document.fonts && document.fonts.ready ) {
			document.fonts.ready.then( equalizeHeights );
		}

		root.addEventListener( 'click', function ( event ) {
			var target = event.target.closest( '[data-index]' );
			if ( target && root.contains( target ) ) {
				show( parseInt( target.getAttribute( 'data-index' ), 10 ) + 1 );
				return;
			}
			// Pulsante senza link: scorre al contenuto della scheda.
			if ( event.target.closest( 'button.odn-button' ) && bodiesContainer ) {
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
		equalizeHeights();
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
