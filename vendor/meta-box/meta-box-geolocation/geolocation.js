( function( $, document, google ) {
	class Base {
		constructor( container ) {
			this.container = container;

			// 2 cases: not in or in a group.
			this.addressFields = container.querySelectorAll( '.rwmb-text[name^="address"], .rwmb-text[name*="[address"]' );

			const geoEl = container.querySelector( '.data-geo' );
			this.settings = geoEl ? JSON.parse( geoEl.dataset.geo ) : null;
		}

		init() {
			if ( this.settings ) {
				this.addressFields.forEach( this.autocomplete );
			}

			if ( !this.container.querySelector( `.rwmb-${ this.type }-field` ) ) {
				return;
			}

			const $container = $( this.container );

			// Populate lat, lng when map pin changes.
			$container.find( `.rwmb-${ this.type }` ).on( 'change', this.populateLatLngFromMap );

			// Populate map when lat, lng change.
			$container.find( '[data-binding="lat"]' ).prev().children().on( 'change keyup', _.debounce( this.populateMapFromLat, 500 ) );
			$container.find( '[data-binding="lng"]' ).prev().children().on( 'change keyup', _.debounce( this.populateMapFromLng, 500 ) );
		}

		populateFromAddress = ( data, address ) => {
			this.getPopulatedFields( address ).forEach( field => this.populateField( field, data ) );
		};

		getMapControllerFromLatLng = el => {
			const addressField = this.getAddressField( el );
			const map = [ ...this.getScope( el ).querySelectorAll( `.rwmb-${ this.type }-field` ) ].find( m => !addressField || m.dataset.addressField === addressField );
			return map ? $( map ).data( `${ this.type }Controller` ) : null;
		};

		populateLatLngFromMap = e => {
			const [ lat, lng ] = `${ e.target.value },,`.split( ',' );
			const data = { lat, lng };

			this.getPopulatedFields( e.target )
				.filter( field => [ 'lat', 'lng' ].includes( field.dataset.binding ) )
				.forEach( field => this.populateField( field, data ) );
		};

		populateField = ( field, data ) => {
			const value = this.getFieldData( field.dataset.binding, data );
			if ( value || field.dataset.bind_if_empty ) {
				field.previousSibling.firstChild.value = value;
			}
		};

		// Get populated fields connected to an element.
		getPopulatedFields = el => {
			let fields = [ ...this.getScope( el ).querySelectorAll( '.rwmb-geo-binding' ) ];

			// Don't populate address.
			fields = fields.filter( field => field.dataset.binding !== 'address' );

			// If el is address, get all fields with no or the same address_field.
			const addressId = this.getAddressId( el );
			if ( addressId ) {
				fields = fields.filter( field => {
					const addressField = this.getAddressField( field );
					return !addressField || addressField === addressId;
				} );
			} else {
				// Get all fields with the same address_field.
				fields = fields.filter( field => this.hasSameAddress( el, field ) );
			}

			return fields;
		};

		// If in a group clone, only populate data inside that group clone. Otherwise, populate in the meta box.
		getScope = el => el.closest( '.rwmb-group-clone' ) || el.closest( '.rwmb-meta-box' );

		// Check if 2 elements has the same address field, e.g. in the same geolocation group.
		// Elements must be <input> or <script class="rwmb-geo-binding">
		hasSameAddress = ( el1, el2 ) => {
			const address1 = this.getAddressField( el1 ),
				address2 = this.getAddressField( el2 );

			if ( address1 === address2 ) {
				return true;
			}
			return ( !address1 && this.isMapField( el2 ) ) || ( !address2 && this.isMapField( el1 ) );
		};

		// Get connected address field, including for map & address.
		// Element must be <input> or <script class="rwmb-geo-binding">
		getAddressField = el => {
			if ( el.dataset.address_field ) {
				return el.dataset.address_field;
			}
			const map = el.closest( `.rwmb-${ this.type }-field` );
			return map ? map.dataset.addressField : null;
		};

		getAddressId = el => {
			if ( !el.name || !el.name.includes( 'address' ) ) {
				return null;
			}
			const lastIndex = el.name.lastIndexOf( 'address' );
			return el.name.substr( lastIndex ).replace( ']', '' );
		};

		isMapField = el => !!el.closest( `.rwmb-${ this.type }-wrapper` );
	}

	class Map extends Base {
		type = 'map';

		autocomplete = field => {
			let that = this,
				$field = $( field ),
				autocomplete = $field.data( 'autocompleteController' );

			if ( autocomplete ) {
				return;
			}

			autocomplete = new google.maps.places.Autocomplete( field, this.settings );
			autocomplete.addListener( 'place_changed', function() {
				// Trigger for Map and other extensions.
				$field.trigger( 'selected_address' );

				var place = this.getPlace();
				if ( typeof place === 'undefined' ) {
					return;
				}

				place.lat = place.geometry.location.lat();
				place.lng = place.geometry.location.lng();
				place.geometry = place.geometry.location.lat() + ',' + place.geometry.location.lng();

				that.populateFromAddress( place, field );
			} );

			// Don't submit the form when select a address: https://metabox.io/support/topic/how-to-disable-submit-when-selecting-an-address/
			$field.on( 'keypress', function( e ) {
				return e.which !== 13;
			} );

			$field.data( 'autocompleteController', autocomplete );
		};

		populateMapFromLat = e => {
			const controller = this.getMapControllerFromLatLng( e.target.parentNode.nextSibling );
			if ( !controller ) {
				return;
			}

			const latLng = {
				lat: e.target.value,
				lng: controller.marker.getPosition().lng()
			};
			this.updateMap( controller, latLng );
		};

		populateMapFromLng = e => {
			const controller = this.getMapControllerFromLatLng( e.target.parentNode.nextSibling );
			if ( !controller ) {
				return;
			}

			const latLng = {
				lat: controller.marker.getPosition().lat(),
				lng: e.target.value
			};
			this.updateMap( controller, latLng );
		};

		// Update map's input value and marker.
		updateMap = ( controller, latLng ) => {
			const zoom = controller.map.getZoom();
			controller.$coordinate.val( latLng.lat + ',' + latLng.lng + ',' + zoom );

			const location = new google.maps.LatLng( latLng.lat, latLng.lng );
			controller.marker.setPosition( location );
			controller.map.setCenter( location );
		};

		/**
		 * Get value of a address component type.
		 *
		 * @link https://developers.google.com/maps/documentation/javascript/reference/3.exp/places-service#PlaceResult
		 *
		 * @param type  string                         Address component type.
		 * @param place google.maps.places.PlaceResult Information about a Place.
		 * @returns string
		 */
		getFieldData = ( binding, place ) => {
			// Check if binding is opening_hours
			if ( binding == 'opening_hours' && typeof place[ binding ] !== 'undefined' ) {
				let weekday_text = place[ binding ][ 'weekday_text' ],
					val = '';
				for ( let i = 0; i < weekday_text.length; i++ ) {
					if ( val == '' ) {
						val += weekday_text[ i ];
					} else {
						val += ', ' + weekday_text[ i ];
					}
				}

				return val;
			}

			if ( place.hasOwnProperty( binding ) ) {
				return place[ binding ];
			}

			// Find in `address_components`.
			for ( let i = 0; i < place.address_components.length; i++ ) {
				let component = place.address_components[ i ],
					longName = true,
					field = binding;

				if ( binding.includes( 'short:' ) ) {
					longName = false;
					field = binding.replace( 'short:', '' );
				}

				if ( component.types.includes( field ) ) {
					return longName ? component.long_name : component.short_name;
				}
			}

			if ( !binding.includes( '+' ) ) {
				return '';
			}

			// Allows users to merge data. For example: `shortname:country + ' ' + postal_code`
			let val = '', that = this;
			binding.split( '+' ).forEach( function( field ) {
				field = field.trim();

				if ( field.indexOf( "'" ) > -1 || field.indexOf( '"' ) > -1 ) {
					field = field.replace( /['"]+/g, '' );
					val += field;
				} else {
					val += that.getFieldData( field, place );
				}
			} );

			return val;
		};
	}

	class Osm extends Base {
		type = 'osm';

		autocomplete = field => {
			const that = this;
			$( field ).on( 'selected_address', ( e, item ) => {
				const data = {
					...item.address,
					lat: item.latitude,
					lng: item.longitude,
					geometry: item.latitude + ',' + item.longitude
				};

				that.populateFromAddress( data, field );
			} );
		};

		populateMapFromLat = e => {
			const controller = this.getMapControllerFromLatLng( e.target.parentNode.nextSibling );
			if ( !controller ) {
				return;
			}

			let latLng = controller.marker.getLatLng();
			latLng.lat = e.target.value;
			this.updateMap( controller, latLng );
		};

		populateMapFromLng = e => {
			const controller = this.getMapControllerFromLatLng( e.target.parentNode.nextSibling );
			if ( !controller ) {
				return;
			}

			let latLng = controller.marker.getLatLng();
			latLng.lng = e.target.value;
			this.updateMap( controller, latLng );
		};

		// Update map's input value and marker.
		updateMap = ( controller, latLng ) => {
			const zoom = controller.map.getZoom();
			controller.$coordinate.val( latLng.lat + ',' + latLng.lng + ',' + zoom );
			controller.marker.setLatLng( latLng );
			controller.map.panTo( latLng );
		};

		/**
		 * @link https://nominatim.org/release-docs/latest/api/Search/#examples
		 */
		getFieldData = ( binding, data ) => {
			if ( data.hasOwnProperty( binding ) ) {
				return data[ binding ];
			}

			if ( !binding.includes( '+' ) ) {
				return '';
			}

			// Allows users to merge data. For example: `shortname:country + ' ' + postal_code`
			let val = '', that = this;
			binding.split( '+' ).forEach( function( field ) {
				field = field.trim();

				if ( field.includes( "'" ) || field.includes( '"' ) ) {
					field = field.replace( /['"]+/g, '' );
					val += field;
				} else {
					val += that.getFieldData( field, data );
				}
			} );

			return val;
		};
	};

	function update() {
		$( '.rwmb-meta-box' ).each( function() {
			const type = this.querySelector( '.rwmb-osm' ) ? 'osm' : 'map';
			controller = 'osm' === type ? new Osm( this ) : new Map( this );

			controller.init();
			$( this ).data( 'controller', controller );
		} );
	}

	$( function() {
		update();
		$( document ).on( 'clone_completed', update ); // Handle group clone event.
	} );

} )( jQuery, document, window.google );