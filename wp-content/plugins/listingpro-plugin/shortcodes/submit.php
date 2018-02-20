<?php 
	ob_start();

/*------------------------------------------------------*/
/* Submit Listing
/*------------------------------------------------------*/
vc_map( array(
	"name"                      => __("Submit Listing", "js_composer"),
	"base"                      => 'listingpro_submit',
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
function listingpro_shortcode_submit($atts, $content = null) {

	extract(shortcode_atts(array(
		'title'   => '',
		'subtitle'   => ''
	), $atts));
	
	do_action('lp_call_maps_scripts');
	/* PRIVACY URL */
	global $listingpro_options;
	$listing_access_only_users = $listingpro_options['lp_allow_vistor_submit'];
	$showAddListing = true;
	if( isset($listing_access_only_users)&& $listing_access_only_users==1 ){
		$showAddListing = false;
		if(is_user_logged_in()){
			$showAddListing = true;
		}
	}
	if( $showAddListing==false ){
		wp_redirect(home_url());
		exit;
	}
	
	$gSiteKey = '';
	$gSiteKey = $listingpro_options['lp_recaptcha_site_key'];
	$enableCaptcha = lp_check_receptcha('lp_recaptcha_listing_submission');
	
	$lp_paid_mode = $listingpro_options['enable_paid_submission'];
	$privacy_policy = $listingpro_options['payment_terms_condition'];

	$paidmode = '';
	$paidmode = $listingpro_options['enable_paid_submission'];
	
	/* EDIT LIST */
	$lp_post ='';
	$form_field ='';
	$faq ='';
	$faqans ='';
	$gAddress ='';
	$latitude ='';
	$longitude ='';
	$timings ='';
	$phone ='';
	$email ='';
	$website ='';
	$twitter ='';
	$facebook ='';
	$linkedin ='';
	$listingcurrency ='';
	$listingprice ='';
	$listingptext ='';
	$video ='';	
	
	/* MODE CHECK */
	if( $lp_paid_mode == "yes" ){
		
		if( !isset($_POST['plan_id'])){
			$selectePlanID = $_POST['plan_id'];
			if( !isset( $_POST['price_nonce_field'.$selectePlanID] ) ){
					$lp_plans_url = $listingpro_options['pricing-plan'];
					if(!empty($lp_plans_url)){
						wp_redirect($lp_plans_url);
						exit;
					}
					else{
						wp_redirect(site_url());
						exit;
					}
					
			}
		}
	}
	
	
	/* PLAN ID */
	$plan_id = '';
	if(isset($_POST['plan_id'])){
		$plan_id = $_POST['plan_id'];
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
	
	/* SUBMIT FORM OUTPUT */
	$output = null;
	
	$output .= '
	<div class="page-container-four clearfix submit_new_style submit_new_style-outer">
		<div class="col-md-12 col-sm-12">
			<div class="form-page-heading">
				<h3>'.$title.'</h3>
				<p>'.$subtitle.'</p>
			</div>
			<div class="post-submit">';
				if(is_user_logged_in()) {
					$output .= '
					<div class="author-section border-bottom lp-form-row clearfix lp-border-bottom padding-bottom-40">
						<div class="lp-form-row-left text-left pull-left not-logged-in-msg">
							<img class="avatar-circle" src="'.listingpro_author_image().'" />
							<p>'.esc_html__('You are currently signed in as', 'listingpro-plugin').' <strong>'.listingpro_author_name().',</strong> <a href="'.wp_logout_url(esc_url(home_url('/'))).'" class="">'.esc_html__('Sign out', 'listingpro-plugin').'</a> ' .esc_html__('or continue below and start submission.', 'listingpro-plugin').'</p>
						</div>
					</div>';
				}else{
					$output .=
					'<div class="author-section border-bottom lp-form-row clearfix lp-border-bottom padding-bottom-40">
						<div class="lp-form-row-left text-left pull-left not-logged-in-msg">
							<!-- <img class="avatar-circle" src="'.plugins_url( '/images/author.jpg', dirname(__FILE__) ).'" /> -->
							<p><strong>'.esc_html__('Returning User? Please', 'listingpro-plugin'). '</strong> <a class=" md-trigger" data-modal="modal-3">'.esc_html__('Sign In', 'listingpro-plugin').'</a> '.esc_html__('and if you are a ', 'listingpro-plugin').' <strong>' .esc_html__('New User, continue below ', 'listingpro-plugin').'</strong>' .esc_html__('and register along with this submission.', 'listingpro-plugin').'</p>
						</div>						
					</div>';
				}

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

				$listing_btn_text = $listingpro_options['listing_btn_text'];
				$showLocation = $listingpro_options['location_switch'];
				
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
				

				$btnText = '';
				if(!empty($listing_btn_text)) {
					$btnText = $listing_btn_text;
				}else {
					$btnText = esc_html__('Save & Preview', 'listingpro-plugin');
				}
				
				$locations_type = $listingpro_options['lp_listing_locations_options'];
				$locArea = '';
				if(!empty($locations_type) && $locations_type=="auto_loc"){
					$locArea = $listingpro_options['lp_listing_locations_range'];
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
								<label for="usr">'.$listing_title_text.' <small>*</small></label>
								<div class="help-text">
									<a href="#" class="help"><i class="fa fa-question"></i></a>
									<div class="help-tooltip">
										<p>'.esc_html__('Put your listing title here and tell the name of your business to the world.', 'listingpro-plugin').'</p>
									</div>
								</div>
									<input type="text" name="postTitle" class="form-control margin-bottom-10" id="lptitle" placeholder="' .esc_html__('Staple & Fancy Hotel', 'listingpro-plugin').'">';
								if($tagline_show == "true"){
									$output .='
									<input type="text" name="tagline_text" class="form-control margin-bottom-10" id="lptagline" placeholder="' .esc_html__('Tagline Example: Best Express Mexican Grill', 'listingpro-plugin').'">';
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
							if($showLocation=="1" && $location_show=="true"){
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
											
												
												$output .='
														<input id="citiess" name="locationn" data-isseleted="false" class="form-control ostsubmitSelect" autocomplete="off" data-country="'.$locArea.'" placeholder="'.esc_html__('select your listing region', 'listingpro-plugin').'">
														<input type="hidden" name="location">
												';
											
										$output .='	
										</div>';
										
									}else{
										$output .='
										<div class="form-group lp-selected-locs clearfix col-md-12"></div>';
									
								
										$output .='
										<div class="form-group col-md-6 col-xs-12 lp-new-cat-wrape">
											<label for="inputTags">'.$listingCityText.'</label>
											<div class="help-text">
												<a href="#" class="help"><i class="fa fa-question"></i></a>
												<div class="help-tooltip">
													<p>'.esc_html__('The city name will help users find you in search filters.', 'listingpro-plugin').'</p>
												</div>
											</div>';
											
												
												$output .='
														<input id="citiess" name="locationn" data-isseleted="false" class="form-control ostsubmitSelect" autocomplete="off" data-country="'.$locArea.'" placeholder="'.esc_html__('select your listing region', 'listingpro-plugin').'">
												';
											
										$output .='	
										</div>';
									}
								}
								elseif( !empty($locations_type)&& $locations_type=="manual_loc" ){
									
									$output .='
									<div class="form-group col-md-6 col-xs-12 lp-new-cat-wrape lp-new-cat-wrape">
										<label for="inputTags">'.$listingCityText.'</label>
										<div class="help-text">
											<a href="#" class="help"><i class="fa fa-question"></i></a>
											<div class="help-tooltip">
												<p>'.esc_html__('The city name will help users find you in search filters.', 'listingpro-plugin').'</p>
											</div>
										</div>';
										
										
											if($singleLocMode==true){
												$output .='<select data-placeholder="'.esc_html__('select your listing region', 'listingpro-plugin').'" id="inputCity" name="location[]" class="select2 postsubmitSelect" tabindex="5">';
											}
											else{
												$output .='<select data-placeholder="'.esc_html__('select your listing region', 'listingpro-plugin').'" id="inputCity" name="location[]" class="select2 postsubmitSelect" tabindex="5" multiple="multiple">';
											}
											
											
												$output .=	'<option value="">' .esc_html__('Select City', 'listingpro-plugin').'</option>';
												$args = array(
													'post_type' => 'listing',
													'order' => 'ASC',
													'hide_empty' => false,
													'parent' => 0,
												);
												$locations = get_terms( 'location',$args);
												if(!empty($locations)){
													foreach($locations as $location) {										
														$output .=	'<option value="'.$location->term_id.'">'.$location->name.'</option>';
														$argsChild = array(
															'order' => 'ASC',
															'hide_empty' => false,
															'hierarchical' => false,
															'parent' => $location->term_id,
															

														);
														$childLocs = get_terms('location', $argsChild);
														if(!empty($childLocs)){
															foreach($childLocs as $childLoc) {										
																$output .=	'<option value="'.$childLoc->term_id.'">-&nbsp;'.$childLoc->name.'</option>';
																
																$argsChildof = array(
																	'order' => 'ASC',
																	'hide_empty' => false,
																	'hierarchical' => false,
																	'parent' => $childLoc->term_id,
																);
																$childLocsof = get_terms('location', $argsChildof);
																if(!empty($childLocsof)){
																	foreach($childLocsof as $childLocof) {										
																		$output .=	'<option value="'.$childLocof->term_id.'">--&nbsp;'.$childLocof->name.'</option>';
																	}
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
									
									<input type="text" class="form-control" name="gAddress" id="inputAddress" placeholder="'.esc_html__('Start typing and find your place in google map', 'listingpro-plugin').'">
									<div class="lp-custom-lat clearfix">
										<label for="inputAddress">'.$listingGaddcustomText.'</label>
										<input type="text" class="form-control" name="gAddresscustom" id="inputAddresss" placeholder="'.esc_html__('Add address here', 'listingpro-plugin').'">
										<div class="row hiddenlatlong">
											<div class="col-md-6 col-xs-6">
											<label for="latitude">'.esc_html__('Latitude', 'listingpro-plugin').'</label>
											<input class="form-control" type="hidden" placeholder="'.esc_html__('40.7143528', 'listingpro-plugin').'" id="latitude" name="latitude">
											</div>
											<div class="col-md-6 col-xs-6">
											<label for="longitude">'.esc_html__('Longitude', 'listingpro-plugin').'</label>
											<input class="form-control" type="hidden" placeholder="'.esc_html__('-74.0059731', 'listingpro-plugin').'" id="longitude" name="longitude">
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
										<label for="inputPhone">'.$listingPhText.'</label>
										<input type="text" class="form-control" name="phone" id="inputPhone" placeholder="'.esc_html__('111-111-1234', 'listingpro-plugin').'">
									</div>';
								}
							}
							if($webSwitch == 1 && $website_show == "true") {
								$output .='
								<div class="form-group col-md-6 col-xs-12">
									<label for="inputWebsite">'.$listingWebText.'</label>
									<input type="text" class="form-control" name="website" id="inputWebsite" placeholder="'.esc_html__('http://', 'listingpro-plugin').'">
								</div>';
							}
							$output .='
						</div>
					</div>
					<div class="white-section border-bottom">
						<div class="row">
							<div class="form-group col-md-6 col-xs-12">';
							
								if($ophSwitch == 1 && $hours_show == "true") {
									$output .='
									<div class="form-group clearfix margin-bottom-0">';
										$fakeID	= '';
										$output	.= LP_operational_hours_form($fakeID,false);
										$output	.='
									</div>';
								}
								$output .='
								<div class="form-group clearfix margin-bottom-0 lp-new-cat-wrape">
									<label for="inputCategory">'.$listing_cat_text.' <small>*</small></label>';
									
									if($singleCatMode==true){
										$output .='
										<select data-placeholder="' .esc_html__('Choose Your Business Category', 'listingpro-plugin').'" id="inputCategory" name="category[]" class="select2 postsubmitSelect" tabindex="5">';
									}else{
										$output .='
										<select data-placeholder="' .esc_html__('Choose Your Business Category', 'listingpro-plugin').'" id="inputCategory" name="category[]" class="select2 postsubmitSelect" tabindex="5" multiple="multiple">';
									}
										$output .=	'<option value="">' .esc_html__('Select Category', 'listingpro-plugin').'</option>';
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
												$output .=	'<option data-doajax="'.$doAjax.'" value="'.$category->term_id.'">'.$category->name.'</option>';
												
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
														$output .= '<option data-doajax="'.$doAjax.'"  class="sub_cat" value="'.$subID->term_id.'">-&nbsp;&nbsp;'.$subID->name.'</option>';
														
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
																$output .= '<option data-doajax="'.$doAjax.'"  class="sub_cat" value="'.$subIDD->term_id.'">--&nbsp;&nbsp;'.$subIDD->name.'</option>';
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
							</div>';
							
							$output .='
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
							<div class="form-group clearfix lpfeatures_fields">
								<div class="pre-load"></div>
								<div class="featuresDataContainer lp-nested row" id="tags-by-cat"></div>	
								<div class="featuresDataContainer lp-nested row" id="features-by-cat"></div>
							</div>';
						$output .='
						<div class="form-group clearfix">
							<div class="row">';
								if($currencySwitch == 1) {
									$lp_priceSymbol = $listingpro_options['listing_pricerange_symbol'];
									$lp_priceSymbol2 = $lp_priceSymbol.$lp_priceSymbol;
									$lp_priceSymbol3 = $lp_priceSymbol2.$lp_priceSymbol;
									$lp_priceSymbol4 = $lp_priceSymbol3.$lp_priceSymbol;
									$output .='
									<div class="col-md-4 clearfix">
										<label for="price_status">'.$listingCurrText.'</label>
										<select id="price_status" name="price_status" class="chosen-select chosen-select7  postsubmitSelect" tabindex="5">
											<option value="notsay">' .esc_html__('Not to say', 'listingpro-plugin').'</option>
											<option value="inexpensive"> '.$lp_priceSymbol.' - '.esc_html__('Inexpensive', 'listingpro-plugin').'</option>
											<option value="moderate"> '.$lp_priceSymbol2.' - '.esc_html__('Moderate', 'listingpro-plugin').'</option>
											<option value="pricey"> '.$lp_priceSymbol3.' - '.esc_html__('Pricey', 'listingpro-plugin').'</option>
											<option value="ultra_high_end"> '.$lp_priceSymbol4.' - '.esc_html__('Ultra High', 'listingpro-plugin').'</option>
										</select>
									</div>';
								}
								if($price_show == "true"){
									if($digitPriceSwitch == 1) {
										$output .='
										<div class="col-md-4">
											<label for="listingprice">'.$listingDigitText.'</label>
											<input type="text" name="listingprice" class="form-control" id="listingprice" placeholder="'.esc_html__('Price From', 'listingpro-plugin').'">
										</div>';
									}
									if($priceSwitch == 1) {
										$output .='
										<div class="col-md-4">
											<label for="listingptext">'.$listingPriceText.'</label>
											<input type="text" name="listingptext" class="form-control" id="listingptext" placeholder="'.esc_html__('Price To', 'listingpro-plugin').'">
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
								$placeholder_for_decs   =   esc_html__('Detail description about your listing', 'listingpro-plugin');
								$output .='
								<div class="form-group clearfix">
									<label for="inputDescription">'.$listing_desc_text.' <small>*</small></label>'. get_textarea_as_editor('inputDescription', 'postContent', $placeholder_for_decs) .'
								</div>';
								if($faq_switch == 1 && $faqs_show=="true") {
									$output .='
									<div class="form-group clearfix margin-bottom-0">
										<div id="tabs" class="clearfix pos-relative" data-faqtitle="'.$listing_faq_text.'">
											<div class="btn-container faq-btns clearfix">	
											  	<ul>
													<li><a href="#tabs-1" data-faq-text="'.$listing_faq_tabs_text.'">'.$listing_faq_tabs_text.'</a></li>
											  	</ul>
											  	<a id="tabsbtn" class="lp-secondary-btn btn-first-hover">+</a>
										 	</div>
										  	<div id="tabs-1">
												<div class="form-group">
													<label for="inpuFaqsLp">'.$listing_faq_text.'</label>
													<input type="text" class="form-control" data-faqmaintitle="'.$listing_faq_text.'" name="faq[1]" id="inpuFaqsLp" placeholder="'.esc_html__('FAQ', 'listingpro-plugin').'">
												</div>
												<div class="form-group">												
													<textarea class="form-control" placeholder="'.esc_html__('Answer', 'listingpro-plugin').'" name="faqans[1]" rows="8" id="inputDescriptionFaq"></textarea>
												</div>
									 	 	</div>										
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
							if($social_show == "true"){
								if($twSwitch == 1) {
									$output .='
									<div class="form-group col-md-6 col-xs-12">
										<label for="inputTwitter">'.esc_html__('Twitter', 'listingpro-plugin').'</label>
										<input type="text" class="form-control" name="twitter" id="inputTwitter" placeholder="'.esc_html__('Your Twitter URL', 'listingpro-plugin').'">
									</div>';
								}
								if($fbSwitch == 1) {
									$output .='
									<div class="form-group col-md-6 col-xs-12">
										<label for="inputFacebook">'.esc_html__('Facebook', 'listingpro-plugin').'</label>
										<input type="text" class="form-control" name="facebook" id="inputFacebook" placeholder="'.esc_html__('Your Facebook URL', 'listingpro-plugin').'">
									</div>';
								}
								if($lnkSwitch == 1) {
									$output .='
									<div class="form-group col-md-6 col-xs-12">
										<label for="inputLinkedIn">'.esc_html__('LinkedIn', 'listingpro-plugin').'</label>
										<input type="text" class="form-control" name="linkedin" id="inputLinkedIn" placeholder="'.esc_html__('Your LinkedIn URL', 'listingpro-plugin').'">
									</div>';
								}
								if($googleSwitch == 1) {
									$output .='
									<div class="form-group col-md-6 col-xs-12">
										<label for="inputGooglePlus">'.esc_html__('Google Plus', 'listingpro-plugin').'</label>
										<input type="text" class="form-control" name="google_plus" id="inputGooglePlus" placeholder="'.esc_html__('Your Google Plus URL', 'listingpro-plugin').'">
									</div>';
								}
								if($ytSwitch == 1) {
									$output .='
									<div class="form-group col-md-6 col-xs-12">
										<label for="inputYoutube">'.esc_html__('Youtube', 'listingpro-plugin').'</label>
										<input type="text" class="form-control" name="youtube" id="inputYoutube" placeholder="'.esc_html__('Your Youtube URL', 'listingpro-plugin').'">
									</div>';
								}
								if($instaSwitch == 1) {
									$output .='
									<div class="form-group col-md-6 col-xs-12">
										<label for="inputInstagram">'.esc_html__('Instagram', 'listingpro-plugin').'</label>
										<input type="text" class="form-control" name="instagram" id="inputInstagram" placeholder="'.esc_html__('Your Instagram URL', 'listingpro-plugin').'">
									</div>';
								}
							}
								$output .='
							</div>';
							if($tags_switch == 1 && $tags_show=="true") {
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
										<textarea class="form-control" name="tags" id="inputTags" placeholder="'.esc_html__('Enter tags or keywords comma separated...', 'listingpro-plugin').'"></textarea>
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
											<label for="postVideo">'.$listingVdoText.'<span>'.esc_html__('(Optional)', 'listingpro-plugin').'</span></label>
											<input type="text" class="form-control" name="postVideo" id="postVideo" placeholder="'.esc_html__('ex: https://youtu.be/lY2yjAdbvdQ', 'listingpro-plugin').'">
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
															<span style="display:inline-block; margin: 15px 0">'.esc_html__('or', 'listingpro-plugin').'</span>
														</div>
														<a class="jFiler-input-choose-btn blue">'.esc_html__('Browse Files', 'listingpro-plugin').'</a>
														<div id="filediv">
															<input type="file" name="listingfiles[]" id="file" multiple>
														</div>
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
                                    <div class="lp-submit-accoutn lp-submit-accoutn-wrap">
                                        <div class="lp-submit-no-account">
                                            <label for="inputEmail">'.$listingEmailText.'</label>
									        <input type="email" class="form-control" name="email" id="inputEmail" placeholder="'.esc_html__('your contact email', 'listingpro-plugin').'">
                                        </div>
                                        <div class="lp-submit-have-account row" style="display: none;">
                                            <div class="col-md-6"><label for="inputUsername">'. esc_html__('Email', 'listingpro-plugin') .'</label>
									        <input type="text" class="form-control" name="inputUsername" id="inputUsername" placeholder="'.esc_html__('enter username', 'listingpro-plugin').'"></div>
									        <div class="col-md-6"><label for="inputUserpass">'. esc_html__('Password', 'listingpro-plugin') .'</label>
									        <input type="password" class="form-control" name="inputUserpass" id="inputUserpass" placeholder="'.esc_html__('enter password', 'listingpro-plugin').'"></div>
                                        </div>
                                    </div>
									<div class="checkbox already-account-checkbox"> <input type="checkbox" id="already-account" value=""><label for="already-account" class="already-account">'.esc_html__('Already Have Account?', 'listingpro-plugin').'</label></div>

									';
								}
								else{
									$output .='<div id="inputEmail"></div>';
								}
							$output .='
							</div>
							<div class="form-group col-md-6 margin-bottom-0 preview-section-caption clearfix">';
								if(!empty($privacy_policy)){
									
									$output .='
								  	<div class="checkbox form-group col-md-4 check_policy termpolicy">
									  	<input id="policycheck" type="checkbox" name="policycheck" value="true">
									  	<label for="policycheck"><a target="_blank" href="'.get_the_permalink($privacy_policy).'" class="help" target="_blank">'.esc_html__('I Agree', 'listingpro-plugin').'</a></label>
									  	<div class="help-text">
											<a class="help" target="_blank"><i class="fa fa-question"></i></a>
											<div class="help-tooltip">
												<p>'.esc_html__('You agree you accept our Terms & Conditions for posting this ad.', 'listingpro-plugin').'</p>
											</div>
										</div>
								  	</div>';
								}
								
								
								$output .='
								<div class="form-group clearfix margin-bottom-0 preview-section pos-relative col-md-8 pull-right">';
								$output .= 'fdf';
								if($enableCaptcha==true){
									if ( class_exists( 'cridio_Recaptcha' ) ){ 
										if ( cridio_Recaptcha_Logic::is_recaptcha_enabled() ) { 
										$output .='<div style="transform:scale(0.77);-webkit-transform:scale(0.77);transform-origin:0 0;-webkit-transform-origin:0 0;" id="recaptcha-securet" class="g-recaptcha form-group clearfix" data-sitekey="'.$gSiteKey.'"></div>';
										}
									}
								}
								$output .='<div class="clearfix"></div>';
									$output .='<div class="submitbutton-wraper">';
										$output .='
											<label for="previewListing">'.esc_html__('Click below to review your listing.', 'listingpro-plugin').'</label>
											<div class="success_box">'.esc_html__('All of the fields were successfully validated!', 'listingpro-plugin').'</div>
											<div class="error_box"></div>
											<input type="hidden" name="plan_id" value="'.$plan_id.'" /> 
											<input type="hidden" name="errorrmsg" value="'.esc_html__('Something is missing! Please fill out all fields highlighted in red.', 'listingpro-plugin').'" /> 
											<input type="submit" id="listingsubmitBTN" name="listingpost" value="'.$btnText.'" class="lp-secondary-btn btn-first-hover" />
											<i class="fa fa-angle-right"></i>
										</div>';
									$output .='</div>';
								$output .= wp_nonce_field( 'post_nonce', 'post_nonce_field' ,true, false );
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
add_shortcode('listingpro_submit', 'listingpro_shortcode_submit');
