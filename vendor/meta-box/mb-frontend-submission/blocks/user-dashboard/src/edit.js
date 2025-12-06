import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import {
	FormTokenField,
	PanelBody,
	SelectControl,
	TextControl,
	ToggleControl
} from '@wordpress/components';
import { useEffect } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import ServerSideRender from '@wordpress/server-side-render';
import './editor.scss';

export default function Edit( { attributes, setAttributes } ) {
	let {
		edit_page,
		meta_box_id, // @deprecated: use id instead. Previously, it's a string of field group IDs separated by commas.
		id,          // An array of field group IDs.
		post_type = '',
		object_type = '',
		model_name = '',
		show_welcome_message,
		columns,
		label_title,
		label_date,
		label_status,
		label_actions,
		title_link,
		add_new
	} = attributes;

	const update = key => value => setAttributes( { [ key ]: value } );

	if ( id.length === 0 && meta_box_id ) {
		id = meta_box_id.split( ',' );
	}
	// Remove invalid field group IDs.
	id = id.filter( i => mbudData.field_groups.some( fg => fg.value === i ) );

	const all_models = Object.entries( mbudData.all_models ).map( ( [ value, label ] ) => ( { value: label, label } ) );
	const fields = mbudData.fields_suggestion;

	useEffect( () => {
		if ( object_type === 'model' && all_models.length === 1 ) {
			setAttributes( { model_name: all_models[ 0 ].value } );
		}
	}, [ object_type, all_models ] );

	useEffect( () => {
		if ( object_type === 'post' && mbudData.post_types.length === 1 ) {
			setAttributes( { post_type: mbudData.post_types[ 0 ].value } );
		}
	}, [ object_type, mbudData.post_types ] );

	return (
		<div { ...useBlockProps() }>
			<InspectorControls>
				<PanelBody title={ __( 'Settings', 'mb-dashboard' ) }>
					<SelectControl
						label={ __( 'Edit page', 'mb-frontend-submission' ) }
						help={ __( 'Choose a page where users can edit their submissions.', 'mb-frontend-submission' ) }
						value={ edit_page }
						options={ [
							{ label: __( '-', 'mb-frontend-submission' ), value: '' },
							...mbudData.pages
						] }
						onChange={ update( 'edit_page' ) }
					/>
					<FormTokenField
						__experimentalAutoSelectFirstMatch
						__experimentalExpandOnFocus
						label={ __( 'Columns', 'mb-frontend-submission' ) }
						value={ columns }
						suggestions={ fields }
						onChange={ update( 'columns' ) }
					/>
					{
						object_type !== 'model' && (
							<SelectControl
								label={ __( 'Title link', 'mb-frontend-submission' ) }
								help={ __( 'The link action when clicking post titles.', 'mb-frontend-submission' ) }
								value={ title_link }
								options={ [
									{ label: __( 'View', 'mb-frontend-submission' ), value: 'view' },
									{ label: __( 'Edit', 'mb-frontend-submission' ), value: 'edit' },
								] }
								onChange={ update( 'title_link' ) }
							/>
						)
					}
					<TextControl
						label={ __( 'Add new button text', 'mb-dashboard' ) }
						value={ add_new }
						onChange={ update( 'add_new' ) }
					/>
				</PanelBody>
				<PanelBody title={ __( 'Appearance', 'mb-dashboard' ) } initialOpen={ false }>
					<ToggleControl
						label={ __( 'Show welcome message', 'mb-frontend-submission' ) }
						checked={ show_welcome_message }
						onChange={ update( 'show_welcome_message' ) }
					/>
					{
						object_type !== 'model' && (
							<>
								<TextControl
									label={ __( 'Title column label', 'mb-dashboard' ) }
									value={ label_title }
									onChange={ update( 'label_title' ) }
								/>
								<TextControl
									label={ __( 'Date column label', 'mb-dashboard' ) }
									value={ label_date }
									onChange={ update( 'label_date' ) }
								/>
								<TextControl
									label={ __( 'Status column label', 'mb-dashboard' ) }
									value={ label_status }
									onChange={ update( 'label_status' ) }
								/>
							</>
						)
					}
					<TextControl
						label={ __( 'Actions column label', 'mb-dashboard' ) }
						value={ label_actions }
						onChange={ update( 'label_actions' ) }
					/>
				</PanelBody>
				<PanelBody title={ __( 'Overwrite page edit attributes', 'mb-dashboard' ) } initialOpen={ false }>
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
					{
						mbudData.object_types.length > 1 && (
							<SelectControl
								label={ __( 'Object type', 'mb-frontend-submission' ) }
								help={ __( 'Object type of the submissions', 'mb-frontend-submission' ) }
								value={ object_type }
								options={ [
									{ label: '-', value: '' },
									...mbudData.object_types
								] }
								onChange={ update( 'object_type' ) }
							/>
						)
					}
					{
						object_type === 'model' && all_models.length > 1 && (
							<SelectControl
								label={ __( 'Model name', 'mb-frontend-submission' ) }
								help={ __( 'Select related model for the submissions', 'mb-frontend-submission' ) }
								value={ model_name }
								options={ [
									{ label: '-', value: '' },
									...all_models
								] }
								onChange={ update( 'model_name' ) }
							/>
						)
					}
					{
						object_type === 'post' && mbudData.post_types.length > 1 && (
							<SelectControl
								label={ __( 'Post type', 'mb-frontend-submission' ) }
								help={ __( 'Overwrite the submitted post type from the edit page.', 'mb-frontend-submission' ) }
								value={ post_type }
								options={ [
									{ label: __( '-', 'mb-frontend-submission' ), value: '' },
									...mbudData.post_types
								] }
								onChange={ update( 'post_type' ) }
							/>
						)
					}
				</PanelBody>
			</InspectorControls>
			<ServerSideRender
				block="meta-box/user-dashboard"
				attributes={ attributes }
			/>
		</div>
	);
}
