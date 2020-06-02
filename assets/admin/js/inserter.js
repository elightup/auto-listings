import { editorHTML } from './editor.js';
import { changeTab } from './tabs.js';
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
			'total_listings' === key
			? <TotalListings key={ key } text={ als_admin.fields[key] } name={ key } />
			: <ButtonInsertField key={ key } text={ als_admin.fields[key] } name={ key } toggleModal={ toggleModal } setValue={ setData } />
		) }

		{ active ? <Modal text={ data.text } name={ data.name } type={ data.type } toggleModal={ toggleModal } /> : null }
		</>
	);
}

const TotalListings = ( { text, name } ) => {
	const handleClick = ( e ) => {
		e.preventDefault();
		changeTab( e );
		insertTextAtCursor( `[als_${name}]` );
	}

	return (
		<>
			<hr />
			<button class="button" data-tab="template-editor" onClick={ handleClick }>{ text }</button>
		</>
	);
}

const ButtonInsertField = ( { text, name, toggleModal, setValue } ) => {
	let type = 'button' === name ? 'button' : 'field';

	const handleClick = ( e ) => {
		e.preventDefault();
		changeTab( e );
		toggleModal();
		setValue( { text, name, type } );
	}

	return <button class="button" data-tab="template-editor" onClick={ handleClick }>{ text }</button>;
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

	const insert = () => {
		let shortcode = '';
		Object.keys( values ).forEach( key => {
			if ( values[key] ) {
				shortcode += ` ${ key }="${ values[key] }"`;
			}
		} );

		let _name = 'button' === type ? '' : ` name="${ name }"`;
		shortcode = `[als_${ type }${ _name }${ shortcode }]`;

		insertTextAtCursor( shortcode );
	}

	return (
		<>
			<div class="als-modal-overlay" onClick={ toggleModal }></div>
			<div className="als-modal">
				<h3>
					{ text + ' ' + als_admin.translate.label }
					<span className="als-modal__close" onClick={ toggleModal }>&times;</span>
				</h3>
				<small><i>{ als_admin.translate.notice }</i></small>

				<FieldAttributes type={ type } setValue={ setValue }/>

				<div className="als-modal__actions">
					<ButtonInsertShortcode insert={ insert } toggleModal={ toggleModal } />
				</div>
			</div>
		</>
	);
}

const FieldAttributes = ( props ) => {
	const setValue = props.setValue;

	if ( 'button' === props.type ) {
		const options = [
			{ value: 'submit', label: als_admin.translate.submit },
			{ value: 'reset', label: als_admin.translate.reset },
		];

		return (
			<>
				<label>
					<span>{ als_admin.translate.label }</span>
					<input type="text" onChange={ e => setValue( 'label', e.target.value ) } />
				</label>
				<label>
					<span>{ als_admin.translate.type }</span>
					<SelectControl options={ options } setValue={ setValue } />
				</label>
			</>
		);
	}

	const options = [
		{ value: 'select', label: als_admin.translate.select },
		{ value: 'radio', label: als_admin.translate.radio },
	];

	const [multiple, setMultiple] = useState( true );
	const toggleMultiple = () => setMultiple( ! multiple );

	return (
		<>
			<label>
				<span>{ als_admin.translate.label }</span>
				<input type="text" onChange={ e => setValue( 'label', e.target.value ) } />
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

const ButtonInsertShortcode = ( { insert, toggleModal } ) => {
	const handleClick = ( e ) => {
		e.preventDefault();
		insert();
		setTimeout( toggleModal, 0);
	}

	return (
		<button class="button button-primary" onClick={ handleClick }>{ als_admin.translate.insert_field }</button>
	);
}

ReactDOM.render( <Fields />, document.getElementById( 'als-fields' ) );