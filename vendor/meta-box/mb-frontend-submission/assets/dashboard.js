{
	document.addEventListener( 'click', e => {
		const button = e.target.classList.contains( 'rwmb-button--delete' ) ? e.target : e.target.closest( '.rwmb-button--delete' );
		if ( !button ) {
			return;
		}
		e.preventDefault();

		if ( !confirm( mbFrontendForm.confirm_delete ) ) {
			return;
		}

		wp.apiFetch( {
			path: 'mbfs/dashboard/delete',
			method: 'DELETE',
			data: {
				id: Number( button.dataset.id ),
				object_type: button.dataset.object_type,
				model: button.dataset.model,
				force: Boolean( button.dataset.force ),
			},
		} ).then( () => button.closest( 'tr' ).remove() ).catch( error => alert( error.message ) );
	} );
}