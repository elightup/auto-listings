wp.domReady( () => {
	// Make sure the block editor loads all blocks.
	setTimeout( () => {
		const editor = wp.data.select( 'core/block-editor' );
		const blocks = editor.getBlocks();

		// Only convert if the whole content is the classic block.
		if ( !blocks || blocks.length !== 1 ) {
			removeFlag();
			return;
		}

		const block = blocks[ 0 ];

		// Make sure it's the classic block.
		if ( block.name !== 'core/freeform' ) {
			removeFlag();
			return;
		}

		const content = wp.blocks.rawHandler( {
			HTML: wp.blocks.getBlockContent( block ),
		} );

		wp.data.dispatch( 'core/block-editor' ).replaceBlocks( block.clientId, content );
	}, 500 );

	const removeFlag = () => {
		const url = wp.url.addQueryArgs( ajaxurl, {
			action: 'mbfs_remove_flag',
			post_id: wp.url.getQueryArg( location, 'post' ),
			_ajax_nonce: MBFS.nonce,
		} );

		fetch( url );
	};
} );
