<?php 
/*------------------------------------------------------*/
/* Submit Listing
/*------------------------------------------------------*/
vc_map( array(
	"name"                      => __("Listing Checkout", "js_composer"),
	"base"                      => 'listingpro_checkout',
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
			"type"        => "attach_image",
			"class"       => "",
			"heading"     => __("Bank Transfer Image","js_composer"),
			"param_name"  => "bank_transfer_img",
			"value"       => "",
			"description" => "Bank Transfer image"
		),
		array(
			"type"        => "attach_image",
			"class"       => "",
			"heading"     => __("Stripe Image","js_composer"),
			"param_name"  => "stripe_img",
			"value"       => "",
			"description" => "Stripe image"
		),
		
		array(
			"type"        => "attach_image",
			"class"       => "",
			"heading"     => __("Paypal Image","js_composer"),
			"param_name"  => "paypal_img",
			"value"       => "",
			"description" => "Paypal image"
		),
		array(
			"type"        => "attach_image",
			"class"       => "",
			"heading"     => __("2 Checkout Image","js_composer"),
			"param_name"  => "twocheckout_img",
			"value"       => "",
			"description" => "2checkout image"
		),
		
		
	),
) );
function listingpro_shortcode_checkout($atts, $content = null) {
	
	extract(shortcode_atts(array(
		'title'   => '',
		'stripe_img'   => '',		
		'bank_transfer_img'   => '',		
		'paypal_img'   => '',		
		'twocheckout_img'   => '',		
	), $atts));
	
	
	
	
	$output = null;
	
	global $listingpro_options;
	
	
	$paypalStatus = false;
	$stripeStatus = false;
	$wireStatus = false;
	$checkout2Status = false;
	if($listingpro_options['enable_paypal']=="1"){
		$paypalStatus = true;
	}
	if($listingpro_options['enable_stripe']=="1"){
		$stripeStatus = true;
	}
	if($listingpro_options['enable_wireTransfer']=="1"){
		$wireStatus = true;
	}
	if($listingpro_options['enable_2checkout']=="1"){
		$checkout2Status = true;
	}

	
	
	/* ================================for campaign wire============================== */
	if(isset($_GET['checkout']) && !empty($_GET['checkout']) && $_GET['checkout']=="wire"){
		
			if (!isset($_SESSION)) { session_start(); }

			$postID = $_SESSION['post_id'];
			if(!empty($postID)){
				$output ='<div class="page-container-four clearfix">';
				$output .='<div class="col-md-10 col-md-offset-1">';
				$output .= get_campaign_wire_invoice( $postID );
				$output .='</div>';
				$output .='</div>';
				unset($_SESSION['post_id']);
			}
			else{
				$redirect = site_url();
				wp_redirect($redirect);
				exit();
			}
	}
	/* ================================for listings wire============================== */
	else if( isset($_GET['method']) && !empty($_GET['method']) && $_GET['method']=="wire" ){
			
			if (!isset($_SESSION)) { session_start(); }

			$postID = $_SESSION['post_id'];
			if(!empty($postID)){
				$output ='<div class="page-container-four clearfix">';
				$output .='<div class="col-md-10 col-md-offset-1">';
				$output .= generate_wire_invoice( $postID );
				$output .='</div>';
				$output .='</div>';
				unset($_SESSION['post_id']);
			}
			else{
				$redirect = site_url();
				wp_redirect($redirect);
				exit();
			}
	}
	/* ================================for checkout default page ============================== */
	else{
			$post_id = '';
			$order_id = '';
			$redirect = '';
			$redirect = get_template_directory_uri().'/include/paypal/form-handler.php?func=addrow';
			$recurringPayment = '';
			if(isset($listingpro_options['lp_enable_recurring_payment'])){
				$recurringPayment = $listingpro_options['lp_enable_recurring_payment'];
			}
			
			
			$output ='<div class="page-container-four clearfix">';
			$output .='<div class="col-md-10 col-md-offset-1">';
			
			$paid_mode = $listingpro_options['enable_paid_submission'];
			
			if( !empty($paid_mode) && $paid_mode=="no" ){
					$output .='<p class="text-center">'.esc_html__('Sorry! Currently Free mode is activated','listingpro-plugin').'</p>';
			}
			else{
					
						
						$output .='<form autocomplete="off" id="listings_checkout" class="lp-listing-form" name ="listings_checkout" action="'.$redirect.'" method="post" data-recurring="'.$recurringPayment.'">';		
						$output .='<h3> '.esc_html__( $title, 'listingpro-plugin' ).'</h3>';
						$output .='<div class="row">';
						$output .='<div class="col-md-8">';
							if(isset($_POST['planid']) && isset($_POST['listingid'])){
								ob_start();
								include_once(WP_PLUGIN_DIR.'/listingpro-plugin/templates/quick-checkout.php');
								$output .= ob_get_contents();
								ob_end_clean();
								ob_flush();
							}
							else{
								ob_start();
								include_once(WP_PLUGIN_DIR.'/listingpro-plugin/templates/default-checkout.php');
								$output .= ob_get_contents();
								ob_end_clean();
								ob_flush();
							}
						
						$output .='<div class="clearfix lp-checkoutbtn-wrap">';
						
						ob_start();
						include_once(WP_PLUGIN_DIR.'/listingpro-plugin/templates/tax.php');
						$output .= ob_get_contents();
						ob_end_clean();
						ob_flush();
						
						if($wireStatus==true || $stripeStatus==true || $paypalStatus==true || $checkout2Status==true){
							$output .='<input type="submit" class="lp_checkout_submitBtn" name="submit_checkout" value="'.esc_html__('Proceed to Next','listingpro-plugin').'" />
							<i class="lp-after-token fa fa-spinner fa-pulse fa-3x fa-fw"></i>
							'
							;
						}
						$output.='</div>';
						
						$output .='</div>';
						
						$output .='<div class="col-md-4">';
						ob_start();
						include_once(WP_PLUGIN_DIR.'/listingpro-plugin/templates/payment-methods.php');
						$output .= ob_get_contents();
						ob_end_clean();
						ob_flush();
						
						$output .='<input type="hidden" name="post_id" value="" />';
						$output .='<input type="hidden" name="method" value="" />';
						$output .= '<input type="hidden" name="listings_tax_price" value="">';
						$output .='<input type="hidden" name="func" value="start" />';
						$output .='<input type="hidden" name="errormsg" value="'.esc_html__('Sorry! Please select listing and payment method to complete the process', 'listingpro-plugin').'" />';
						$output .='</div>';
						
						$output .='</div>';
						
						
						$output .='</form>';
						if($checkout2Status == true){
							ob_start();
							include_once(WP_PLUGIN_DIR.'/listingpro-plugin/templates/popup.php');
							$output .= ob_get_contents();
							ob_end_clean();
							ob_flush();
						}
						
			}
			
			
			
			$output .='</div>';
			$output .='</div>';
			
			$pubilshableKey = '';
			
			$pubilshableKey = $listingpro_options['stripe_pubishable_key'];
			
			$ajaxURL = '';
			$ajaxURL = admin_url( 'admin-ajax.php' );
			$loadingClasses = "class='lp-after-token fa fa-spinner fa-pulse fa-3x fa-fw'";
			
			$output .='

			<button id="stripe-submit">'.esc_html__('Purchase','listingpro-plugin').'</button>

			<script>
			var post_title = "";
			listings_id = "";
			listings_img = "";
			plan_price = "";
			currency = "";
			plan_id = "";
			listing_img = "";
			taxrate = "";
			jQuery("#listings_checkout input[name=listing_id]").click(function(){
				post_title = "";
				post_title = jQuery("#listings_checkout input[name=post_title]").val();
				
				plan_price = "";
				plan_price = jQuery("#listings_checkout input[name=plan_price]").val();
				
				currency = "";
				currency = jQuery("#listings_checkout input[name=currency]").val();
				
				listings_id = "";
				listings_id = jQuery("#listings_checkout input[name=listing_id]:checked").val();
				
				plan_id = "";
				plan_id = jQuery(this).closest(".lp-user-listings").find("input[name=plan_id]").val();
				
				listing_img = "";
				listing_img = jQuery("#listings_checkout input[name=listing_img]").val();
				taxrate = jQuery("input[name=listings_tax_price]").val();
				
			});
			var recurringtext ="";
			jQuery("#listings_checkout").submit(function(){
				recurringtext = jQuery("input[name=lp-recurring-option]:checked").val();
			});
			
			var token_email, token_id;
			var handler = StripeCheckout.configure({
			  key: "'.$pubilshableKey.'",
			  image: "https://stripe.com/img/documentation/checkout/marketplace.png",
			  locale: "auto",
			  token: function(token) {
				console.log(token);
				token_id = token.id;
				token_email = token.email;
				jQuery("body").addClass("listingpro-loading");
				jQuery.ajax({
					type: "POST",
					dataType: "json",
					url: "'.$ajaxURL.'",
					data: { 
						"action": "listingpro_save_stripe", 
						"token": token_id, 
						"email": token_email, 
						"listing": listings_id, 
						"plan": plan_id,
						"taxrate" : taxrate,						
						"recurring" : recurringtext,						
					},   
					success: function(res){
						if(res.status=="success"){
							redURL = res.redirect;
							if(res.status=="success"){
								window.location.href = redURL;
								jQuery("body").removeClass("listingpro-loading");
							}
						}
						if(res.status=="fail"){
							alert(res.redirect);
							jQuery("body").removeClass("listingpro-loading");
						}
						
					},
					error: function(errorThrown){
						alert(errorThrown);
						jQuery("body").removeClass("listingpro-loading");
					} 
				});
				

			  }
			});

			//document.getElementById("stripe-submit").addEventListener("click", function(e) {
			  
			  //e.preventDefault();
			//});

			// Close Checkout on page navigation:
			window.addEventListener("popstate", function() {
			  handler.close();
			});
			</script>
			
			';
	}
	return $output;
}
add_shortcode('listingpro_checkout', 'listingpro_shortcode_checkout');