<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


class Auto_Listings_Search_Form {


	/**
	 * Get things going
	 *
	 */
	public function __construct() {
		add_filter( 'wp', array( $this, 'has_shortcode' ) );
		add_filter( 'query_vars', array( $this, 'register_query_vars' ) );

		add_shortcode( 'auto_listings_search', array( $this, 'search_form' ) );
	}

	/**
	 * Check if we have the shortcode displayed
	 */
	public function has_shortcode() {
		global $post;

	    if ( is_a( $post, 'WP_Post' ) &&
	    	has_shortcode( $post->post_content, 'auto_listings_search') ) {
	        add_filter( 'is_auto_listings', array( $this, 'return_true' ) );
	    }
	}

	public function return_true() {
		return true;
	}

	/**
	 * Register custom query vars, based on our registered fields
	 *
	 * @link https://codex.wordpress.org/Plugin_API/Filter_Reference/query_vars
	 */
	public function register_query_vars( $vars ) {
		$vars[] = 'the_year';
		$vars[] = 'make';
		$vars[] = 'model';
		$vars[] = 'condition';
		$vars[] = 'min_price';
		$vars[] = 'max_price';
		$vars[] = 'body_type';
		$vars[] = 'odometer';
		$vars[] = 'within';
		$vars[] = 'area';
		return $vars;
	} 


	/*
	 * year field setup
	 */
	public function year_field() {	
		$data = auto_listings_search_get_vehicle_data();
		$year = $data['year'];
		$options = array();
		if( ! $year )
			return;
		foreach( $year as $n ){
		  	$options[$n] = $n;
		}
		$args = array(
			'name' => 'the_year',
			'label' => __( 'Year', 'auto-listings'),
		);
		return $this->multiple_select_field( $options, $args );
	}

	/*
	 * make field setup
	 */
	public function make_field() {	
		$data = auto_listings_search_get_vehicle_data();
		$make = $data['make'];
		$options = array();
		if( ! $make )
			return;
		foreach( $make as $n ){
		  	$options[$n] = $n;
		}
		$args = array(
			'name' => 'make',
			'label' => __( 'Make', 'auto-listings'),
		);
		return $this->multiple_select_field( $options, $args );
	}

	/*
	 * model field setup
	 */
	public function model_field() {	
		$data = auto_listings_search_get_vehicle_data();
		$model = $data['model'];
		$options = array();
		if( ! $model )
			return;
		foreach( $model as $n ){
		  	$options[$n] = $n;
		}
		$args = array(
			'name' => 'model',
			'label' => __( 'Model', 'auto-listings'),
		);
		return $this->multiple_select_field( $options, $args );
	}

	/*
	 * Condition field setup
	 */
	public function condition_field() {	
		$conditions = auto_listings_option( 'display_condition' );
		$options = array();
		if( ! $conditions )
			return;
		foreach( $conditions as $n ){
		  	$options[$n] = $n;
		}
		$args = array(
			'name' => 'condition',
			'label' => __( 'condition', 'auto-listings'),
			'prefix' => __( 'I\'m looking for ', 'auto-listings'),
		);
		return $this->multiple_select_field( $options, $args );
	}


	/*
	 * Min price field setup
	 */
	public function min_price_field() {	
		$min_max_price = auto_listings_search_price_min_max();
		$args = array(
			'name' => 'min_price',
			'label' => __( 'min', 'auto-listings'),
			'prefix' => __( 'priced from', 'auto-listings'),
		);
		return $this->select_field( $min_max_price, $args );
	}

	/*
	 * Max price field setup
	 */
	public function max_price_field() {	
		$min_max_price = auto_listings_search_price_min_max();
		$args = array(
			'name' => 'max_price',
			'label' => __( 'max', 'auto-listings'),
			'prefix' => __( 'to', 'auto-listings'),
		);
		return $this->select_field( $min_max_price, $args );
	}

	/*
	 * Within field setup
	 */
	public function within_field() {
		$key = auto_listings_option( 'maps_api_key' );
		if( empty( $key ) ) 
			return;	
		$radius = auto_listings_search_within_radius();
		$args = array(
			'name' => 'within',
			'label' => __( 'within', 'auto-listings'),
		);
		return $this->select_field( $radius, $args );
	}

