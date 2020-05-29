import {editorHTML} from './editor.js';
const { useState } = wp.element;

const btnInsertField = [...document.querySelectorAll('.btn-insert_field')]
const btnInsertModal = [...document.querySelectorAll('.btn-insert_modal')]
const modalObject    = document.getElementById( 'als-fields' )

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

	let data = {
		name: props.name,
		type: props.type
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

				<FieldAttributes dataType={props.type} />

				<div className="modal-actions">
					<Button {...data} />
				</div>
			</div>
		</>
	);
}

const FieldAttributes = ( props ) => {
	if ( 'button' === props.dataType ) {
		const options = [
			{ value: 'submit', label: 'Submit' },
			{ value: 'reset', label: 'Reset' },
		];

		return (
			<>
				<label>
					<span>Label</span>
					<input id="als-field_label" type="text" />
				</label>
				<label>
					<span>Type</span>
					<SelectControl options={options} />
				</label>
			</>
		);
	}

	const options = [
		{ value: 'select', label: 'Dropdown' },
		{ value: 'radio', label: 'Single Choice' },
	];
	return (
		<>
			<label>
				<span>Label</span>
				<input id="als-field_label" type="text" />
			</label>
			<label>
				<span>Placeholder</span>
				<input id="als-field_placeholder" type="text" />
			</label>
			<label>
				<span>Prefix</span>
				<input id="als-field_prefix" type="text" />
			</label>
			<label>
				<span>Suffix</span>
				<input id="als-field_suffix" type="text" />
			</label>
			<label>
				<span>Type</span>
				<SelectControl options={options} />
			</label>
			<label className="modal-checkbox active">
				<input id="als-field_multiple" type="checkbox" />
				<span>Multiple</span>
			</label>
		</>
	);
}

const SelectControl = ( { options } ) => {
	const toggleMultiple = () => {
		let containers = document.querySelectorAll( '.modal-checkbox' );
		if ( ! containers.length ) {
			return;
		}
		containers.forEach( el => el.classList.toggle( 'active' ) )

		document.getElementById( 'als-field_multiple' ).checked = false
	}

	return (
		<select id="als-field_type" onChange={toggleMultiple}>
			{ options.map( ( { value, label } ) => <option value={value}>{label}</option> ) }
		</select>
	);
}

const Button = ( props ) => {
	const insertFieldShortcode = () => {
		// button and fields attibutes
		let fieldLabel       = document.querySelector( '#als-field_label' ),
			label            = "" === fieldLabel.value ? "" : ' label="' + fieldLabel.value + '" '
		let fieldType        = document.querySelector( '#als-field_type' ),
			type             = "" === fieldType.value ? "" : ' type="' + fieldType.value + '" '

		// fields attributes
		let fieldPlaceholder = document.querySelector( '#als-field_placeholder' ),
			placeholder      = 'button' === props.type || "" === fieldPlaceholder.value ? "" : ' placeholder="' + fieldPlaceholder.value + '" '
		let isMultiple       = document.getElementById( 'als-field_multiple' ),
			multiple         = 'button' === props.type || false === isMultiple.checked ? "" : ' multiple="true"'
		let fieldPrefix      = document.querySelector( '#als-field_prefix' ),
			prefix           = 'button' === props.type || "" === fieldPrefix.value ? "" : ' prefix="' + fieldPrefix.value + '" '
		let fieldSuffix      = document.querySelector( '#als-field_suffix' ),
			suffix           = 'button' === props.type || "" === fieldSuffix.value ? "" : ' suffix="' + fieldSuffix.value + '" '
		let name             = 'button' === props.type ? "" : ' name="' + props.name  + '"';


		let shortCode = '[als_' + props.type + name + label + placeholder + type + multiple + prefix + suffix + ']'

		insertTextAtCursor( shortCode );
		modalObject.classList.remove( 'active' );
	}

	return (
		<span data-field={props.name} class="button button-primary button-large" onClick={insertFieldShortcode}>Insert Field</span>
	);
}