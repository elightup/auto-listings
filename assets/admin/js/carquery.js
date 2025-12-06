/* global AlCarQuery */
jQuery( function ( $ ) {
	var $populateButton = $( '#cq-show-data' ),
		$populateDesc = $( '#cq-show-data-description' );

	function populateYearSelect( $yearSelect ) {
		//Set a loading message while we retrieve the data
		$yearSelect.html( `<option value=''>${ AlCarQuery.loading }</option>` );

		$.ajax( {
			url: 'https://api.wpautolistings.com/wp-json/data/years',
			method: 'GET',
			success: function ( data ) {
				let options = `<option value="">${ AlCarQuery.select }</option>`;
				data.forEach( function ( year ) {
					options += `<option value="${ year }">${ year }</option>`;
				} );
				$yearSelect.html( options );
			},
			error: function () {
				alert( AlCarQuery.errorNoData );
				return;
			}
		} );
	}

	function populateMakeSelect( selectedYear, $makeSelect ) {
		$makeSelect.html( `<option value=''>${ AlCarQuery.loading }</option>` );

		$.ajax( {
			url: 'https://api.wpautolistings.com/wp-json/data/makes',
			method: 'GET',
			data: { year: selectedYear },
			success: function ( data ) {
				let options = `<option value="">${ AlCarQuery.select }</option>`;
				data.forEach( function ( item ) {
					options += `<option value="${ item.make_id }">${ item.make }</option>`;
				} );
				$makeSelect.html( options );
			},
			error: function () {
				alert( AlCarQuery.errorNoData );
				return;
			}
		} );
	}

	function populateModelSelect( year, makeId, $modelSelect ) {
		$modelSelect.html( `<option value=''>${ AlCarQuery.loading }</option>` );

		$.ajax( {
			url: 'https://api.wpautolistings.com/wp-json/data/models',
			method: 'GET',
			data: {
				year: year,
				make_id: makeId
			},
			success: function ( data ) {
				let options = `<option value="">${ AlCarQuery.select }</option>`;
				data.forEach( function ( item ) {
					options += `<option value="${ item.model_id }">${ item.model }</option>`;
				} );
				$modelSelect.html( options );
			},
			error: function () {
				alert( AlCarQuery.errorNoData );
				return;
			}
		} );
	}

	function populateTrimSelect( year, makeId, modelId, $trimSelect ) {
		$trimSelect.html( `<option value=''>${ AlCarQuery.loading }</option>` );

		$.ajax( {
			url: 'https://api.wpautolistings.com/wp-json/data/trims',
			method: 'GET',
			data: {
				year: year,
				make_id: makeId,
				model_id: modelId,
			},
			success: function ( data ) {
				let options = `<option value="">${ AlCarQuery.select }</option>`;
				data.forEach( function ( item ) {
					options += `<option value="${ item.trim_id }">${ item.trim }</option>`;
				} );
				$trimSelect.html( options );
			},
			error: function () {
				alert( AlCarQuery.errorNoData );
				return;
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
			$makeSelect.html( `<option value="">${ AlCarQuery.select }</option>` );

			if ( year ) {
				populateMakeSelect( year, $makeSelect );
			}
		} );

		$makeSelect.off( "change" ).on( "change", function () {
			const year = $yearSelect.val();
			const makeId = $( this ).val();

			$modelSelect.html( `<option value="">${ AlCarQuery.select }</option>` );

			if ( year && makeId ) {
				populateModelSelect( year, makeId, $modelSelect );
			}
		} );

		$modelSelect.off( "change" ).on( "change", function () {
			const year = $yearSelect.val();
			const makeId = $makeSelect.val();
			const modelId = $( this ).val();
			$trimSelect.html( `<option value="">${ AlCarQuery.select }</option>` );

			if ( year && makeId && modelId ) {
				populateTrimSelect( year, makeId, modelId, $trimSelect );
			}
		} );

		$populateButton.show();
		$populateDesc.show();
	}



	function populateModelData() {
		const year = $( '#car-years' ).val();
		const makeId = $( '#car-makes' ).val();
		const modelId = $( '#car-models' ).val();
		const trimId = $( '#car-model-trims' ).val();

		if ( !year || !makeId || !modelId || !trimId ) {
			alert( AlCarQuery.errorNoSelected );
			return;
		}

		$.ajax( {
			url: 'https://api.wpautolistings.com/wp-json/data/entries',
			method: 'GET',
			data: {
				year: year,
				make_id: makeId,
				model_id: modelId,
				trim_id: trimId
			},
			success: function ( data ) {
				if ( !data || data.length === 0 ) {
					alert( AlCarQuery.errorNoData );
					return;
				}
				let trimText = $( '#car-model-trims option:selected' ).text();
				$( '#_al_listing_model_vehicle' ).val( trimText );

				$.each( data[ 0 ], function ( id, value ) {
					$( '#_al_listing_' + id ).val( value );
				} );
			},
			error: function () {
				alert( AlCarQuery.errorNoData );
				return;
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
