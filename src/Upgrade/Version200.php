<?php
namespace AutoListings\Upgrade;

class Version200 {
	public function __construct() {
		$current_version = get_option( 'auto_listings_version' );
		if ( version_compare( $current_version, '2.0.0', '<' ) ) {
			$this->update_listing_data();
		}
	}

	protected function update_listing_data() {
		add_action( 'load-post.php', [ $this, 'update_listing_admin' ] );
		add_action( 'template_redirect', [ $this, 'update_listing_frontend' ] );
	}

	public function update_listing_admin() {
		$screen = get_current_screen();
		if ( 'auto-listing' === $screen->id && isset( $_GET['post'] ) ) {
			$this->update_single_listing( intval( $_GET['post'] ) );
		}
	}

	public function update_listing_frontend() {
		if ( is_singular( 'auto-listing' ) ) {
			$this->update_single_listing( get_the_ID() );
		}
	}

	protected function update_single_listing( $listing_id ) {
		$this->update_listing_gallery( $listing_id );
		$this->update_listing_content( $listing_id );
	}

	protected function update_listing_gallery( $listing_id ) {
		$gallery = get_post_meta( $listing_id, '_al_listing_image_gallery', true );
		if ( empty( $gallery ) || ! is_array( $gallery ) ) {
			return;
		}
		$image_ids = [];
		foreach ( $gallery as $image_url ) {
			$image_ids[] = attachment_url_to_postid( $image_url );
		}
		$image_ids = array_filter( $image_ids );
		delete_post_meta( $listing_id, '_al_listing_image_gallery' );
		foreach ( $image_ids as $image_id ) {
			add_post_meta( $listing_id, '_al_listing_image_gallery', $image_id, false );
		}
	}

	protected function update_listing_content( $listing_id ) {
		$content = get_post_meta( $listing_id, '_al_listing_main_description', true );
		$excerpt = get_post_meta( $listing_id, '_al_listing_tagline', true );
		if ( ! $content && ! $excerpt ) {
			return;
		}
		$post_data = [
			'ID'           => $listing_id,
			'post_content' => $content,
			'post_excerpt' => $excerpt,
		];
		wp_update_post( $post_data );
		delete_post_meta( $listing_id, '_al_listing_main_description' );
		delete_post_meta( $listing_id, '_al_listing_tagline' );
	}
}