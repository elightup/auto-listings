/* global CarQuery, AlCarQuery */
jQuery( function ( $ ) {
	//var carQuery = new CarQuery();
	var $populateButton = $( '#cq-show-data' ),
		$populateDesc = $( '#cq-show-data-description' );

	function populateYearSelect( $yearSelect ) {
		//Set a loading message while we retrieve the data
		$yearSelect.html( "<option value=''>Loading Years...</option>" );

		$.ajax( {
			url: 'https://eu.titanweb.vn/autolisting_api/wp-json/autolisting/car-year',
			method: 'GET',
			success: function ( data ) {
				let options = '<option value="">Select Year</option>';
				data.forEach( function ( item ) {
					options += `<option value="${ item.year }">${ item.year }</option>`;
				} );
				$yearSelect.html( options );
			},
			error: function () {
				$yearSelect.html( "<option value=''>Failed to load years</option>" );
			}
		} );
	}

	function populateMakeSelect( selectedYear, $makeSelect ) {
		$makeSelect.html( "<option value=''>Loading Makes...</option>" );

		$.ajax( {
			url: 'https://eu.titanweb.vn/autolisting_api/wp-json/autolisting/car-makes',
			method: 'GET',
			data: { year: selectedYear },
			success: function ( data ) {
				let options = '<option value="">Select Make</option>';
				data.forEach( function ( item ) {
					options += `<option value="${ item.make_id }">${ item.make }</option>`;
				} );
				$makeSelect.html( options );
			},
			error: function () {
				$makeSelect.html( "<option value=''>Failed to load makes</option>" );
			}
		} );
	}

	function populateModelSelect( year, makeId, $modelSelect ) {
		$modelSelect.html( "<option value=''>Loading Models...</option>" );

		$.ajax( {
			url: 'https://eu.titanweb.vn/autolisting_api/wp-json/autolisting/car-models',
			method: 'GET',
			data: {
				year: year,
				make_id: makeId
			},
			success: function ( data ) {
				let options = '<option value="">Select Model</option>';
				data.forEach( function ( item ) {
					options += `<option value="${ item.model_id }">${ item.model }</option>`;
				} );
				$modelSelect.html( options );
			},
			error: function () {
				$modelSelect.html( "<option value=''>Failed to load models</option>" );
			}
		} );
	}

	function populateTrimSelect( year, makeId, $trimSelect ) {
		$trimSelect.html( "<option value=''>Loading Trims...</option>" );

		$.ajax( {
			url: 'https://eu.titanweb.vn/autolisting_api/wp-json/autolisting/car-trims',
			method: 'GET',
			data: {
				year: year,
				make_id: makeId
			},
			success: function ( data ) {
				let options = '<option value="">Select Trim</option>';
				data.forEach( function ( item ) {
					options += `<option value="${ item.trim_id }">${ item.trim }</option>`;
				} );
				$trimSelect.html( options );
			},
			error: function () {
				$trimSelect.html( "<option value=''>Failed to load trims</option>" );
			}
		} );
	}


	function loadData( year_select_id, make_select_id, model_select_id, trim_select_id ) {
		const $yearSelect = $( "#" + year_select_id );
		const $makeSelect = $( "#" + make_select_id );
		const $modelSelect = $( "#" + model_select_id );
		const $trimSelect = $( "#" + trim_select_id );

		//Populate the car-years select element
		populateYearSelect( $yearSelect );

		$yearSelect.off( "change" ).on( "change", function () {
			const year = $( this ).val();
			$makeSelect.html( '<option value="">Select Make</option>' );

			if( year ) {
				populateMakeSelect( year, $makeSelect );
			}
		} );

		$makeSelect.off( "change" ).on( "change", function () {
			const year = $yearSelect.val();
			const makeId = $( this ).val();

			$modelSelect.html( '<option value="">Select Model</option>' );
			$trimSelect.html( '<option value="">Select Trim</option>' );

			if( year && makeId ) {
				populateModelSelect( year, makeId, $modelSelect );
				populateTrimSelect( year, makeId, $trimSelect );
			}
		} );

		$populateButton.show();
		$populateDesc.show();
	}



	function populateModelData() {
		const year = $( '#car-years' ).val();
		const makeText = $( '#car-makes option:selected' ).text();
		const modelText = $( '#car-models option:selected' ).text();
		const trimText = $( '#car-model-trims option:selected' ).text();

		if( !year || !makeText || !modelText || !trimText ) {
			alert( 'Please select Year, Make, Model, and Trim before proceeding.' );
			return;
		}

		$.ajax( {
			url: 'https://eu.titanweb.vn/autolisting_api/wp-json/autolisting/entries',
			method: 'GET',
			data: {
				year: year,
				make: makeText,
				model: modelText,
				trim: trimText
			},
			success: function ( data ) {
				if( !data || data.length === 0 ) {
					alert( 'No data found for selected vehicle.' );
					return;
				}

				const vehicle = data[ 0 ];
				console.log(vehicle);

				$( '#_al_listing_model_vehicle' ).val( trimText );

				$.each( vehicle, function ( id, value ) {
					$( '#_al_listing_' + id ).val( value );
				} );
			},
			error: function () {
				alert( 'Failed to fetch vehicle data from server.' );
			}
		} );

	}

	$( '#cq-select-model' ).on( 'click', function () {
		loadData( 'car-years', 'car-makes', 'car-models', 'car-model-trims' );
	} );
	$populateButton.on( 'click', populateModelData );
	$populateButton.hide();
	$populateDesc.hide();
} );
