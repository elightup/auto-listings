<?php
namespace AutoListings\SearchForm;

class Editor {
	public function __construct() {
		add_filter( 'rwmb_meta_boxes', array( $this, 'register_meta_boxes' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue' ), 99 );
	}

	public function register_meta_boxes( $meta_boxes ) {
		$meta_boxes[] = array(
			'title'      => __( 'Template Editor', 'auto-listings' ),
			'id'         => 'als-template-editor',
			'class'      => 'als-editors',
			'post_types' => array( 'auto-listings-search' ),
			'style'      => 'seamless',
			'fields'     => array(
				array(
					'type'     => 'custom_html',
					'callback' => array( $this, 'render_editors' ),
					'before'   => $this->render_inserter_and_toolbar(),
				),
			),
		);

		$post_id = rwmb_request()->filter_get( 'post', FILTER_SANITIZE_NUMBER_INT );
		if ( ! $post_id ) {
			return $meta_boxes;
		}

		$shortcode    = '[als id="' . $post_id . '"]';
		$meta_boxes[] = array(
			'title'      => __( 'Shortcode', 'auto-listings' ),
			'id'         => 'als-shortcode',
			'context'    => 'side',
			'priority'   => 'low',
			'post_types' => array( 'auto-listings-search' ),
			'fields'     => array(
				array(
					'type' => 'custom_html',
					'std'  => '<input type="text" class="regular-text" value="' . esc_attr( $shortcode ) . '" onclick="this.select()">',
				),
			),
		);

		return $meta_boxes;
	}

	public function render_editors() {
		return $this->render( 'editors' );
	}

	private function render_inserter_and_toolbar() {
		$inserter = $this->render( 'inserter' );
		$toolbar  = $this->render( 'toolbar' );

		return $inserter . $toolbar;
	}

	private function render( $name ) {
		ob_start();
		require AUTO_LISTINGS_DIR . "src/SearchForm/views/$name.php";
		return ob_get_clean();
	}

	public function admin_enqueue() {
		if ( ! $this->is_screen() ) {
			return;
		}
		wp_enqueue_code_editor(
			array(
				'type' => 'application/x-httpd-php',
			)
		);

		wp_enqueue_style( 'als-admin', AUTO_LISTINGS_URL . 'assets/admin/css/search-form.css', AUTO_LISTINGS_VERSION );
		wp_enqueue_script( 'als-admin', AUTO_LISTINGS_URL . 'assets/admin/js/search-form.js', array( 'code-editor', 'underscore', 'wp-element' ), AUTO_LISTINGS_VERSION, true );


		wp_localize_script( 'als-admin', 'als_admin', [
			'fields' => [
				'body_type'       => 'Body Type',
				'condition'       => 'Condition',
				'drivetrain'      => 'Drivetrain',
				'engine'          => 'Engine',
				'exterior_colors' => 'Exterior Colors',
				'fuel_type'       => 'Fuel Type',
				'make'            => 'Make',
				'max_price'       => 'Max Price',
				'min_price'       => 'Min Price',
				'model'           => 'Model',
				'odometer'        => 'Odometer',
				'price'           => 'Price',
				'transmission'    => 'Transmission',
				'within'          => 'Within',
				'year'            => 'Year',
				'button'          => 'Button',
				'total_listings'  => 'Total listings'
			],
			'translate' => [
				'label'        => __( 'Label', 'auto-listings' ),
				'type'         => __( 'Type', 'auto-listings' ),
				'placeholder'  => __( 'Placeholder', 'auto-listings' ),
				'prefix'       => __( 'Prefix', 'auto-listings' ),
				'suffix'       => __( 'Suffix', 'auto-listings' ),
				'multiple'     => __( 'Multiple', 'auto-listings' ),
				'insert_field' => __( 'Insert Field', 'auto-listings' ),
				'attributes'   => __( 'attributes', 'auto-listings' ),
				'reset'        => __( 'Reset', 'auto-listings' ),
				'submit'       => __( 'Submit', 'auto-listings' ),
				'select'       => __( 'Dropdown', 'auto-listings' ),
				'radio'        => __( 'Single Choice', 'auto-listings' ),
				'notice'       => __( 'Leave empty to use the default values', 'auto-listings' ),
				
			]
		]);
	}

	private function is_screen() {
		return 'auto-listings-search' === get_current_screen()->id;
	}
}
