<?php
/**
 * Listings search form.
 *
 * @package Auto Listings.
 */

namespace AutoListings;

/**
 * Class SearchForm
 */
class SearchForm {
	/**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {
		add_filter( 'wp', [ $this, 'has_shortcode' ] );
		add_filter( 'query_vars', [ $this, 'register_query_vars' ] );
		add_shortcode( 'auto_listings_search', [ $this, 'search_form' ] );
	}

	/**
	 * Check if we have the shortcode displayed
	 */
	public function has_shortcode() {
		global $post;

		if ( is_a( $post, 'WP_Post' ) && ( has_shortcode( $post->post_content, 'auto_listings_search' ) || has_shortcode( $post->post_content, 'als' ) ) ) {
			add_filter( 'is_auto_listings', '__return_true' );
		}
	}

	/**
	 * Register query vars.
	 *
	 * @param array $vars query vars.
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
		return apply_filters( 'auto_listings_query_vars', $vars );
	}

	/**
	 * Search Form shortcode.
	 *
	 * @param array $atts shortcode attributes.
	 */
	public function search_form( $atts ) {
		$s = isset( $_GET['s'] ) ? sanitize_text_field( $_GET['s'] ) : '';

		$atts = shortcode_atts(
			[
				'area_placeholder' => __( 'State, Zip, Town', 'auto-listings' ),
				'submit_btn'       => __( 'Find My Car', 'auto-listings' ),
				'refine_text'      => __( 'More Refinements', 'auto-listings' ),
				'style'            => '1',
				'layout'           => '',
				'exclude'          => [],
			],
			$atts
		);

		$exclude = ! empty( $atts['exclude'] ) ? array_map( 'trim', explode( ',', $atts['exclude'] ) ) : [];

		ob_start();
		?>

		<form
			id="auto-listings-search" class="auto-listings-search s-<?php echo esc_attr( $atts['style'] ); ?> <?php echo esc_attr( $atts['layout'] ); ?>" autocomplete="off"
			action="<?php the_permalink( auto_listings_option( 'archives_page' ) ); ?>"
			method="GET"
			role="search">
			<?php if ( 'standard' !== $atts['layout'] ) : ?>

				<?php if ( ! in_array( 'condition', $exclude, true ) ) : ?>
					<div class="row condition-wrap">
						<?php echo $this->condition_field(); // wpcs xss: ok. ?>
					</div>
				<?php endif; ?>

				<?php if ( ! in_array( 'prices', $exclude, true ) ) : ?>
					<div class="row price-wrap">
						<?php
						if ( ! in_array( 'min_price', $exclude, true ) ) {
							echo $this->min_price_field(); // wpcs xss: ok.
						}
						if ( ! in_array( 'max_price', $exclude, true ) ) {
							echo $this->max_price_field(); // wpcs xss: ok.
						}
						?>
					</div>
				<?php endif; ?>

				<?php if ( ! in_array( 'area', $exclude, true ) ) : ?>
					<div class="row area-wrap">
						<?php echo $this->within_field(); // wpcs xss: ok. ?>
						<input class="field area" type="text" name="s" placeholder="<?php echo esc_attr( $atts['area_placeholder'] ); ?>" value="<?php echo esc_attr( $s ); ?>"/>
						<button class="al-button" type="submit"><?php echo esc_html( $atts['submit_btn'] ); ?></button>
					</div>
				<?php else : ?>
					<div class="row area-wrap">
						<input type="hidden" name="s" value="<?php echo esc_attr( $s ); ?>"/>
						<button class="al-button" type="submit"><?php echo esc_html( $atts['submit_btn'] ); ?></button>
					</div>
				<?php endif; ?>

				<?php if ( ! in_array( 'refine', $exclude, true ) ) : ?>
					<a class="refine"><?php echo esc_html( $atts['refine_text'] ); ?><i class="fa fa-angle-down"></i></a>

					<div class="row extras-wrap">
						<?php
						if ( ! in_array( 'year', $exclude, true ) ) {
							echo $this->year_field(); // wpcs xss: ok.
						}
						if ( ! in_array( 'make', $exclude, true ) ) {
							echo $this->make_field(); // wpcs xss: ok.
						}
						if ( ! in_array( 'model', $exclude, true ) ) {
							echo $this->model_field(); // wpcs xss: ok.
						}
						if ( ! in_array( 'body_type', $exclude, true ) ) {
							echo $this->body_type_field(); // wpcs xss: ok.
						}
						if ( ! in_array( 'odometer', $exclude, true ) ) {
							echo $this->odometer_field(); // wpcs xss: ok.
						}
						do_action( 'auto_listings_extra_search_fields', $exclude );
						?>
					</div>
				<?php endif; ?>

			<?php else : ?>

				<?php
				if ( ! in_array( 'condition', $exclude, true ) ) {
					echo $this->condition_field(); // wpcs xss: ok.
				}
				if ( ! in_array( 'prices', $exclude, true ) ) {
					if ( ! in_array( 'min_price', $exclude, true ) ) {
						echo $this->min_price_field(); // wpcs xss: ok.
					}
					if ( ! in_array( 'max_price', $exclude, true ) ) {
						echo $this->max_price_field(); // wpcs xss: ok.
					}
				}
				if ( ! in_array( 'year', $exclude, true ) ) {
					echo $this->year_field(); // wpcs xss: ok.
				}
				if ( ! in_array( 'make', $exclude, true ) ) {
					echo $this->make_field(); // wpcs xss: ok.
				}
				if ( ! in_array( 'model', $exclude, true ) ) {
					echo $this->model_field(); // wpcs xss: ok.
				}
				if ( ! in_array( 'body_type', $exclude, true ) ) {
					echo $this->body_type_field(); // wpcs xss: ok.
				}
				if ( ! in_array( 'odometer', $exclude, true ) ) {
					echo $this->odometer_field(); // wpcs xss: ok.
				}
				if ( ! in_array( 'area', $exclude, true ) ) :
					echo $this->within_field(); // wpcs xss: ok.
					?>
					<input class="field area" type="text" name="s" placeholder="<?php echo esc_attr( $atts['area_placeholder'] ); ?>" value="<?php echo esc_attr( $s ); ?>">
				<?php else : ?>
					<input type="hidden" name="s" value="<?php echo esc_attr( $s ); ?>"/>
				<?php endif; ?>

				<button class="al-button" type="submit"><?php echo esc_html( $atts['submit_btn'] ); ?></button>

			<?php endif; ?>
		</form>

		<?php
		$output = ob_get_clean();
		return apply_filters( 'auto_listings_search_form_output', $output, $atts );
	}

