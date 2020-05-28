<?php
namespace AutoListings\SearchForm;

class Editor {
	public function __construct() {
		add_filter( 'rwmb_meta_boxes', array( $this, 'register_meta_boxes' ) );
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
}
