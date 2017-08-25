(function($){

    if ( $("#al-geocomplete").length > 0) {

        $( document ).ready(function() {
            $("#al-geocomplete").trigger( "geocode" );
        });
        
        var lat = $("input[name=_al_listing_lat]").val();
        var lng = $("input[name=_al_listing_lng]").val();

        var location = [lat,lng];
        $("#al-geocomplete").geocomplete({
            map: ".al-admin-map",
            details: "#post", // form id
            detailsAttribute: "data-geo",
            types: ["geocode", "establishment"],
            location: location,
            markerOptions: {
                draggable: true
            }
        });

        $("#al-geocomplete").bind("geocode:dragged", function(event, latLng){
            $("input[name=_al_listing_lat]").val(latLng.lat());
            $("input[name=_al_listing_lng]").val(latLng.lng());
        });

        $("#al-find").click(function(){
            $("#al-geocomplete").trigger("geocode");
        });
        
        $("#al-reset").click(function(){
            $("#al-geocomplete").geocomplete("resetMarker");
            return false;
        });

    }
    

})(jQuery);