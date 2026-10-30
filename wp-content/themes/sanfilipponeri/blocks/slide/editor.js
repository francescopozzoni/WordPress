( function ( blocks, blockEditor, components, element ) {
	var el = element.createElement;
	var RichText = blockEditor.RichText;

	blocks.registerBlockType( 'sanfilipponeri/slide', {
		__experimentalLabel: function ( attributes ) {
			return attributes.label || 'Scheda dello slider';
		},
		edit: function ( props ) {
			var attributes = props.attributes;
			var setAttributes = props.setAttributes;
			var blockProps = blockEditor.useBlockProps( { className: 'sfn-slide-editor' } );
			var innerBlocksProps = blockEditor.useInnerBlocksProps(
				{ className: 'sfn-slide-editor__body' },
				{
					template: [ [ 'core/paragraph', { placeholder: 'Contenuto della scheda (articoli, shortcode, testo…)' } ] ],
				}
			);

			return el(
				'div',
				blockProps,
				el(
					blockEditor.InspectorControls,
					null,
					el(
						components.PanelBody,
						{ title: 'Scheda' },
						el( components.TextControl, {
							label: 'Voce nella barra di navigazione',
							value: attributes.label,
							onChange: function ( value ) {
								setAttributes( { label: value } );
							},
							__nextHasNoMarginBottom: true,
						} )
					),
					el(
						components.PanelBody,
						{ title: 'Pulsante' },
						el( 'p', { className: 'components-base-control__help' }, 'Cerca una pagina o un articolo, oppure incolla un indirizzo. Se lasci vuoto, il pulsante porta al contenuto della scheda.' ),
						el( blockEditor.URLInput, {
							label: 'Link del pulsante',
							value: attributes.buttonUrl,
							onChange: function ( value ) {
								setAttributes( { buttonUrl: value } );
							},
							__nextHasNoMarginBottom: true,
						} ),
						el( components.ToggleControl, {
							label: 'Apri in una nuova scheda',
							checked: attributes.buttonNewTab,
							onChange: function ( value ) {
								setAttributes( { buttonNewTab: value } );
							},
							__nextHasNoMarginBottom: true,
						} )
					)
				),
				el( RichText, {
					tagName: 'p',
					className: 'sfn-slide-editor__label',
					value: attributes.label,
					allowedFormats: [],
					placeholder: 'Voce di navigazione (es. News)',
					onChange: function ( value ) {
						setAttributes( { label: value } );
					},
				} ),
				el(
					'div',
					{ className: 'sfn-slide-editor__hero' },
					el( RichText, {
						tagName: 'p',
						className: 'odn-p-small',
						value: attributes.kicker,
						allowedFormats: [],
						placeholder: 'Occhiello (es. News)',
						onChange: function ( value ) {
							setAttributes( { kicker: value } );
						},
					} ),
					el( RichText, {
						tagName: 'p',
						className: 'odn-p-big',
						value: attributes.title,
						allowedFormats: [ 'core/italic', 'core/underline', 'core/link' ],
						placeholder: 'Titolo della slide — usa il corsivo per la parola evidenziata',
						onChange: function ( value ) {
							setAttributes( { title: value } );
						},
					} ),
					el( RichText, {
						tagName: 'span',
						className: 'odn-button',
						value: attributes.buttonText,
						allowedFormats: [],
						placeholder: 'Testo del pulsante',
						onChange: function ( value ) {
							setAttributes( { buttonText: value } );
						},
					} ),
					el(
						'div',
						{ className: 'sfn-slide-editor__link' },
						el( blockEditor.URLInput, {
							label: 'Link del pulsante',
							value: attributes.buttonUrl,
							placeholder: 'Cerca una pagina o incolla un indirizzo (vuoto = scorre al contenuto)',
							onChange: function ( value ) {
								setAttributes( { buttonUrl: value } );
							},
							__nextHasNoMarginBottom: true,
						} )
					)
				),
				el( 'div', innerBlocksProps )
			);
		},
		save: function () {
			return el( blockEditor.InnerBlocks.Content );
		},
	} );
} )( window.wp.blocks, window.wp.blockEditor, window.wp.components, window.wp.element );
