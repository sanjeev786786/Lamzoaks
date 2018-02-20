<?php

	global $wpdb, $listingpro_options;
	$dbprefix = '';
	$dbprefix = $wpdb->prefix;
	$user_ID = '';
	$user_ID = get_current_user_id();
	$currency = '';
	$currency = $listingpro_options['currency_paid_submission'];
	$currency_symbol = listingpro_currency_sign();
	$currency_position = '';
	$currency_position = $listingpro_options['pricingplan_currency_position'];
	$enableTax = false;
	$Taxrate='';
	$Taxtype='';
	if($listingpro_options['lp_tax_swtich']=="1"){
		$enableTax = true;
		$Taxrate = $listingpro_options['lp_tax_amount'];
		$Taxtype = $listingpro_options['lp_tax_label'];
	}
	
	$results = $wpdb->get_results( "SELECT * FROM ".$dbprefix."listing_orders WHERE user_id ='$user_ID' AND status = 'in progress' ORDER BY main_id DESC" );
	if( count($results) >0 ){
		$output .='<h2 class="lp_select_listing_heading">'.esc_html__('SELECT A LISTING', 'listingpro-plugin').'</h2>';
		$output .='<div class="lp-checkout-wrapper">';
				foreach ( $results as $info ) {
								
								if(isset($info->post_id)){
									$post_id = $info->post_id;
									
								}
										//$postmeta = get_post_meta($post_id, 'lp_listingpro_options', true);
										$plan_id = listing_get_metabox_by_ID('Plan_id',$post_id);
										$plan_price = get_post_meta($plan_id, 'plan_price', true);
										$plan_duration = get_post_meta($plan_id, 'plan_time', true);
										$plan_type = get_post_meta($plan_id, 'plan_package_type', true);
										$terms = wp_get_post_terms( $post_id, 'listing-category', array() );
										$price = '';
										$price = $plan_price;
										$deafaultFeatImg = lp_default_featured_image_listing();
										
										$catname = '';
										if( count($terms)>0 ){
											$catname = $terms[0]->name;
										}
										if(!empty($plan_price)){
											$output .='<div class="lp-user-listings clearfix" data-plantype="'.$plan_type.'" data-recurringtext="'.esc_html__('Recurring Payment?', 'listingpro-plugin').'"><div class="col-md-12 col-sm-12 col-xs-12 lp-listing-clm lp-checkout-page-outer">';
											
											$output .= '<div class="col-md-1 col-sm-2 col-xs-6">';
											
											$output .='<div class="radio radio-danger lp_price_trigger_checkout">
															<input type="radio" name="listing_id" data-taxenable = "'.$enableTax.'" data-taxrate = "'.$Taxrate.'" data-planprice = "'.$plan_price.'" data-title="'.get_the_title($plan_id).'" data-price="'.$price.'" id="'.$post_id.'" value="'.$post_id.'">
															<label for="'.$post_id.'">
															 
															</label>
														</div>';
											$output .='</div>';
											
											if ( has_post_thumbnail($post_id) ) { 
												
												$imgurl = get_the_post_thumbnail_url($post_id, 'listingpro-checkout-listing-thumb');
												$output .= '<input type="hidden" name="listing_img" value="'.$imgurl.'">';
												$output .='<div class="col-md-3">';
												$output .='<img class="img-responsive" src="'.$imgurl.'" alt="" />';
												$output .='</div>';
												
											}
											elseif(!empty($deafaultFeatImg)){
												$output .= '<input type="hidden" name="listing_img" value="'.$deafaultFeatImg.'">';
												$output .='<div class="col-md-3">';
												$output .='<img class="img-responsive" src="'.$deafaultFeatImg.'" alt="" />';
												$output .='</div>';
											}
											else {
												$output .='<div class="col-md-3">';
												$output .='<img class="img-responsive" src="'.esc_url('https://placeholdit.imgix.net/~text?txtsize=33&txt=ListingPro&w=372&h=240').'" alt="" />';
												$output .='</div>';
											} 
											$output .= '<h5>';
											$output .= get_the_title($post_id);
											$output .='</h5>';
											$output .= '<div class="col-md-2 col-sm-2 col-xs-6">';
											
											$output .= '<span class="lp-booking-dt">'.esc_html__('Date:','listingpro-plugin').'</span>
											<p>'.get_the_date('', $post_id).'</p>';
											
											$output .='</div>';
											$output .= '<div class="col-md-2 col-sm-2 col-xs-6">';
											
											$output .= '<span class="lp-persons">'.esc_html__('Category:','listingpro-plugin').'</span>
											<p>'.$catname.'</p>';
											
											$output .='</div>';
											$output .= '<div class="col-md-2 col-sm-2 col-xs-6">';
											
											$output .= '<span class="lp-duration">'.esc_html__('Duration:','listingpro-plugin').'</span>
											<p>'.$plan_duration.esc_html__(' Days','listingpro-plugin').'</p>';
											
											$output .='</div>';
											$output .= '<div class="col-md-2 col-sm-2 col-xs-6">';
											
											if(!empty($currency_position)){
												if($currency_position=="left"){
													$output .= '<span class="lp-booking-type">'.esc_html__('Price:','listingpro-plugin').'</span>
											<p>'.$currency_symbol.$plan_price.'</p>';
												}
												else{
													$output .= '<span class="lp-booking-type">'.esc_html__('Price:','listingpro-plugin').'</span>
											<p>'.$plan_price.$currency_symbol.'</p>';
												}
											}
											else{
												$output .= '<span class="lp-booking-type">'.esc_html__('Price:','listingpro-plugin').'</span>
											<p>'.$currency_symbol.$plan_price.'</p>';
											}
											
											
											
											
											
											$output .= '<input type="hidden" name="plan_price" value="'.$price.'">';
											$output .= '<input type="hidden" name="currency" value="'.$currency.'">';
											$output .= '<input type="hidden" name="post_title" value="'.get_the_title($post_id).'">';
											$output .= '<input type="hidden" name="listings_id" value="'.$post_id.'">';
											$output .= '<input type="hidden" name="plan_id" value="'.$plan_id.'">';
											
											$output .='</div>';
											
											$output .='</div>';
											$output .='</div>';
										}
									
							
							}
				$output .='</div>';
	}
	else{
			$output .='<p class="text-center">'.esc_html__('Sorry! You have no paid listings yet!','listingpro-plugin').'</p>';
	}