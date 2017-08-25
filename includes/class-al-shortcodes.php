<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class Auto_Listings_Shortcodes {

	public function __construct() {
		add_filter( 'wp', array( $this, 'has_shortcode' ) );
		add_shortcode( 'auto_listings_browse', array( $this, 'browse' ) );
		add_shortcode( 'auto_listings_listing', array( $this, 'listing' ) );
		add_shortcode( 'auto_listings_listings', array( $this, 'listings' ) );
	}

	/**
	 * Check if we have the shortcode displayed
	 */
	public function has_shortcode() {
		global $post;
	    if ( is_a( $post, 'WP_Post' ) && 
	    	( has_shortcode( $post->post_content, 'auto_listings_browse') || 
	    	has_shortcode( $post->post_content, 'auto_listings_listing') || 
	    	has_shortcode( $post->post_content, 'auto_listings_listings') ) )
	    {
	        add_filter( 'is_auto_listings', array( $this, 'return_true' ) );
	    }

	    if ( is_a( $post, 'WP_Post' ) && 
	    	has_shortcode( $post->post_content, 'auto_listings_listing') )
	    {
	        add_filter( 'is_listing', array( $this, 'return_true' ) );
	    }
	}

	/**
	 * Add this as a auto_listings page
	 *
	 * @param bool $return
	 * @return bool
	 */
	public function return_true( $return ) {
		return true;
	}

	/**
	 * Browse shortcode.
	 *
	 * @param array $atts
	 * @return string
	 */
	public function browse( $atts ) {
		
	}

	/**
	 * Loop over found listings.
	 * @param  array $query_args
	 * @param  array $atts
	 * @param  string $loop_name
	 * @return string
	 */
	private function listing_loop( $query_args, $atts, $loop_name ) {

		$listings = new WP_Query( apply_filters( 'auto_listings_shortcode_listings_query', $query_args, $atts, $loop_name ) );

		ob_start();

		if ( $listings->have_posts() ) { ?>

			<?php do_action( "auto_listings_shortcode_before_{$loop_name}_loop" ); ?>

			<ul class="auto-listings-items">

				<?php while ( $listings->have_posts() ) : $listings->the_post(); ?>

					<?php auto_listings_get_part( 'content-listing.php' ); ?>

				<?php endwhile; // end of the loop. ?>

			</ul>

			<?php do_action( "auto_listings_shortcode_after_{$loop_name}_loop" ); ?>

			<?php

		} else {
			do_action( "auto_listings_shortcode_{$loop_name}_loop_no_results" );
		}

		wp_reset_postdata();

		return ob_get_clean();
	}

	/**
	 * List multiple listings shortcode.
	 *
	 * @param array $atts
	 * @return string
	 */
	public function listings( $atts ) {
		$atts = shortcode_atts( array(
			'orderby' 		=> 'date',
			'order'   		=> 'asc',
			'number' 		=> '20',
			'seller' 		=> '', // id of the seller
			'ids'     		=> '',
			'compact'     	=> '',
		), $atts );

		$query_args = array(
			'post_type'           	=> 'auto-listing',
			'post_status'         	=> 'publish',
			'ignore_sticky_posts' 	=> 1,
			'orderby'             	=> $atts['orderby'],
			'order'               	=> $atts['order'],
			'posts_per_page'      	=> $atts['number'],
		);

		if ( ! empty( $atts['ids'] ) ) {
			$query_args['post__in'] = array_map( 'trim', explode( ',', $atts['ids'] ) );
		}

		if ( ! empty( $atts['seller'] ) ) {
			$query_args['meta_key'] 	= '_al_listing_seller';
			$query_args['meta_value'] 	= absint( $atts['seller'] );
			$query_args['meta_compare'] = '=';
		}


		// if we are in compact mode
		if ( ! empty( $atts['compact'] ) && $atts['compact'] == 'true' ) {
			remove_action( 'auto_listings_listings_loop_item', 'auto_listings_template_loop_at_a_glance', 40 );
			remove_action( 'auto_listings_listings_loop_item', 'auto_listings_template_loop_description', 50 );
			add_filter( 'post_class', array( $this, 'listings_compact_mode' ), 20, 3 );
		}

		return $this->listing_loop( $query_args, $atts, 'listings' );
	}

	/**
	 * Add the compact class to the listings
	 */
	public function listings_compact_mode( $classes, $class = '', $post_id = '' ) {
		$classes[] = 'compact';
		return $classes;
	}


	/**
	 * Display a single listing.
	 *
	 * @param array $atts
	 * @return string
	 */
	public function listing( $atts ) {
		if ( empty( $atts ) ) {
			return '';
		}

		$args = array(
			'post_type'      => 'auto-listing',
			'posts_per_page' => 1,
			'no_found_rows'  => 1,
			'post_status'    => 'publish',
		);

		if ( isset( $atts['id'] ) ) {
			$args['p'] = $atts['id'];
		}

		ob_start();

		$listings = new WP_Query( apply_filters( 'auto_listings_shortcode_listing_query', $args, $atts ) );

		if ( $listings->have_posts() ) : ?>

			<div id="listing-<?php the_ID(); ?>" class="auto-listings-single">

				<?php while ( $listings->have_posts() ) : $listings->the_post(); ?>

					<?php auto_listings_get_part( 'content-single-listing.php' ); ?>

				<?php endwhile; // end of the loop. ?>

			</div>

		<?php endif;

		wp_reset_postdata();

		return ob_get_clean();
	}


}


return new Auto_Listings_Shortcodes();