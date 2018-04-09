/* global CarQuery, AlCarQuery */
jQuery( function ( $ ) {
	var carQuery = new CarQuery(),
		$populateButton = $( '#cq-show-data' ),
		$populateDesc = $( '#cq-show-data-description' );

	function loadData() {
		carQuery.init();
		carQuery.setFilters( {sold_in_us: false} );

		// Initialize the year, make, model, and trim drop downs by providing their element IDs
		carQuery.initYearMakeModelTrim( 'car-years', 'car-makes', 'car-models', 'car-model-trims' );
		$populateButton.show();
		$populateDesc.show();
	}

	function populateModelData() {
		if ( ! carQuery.cur_trim ) {
			alert( AlCarQuery.errorNoSelected );
			return;
		}

		$.getJSON( carQuery.base_url + '?callback=?', {
			cmd: 'getModel',
			model: carQuery.cur_trim
		}, function ( data ) {
			if ( carQuery.responseError( data ) ) {
				alert( AlCarQuery.errorNoData );
				return;
			}
			$( '#_al_listing_model_vehicle' ).val( $( '#' + carQuery.trim_select_id + ' option:selected' ).text() );
			$.each( data[0], function ( id, value ) {
				$( '#_al_listing_' + id ).val( value );
			} );
		} );
	}

	$( '#cq-select-model' ).on( 'click', loadData );
	$populateButton.on( 'click', populateModelData );
	$populateButton.hide();
	$populateDesc.hide();
} );
