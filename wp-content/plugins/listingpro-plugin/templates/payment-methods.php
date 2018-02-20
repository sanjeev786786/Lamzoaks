<?php
global $listingpro_options;
$paypalStatus = false;
$stripeStatus = false;
$wireStatus = false;
$twocheckStatus = false;
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
	$twocheckStatus = true;
}

$bank_img_url = null;
$stripe_img_url = null;
$paypal_img_url = null;
$twocheckout_img_url = null;

$bank_img_url = wp_get_attachment_url($bank_transfer_img);
$stripe_img_url = wp_get_attachment_url($stripe_img);
$paypal_img_url = wp_get_attachment_url($paypal_img);
$twocheckout_img_url = wp_get_attachment_url($twocheckout_img);
$output .='<h2 class="lp_select_listing_heading">'.esc_html__('SELECT A GATEWAY', 'listingpro-plugin').'</h2>';
$output .='<div class="lp-rightbnk-transfer-msg">';
if($wireStatus==true){
		$output .='<div class="lp-method-wrap">';
		$output .='<label>';
		
		
		$output .='<div class="radio radio-danger">
						<input type="radio" name="plan" id="rd1" value="wire">
						<label for="rd1">
						</label>
					</div>';
					if(!empty($bank_img_url)){
						$output .='<img src="'.esc_attr($bank_img_url).'">';
					}
					else{
						$output .='<img src="'.get_template_directory_uri().'/assets/images/bank_transfer.png">';
					}
		$bankinfo = '';
		$bankinfo = $listingpro_options['direct_payment_instruction'];
		//$output .= esc_html__('Bank Transfer', 'listingpro-plugin');
		$output .='</label>';
		$output .='<div class="lp-tranfer-info">';
			
		$output .= $bankinfo;
		$output .='</div>';
	}
		
		if($paypalStatus==true){
			$output .='<div class="lp-method-wrap">';
			$output .='<label>';
			
			
			$output .='<div class="radio radio-danger">
								<input type="radio" name="plan" id="rd2" value="paypal">
								<label for="rd2">
								 
								</label>
							</div>';
			
			if(!empty($paypal_img_url)){
				$output .= '<img src="'.esc_attr($paypal_img_url).'">';
			}
			else{
				$output .= '<img src="'.get_template_directory_uri().'/assets/images/paypal.png">';
			}
			//$output .= esc_html__('Paypal', 'listingpro-plugin');
			$output .='</label>';
			$output .='</div>';
		}
		
		if($twocheckStatus==true){
			$output .='<div class="lp-method-wrap">';
			$output .='<label>';
			
			
			$output .='<div class="radio radio-danger">
								<input type="radio" name="plan" id="rd4" value="2checkout">
								<label for="rd4">
								 
								</label>
							</div>';
			
			if(!empty($twocheckout_img_url)){
				$output .= '<img src="'.esc_attr($twocheckout_img_url).'">';
			}
			else{
				$output .= '<img src="'.get_template_directory_uri().'/assets/images/2checkout-logo.png">';
			}
			$output .='</label>';
			$output .='</div>';
		}
		
		if($stripeStatus==true){
			$output .='<div class="lp-method-wrap">';
			$output .='<label>';
			
			
			$output .='<div class="radio radio-danger">
								<input type="radio" name="plan" id="rd3" value="stripe">
								<label for="rd3">
								 
								</label>
						</div>';
			
			if(!empty($stripe_img_url)){
				$output .= '<img src="'.esc_attr($stripe_img_url).'">';
			}
			else{
				$output .= '<img src="'.get_template_directory_uri().'/assets/images/stripe.png">';
			}
			//$output .= esc_html__('Stripe', 'listingpro-plugin');
			$output .='</label>';
			$output .='</div>';
		}
		
		if($wireStatus==false && $stripeStatus==false && $paypalStatus==false && $twocheckStatus==false){
			$output .= esc_html__('Sorry! You have not enable any payment method', 'listingpro-plugin');
		}
	$output .='</div>';
	$output .='</div>';
	$output .='<div class="lp-recurring-button-wrap"></div>';
