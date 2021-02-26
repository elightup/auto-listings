<?php
/**
 * This is Meta Box Geolocation usage example.
 * Include this file to your plugin or theme or see the usage guide below to apply to your Meta Box.
 */
add_filter( 'rwmb_meta_boxes', function( $meta_boxes )
{
    $meta_boxes[] = array(
        'id' 		=> 'geolocation',
        'title' 	=> 'GeoLocation',
        'context'	=> 'normal',
        'priority'	=> 'high',
        // Tell WP this Meta Box is GeoLocation
        'geo' => true,

        // Or you can set advanced settings for Geo, like this example:
        // Restrict results to Australia only.
        // Uncomment to use it.
//        'geo' => array(
//            'componentRestrictions' => array(
//                'country' => 'au'
//            )
//        ),

        'fields' => array(
             array(
                'type' => 'text',
                'name' => 'Address',
                'id'    => 'address',
            ),
            // Auto populate `postal_code` to this field
            array(
                'type' => 'number',
                'name' => 'Postcode',
                'id'    => 'postal_code'
            ),
            // Auto populate also works with Select field. In case you want to limit your result like this example.
            // Auto populate short name of `administrative_area_level_1`. For example: QLD
            array(
                'type' => 'select',
                'name' => 'State',
                'placeholder' => 'Select a State',
                'options' => array(
                    'ACT' => 'ACT',
                    'QLD' => 'QLD',
                    'NSW' => 'NSW',
                    'NT'  => 'NT',
                    'SA'  => 'SA',
                    'TAS' => 'TAS',
                    'VIC' => 'VIC',
                    'WA'  => 'WA'
                ),
                'id'    => 'administrative_area_level_1_short'
            ),

            // You can set different ID but still can auto populate `route` to this field.
            array(
                'type' => 'text',
                'name' => 'Route',
                'id'    => 'dummy_field',
                'binding' => 'route'
            ),

            // We have custom `geometry` address component. Which is `lat + ',' + lng`
            array(
                'type' => 'text',
                'name' => 'Geometry',
                'id'    => 'geometry'
            ),

            // But you can always use Binding Template to bind data like so
            array(
                'type' => 'text',
                'name' => 'Geometry with custom template',
                'id'    => 'geometry2',
                'binding' => 'lat + "," + lng' // lat,lng
            ),

            // Here is the advanced usage of Binding Template.
            // Put any address component + anything you want
            array(
                'type' => 'text',
                'name' => 'State + Country',
                'id'    => 'state_country',
                // Example Output: QLD AU
                'binding' => 'short:administrative_area_level_1 + " " + country'
            ),
        )
    );

    return $meta_boxes;
} );