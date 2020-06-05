<?php
/**
 * Test simple form with default HTML inputs.
 *
 * @package    Meta Box
 * @subpackage MB Frontend Submission
 */


add_filter(
	'rwmb_meta_boxes',
	function ( $meta_boxes ) {
		$meta_boxes[] = [
			'title'  => 'multiple form 1',
			'id'     => 'multiple-form',
			'fields' => [
				[
					'name'              => 'Text',
					'label_description' => 'Some description',
					'id'                => 'text',
					'desc'              => 'Text description',
					'type'              => 'text',
					'std'               => 'Default text value',
					'clone'             => true,
				],
				[
					'name' => 'Checkbox',
					'id'   => 'checkbox',
					'type' => 'checkbox',
					'std'  => 1,
				],
				[
					'name'    => 'Radio',
					'id'      => 'radio',
					'type'    => 'radio',
					'options' => [
						'value1' => 'Label1',
						'value2' => 'Label2',
					],
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
				],
				[
					'id'   => 'hidden',
					'type' => 'hidden',
					'std'  => 'Hidden value',
				],
				[
					'name' => 'Password',
					'id'   => 'password',
					'type' => 'password',
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

		$meta_boxes[] = [
			'title'  => 'multiple form 2',
			'id'     => 'multiple-form-2',
			'fields' => [
				[
					'name'              => 'Text demo 2',
					'label_description' => 'Some description',
					'id'                => 'text-2',
					'desc'              => 'Text description',
					'type'              => 'text',
					'std'               => 'Default text value',
					'clone'             => true,
				],
				[
					'name' => 'Checkbox 2',
					'id'   => 'checkbox-2',
					'type' => 'checkbox',
					'std'  => 1,
				],
				[
					'name'    => 'Radio 2',
					'id'      => 'radio-2',
					'type'    => 'radio',
					'options' => [
						'value1' => 'Label1',
						'value2' => 'Label2',
					],
				],
				[
					'name'        => 'Select 2',
					'id'          => 'select-2',
					'type'        => 'select',
					'options'     => [
						'value1' => 'Label1',
						'value2' => 'Label2',
					],
					'multiple'    => false,
					'std'         => 'value2',
					'placeholder' => 'Select an Item',
				],
				[
					'id'   => 'hidden-2',
					'type' => 'hidden',
					'std'  => 'Hidden value',
				],
				[
					'name' => 'Password 2',
					'id'   => 'password-2',
					'type' => 'password',
				],
				[
					'name' => 'Textarea 2',
					'desc' => 'Textarea description',
					'id'   => 'textarea-2',
					'type' => 'textarea',
					'cols' => 20,
					'rows' => 3,
				],
			],
		];
		return $meta_boxes;
	}
);

add_filter(
	'the_content',
	function ( $content ) {
		$content .= do_shortcode( '[mb_frontend_form id="multiple-form,multiple-form-2"]' );
		return $content;
	}
);

