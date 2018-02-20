<?php 
require_once(ABSPATH . 'wp-admin/includes/screen.php');
//form submit
if( !empty($_POST['payment_submitt']) && isset($_POST['payment_submitt']) ){
	
	global $wpdb;
	$dbprefix = '';
	$dbprefix = $wpdb->prefix;
	$table_name = $dbprefix.'listing_orders';
	$order_id = '';
	$results = '';
	$order_id = $_POST['order_id'];
	$date = date('d-m-Y');
	$update_data = array('date' => $date, 'status' => 'success', 'used' => '1');
	$where = array('order_id' => $order_id);
	$update_format = array('%s', '%s');
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
		$wpdb->update($dbprefix.'listing_orders', $update_data, $where, $update_format);
	}
	
	$postid= $_POST['post_id'];
	$my_post;
	$listing_status = get_post_status( $postid );
	if($listingpro_options['listings_admin_approved']=="no" || $listing_status=="publish"){
		$my_post = array(
		  'ID'           => $postid,
		  'post_date'  => date("Y-m-d H:i:s"),
		  'post_status'   => 'publish',
		);
	}
	else{
		$my_post = array(
		  'ID'           => $postid,
		  'post_date'  => date("Y-m-d H:i:s"),
		  'post_status'   => 'pending',
		);
	}
	wp_update_post( $my_post );
	$ex_plan_id = listing_get_metabox_by_ID('Plan_id', $postid);
	$new_plan_id = listing_get_metabox_by_ID('changed_planid', $postid);
	if(!empty($new_plan_id)){
		if( $ex_plan_id != $new_plan_id ){
			lp_cancel_stripe_subscription($postid, $ex_plan_id);
			listing_set_metabox('Plan_id',$new_plan_id, $postid);
			listing_set_metabox('changed_planid','', $postid);
		}
	}
	  
	  if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
		$thepost = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM ".$dbprefix."listing_orders WHERE post_id = %d", $postid ) );
	  }
	  
	  $post_author_id = get_post_field( 'post_author', $postid );
	  $user = get_user_by( 'id', $post_author_id );
	  $useremail = $user->user_email;
	  
			$admin_email = '';
			$admin_email = get_option( 'admin_email' );
			
			$listing_id = $postid;
			$listing_title = get_the_title($postid);
			$invoice_no = $thepost->order_id;
			$payment_method = $thepost->payment_method;
			
			$plan_title = $thepost->plan_name;
			$plan_price = $thepost->price.$thepost->currency;
			$listing_url = get_the_permalink($listing_id);
			
			
			//to admin
			$mail_subject = $listingpro_options['listingpro_subject_purchase_activated_admin'];
			$website_url = site_url();
			$website_name = get_option('blogname');
			
			$formated_mail_subject = lp_sprintf2("$mail_subject", array(
				'website_url' => "$website_url",
				'website_name' => "$website_name"
			));

			$mail_content = $listingpro_options['listingpro_content_purchase_activated_admin'];
			
			$formated_mail_content = lp_sprintf2("$mail_content", array(
				'website_url' => "$website_url",
				'listing_title' => "$listing_title",
				'plan_title' => "$plan_title",
				'plan_price' => "$plan_price",
				'listing_url' => "$listing_url",
				'invoice_no' => "$invoice_no",
				'website_name' => "$website_name",
				'payment_method' => "$payment_method"
			));
			
			
			$headers1[] = 'Content-Type: text/html; charset=UTF-8';
			wp_mail( $admin_email, $formated_mail_subject, $formated_mail_content, $headers1);
			// to user
			
			$mail_subject2 = $listingpro_options['listingpro_subject_purchase_activated'];
			$website_url = site_url();
			
			$formated_mail_subject2 = lp_sprintf2("$mail_subject2", array(
				'website_url' => "$website_url",
				'website_name' => "$website_name"
			));

			$mail_content2 = $listingpro_options['listingpro_content_purchase_activated'];
			$formated_mail_content2 = lp_sprintf2("$mail_content2", array(
				'website_url' => "$website_url",
				'listing_title' => "$listing_title",
				'plan_title' => "$plan_title",
				'plan_price' => "$plan_price",
				'listing_url' => "$listing_url",
				'invoice_no' => "$invoice_no",
				'website_name' => "$website_name",
				'payment_method' => "$payment_method"
			));

			$headers[] = 'Content-Type: text/html; charset=UTF-8';
			wp_mail( $useremail, $formated_mail_subject2, $formated_mail_content2, $headers);
	
}


