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
     * Search box
     */
    function auto_listings_search_box() {

        $('#auto-listings-search select').SumoSelect({
        });

        $('.auto-listings-search').on( 'click', 'a.refine', function( e ) {
            $( this ).next('.extras-wrap').slideToggle( 200 );
            $( this ).toggleClass( 'shown' );
        });

    }

})(jQuery);