	/*
	 * Body type field setup
	 */
	public function body_type_field() {	
		
		$body_types = get_terms( array(
		    'taxonomy' => 'body-type',
		    'hide_empty' => true,
		) );

		$options = array();

		if( $body_types ) {
			foreach ( $body_types as $key => $type ) {
				$options[$type->slug] = $type->name;
			}
		}
		$args = array(
			'name' => 'body_type',
			'label' => __( 'Body Type', 'auto-listings'),
		);
		return $this->multiple_select_field( $options, $args );
	}

	/*
	 * Odometer field setup
	 */
	public function odometer_field() {
		$odometer = auto_listings_search_mileage_max();
		$args = array(
			'name' => 'odometer',
			'label' => __( 'Max Mileage', 'auto-listings'),
		);
		return $this->select_field( $odometer, $args );
	}

	/**
	 * Build the form
	 *
	 */
	public function search_form( $atts ){

		$s = isset( $_GET['s'] ) ? sanitize_text_field( $_GET['s'] ) : '';

		$atts = shortcode_atts( array(
			'area_placeholder' 	=> __( 'State, Zip, Town', 'auto-listings' ),
			'submit_btn' 		=> __( 'Find My Car', 'auto-listings' ),
			'refine_text' 		=> __( 'More Refinements', 'auto-listings' ),
			'style' 			=> '1',
			'layout' 			=> '',
			'exclude' 			=> array(),
		), $atts );

		$exclude = ! empty( $atts['exclude'] ) ? array_map('trim', explode( ',', $atts['exclude'] ) ) : array();

		$output = '';
		ob_start();

		?>

		<form 
			id="auto-listings-search" 
			class="auto-listings-search s-<?php echo esc_attr( $atts['style'] ); ?> <?php echo esc_attr( $atts['layout'] ); ?>" autocomplete="off" 
			action="<?php echo esc_url( get_permalink( auto_listings_option( 'archives_page' ) ) ) ?>" 
			method="GET" 
			role="search">

			<?php if( $atts['layout'] != 'standard' ) { ?>

				<?php if( ! in_array( 'condition', $exclude ) ) { ?>
					<div class="row condition-wrap">
						<?php echo $this->condition_field(); ?>
					</div>
				<?php } ?>

				<?php if( ! in_array( 'prices', $exclude ) ) { ?>
					<div class="row price-wrap">
						<?php 
						if( ! in_array( 'min_price', $exclude ) ) { 
							echo $this->min_price_field(); 
						} 
						if( ! in_array( 'max_price', $exclude ) ) { 
						 	echo $this->max_price_field(); 
						} 
						?>
					</div>
				<?php } ?>

				<?php if( ! in_array( 'area', $exclude ) ) { ?>
					<div class="row area-wrap">
						<?php echo $this->within_field(); ?>
						<input class="field area" type="text" name="s" placeholder="<?php echo esc_html( $atts['area_placeholder'] ); ?>" value="<?php echo esc_attr( $s ); ?>" />
						<button class="al-button" type="submit"><?php echo esc_html( $atts['submit_btn'] ); ?></button>
					</div>
				<?php } ?>

				<?php if( ! in_array( 'refine', $exclude ) ) { ?>
					<a class="refine"><?php echo esc_html( $atts['refine_text'] ) ?> <i class="fa fa-angle-down"></i></a>

					<div class="row extras-wrap">
						<?php 
						if( ! in_array( 'year', $exclude ) ) {
							echo $this->year_field();
						}
						if( ! in_array( 'make', $exclude ) ) {
						echo $this->make_field();
						}
						if( ! in_array( 'model', $exclude ) ) {
						echo $this->model_field();
						}
						if( ! in_array( 'body_type', $exclude ) ) {
							echo $this->body_type_field();
						}
						if( ! in_array( 'odometer', $exclude ) ) {
							echo $this->odometer_field(); 
						}
						?>
					</div>
				<?php } ?>	

			<?php } else { ?>

				<?php 
				if( ! in_array( 'condition', $exclude ) ) {
					echo $this->condition_field();
				}
				if( ! in_array( 'prices', $exclude ) ) {
					if( ! in_array( 'min_price', $exclude ) ) {
						echo $this->min_price_field();
					}
					if( ! in_array( 'max_price', $exclude ) ) {
						echo $this->max_price_field();
					}
				}
				if( ! in_array( 'year', $exclude ) ) {
					echo $this->year_field();
				}
				if( ! in_array( 'make', $exclude ) ) {
					echo $this->make_field();
				}
				if( ! in_array( 'model', $exclude ) ) {
					echo $this->model_field();
				}
				if( ! in_array( 'body_type', $exclude ) ) {
					echo $this->body_type_field();
				}
				if( ! in_array( 'odometer', $exclude ) ) {
					echo $this->odometer_field();
				}
				if( ! in_array( 'area', $exclude ) ) {
					echo $this->within_field(); 
					?>
					<input class="field area" type="text" name="s" placeholder="<?php echo esc_html( $atts['area_placeholder'] ); ?>" value="<?php echo esc_attr( $s ); ?>" />
					<?php
				}
				?>

				<button class="al-button" type="submit"><?php echo esc_html( $atts['submit_btn'] ); ?></button>

			<?php } ?>
				
		</form>

		<?php

	    $output = ob_get_contents();
	    ob_end_clean();

	    return apply_filters( 'auto_listings_search_form_output', $output, $atts );

	}


