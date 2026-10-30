/**
 * Ricerca nel menu: se il campo è vuoto, la lente apre il campo invece di
 * inviare una ricerca vuota; Esc lo richiude.
 */
( function () {
	document.querySelectorAll( '.sfn-menu-search' ).forEach( function ( item ) {
		var form = item.querySelector( 'form' );
		var field = item.querySelector( '.sfn-menu-search__field' );

		if ( ! form || ! field ) {
			return;
		}

		form.addEventListener( 'submit', function ( event ) {
			if ( '' === field.value.trim() ) {
				event.preventDefault();
				field.focus();
			}
		} );

		field.addEventListener( 'keydown', function ( event ) {
			if ( 'Escape' === event.key ) {
				field.blur();
			}
		} );
	} );
} )();
