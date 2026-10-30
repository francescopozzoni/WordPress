/**
 * Pulsanti +/- dei sottomenu sui dispositivi touch.
 *
 * Twenty Twenty-One apre i sottomenu anche al passaggio del mouse: con un tap
 * il browser simula prima il passaggio (che apre) e poi il clic (che richiude),
 * quindi il sottomenu non si apriva. Qui si ripristina lo stato che il pulsante
 * aveva al momento del tocco, così il clic lo inverte correttamente.
 */
( function () {
	var stateAtTouch = null;

	document.addEventListener(
		'pointerdown',
		function ( event ) {
			var toggle = event.target.closest && event.target.closest( '.sub-menu-toggle' );
			stateAtTouch = toggle && 'mouse' !== event.pointerType ? { toggle: toggle, expanded: toggle.getAttribute( 'aria-expanded' ) } : null;
		},
		true
	);

	document.addEventListener(
		'click',
		function ( event ) {
			var toggle = event.target.closest && event.target.closest( '.sub-menu-toggle' );
			if ( stateAtTouch && toggle === stateAtTouch.toggle ) {
				toggle.setAttribute( 'aria-expanded', stateAtTouch.expanded );
			}
			stateAtTouch = null;
		},
		true
	);
} )();