/* --------------------delete invoice data------------------- */
if( isset($_POST['delete_invoice']) && !empty($_POST['delete_invoice']) ){
	
	$main_id = $_POST['main_id'];
	if( !empty($main_id) ){
		$table = 'listing_orders';
		$where = array('main_id'=>$main_id);
		lp_delete_data_in_db($table, $where);
		
	}
	
}
			 
/*---------------------------------------------------
				adding invoice page
----------------------------------------------------*/

function listingpro_register_invocies_page() {
    add_menu_page(
        __( 'Listings Invoices', 'listingpro-plugin' ),
        'Invoices',
        'manage_options',
        'lp-listings-invoices',
        'listingpro_invoices_page',
        plugins_url( 'listingpro-plugin/images/invoices.png' ),
        30
    );
	wp_enqueue_style("panel_style", WP_PLUGIN_URL."/listingpro-plugin/assets/css/custom-admin-pages.css", false, "1.0", "all");
	
}
add_action( 'admin_menu', 'listingpro_register_invocies_page' );

if(!function_exists('listingpro_invoices_page')){
	function listingpro_invoices_page(){
										//adding css
									
									wp_enqueue_style('bootstrapcss', get_template_directory_uri() . '/assets/lib/bootstrap/css/bootstrap.min.css');
									wp_enqueue_script('bootstrapadmin', get_template_directory_uri() . '/assets/lib/bootstrap/js/bootstrap.min.js', 'jquery', '', true);
									global $wpdb;
									$dbprefix = '';
									$dbprefix = $wpdb->prefix;
									$table_name = $dbprefix.'listing_orders';
		?>
			<div class="wrap">
				<h2><?php esc_html_e('Listings Invoices', 'listingpro-plugin');  ?></h2>
						
						<ul class="nav nav-tabs">
						  <li class="active"><a data-toggle="tab" href="#paypal"><?php echo esc_html__('Paypal', 'listingpro-plugin'); ?></a></li>
						  <li><a data-toggle="tab" href="#stripe"><?php echo esc_html__('Stripe', 'listingpro-plugin'); ?></a></li>
						  <li><a data-toggle="tab" href="#wire"><?php echo esc_html__('Wire', 'listingpro-plugin'); ?></a></li>
						</ul>
						

						<div class="tab-content">
							
						<!--paypal-->	
						<div id="paypal" class="tab-pane fade in active">
						  
								<!-- inner tabs start -->
								<ul class="nav nav-tabs">
								  <li class="active">
										<a data-toggle="tab" href="#success"><?php echo esc_html__('Success', 'listingpro-plugin'); ?></a>
								 </li>
								  <li>
										<a data-toggle="tab" href="#pending"><?php echo esc_html__('Pending', 'listingpro-plugin'); ?></a>
								 </li>
								  <li>
										<a data-toggle="tab" href="#failed"><?php echo esc_html__('Failed', 'listingpro-plugin'); ?></a>
								 </li>
								</ul>
								
								<div class="tab-content">
									
									<div id="success" class="tab-pane fade in active">
										
										<?php 
											if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
												$results = get_invoices_list('', 'paypal', 'success') ;
												if(empty($results)){
													$results = get_invoices_list('', 'paypal', 'expired');
												}												
											}
										?>
											<?php if( !empty($results) && count($results) > 0 ){  ?>
												<?php $n=1; ?>
													<table class="wp-list-table widefat fixed striped posts">
														<thead>
															<tr>
																<th><?php echo esc_html__('No.', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('User', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Order#', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Plan', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Price', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Date', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Days', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Action', 'listingpro-plugin'); ?></th>
															</tr>
														</thead>
														
														<tbody>
															<?php foreach( $results as $data ){ 
															$author_obj = get_userdata($data->user_id);
															$user_login = $author_obj->user_login;
															
															$main_id = $data->main_id;
															?>
																<tr>
																	<td><?php echo $n; ?></td>
																	<td><?php echo $user_login; ?></td>
																	<td><?php echo $data->order_id; ?></td>
																	<td><?php echo $data->plan_name; ?></td>
																	<td><?php echo $data->price.$data->currency; ?></td>
																	<td><?php echo $data->date; ?></td>
																	<td><?php echo $data->days; ?></td>
																	<td>
																		<form class="wp-core-ui" method="post">
																			<input type="submit" name="delete_invoice" class="button action" value="<?php echo esc_html__('Delete', 'listingpro-plugin'); ?>" onclick="return window.confirm('Are you sure you want to proceed action?');" />
																			<input type="hidden" name="main_id" value="<?php echo $main_id; ?>" />
																		</form>
																	</td>
																</tr>
															<?php $n++; ?>
															<?php } ?>
															
														</tbody>
													</table>	
											
											<?php  } else{ ?>
													<p><?php echo esc_html__('Nothing in the list', 'listingpro-plugin'); ?></p>
											<?php } ?>
										
									</div>
									<!--success -->
									

									<div id="pending" class="tab-pane fade in">
										
										<?php 
											if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
												$results = get_invoices_list('', 'paypal', 'pending') ; 
											}
										 ?>
											<?php if( !empty($results) && count($results) > 0 ){  ?>
												<?php $n=1; ?>
													<table class="wp-list-table widefat fixed striped posts">
														<thead>
															<tr>
																<th><?php echo esc_html__('No.', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('User', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Order#', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Plan', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Price', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Date', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Days', 'listingpro-plugin'); ?></th>
															</tr>
														</thead>
														
														<tbody>
															<?php foreach( $results as $data ){ 
															$author_obj = get_userdata($data->user_id);
															$user_login = $author_obj->user_login;
															?>
																<tr>
																	<td><?php echo $n; ?></td>
																	<td><?php echo $user_login; ?></td>
																	<td><?php echo $data->order_id; ?></td>
																	<td><?php echo $data->plan_name; ?></td>
																	<td><?php echo $data->price.$data->currency; ?></td>
																	<td><?php echo $data->date; ?></td>
																	<td><?php echo $data->days; ?></td>
																</tr>
															<?php $n++; ?>
															<?php } ?>
															
														</tbody>
													</table>	
											
											<?php  } else{ ?>
													<p><?php echo esc_html__('Nothing in the list', 'listingpro-plugin'); ?></p>
											<?php } ?>
										
									</div>
									<!--pending -->
									

									<div id="failed" class="tab-pane fade in">
										
										<?php 
											if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
												$results = get_invoices_list('', 'paypal', 'failed') ;  
											}
										?>
											<?php if( !empty($results) && count($results) > 0 ){  ?>
												<?php $n=1; ?>
													<table class="wp-list-table widefat fixed striped posts">
														<thead>
															<tr>
																<th><?php echo esc_html__('No.', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('User', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Order#', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Plan', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Price', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Date', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Days', 'listingpro-plugin'); ?></th>
															</tr>
														</thead>
														
														<tbody>
															<?php foreach( $results as $data ){ 
															$author_obj = get_userdata($data->user_id);
															$user_login = $author_obj->user_login;
															?>
																<tr>
																	<td><?php echo $n; ?></td>
																	<td><?php echo $user_login; ?></td>
																	<td><?php echo $data->order_id; ?></td>
																	<td><?php echo $data->plan_name; ?></td>
																	<td><?php echo $data->price.$data->currency; ?></td>
																	<td><?php echo $data->date; ?></td>
																	<td><?php echo $data->days; ?></td>
																</tr>
															<?php $n++; ?>
															<?php } ?>
															
														</tbody>
													</table>	
											
											<?php  } else{ ?>
													<p><?php echo esc_html__('Nothing in the list', 'listingpro-plugin'); ?></p>
											<?php } ?>
										
									</div>
									<!--failed -->
									
								</div>
								<!-- inner tabs ends -->
						  
							</div>
						  <!--/paypal-->
						  	
						<!--stripe-->	
						<div id="stripe" class="tab-pane fade in">
						  
								<!-- inner tabs start -->
								<ul class="nav nav-tabs">
								  <li class="active">
										<a data-toggle="tab" href="#s-success"><?php echo esc_html__('Success', 'listingpro-plugin'); ?></a>
								 </li>
								  <li>
										<a data-toggle="tab" href="#s-pending"><?php echo esc_html__('Pending', 'listingpro-plugin'); ?></a>
								 </li>
								  <li>
										<a data-toggle="tab" href="#s-failed"><?php echo esc_html__('Failed', 'listingpro-plugin'); ?></a>
								 </li>
								</ul>
								
								<div class="tab-content">
									
									<div id="s-success" class="tab-pane fade in active">
										<?php 
											if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
												$results = get_invoices_list('', 'stripe', 'success') ;
												if(empty($results)){
													$results = get_invoices_list('', 'stripe', 'expired');
												}	
											}
										?>
											<?php if( !empty($results) && count($results) > 0 ){  ?>
												<?php $n=1; ?>
													<table class="wp-list-table widefat fixed striped posts">
														<thead>
															<tr>
																<th><?php echo esc_html__('No.', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('User', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Order#', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Plan', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Price', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Date', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Days', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Action', 'listingpro-plugin'); ?></th>
															</tr>
														</thead>
														
														<tbody>
															<?php foreach( $results as $data ){ 
															$author_obj = get_userdata($data->user_id);
															$user_login = $author_obj->user_login;
															$main_id = $data->main_id;
															?>
																<tr>
																	<td><?php echo $n; ?></td>
																	<td><?php echo $user_login; ?></td>
																	<td><?php echo $data->order_id; ?></td>
																	<td><?php echo $data->plan_name; ?></td>
																	<td><?php echo $data->price.$data->currency; ?></td>
																	<td><?php echo $data->date; ?></td>
																	<td><?php echo $data->days; ?></td>
																	<td>
																		<form class="wp-core-ui" method="post">
																			<input type="submit" name="delete_invoice" class="button action" value="<?php echo esc_html__('Delete', 'listingpro-plugin'); ?>" onclick="return window.confirm('Are you sure you want to proceed action?');" />
																			<input type="hidden" name="main_id" value="<?php echo $main_id; ?>" />
																		</form>
																	</td>
																</tr>
															<?php $n++; ?>
															<?php } ?>
															
														</tbody>
													</table>	
											
											<?php  } else{ ?>
													<p><?php echo esc_html__('Nothing in the list', 'listingpro-plugin'); ?></p>
											<?php } ?>
										
									</div>
									<!--success -->
									

									<div id="s-pending" class="tab-pane fade in">
										<?php 
											if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
												$results = get_invoices_list('', 'stripe', 'pending') ;  
											}
										?>
										<?php  ?>
											<?php if( !empty($results) && count($results) > 0 ){  ?>
												<?php $n=1; ?>
													<table class="wp-list-table widefat fixed striped posts">
														<thead>
															<tr>
																<th><?php echo esc_html__('No.', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('User', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Order#', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Plan', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Price', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Date', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Days', 'listingpro-plugin'); ?></th>
															</tr>
														</thead>
														
														<tbody>
															<?php foreach( $results as $data ){ 
															$author_obj = get_userdata($data->user_id);
															$user_login = $author_obj->user_login;
															?>
																<tr>
																	<td><?php echo $n; ?></td>
																	<td><?php echo $user_login; ?></td>
																	<td><?php echo $data->order_id; ?></td>
																	<td><?php echo $data->plan_name; ?></td>
																	<td><?php echo $data->price.$data->currency; ?></td>
																	<td><?php echo $data->date; ?></td>
																	<td><?php echo $data->days; ?></td>
																</tr>
															<?php $n++; ?>
															<?php } ?>
															
														</tbody>
													</table>	
											
											<?php  } else{ ?>
													<p><?php echo esc_html__('Nothing in the list', 'listingpro-plugin'); ?></p>
											<?php } ?>
										
									</div>
									<!--pending -->
									

									<div id="s-failed" class="tab-pane fade in">
										<?php 
											if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
												$results = get_invoices_list('', 'stripe', 'failed') ;  
											}
										?>
										<?php  ?>
											<?php if( !empty($results) && count($results) > 0 ){  ?>
												<?php $n=1; ?>
													<table class="wp-list-table widefat fixed striped posts">
														<thead>
															<tr>
																<th><?php echo esc_html__('No.', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('User', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Order#', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Plan', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Price', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Date', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Days', 'listingpro-plugin'); ?></th>
															</tr>
														</thead>
														
														<tbody>
															<?php foreach( $results as $data ){ 
															$author_obj = get_userdata($data->user_id);
															$user_login = $author_obj->user_login;
															?>
																<tr>
																	<td><?php echo $n; ?></td>
																	<td><?php echo $user_login; ?></td>
																	<td><?php echo $data->order_id; ?></td>
																	<td><?php echo $data->plan_name; ?></td>
																	<td><?php echo $data->price.$data->currency; ?></td>
																	<td><?php echo $data->date; ?></td>
																	<td><?php echo $data->days; ?></td>
																</tr>
															<?php $n++; ?>
															<?php } ?>
															
														</tbody>
													</table>	
											
											<?php  } else{ ?>
													<p><?php echo esc_html__('Nothing in the list', 'listingpro-plugin'); ?></p>
											<?php } ?>
										
									</div>
									<!--failed -->
									
								</div>
								<!-- inner tabs ends -->
						  
							</div>
						  <!--/stripe-->
						  
						  
						
							
						
						<div id="wire" class="tab-pane fade">
						  
							<!-- inner tabs start -->
							<ul class="nav nav-tabs">
							  <li class="active">
									<a data-toggle="tab" href="#wsuccess"><?php echo esc_html__('Success', 'listingpro-plugin'); ?></a>
							 </li>
							  <li>
									<a data-toggle="tab" href="#wpending"><?php echo esc_html__('Pending', 'listingpro-plugin'); ?></a>
							 </li>
							  <li>
									<a data-toggle="tab" href="#wfailed"><?php echo esc_html__('Failed', 'listingpro-plugin'); ?></a>
							 </li>
							</ul>
							
							<div class="tab-content">
								
								<div id="wsuccess" class="tab-pane fade in active">
									
									<?php 
											if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
												$results =  get_invoices_list('', 'wire', 'success');
												if(empty($results)){
													$results = get_invoices_list('', 'wire', 'expired');
												}	
											}
									?>
									<?php  ?>
										<?php if( !empty($results) && count($results) > 0 ){  ?>
											<?php $n=1; ?>
												<table class="wp-list-table widefat fixed striped posts">
													<thead>
															<tr>
																<th><?php echo esc_html__('No.', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('User', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Order#', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Plan', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Price', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Date', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Days', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Delete', 'listingpro-plugin'); ?></th>
															</tr>
														</thead>
													
													<tbody>
														<?php foreach( $results as $data ){ 
															$user_login = '';
															$author_obj = get_userdata($data->user_id);
															if(!empty($author_obj)){
																$user_login = $author_obj->user_login;
															}
															$main_id = $data->main_id;
														?>
															<tr>
																<td><?php echo $n; ?></td>
																<td><?php echo $user_login; ?></td>
																<td><?php echo $data->order_id; ?></td>
																<td><?php echo $data->plan_name; ?></td>
																<td><?php echo $data->price.$data->currency; ?></td>
																<td><?php echo $data->date; ?></td>
																<td><?php echo $data->days; ?></td>
																<td>
																	<form class="wp-core-ui" method="post">
																		<input type="submit" name="delete_invoice" class="button action" value="<?php echo esc_html__('Delete', 'listingpro-plugin'); ?>" onclick="return window.confirm('Are you sure you want to proceed action?');" />
																		<input type="hidden" name="main_id" value="<?php echo $main_id; ?>" />
																	</form>
																</td>
															</tr>
														<?php $n++; ?>
														<?php } ?>
														
													</tbody>
												</table>	
										
										<?php  } else{ ?>
												<p><?php echo esc_html__('Nothing in the list', 'listingpro-plugin'); ?></p>
										<?php } ?>
									
								</div>
								<!--success -->
								
								
								<div id="wpending" class="tab-pane fade in">
									
									<?php 
											if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
												$results =  get_invoices_list('', 'wire', 'pending'); 
											}
									?>
									<?php  ?>
										<?php if( !empty($results) && count($results) > 0 ){  ?>
											<?php $n=1; ?>
												<table class="wp-list-table widefat fixed striped posts">
													<thead>
															<tr>
																<th><?php echo esc_html__('No.', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('User', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Order#', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Plan', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Price', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Date', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Days', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Action', 'listingpro-plugin'); ?></th>
															</tr>
														</thead>
													
													<tbody>
														<?php foreach( $results as $data ){ 
															$author_obj = get_userdata($data->user_id);
															$user_login = $author_obj->user_login;
														?>
															<tr>
																<td><?php echo $n; ?></td>
																<td><?php echo $user_login; ?></td>
																<td><?php echo $data->order_id; ?></td>
																<td><?php echo $data->plan_name; ?></td>
																<td><?php echo $data->price.$data->currency; ?></td>
																<td><?php echo $data->date; ?></td>
																<td><?php echo $data->days; ?></td>
																<td>
																	<form class="wp-core-ui" id="confirm_payment" name="confirm_payment" method="post">
																		<input type="submit" name="payment_submitt" class="button action" value="Confirm" onclick="return window.confirm('Are you sure you want to proceed action?');" />
																		<input type="hidden" name="order_id" value="<?php echo $data->order_id ?>" />
																		<input type="hidden" name="post_id" value="<?php echo $data->post_id ?>" />
																	
																	</form>
																</td>
															</tr>
														<?php $n++; ?>
														<?php } ?>
														
													</tbody>
												</table>	
										
										<?php  } else{ ?>
												<p><?php echo esc_html__('Nothing in the list', 'listingpro-plugin'); ?></p>
										<?php } ?>
									
								</div>
								<!--pending -->
								
								
								<div id="wfailed" class="tab-pane fade in">
									
									<?php 
											if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
												$results =  get_invoices_list('', 'wire', 'failed');
											}
									?>
									<?php  ?>
										<?php if( !empty($results) && count($results) > 0 ){  ?>
											<?php $n=1; ?>
												<table class="wp-list-table widefat fixed striped posts">
													<thead>
															<tr>
																<th><?php echo esc_html__('No.', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('User', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Order#', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Plan', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Price', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Date', 'listingpro-plugin'); ?></th>
																<th><?php echo esc_html__('Days', 'listingpro-plugin'); ?></th>
															</tr>
														</thead>
													
													<tbody>
														<?php foreach( $results as $data ){ 
															$author_obj = get_userdata($data->user_id);
															$user_login = $author_obj->user_login;
														?>
															<tr>
																<td><?php echo $n; ?></td>
																<td><?php echo $user_login; ?></td>
																<td><?php echo $data->order_id; ?></td>
																<td><?php echo $data->plan_name; ?></td>
																<td><?php echo $data->price.$data->currency; ?></td>
																<td><?php echo $data->date; ?></td>
																<td><?php echo $data->days; ?></td>
															</tr>
														<?php $n++; ?>
														<?php } ?>
														
													</tbody>
												</table>	
										
										<?php  } else{ ?>
												<p><?php echo esc_html__('Nothing in the list', 'listingpro-plugin'); ?></p>
										<?php } ?>
									
								</div>
								<!--failed -->
								
								
								
						  
							
						  </div>
						  <!--/wire-->
						  
						</div>
						
			</div>
		<?php	
	}
}

//function to retreive invoices
if(!function_exists('get_invoices_list')){
	function get_invoices_list($userid, $method, $status){
		global $wpdb;
		$prefix = '';
		$prefix = $wpdb->prefix;
		$table_name = $prefix.'listing_orders';
		
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
			
			if( empty($userid)  && !empty($method) && !empty($status) && is_admin() ){
				//return on admin side
				$results = $wpdb->get_results( 
								$wpdb->prepare("SELECT * FROM {$prefix}listing_orders WHERE payment_method=%s AND status=%s ORDER BY main_id DESC", $method, $status) 
							 );
				return $results;
			}
			else if( !empty($userid) && isset($userid) && !empty($status) && !is_admin() ){
				//return on front side
				
				$results = $wpdb->get_results( 
								$wpdb->prepare("SELECT * FROM {$prefix}listing_orders WHERE user_id=%d AND status=%s ORDER BY main_id DESC", $userid, $status) 
							 );
				return $results;
				
			}
			
		}
	}
}

?>