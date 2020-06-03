/**
 */
(function($){

    /**
     * Archive page
     */
    if( $( 'body.auto-listings' ).hasClass( 'archive' ) ) {
        auto_listings_view_switcher();
        auto_listings_ordering();
        auto_listings_buy_sell();
    }

    /**
     * Single listing
     */
    if( $( 'body.auto-listings' ).hasClass( 'single' ) ) {
        auto_listings_google_map();
        auto_listings_slider();
    }

    /**
     * Search box
     */
    if( $( '.auto-listings-search' ).length > 0 ) {
        auto_listings_search_box();
    }

    auto_listings_tabs();


/**
 * ================================= FUNCTIONS =======================================
 */

    /**
     * Ordering
     */
    function auto_listings_ordering() {
        $('.auto-listings-ordering select.orderby').SumoSelect();
        $( '.auto-listings-ordering' ).on( 'change', 'select.orderby', function() {
            $( this ).closest( 'form' ).submit();
        });
    }

    /**
     * Buy/Sell option
     */
    function auto_listings_buy_sell() {
        $( '.auto-listings-search' ).on( 'change', 'select.purpose', function() {
            $( this ).closest( 'form' ).submit();
        });
    }


    /**
     * View switcher
     */
    function auto_listings_view_switcher() {

        var default_view = auto_listings.list_grid_view;

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

        if ( $("#image-gallery").length > 0) {

            $('#image-gallery').lightSlider({

                thumbItem: parseInt( auto_listings.thumbs_shown ),
                mode: auto_listings.gallery_mode,
                auto: auto_listings.auto_slide,
                pause: parseInt( auto_listings.slide_delay ),
                speed: parseInt( auto_listings.slide_duration ),
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
                galleryMargin: 10,
                thumbMargin: 10,
                enableDrag: false,
                currentPagerPosition: 'left',

                onSliderLoad: function(el) {
                    el.lightGallery({
                        selector: '#image-gallery .lslide'
                    });
                }
            });

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
			searchForm.setDefaultSelected();
			searchForm.toggleExtraFields();
			searchForm.setSelectedOnChange();
			searchForm.deleteSelectedFields();
			searchForm.handlePriceField();
			searchForm.reset();
		},
		initElement: function( $scope ) {
			searchForm.$searchForm    =  $scope.find( '.als' );
			searchForm.$selectFields  =  $scope.find( '.als select' );
			searchForm.$extraFields   =  $scope.find( '.als-toggle-wrapper' );
			searchForm.$selectedWrap  =  $scope.find( '.als-selected' );
			searchForm.$resetButton   =  $scope.find( '.als .reset-all');
			searchForm.$priceField    =  $scope.find( '.als' ).find( '[name="price"]' );
			searchForm.$locationField =  $scope.find( '.als' ).find( '[name="s"]' );
			searchForm.selected       = {};
		},
		initSumoSelect: function() {
			searchForm.$selectFields.SumoSelect({});
		},
		setDefaultSelected: function() {
			$selectedItems = searchForm.$searchForm.find( '.als-is-selected' );
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
			var label           = $selectedItem.find( '.field__label' ).text();
			var selectedKeyName = $select.attr( 'name' );
			var value           = '';
			if ( $select.val() ) {
				if ( ! $selectedItem.hasClass( 'als-is-selected' ) ) {
					$selectedItem.addClass( 'als-is-selected' );
				}
				value = $select.next( '.SelectBox' ).attr( 'title' );
			} else {
				$selectedItem.removeClass( 'als-is-selected' );
			}
			var selectedItem = {
				label: label,
				value: value
			};
			searchForm.selected[ selectedKeyName ] = selectedItem;
		},
		deleteSelectedFields: function() {
			searchForm.$searchForm.on( 'click', '.als-selected__item-close', function( e ) {
				var key = $( this ).attr( 'data-selected' );
				if ( key.indexOf( '[]' ) < 0 ) {
					$( 'select[name="' + key + '"]' ).val( '' );
				}
				$( 'select[name="' + key + '"]' )[0].sumo.unSelectAll();
				delete searchForm.selected[ key ];
				searchForm.printSelectedFields();
			} );
		},
		handlePriceField: function() {
			searchForm.$priceField.on( 'change', function() {
				var $this = $( this );
				var $wrapper = $this.closest( '.als' );
				var $minField = $wrapper.find( 'input[name="min_price"]' );
				var $maxField = $wrapper.find( 'input[name="max_price"]' );
				var value = $this.val();
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
					var $this = $( this );
					if ( ! $this.val() ) {
						return true;
					}
					if ( $this.attr( 'name' ).indexOf( '[]' ) < 0 ) {
						$this.val( '' );
					}
					$this[0].sumo.unSelectAll();
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
				output += `<span class="als-selected__item"><i class="ion-close-circled als-selected__item-close" data-selected="${ key }"></i>`;
                output += selectedItem.label ? `<span class="als-selected__item-label">${ selectedItem.label }: </span>` : '';
                output += `<span class="als-selected__item-value">${ selectedItem.value }</span></span>`;
			}
			searchForm.$selectedWrap.html( output );
		},
		toggleExtraFields: function() {
			searchForm.$searchForm.on( 'click', '.als-refine', function( e ) {
				e.preventDefault();
				searchForm.$extraFields.slideToggle( 200 );
				$( this ).toggleClass( 'shown' );
			} );
		},
	};

	searchForm.init();

})(jQuery);
