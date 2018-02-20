<?php 
require_once(ABSPATH . 'wp-admin/includes/screen.php');
//form submit
if( !empty($_POST['subscr_id']) && isset($_POST['subscr_id']) ){
	$subscrip_id = $_POST['subscr_id'];
	$uid = $_POST['subscriber_id'];
	global $listingpro_options;
	require_once THEME_PATH . '/include/stripe/stripe-php/init.php';
	$strip_sk = $listingpro_options['stripe_secrit_key'];
	\Stripe\Stripe::setApiKey($strip_sk);
	$subscription = \Stripe\Subscription::retrieve($subscrip_id);
	$subscription->cancel();
	$userSubscriptions = get_user_meta($uid, 'listingpro_user_sbscr', true);
	if(!empty($userSubscriptions)){
		foreach($userSubscriptions as $key=>$subscription){
			$subscr_id = $subscription['subscr_id'];
			$subscr_listing_id = $subscription['listing_id'];
						
			$my_listing_post = array();
			$my_listing_post['ID'] = $subscr_listing_id;
			$my_listing_post['post_status'] = 'expired';
			wp_update_post( $my_listing_post );
			
			if($subscr_id == $subscrip_id){
				unset($userSubscriptions[$key]);
				$headers[] = 'Content-Type: text/html; charset=UTF-8';
				/* user email */
				$author_obj = get_user_by('id', $uid);
				$user_email = $author_obj->user_email;
				$usubject = $listingpro_options['listingpro_subject_cancel_subscription'];
				$ucontent = $listingpro_options['listingpro_content_cancel_subscription'];
				wp_mail( $user_email, $usubject, $ucontent, $headers );
				/* admin email */
				$adminemail = get_option('admin_email');
				$asubject = $listingpro_options['listingpro_subject_cancel_subscription_admin'];
				$acontent = $listingpro_options['listingpro_content_cancel_subscription_admin'];
				wp_mail( $adminemail, $asubject, $acontent, $headers );
			}																						
		}
	}
	/* removing user meta */
	if(!empty($userSubscriptions)){
		update_user_meta($uid, 'listingpro_user_sbscr', $userSubscriptions);
	}
	else{
		delete_user_meta($uid, 'listingpro_user_sbscr');
	}
	/* end removing user meta */
	
}

			 
/*---------------------------------------------------
				adding invoice page
----------------------------------------------------*/

function listingpro_register_subscription_page() {
    add_menu_page(
        __( 'Subscriptions', 'listingpro-plugin' ),
        'Subscription',
        'manage_options',
        'lp-listings-subscription',
        'listingpro_subscription_page',
        plugins_url( 'listingpro-plugin/images/icon-subscr.png' ),
        30
    );
	wp_enqueue_style("panel_style", WP_PLUGIN_URL."/listingpro-plugin/assets/css/custom-admin-pages.css", false, "1.0", "all");
	
}
add_action( 'admin_menu', 'listingpro_register_subscription_page' );

if(!function_exists('listingpro_subscription_page')){
	function listingpro_subscription_page(){
										//adding css
									
									wp_enqueue_style('bootstrapcss', get_template_directory_uri() . '/assets/lib/bootstrap/css/bootstrap.css');
									wp_enqueue_script('bootstrapadmin', get_template_directory_uri() . '/assets/lib/bootstrap/js/bootstrap.min.js', 'jquery', '', true);
									global $listingpro_options;
									$userSubscriptions;
									$subscription_exist = false;
									require_once THEME_PATH . '/include/stripe/stripe-php/init.php';
									$strip_sk = $listingpro_options['stripe_secrit_key'];
									\Stripe\Stripe::setApiKey($strip_sk);
									$currency = listingpro_currency_sign();
		?>
			<div class="wrap">
				<h2><?php esc_html_e('Users Subscriptions', 'listingpro-plugin');  ?></h2>
	<?php 
		$users = get_users( array( 'fields' => array( 'ID' ) ) );
	?>
				<table class="wp-list-table widefat fixed striped posts">
					<thead>
						<tr>
							<th><?php esc_html_e('No.','listingpro'); ?></th>
							<th><?php esc_html_e('User','listingpro'); ?></th>
							<th><?php esc_html_e('Subscription','listingpro'); ?></th>
							<th><?php esc_html_e('Price','listingpro'); ?></th>
							<th><?php esc_html_e('Upcoming renewal','listingpro'); ?></th>
							<th><?php esc_html_e('Action','listingpro'); ?></th>
						</tr>
					</thead>
					
					<tbody>
						<?php
							foreach($users as $user_id){
								$user_id = $user_id->ID;
								$user_obj = get_user_by('id', $user_id);
								$user_login = $user_obj->user_login;
								$userSubscriptions = '';
								$userSubscriptions = get_user_meta($user_id, 'listingpro_user_sbscr', true);
								
								if(!empty($userSubscriptions) && count($userSubscriptions)>0 ) {
									$subscription_exist = true;
									$n=1;
									foreach($userSubscriptions as $subscription){
										try {	
											$plan_id = $subscription['plan_id'];
											$subscr_id = $subscription['subscr_id'];
											$subscrObj = \Stripe\Subscription::retrieve($subscr_id);
											$subscrID = $subscrObj->id;
											$taxStatus = '';
											$planStripe = $subscrObj->plan;
											$stripePrice = $planStripe->amount;
											$plan_title = get_the_title($plan_id);
											$plan_price = get_post_meta($plan_id, 'plan_price', true); 
											if($stripePrice==$plan_price){
												$taxStatus = esc_html__('exc. tax', 'listingpro-plugin');
											}
											else{
												$plan_price = (float)$stripePrice/100;
												$plan_price = round($plan_price, 2);
												$taxStatus = esc_html__('inc. tax', 'listingpro-plugin');
											}
											?>
											
											
											<tr>
												<td><?php echo $n; ?></td>
												<td><?php echo $user_login; ?></td>
												<td><?php echo $subscrID; ?></td>
												<td><?php echo $plan_price.$currency." ($taxStatus)"; ?></td>
												<td><?php echo date("F j, Y", $subscrObj->current_period_end); ?></td>
												<td>
													<form class="wp-core-ui" id="subscription_cancel" name="subscription_cancel" method="post">
														<input type="submit" name="subscription_cancel_submit" class="button action" value="<?php echo esc_html__('Unsubscribe', 'listingpro'); ?>" onclick="return window.confirm('<?php echo esc_html__('Are you sure you want to proceed action?', 'listingpro-plugin'); ?>');">
														<input type="hidden" name="subscr_id" value="<?php echo $subscrID; ?>">
														<input type="hidden" name="subscriber_id" value="<?php echo $user_id; ?>">
													</form>
												</td>
												
											</tr>
											
										<?php
											$n++;
										}catch (Exception $e) {
											
										}
									}
								} 
							}
						?>
					</tbody>
				</table>
				<?php
					if($subscription_exist==false){
						echo '<p>'.esc_html('Sorry! There is no subscription yet', 'listingpro-plugin').'<p>';
					}
				?>
			</div>
<?php
	}
}
?>