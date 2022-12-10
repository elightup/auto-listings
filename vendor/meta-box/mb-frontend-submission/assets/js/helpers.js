const $ = jQuery;
const i18n = mbFrontendForm;

// Set ajax URL for ajax actions like query images for image_advanced fields.
if ( !window.ajaxurl ) {
	window.ajaxurl = i18n.ajaxUrl;
}

const isAjax = 'true' === i18n.ajax;
const addLoading = $btn => $btn.append( '<div class="rwmb-loading"></div>' );
const removeLoading = () => $( '.rwmb-loading' ).remove();
const scrollTo = $el => $( 'html, body' ).animate( { scrollTop: $el.offset().top - 50 }, 200 );
const redirect = url => setTimeout( () => window.location.href = url, 2000 );

const checkRecaptcha = ( { success, error } ) => {
	grecaptcha.ready( () => grecaptcha.execute( i18n.recaptchaKey, { action: 'mbfs' } ).then( success ).catch( error ) );
};

// Save editor content for ajax submission.
function saveEditorContent() {
	var id = $( this ).attr( 'id' );

	$( document ).on( 'tinymce-editor-init', ( event, editor ) => {
		editor.on( 'input keyup', () => editor.save() );
	} );
}

$( function() {
	$( '.rwmb-wysiwyg' ).each( saveEditorContent );
} );

export { isAjax, addLoading, removeLoading, scrollTo, redirect, checkRecaptcha };
