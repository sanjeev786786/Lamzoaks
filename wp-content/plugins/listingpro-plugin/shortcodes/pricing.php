<?php
/*------------------------------------------------------*/
/* Pricing plans
/*------------------------------------------------------*/
vc_map( array(
	"name"                      => esc_html__("Pricing Plans", "js_composer"),
	"base"                      => 'listingpro_pricing',
	"category"                  => esc_html__('Listingpro', 'js_composer'),
	"description"               => '',
	"params"                    => array(
		array(
			"type"			=> "textfield",
			"class"			=> "",
			"heading"		=> esc_html__("Title","js_composer"),
			"param_name"	=> "title",
			"value"			=> ""
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Subtitle', 'js_composer' ),
			'param_name'  => 'subtitle',
			'value'       => ''
		),
		array(
			"type"        => "dropdown",
			"class"       => "",
			"heading"     => esc_html__("Pricing plans views","js_composer"),
			"param_name"  => "pricing_views",
			'value' => array(
				esc_html__( 'Horizontal View', 'js_composer' ) => 'horizontal_view',
				esc_html__( 'Vertical View', 'js_composer' ) => 'vertical_view',
			),
			'save_always' => true,
			"description" => ""
		),
	),
) );
function listingpro_shortcode_pricing($atts, $content = null) {
	extract(shortcode_atts(array(
		'title'   			=> '',
		'subtitle'   		=> '',
		'pricing_views'   	=> 'horizontal_view'
	), $atts));
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
	global $wpdb;
	
	$lp_social_show;
	$lp_social_show = $listingpro_options['listin_social_switch'];
	$dbprefix = '';
	$dbprefix = $wpdb->prefix;
	$user_ID = '';
	$user_ID = get_current_user_id();
	$output = null;
	$results = null;
	$table_name = $dbprefix.'listing_orders';
	$limitLefts = '';
	$taxOn = $listingpro_options['lp_tax_swtich'];
	$withtaxprice = false;
	if($taxOn=="1"){
		$showtaxwithprice = $listingpro_options['lp_tax_with_plan_swtich'];
		if($showtaxwithprice=="1"){
			$withtaxprice = true;
		}
	}
	
	if( $pricing_views == 'horizontal_view' ) {
		$output .= '
		<div class="page-container-four clearfix">
			<div class="col-md-10 col-md-offset-1">
				<div class="page-header">
					<h3>'.$title.'</h3>
					<p>'.$subtitle.'</p>
				</div>
				<div class="page-inner-container">';
					$args = array(
						'post_type' => 'price_plan',
						'posts_per_page' => -1
					);
					$query = new WP_Query( $args );
					if($query->have_posts()){
						while ( $query->have_posts() ) {
							$query->the_post();
							global $post;
							$plan_package_type = get_post_meta( get_the_ID(), 'plan_package_type', true );
							$post_price = get_post_meta(get_the_ID(), 'plan_price', true);
							$plan_time = '';
							$plan_time = get_post_meta(get_the_ID(), 'plan_time', true);
							$posts_allowed_in_plan = '';
							$posts_allowed_in_plan = get_post_meta(get_the_ID(), 'plan_text', true);
							
							if(!empty($plan_package_type) && $plan_package_type=="Package"){
								if(is_numeric($posts_allowed_in_plan)){
									$posts_allowed_in_plan = $posts_allowed_in_plan;
								}
								else{
									$posts_allowed_in_plan = esc_html__('unlimited', 'listingpro-plugin');
								}
							}
							

							$contact_show = get_post_meta( get_the_ID(), 'contact_show', true );
							if($contact_show == 'true'){
								$contact_checked = 'checked';
							}else{
								$contact_checked = 'unchecked';
							}
							
							$map_show = get_post_meta( get_the_ID(), 'map_show', true );
							if($map_show == 'true'){
								$map_checked = 'checked';
							}else{
								$map_checked = 'unchecked';
							}
							
							$video_show = get_post_meta( get_the_ID(), 'video_show', true );
							if($video_show == 'true'){
								$video_checked = 'checked';
							}else{
								$video_checked = 'unchecked';
							}
							
							$gallery_show = get_post_meta( get_the_ID(), 'gallery_show', true );
							if($gallery_show == 'true'){
								$gallery_checked = 'checked';
							}else{
								$gallery_checked = 'unchecked';
							}
							
							$listingproc_tagline = get_post_meta( get_the_ID(), 'listingproc_tagline', true );
							if($listingproc_tagline == 'true'){
								$tagline_checked = 'checked';
							}else{
								$tagline_checked = 'unchecked';
							}
							
							$listingproc_location = get_post_meta( get_the_ID(), 'listingproc_location', true );
							if($listingproc_location == 'true'){
								$location_checked = 'checked';
							}else{
								$location_checked = 'unchecked';
							}
							
							$listingproc_website = get_post_meta( get_the_ID(), 'listingproc_website', true );
							if($listingproc_website == 'true'){
								$website_checked = 'checked';
							}else{
								$website_checked = 'unchecked';
							}
							
							$listingproc_social = get_post_meta( get_the_ID(), 'listingproc_social', true );
							if($listingproc_social == 'true'){
								$social_checked = 'checked';
							}else{
								$social_checked = 'unchecked';
							}
							
							$listingproc_faq = get_post_meta( get_the_ID(), 'listingproc_faq', true );
							if($listingproc_faq == 'true'){
								$faq_checked = 'checked';
							}else{
								$faq_checked = 'unchecked';
							}
							
							$listingproc_price = get_post_meta( get_the_ID(), 'listingproc_price', true );
							if($listingproc_price == 'true'){
								$price_checked = 'checked';
							}else{
								$price_checked = 'unchecked';
							}
							
							$listingproc_tag_key = get_post_meta( get_the_ID(), 'listingproc_tag_key', true );
							if($listingproc_tag_key == 'true'){
								$tag_key_checked = 'checked';
							}else{
								$tag_key_checked = 'unchecked';
							}
							
							$listingproc_bhours = get_post_meta( get_the_ID(), 'listingproc_bhours', true );
							if($listingproc_bhours == 'true'){
								$bhours_checked = 'checked';
							}else{
								$bhours_checked = 'unchecked';
							}
							
							
							
							
							$plan_type_name = '';
							if( $plan_package_type=="Pay Per Listing" ){
								$plan_type_name = esc_html__("Per Listing",'listingpro-plugin');
							}
							else{
								$plan_type_name = esc_html__("Per Package",'listingpro-plugin');
							}
							
				
							$plan_text = '';
							$used = '';
							$plan_limit_left = '';
							$limitLefts = null;
							$currentPlanID = get_the_ID();
							
							if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
								$results = $wpdb->get_results( "SELECT * FROM ".$dbprefix."listing_orders WHERE user_id ='$user_ID' AND plan_id ='$currentPlanID' AND status = 'success' AND plan_type='$plan_package_type'"  );
							}
							
							$used = '';
							if(!empty($plan_package_type) && $plan_package_type=="Package"){
									$plan_text = esc_html__('Per Package ', 'listingpro-plugin');
									$plan_limit_left = $posts_allowed_in_plan;
								}
								else if(!empty($plan_package_type) && $plan_package_type=="Pay Per Listing"){
									$plan_text = esc_html__('Per Listing ', 'listingpro-plugin');
								}
							if( !empty($results) && count($results)>0 ){
								if(!empty($plan_package_type) && $plan_package_type=="Package"){
									
									/* package details */
									/* foreach ( $results as $info ) {
										$used = $info->used;
									} */
									
									$used = $results[0]->used;
									
									if(is_numeric($posts_allowed_in_plan)){
										$plan_limit_left = (int)$posts_allowed_in_plan - (int)$used;
									}
									else{
										$plan_limit_left = $posts_allowed_in_plan;
									}
									
									$plan_text = esc_html__('Per Package ', 'listingpro-plugin');
								}
								else if(!empty($plan_package_type) && $plan_package_type=="Pay Per Listing"){
									$plan_text = esc_html__('Per Listing ', 'listingpro-plugin');
								}
								
								
								
							}
							
							$plan_title_color = '';
                            $plan_title_img =   '';
                            $plan_title_bg  =   '';

                            $plan_title_img = listing_get_metabox_by_ID('lp_price_plan_bg', get_the_ID()); 
							
                            $plan_title_color = get_post_meta(get_the_ID(), 'plan_title_color', true);
							$classForBg = 'price-plan-box-upper';
                            if( isset($plan_title_img) && $plan_title_img != '' )
                            {
                                $plan_title_bg  =   "background: url($plan_title_img); background-size:cover;";
								$classForBg .= ' lp-overlay-pricing';
                            }
                            else
                            {
                                $plan_title_bg  =   "background-color: $plan_title_color;";
                            }
							
							$output .='
							<div class="price-plan-box lp-border-radius-8 '.get_the_ID().'">
								<div class="'.$classForBg.'" style="'.$plan_title_bg.'">
									<div class="lp-plane-top-wrape">
										<h1 class="clearfix">
											<span class="pull-left">'.get_the_title().'</span>';
											if(!empty($post_price)){
												if($withtaxprice=="1"){
													$taxrate = $listingpro_options['lp_tax_amount'];
													$taxprice = (float)(($taxrate/100)*$post_price);
													$post_price = (float)$post_price + (float)$taxprice;
												}
												$lp_currency_position = $listingpro_options['pricingplan_currency_position'];
												if(isset($lp_currency_position) && $lp_currency_position=="left"){
													$output .='<span class="pull-right">'.listingpro_currency_sign().$post_price.'</span>';
												}
												else{
													$output .='<span class="pull-right">'.$post_price.listingpro_currency_sign().'</span>';
												}
											}
											else{
												$output .='<span class="pull-right">'.esc_html__("Free", "listingpro-plugin").'</span>';
											}
											
										$listingCalculations = null;	
										$output .=
										'</h1>
										<p class="clearfix">
											<span class="pull-left">'.$plan_text.'</span>
											<span class="pull-right">';
												if( !empty($plan_time) ){
													$output .= esc_html__('Duration', 'listingpro-plugin').' : '.$plan_time.' '.esc_html__('days', 'listingpro-plugin');
												}
												else{
													$output .= esc_html__('Duration', 'listingpro-plugin');
													$output .= esc_html__(' : Unlimited days', 'listingpro-plugin');
												}
												
												if( $plan_package_type=="Package" ){
													$plan_text = get_post_meta(get_the_ID(), 'plan_text', true);
													if( !empty($plan_text) && isset($plan_text) ){
														$plan_text = esc_html__('Total Listings : ', 'listingpro-plugin').$plan_text;
														$listingCalculations = $plan_text;
													}
													else{
														$plan_text = esc_html__('unlimited', 'listingpro-plugin');
														$plan_text = esc_html__('Total Listings : ', 'listingpro-plugin').$plan_text;
														$listingCalculations = $plan_text;
													}
											
													if( !empty($plan_limit_left) && is_numeric($plan_limit_left) ){
														$limitLefts .= esc_html__('Available Listings : ', 'listingpro-plugin'). $plan_limit_left;
														$listingCalculations .= ' '.$limitLefts;
													}
													
													
													if(!empty($used) && isset($used)){
														$used =  $used;
														$used = esc_html__(' Used :', 'listingpro-plugin').$used;
													}
													
													$listingCalculations .= $used;
													
													$output .='<p class="clearfix">'.$listingCalculations.'</p>';
												}
												
												$output .='
											</span>
										</p>
									</div>
								</div>
								<div class="price-plan-box-bottom lp-border clearfix">
									<div class="price-plan-content  pull-left">
										<ul class="list-style-none">
										
											';
											if($listingpro_options['lp_showhide_address']=="1"){
												$output .='
												
												<li>
													<span class="icon-text">'.listingpro_icon8($map_checked).'</span>
													<span>'.esc_html__('Map Display', 'listingpro-plugin').'</span>
												</li>
												';
											}
											if($listingpro_options['phone_switch']=="1"){
												$output .='
												<li>
													<span class="icon-text">'.listingpro_icon8($contact_checked).'</span>
													<span>'.esc_html__('Contact Display', 'listingpro-plugin').'</span>
												</li>
												';
											}
											if($listingpro_options['file_switch']=="1"){
												$output .='
												<li>
													<span class="icon-text">'.listingpro_icon8($gallery_checked).'</span>
													<span>'.esc_html__('Image Gallery', 'listingpro-plugin').'</span>
												</li>
												';
											}
											if($listingpro_options['vdo_switch']=="1"){
												$output .='
												<li>
													<span class="icon-text">'.listingpro_icon8($video_checked).'</span>
													<span>'.esc_html__('Video', 'listingpro-plugin').'</span>
												</li>
												';
											}
											
											$output .='
												<li>
													<span class="icon-text">'.listingpro_icon8($tagline_checked).'</span>
													<span>'.esc_html__('Business Tagline', 'listingpro-plugin').'</span>
												</li>';
											
											if($listingpro_options['location_switch']=="1"){
												$output .='
												<li>
													<span class="icon-text">'.listingpro_icon8($location_checked).'</span>
													<span>'.esc_html__('Location', 'listingpro-plugin').'</span>
												</li>';
											}
											if($listingpro_options['web_switch']=="1"){
												$output .='
												<li>
													<span class="icon-text">'.listingpro_icon8($website_checked).'</span>
													<span>'.esc_html__('Website', 'listingpro-plugin').'</span>
												</li>';
											}
											if($listingpro_options['listin_social_switch']=="1"){
												$output .='
												<li>
													<span class="icon-text">'.listingpro_icon8($social_checked).'</span>
													<span>'.esc_html__('Social Links', 'listingpro-plugin').'</span>
												</li>
												';
											}
											if($listingpro_options['faq_switch']=="1"){
												$output .='
												<li>
													<span class="icon-text">'.listingpro_icon8($faq_checked).'</span>
													<span>'.esc_html__('FAQ', 'listingpro-plugin').'</span>
												</li>
												';
											}
											if($listingpro_options['currency_switch']=="1"){
												$output .='
												<li>
													<span class="icon-text">'.listingpro_icon8($price_checked).'</span>
													<span>'.esc_html__('Price Range', 'listingpro-plugin').'</span>
												</li>
												';
											}
											
											if($listingpro_options['tags_switch']=="1"){
												$output .='
												<li>
													<span class="icon-text">'.listingpro_icon8($tag_key_checked).'</span>
													<span>'.esc_html__('Tags/Keywords', 'listingpro-plugin').'</span>
												</li>
												';
											}
											if($listingpro_options['oph_switch']=="1"){
													$output .='
													<li>
														<span class="icon-text">'.listingpro_icon8($bhours_checked).'</span>
														<span>'.esc_html__('Business Hours', 'listingpro-plugin').'</span>
													</li>
													';
											}
											
											$lp_plan_more_fields = listing_get_metabox_by_ID('lp_price_plan_addmore',get_the_ID());
											if(!empty($lp_plan_more_fields)){
												foreach($lp_plan_more_fields as $morefield){
													if(!empty($morefield)){
														$output .='<li>
															<span class="icon-text">'.listingpro_icon8('checked').'</span>
															<span>'.$morefield.'</span>
														</li>';
													}
												}
											}
											
											$output .='
										</ul>
									</div>
									<form  enctype="multipart/form-data" method="post" action="'.listingpro_url('submit-listing').'" class="price-plan-button  pull-right">
										<input type="hidden" name="plan_id" value="'.get_the_ID().'" />';
										
										if( !empty($plan_package_type) && $plan_package_type=="Package" ){
											$plan_price = get_post_meta(get_the_ID(), 'plan_price', true);
											if(!empty($plan_price)){
											
												if(!empty($plan_limit_left)){
													
												
													$output .='<input id="submit'.$post->ID.'" class="lp-secondary-btn btn-second-hover" type="submit" value="'.esc_html__('Get Started Now', 'listingpro-plugin').'" name="submit">';
												}
												else{
													$output .='<input id="submit'.$post->ID.'" class="lp-secondary-btn btn-second-hover" type="submit" value="'.esc_html__('Get Started Now', 'listingpro-plugin').'" name="submit">';
												}
											}
											else{
												$output .='<p>A <strong>'.esc_html__("Package",'listingpro-plugin').'</strong>'.esc_html__(" should have a price ",'listingpro-plugin').'</p>';
											}
										}
										
										else{
											$output .='<input id="submit'.$post->ID.'" class="lp-secondary-btn btn-second-hover" type="submit" value="'.esc_html__('Get Started Now', 'listingpro-plugin').'" name="submit">';
										}
										
										
										$output .= wp_nonce_field( 'price_nonce', 'price_nonce_field'.$post->ID ,true, false );
										$output .='
									</form>
								</div>
							</div>';
						}/* END WHILE */
						wp_reset_postdata();
					}else {
						echo '<p class="text-center">'.esc_html__('There is no Plan available right now.', 'listingpro-plugin').'</p>';
					}
					$output .= '
				</div>
			</div>
		</div>';
	}elseif( $pricing_views == 'vertical_view' ) {
		$output .= '
		<div class="col-md-10 col-md-offset-1 padding-bottom-40 '.$pricing_views.'">
			<div class="page-header">
				<h3>'.$title.'</h3>
				<p>'.$subtitle.'</p>
			</div>
			<div class="page-inner-container">
				<div class="row">';
					$args1 = array(
						'post_type' => 'price_plan',
						'posts_per_page' => -1
					);
					$query1 = new WP_Query( $args1 );
					$gridNumber = 0;
					if($query1->have_posts()){
						while ( $query1->have_posts() ) {
							$query1->the_post(); $gridNumber++;
							global $post;
							$plan_package_type = get_post_meta( get_the_ID(), 'plan_package_type', true );
							$post_price = get_post_meta(get_the_ID(), 'plan_price', true);

							$plan_time = '';
							$plan_time = get_post_meta(get_the_ID(), 'plan_time', true);
							$posts_allowed_in_plan = '';
							$PostAllowedInPlan = get_post_meta(get_the_ID(), 'plan_text', true);
							if(!empty($PostAllowedInPlan)){
								$posts_allowed_in_plan = get_post_meta(get_the_ID(), 'plan_text', true);
								$posts_allowed_in_plan = trim($posts_allowed_in_plan);
							}
							else{
								$posts_allowed_in_plan = 'unlimited';
							}
							
							$contact_show = get_post_meta( get_the_ID(), 'contact_show', true );
							if($contact_show == 'true'){
								$contact_checked = 'checked';
							}else{
								$contact_checked = 'unchecked';
							}
							
							$map_show = get_post_meta( get_the_ID(), 'map_show', true );
							if($map_show == 'true'){
								$map_checked = 'checked';
							}else{
								$map_checked = 'unchecked';
							}
							
							$video_show = get_post_meta( get_the_ID(), 'video_show', true );
							if($video_show == 'true'){
								$video_checked = 'checked';
							}else{
								$video_checked = 'unchecked';
							}
							
							$gallery_show = get_post_meta( get_the_ID(), 'gallery_show', true );
							if($gallery_show == 'true'){
								$gallery_checked = 'checked';
							}else{
								$gallery_checked = 'unchecked';
							}
							
							$listingproc_tagline = get_post_meta( get_the_ID(), 'listingproc_tagline', true );
							if($listingproc_tagline == 'true'){
								$tagline_checked = 'checked';
							}else{
								$tagline_checked = 'unchecked';
							}
							
							$listingproc_location = get_post_meta( get_the_ID(), 'listingproc_location', true );
							if($listingproc_location == 'true'){
								$location_checked = 'checked';
							}else{
								$location_checked = 'unchecked';
							}
							
							$listingproc_website = get_post_meta( get_the_ID(), 'listingproc_website', true );
							if($listingproc_website == 'true'){
								$website_checked = 'checked';
							}else{
								$website_checked = 'unchecked';
							}
							
							$listingproc_social = get_post_meta( get_the_ID(), 'listingproc_social', true );
							if($listingproc_social == 'true'){
								$social_checked = 'checked';
							}else{
								$social_checked = 'unchecked';
							}
							
							$listingproc_faq = get_post_meta( get_the_ID(), 'listingproc_faq', true );
							if($listingproc_faq == 'true'){
								$faq_checked = 'checked';
							}else{
								$faq_checked = 'unchecked';
							}
							
							$listingproc_price = get_post_meta( get_the_ID(), 'listingproc_price', true );
							if($listingproc_price == 'true'){
								$price_checked = 'checked';
							}else{
								$price_checked = 'unchecked';
							}
							
							$listingproc_tag_key = get_post_meta( get_the_ID(), 'listingproc_tag_key', true );
							if($listingproc_tag_key == 'true'){
								$tag_key_checked = 'checked';
							}else{
								$tag_key_checked = 'unchecked';
							}
							
							$listingproc_bhours = get_post_meta( get_the_ID(), 'listingproc_bhours', true );
							if($listingproc_bhours == 'true'){
								$bhours_checked = 'checked';
							}else{
								$bhours_checked = 'unchecked';
							}
							
							$plan_hot = '';
							$plan_hot = get_post_meta( get_the_ID(), 'plan_hot', true );
							
							$plan_type = '';
							$plan_type_name = '';
							$plan_type = get_post_meta(get_the_ID(), 'plan_package_type', true);
							if( $plan_type=="Pay Per Listing" ){
								$plan_type_name = esc_html__("Per Listing",'listingpro-plugin');
							}
							else{
								$plan_type_name = esc_html__("Per Package",'listingpro-plugin');
							}
							
							$currentPlanID = get_the_ID();
							$plan_text = '';
							$used = '';
							$plan_limit_left = '';
							if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
								$results = $wpdb->get_results( "SELECT * FROM ".$dbprefix."listing_orders WHERE user_id ='$user_ID' AND plan_id='$currentPlanID' AND status = 'success' AND plan_type='$plan_type'" );
							}
							
							
			
							if( !empty($results) && count($results)>0 ){
								$used = '';
								$used = $results[0]->used;
								
								if(is_numeric($posts_allowed_in_plan)){
									$plan_limit_left = (int)$posts_allowed_in_plan - (int)$used;
								}
								else{
									$plan_limit_left = 'unlimited';
								}
								
							}
							else{
								$plan_limit_left = $PostAllowedInPlan;
							}

							if( !empty ( $plan_package_type ) ){
								if( $plan_package_type=="Pay Per Listing" ){
									$plan_text = '';
								}
								else if( $plan_package_type=="Package" ){
									$plan_text = get_post_meta(get_the_ID(), 'plan_text', true);
									if( !empty($plan_text) && isset($plan_text) ){
										$plan_text = esc_html__('Max. listings allowed : ', 'listingpro-plugin').$plan_text;
									}
								}
							}

							$hotClass = '';
							if(!empty($plan_hot) && $plan_hot=="true") {
								$hotClass = 'featured-plan';
							}else {
								$hotClass = '';
							}

							$output .='
							<div class="col-md-4 '.get_the_ID().' '.$hotClass.'">
								<div class="lp-price-main lp-border-radius-8 lp-border text-center">';
								
								$user_ID = get_current_user_id();
								
								
								if( !empty($plan_type) && $plan_type=="Package" ){
									if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
										$results = $wpdb->get_results( "SELECT * FROM ".$dbprefix."listing_orders WHERE user_id ='$user_ID' AND plan_id='$currentPlanID' AND status = 'success' AND plan_type='$plan_type'" );
									}
									
									if(is_numeric($plan_limit_left)){
										if( !empty($results) && count($results)>0 ){
											if(!empty($post_price) && $plan_limit_left>0){
												$output .='<div class="lp-sales-option">
																<div class="sales-offer">
																	'.esc_html__("Active",'listingpro-plugin').'
																</div>
															</div>';
											}
										}
									}
									else if(!empty($post_price) && $plan_limit_left=="unlimited"){
										if( !empty($plan_type) && $plan_type=="Package" ){
											if( !empty($results) && count($results)>0 ){
												$output .='<div class="lp-sales-option">
																<div class="sales-offer">
																	'.esc_html__("Active",'listingpro-plugin').'
																</div>
															</div>';
											}
										}
									}
								}
									$plan_title_color = '';
									$plan_title_img =   '';
									$plan_title_bg  =   '';

									$plan_title_img = listing_get_metabox_by_ID('lp_price_plan_bg', get_the_ID()); 

									$plan_title_color = get_post_meta(get_the_ID(), 'plan_title_color', true);
									$classForBg = 'lp-title';
									if( isset($plan_title_img) && $plan_title_img != '' )
									{
										$plan_title_bg  =   "background: url($plan_title_img); background-size:cover;";
										$classForBg .= ' lp-overlay-pricing';
									}
									else
									{
										$plan_title_bg  =   "background-color: $plan_title_color;";
									}
									$output .='
									<div class="'.$classForBg.'" style="'.$plan_title_bg.'">
										<div class="lp-plane-top-wrape">
											<a>'.get_the_title().'</a>';
											if(!empty($post_price)){
												if($withtaxprice=="1"){
													$taxrate = $listingpro_options['lp_tax_amount'];
													$taxprice = (float)(($taxrate/100)*$post_price);
													$post_price = (float)$post_price + (float)$taxprice;
												}
												$lp_currency_position = $listingpro_options['pricingplan_currency_position'];
												if(isset($lp_currency_position) && $lp_currency_position=="left"){
													$output .='<p>'.listingpro_currency_sign().$post_price.'</p>';
												}
												else{
													$output .='<p>'.$post_price.listingpro_currency_sign().'</p>';
												}
											}
											else{
												$output .='<p>'.esc_html__("Free", 'listingpro-plugin').'</p>';
											}
											if(!empty($plan_type_name)){
												$output .='<span class="package-type">'.$plan_type_name.'</span><br><br>';
											}
											
											if(is_numeric($plan_limit_left)){
												if( !empty($results) && count($results)>0 ){
													if(!empty($post_price) && $plan_limit_left>0){
														$output .= '<span style="font-size:12px;color:#fff" class="allowedListing">'.esc_html__('Remaining Listings : ', 'listingpro-plugin') . $plan_limit_left.'</span>';
													}
												}
											}
										$output .='	</div>';
									$output .='
									</div>';
									
									$output .='
									<div class="lp-price-list">';
									if(!empty($plan_hot) && $plan_hot=="true"){
										$output .='<div class="lp-hot">'.esc_html__('Hot','listingpro-plugin').'</div>';
									}
									
										
										$output .='<ul class="lp-listprc">
											<li>
												<span class="icon-text">
													<img class="icon icons8-Cancel" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAFaElEQVRoQ+1aTVbbVhT+rpSDO6s5EePACgqTVh7F7ABWgFkBZlKbUckInAnJCmJWULICxMhuJjgrCIxxDnQGja3bcyU9+0lI1pNsSk9OPAL8/r77893v3QfhO/nQd4IDP4CkefLtp9vXzH6dmesErgK0Ph3HAwbdye9E5BFZH3//dXmwqIiY2yNHvZs6Ee0Q0Ch6KAauAHjMfHpQW/GKztfHlwbS+Wu4xYw9AupqQQZ/BsTa8IjsK93ibz/dro/Ho6plUZUZdWJsgfBqOjcA9KYsoMJAjnq3q0TjDxMAjGuAuz5edA9qy2Jh44+A4/Foi4maBPwsExnwKhV7e39jOQhD008hIOIFMD4AqDLwN4EOW+7Ld6abZY07ubyt/nM/aipAEnKWZW8nc0jGZQE0BnLc/7pH4ODQDHysVOxGUavlAZaDPjyMPAL9ImN9xu5BzenKz0e9YcMinJBlb6aRhBGQ4/5QQilKZtpfhBdmgTruD98RsEeWvSGHFkKxiM6T4Aole6f/tQnwiYQSM5rKQnnWnfd7yUXJuSCP/LGAqIL5Tau2cpi29kyPRDnx5yxLzHvgWfOD3HkYnQf1iHHaqjmZFJ8JRCxi0fgysASePpzSAHX6N5cCQmi9UnlRn5WTmUCO+8NzoVhJ7LbrbD2l5dPWnuQl43rpJ3tdQEiuZNWZVCAqpCQvKhV7ddHslGcUPS8ty67rCe8zb6aBSQWivPEcIRXRrNQqgLDd+s05kx87vZtDEP0hBbPtOptJYzwCMqE6xnWr5qzmWW+R3+sMpdcQ2SOsMeMrUQBpXnkEpNMbdkHYmUV1izy8WitGLhkMpbySxmCPgfSHHNKtvVZUO5UFGKdZvmjVViZCVF8zAvsFwN1SxV7TczcGZJrk/Lntrmh3ibJHNJvX6Q+lVm2Z0Oxx/2YgEiYZXnEg04R633adptkx5hulaDZUDvZ6XhQo+ZIM/SQQD0SvdbaY75izZyuGEhCKZvP20+bE6lscSFRJlVjLW3Se702EYNr6U1aN51ICSJjoLdcxVsXMuCgqJE2FYBqQkBjGt5LwLddZVmNKA9ELV5Lz84Tgw8P4koDVPCGYtU4nYlbd4KWByCY6GAY12+7L93nhpgvBssy4cCCPwaDbdp3dLDBpQjAPeNr3uUAURxdN9rhn0sFoWsmYodJARPl1KTVH9+jC6Dfqb52JFmLEwcTzKV29mnpmctnjWaw1Z0EUa/n+2IvABG2db9+wyn5wQYs1E0wPnhxnVBCn3M6DlruyUWYzHQzAA4BEQVfLMlTyDIosZkoUmaQSaR7RGIIZdVVbZ1G3TCUaRQm0Xaeqg3wyGa96VLJZ3n3b1POFZLwKL+n2tV1nzXSTrCp8f49qnhA03aPTH0pFrxpdrILw6t2E4vGZuifptSPsryHBVqkSRf1R62c9usCYWm+R4yJ9JReqVG/IXpnicOoVnLVcZ3uRByu61vTild2amtmgIxoPwnb/8zToQhbVW7bZF6//dcs0qzWU5tHce4eyiOh/n7Ff9O5RNIzU+BgIg4jIBRKyWNQiCt5GzOR6WQAyT3+LMVUERkD0WI0OeLZUsXcX3UqN2Em6jFGv2Tw3jYEEYMIH0G703nfHoEOTy5SJdyIvyNtH+KxHaKh2qcn8QkBkwUDvYNQNC2bwDHdFRF3ft06LVvBgLcvfYeZGcPWNnvWY7WbRtQoDiRVNn5sKUPh3UbvwGORZln2dfOuLlPErAksnsR77hwLmCx84/M+ep5NuDrQZqBH0iwt+ghBinPngblkAMyVKwfNMhoeggn8gqDOhqmS8GiDXU2LI+7nnA968h9fPWTq0yoJ9qnk/gDyVZcuu+y8Ax3BgT7fNbAAAAABJRU5ErkJggg==" alt="icon-cross">
												</span>';
												$output .= '<span>';
												if( !empty($plan_time) ){
													$output .= esc_html__('Duration', 'listingpro-plugin').' : '.$plan_time.' '.esc_html__('days', 'listingpro-plugin');
												}
												else{
													$output .= esc_html__('Duration', 'listingpro-plugin');
													$output .= esc_html__(' : Unlimited days', 'listingpro-plugin');
												}
												$output .= '</span>';
												$output .='</li>';
												
												if(!empty($posts_allowed_in_plan) && $plan_type=="Package"){
													$output .='<li>';
													$output .='<span class="icon-text">'.listingpro_icon8('checked').'</span>';
													$output .= '<span>'.esc_html__('Max. Listings : ', 'listingpro-plugin'). $posts_allowed_in_plan.'</span>';
													$output .='</li>';
												}
											
												if(empty($posts_allowed_in_plan) && $plan_type=="Package"){
													$output .='<li>';
													$output .='<span class="icon-text">'.listingpro_icon8('checked').'</span>';
													$output .= '<span>'.esc_html__('Max. Listings : Unlimited', 'listingpro-plugin').'</span>';
													$output .='</li>';
												}
											
											if($listingpro_options['lp_showhide_address']=="1"){
												$output .='
												<li>
													<span class="icon icons8-Cancel">'.listingpro_icon8($map_checked).'</span>
													<span>'.esc_html__('Map Display', 'listingpro-plugin').'</span>
												</li>';
											}
											if($listingpro_options['phone_switch']=="1"){
												$output .='
														<li>
															<span class="icon icons8-Cancel">'.listingpro_icon8($contact_checked).'</span>
															<span>'.esc_html__('Contact Display', 'listingpro-plugin').'</span>
														</li>
														';
											}
											if($listingpro_options['file_switch']=="1"){
												$output .='
													<li>
														<span class="icon icons8-Cancel">'.listingpro_icon8($gallery_checked).'</span>
														<span>'.esc_html__('Image Gallery', 'listingpro-plugin').'</span>
													</li>
													';
											}
											if($listingpro_options['vdo_switch']=="1"){
												$output .='
													<li>
														<span class="icon icons8-Cancel">'.listingpro_icon8($video_checked).'</span>
														<span>'.esc_html__('Video', 'listingpro-plugin').'</span>
													</li>
													';
											}
											$output .='
											<li>
												<span class="icon-text">'.listingpro_icon8($tagline_checked).'</span>
												<span>'.esc_html__('Business Tagline', 'listingpro-plugin').'</span>
											</li>
											';
											if($listingpro_options['location_switch']=="1"){
												$output .='
													<li>
														<span class="icon-text">'.listingpro_icon8($location_checked).'</span>
														<span>'.esc_html__('Location', 'listingpro-plugin').'</span>
													</li>';
											}
											if($listingpro_options['web_switch']=="1"){
												$output .='
												<li>
													<span class="icon-text">'.listingpro_icon8($website_checked).'</span>
													<span>'.esc_html__('Website', 'listingpro-plugin').'</span>
												</li>';
												
											}
											
											if($listingpro_options['listin_social_switch']=="1"){
												$output .='
												<li>
													<span class="icon-text">'.listingpro_icon8($social_checked).'</span>
													<span>'.esc_html__('Social Links', 'listingpro-plugin').'</span>
												</li>
												';
											}
											if($listingpro_options['faq_switch']=="1"){
												$output .='
													<li>
														<span class="icon-text">'.listingpro_icon8($faq_checked).'</span>
														<span>'.esc_html__('FAQ', 'listingpro-plugin').'</span>
													</li>
													';
											}
											if($listingpro_options['currency_switch']=="1"){
												$output .='
													<li>
														<span class="icon-text">'.listingpro_icon8($price_checked).'</span>
														<span>'.esc_html__('Price Range', 'listingpro-plugin').'</span>
													</li>
													';
											}
											
											if($listingpro_options['tags_switch']=="1"){
												$output .='
													<li>
														<span class="icon-text">'.listingpro_icon8($tag_key_checked).'</span>
														<span>'.esc_html__('Tags/Keywords', 'listingpro-plugin').'</span>
													</li>
													';
											}
											if($listingpro_options['oph_switch']=="1"){
												$output .='		
												<li>
													<span class="icon-text">'.listingpro_icon8($bhours_checked).'</span>
													<span>'.esc_html__('Business Hours', 'listingpro-plugin').'</span>
												</li>
												';
											}
											$lp_plan_more_fields = listing_get_metabox_by_ID('lp_price_plan_addmore',get_the_ID());
											if(!empty($lp_plan_more_fields)){
												foreach($lp_plan_more_fields as $morefield){
													if(!empty($morefield)){
														$output .='<li>
															<span class="icon-text">'.listingpro_icon8('checked').'</span>
															<span>'.$morefield.'</span>
														</li>';
													}
												}
											}
											$output .='
										</ul>';
										$output .='<form method="post" action="'.listingpro_url('submit-listing').'" class="price-plan-button">
											<input type="hidden" name="plan_id" value="'.$post->ID.'" />';
											
											if(empty($post_price) && $plan_type=="Package"){
												$output .='<p>A <strong>'.esc_html__("Package",'listingpro-plugin').'</strong>'.esc_html__(" should have a price ",'listingpro-plugin').'</p>';

											}
											else if( !empty($plan_type) && $plan_type=="Package" ){
												if(!empty($plan_limit_left)){
											
													$output .='<input id="submit'.$post->ID.'" class="lp-price-free lp-without-prc btn" type="submit" value="'.esc_html__('Continue', 'listingpro-plugin').'" name="submit">';
												}
												else{
													$output .='<input id="submit'.$post->ID.'" class="lp-price-free lp-without-prc btn" type="submit" value="'.esc_html__('Continue', 'listingpro-plugin').'" name="submit">';
												}
											}
											else{
											
													$output .='<input id="submit'.$post->ID.'" class="lp-price-free lp-without-prc btn" type="submit" value="'.esc_html__('Continue', 'listingpro-plugin').'" name="submit">';
												
												
											}
											$output .= wp_nonce_field( 'price_nonce', 'price_nonce_field'.$post->ID ,true, false );
											$output .='
										</form>
									</div>
								</div>
							</div>';
							if($gridNumber%3 == 0) {
								$output.='<div class="clearfix"></div>';
							}
						}/* END WHILE */
						wp_reset_postdata();
					}else {
						echo '<p class="text-center">'.esc_html__('There is no Plan available right now.', 'listingpro-plugin').'</p>';
					}
					$output .= '
				</div>
			</div>
		</div>';
	}			
	
	return $output;
}
add_shortcode('listingpro_pricing', 'listingpro_shortcode_pricing');