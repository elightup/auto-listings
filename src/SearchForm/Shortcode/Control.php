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
		] );

		$class_selected = empty( $_GET[ $args['name'] ] ) ? '' : 'als-is-selected';
		ob_start();
		?>

		<div class="als-field als-field--<?= esc_attr( str_replace( '_', '-', $args['name'] ) ); ?> <?= esc_attr( $class_selected ); ?>">
			<?php
			if ( $args['label'] ) {
				echo '<span class="als-field__label">', esc_html( $args['label'] ), '</span>';
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
		$selected = isset( $_GET[ $args['name'] ] ) ? filter_var( $_GET[ $args['name'] ], FILTER_SANITIZE_STRING ) : '';
		?>

		<select <?= 'true' === $args['multiple'] ? 'multiple' : '' ?> placeholder="<?= esc_attr( $args['placeholder'] ); ?>" name="<?= esc_attr( $args['name'] ); ?>">
			<?php foreach ( $options as $val => $text ) : ?>
				<option value="<?= esc_attr( $val ); ?>" <?php selected( $val, $selected ); ?>><?= esc_html( $text ); ?></option>
			<?php endforeach; ?>
		</select>

		<?php
	}

	private function radio( $options, $args ) {
		$selected = isset( $_GET[ $args['name'] ] ) ? filter_var( $_GET[ $args['name'] ], FILTER_SANITIZE_STRING ) : '';
		?>

		<span class="als-field__radio">
			<?php foreach ( $options as $val => $text ) : ?>
				<label>
					<input type="radio" <?php checked( $selected, $val ); ?> name="<?= esc_attr( $args['name'] ); ?>" value="<?= esc_attr( $val ); ?>">
					<span><?= esc_html( $text ); ?></span>
				</label>
			<?php endforeach; ?>
		</span>

		<?php
	}
}
