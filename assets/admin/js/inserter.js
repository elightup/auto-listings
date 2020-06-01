import {editorHTML} from './editor.js';
const { useState } = wp.element;

const btnInsertField = [...document.querySelectorAll('.btn-insert_field')]
const btnInsertModal = [...document.querySelectorAll('.btn-insert_modal')]

btnInsertField.forEach( btn => btn.addEventListener( 'click', () => insertTextAtCursor( btn.dataset.field ) ) );

btnInsertModal.forEach( btn => btn.addEventListener( 'click', () => createModal( btn.textContent, btn.dataset.field, btn.dataset.type ) ) );

const insertTextAtCursor = text => {
	const doc = editorHTML.getDoc();
	doc.replaceRange( text, doc.getCursor() );
	editorHTML.focus();
}

const createModal = ( text, name, type ) => {
	ReactDOM.render( <Modal text={text.trim()} name={name} type={type} />, document.getElementById( 'als-fields' ) );
}

const Modal = ( props ) => {
	const [active, setActive] = useState( true );
	if ( ! active ) {
		return;
	}

	const closeModal = () => setActive( false );

	const [values, setValues] = useState( {
		label: '',
		placeholder: '',
		prefix: '',
		suffix: '',
		type: 'button' === props.type ? 'submit' : 'select',
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
				shortcode += ` ${key}="${values[key]}"`;
			}
		} );

		let name = 'button' === props.type ? '' : ` name="${props.name}"`;
		shortcode = `[als_${props.type}${name}${shortcode}]`;

		insertTextAtCursor( shortcode );
	}

	return (
		<>
			<div id="modal-bg" onClick={closeModal}></div>
			<div className="modal">
				<h3>
					{props.text} attributes
					<span className="modal-close" onClick={closeModal}>&times;</span>
				</h3>
				<small><i>Leave empty to use the default values</i></small>

				<FieldAttributes type={props.type} setValue={ setValue }/>

				<div className="modal-actions">
					<Button insert={ insert } closeModal={closeModal} />
				</div>
			</div>
		</>
	);
}

const FieldAttributes = ( props ) => {
	const setValue = props.setValue;

	if ( 'button' === props.type ) {
		const options = [
			{ value: 'submit', label: 'Submit' },
			{ value: 'reset', label: 'Reset' },
		];

		return (
			<>
				<label>
					<span>Label</span>
					<input id="als-field_label" type="text" onChange={ e => setValue( 'label', e.target.value ) } />
				</label>
				<label>
					<span>Type</span>
					<SelectControl options={options} setValue={setValue} />
				</label>
			</>
		);
	}

	const options = [
		{ value: 'select', label: 'Dropdown' },
		{ value: 'radio', label: 'Single Choice' },
	];

	const [multiple, setMultiple] = useState( true );
	const toggleMultiple = () => setMultiple( ! multiple );

	return (
		<>
			<label>
				<span>Label</span>
				<input id="als-field_label" type="text" onChange={ e => setValue( 'label', e.target.value ) } />
			</label>
			<label>
				<span>Placeholder</span>
				<input id="als-field_placeholder" type="text" onChange={ e => setValue( 'placeholder', e.target.value ) } />
			</label>
			<label>
				<span>Prefix</span>
				<input id="als-field_prefix" type="text" onChange={ e => setValue( 'prefix', e.target.value ) } />
			</label>
			<label>
				<span>Suffix</span>
				<input id="als-field_suffix" type="text" onChange={ e => setValue( 'suffix', e.target.value ) } />
			</label>
			<label>
				<span>Type</span>
				<SelectControl options={options} toggleMultiple={toggleMultiple} setValue={ setValue }  />
			</label>
			{
				! multiple ? '' : (
					<label className="modal-checkbox active">
						<input id="als-field_multiple" type="checkbox" onChange={ e => setValue( 'multiple', e.target.checked ) } />
						<span>Multiple</span>
					</label>
				)
			}
		</>
	);
}

const SelectControl = ( { options, toggleMultiple, setValue } ) => {
	const onChange = e => {
		if ( toggleMultiple ) { toggleMultiple() }
		if ( setValue ) { setValue( 'type', e.target.value ) }
	}

	return (
		<select id="als-field_type" onChange={onChange} >
			{ options.map( ( { value, label } ) => <option value={value}>{label}</option> ) }
		</select>
	);
}

const Button = ( { insert, closeModal } ) => {
	const handleClick = () => {
		insert();
		setTimeout(() => {
			closeModal();
		}, 0);
	}

	return (
		<span class="button button-primary button-large" onClick={handleClick}>Insert Field</span>
	);
}