<?php

function enqueue_customjs() {
    wp_enqueue_script( 'custom-medifind-js', get_stylesheet_directory_uri() . '/custom.js', array( 'jquery' ), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'enqueue_customjs' );

function enqueue_customcss() {
    wp_enqueue_style( 'custom-medifind-css', get_stylesheet_directory_uri() . '/style.css', array(), '1.0.0', 'all' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_customcss' );

function get_googlemap()
    {
      return $result="
            <script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyB4jMrRuCraI1_tbk1ekCZBSg3orBYOqeA'></script>
            <script src='" . get_stylesheet_directory_uri() . "/markerclusterer_compiled.js'></script>
            <script>
                markers = [];
                map = null;
                markerCluster = null;
                
                function initialize() 
                {    
                    currentInfoWindow = null;        
                    var myLatlng = new google.maps.LatLng(37.8728033,-8.2015871);
                    var mapOptions = 
                    {
                            zoom: 10,
                            center: myLatlng,
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                    };

                    map = new google.maps.Map(document.getElementById('google_medifind_map'), mapOptions);
                    
                    google.maps.event.addListener(markers, 'click', function() 
                    {
                            if (currentInfoWindow != null) {
                                    currentInfoWindow.close();
                            }
                            infowindow.open(map, marker);
                            currentInfoWindow = infowindow;
                    });
                    
                    for(var i = 0; i < markers.length; i++) {
                            markers[i].setMap(map);
                    }
                    
                    mcOptions = { gridSize: 30,maxZoom: 12, styles: 
                    [{
                        height: 32,
                        url:  \"" . get_stylesheet_directory_uri() . "/pics/map-zoom.png\",
                        width: 32,

                        fontFamily: 'arial Bold',
                        textColor: '#515151'
                    }] 
                }

                markerCluster = new MarkerClusterer(map, null,mcOptions); 

                if(markers.length > 0) {
                    for(var i = 0; i < markers.length; i++) {
                        markers[i].setMap(null);
                    }
                    markerCluster.clearMarkers();    
                    markers = [];
                }

                " . get_googlemap_markers() . ";
        }
        google.maps.event.addDomListener(window, 'load', initialize);  
        </script>";   
    }
    
    function get_googlemap_markers() {
        $code .= '';
        $companies = get_companies();
        
        foreach( $companies as $company ) {
              $id = $company['id'];
              $name = $company['name'];
              $street = $company['address'];
              $city = $company['city'];
              $postnumber = $company['postnumber'];
              $gpsLat = $company['gpslatitude'];
              $gpsLong = $company['gpslongitude'];
              $code .= "
              var infowindow{$id} = new google.maps.InfoWindow
              ({
                    content:  '<div class=\"ramecekMapa\">'+
                    '<strong>{$name}</strong><br>'+
                    '{$street} {$postnumber}, {$city}<br>'+
                    '</div>'
              });

              var myLatlng{$id} = new google.maps.LatLng({$gpsLat} ,{$gpsLong});  
              var marker{$id} = new google.maps.Marker
              ({
                position: myLatlng{$id},
                map: map,
                icon: \"" . get_stylesheet_directory_uri() . "/pics/map-marker.png\"
              });
              google.maps.event.addListener(marker{$id}, 'click', function()
              {
                    if(currentInfoWindow != null) {
                        currentInfoWindow.close();
                    } 
                    infowindow{$id}.open(map,marker{$id});
                    currentInfoWindow = infowindow{$id};
              });
              markers.push(marker{$id});";  
        }
        $code .= "
                if(markers.length > 0) {
                    markerCluster.addMarkers(markers); 
                }
                ";
        return $code;
    }
    
    function get_companies() {
        
        global $wpdb;
        
        return $wpdb->get_results( 'SELECT * FROM mf_companies ORDER BY id ASC', ARRAY_A );
        
        /*return [
            0 => [
                'id' => '1',
                'name' => 'Instituto Clínico de Aljustrel',
                'address' => 'R. de Olivença nº 33',
                'city' => 'Aljustrel',
                'country' => 'Portugal',
                'phone' => '284 601 746',
                'gpslatitude' => '37.8798095',
                'gpslongitude' => '-8.161850',
            ],
            1 => [
                'id' => '2',
                'name' => 'Farmácia Dias',
                'address' => 'N261 109 105',
                'city' => 'Aljustrel',
                'country' => 'Portugal',
                'phone' => '???',
                'gpslatitude' => '37.8772545',
                'gpslongitude' => '-8.165344',
            ],
        ];*/
    }
    
    add_shortcode( 'medical_companies', 'get_googlemap' );
    
    function get_filter() {
        return '
        <form method="post" class="medifind_form" id="medifind_form">
            <input id="search_medicaments" name="search_medicaments" class="medifind_form_input" placeholder="medicaments">
            <input id="search_location" name="search_location" class="medifind_form_input" placeholder="city / location">
            <input type="submit" name="research" class="medifind_form_submit" id="medifind_form_submit" value="Search">
        </form>
        <div id="medifind_search_info" class="waiting">
            <span class="empty_results">Please type in what you search for ...</span>
            <img src="' . get_stylesheet_directory_uri() . '/pics/waiting-gif.gif" alt="loading...">
        </div>
        <div id="medifind_search_results_table" class="waiting"></div>
        ';
    }
    add_shortcode( 'medifind_filter', 'get_filter' );
    
    function medifind_rewrite_rules() {
        global $wp_rewrite;
        
        $new_non_wp_rules = array(
            'medifind_ajax/(.*)'    => 'wp-content/themes/DiviMedifind/ajax.php?page=$1',
        );
        $wp_rewrite->non_wp_rules += $new_non_wp_rules;
    }
    add_action( 'init', 'medifind_rewrite_rules' );
    