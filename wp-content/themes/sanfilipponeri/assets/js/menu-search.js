/**
 * Ricerca nel menu (da 482px in su): la lente apre e chiude il pannello con
 * il campo; si chiude anche con Esc o cliccando altrove. Una ricerca vuota
 * non viene inviata.
 */
( function () {
	document.querySelectorAll( '.sfn-menu-search' ).forEach( function ( item ) {
		var toggle = item.querySelector( '.sfn-menu-search__toggle' );
		var form = item.querySelector( '.sfn-menu-search__form' );
		var field = item.querySelector( '.sfn-menu-search__field' );

		if ( ! toggle || ! form || ! field ) {
			return;
		}

		function setOpen( open ) {
			item.classList.toggle( 'is-open', open );
			toggle.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
			toggle.setAttribute( 'aria-label', open ? 'Chiudi la ricerca' : 'Apri la ricerca' );
			if ( open ) {
				field.focus();
			}
		}

		toggle.addEventListener( 'click', function () {
			setOpen( ! item.classList.contains( 'is-open' ) );
		} );

		item.addEventListener( 'keydown', function ( event ) {
			if ( 'Escape' === event.key && item.classList.contains( 'is-open' ) ) {
				setOpen( false );
				toggle.focus();
			}
		} );

		document.addEventListener( 'click', function ( event ) {
			if ( item.classList.contains( 'is-open' ) && ! item.contains( event.target ) ) {
				setOpen( false );
			}
		} );

		form.addEventListener( 'submit', function ( event ) {
			if ( '' === field.value.trim() ) {
				event.preventDefault();
				field.focus();
			}
		} );
	} );
} )();
