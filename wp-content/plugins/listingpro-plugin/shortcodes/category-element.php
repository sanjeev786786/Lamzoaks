<?php


/*------------------------------------------------------*/
/* Categories
/*------------------------------------------------------*/
$categories = get_terms('listing-category', array('hide_empty' => false)); 
$cats = array();
foreach($categories as $category) {
	$cats[$category->name] = $category->term_id;
}
vc_map( array(
	"name"                      => __("Listing Categories", "js_composer"),
	"base"                      => 'listing_cats',
	"category"                  => __('Listingpro', 'js_composer'),
	"description"               => '',
	"params"                    => array(
		array(
			'type'        => 'dropdown',
			'heading'     => __( 'Category Styles', 'js_composer' ),
			'param_name'  => 'catstyles',
			'description' => __( 'Choose your Category style', 'js_composer' ),
			'value'       => array(
				__("Abstracted View", "js_composer") => "cat_abstracted",
				__("Boxed View", "js_composer") => "cat_boxed",
				__("Abstracted & Boxed View", "js_composer") => "cat_grid_abstracted",
				__("Grid View", "js_composer") => "cat_ab_grid_abstracted"
				
			),
			'save_always' => true,
			
		),
		array(
            'type' => 'checkbox',
            'heading' => __( 'Select Category', 'js_composer' ),
            'param_name' => 'category_ids',
            'description' => __( 'Check the checkbox' ),
            'value' => $cats
        ),
	),
) );
function listingpro_shortcode_listing_cats($atts, $content = null) {
	extract(shortcode_atts(array(
		'category_ids'   => '',
		'catstyles'    => 'cat_grid_abstracted',

	), $atts));
	require_once (THEME_PATH . "/include/aq_resizer.php");
	$output = null;
	global $listingpro_options;
	$listing_mobile_view    =   $listingpro_options['single_listing_mobile_view'];
	
	if($listing_mobile_view == 'app_view' && wp_is_mobile() ){
		$output .= '<div class="lp-section-content-container lp-location-slider clearfix">';

		$listingCategories = $category_ids; 
		$ucat = array(
			'post_type' => 'listing',
			'hide_empty' => false,
			'orderby' => 'count',
			'order' => 'ASC',
			'include'=> $listingCategories
		);
		$allLocations = get_terms( 'listing-category',$ucat);
		$grid = 0;
		foreach($allLocations as $category) {
			$category_icon = listing_get_tax_meta($category->term_id,'category','image');
			$category_image = listing_get_tax_meta($category->term_id,'category','banner');
			$catImg = '';
			
			$cat_image_id = listing_get_tax_meta($category->term_id,'category','banner_id');
			if( !empty($cat_image_id) ){
			$thumbnail_url = wp_get_attachment_image_src($cat_image_id, 'listingpro_location270_400', true );
				$catImg = $thumbnail_url[0];
			}else{
				$imgurl = aq_resize( $category_image, '270', '400', true, true, true);
				if(empty($imgurl) ){
					$catImg = 'https://placeholdit.imgix.net/~text?txtsize=33&txt=372%C3%97240&w=372&h=240';
				}
				else{
					$catImg = $imgurl;
				}
			}
		
			$output .= '
			
				<div class="slider-for-category-container">
					<div class="">
						<div class="city-girds2">
							<div class="city-thumb2">
								<img src="'. $catImg.'" />
								<div class="category-style3-title-outer">
									<h3 class="lp-h3">
										<a href="'.esc_url( get_term_link( $category->term_id , 'listing-category')).'">'.esc_attr($category->name).'</a>
									</h3>
								</div>
								<a href="'.esc_url( get_term_link( $category )).'" class="overlay-link"></a>
								<div class="location-overlay"></div>
							</div>
							
							
						</div>
					</div>
				</div>
			';
			$grid++;
			
		}
	$output .= '</div>';
	}else{
		$output .= '<div class="lp-section-content-container clearfix">';

	$listingCategories = $category_ids; 
	$ucat = array(
		'post_type' => 'listing',
		'hide_empty' => false,
		'orderby' => 'count',
		'order' => 'ASC',
		'include'=> $listingCategories
	);
	$allLocations = get_terms( 'listing-category',$ucat);

	if($catstyles == 'cat_abstracted') {
		$grid = 0;
		foreach($allLocations as $category) {
			$category_icon = listing_get_tax_meta($category->term_id,'category','image');
			$category_image = listing_get_tax_meta($category->term_id,'category','banner');
			$catImg = '';
			
			$loc_term_children_array = array();
			$loc_term_children = get_term_children( $category->term_id, 'location' );
			$totalListinginLoc = lp_count_postcount_taxonomy_term_byID('listing','listing-category', $category->term_id);

			if($grid == 0){
				$gridStyle = 'col-md-6 col-sm-6  col-xs-12';
				
				$cat_image_id = listing_get_tax_meta($category->term_id,'category','banner_id');
				if( !empty($cat_image_id) ){
				$thumbnail_url = wp_get_attachment_image_src($cat_image_id, 'listingpro_location570_455', true );
					$catImg = $thumbnail_url[0];
				}else{
					$imgurl = aq_resize( $category_image, '570', '455', true, true, true);
					if(empty($imgurl) ){
						$catImg = 'https://placeholdit.imgix.net/~text?txtsize=33&txt=570%C3%97455&w=570&h=455';
					}
					else{
						$catImg = $imgurl;
					}
				}
				
				
			}elseif($grid == 1){
				$gridStyle = 'col-md-6 col-sm-6  col-xs-12';
				
				$cat_image_id = listing_get_tax_meta($category->term_id,'category','banner_id');
				if( !empty($cat_image_id) ){
				$thumbnail_url = wp_get_attachment_image_src($cat_image_id, 'listingpro_location570_228', true );
					$catImg = $thumbnail_url[0];
				}else{
					$imgurl = aq_resize( $category_image, '570', '228', true, true, true);
					if(empty($imgurl) ){
						$catImg = 'https://placeholdit.imgix.net/~text?txtsize=33&txt=570%C3%97228&w=570&h=228';
					}
					else{
						$catImg = $imgurl;
					}
				}
				
			}else{
				$gridStyle = 'col-md-3 col-sm-3 col-xs-12';
				
				$cat_image_id = listing_get_tax_meta($category->term_id,'category','banner_id');
				if( !empty($cat_image_id) ){
				$thumbnail_url = wp_get_attachment_image_src($cat_image_id, 'listingpro_location270_197', true );
					$catImg = $thumbnail_url[0];
				}else{
					$imgurl = aq_resize( $category_image, '270', '197', true, true, true);
					if(empty($imgurl) ){
						$catImg = 'https://placeholdit.imgix.net/~text?txtsize=33&txt=270%C3%97197&w=270&h=197';
					}
					else{
						$catImg = $imgurl;
					}
				}
				
			}

			$output .= '
			<div class="'.$gridStyle.'">
				<div class="city-girds lp-border-radius-8">
					<div class="city-thumb">
						<img src="'. $catImg.'" />
						
					</div>
					<div class="city-title text-center">
						<h3 class="lp-h3">
							<a href="'.esc_url( get_term_link( $category->term_id , 'listing-category')).'">'.esc_attr($category->name).'</a>
						</h3>
						<label class="lp-listing-quantity">'.esc_attr($totalListinginLoc).' '.esc_html__('Listings', 'listingpro-plugin').'</label>
					</div>
					<a href="'.esc_url( get_term_link( $category )).'" class="overlay-link"></a>
				</div>
			</div>';
			$grid++;
		}

	}elseif($catstyles=="cat_boxed") {

		foreach($allLocations as $cats) {
			$category_icon = listing_get_tax_meta($cats->term_id,'category','image');
			$category_image = listing_get_tax_meta($cats->term_id,'category','banner');

			$totalListinginLoc = lp_count_postcount_taxonomy_term_byID('listing','listing-category', $cats->term_id);

			$catImg = '';
			$cat_image_id = listing_get_tax_meta($cats->term_id,'category','banner_id');
			if( !empty($cat_image_id) ){
				$thumbnail_url = wp_get_attachment_image_src($cat_image_id, 'listingpro_location270_197', true );
				$catImg = $thumbnail_url[0];
			}else{
				$imgurl = aq_resize( $category_image, '270', '197', true, true, true);
				if(empty($imgurl) ){
					$catImg = 'https://placeholdit.imgix.net/~text?txtsize=33&txt=270%C3%97197&w=270&h=197';
				}
				else{
					$catImg = $imgurl;
				}
			}
			
			$output .= '
			<div class="col-md-3 col-sm-3 col-xs-12">
				<div class="city-girds lp-border-radius-8">
					<div class="city-thumb">
						<img src="'. $catImg.'" />
						
					</div>
					<div class="city-title text-center">
						<h3 class="lp-h3">
							<a href="'.esc_url( get_term_link( $cats->term_id , 'listing-category')).'">'.esc_attr($cats->name).'</a>
						</h3>
						<label class="lp-listing-quantity">'.esc_attr($totalListinginLoc).' '.esc_html__('Listings', 'listingpro-plugin').'</label>
					</div>
					<a href="'.esc_url( get_term_link( $cats )).'" class="overlay-link"></a>
				</div>
			</div>';
		}
	}elseif($catstyles == 'cat_grid_abstracted'){
	
		$grid = 0;
		foreach($allLocations as $category) {
			$category_icon = listing_get_tax_meta($category->term_id,'category','image');
			$category_image = listing_get_tax_meta($category->term_id,'category','banner');
			$catImg = '';
			$totalListinginLoc = lp_count_postcount_taxonomy_term_byID('listing','listing-category', $category->term_id);

			if($grid == 0){
				$gridStyle = 'col-md-6 col-sm-6  col-xs-12';
				
				$cat_image_id = listing_get_tax_meta($category->term_id,'category','banner_id');
				if( !empty($cat_image_id) ){
					$thumbnail_url = wp_get_attachment_image_src($cat_image_id, 'listingpro_location570_455', true );
					$catImg = $thumbnail_url[0];
				}else{
					$imgurl = aq_resize( $category_image, '570', '455', true, true, true);
					if(empty($imgurl) ){
						$catImg = 'https://placeholdit.imgix.net/~text?txtsize=33&txt=570%C3%97455&w=570&h=455';
					}
					else{
						$catImg = $imgurl;
					}
				}
				
			
			}else{
				$gridStyle = 'col-md-3 col-sm-3 col-xs-12';
				
				$cat_image_id = listing_get_tax_meta($category->term_id,'category','banner_id');
				if( !empty($cat_image_id) ){
					$thumbnail_url = wp_get_attachment_image_src($cat_image_id, 'listingpro_cats270_213', true );
					$catImg = $thumbnail_url[0];
				}else{
					$imgurl = aq_resize( $category_image, '270', '213', true, true, true);
					if(empty($imgurl) ){
						$catImg = 'https://placeholdit.imgix.net/~text?txtsize=33&txt=270%C3%97213&w=270&h=213';
					}
					else{
						$catImg = $imgurl;
					}
				}
				
			}

			$output .= '
			<div class="'.$gridStyle.'">
				<div class="city-girds lp-border-radius-8 city-girds4">
					<div class="city-thumb">
						<img src="'. $catImg.'" />
						
					</div>
					<div class="city-title text-center category-style3-title-outer">
						<h3 class="lp-h3">
							<a href="'.esc_url( get_term_link( $category->term_id , 'listing-category')).'">'.esc_attr($category->name).'</a>
						</h3>
						<label class="lp-listing-quantity">'.esc_attr($totalListinginLoc).' '.esc_html__('Listings', 'listingpro-plugin').'</label>'
						;
						
						$sub = get_term_children( $category->term_id, 'listing-category' );
						if(!empty($sub)){
							$output .= '<ul class="clearfix text-center sub-category-outer lp-listing-quantity">';
							$counter = 1;
							foreach ( $sub as $subID ) {
								if($counter == 1){

									$categoryTerm = get_term_by( 'id', $subID, 'listing-category' );
									
									$output .= '<li><p><a href="'.esc_url( get_term_link( $categoryTerm->term_id , 'listing-category')).'">'.$categoryTerm->name.'</a></p></li>';
								}
								$counter ++;
							}
							$output .= '</ul>';
							
							
						}
						
					$output .='	
					</div>
					<a href="'.esc_url( get_term_link( $category )).'" class="overlay-link"></a>
				</div>
			</div>';
			$grid++;
		}
	
	
	}else {
		
		$grid = 0;
		foreach($allLocations as $category) {
			$category_icon = listing_get_tax_meta($category->term_id,'category','image');
			$category_image = listing_get_tax_meta($category->term_id,'category','banner');
			$catImg = '';
			$totalListinginLoc = lp_count_postcount_taxonomy_term_byID('listing','listing-category', $category->term_id);
			
			$cat_image_id = listing_get_tax_meta($category->term_id,'category','banner_id');
			if( !empty($cat_image_id) ){
				$thumbnail_url = wp_get_attachment_image_src($cat_image_id, 'listingpro-blog-grid', true );
				$catImg = $thumbnail_url[0];
			}else{
				$imgurl = aq_resize( $category_image, '372', '240', true, true, true);
				if(empty($imgurl) ){
					$catImg = 'https://placeholdit.imgix.net/~text?txtsize=33&txt=372%C3%97240&w=372&h=240';
				}
				else{
					$catImg = $imgurl;
				}
			}
		
			
			
			
			$output .= '
			
				<div class="col-md-4 col-sm-4 col-xs-12">
					<div class="margin-bottom-30">
						<div class="city-girds2 lp-border-radius-8">
							<div class="city-thumb2">
								<img src="'. $catImg.'" />
								
								<div class="category-style3-title-outer">
									<h3 class="lp-h3">
										<a href="'.esc_url( get_term_link( $category->term_id , 'listing-category')).'">'.esc_attr($category->name).'</a>
									</h3>
								</div>
								<a href="'.esc_url( get_term_link( $category )).'" class="overlay-link"></a>
							</div>
							
						
						</div>
					</div>
				</div>
			';
			$grid++;
			
		}
		
	}
	
	$output .= '</div>';
	}
	
	
	
	
	
	return $output;
}
add_shortcode('listing_cats', 'listingpro_shortcode_listing_cats');