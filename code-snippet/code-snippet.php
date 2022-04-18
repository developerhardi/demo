<?php

/*

Description: This is functions.php file of child theme from one of my project. I'm demostrating here different functionalities, Details are as below.

Function 1 wpb_loadmap: This function is fetching addresses(location) from MySql Database and loading data on google map as marker. Multiple markers are being placed.

Function 2 my_custom_fonts_new: This function loads style for menu element.

Function 3 custom_shop_page_redirect: In this, Shop page redirect to new created Shop page.

Function 4 print_my_inline_script_custom: Here, loading inline script on footer. If website opens using Mac devices,Class "mac-os" will be added to the "body" tag.

*/


// register shortcode
add_shortcode('all_map', 'wpb_loadmap');
// function that runs when shortcode is called
function wpb_loadmap()
{

    global $wpdb;
    $results = $wpdb->get_results("SELECT * FROM foodbank_partner WHERE Id != '1'", ARRAY_A);
    ?>

    <!--The div element for the map -->
    <div id="map"></div>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCJTFMQk9wwdwhVwvQsc8kTHn3gLwNclQ&callback=initMap&libraries=&v=weekly" async></script>

    <style type="text/css">
        /* Set the size of the div element that contains the map */
        #map {
            height: 475px;
            /* The height is 400 pixels */
            width: 100%;
            /* The width is the width of the web page */
        }
    </style>
    <script>
        // Initialize and add the map
        function initMap() {
            var markers = new Array();
            var locations = [
                <?php
                    foreach ($results as $res) {
                        $DP_Name = str_replace('/^(\'(.*)\'|"(.*)")$/', '', $res['DP_Name']);
                        $pinadd = '<b>' . $DP_Name . '</b><br><br>' . $res['DP_Billing_Address'] . '<br>' . $res['DP_Billing_City'] . '<br>' . $res['DP_Billing_Postal'] . '<br><br>Phone<br>' . $res['DP_Billing_Phone'];
                        ?>['<p><?php echo $pinadd; ?></p>', <?php echo $res['DP_Billing_Lat']; ?>, <?php echo $res['DP_Billing_Long']; ?>, '<?php echo $res['DP_Agency_Type']; ?>', '<?php echo $res['Id']; ?>', 12],

                <?php } ?>
            ];

            const uluru = {
                lat: <?php echo $results[1]['DP_Billing_Lat'] ?>,
                lng: <?php echo $results[1]['DP_Billing_Long'] ?>
            };

            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 14,
                center: uluru,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var infowindow = new google.maps.InfoWindow();

            var marker, i;

            for (i = 0; i < locations.length; i++) {

                var iconi = '';
                if (locations[i][3] == 'Multi-Service Program') {
                    iconi = 'https://www.centralpafoodbank.org/wp-content/plugins/store-locator-le/images/icons/bulb_AMP.png';
                } else if (locations[i][3] == 'Pantry') {
                    iconi = 'https://www.centralpafoodbank.org/wp-content/plugins/store-locator-le/images/icons/bulb_chartreuse.png';
                } else if (locations[i][3] == 'Pantry/Soup Kitchen') {
                    iconi = 'https://www.centralpafoodbank.org/wp-content/plugins/store-locator-le/images/icons/bulb_azure.png';
                } else if (locations[i][3] == 'Senior Program') {
                    iconi = 'https://www.centralpafoodbank.org/wp-content/plugins/store-locator-le/images/icons/bulb_orange.png';
                } else if (locations[i][3] == 'Soup Kitchen') {
                    iconi = 'https://www.centralpafoodbank.org/wp-content/plugins/store-locator-le/images/icons/bulb_violet.png';
                }

                jQuery('#map_sidebar #slp_results_wrapper_' + locations[i][4]).attr('data-markerid', i);
                jQuery('#map_sidebar #slp_results_wrapper_' + locations[i][4]).addClass('markerid' + i);

                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    icon: iconi,
                    map: map
                });

                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        infowindow.setContent(locations[i][0]);
                        infowindow.open(map, marker);

                        jQuery(".markerid" + i).show();
                    }
                })(marker, i));
                markers.push(marker);
            }

            //Trigger a click event on each marker when the corresponding marker link is clicked
            jQuery('#map_sidebar .results_wrapper').on('click', function() {
                google.maps.event.trigger(markers[jQuery(this).data('markerid')], 'click');
            });
        }
    </script>

<?php
}


add_action('admin_head', 'my_custom_fonts_new'); // admin_head is a hook my_custom_fonts is a function we are adding it to the hook
function my_custom_fonts_new() {
  echo '<style>
    #menu-appearance ul li:nth-last-child(3) {
	    display:none;
	}
  </style>';
}


add_action( 'template_redirect', 'custom_shop_page_redirect' );
//redirect shop page
function custom_shop_page_redirect() {
    if( is_shop() ){
        wp_redirect( home_url( '/shop_new/' ) );
        exit();
    }
}


add_action( 'wp_footer', 'print_my_inline_script_custom' );
function print_my_inline_script_custom() {
?>
    <script type="text/javascript">
        if(navigator.userAgent.indexOf('Mac') > 0){
            jQuery('body').addClass('mac-os');
        }
    </script>
<?php
}
