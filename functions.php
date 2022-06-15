//Modify marker based on taxonomy
add_filter(
	'wp_grid_builder_map/geojson',
	function( $json, $facet ) {
 
		$json['features'] = array_map(
			function( $feature ) {
 
				$icon_url  = '';
				$post_id   = $feature['properties']['id'];
				$terms = get_the_terms( $post_id, 'act_cat' );
        // get the current taxonomy term
        $term = get_queried_object();
                
                if ( !empty( $terms ) ){
                // get the first term
                $term = array_shift( $terms );

                // vars
                $image = get_field('t_marker', $term);

                // image id is stored as term meta
                // $image_id = get_term_meta( $term->term_id, 'image', true );
                // $image_id = get_term_meta( $term->term_id, 'image', true );
                
                // image data stored in array, second argument is which image size to retrieve
                $image_data = wp_get_attachment_image_src( $image_id, 'full' );
                
                // icon url is the first item in the array (aka 0)
                $icon_url = $image;

                }
 
 
				if ( ! empty( $icon_url ) ) {
					$feature['properties']['icon']['url'] = $icon_url;
				}
				else {
				    
				}
 
				return $feature;
 
			},
			$json['features']
		);
 
		return $json;
 
	},
	10,
	2
);
