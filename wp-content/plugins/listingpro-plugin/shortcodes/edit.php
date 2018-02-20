<?php
	ob_start(); 
/*------------------------------------------------------*/
/* Edit Listing
/*------------------------------------------------------*/
vc_map( array(
	"name"                      => __("Edit Listing", "js_composer"),
	"base"                      => 'listingpro_edit',
	"category"                  => __('Listingpro', 'js_composer'),
	"description"               => '',
	"params"                    => array(
		
		array(
			"type"			=> "textfield",
			"class"			=> "",
			"heading"		=> __("Title","js_composer"),
			"param_name"	=> "title",
			"value"			=> ""
		),
		array(
			'type'        => 'textfield',
			'heading'     => __( 'Subtitle', 'js_composer' ),
			'param_name'  => 'subtitle',
			'value'       => ''
		),
	),
) );
function listingpro_shortcode_edit($atts, $content = null) {
	
	extract(shortcode_atts(array(
		'title'   => '',
		'subtitle'   => ''		
	), $atts));
	
	do_action('lp_call_maps_scripts');
	global $listingpro_options;
	
	
	/* EDIT LIST */
	$lp_post ='';
	$form_field ='';
	$faqs ='';
	$faq ='';
	$faqans ='';
	$gAddress ='';
	$latitude ='';
	$longitude ='';
	$phone ='';
	$email ='';
	$website ='';
	$twitter ='';
	$facebook ='';
	$linkedin ='';
	$listingprice ='';
	$listingptext ='';
	$gPlus ='';
	$youtube ='';
	$instagram ='';
	$video ='';
	$gSiteKey = '';
	$gSiteKey = $listingpro_options['lp_recaptcha_site_key'];
	
	$singleLocMode = true;
	if( isset($listingpro_options['lp_listing_location_mode']) ){
		if($listingpro_options['lp_listing_location_mode']=="multi"){
			$singleLocMode = false;
		}
	}
	
	$singleCatMode = true;
	if( isset($listingpro_options['lp_listing_category_mode']) ){
		if($listingpro_options['lp_listing_category_mode']=="multi"){
			$singleCatMode = false;
		}
	}
				
	
	$enableCaptcha = lp_check_receptcha('lp_recaptcha_listing_edit');	
	if(isset($_GET['lp_post']) && !empty($_GET['lp_post'])){
		$lp_post = $_GET['lp_post'];	
		//$form_field = listing_get_metabox_by_ID('form_field', $lp_post);
		$tagline_text = listing_get_metabox_by_ID('tagline_text',$lp_post);
		$faqs = listing_get_metabox_by_ID('faqs',$lp_post);
		if(!empty($faqs)){
			$faq =$faqs['faq'];
			$faqans =$faqs['faqans'];
		}
		$gAddress = listing_get_metabox_by_ID('gAddress',$lp_post);
		$latitude = listing_get_metabox_by_ID('latitude', $lp_post);
		$longitude = listing_get_metabox_by_ID('longitude',$lp_post);
		$plan_id = listing_get_metabox_by_ID('Plan_id',$lp_post);
		$phone = listing_get_metabox_by_ID('phone', $lp_post);
		$email = listing_get_metabox_by_ID('email', $lp_post);
		$website = listing_get_metabox_by_ID('website', $lp_post);
		$twitter = listing_get_metabox_by_ID('twitter', $lp_post);
		$facebook = listing_get_metabox_by_ID('facebook',$lp_post);
		$linkedin = listing_get_metabox_by_ID('linkedin', $lp_post);
		$gPlus = listing_get_metabox_by_ID('google_plus', $lp_post);
		$youtube = listing_get_metabox_by_ID('youtube', $lp_post);
		$instagram = listing_get_metabox_by_ID('instagram', $lp_post);
		$video = listing_get_metabox_by_ID('video', $lp_post);
		$listingprice = listing_get_metabox_by_ID('list_price', $lp_post);
		$price_status = listing_get_metabox_by_ID('price_status', $lp_post);
		/* by zaheer on 17 march */
		$listingptext = listing_get_metabox_by_ID('list_price_to', $lp_post);
		/* end by zaheer on 17 march */		
		$metaFields = get_post_meta( $lp_post, 'lp_'.strtolower(THEMENAME).'_options_fields', true);
		$galleryImagesIDS = get_post_meta( $lp_post, 'gallery_image_ids', true);

		if(!empty($plan_id)){
			$plan_id = $plan_id;
		}else{
			$plan_id = 'none';
		}
		
		$contact_show = get_post_meta( $plan_id, 'contact_show', true );
		$map_show = get_post_meta( $plan_id, 'map_show', true );
		$video_show = get_post_meta( $plan_id, 'video_show', true );
		$gallery_show = get_post_meta( $plan_id, 'gallery_show', true );
		$tagline_show = get_post_meta( $plan_id, 'listingproc_tagline', true );
		$location_show = get_post_meta( $plan_id, 'listingproc_location', true );
		$website_show = get_post_meta( $plan_id, 'listingproc_website', true );
		$social_show = get_post_meta( $plan_id, 'listingproc_social', true );
		$faqs_show = get_post_meta( $plan_id, 'listingproc_faq', true );
		$price_show = get_post_meta( $plan_id, 'listingproc_price', true );
		$tags_show = get_post_meta( $plan_id, 'listingproc_tag_key', true );
		$hours_show = get_post_meta( $plan_id, 'listingproc_bhours', true );
		if($plan_id=="none"){
			$contact_show = 'true';
			$map_show = 'true';
			$video_show = 'true';
			$gallery_show = 'true';
			$tagline_show = 'true';
			$location_show = 'true';
			$website_show = 'true';
			$social_show = 'true';
			$faqs_show = 'true';
			$price_show = 'true';
			$tags_show = 'true';
			$hours_show = 'true';
		}
		
	}else{
		wp_redirect( home_url() ); exit;

	}
	
	if(is_user_logged_in()){
		
		$current_user = wp_get_current_user();
		$userID = $current_user->ID;
		$post_author_id = get_post_field( 'post_author', $lp_post );

		if($userID != $post_author_id) {
			wp_redirect( home_url() ); exit;
		}
	}else{
		wp_redirect( home_url() ); exit;
	}	


	$current_cat= array();
	$formFields='';
	$term_id=array();
	$n=1;
	$current_cat_array = get_the_terms($lp_post, 'listing-category');
	if(!empty($current_cat_array)){
		foreach($current_cat_array as $current_catt) {
				$current_cat[$n] = $current_catt->term_id;
				$term_id[$n] = $current_catt->term_id;
				$n++;
		}
	}
	
	
	$n=1;
	$fieldIDs;
	$fieldIDss = array();
	$allIdsArray = array();
	if(!empty($term_id)){
		foreach($term_id as $tid) {
			$fieldIDss= listingpro_get_term_meta($tid,'fileds_ids');
			if(!empty($fieldIDss)){
				foreach($fieldIDss as $singlefId){
					if(array_search($singlefId, $allIdsArray)){}else{
						$lppoststatus = get_post_status( $singlefId );
						if($lppoststatus=="publish"){
							array_push($allIdsArray,$singlefId);
						}
					}
				}
						
			}
			$n++;
		}
	}
	$n=1;
	$fieldIDs[$n]= $allIdsArray;
	
	$formFieldsArray = array();
	if(!empty($fieldIDs)){
		foreach($fieldIDs as $fid) {
			$formFieldsArray[$n]= listingpro_field_type($fid);
			$n++;
		}
	}
	
	if(!empty($formFieldsArray)){
		foreach($formFieldsArray as $ffields){
			$formFields .= $ffields;
		}
	}
	
	
	$locations_type = $listingpro_options['lp_listing_locations_options'];
	$locArea = '';
	if(!empty($locations_type) && $locations_type=="auto_loc"){
		$locArea = $listingpro_options['lp_listing_locations_range'];
	}

	/* EDIT FORM OUTPUT */


	$output = null;
	
	$output .= '
	<div class="page-container-four clearfix submit_new_style submit_new_style-outer">
		<div class="col-md-12 col-sm-12">
			<div class="form-page-heading">
				<h3>'.$title.'</h3>
				<p>'.$subtitle.'</p>
			</div>
			<div class="post-submit">
				<div class="author-section border-bottom lp-form-row clearfix lp-border-bottom padding-bottom-40">
					<div class="lp-form-row-left text-left pull-left not-logged-in-msg">
						<img class="avatar-circle" src="'.plugins_url( '/images/author.jpg', dirname(__FILE__) ).'" />
						<p>'.esc_html__('You are currently signed in as', 'listingpro-plugin').' <strong>'.listingpro_author_name().',</strong> <a href="'.wp_logout_url(esc_url(home_url('/'))).'" class="">'.esc_html__('Sign out', 'listingpro-plugin').'</a> ' .esc_html__('or continue below and start submission.', 'listingpro-plugin').'</p>
					</div>
				</div>';
				$pcontent= '';	$page_data = get_page($lp_post); 	$pcontent = $page_data->post_content;	//$pcontent = get_the_content($lp_post);	

				$quickTipTitle = $listingpro_options['quick_tip_title'];
				$quickTipText = $listingpro_options['quick_tip_text'];
				$submitImg = $listingpro_options['submit_ad_img']['url'];
				$submitImg1 = $listingpro_options['submit_ad_img1']['url'];
				$submitImg2 = $listingpro_options['submit_ad_img2']['url'];
				$submitImg3 = $listingpro_options['submit_ad_img3']['url'];

				/* Submit Fields ON/OFF */
				$listing_title_text = $listingpro_options['listing_title_text'];
				$listingCityText = $listingpro_options['listing_city_text'];
				$listingGaddText = $listingpro_options['listing_gadd_text'];
				$listingGaddcustomText = $listingpro_options['listing_custom_cordn'];
				$addressSwitch = $listingpro_options['lp_showhide_address'];
				$phoneSwitch = $listingpro_options['phone_switch'];
				$listingPhText = $listingpro_options['listing_ph_text'];
				$webSwitch = $listingpro_options['web_switch'];
				$listingWebText = $listingpro_options['listing_web_text'];
				$ophSwitch = $listingpro_options['oph_switch'];
				$listing_cat_text = $listingpro_options['listing_cat_text'];
				$listing_features_text = $listingpro_options['listing_features_text'];
				$currencySwitch = $listingpro_options['currency_switch'];
				$listingCurrText = $listingpro_options['listing_curr_text'];
				$digitPriceSwitch = $listingpro_options['digit_price_switch'];
				$listingDigitText = $listingpro_options['listing_digit_text'];
				$priceSwitch = $listingpro_options['price_switch'];
				$listingPriceText = $listingpro_options['listing_price_text'];
				$listing_desc_text = $listingpro_options['listing_desc_text'];
				$faq_switch = $listingpro_options['faq_switch'];
				$listing_faq_text = $listingpro_options['listing_faq_text'];
				$listing_faq_tabs_text = $listingpro_options['listing_faq_tabs_text'];
				$twSwitch = $listingpro_options['tw_switch'];
				$fbSwitch = $listingpro_options['fb_switch'];
				$lnkSwitch = $listingpro_options['lnk_switch'];
				$googleSwitch = $listingpro_options['google_switch'];
				$ytSwitch = $listingpro_options['yt_switch'];
				$instaSwitch = $listingpro_options['insta_switch'];
				$tags_switch = $listingpro_options['tags_switch'];
				$listingTagsText = $listingpro_options['listing_tags_text'];
				$vdoSwitch = $listingpro_options['vdo_switch'];
				$listingVdoText = $listingpro_options['listing_vdo_text'];
				$fileSwitch = $listingpro_options['file_switch'];
				$listingEmailText = $listingpro_options['listing_email_text'];

				$submit_ad_img_switch = $listingpro_options['submit_ad_img_switch'];
				$submit_ad_img1_switch = $listingpro_options['submit_ad_img1_switch'];
				$submit_ad_img2_switch = $listingpro_options['submit_ad_img2_switch'];
				$submit_ad_img3_switch = $listingpro_options['submit_ad_img3_switch'];
				$quick_tip_switch = $listingpro_options['quick_tip_switch'];

				$listing_btn_text = $listingpro_options['listing_edit_btn_text'];
				$showLocation = $listingpro_options['location_switch'];

				$btnText = '';
				if(!empty($listing_btn_text)) {
					$btnText = $listing_btn_text;
				}else {
					$btnText = esc_html__('Update & Preview', 'listingpro-plugin');
				}
				

				$output .='
				<form method="post" enctype=multipart/form-data id="lp-submit-form" name="lp-submit-form">
					<div class="white-section border-bottom">
						<div class="row">
							<div class="form-group col-md-6 col-xs-12">';
								if($quick_tip_switch == 1) {
									$output .='
									<div class="quick_tip">
										<h2>'. $quickTipTitle .'</h2>
										<p>'. $quickTipText .'</p>
									</div>';
								}
								$output .='
								<div class="form-group">
									<label for="usr">'.$listing_title_text.' <small>*</small></label>
									<div class="help-text">
										<a href="#" class="help"><i class="fa fa-question"></i></a>
										<div class="help-tooltip">
											<p>'.esc_html__('Put your listing title here and tell the name of your business to the world.', 'listingpro-plugin').'</p>
										</div>
									</div>
									<input type="text" value="'.get_the_title($lp_post).'" name="postTitle" class="form-control" id="lptitle">
								</div>';
								if($tagline_show == "true"){
									$output .='
									<div class="form-group">
										<input type="text" name="tagline_text" value="'.$tagline_text.'" class="form-control" id="lptagline" placeholder="' .esc_html__('Tagline Example: Best Express Mexican Grill', 'listingpro-plugin').'">									
									</div>';
								}
								$output .='
							</div>
							<div class="form-group col-md-6 col-xs-12">';
								if($submit_ad_img_switch == 1) {
									$output .='
									<div class="submit-img">
										<img src="'. $submitImg .'" alt="">
									</div>';
								}
								$output .='
							</div>
						</div>
						<div class="row">';
							if($showLocation=="1" && $location_show == "true"){
								if( !empty($locations_type)&& $locations_type=="auto_loc" ){
									if($singleLocMode==true){
										$output .='
										<div class="form-group col-md-6 col-xs-12 lp-new-cat-wrape">
											<label for="inputTags">'.$listingCityText.'</label>
											<div class="help-text">
												<a href="#" class="help"><i class="fa fa-question"></i></a>
												<div class="help-tooltip">
													<p>'.esc_html__('The city name will help users find you in search filters.', 'listingpro-plugin').'</p>
												</div>
											</div>';
										
												$current_loc ='';
												$current_loc_array = get_the_terms($lp_post, 'location');
												if(!empty($current_loc_array)){
													foreach($current_loc_array as $current_locc) {
															$current_loc = $current_locc->name;
													}
												}
											
												$output .='
														<input id="citiess" name="locationn" class="form-control postsubmitSelect" autocomplete="off" data-country="'.$locArea.'" placeholder="'.esc_html__('select your listing region', 'listingpro-plugin').'" value="'.$current_loc.'">	
														<input type="hidden" name="location" value="'.$current_loc.'">
												';
												
										$output .='
										</div>';
									}else{
										
										/* for google multiloation */
										$output .='<div class="form-group lp-selected-locs clearfix col-md-12">';
										$current_loc = array();
										$current_loc_array = get_the_terms($lp_post, 'location');
										if(!empty($current_loc_array)){
											foreach($current_loc_array as $current_locc) {
												$current_loc[] = $current_locc->term_id;
											}
										}
										$args = array(
											'post_type' => 'listing',
											'order' => 'ASC',
											'parent' => 0,
											'hide_empty' => false,
										);
										$locations = get_terms( 'location',$args);
										foreach($locations as $location) {
											
											if(!empty($current_loc)){
												foreach($current_loc as $cloc){
													if($location->term_id == $cloc){
														$output .=	'<div class="lpsinglelocselected '.$location->name.'">'.$location->name.'<i class="fa fa-times lp-removethisloc"></i><input type="hidden" name="location[]" value="'.$location->name.'"></div>';
													}
												}
											}
											
											$argsChild = array(
													'order' => 'ASC',
													'hide_empty' => false,
													'hierarchical' => false,
													'parent' => $location->term_id,
												);
												$childLocs = get_terms('location', $argsChild);
												if(!empty($childLocs)){
													foreach($childLocs as $childLoc) {
														
														if(!empty($current_loc)){
															foreach($current_loc as $cloc){
																if($childLoc->term_id == $cloc){
																	$output .=	'<div class="lpsinglelocselected '.$childLoc->name.'">'.$childLoc->name.'<i class="fa fa-times lp-removethisloc"></i><input type="hidden" name="location[]" value="'.$childLoc->name.'"></div>';
																}
															}
														}
																					
														
														
														$argsChildof = array(
															'order' => 'ASC',
															'hide_empty' => false,
															'hierarchical' => false,
															'parent' => $childLoc->term_id,
														);
														$childLocsof = get_terms('location', $argsChildof);
														if(!empty($childLocsof)){
															foreach($childLocsof as $childLocof) {
																
																if(!empty($current_loc)){
																	foreach($current_loc as $cloc){
																		if($childLocof->term_id == $cloc){
																			$output .=	'<div class="lpsinglelocselected '.$childLocof->name.'">'.$childLocof->name.'<i class="fa fa-times lp-removethisloc"></i><input type="hidden" name="location[]" value="'.$childLocof->name.'"></div>';
																		}
																	}
																}
																						
																
																
															}
															
														}
														
														
													}
												}
											
											
											
										}
										
										$output .='</div>';
										$output .='
													<div class="form-group col-md-6 col-xs-12 lp-new-cat-wrape">
													<input id="citiess" name="locationn" class="form-control postsubmitSelect" autocomplete="off" data-country="'.$locArea.'" placeholder="'.esc_html__('select your listing region', 'listingpro-plugin').'"></div>	
											';
										/* end for google multiloation */
										
									}
								}
								elseif( !empty($locations_type)&& $locations_type=="manual_loc" ){
									
									$output .='
									<div class="form-group col-md-6 col-xs-12 lp-new-cat-wrape">
										<label for="inputTags">'.$listingCityText.'</label>
										<div class="help-text">
											<a href="#" class="help"><i class="fa fa-question"></i></a>
											<div class="help-tooltip">
												<p>'.esc_html__('The city name will help users find you in search filters.', 'listingpro-plugin').'</p>
											</div>
										</div>';
											
											if($singleLocMode==true){
												$output .='<select autocomplete="off" data-placeholder="'.esc_html__('Select your listing region', 'listingpro-plugin').'" id="inputCity" name="location[]" class="select2 postsubmitSelect" tabindex="5">';
											}else{
												$output .='<select autocomplete="off" data-placeholder="'.esc_html__('Select your listing region', 'listingpro-plugin').'" id="inputCity" name="location[]" class="select2 postsubmitSelect" tabindex="5"  multiple="multiple">';
											}
												$output .=	'<option value="">'.esc_html__('Select Location', 'listingpro-plugin').'</option>';
												$current_loc = array();
												$current_loc_array = get_the_terms($lp_post, 'location');
												if(!empty($current_loc_array)){
													foreach($current_loc_array as $current_locc) {
														$current_loc[] = $current_locc->term_id;
													}
												}
												$args = array(
													'post_type' => 'listing',
													'order' => 'ASC',
													'parent' => 0,
													'hide_empty' => false,
												);
												$locations = get_terms( 'location',$args);
												foreach($locations as $location) {
													$selected = '';
													if(!empty($current_loc)){
														foreach($current_loc as $cloc){
															if($location->term_id == $cloc){
																$selected = 'selected';
															}
														}
													}
													
													$output .=	'<option '.$selected.' value="'.$location->term_id.'">'.$location->name.'</option>';
													
													$argsChild = array(
															'order' => 'ASC',
															'hide_empty' => false,
															'hierarchical' => false,
															'parent' => $location->term_id,
														);
														$childLocs = get_terms('location', $argsChild);
														if(!empty($childLocs)){
															foreach($childLocs as $childLoc) {
																$selected = '';
																if(!empty($current_loc)){
																	foreach($current_loc as $cloc){
																		if($childLoc->term_id == $cloc){
																			$selected = 'selected';
																		}
																	}
																}
																							
																$output .=	'<option '. $selected.' value="'.$childLoc->term_id.'">-&nbsp;'.$childLoc->name.'</option>';
																
																$argsChildof = array(
																	'order' => 'ASC',
																	'hide_empty' => false,
																	'hierarchical' => false,
																	'parent' => $childLoc->term_id,
																);
																$childLocsof = get_terms('location', $argsChildof);
																if(!empty($childLocsof)){
																	foreach($childLocsof as $childLocof) {
																		
																		$selected = '';
																		if(!empty($current_loc)){
																			foreach($current_loc as $cloc){
																				if($childLocof->term_id == $cloc){
																					$selected = 'selected';
																				}
																			}
																		}
																									
																		$output .=	'<option '. $selected.' value="'.$childLocof->term_id.'">--&nbsp;'.$childLocof->name.'</option>';
																		
																	}
																	
																}
																
																
															}
														}
													
													
													
												}
												$output .='
											</select>';
									$output .='
									</div>';
									
								}
							}
							if($addressSwitch==1){
							$output .='
							<div class="form-group col-md-6 col-xs-12">
								<div class="lp-coordinates">
									<a data-type="gaddress" class="btn-link googleAddressbtn active">'.esc_html__('Search By Google', 'listingpro-plugin').'</a>
									<a data-type="gaddresscustom" class="btn-link googleAddressbtn">'.esc_html__('Manual Coordinates', 'listingpro-plugin').'</a>';
									if((is_ssl()) || (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1')))){
										$output .='
										<a data-type="gaddresscustom" class="btn-link googledroppin" data-toggle="modal" data-target="#modal-doppin"><i class="fa fa-map-pin"></i> '.esc_html__('Drop Pin', 'listingpro-plugin').'</a>';
									}
								$output .='
								</div>
								
								<label for="inputAddress" class="googlefulladdress">'.$listingGaddText.'</label>
								
								<div class="help-text googlefulladdress">
									<a href="#" class="help"><i class="fa fa-question"></i></a>
									<div class="help-tooltip">
										<p>'.esc_html__('Start typing and select your google location from google suggestions. This is for the map and also for locating your business.', 'listingpro-plugin').'</p>
									</div>
								</div>
								
								<input value="'.$gAddress.'" type="text" class="form-control" name="gAddress" id="inputAddress" placeholder="'.esc_html__('Your address for google map', 'listingpro-plugin').'">
								<div class="lp-custom-lat clearfix">
								<label for="inputAddress">'.$listingGaddcustomText.'</label>
									<input value="'.$gAddress.'" type="text" class="form-control" name="gAddresscustom" id="inputAddresss" placeholder="'.esc_html__('Add address here', 'listingpro-plugin').'">
									<div class="row hiddenlatlong">
										<div class="col-md-6 col-xs-6">
											<label for="latitude">'.esc_html__('Latitude', 'listingpro-plugin').'</label>
											<input class="form-control" value="'.$latitude.'" type="hidden" id="latitude" name="latitude">
										</div>
										<div class="col-md-6 col-xs-6">
											<label for="longitude">'.esc_html__('Longitude', 'listingpro-plugin').'</label>
											<input class="form-control" value="'.$longitude.'" type="hidden" id="longitude" name="longitude">
										</div>
									</div>
								</div>
								</div>
								</div>
								<div class="row">';
							}
						
							if($phoneSwitch == 1) {
								if($contact_show=="true"){
									$output .='
									<div class="form-group col-md-6 col-xs-12">
										<label for="inputPhone">'.esc_html__('Phone', 'listingpro-plugin').'</label>
										<input value="'.$phone.'" type="text" class="form-control" name="phone" id="inputPhone" placeholder="'.esc_html__('Your contact number', 'listingpro-plugin').'">
									</div>';
								}
							}
							if($webSwitch == 1 && $website_show=="true") {
								$output .='
								<div class="form-group col-md-6 col-xs-12">
									<label for="inputWebsite">'.esc_html__('Website', 'listingpro-plugin').'</label>
									<input value="'.$website.'" type="text" class="form-control" name="website" id="inputWebsite" placeholder="'.esc_html__('Your web URL', 'listingpro-plugin').'">
								</div>';
							}
							$output .='
						</div>
					</div>
					<div class="white-section border-bottom">
						<div class="row">
							<div class="form-group col-md-6 col-xs-12">';
								if($ophSwitch == 1 && $hours_show=="true") {
									$output .='
									<div class="form-group clearfix margin-bottom-0">';
										$output	.= LP_operational_hours_form($lp_post,true);
										$output	.='
									</div>';
								}
								$output .='
								<div class="form-group clearfix margin-bottom-0 lp-new-cat-wrape">
									<label for="inputCategory">'.$listing_cat_text.' <small>*</small></label>';
									if($singleCatMode==true){
										
										$output .='
										<select autocomplete="off" data-placeholder="'.esc_html__('Choose one categories', 'listingpro-plugin').'" id="inputCategory" name="category[]" class="select2 postsubmitSelect" tabindex="5">';
										
									}else{
										$output .='
										<select autocomplete="off" data-placeholder="'.esc_html__('Choose one categories', 'listingpro-plugin').'" id="inputCategory" name="category[]" class="select2 postsubmitSelect" tabindex="5" multiple="multiple">';
									}
										$output .='<option value="">'.esc_html__('Select Category', 'listingpro-plugin').'</option>';
										$args = array(
											'post_type' => 'listing',
											'order' => 'ASC',
											'hide_empty' => false,
											'parent' => 0,
										);
										$categories = get_terms( 'listing-category',$args);
										if(!empty($categories)){
											foreach($categories as $category) {
												$doAjax = false;
												$doAjax = lp_category_has_features($category->term_id);
												$selected = '';
												foreach($current_cat as $cid){
													if($category->term_id == $cid){
														$selected = 'selected';
													}
												}
												
												$output .=	'<option data-doajax="'.$doAjax.'" '.$selected.' value="'.$category->term_id.'">'.$category->name.'</option>';
												
												$argscatChild = array(
													'order' => 'ASC',
													'hide_empty' => false,
													'hierarchical' => false,
													'parent' => $category->term_id,

												);
												
												$childCats = get_terms('listing-category', $argscatChild);
												if(!empty($childCats)){
													
													foreach ( $childCats as $subID ) {								
														$doAjax = false;
														$doAjax = lp_category_has_features($subID->term_id);
														$selected = '';
														foreach($current_cat as $cid){
															if($subID->term_id == $cid){
																$selected = 'selected';
															}
														}
														$output .= '<option '.$selected.' data-doajax="'.$doAjax.'"  class="sub_cat" value="'.$subID->term_id.'">-&nbsp;&nbsp;'.$subID->name.'</option>';
														
														$childCatsof = array(
															'order' => 'ASC',
															'hide_empty' => false,
															'hierarchical' => false,
															'parent' => $subID->term_id,
														);
														$childofCats = get_terms('listing-category', $childCatsof);
														if(!empty($childofCats)){
															foreach ( $childofCats as $subIDD ) {								
																$doAjax = false;
																$doAjax = lp_category_has_features($subIDD->term_id);
																$selected = '';
																foreach($current_cat as $cid){
																	if($subIDD->term_id == $cid){
																		$selected = 'selected';
																	}
																}
																$output .= '<option '.$selected.' data-doajax="'.$doAjax.'"  class="sub_cat" value="'.$subIDD->term_id.'">--&nbsp;&nbsp;'.$subIDD->name.'</option>';
															}
																
																
														}
													
													
													}
												}
											}
										}
										$output .='
									</select>
								</div>';
								$output .='
							</div>
							<div class="form-group col-md-6 col-xs-12">';
								if($submit_ad_img1_switch == 1) {
									$output .='
									<div class="submit-img">
										<img src="'. $submitImg1 .'" alt="">
									</div>';
								}
								$output .='
							</div>';
						$output .= listingpro_get_term_openfields(false);	
						$output .='
						</div>';
						$output .='
							<div class="form-group clearfix lpfeatures_fields">';
							$features;
							$featuresArr;
							$nofeatures = true;
							$fcount = 1;
							if(!empty($current_cat_array)){
								$totalTms = count($current_cat);
								
											$output .='
											<label for="inputTags" class="featuresBycat">'.$listing_features_text.'</label><br>
											<div class="pre-load"></div>
											<div class="featuresDataContainer row clearfix lp-nested" id="tags-by-cat">';
											
								}
								foreach($current_cat as $cid){
									$features= listingpro_get_term_meta($cid,'lp_category_tags');
									if(!empty($features)){
									$nofeatures = false;
											
										$cheched = '';
										foreach($features as $feature){
											$terms = get_term_by('id', $feature, 'features');
											if(!empty($terms)){
												if(!empty($metaFields['lp_feature'])){
													if (in_array($feature, $metaFields['lp_feature'])) {
														$cheched =  "checked";
													}else{
														$cheched = '';
													}  
												}
												
												$output .='<div class="col-md-2 col-sm-4 col-xs-6"><div class="checkbox pad-bottom-10"><input '.$cheched.'  id="check_'.$terms->term_id.'" type="checkbox" name="lp_form_fields_inn[lp_feature][]" value="'.$terms->term_id.'" ><label for="check_'.$terms->term_id.'">'.$terms->name.'</label></div></div>
												';
											}
										}
											
									
								}
							}
							
							$output .='
							</div>';
											
							if($nofeatures==true){
								$output .='
								<div class="form-group clearfix">
									<div class="pre-load"></div>
									<div class="featuresDataContainer lp-nested row" id="tags-by-cat"></div>	
									<div class="featuresDataContainer lp-nested row" id="features-by-cat"></div>
								</div>';
							}
							
							if(!empty($formFields)){
								$output .='
								<div class="featuresDataContainer row clearfix lp-nested" id="features-by-cat">';
									$output .= '<label for="inputTags" class="featuresBycat">'.esc_html__('Additional Business Info', 'listingpro-plugin').'</label>';
									$output .= $formFields;
									$output	.='
								</div>';
							}
							$output .='
							</div>';
							
						$output .='
						<div class="form-group clearfix">
							<div class="row">';
								if($currencySwitch == 1) {
									$lp_priceSymbol = $listingpro_options['listing_pricerange_symbol'];
									$lp_priceSymbol2 = $lp_priceSymbol.$lp_priceSymbol;
									$lp_priceSymbol3 = $lp_priceSymbol2.$lp_priceSymbol;
									$lp_priceSymbol4 = $lp_priceSymbol3.$lp_priceSymbol;
									$priceyArray = array(
												'notsay' => esc_html__('Not to say', 'listingpro-plugin'),
												'inexpensive' => esc_html__('Inexpensive', 'listingpro-plugin'),
												'moderate' => esc_html__('Moderate', 'listingpro-plugin'),
												'pricey' => esc_html__('Pricey', 'listingpro-plugin'),
												'ultra_high_end'  => esc_html__('Ultra High', 'listingpro-plugin'),
											);
											
									
									$output .='
									<div class="col-md-4 clearfix">
										<label for="listingptext">'.$listingCurrText.'</label>
										<select id="price_status" name="price_status" class="chosen-select chosen-select7  postsubmitSelect" tabindex="5">
											';
											foreach($priceyArray as $key => $value){
												if($price_status == $key){
													$selected = 'selected';
												}else{
													$selected = '';
												}
												if($key == 'notsay'){
													$output .='<option '.$selected.' value="'.$key.'">' .$value.'</option>';
												}elseif($key == 'inexpensive'){
													$output .='<option '.$selected.' value="'.$key.'">' .$lp_priceSymbol.' - '.$value.'</option>';
												}elseif($key == 'moderate'){
													$output .='<option '.$selected.' value="'.$key.'">' .$lp_priceSymbol2.' - '.$value.'</option>';
												}elseif($key == 'pricey'){
													$output .='<option '.$selected.' value="'.$key.'">' .$lp_priceSymbol3.' - '.$value.'</option>';
												}elseif($key == 'ultra_high_end'){
													$output .='<option '.$selected.' value="'.$key.'">' .$lp_priceSymbol4.' - '.$value.'</option>';
												}
											}
										$output .='
										</select>
									</div>';
								}
								if($price_show == "true"){
									if($digitPriceSwitch == 1) {
										$output .='
										<div class="col-md-4">
											<label for="listingprice">'.$listingDigitText.'</label>
											<input value="'.$listingprice.'" type="text" name="listingprice" class="form-control" id="listingprice" placeholder="'.esc_html__('Only Digits', 'listingpro-plugin').'">
										</div>';
									}
									if($priceSwitch == 1) {
										$output .='
										<div class="col-md-4">
											<label for="listingptext">'.$listingPriceText.'</label>
											<input value="'.$listingptext.'" type="text" name="listingptext" class="form-control" id="listingptext" placeholder="'.esc_html__('Price To', 'listingpro-plugin').'">
										</div>';
									}
								}
								$output .='
							</div>
						</div>
					</div>
					<div class="white-section border-bottom">
						<div class="row">
							<div class="form-group col-md-6 col-xs-12">';
								$output .='
								<div class="form-group clearfix">
									<label for="inputDescription">'.$listing_desc_text.' <small>*</small></label>'. get_textarea_as_editor('inputDescription', 'postContent', $pcontent) .'
								</div>';
								if($faq_switch == 1 && $faqs_show=="true") {
									$output .='
									<div class="form-group clearfix margin-bottom-0">
										<div id="tabs" class="clearfix" data-faqtitle="'.$listing_faq_text.'">
										
										';
										
										$FaqHasData = false;
										
										if(!empty($faq) && !empty($faqans)){
											foreach($faq as $faqData){
												if($faqData==""){}else{
													$FaqHasData = true;
												}
											}
										}
						
										
											if($FaqHasData==true){
												
											 	$n=count($faq);
											 	if($n>1){
													$j=1;
													
													while($j <= $n){
														$faqQ =$faq[$j];
														if(!empty($faqQ)){
															$output .='
															<div id="tabs-'.$j.'">
																<div class="form-group">
																	<label for="inpuFaqsLp">'.$listing_faq_text.'</label>
																	<input type="text" class="form-control" placeholder="'.esc_html__('Questions', 'listingpro-plugin').'" name="faq['.$j.']" id="inpuFaqsLp" value="'.$faq[$j].'">
																</div>
																<div class="form-group">
																	<textarea class="form-control" placeholder="'.esc_html__('Answer', 'listingpro-plugin').'" name="faqans['.$j.']" rows="8" id="inputDescription">'.$faqans[$j].'</textarea>
																</div>
															</div>';																
														}
														$j++;
													}
												}else {
													$output .='
													<div id="tabs-1">
														<div class="form-group">
															<label for="inpuFaqsLp">'.$listing_faq_text.'</label>
															<input type="text" class="form-control" data-faqmaintitle="'.$listing_faq_text.'"  name="faq[1]" id="inpuFaqsLp" placeholder="'.esc_html__('FAQ 1', 'listingpro-plugin').'" value="'.$faq[1].'">
														</div>
														<div class="form-group">
															<textarea class="form-control" name="faqans[1]" rows="8" id="inputDescriptionFaq">'.$faqans[1].'</textarea>
														</div>
												  	</div>';	
												}
												$output.='
												<div class="btn-container faq-btns clearfix">	
												  	<ul>';
														if( is_array($faq) && count($faq)>1 ){
															$word = preg_replace('/\d/', '', $listing_faq_tabs_text );
															$i=1;
															foreach ($faq as $q){
																if(!empty($q)){
																$output .='<li><a  data-faq-text="'.$listing_faq_tabs_text.'" href="#tabs-'.$i.'">'.$word.' '.$i.'</a></li>';
																$i++;
																}
															}
														}
														else{
															$output .='<li><a href="#tabs-1"  data-faq-text="'.$listing_faq_tabs_text.'">'.$listing_faq_tabs_text.'</a></li>';	
														}
														$output .='
													</ul>
												  	
											 	</div>';
											}else{
												
												$output.='
												<div class="btn-container faq-btns clearfix">	
													<ul>
														<li><a href="#tabs-1" data-faq-text="'.$listing_faq_tabs_text.'">'.$listing_faq_tabs_text.'</a></li>
													</ul>
												  	<a id="tabsbtn" class="lp-secondary-btn btn-first-hover">+</a>
												</div>
												';
												
												$output .='
								
												
													<div id="tabs-1">
														<div class="form-group">
															<label for="inpuFaqsLp">'.$listing_faq_text.'</label>
															<input type="text" class="form-control" data-faqmaintitle="'.$listing_faq_text.'"  name="faq[1]" id="inpuFaqsLp" placeholder="'.esc_html__('FAQ 1', 'listingpro-plugin').'" value="'.$faq[1].'">
														</div>
														<div class="form-group">
															<textarea class="form-control" name="faqans[1]" rows="8" id="inputDescriptionFaq">'.$faqans[1].'</textarea>
														</div>
											 	</div>';
											}
											$output .='
									  	</div>
									</div>';
								}
								$output .='
							</div>
							<div class="form-group col-md-6 col-xs-12">';
								if($submit_ad_img2_switch == 1) {
									$output .='
									<div class="submit-img">
										<img src="'. $submitImg2 .'" alt="">
									</div>';
								}
								$output .='
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-6 col-xs-12 lp-social-area">';
							if($social_show=="true"){
								if($twSwitch == 1) {
									$output .='
									<div class="form-group col-md-6 col-xs-12">
										<label for="inputTwitter">'.esc_html__('Twitter', 'listingpro-plugin').'</label>
										<input value="'.$twitter.'" type="text" class="form-control" name="twitter" id="inputTwitter" placeholder="'.esc_html__('Your Twitter URL', 'listingpro-plugin').'">
									</div>';
								}
								if($fbSwitch == 1) {
									$output .='
									<div class="form-group col-md-6 col-xs-12">
										<label for="inputFacebook">'.esc_html__('Facebook', 'listingpro-plugin').'</label>
										<input value="'.$facebook.'" type="text" class="form-control" name="facebook" id="inputFacebook" placeholder="'.esc_html__('Your Facebook URL', 'listingpro-plugin').'">
									</div>';
								}
								if($lnkSwitch == 1) {
									$output .='
									<div class="form-group col-md-6 col-xs-12">
										<label for="inputLinkedIn">'.esc_html__('LinkedIn', 'listingpro-plugin').'</label>
										<input value="'.$linkedin.'" type="text" class="form-control" name="linkedin" id="inputLinkedIn" placeholder="'.esc_html__('Your LinkedIn URL', 'listingpro-plugin').'">
									</div>';
								}
								if($googleSwitch == 1) {
									$output .='
									<div class="form-group col-md-6 col-xs-12">
										<label for="inputGooglePlus">'.esc_html__('Google Plus', 'listingpro-plugin').'</label>
										<input value="'.$gPlus.'" type="text" class="form-control" name="google_plus" id="inputGooglePlus" placeholder="'.esc_html__('Your Google Plus URL', 'listingpro-plugin').'">
									</div>';
								}
								if($ytSwitch == 1) {
									$output .='
									<div class="form-group col-md-6 col-xs-12">
										<label for="inputYoutube">'.esc_html__('Youtube', 'listingpro-plugin').'</label>
										<input value="'.$youtube.'" type="text" class="form-control" name="youtube" id="inputYoutube" placeholder="'.esc_html__('Your Youtube URL', 'listingpro-plugin').'">
									</div>';
								}
								if($instaSwitch == 1) {
									$output .='
									<div class="form-group col-md-6 col-xs-12">
										<label for="inputInstagram">'.esc_html__('Instagram', 'listingpro-plugin').'</label>
										<input value="'.$instagram.'" type="text" class="form-control" name="instagram" id="inputInstagram" placeholder="'.esc_html__('Your Instagram URL', 'listingpro-plugin').'">
									</div>';
								}
							}
								$output .='
							</div>';
							if($tags_switch == 1 && $tags_show=="true" ) {
								$output .='
								<div class="form-group col-md-6 col-xs-12 lp-social-area">
									<div class="form-group col-md-12 col-xs-12">
										<label for="inputTags">'.$listingTagsText.'</label>
										<div class="help-text">
											<a href="#" class="help"><i class="fa fa-question"></i></a>
											<div class="help-tooltip">
												<p>'.esc_html__('These keywords or tags will help your listing to find in search. Add a comma separated list of keywords related to your business.', 'listingpro-plugin').'</p>
											</div>
										</div>
										<textarea class="form-control" name="tags" id="inputTags" placeholder="'.esc_html__('Enter tags or keywords comma separated...', 'listingpro-plugin').'">';
										$tags = get_the_terms($lp_post, 'list-tags');
										if ( $tags and ! is_wp_error($tags) ){
											$names = wp_list_pluck($tags ,'name');
											$output .= implode(',', $names);
										}
										$output .=	'
										</textarea>
									</div>
								</div>';
							}
							$output .='
						</div>
					</div>';
					$featuredimageshow = true;
					if($video_show=="true" || $gallery_show=="true" || $featuredimageshow==true){
					$output .='
					<div class="white-section border-bottom">
						<div class="row">
							<div class="form-group col-md-6 col-xs-12">';
								if($vdoSwitch == 1) {
									if($video_show=="true"){
										$output .='
										<div class="form-group clearfix">
											<label for="postVideo">'.esc_html__('Video ', 'listingpro-plugin').'<span>'.esc_html__('(Optional)', 'listingpro-plugin').'</span></label>
											<input type="text" value="'.$video.'" class="form-control" name="postVideo" id="postVideo" placeholder="'.esc_html__('ex: https://youtu.be/lY2yjAdbvdQ', 'listingpro-plugin').'">
										</div>';
									}
								}
								if($fileSwitch == 1) {
									if($gallery_show=="true"){
										$output .='
										<div class="form-group clearfix margin-bottom-0 lp-img-gall-upload-section">
											<div class="col-sm-12 padding-left-0 padding-right-0">
												<label for="postVideo">'.esc_html__('Images ', 'listingpro-plugin').'</label>	
												<div class="jFiler-input-dragDrop pos-relative">
													<div class="jFiler-input-inner">
														<div class="jFiler-input-icon">
															<i class="icon-jfi-cloud-up-o"></i>
														</div>
															<div class="jFiler-input-text">
															<h3>'.esc_html__('Drag&Drop files here', 'listingpro-plugin').'</h3>
															<span style="display:inline-block; margin: 15px 0">'.esc_html__('Or', 'listingpro-plugin').'</span>
														</div>
														<a class="jFiler-input-choose-btn blue">'.esc_html__('Browse Files', 'listingpro-plugin').'</a>
														<div id="filediv">
															<input type="file" name="listingfiles[]" id="file" multiple>
														</div>';
														$galleryImagesIDS = explode( ',', $galleryImagesIDS );
														if(!empty($galleryImagesIDS)){
															$output.= '<div id="filedivd">';		
															foreach($galleryImagesIDS as $galID){
																$imgFull = wp_get_attachment_image_src( $galID, 'thumbnail');
																if(!empty($imgFull[0])){
																	$output.= '									
																		<ul class="jFiler-items-list jFiler-items-grid grid1">
																			<li class="jFiler-item">	
																				<div class="jFiler-item-container">
																					<div class="jFiler-item-inner">		
																						<div class="jFiler-item-thumb">
																							<img src="'. $imgFull[0] .'" alt="post1" />
																						</div>		
																					</div>		
																				</div>
																				<a class="icon-jfi-trash jFiler-item-trash-action"><i class="fa fa-trash"></i></a>	
																				<input name="" id="file" multiple="multiple" value="'.$galID.'" type="hidden">
																			</li>
																		</ul>';
																}
															}
															
															$output .= '</div>';
														}															
														$output .=	'
													</div>
												</div>
											</div>
										</div>';
									}
								}
								$output .='
								
									<div class="form-group clearfix margin-bottom-0 margin-top-10 lp-listing-featuredimage">
									<label class="margin-top-10">'.esc_html__('Upload Feature Image', 'listingpro-plugin').'</label>
									
									<div class="custom-file">
										<input style="display:none;" type="file" name="lp-featuredimage[]" id="lp-featuredimage" class="inputfile inputfile-3" data-multiple-caption="{count} files selected" multiple />
										<label for="lp-featuredimage"><p>'.esc_html__('Browse', 'listingpro-plugin').'</p><span>'.esc_html__('Choose a file', 'listingpro-plugin').'&hellip;</span></label>
									</div>
								</div>
								
								';
								$output .='
							</div>
							<div class="form-group col-md-6 col-xs-12">';
								if($submit_ad_img3_switch == 1) {
									$output .='
									<div class="submit-img">
										<img src="'. $submitImg3 .'" alt="">
									</div>';
								}
								$output .='
							</div>
						</div>
					</div>';
					}
					
					$output .='
					<div class="blue-section">
						<div class="row">
							<div class="form-group col-md-6 margin-bottom-0">';
								if(!is_user_logged_in()){
									$output .='
									<label for="inputEmail">'.$listingEmailText.'</label>
									<input type="email" class="form-control" name="email" id="inputEmail" placeholder="'.esc_html__('your contact email', 'listingpro-plugin').'">';
								}
								else{
									$output .='<div id="inputEmail"></div>';
								}
							$output .='
							</div>
							<div class="form-group col-md-6 margin-bottom-0">
							  	<div class="checkbox form-group col-md-4">
							  	</div>
								<div class="form-group clearfix margin-bottom-0 preview-section pos-relative col-md-8 pull-right">';
									
									if($enableCaptcha==true){
										if ( class_exists( 'cridio_Recaptcha' ) ){ 
											if ( cridio_Recaptcha_Logic::is_recaptcha_enabled() ) { 
											$output .='<div style="transform:scale(0.77);-webkit-transform:scale(0.77);transform-origin:0 0;-webkit-transform-origin:0 0;" id="recaptcha-securet" class="g-recaptcha form-group clearfix" data-sitekey="'.$gSiteKey.'"></div>';
											}
										}
									}
								
									$output .='<label for="previewListing">'.esc_html__('Click below to review your listing.', 'listingpro-plugin').'</label>
									<div class="error_box"></div>
									<input type="hidden" name="lp_post" value="'.$lp_post.'" /> 
									<input type="hidden" name="plan_id" value="'.$plan_id.'" /> 
									<input type="hidden" name="claimed_section" value="'.listing_get_metabox_by_ID("claimed_section", $lp_post).'" /> 
									<input type="submit" name="listingedit" value="'.$btnText.'" class="lp-secondary-btn btn-first-hover" /> 
									<i class="fa fa-angle-right"></i>
									<input type="hidden" name="errorrmsg" value="'.esc_html__('Something is missing! Please fill out all fields highlighted in red.', 'listingpro-plugin').'" />
								</div>';
								$output .= wp_nonce_field( 'edit_nonce', 'edit_nonce_field' ,true, false );
								$output .='
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>';
    ob_end_clean();
	ob_flush();
	return $output;
}
add_shortcode('listingpro_edit', 'listingpro_shortcode_edit');