( function( $ ) {

	auto_listings_view_switcher();
	auto_listings_ordering();

	/**
	 * Single listing
	 */
	auto_listings_google_map();
	auto_listings_slider();

	/**
	 * Search box ( Old version )
	 */
	if( $( '.auto-listings-search' ).length > 0 ) {
		$('.auto-listings-search select').SumoSelect({});

		$('.auto-listings-search').on( 'click', 'a.refine', function( e ) {
			$( this ).next('.extras-wrap').slideToggle( 200 );
			$( this ).toggleClass( 'shown' );
		});
	}

	auto_listings_tabs();
/**
 * ================================= FUNCTIONS =======================================
 */

	/**
	 * Ordering
	 */
	function auto_listings_ordering() {
		if ( ! $('.auto-listings-ordering select.orderby').length ) {
			return;
		}
		$('.auto-listings-ordering select.orderby').SumoSelect({
			showTitle: false,
		});
		$( 'body' ).on( 'change', 'select.orderby', function() {
			$( this ).closest( 'form' ).submit();
		});
	}

	/**
	 * View switcher
	 */
	function auto_listings_view_switcher() {
		if ( ! $( '.auto-listings-view-switcher' ).length ) {
			return;
		}

		var default_view = auto_listings.list_grid_view || 'list';

		if( ! get_cookie( 'view' ) ) { switch_view( default_view ); }

		$( '.auto-listings-view-switcher div' ).click( function() {
			var view = $( this ).attr( 'id' );
			set_cookie( view );
			switch_view( view );
		});

		if( get_cookie( 'view' ) == 'grid') { switch_view( 'grid' ); }

		function switch_view( to ) {
			var from = ( to == 'list' ) ? 'grid' : 'list';
			var $switcher = $( '.auto-listings-view-switcher' );
			var $listings = $switcher.nextAll( '.auto-listings-items' );
			$listings.removeClass( from + '-view' ).addClass( to + '-view' );
		}

		function set_cookie( value ) {
			var days = 30; // set cookie duration
			if (days) {
				var date = new Date();
				date.setTime(date.getTime()+(days*24*60*60*1000));
				var expires = "; expires="+date.toGMTString();
			}
			else var expires = "";
			document.cookie = "view="+value+expires+"; path=/";
		}

		function get_cookie( name ) {
			var value = "; " + document.cookie;
			var parts = value.split("; " + name + "=");
			if (parts.length == 2) return parts.pop().split(";").shift();
		}

	}

	 /**
	 * Slider
	 */
	function auto_listings_slider() {

		if ( $( '#image-gallery' ).length > 0 ) {

			$( '#image-gallery' ).lightSlider( {

				thumbItem: 6,
				mode: 'slide',
				auto: true,
				pause: 2000,
				speed: 1000,
				prevHtml: '<i class="fa fa-angle-left"></i>',
				nextHtml: '<i class="fa fa-angle-right"></i>',
				pager: true,
				controls: true,

				addClass: 'listing-gallery',
				gallery: true,
				item: 1,
				autoWidth: false,
				loop: true,
				slideMargin: 0,
				thumbMargin: 10,
				galleryMargin: 10,
				enableDrag: false,
				currentPagerPosition: 'left',

				onSliderLoad: function(el) {
					el.lightGallery({
						selector: '#image-gallery .lslide'
					} );
				}
			} );

		}

	}

	/**
	 * Tabs
	 */
	function auto_listings_tabs() {

		$( 'body' ).on( 'init', '.al-tabs-wrapper, .auto-listings-tabs', function() {

				$( '.al-tab, .auto-listings-tabs .panel:not(.panel .panel)' ).hide();

				var $tabs = $( this ).find( '.al-tabs, ul.tabs' ).first();

				$tabs.find( 'li:first a' ).click();

				// show reset password tab
				if( $('.al-tab').hasClass('resetpass') ) {
					$tabs.find( 'li:last a' ).click();
				}

			} )
			.on( 'click', '.al-tabs li a, ul.tabs li a', function( e ) {

				e.preventDefault();
				var $tab          = $( this );
				var $tabs_wrapper = $tab.closest( '.al-tabs-wrapper, .auto-listings-tabs' );
				var $tabs         = $tabs_wrapper.find( '.al-tabs, ul.tabs' );

				$tabs.find( 'li' ).removeClass( 'active' );
				$tabs_wrapper.find( '.al-tab, .panel:not(.panel .panel)' ).hide();

				$tab.closest( 'li' ).addClass( 'active' );
				$tabs_wrapper.find( $tab.attr( 'href' ) ).show();
			} );

		// Init Tabs
		$( '.al-tabs-wrapper, .auto-listings-tabs' ).trigger( 'init' );

	}


	/**
	 * Google map
	 */
	function auto_listings_google_map() {
		if ( typeof google !== 'object' ) return;
		var map = $( '#auto-listings-map' );
		if ( map.length == 0 ) {
			return;
		}
		var lat = auto_listings.lat;
		var lng = auto_listings.lng;

		if( ( lat && lng ) && ( lat.length > 0 && lng.length > 0 ) ) {

			var options = {
				center: new google.maps.LatLng( lat, lng ),
				zoom: parseInt( auto_listings.map_zoom ),
			}

			al_map = new google.maps.Map( document.getElementById( 'auto-listings-map' ), options );

			var position = new google.maps.LatLng( lat, lng );

			var al_icon = {
				path: 'M25,0 C60,0, 60,50, 25,50 C-10,50, -10,0, 25,0',
				fillColor: '#26a0f2',
				fillOpacity: 0.4,
				scale: 1.5,
				strokeColor: '#26a0f2',
				strokeWeight: 3
			};

			var set_marker = new google.maps.Marker({
				map: al_map,
				icon: al_icon,
				position: position
			});

		}

	}

	var FilterModelByMake = function( makeSelect ) {
		this.makeSelect = makeSelect;
		this.modelSelect = null;
	};

	FilterModelByMake.prototype.init = function() {
		var that = this;
		that.modelSelect = that.makeSelect.closest( '.als, .auto-listings-search' ).find( '.als-field--model select, .model select' );
		if ( ! that.modelSelect.length ) {
			return;
		}
		var selected = that.makeSelect.val();
		if ( ! selected || ! selected.length ) {
			that.modelSelect[0].sumo.disable();
		} else {
			that.filterModel( selected );
		}

		that.makeSelect.on( 'change', function() {
			that.filterModel( $( this ).val() );
		} );
	};
	FilterModelByMake.prototype.filterModel = function( selected ) {
		var that = this;
		var data = {
			action: 'model_filter',
			selected: selected
		};
		var $request = $.post( auto_listings.ajaxUrl, data );
		$request.done( function( response ) {
			that.handleResponse( response );
		} );
	};
	FilterModelByMake.prototype.handleResponse = function( response ) {
		var that = this;
		if ( ! response.success ) {
			that.modelSelect[0].sumo.disable();
			return;
		}
		var selectedModel = that.modelSelect.val();
		var options       = response.data;
		that.modelSelect.html( options );
		that.modelSelect.val( selectedModel );
		that.modelSelect[0].sumo.reload();
		that.modelSelect[0].sumo.enable();
	};

	/**
	 * Search Form
	 */
	var searchForm = {
		init: function( $scope = $( 'body' ) ) {
			if ( ! $scope.find( '.als' ).length ) {
				return;
			}
			searchForm.initElement( $scope );
			searchForm.initSumoSelect();
			searchForm.appendSearchKey();
			searchForm.setDefaultSelected();
			searchForm.toggleExtraFields();
			searchForm.setSelectedOnChange();
			searchForm.deleteSelectedFields();
			searchForm.handlePriceField();
			searchForm.reset();
		},
		initElement: function( $scope ) {
			searchForm.$form          = $scope.find( '.als' );
			searchForm.$selectFields  = $scope.find( '.als select' );
			searchForm.$extraFields   = $scope.find( '.als-toggle-wrapper' );
			searchForm.$selectedWrap  = $scope.find( '.als-selected' );
			searchForm.$resetButton   = $scope.find( '.als-reset' );
			searchForm.$priceField    = $scope.find( '.als' ).find( '[name="price"]' );
			searchForm.$locationField = $scope.find( '.als' ).find( '[name="s"]' );
			searchForm.selected       = {};
		},
		initSumoSelect: function() {
			searchForm.$selectFields.each( function() {
				var $this = $( this );
				$this.SumoSelect( {
					'placeholder': $this.attr( 'data-placeholder' )
				} )
			} );
		},
		appendSearchKey: function() {
			if ( searchForm.$form.find( '[name="s"]' ).length !== 0 ) {
				return;
			}
			searchForm.$form.append( '<input type="hidden" name="s" />' )
		},
		setDefaultSelected: function() {
			$selectedItems = searchForm.$form.find( '.als-is-selected' );
			if ( $selectedItems.length === 0 ) {
				return;
			}
			$selectedItems.each( function() {
				searchForm.setSelectedFields( $( this ) );
			} );
			searchForm.printSelectedFields();
		},
		setSelectedOnChange: function() {
			searchForm.$selectFields.on( 'change', function() {
				var $this       = $( this );
				var $searchItem = $this.closest( '.als-field' );
				searchForm.setSelectedFields( $searchItem );
				searchForm.printSelectedFields();
			} );
		},
		setSelectedFields: function( $selectedItem ) {
			var $select         = $selectedItem.find( 'select' );
			var selectedKeyName = $select.attr( 'name' );
			var selectValue     = $select.val() || []; // For jQuery < 3, empty multiple select return null;
			if ( selectValue.length ) {
				if ( ! $selectedItem.hasClass( 'als-is-selected' ) ) {
					$selectedItem.addClass( 'als-is-selected' );
				}
				var selectedItem = {
					label: $selectedItem.find( '.als-field__label' ).text(),
					value: $select.next( '.SelectBox' ).attr( 'title' )
				};
				searchForm.selected[ selectedKeyName ] = selectedItem;
			} else {
				$selectedItem.removeClass( 'als-is-selected' );
				delete searchForm.selected[ selectedKeyName ]
			}
		},
		deleteSelectedFields: function() {
			searchForm.$form.on( 'click', '.als-selected__close', function( e ) {
				var key     = $( this ).attr( 'data-selected' );
				var $select = $( 'select[name="' + key + '"]' );

				searchForm.emptySelectValue( $select );

				delete searchForm.selected[ key ];
				searchForm.printSelectedFields();
			} );
		},
		handlePriceField: function() {
			searchForm.$priceField.on( 'change', function() {
				var $minField = searchForm.$form.find( '[name="min_price"]' );
				var $maxField = searchForm.$form.find( '[name="max_price"]' );
				var value = $( this ).val();
				if ( value == '' ) {
					$minField.val( '' );
					$maxField.val( '' );
				} else {
					value = value.split( '-' );
					$minField.val( value[0] );
					$maxField.val( value[1] );
				}
			} );
		},
		reset: function() {
			searchForm.$resetButton.on( 'click', function( e ) {
				e.preventDefault();
				searchForm.$selectFields.each( function() {
					searchForm.emptySelectValue( $( this ) );
				} );
				searchForm.$locationField.val('');
				searchForm.selected = {};
				searchForm.$selectedWrap.empty();
			} );
		},
		printSelectedFields: function() {
			var output = '';
			for( var key in searchForm.selected ) {
				var selectedItem = searchForm.selected[ key ];
				if ( selectedItem.value === '' ) {
					continue;
				}
				output += `<span class="als-selected__item"><i class="als-selected__close" data-selected="${ key }"></i>`;
				output += selectedItem.label ? `<span class="als-selected__label">${ selectedItem.label }: </span>` : '';
				output += `<span class="als-selected__value">${ selectedItem.value }</span></span>`;
			}
			searchForm.$selectedWrap.html( output );
		},
		toggleExtraFields: function() {
			searchForm.$form.on( 'click', '.als-toggle', function( e ) {
				e.preventDefault();
				searchForm.$extraFields.slideToggle( 200 );
				$( this ).toggleClass( 'shown' );
			} );
		},
		emptySelectValue: function( $select ) {
			if ( ! $select.val() ) {
				return;
			}
			$select.val( '' );
			$select[0].sumo.unSelectAll();
			$select.siblings( '.multiple' ).find( 'li' ).removeClass( 'selected' );
		}
	};

	searchForm.init();
	$( window ).on( 'load', function() {
		$( '.als-field--make select, .make select' ).each( function() {
			var filter = new FilterModelByMake( $( this ) );
			filter.init();
		} );
	} );
} )( jQuery );
