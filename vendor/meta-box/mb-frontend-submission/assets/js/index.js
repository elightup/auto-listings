import { addLoading, checkRecaptcha, isAjax, redirect, removeLoading, scrollTo } from './helpers.js';

const $ = jQuery;
const i18n = mbFrontendForm;

function processForm() {
	var $form = $( this );
	var $submitBtn = $form.find( 'button[name="rwmb_submit"]' );
	var $deleteBtn = $form.find( 'button[name="rwmb_delete"]' );
	var editText = $submitBtn.attr( 'data-edit' );
	var $validationElements = $form.find( '.rwmb-validation' );
	var countClick = 0;

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

	function isRemote() {
		let remote = false;
		$validationElements.each( function () {
			const data = $( this ).data( 'validation' );
			if ( Object.values( data.rules ).find( rule => rule.remote ) ) {
				remote = true;
			}
		} );
		return remote;
	}

	function checkAjax() {
		return new Promise( ( resolve, reject ) => {
			$( document ).ajaxComplete( function ( event, request, settings ) {
				const $form = $( settings.context );

				if ( !$form.hasClass( 'mbfs-form' ) || $form.find( '.rwmb-error' ).length === 0 ) {
					resolve();
				}

				window.stop();
				enableButtons();

				if ( isAjax ) {
					removeLoading();
				}

				reject( 'Remote validation error' );
			} );
		} );
	}

	async function handleSubmitClick( e ) {
		try {
			countClick++;

			if ( i18n.recaptchaKey || isAjax ) {
				e.preventDefault();
			}

			// Do nothing when the form is not validated.
			if ( !validate() ) {
				return;
			}

			if ( countClick == 1 && isRemote() ) {
				await checkAjax();
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
		} catch ( err ) {
			console.log( err );
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
		} ).done( function ( response ) {
			removeLoading();
			enableButtons();
			displayMessage( response.data.message, response.success );

			if ( response.success && response.data.allowScroll == 'true' ) {
				scrollTo( $( '.rwmb-confirmation' ) );
			}

			if ( response.success && response.data.redirect ) {
				redirect( response.data.redirect );
			}

			if ( typeof callback === 'function' ) {
				callback( response );
			}
		} );
	}

	function displayMessage( message, success = true ) {
		if ( !success ) {
			message = `<div class="rwmb-confirmation rwmb-error">${ message }</div>`;
		}
		const isEdit = editText === 'true';

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

$( function () {
	$( '.rwmb-form' ).each( processForm );
} );
