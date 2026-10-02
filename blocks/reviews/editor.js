/**
 * Editor preview of the reviews block, rendered by the server.
 *
 * The Google part is only a placeholder in the editor: Google's element loads
 * on the front end.
 */
( function ( blocks, element, blockEditor, ServerSideRender, components, i18n ) {
	const el = element.createElement;
	const __ = i18n.__;

	blocks.registerBlockType( 'witryna/reviews', {
		edit( props ) {
			const { attributes, setAttributes } = props;
			return el(
				'div',
				blockEditor.useBlockProps(),
				el(
					blockEditor.InspectorControls,
					null,
					el(
						components.PanelBody,
						{ title: __( 'Ustawienia', 'witryna' ) },
						el( components.SelectControl, {
							label: __( 'Wariant', 'witryna' ),
							value: attributes.variant,
							options: [
								{ label: __( 'Strona główna', 'witryna' ), value: 'home' },
								{ label: __( 'Strona z opiniami', 'witryna' ), value: 'page' },
							],
							onChange: ( variant ) => setAttributes( { variant } ),
						} ),
						el( components.RangeControl, {
							label: __( 'Liczba opinii ze sklepu', 'witryna' ),
							value: attributes.shopCount,
							min: 1,
							max: 50,
							onChange: ( shopCount ) => setAttributes( { shopCount } ),
						} )
					)
				),
				el( ServerSideRender, { block: 'witryna/reviews', attributes, urlQueryArgs: { 'witryna-editor': 1 } } )
			);
		},
		save: () => null,
	} );
} )( window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.serverSideRender, window.wp.components, window.wp.i18n );
