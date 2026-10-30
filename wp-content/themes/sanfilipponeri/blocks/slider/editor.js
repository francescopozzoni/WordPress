( function ( blocks, blockEditor, components, element ) {
	var el = element.createElement;

	var TEMPLATE = [
		[ 'sanfilipponeri/slide', { label: 'Scheda 1' } ],
		[ 'sanfilipponeri/slide', { label: 'Scheda 2' } ],
	];

	blocks.registerBlockType( 'sanfilipponeri/slider', {
		edit: function ( props ) {
			var blockProps = blockEditor.useBlockProps( { className: 'sfn-slider-editor' } );
			var innerBlocksProps = blockEditor.useInnerBlocksProps(
				{ className: 'sfn-slider-editor__slides' },
				{
					allowedBlocks: [ 'sanfilipponeri/slide' ],
					template: TEMPLATE,
					renderAppender: blockEditor.InnerBlocks.ButtonBlockAppender,
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
						{ title: 'Altezza delle schede' },
						el( components.RangeControl, {
							label: 'Uniforma le schede che differiscono al massimo di (px)',
							help: 'Le schede poco più basse della più alta prendono la sua altezza, così la pagina non salta cambiando scheda. 0 = mai.',
							value: props.attributes.heightCutoff,
							min: 0,
							max: 400,
							step: 10,
							onChange: function ( value ) {
								props.setAttributes( { heightCutoff: value || 0 } );
							},
							__nextHasNoMarginBottom: true,
						} )
					)
				),
				el( 'p', { className: 'sfn-slider-editor__hint' }, 'Slider a schede — ogni scheda qui sotto diventa una slide con il suo contenuto. Trascina le schede per riordinarle.' ),
				el( 'div', innerBlocksProps )
			);
		},
		save: function () {
			return el( blockEditor.InnerBlocks.Content );
		},
	} );
} )( window.wp.blocks, window.wp.blockEditor, window.wp.components, window.wp.element );
