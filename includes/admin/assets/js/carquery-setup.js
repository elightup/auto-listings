(function($){

    //Create a variable for the CarQuery object.  You can call it whatever you like.
    var carquery = new CarQuery();

   

    $('#cq-show-data').hide();
    $('.show-data-desc').hide();

    $('#cq-select-model').click(  function(){ 
        
         //Run the carquery init function to get things started:
        carquery.init(); 
        
        //Optionally, you can pre-select a vehicle by passing year / make / model / trim to the init function:
        //carquery.init('2000', 'dodge', 'Viper', 11636);

        //Optional: Pass sold_in_us:true to the setFilters method to show only US models. 
        carquery.setFilters( {sold_in_us:false} );

        //Optional: initialize the year, make, model, and trim drop downs by providing their element IDs
        carquery.initYearMakeModelTrim('car-years', 'car-makes', 'car-models', 'car-model-trims');

        $('#cq-show-data').show();
        $('.show-data-desc').show();

    } );

    //Optional: set the onclick event for a button to show car data.
    $('#cq-show-data').click(  function(){ 
        populateMyData('_al_listing_specs'); 
    } );

     //Optional: initialize the make, model, trim lists by providing their element IDs.
     carquery.initMakeModelTrimList('make-list', 'model-list', 'trim-list', 'trim-data-list');

     //Optional: set minimum and/or maximum year options.
     //carquery.year_select_min=1980;
     //carquery.year_select_max=2017;

    function populateMyData(model_data_id) {
        
        carquery.model_data_id = model_data_id;
        carquery.cur_trim = $("select#"+carquery.trim_select_id).val();
        var cur_trim = $("select#"+carquery.trim_select_id + " option:selected").text();
        
        //Make sure there is a trim selected
        if(carquery.cur_trim == null || carquery.cur_trim == "") {
            //$("#"+carquery.model_data_id).html("");
            alert('Please select a year, make, and model.');
            return;
        }
        console.log(cur_trim);
        console.log(carquery.cur_trim);
        //Set a loading message while we retrieve the data
        //$("#"+carquery.model_data_id).html("Loading Model Data...");

        var sender = carquery;
        
        //Get Car Model JSON for the selected make
        $.getJSON(carquery.base_url+"?callback=?", {cmd:"getModel", model:carquery.cur_trim}, function(data) {
        
            if(!sender.responseError(data)) {
                console.log(sender.model_data_id);
                // var out = sender.carDataHTML(data[0]);
                $.each(data[0], function (id, value) {
                    $( "#cmb2-metabox-" + sender.model_data_id + ' #_al_listing_'+id ).val(value);
                    $( "#cmb2-metabox-" + sender.model_data_id + ' #_al_listing_model_vehicle' ).val(cur_trim);
                    //console.log( cur_trim );
                });

            }

        });
        
    }

})(jQuery);