	/**
	 * Year field
	 */
	public function year_field() {
		$data    = auto_listings_search_get_vehicle_data();
		$year    = $data['the_year'];
		$options = [];
		
		if ( ! $year ) {
			return '';
		}
		foreach ( $year as $n ) {
			$options[ $n ] = $n;
		}
		$args = [
			'name'  => 'the_year',
			'label' => __( 'Year', 'auto-listings' ),
		];
		return $this->multiple_select_field( $options, $args );
	}

	/**
	 * Make field
	 */
	public function make_field() {
		$data    = auto_listings_search_get_vehicle_data();
		$make    = $data['make'];
		$options = [];
		if ( ! $make ) {
			return '';
		}
		foreach ( $make as $n ) {
			$options[ $n ] = $n;
		}
		$args = [
			'name'  => 'make',
			'label' => __( 'Make', 'auto-listings' ),
		];
		return $this->multiple_select_field( $options, $args );
	}

	/**
	 * Model field
	 */
	public function model_field() {
		$data    = auto_listings_search_get_vehicle_data();
		$model   = $data['model'];
		$options = [];
		if ( ! $model ) {
			return '';
		}
		foreach ( $model as $n ) {
			$options[ $n ] = $n;
		}
		$args = [
			'name'  => 'model',
			'label' => __( 'Model', 'auto-listings' ),
		];
		return $this->multiple_select_field( $options, $args );
	}

	/**
	 * Condition field
	 */
	public function condition_field() {
		$options = auto_listings_available_listing_conditions();
		if ( ! $options ) {
			return '';
		}
		$args = [
			'name'   => 'condition',
			'label'  => __( 'condition', 'auto-listings' ),
			'prefix' => __( 'I\'m looking for ', 'auto-listings' ),
		];
		return $this->multiple_select_field( $options, $args );
	}

	/**
	 * Min price field
	 */
	public function min_price_field() {
		$min_max_price = auto_listings_search_price_min_max();
		$args          = [
			'name'   => 'min_price',
			'label'  => __( 'min', 'auto-listings' ),
			'prefix' => __( 'priced from', 'auto-listings' ),
		];
		return $this->select_field( $min_max_price, $args );
	}

