<?php
namespace AutoListings\SearchForm;

class Ajax {
	public function __construct() {
		add_action( 'wp_ajax_model_filter', [ $this, 'handle_ajax' ] );
		add_action( 'wp_ajax_nopriv_model_filter', [ $this, 'handle_ajax' ] );
	}

	public function handle_ajax() {
		if ( empty( $_POST[ 'selected' ] ) ) {
			wp_send_json_error( __( 'No make selected', 'auto-listings' ) );
		}
		$selected = is_array( $_POST[ 'selected' ] ) ? $_POST[ 'selected' ] : ( array ) $_POST[ 'selected' ];
		$selected = array_map( 'sanitize_text_field', wp_unslash( $selected ) );
		$query = [
			'post_type'      => 'auto-listing',
			'meta_key'       => '_al_listing_make_display',
			'meta_value'     => $selected,
			'compare'        => 'IN',
			'fields'         => 'ids',
			'posts_per_page' => -1,
		];
		$listings = $this->get_listings( $query );
		$models = $this->get_listings_models( $listings );
		wp_send_json_success( $this->render_model_select( $models ) );
	}

	public function get_listings( $query ) {
		$listings = new \WP_Query( $query );
		return $listings->posts;
	}

	public function get_listings_models( $listings ) {
		$models = array_map( function( $listing ) {
			$model = get_post_meta( $listing, '_al_listing_model_name', true );
			return trim( $model );
		}, $listings );
		sort( $models );
		return array_unique( array_filter( $models ) );
	}

	public function render_model_select( $models ) {
		ob_start();
		foreach( $models as $model ) : ?>
			<option value="<?php echo esc_attr( $model ); ?>"><?php echo esc_html( $model ); ?></option>
		<?php
		endforeach;
		return ob_get_clean();
	}
}
