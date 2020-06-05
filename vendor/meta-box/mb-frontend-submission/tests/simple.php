<?php
/**
 * Test simple form with default HTML inputs.
 *
 * @package    Meta Box
 * @subpackage MB Frontend Submission
 */

add_filter( 'rwmb_meta_boxes', function ( $meta_boxes ) {
	$meta_boxes[] = [
		'title'  => 'Simple form',
		'id'     => 'simple-form',
		'fields' => [
			[
				'name'              => 'Text',
				'label_description' => 'Some description',
				'id'                => 'text',
				'desc'              => 'Text description',
				'type'              => 'text',
				'std'               => 'Default text value',
				'clone'             => true,
				'columns'           => 6,
			],
			[
				'name'    => 'Checkbox',
				'id'      => 'checkbox',
				'type'    => 'checkbox',
				'std'     => 1,
				'columns' => 6,
			],
			[
				'name'    => 'Radio',
				'id'      => 'radio',
				'type'    => 'radio',
				'options' => [
					'value1' => 'Label1',
					'value2' => 'Label2',
				],
				'columns' => 6,
			],
			[
				'name'        => 'Select',
				'id'          => 'select',
				'type'        => 'select',
				'options'     => [
					'value1' => 'Label1',
					'value2' => 'Label2',
				],
				'multiple'    => false,
				'std'         => 'value2',
				'placeholder' => 'Select an Item',
				'columns'     => 6,
			],
			[
				'type'  => 'heading',
				'name'  => 'Custom Heading',
				'class' => 'my-class',
			],
			[
				'id'   => 'hidden',
				'type' => 'hidden',
				'std'  => 'Hidden value',
			],
			[
				'name'    => 'Password',
				'id'      => 'password',
				'type'    => 'password',
				'columns' => 12,
			],
			[
				'name' => 'Textarea',
				'desc' => 'Textarea description',
				'id'   => 'textarea',
				'type' => 'textarea',
				'cols' => 20,
				'rows' => 3,
			],
		],
	];

	return $meta_boxes;
} );

add_filter( 'the_content', function ( $content ) {
	if ( is_page() ) {
		$content .= do_shortcode( '[mb_frontend_form id="simple-form" post_fields="title, content"]' );
	}
	return $content;
} );
