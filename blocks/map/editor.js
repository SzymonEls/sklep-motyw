/**
 * Editor preview of the map block: a placeholder, the map loads on the front end.
 */
( function ( blocks, element, blockEditor, ServerSideRender ) {
	blocks.registerBlockType( 'witryna/map', {
		edit( props ) {
			return element.createElement(
				'div',
				blockEditor.useBlockProps(),
				element.createElement( ServerSideRender, { block: 'witryna/map', attributes: props.attributes } )
			);
		},
		save: () => null,
	} );
} )( window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.serverSideRender );