	/*
	 * Select field
	 */
	public function select_field( $options, $args = array() ){	

		$output = '';
		ob_start();

		?>
		<div class="field <?php echo esc_attr( str_replace( '_', '-', $args['name'] ) ); ?>">
			
			<?php if( isset( $args['prefix'] ) ) {
				echo '<span class="prefix">' . esc_html( $args['prefix'] ) . '</span>';
			} ?>

			<select name="<?php echo esc_attr( $args['name'] ); ?>">
				
				<option value=""><?php echo esc_attr( $args['label'] ) ?></option>

				<?php if( ! empty( $options ) ) {

					foreach ( $options as $val => $text ) {

						$selected = isset( $_GET[$args['name']] ) && $_GET[$args['name']] == $val ? ' selected="selected"' : '';

						if( ! empty( $val ) ) { ?>
							<option value="<?php echo esc_attr( $val ); ?>" <?php echo esc_attr( $selected ); ?> ><?php echo esc_attr( $text ) ?></option>
						<?php } 
					
					}
				
				}

				?>

			</select>

			<?php if( isset( $args['suffix'] ) ) {
				echo '<span class="suffix">' . esc_html( $args['suffix'] ) . '</span>';
			} ?>

		</div>

		<?php

	    $output = ob_get_contents();
	    ob_end_clean();

	    return apply_filters( 'auto_listings_search_field' . $args['name'], $output );

	}


	/*
	 * Multi Select field
	 */
	public function multiple_select_field( $options, $args = array() ){	

		$output = '';
		ob_start();

		?>

		<div class="field <?php echo esc_attr( str_replace( '_', '-', $args['name'] ) ); ?>">

			<?php if( isset( $args['prefix'] ) ) {
				echo '<span class="prefix">' . esc_html( $args['prefix'] ) . '</span>';
			} ?>

			<?php // condition field. If we only have 1 condition, remove the select option
			if( $args['name'] == 'condition' && count( $options ) <= 1 ) { ?>

				<input type="hidden" name="condition[]" value="<?php echo esc_html( $this->conditions[0] ) ?>"/>
			
			<?php } else { ?>
				
			<select multiple="multiple" name="<?php echo esc_attr( $args['name'] ); ?>[]" placeholder="<?php echo esc_attr( $args['label'] ) ?>">
				
				<?php if( ! empty( $options ) ) {

					foreach ( $options as $val => $text ) {

						$selected = isset( $_GET[$args['name']] ) && in_array( $val, $_GET[$args['name']] )  == $val ? ' selected="selected"' : '';

						if( ! empty( $val ) ) { ?>
							<option value="<?php echo esc_attr( $val ); ?>" <?php echo esc_attr( $selected ); ?> ><?php echo esc_attr( $text ) ?></option>
						<?php } 
					
					}
				
				}

				?>

			</select>

			<?php } ?>

			<?php if( isset( $args['suffix'] ) ) {
				echo '<span class="suffix">' . esc_html( $args['suffix'] ) . '</span>';
			} ?>

		</div>

		<?php

	    $output = ob_get_contents();
	    ob_end_clean();

	    return apply_filters( 'auto_listings_multiple_search_field' . $args['name'], $output );

	}



}

return new Auto_Listings_Search_Form();