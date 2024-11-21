<?php
namespace MBFS;

class ConvertToBlocks {
	const FLAG = '_mbfs_convert_to_blocks';

	public function __construct() {
		add_action( 'rwmb_frontend_after_save_post', [ $this, 'set_flag' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'wp_ajax_mbfs_remove_flag', [ $this, 'remove_flag' ] );
	}

	public function set_flag( Post $post ): void {
		if ( ! is_numeric( $post->post_id ) ) {
			return;
		}
		if ( ! use_block_editor_for_post_type( $post->post_type ) ) {
			return;
		}

		update_post_meta( $post->post_id, self::FLAG, 1 );
	}

	public function enqueue_scripts(): void {
		$screen = get_current_screen();
		if ( ! $screen || $screen->base !== 'post' ) {
			return;
		}

		$post_type = $screen->post_type;
		if ( ! use_block_editor_for_post_type( $post_type ) ) {
			return;
		}

		$post_id = (int) filter_input( INPUT_GET, 'post' );
		if ( ! $post_id ) {
			return;
		}

		$flag = get_post_meta( $post_id, self::FLAG, true );
		if ( ! $flag ) {
			return;
		}

		wp_enqueue_script(
			'mbfs-convert-to-blocks',
			MBFS_URL . 'assets/convert-to-blocks.js',
			[ 'wp-data', 'wp-blocks', 'wp-dom-ready', 'wp-url' ],
			filemtime( MBFS_DIR . '/assets/convert-to-blocks.js' ),
			true
		);
		wp_localize_script( 'mbfs-convert-to-blocks', 'MBFS', [
			'nonce' => wp_create_nonce( 'remove-flag' ),
		] );
	}

	public function remove_flag(): void {
		check_ajax_referer( 'remove-flag' );

		$post_id = (int) filter_input( INPUT_GET, 'post_id' );
		if ( $post_id ) {
			delete_post_meta( $post_id, self::FLAG );
		}
	}
}
