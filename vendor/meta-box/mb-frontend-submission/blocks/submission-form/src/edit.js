import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import {
	FormTokenField,
	PanelBody,
	SelectControl,
	TextControl,
	ToggleControl
} from '@wordpress/components';
import { subscribe } from '@wordpress/data';
import { useEffect, useRef } from '@wordpress/element';
import { doAction } from '@wordpress/hooks';
import { __ } from '@wordpress/i18n';
import ServerSideRender from '@wordpress/server-side-render';
import './editor.scss';

export default function Edit( { attributes, setAttributes } ) {
	const ref = useRef();

	let {
		meta_box_id, // @deprecated: use id instead. Previously, it's a string of field group IDs separated by commas.
		id,          // An array of field group IDs.
		ajax,
		allow_scroll,
		edit,
		allow_delete,
		force_delete,
		show_add_more,
		post_type,
		object_type = 'post',
		object_id,
		post_id,
		post_status,
		post_fields,
		label_title,
		label_content,
		label_excerpt,
		label_date,
		label_thumbnail,
		submit_button,
		add_button,
		delete_button,
		redirect,
		confirmation,
		delete_confirmation,
		recaptcha_key,
		recaptcha_secret,
	} = attributes;

	const post_statuses = Object.keys( mbfsData.post_statuses ).map( post_status => ( {
		label: post_status,
		value: post_status
	} ) );

	const update = key => value => setAttributes( { [ key ]: value } );

	if ( id.length === 0 && meta_box_id ) {
		id = meta_box_id.split( ',' );
	}
	// Remove invalid field group IDs.
	id = id.filter( i => mbfsData.field_groups.some( fg => fg.value === i ) );

	const selectedFieldGroups = mbfsData.field_groups.filter( fg => id.includes( fg.value ) );
	const postTypes = mbfsData.post_types.filter( pt => selectedFieldGroups.some( fg => fg.post_types.includes( pt.value ) ) );
	const objectTypes = mbfsData.object_types.filter( ot => selectedFieldGroups.some( fg => fg.object_type === ot.value ) );

	const fields = selectedFieldGroups.flatMap( fg => fg.fields );
	const postFieldsMap = {
		'post_title': 'title',
		'post_content': 'content',
		'post_excerpt': 'excerpt',
		'post_date': 'date',
		'_thumbnail_id': 'thumbnail'
	};
	const postFieldsInFieldGroups = fields.filter( field => postFieldsMap[ field ] ).map( field => postFieldsMap[ field ] );
	const postFields = [
		'title',
		'content',
		'excerpt',
		'date',
		'thumbnail'
	].filter( field => !postFieldsInFieldGroups.includes( field ) );

	useEffect( () => {
		if ( objectTypes.length === 1 ) {
			setAttributes( { object_type: objectTypes[ 0 ].value } );
		}
	}, [ objectTypes ] );

	useEffect( () => {
		if ( postTypes.length === 1 ) {
			setAttributes( { post_type: postTypes[ 0 ].value } );
		}
	}, [ postTypes ] );

	const triggerEvents = () => {
		doAction( 'mb_ready', ref.current );
		// $( ref.current ).trigger( 'mb_ready' )
		// 	.trigger( 'mb-blocks-edit-ready' ); // Run Conditional Logic.
	};

	useEffect( () => {
		const unsubscribe = subscribe( () => {
			const fetched = ref?.current?.querySelector( '.rwmb-field' );

			if ( fetched ) {
				triggerEvents();
				unsubscribe(); // Stop listening once content is detected
			}
		} );

		return () => {
			unsubscribe();
		};
	}, [] );

	return (
		<div { ...useBlockProps( { ref } ) }>
			<InspectorControls>
				<PanelBody title={ __( 'Settings', 'mb-frontend-submission' ) }>
					<FormTokenField
						__experimentalAutoSelectFirstMatch
						__experimentalExpandOnFocus
						label={ __( 'Field group', 'mb-frontend-submission' ) }
						value={ id }
						onChange={ update( 'id' ) }
						suggestions={ mbfsData.field_groups }
						saveTransform={ item => item?.value || '' }
						displayTransform={ item => mbfsData.field_groups.find( fg => fg.value === ( typeof item === 'string' ? item : item.value ) )?.label || '' }
					/>
					<ToggleControl
						label={ __( 'Enable ajax submission', 'mb-frontend-submission' ) }
						checked={ ajax }
						onChange={ update( 'ajax' ) }
					/>
					<ToggleControl
						label={ __( 'Allow to edit after submitting', 'mb-frontend-submission' ) }
						help={ __( 'If enabled, then ajax submission will be disabled.', 'mb-frontend-submission' ) }
						checked={ edit }
						onChange={ update( 'edit' ) }
					/>
					<ToggleControl
						label={ __( 'Allow to delete the entry', 'mb-frontend-submission' ) }
						help={ __( 'Allow users to delete the submitted entry.', 'mb-frontend-submission' ) }
						checked={ allow_delete }
						onChange={ update( 'allow_delete' ) }
					/>
					{
						object_type === 'post' && allow_delete && (
							<ToggleControl
								label={ __( 'Force delete', 'mb-frontend-submission' ) }
								help={ __( 'Whether to delete the submitted entry permanently or temporarily (move to Trash).', 'mb-frontend-submission' ) }
								checked={ force_delete }
								onChange={ update( 'force_delete' ) }
							/>
						)
					}
					<ToggleControl
						label={ __( 'Allow to add more entries', 'mb-frontend-submission' ) }
						checked={ show_add_more }
						onChange={ update( 'show_add_more' ) }
					/>
					{
						objectTypes.length > 1 && (
							<SelectControl
								label={ __( 'Object type', 'mb-frontend-submission' ) }
								value={ object_type }
								options={ objectTypes }
								onChange={ update( 'object_type' ) }
							/>
						)
					}
					<TextControl
						label={ __( 'Object ID', 'mb-frontend-submission' ) }
						help={ __( 'The object id, used when you want to update an existing entry.', 'mb-frontend-submission' ) }
						value={ object_id }
						onChange={ update( 'object_id' ) }
					/>
					{
						object_type === 'post' && (
							<>
								{
									postTypes.length > 1 && (
										<SelectControl
											label={ __( 'Post type', 'mb-frontend-submission' ) }
											value={ post_type }
											options={ [
												{ label: __( '-', 'mb-frontend-submission' ), value: '' },
												...postTypes
											] }
											onChange={ update( 'post_type' ) }
										/>
									)
								}
								<SelectControl
									label={ __( 'Post status', 'mb-frontend-submission' ) }
									value={ post_status }
									options={ [
										{ label: '-', value: '' },
										...post_statuses
									] }
									onChange={ update( 'post_status' ) }
								/>
								{
									postFields.length > 0 && (
										<FormTokenField
											__experimentalAutoSelectFirstMatch
											__experimentalExpandOnFocus
											label={ __( 'Post fields', 'mb-frontend-submission' ) }
											help={ __( 'List of post fields you want to show in the frontend.', 'mb-frontend-submission' ) }
											value={ post_fields }
											suggestions={ postFields }
											onChange={ update( 'post_fields' ) }
										/>
									)
								}
							</>
						)
					}
					<TextControl
						label={ __( 'Custom redirect URL', 'mb-frontend-submission' ) }
						value={ redirect }
						onChange={ update( 'redirect' ) }
					/>
				</PanelBody>
				<PanelBody title={ __( 'Appearance', 'mb-frontend-submission' ) } initialOpen={ false }>
					<ToggleControl
						label={ __( 'Allow scroll', 'mb-frontend-submission' ) }
						help={ __( 'Enable scroll to the message after ajax submission.', 'mb-frontend-submission' ) }
						checked={ allow_scroll }
						onChange={ update( 'allow_scroll' ) }
					/>
					<TextControl
						label={ __( 'Confirmation text', 'mb-frontend-submission' ) }
						help={ __( 'The text for the confirmation message when the form is successfully submitted.', 'mb-frontend-submission' ) }
						value={ confirmation }
						onChange={ update( 'confirmation' ) }
					/>
					<TextControl
						label={ __( 'Delete confirmation text', 'mb-frontend-submission' ) }
						help={ __( 'The text for the confirmation message when the entry is deleted.', 'mb-frontend-submission' ) }
						value={ delete_confirmation }
						onChange={ update( 'delete_confirmation' ) }
					/>
					<TextControl
						label={ __( 'Submit button text', 'mb-frontend-submission' ) }
						value={ submit_button }
						onChange={ update( 'submit_button' ) }
					/>
					<TextControl
						label={ __( 'Add new button text', 'mb-frontend-submission' ) }
						value={ add_button }
						onChange={ update( 'add_button' ) }
					/>
					<TextControl
						label={ __( 'Delete button text', 'mb-frontend-submission' ) }
						value={ delete_button }
						onChange={ update( 'delete_button' ) }
					/>
				</PanelBody>
				{
					object_type === 'post' && post_fields.length > 0 && (
						<PanelBody title={ __( 'Post fields labels', 'mb-frontend-submission' ) } initialOpen={ false }>
							{
								post_fields.includes( 'title' ) && (
									<TextControl
										label={ __( 'Title', 'mb-frontend-submission' ) }
										value={ label_title }
										onChange={ update( 'label_title' ) }
									/>
								)
							}
							{
								post_fields.includes( 'content' ) && (
									<TextControl
										label={ __( 'Content', 'mb-frontend-submission' ) }
										value={ label_content }
										onChange={ update( 'label_content' ) }
									/>
								)
							}
							{
								post_fields.includes( 'excerpt' ) && (
									<TextControl
										label={ __( 'Excerpt', 'mb-frontend-submission' ) }
										value={ label_excerpt }
										onChange={ update( 'label_excerpt' ) }
									/>
								)
							}
							{
								post_fields.includes( 'date' ) && (
									<TextControl
										label={ __( 'Date', 'mb-frontend-submission' ) }
										value={ label_date }
										onChange={ update( 'label_date' ) }
									/>
								)
							}
							{
								post_fields.includes( 'thumbnail' ) && (
									<TextControl
										label={ __( 'Thumbnail', 'mb-frontend-submission' ) }
										value={ label_thumbnail }
										onChange={ update( 'label_thumbnail' ) }
									/>
								)
							}
						</PanelBody>
					)
				}
				<PanelBody title={ __( 'Google reCaptcha (v3)', 'mb-frontend-submission' ) } initialOpen={ false }>
					<TextControl
						label={ __( 'Site key', 'mb-frontend-submission' ) }
						value={ recaptcha_key }
						onChange={ update( 'recaptcha_key' ) }
					/>
					<TextControl
						label={ __( 'Secret key', 'mb-frontend-submission' ) }
						value={ recaptcha_secret }
						onChange={ update( 'recaptcha_secret' ) }
					/>
				</PanelBody>
			</InspectorControls>
			<ServerSideRender
				block="meta-box/submission-form"
				attributes={ attributes }
			/>
		</div>
	);
}
