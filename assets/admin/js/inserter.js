import {editorHTML} from './editor.js';
const { useState } = wp.element;

const btnInsertField = [...document.querySelectorAll('.btn-insert_field')]

btnInsertField.forEach( btn => btn.addEventListener( 'click', () => insertTextAtCursor( btn.dataset.field ) ) );

const insertTextAtCursor = text => {
	const doc = editorHTML.getDoc();
	doc.replaceRange( text, doc.getCursor() );
	editorHTML.focus();
}

const createModal = () => {
	ReactDOM.render( <Fields />, document.getElementById( 'als-fields' ) );
}

const Fields = () => {
	const [active, setActive] = useState( false );
	const toggleModal = () => setActive( ! active );

	const [datas, setDatas] = useState( {
		text: '',
		name: '',
		type: '',
	} );
	const setValue = ( newData ) => {
		setDatas( newData );
	}

	return (
		<>
		{ Object.keys( als_admin.fields ).map( key => <ButtonInsertField text={als_admin.fields[key]} name={key} toggleModal={toggleModal} setValue={setValue} /> ) }
		{ active ? <Modal text={datas.text} name={datas.name} type={datas.type} toggleModal={toggleModal} /> : null }
		</>
	);
}

const ButtonInsertField = ( {text, name, toggleModal, setValue} ) => {
	let type = 'button' === name ? 'button' : 'field';

	const handleClick = () => {
		toggleModal();
		setValue( {
			text: text,
			name: name,
			type: type,
		} )
	}

	return (
		<span class="button btn-insert_modal"
			data-tab="template-editor"
			data-field={name}
			data-type={type}
			onClick={handleClick}
			>
			{text}
		</span>
	);
}

const Modal = ( {text, name, type, toggleModal} ) => {
	const [values, setValues] = useState( {
		label: '',
		placeholder: '',
		prefix: '',
		suffix: '',
		type: 'button' === type ? 'submit' : 'select',
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

		let _name = 'button' === type ? '' : ` name="${name}"`;
		shortcode = `[als_${type}${_name}${shortcode}]`;

		insertTextAtCursor( shortcode );
	}

	return (
		<>
			<div id="modal-bg" onClick={toggleModal}></div>
			<div className="modal">
				<h3>
					{text} attributes
					<span className="modal-close" onClick={toggleModal}>&times;</span>
				</h3>
				<small><i>Leave empty to use the default values</i></small>

				<FieldAttributes type={type} setValue={ setValue }/>

				<div className="modal-actions">
					<ButtonInsertShortcode insert={ insert } toggleModal={toggleModal} />
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

const ButtonInsertShortcode = ( { insert, toggleModal } ) => {
	const handleClick = () => {
		insert();
		setTimeout(() => {
			toggleModal();
		}, 0);
	}

	return (
		<span class="button button-primary button-large" onClick={handleClick}>Insert Field</span>
	);
}

document.addEventListener("DOMContentLoaded", function() {
	createModal();
  });