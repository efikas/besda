var blocks = CB_BLOCKS.status

if( typeof wp.blocks.unregisterBlockType !== "undefined" ){
	Object.keys( blocks ).map( function( key ){
		if( blocks[ key ] == 'disabled' ){
			wp.blocks.unregisterBlockType( 'creative-blocks/' + key );
		}
	});
}