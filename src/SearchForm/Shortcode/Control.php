<?php
namespace AutoListings\SearchForm\Shortcode;

class Control {
	public function render( $options, $args ) {
		if ( empty( $options ) ) {
			return '';
		}

		$args = wp_parse_args( $args, [
			'type'        => 'select',
			'name'        => '',
			'label'       => '',
			'placeholder' => '',
			'prefix'      => '',
			'suffix'      => '',
			'id'          => uniqid(),
		] );

		$class_selected = empty( $_GET[ $args['name'] ] ) || $args['default'] ? '' : 'als-is-selected';
		ob_start();
		?>

		<div class="als-field als-field--<?= esc_attr( str_replace( '_', '-', $args['name'] ) ); ?> <?= esc_attr( $class_selected ); ?>">
			<?php
			if ( $args['label'] ) {
				echo '<label for="', esc_attr( $args['id'] ), '" class="als-field__label">', esc_html( $args['label'] ), '</label>';
			}

			if ( $args['prefix'] ) {
				echo '<span class="als-field__prefix">', esc_html( $args['prefix'] ), '</span>';
			}

			$this->{$args['type']}( $options, $args );

			if ( $args['suffix'] ) {
				echo '<span class="als-field__suffix">', esc_html( $args['suffix'] ), '</span>';
			}
			?>
		</div>

		<?php
		$output = ob_get_clean();
		return $output;
	}

	private function select( $options, $args ) {
		$is_multiple = $args['multiple'] === 'true' && ! in_array( $args['name'], [ 'price', 'min_price', 'max_price', 'odometer' ] );
		$is_disabled = $args['disabled'] === 'true';
		$default     = isset( $args['default'] ) ? array( $args['default'] ) : [];
		$selected    = isset( $_GET[ $args['name'] ] ) ? (array) $_GET[ $args['name'] ] : $default;
		$name        = $is_multiple ? $args['name'] . '[]' : $args['name'];
		?>

		<select
			id="<?= esc_attr( $args['id'] ); ?>"
			<?= $is_multiple ? 'multiple' : '' ?>
			<?= $is_disabled ? 'disabled' : '' ?>
			data-placeholder="<?= esc_attr( $args['placeholder'] ); ?>"
			name="<?= esc_attr( $name ); ?>"
		>

			<?php foreach ( $options as $value => $label ) : ?>

				<option value="<?= esc_attr( $value ); ?>" <?php selected( in_array( $value, $selected ) ); ?>><?= esc_html( $label ); ?></option>

			<?php endforeach; ?>

		</select>

		<?php
	}

	private function radio( $options, $args ) {
		$default         = isset( $args['default'] ) ? $args['default'] : '';
		$selected_option = isset( $_GET[ $args['name'] ] ) ? filter_var( $_GET[ $args['name'] ], FILTER_SANITIZE_STRING ) : $default;
		?>

		<span class="als-field__radio">
			<?php foreach ( $options as $val => $text ) : ?>
				<label>
					<input type="radio" <?php checked( $selected_option, $val ); ?> name="<?= esc_attr( $args['name'] ); ?>" value="<?= esc_attr( $val ); ?>">
					<span><?= esc_html( $text ); ?></span>
				</label>
			<?php endforeach; ?>
		</span>

		<?php
	}
}