	/**
	 * Max price field
	 */
	public function max_price_field() {
		$min_max_price = auto_listings_search_price_min_max();
		$args          = [
			'name'   => 'max_price',
			'label'  => __( 'max', 'auto-listings' ),
			'prefix' => __( 'to', 'auto-listings' ),
		];
		return $this->select_field( $min_max_price, $args );
	}

	/**
	 * Within field
	 */
	public function within_field() {
		$radius = auto_listings_search_within_radius();
		$args   = [
			'name'  => 'within',
			'label' => __( 'within', 'auto-listings' ),
		];
		return $this->select_field( $radius, $args );
	}

	/**
	 * Body type field
	 */
	public function body_type_field() {
		$body_types = get_terms(
			[
				'taxonomy'   => 'body-type',
				'hide_empty' => true,
			]
		);

		$options = [];

		if ( $body_types ) {
			foreach ( $body_types as $key => $type ) {
				$options[ $type->slug ] = $type->name;
			}
		}
		$args = [
			'name'  => 'body_type',
			'label' => __( 'Body Type', 'auto-listings' ),
		];
		return $this->multiple_select_field( $options, $args );
	}

	/**
	 * Odometer field
	 */
	public function odometer_field() {
		$odometer = auto_listings_search_mileage_max();
		$args     = [
			'name'  => 'odometer',
			'label' => __( 'Max Mileage', 'auto-listings' ),
		];
		return $this->select_field( $odometer, $args );
	}

	/**
	 * Select field
	 *
	 * @param array $options Field options.
	 * @param array $args Field arguments.
	 */
	public function select_field( $options, $args = [] ) {
		if ( empty( $options ) ) {
			return '';
		}
		$selected = isset( $_GET[ $args['name'] ] ) ? $_GET[ $args['name'] ] : '';
		ob_start();
		?>
		<div class="field <?php echo esc_attr( str_replace( '_', '-', $args['name'] ) ); ?>">

			<?php
			if ( isset( $args['prefix'] ) ) {
				echo '<span class="prefix">' . esc_html( $args['prefix'] ) . '</span>';
			}
			?>

			<select placeholder="<?php echo esc_attr( $args['label'] ); ?>" name="<?php echo esc_attr( $args['name'] ); ?>">
				<option value=""><?php echo esc_attr( $args['label'] ); ?></option>

				<?php foreach ( $options as $val => $text ) : ?>
					<option value="<?php echo esc_attr( $val ); ?>" <?php selected( $val, $selected ); ?> ><?php echo esc_attr( $text ); ?></option>
				<?php endforeach; ?>
			</select>

			<?php
			if ( isset( $args['suffix'] ) ) {
				echo '<span class="suffix">' . esc_html( $args['suffix'] ) . '</span>';
			}
			?>

		</div>

		<?php
		$output = ob_get_clean();
		return apply_filters( 'auto_listings_search_field' . $args['name'], $output );
	}

	/**
	 * Multiple select field
	 *
	 * @param array $options Field options.
	 * @param array $args Field arguments.
	 */
	public function multiple_select_field( $options, $args = [] ) {
		if ( empty( $options ) ) {
			return '';
		}
		ob_start();
		$selected = isset( $_GET[ $args['name'] ] ) ? $_GET[ $args['name'] ] : [];
		?>

		<div class="field <?php echo esc_attr( str_replace( '_', '-', $args['name'] ) ); ?>">

			<?php
			if ( isset( $args['prefix'] ) ) {
				echo '<span class="prefix">' . esc_html( $args['prefix'] ) . '</span>';
			}
			// Condition field. If we only have 1 condition, remove the select option.
			if ( 'condition' === $args['name'] && count( $options ) <= 1 ) :
				?>

				<input type="hidden" name="condition[]" value="<?php echo esc_html( key( $options ) ); ?>"/>

			<?php else : ?>

				<select multiple="multiple" placeholder="<?php echo esc_attr( $args['label'] ); ?>" name="<?php echo esc_attr( $args['name'] ); ?>[]">

					<?php foreach ( $options as $val => $text ) : ?>
						<option value="<?php echo esc_attr( $val ); ?>" <?php selected( true, in_array( strval( $val ), $selected, true ) ); ?> ><?php echo esc_attr( $text ); ?></option>
					<?php endforeach; ?>

				</select>

			<?php endif; ?>

			<?php
			if ( isset( $args['suffix'] ) ) {
				echo '<span class="suffix">' . esc_html( $args['suffix'] ) . '</span>';
			}
			?>

		</div>

		<?php
		$output = ob_get_clean();
		return apply_filters( 'auto_listings_multiple_search_field' . $args['name'], $output );
	}
}
