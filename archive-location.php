<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s
 */

get_header(); ?>

<?php
// Hero
get_template_part( 'template-parts/hero', 'archive-location' );

get_template_part( 'template-parts/hero', 'after-archive-location' );
?>

<?php


$locations = array();

if ( have_posts() ) : 
    
    $counter = 0;
    
    while ( have_posts() ) :
        the_post();
        
        $location = [];
        
        $location['id'] = ++$counter;
        $location['name'] = get_the_title();
        $location['permalink'] = get_permalink();
        
        // City is now just a description field. Field label changes in ACF field. 
        $fields = array( 'id', 'name', 'city', 'address', 'email', 'phone', 'category', 'map_marker' );
        
        
        foreach( $fields as $field ) {
            $data = get_field( $field );
            
            if( !empty( $data ) ) {
                
                if( 'map_marker' == $field ) {
                    $location['lat'] = $data['lat']; 
                    $location['lng'] = $data['lng']; 
                }
                
                $location[$field] = $data;
            }
             
        }
        
        $terms = get_the_terms( get_the_ID(), 'location_cat' );
        if( ! is_wp_error( $terms ) ) {
            $term = $terms[0]->name;
            $location['category'] = $term;
        }
        
        
        
        $location['address'] = nl2br( $location['address'] );
        
        array_push($locations, $location);
    
    endwhile;
    
    //Output JSON
    //echo json_encode($locations);
    
    
    add_action( 'wp_footer', function() {
        
        global $locations;
        
        $locations = json_encode($locations);
        
        ?>
        
        <script id="listTemplate" type="text/x-handlebars-template">
        {{#location}}
        <li data-markerid="{{markerid}}">
            <div class="list-label"><span>{{marker}}</span></div>
            <div class="list-details">
                <div class="list-content">
                    <div class="loc-name"><a href="{{permalink}}">{{{name}}}</a></div>
                    <div class="loc-description">{{{category}}}</div>
                    <div class="loc-addr">{{{address}}}</div> 
                    <div class="loc-phone">{{phone}}</div>
                    <div class="loc-links"><a href="{{permalink}}">Learn More</a></div>
                </div>
            </div>
        </li>
        {{/location}}
        </script>
        
        <script id="infowindowTemplate" type="text/x-handlebars-template">
        {{#location}}
        <div class="loc-name">{{{name}}}</div>
        <div>{{{address}}}</div>
        <div class="loc-links"><a href="{{permalink}}">Learn More</a></div>
        {{/location}}
        </script>
        
        
        <script>
			(function (document, window, $) {
                
				$('#bh-sl-map-container').storeLocator(
                {
                    
                    'defaultLoc': true,
					'defaultLat': '47.64863',
					'defaultLng' : '-122.52357469999998',
                    'mapSettings': {zoom: 10, styles: 
                    
                                            [
                          {
                            "elementType": "geometry",
                            "stylers": [
                              {
                                "color": "#f5f5f5"
                              }
                            ]
                          },
                          {
                            "elementType": "labels.icon",
                            "stylers": [
                              {
                                "visibility": "off"
                              }
                            ]
                          },
                          {
                            "elementType": "labels.text.fill",
                            "stylers": [
                              {
                                "color": "#616161"
                              }
                            ]
                          },
                          {
                            "elementType": "labels.text.stroke",
                            "stylers": [
                              {
                                "color": "#f5f5f5"
                              }
                            ]
                          },
                          {
                            "featureType": "administrative.land_parcel",
                            "elementType": "labels.text.fill",
                            "stylers": [
                              {
                                "color": "#bdbdbd"
                              }
                            ]
                          },
                          {
                            "featureType": "poi",
                            "elementType": "geometry",
                            "stylers": [
                              {
                                "color": "#eeeeee"
                              }
                            ]
                          },
                          {
                            "featureType": "poi",
                            "elementType": "labels.text.fill",
                            "stylers": [
                              {
                                "color": "#757575"
                              }
                            ]
                          },
                          {
                            "featureType": "poi.park",
                            "elementType": "geometry",
                            "stylers": [
                              {
                                "color": "#e5e5e5"
                              }
                            ]
                          },
                          {
                            "featureType": "poi.park",
                            "elementType": "labels.text.fill",
                            "stylers": [
                              {
                                "color": "#9e9e9e"
                              }
                            ]
                          },
                          {
                            "featureType": "road",
                            "elementType": "geometry",
                            "stylers": [
                              {
                                "color": "#ffffff"
                              }
                            ]
                          },
                          {
                            "featureType": "road.arterial",
                            "elementType": "labels.text.fill",
                            "stylers": [
                              {
                                "color": "#757575"
                              }
                            ]
                          },
                          {
                            "featureType": "road.highway",
                            "elementType": "geometry",
                            "stylers": [
                              {
                                "color": "#dadada"
                              }
                            ]
                          },
                          {
                            "featureType": "road.highway",
                            "elementType": "labels.text.fill",
                            "stylers": [
                              {
                                "color": "#616161"
                              }
                            ]
                          },
                          {
                            "featureType": "road.local",
                            "elementType": "labels.text.fill",
                            "stylers": [
                              {
                                "color": "#9e9e9e"
                              }
                            ]
                          },
                          {
                            "featureType": "transit.line",
                            "elementType": "geometry",
                            "stylers": [
                              {
                                "color": "#e5e5e5"
                              }
                            ]
                          },
                          {
                            "featureType": "transit.station",
                            "elementType": "geometry",
                            "stylers": [
                              {
                                "color": "#eeeeee"
                              }
                            ]
                          },
                          {
                            "featureType": "water",
                            "elementType": "geometry",
                            "stylers": [
                              {
                                "color": "#c9c9c9"
                              }
                            ]
                          },
                          {
                            "featureType": "water",
                            "elementType": "geometry.fill",
                            "stylers": [
                              {
                                "color": "#3287C4"
                              }
                            ]
                          },
                          {
                            "featureType": "water",
                            "elementType": "labels.text.fill",
                            "stylers": [
                              {
                                "color": "#9e9e9e"
                              }
                            ]
                          }
                        ]
                    
                    },
                    'dataType': 'json',
                    //'dataLocation': 'data/locations.json',
                    dataRaw: <?php echo $locations;?>,
                    'listTemplateID': 'listTemplate',
                    'infowindowTemplateID': 'infowindowTemplate',
                    'disableAlphaMarkers': true,
                    'storeLimit': -1,
                    'distanceAlert': -1,
                    'fullMapStart': true,
                    'listColor1': 'transparent',
                    'listColor2': 'transparent',
                    'callbackCreateMarker': function(map, point, letter, category) {
                        
                        var number = letter.charCodeAt(0) - "A".charCodeAt(0) + 1;
                                                
                        var image = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='37' height='52'%3E%3Cdefs%3E%3Cpath id='a' d='M31 89H0V0h62v89H31z'/%3E%3C/defs%3E%3Cg fill='none' fill-rule='evenodd' transform='translate%28-9 -23%29'%3E%3Cmask id='b' fill='%23fff'%3E%3Cuse xlink:href='%23a'/%3E%3C/mask%3E%3Cpath fill='%23AAC687' d='M45.126 35.944c-.193-.694-.58-1.434-.869-2.083C40.822 25.867 33.313 23 27.25 23 19.134 23 10.195 28.27 9 39.132v2.217c0 .093.032.925.078 1.342.67 5.174 4.89 10.676 8.04 15.853C20.507 64.09 24.024 69.546 27.508 75c2.15-3.56 4.292-7.166 6.39-10.633.574-1.016 1.239-2.031 1.81-3.002.381-.65 1.113-1.295 1.445-1.896C40.542 53.46 46 47.406 46 41.442v-2.45c0-.645-.828-2.91-.874-3.048zM27.234 47.87c-2.463 0-5.158-1.176-6.488-4.427-.199-.518-.183-1.555-.183-1.65v-1.461c0-4.142 3.681-6.028 6.884-6.028 3.94 0 6.99 3.016 6.99 6.784 0 3.769-3.26 6.782-7.203 6.782z' mask='url%28%23b%29'/%3E%3Ccircle cx='28' cy='41' r='11' fill='%23FFF'/%3E%3Ctext fill='%234A4A4A' font-family='sans-serif' font-size='14' font-weight='bold' x='28' y='46' text-anchor='middle'%3E " + number + " %3C/text%3E%3C/g%3E%3C/svg%3E";
                                                
                        return new google.maps.Marker({
                          position : point,
                          map      : map,
                          icon     : image,
                          draggable: false
                        });
                    }
                 }
                );
			}(document, window, jQuery));
            
		</script>
                
        <?php
        
        
    }, 99, 1);
    
endif;

 

?>

<div class="column row">

     <div id="primary" class="content-area">
    
        <main id="main" class="site-main" role="main">
            <div class="bh-sl-container">
              
                <section class="section-intro">
                  <div class="box bh-sl-form-container">
                    <form id="bh-sl-user-location" method="post" action="#">
                        <div class="form-input">
                          <label for="bh-sl-address"><?php printf('<img src="%sicons/address-pin.svg" width="28px" height="39px" />', trailingslashit( THEME_IMG ) );?><span class="screen-reader-text">Zip Code</span></label>
                          <input type="text" id="bh-sl-address" name="bh-sl-address" placeholder="Enter Zip Code" />
                        </div>
            
                        <button id="bh-sl-submit" class="blue button" type="submit">Find Now</button>
                    </form>
                  </div>
              </section>
        
              <div id="bh-sl-map-container" class="bh-sl-map-container">
                <div id="bh-sl-map" class="bh-sl-map"></div>
                <div class="bh-sl-loc-list">
                  <ul class="list"></ul>
                </div>
              </div>
          </div>
    
        </main>
    
    </div>
  
</div>

<?php
get_footer();
