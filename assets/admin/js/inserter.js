import {editorHTML} from './editor.js';

const btnInsertField = [...document.querySelectorAll('.btn-insert_field')]
const btnInsertModal = [...document.querySelectorAll('.btn-insert_modal')]
const modalObject    = document.getElementById( 'als-fields' )
const als_field_types = [
    { type: 'select', label: 'Dropdown' },
    { type: 'radio', label: 'Single Choice' },
];

const als_button_types = [
    { type: 'submit', label: 'Submit' },
    { type: 'reset', label: 'Reset' },
];

btnInsertField.forEach( 
    btn => btn.addEventListener( 
        'click',
        () => insertTextAtCursor( btn.dataset.field )
    )
)

btnInsertModal.forEach( 
    btn => btn.addEventListener( 
        'click',
        () => createModal( btn.textContent, btn.dataset.field, btn.dataset.type ).then( popupModal() )
    )
)

const insertTextAtCursor = text => {
	const doc = editorHTML.getDoc();
    doc.replaceRange( text, doc.getCursor() );
    editorHTML.focus();
}

const createModal = async ( text, name, type ) => {
    let props = {
        text: text.trim(),
        name: name,
        type: type
    }
    ReactDOM.render( <Modal {...props} />, document.getElementById( 'als-fields' ) )
}

const popupModal = () => {
    setTimeout(() => {
        modalObject.classList.add( 'active' );
    }, 0);
}

const Modal = ( props ) => {
    const closeModal = () => {
        modalObject.classList.remove( 'active' );
    }

    let data = {
        name: props.name,
        type: props.type
    }

    return (
        <div>
            <div id="modal-bg" onClick={closeModal}></div>
            <div className="modal">
                <h3>
                    {props.text} attributes
                    <span className="modal-close" onClick={closeModal} >&times;</span>
                </h3>
                <small><i>Leave empty to use default value</i></small>
                
                <FieldAttributes dataType={props.type} />

                <div className="modal-actions">
                    <Button {...data} />
                </div>
            </div>
        </div>
    );
}

const FieldAttributes = ( props ) => {
    if ( 'button' === props.dataType ) {
        return (
            <div>
                <label>
                    <span>Label</span>
                    <input id="als-field_label" type="text" />
                </label>
                <label>
                    <span>Type</span>
                    <SelectFieldType fieldTypes={als_button_types} />
                </label>
            </div>
        );
    } else {
        return (
            <div>
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
                    <SelectFieldType fieldTypes={als_field_types} />
                </label>
                <label className="modal-checkbox active">
                    <input id="als-field_multiple" type="checkbox" />
                    <span>Multiple</span>
                </label>
            </div>
        );
    }
}

const SelectFieldType = ( props ) => {
    const fieldTypes = props.fieldTypes;

    const options = fieldTypes.map( (ft) =>
        <option value={ft.type}>{ft.label}</option>
    );

    const toggleMultiple = () => {
        let containers = document.querySelectorAll( '.modal-checkbox' );
        containers.forEach( el => el.classList.toggle( 'active' ) )

        document.getElementById( 'als-field_multiple' ).checked = false
    }

    return (
        <select id="als-field_type" onChange={toggleMultiple}>{options}</select>
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

        insertTextAtCursor( shortCode )
        modalObject.classList.remove( 'active' );
    }

    return (
        <span data-field={props.name} class="button button-primary button-large" onClick={insertFieldShortcode}>Insert Field</span>
    );
}