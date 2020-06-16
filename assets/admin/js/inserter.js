import { editorHTML } from './editor.js';
const { useState } = wp.element;

const insertTextAtCursor = text => {
	editorHTML.focus();
	const doc = editorHTML.getDoc();
	doc.replaceRange( text, doc.getCursor() );
}

const Fields = () => {
	const [active, setActive] = useState( false );
	const toggleModal = () => setActive( ! active );

	const [data, setData] = useState( {
		text: '',
		name: '',
		type: '',
	} );

	return (
		<>
		{ Object.keys( als_admin.fields ).map( ( key ) =>
			<ButtonInsertField key={ key } text={ als_admin.fields[key] } name={ key } toggleModal={ toggleModal } setValue={ setData } />
		) }

		{ active ? <Modal text={ data.text } name={ data.name } type={ data.type } toggleModal={ toggleModal } /> : null }
		</>
	);
}

const FieldsExtra = () => {
	const handleClick = ( e ) => {
		e.preventDefault();
		const name = e.target.dataset.name;
		let shortcode = '';
		switch ( name ) {
			case 'toggle_wrapper':
				shortcode = `[als_${ name }]\n\n[/als_${ name }]`;
				break;
			default:
				shortcode = `[als_${ name }]`;
				break;
		}
		insertTextAtCursor( shortcode );
	}

	return (
		<>
		{ Object.keys( als_admin.fields_extra ).map( ( key ) =>
			<button class="button" data-name={ key } onClick={ handleClick }>{ als_admin.fields_extra[key] }</button>
		) }
		</>
	);
}

const ButtonInsertField = ( { text, name, toggleModal, setValue } ) => {
	let type = 'button' === name ? 'button' : 'field';

	const handleClick = ( e ) => {
		e.preventDefault();
		toggleModal();
		setValue( { text, name, type } );
	}

	return <button class="button" onClick={ handleClick }>{ text }</button>;
}

const Modal = ( { text, name, type, toggleModal } ) => {
	const [values, setValues] = useState( {
		label: '',
		placeholder: '',
		prefix: '',
		suffix: '',
		type: '',
		multiple: false,
	} );
	const setValue = ( attribute, value ) => {
		let newValues = values;
		newValues[attribute] = value;
		setValues( newValues );
	}

	const insert = ( e ) => {
		e.preventDefault();

		let shortcode = '';
		Object.keys( values ).forEach( key => {
			if ( values[key] ) {
				shortcode += ` ${ key }="${ values[key] }"`;
			}
		} );

		switch ( name ) {
			case 'button':
			case 'keyword':
				shortcode = `[als_${ name }${ shortcode }]`;
				break;
			case 'toggle_wrapper':
				shortcode = `[als_${ name }${ shortcode }]\n\n[/als_${ name }]`;
				break;
			default:
				shortcode = `[als_${ type } name="${ name }"${ shortcode }]`;
				break;
		}

		insertTextAtCursor( shortcode );
		toggleModal();
	}

	return (
		<>
			<div class="als-modal-overlay" onClick={ toggleModal }></div>
			<form className="als-modal" onSubmit={ insert }>
				<h3>
					{ text + ' ' + als_admin.translate.attributes }
					<span className="als-modal__close" onClick={ toggleModal }>&times;</span>
				</h3>
				<small><i>{ als_admin.translate.notice }</i></small>

				<FieldAttributes type={ type } name={ name } setValue={ setValue }/>

				<div className="als-modal__actions">
					<button type="submit" class="button button-primary">{ als_admin.translate.insert_field }</button>
				</div>
			</form>
		</>
	);
}

const FieldAttributes = ( props ) => {
	const setValue = props.setValue;

	if ( 'button' === props.type ) {
		const options = [
			{ value: 'submit', label: als_admin.translate.submit },
			{ value: 'reset', label: als_admin.translate.reset },
			{ value: 'toggle', label: als_admin.translate.toggle },
		];

		return (
			<>
				<label>
					<span>{ als_admin.translate.label }</span>
					<input type="text" onChange={ e => setValue( 'label', e.target.value ) } autoFocus />
				</label>
				<label>
					<span>{ als_admin.translate.type }</span>
					<SelectControl options={ options } setValue={ setValue } />
				</label>
			</>
		);
	}

	if ( 'toggle_wrapper' === props.name ) {
		return (
			<>
				<label>
					<span>{ als_admin.translate.toggle_button_label }</span>
					<input type="text" onChange={ e => setValue( 'label', e.target.value ) } autoFocus />
				</label>
			</>
		);
	}

	if ( 'keyword' === props.name ) {
		return (
			<>
				<label>
					<span>{ als_admin.translate.label }</span>
					<input type="text" onChange={ e => setValue( 'label', e.target.value ) } autoFocus />
				</label>
				<label>
					<span>{ als_admin.translate.placeholder }</span>
					<input type="text" onChange={ e => setValue( 'placeholder', e.target.value ) } />
				</label>
			</>
		);
	}

	const options = [
		{ value: 'select', label: als_admin.translate.select },
		{ value: 'radio', label: als_admin.translate.radio },
	];

	const FieldsNoMultiple = [ 'price', 'min_price', 'max_price', 'odometer' ];

	const [multiple, setMultiple] = FieldsNoMultiple.includes( props.name ) ? useState( false ): useState( true );
	const toggleMultiple = () => setMultiple( ! multiple );

	return (
		<>
			<label>
				<span>{ als_admin.translate.label }</span>
				<input type="text" onChange={ e => setValue( 'label', e.target.value ) } autoFocus />
			</label>
			<label>
				<span>{ als_admin.translate.placeholder }</span>
				<input type="text" onChange={ e => setValue( 'placeholder', e.target.value ) } />
			</label>
			<label>
				<span>{ als_admin.translate.prefix }</span>
				<input type="text" onChange={ e => setValue( 'prefix', e.target.value ) } />
			</label>
			<label>
				<span>{ als_admin.translate.suffix }</span>
				<input type="text" onChange={ e => setValue( 'suffix', e.target.value ) } />
			</label>
			<label>
				<span>{ als_admin.translate.type }</span>
				<SelectControl options={ options } toggleMultiple={ toggleMultiple } setValue={ setValue }  />
			</label>
			{
				! multiple ? '' : (
					<label className="als-modal-checkbox">
						<input type="checkbox" onChange={ e => setValue( 'multiple', e.target.checked ) } />
						<span>{ als_admin.translate.multiple }</span>
					</label>
				)
			}
		</>
	);
}

const SelectControl = ( { options, toggleMultiple, setValue } ) => {
	const onChange = e => {
		if ( toggleMultiple ) {
			toggleMultiple();
		}
		if ( setValue ) {
			setValue( 'type', e.target.value );
		}
	}

	return (
		<select onChange={ onChange } >
			{ options.map( ( { value, label } ) => <option value={ value }>{ label }</option> ) }
		</select>
	);
}

ReactDOM.render( <Fields />, document.getElementById( 'als-fields' ) );
ReactDOM.render( <FieldsExtra />, document.getElementById( 'als-fields-extra' ) );
