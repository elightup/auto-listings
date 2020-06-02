// TODO
// 1: Viết dấu cách trong ngoặc { }
// 2: Kiểm tra tất cả các text chưa được dịch
// 3: Kiểm tra các class và ID thừa
// 4: Đổi các button về <button>, bỏ class button-large
// 5: Chuyển nút total listings vào react
// 6: Thêm prefix vào CSS class. Dùng class thay cho ID.

import {editorHTML} from './editor.js';
const { useState } = wp.element;

const btnInsertField = [...document.querySelectorAll('.btn-insert_field')]

btnInsertField.forEach( btn => btn.addEventListener( 'click', () => insertTextAtCursor( btn.dataset.field ) ) );

const insertTextAtCursor = text => {
	const doc = editorHTML.getDoc();
	doc.replaceRange( text, doc.getCursor() );
	editorHTML.focus();
}

const Fields = () => {
	const [active, setActive] = useState( false );
	const toggleModal = () => setActive( ! active );

	const [data, setData] = useState( {
		text: '',
		name: '',
		type: '',
	} );
	const setValue = newData => setData( newData );

	return (
		<>
		{ Object.keys( als_admin.fields ).map( key => <ButtonInsertField key={key} text={als_admin.fields[key]} name={key} toggleModal={toggleModal} setValue={setValue} /> ) }
		{ active ? <Modal text={data.text} name={data.name} type={data.type} toggleModal={toggleModal} /> : null }
		</>
	);
}

const ButtonInsertField = ( {text, name, toggleModal, setValue} ) => {
	let type = 'button' === name ? 'button' : 'field';

	const handleClick = ( e ) => {
		e.preventDefault();
		toggleModal();
		setValue( { text, name, type } );
	}

	return <button class="button" onClick={handleClick}>{text}</button>;
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
		if ( toggleMultiple ) {
			toggleMultiple();
		}
		if ( setValue ) {
			setValue( 'type', e.target.value );
		}
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

ReactDOM.render( <Fields />, document.getElementById( 'als-fields' ) );