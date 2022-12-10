import { addLoading, checkRecaptcha, isAjax, redirect, removeLoading, scrollTo } from './helpers.js';

const $ = jQuery;
const i18n = mbFrontendForm;

function processForm() {
	var $form = $( this );
	var $submitBtn = $form.find( 'button[name="rwmb_submit"]' );
	var $deleteBtn = $form.find( 'button[name="rwmb_delete"]' );
	var editText   = $submitBtn.attr( 'data-edit' );

	const setAction = action => $form.find( 'input[name="action"]' ).val( `mbfs_${ action }` );
	const validate = () => {
		$( '#rwmb-validation-message' ).remove(); // Remove all previous validation message.
		return !$.validator || $form.valid();
	};

	// To prevent submitting twice.
	function disableButtons() {
		$submitBtn.prop( 'disabled', true );
		$deleteBtn.prop( 'disabled', true );
	}

	function enableButtons() {
		$submitBtn.prop( 'disabled', false );
		$deleteBtn.prop( 'disabled', false );
	}

	function submitCallback() {
		if ( isAjax ) {
			addLoading( $submitBtn );
			performAjax();
		} else {
			$form[ 0 ].submit(); // Native form submit.
		}
	}

	function handleSubmitClick( e ) {
		if ( i18n.recaptchaKey || isAjax ) {
			e.preventDefault();
		}

		// Do nothing when the form is not validated.
		if ( !validate() ) {
			return;
		}

		disableButtons();
		setAction( 'submit' );

		if ( i18n.recaptchaKey ) {
			checkRecaptcha( {
				success: token => {
					$form.find( 'input[name="mbfs_recaptcha_token"]' ).val( token );
					submitCallback();
				},
				error: () => displayMessage( i18n.captchaExecuteError, false )
			} );
		} else {
			submitCallback();
		}
	}

	function performAjax( callback ) {
		$( '.rwmb-confirmation' ).remove();

		let data = new FormData( $form[ 0 ] );
		data.append( '_ajax_nonce', i18n.nonce );

		$.ajax( {
			dataType: 'json',
			type: 'POST',
			data: data,
			url: i18n.ajaxUrl,
			contentType: false,
			processData: false
		} ).done( function( response ) {
			removeLoading();
			enableButtons();
			displayMessage( response.data.message, response.success );
			scrollTo( $( '.rwmb-confirmation' ) );

			if ( response.success && response.data.redirect ) {
				redirect( response.data.redirect );
			}

			if ( typeof callback === 'function' ) {
				callback( response );
			}
		} );
	}

	function displayMessage( message, success = true ) {
		message = `<div class="rwmb-confirmation${ success ? '' : ' rwmb-error' }">${ message }</div>`;
		const isEdit = ( editText === 'true' );

		if ( isEdit || !success ) {
			$form.prepend( message );
		} else {
			$form.replaceWith( message );
		}
	}

	function handleDeleteClick( e ) {
		if ( !confirm( i18n.confirm_delete ) ) {
			e.preventDefault();
			return;
		}
		disableButtons();
		setAction( 'delete' );

		if ( !isAjax ) {
			$form[ 0 ].submit(); // Native form submit. Chrome requires this to perform submitting the form.
			return;
		}

		// Remove row on dashboard: must get before performing Ajax because the form is removed.
		const $tr = $( e.target ).closest( '.mbfs-actions' ).parent();

		e.preventDefault();
		addLoading( $deleteBtn );
		performAjax( response => {
			if ( !$tr.length ) {
				returnn;
			}
			$tr.closest( 'table' ).before( `<div class="rwmb-confirmation">${ response.data.message }</div>` );
			$tr.remove();
		} );
	}

	$submitBtn.on( 'click', handleSubmitClick );
	$deleteBtn.on( 'click', handleDeleteClick );
}

$( function() {
	$( '.rwmb-form' ).each( processForm );
} );
