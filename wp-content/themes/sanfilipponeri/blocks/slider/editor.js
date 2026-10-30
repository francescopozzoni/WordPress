( function ( blocks, blockEditor, element ) {
	var el = element.createElement;

	var TEMPLATE = [
		[ 'sanfilipponeri/slide', { label: 'Scheda 1' } ],
		[ 'sanfilipponeri/slide', { label: 'Scheda 2' } ],
	];

	blocks.registerBlockType( 'sanfilipponeri/slider', {
		edit: function () {
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
				el( 'p', { className: 'sfn-slider-editor__hint' }, 'Slider a schede — ogni scheda qui sotto diventa una slide con il suo contenuto. Trascina le schede per riordinarle.' ),
				el( 'div', innerBlocksProps )
			);
		},
		save: function () {
			return el( blockEditor.InnerBlocks.Content );
		},
	} );
} )( window.wp.blocks, window.wp.blockEditor, window.wp.element );
