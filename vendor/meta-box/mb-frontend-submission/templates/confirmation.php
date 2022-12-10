<?php
/**
 * The template file for the confirmation message.
 *
 * @package    Meta Box
 * @subpackage MB Frontend Submission
 */

$request = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
?>
<div class="rwmb-confirmation"><?= esc_html( $data->confirmation ); ?></div>
<?php if ( 'true' === $data->show_add_more ) : ?>
	<a class="rwmb-button" href="<?= esc_url( strtok( $request, '?' ) ); ?>"><?= esc_html( $data->add_button ); ?></a>
<?php endif; ?>