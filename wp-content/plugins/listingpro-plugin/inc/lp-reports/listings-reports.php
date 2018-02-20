<?php
/*---------------------------------------------------
				listings reports page
----------------------------------------------------*/

/* post form code */
if( isset($_POST['listing_id']) && isset($_POST['lp_listing_report_submit']) ){
	
	$listing_id = $_POST['listing_id'];
	if(!empty($listing_id)){
	  $review_post = array(
		  'ID'           => $listing_id,
		  'post_status' => 'reported',
	  );
	  wp_update_post( $review_post );
	  
	  listing_set_metabox('listing_reported', '', $listing_id);
	  listing_set_metabox('listing_reported_by', '', $listing_id);
	  
	  if ( get_option( 'lp_reported_listings' ) !== false ) {
								$reportedLisingsArray = array();
								$delReview = array();
								$reportedLisings = get_option( 'lp_reported_listings' );
								if( strpos($reportedLisings, ',') !== false ){
									$reportedLisingsArray = explode(",",$reportedLisings);
								}else{
									$reportedLisingsArray[] = $reportedLisings;
									
								}
								
								$delReview[] = $listing_id;
								$result=array_diff($reportedLisingsArray,$delReview);
								if(!empty($result)){
									$newRevieids = implode(",",$result);
									update_option( 'lp_reported_listings', $newRevieids );
								}
								else{
									delete_option( 'lp_reported_listings' );
								}
	  }
	  
	}
	
}
/* end post form code */




if(!function_exists('listingpro_flags_page')){
	function listingpro_flags_page(){
										//adding css
									
									wp_enqueue_style('bootstrapcss', get_template_directory_uri() . '/assets/lib/bootstrap/css/bootstrap.min.css');
									wp_enqueue_script('bootstrapadmin', get_template_directory_uri() . '/assets/lib/bootstrap/js/bootstrap.min.js', 'jquery', '', true);
	?>
		<div class="wrap">
			<h2><?php esc_html_e('Listing Reports', 'listingpro-plugin');?></h2>
			<?php
				global $paged;
				if ( get_option( 'lp_reported_listings' ) !== false ) {
						$reportedLisings = get_option( 'lp_reported_listings' );
						$ReportedLisints = array();
						if( strpos($reportedLisings, ',') !== false ){
							$ReportedLisints = explode(",",$reportedLisings);
						}else{
							$ReportedLisints[] = $reportedLisings;
							
						}
						$wp_query = new WP_Query( 
							array( 
								'post_type' => 'listing', 
								'post__in' => $ReportedLisints,
								'post_status' => 'publish',
								'posts_per_page' => 8,
								'paged' => $paged,
							) 
						);
						if ( $wp_query->have_posts() ) { ?>
							<table class="table table-striped">
								<thead>
								  <tr>
									<th><?php echo esc_html__('Listing Title', 'listingpro-plugin'); ?></th>
									<th><?php echo esc_html__('Author', 'listingpro-plugin'); ?></th>
									<th><?php echo esc_html__('Reported For', 'listingpro-plugin'); ?></th>
									<th><?php echo esc_html__('Action', 'listingpro-plugin'); ?></th>
								  </tr>
								</thead>
								<tbody>
						<?php
										$confirmMsg = esc_html__('Are you sure you want to proceed?', 'listingpro-plugin');
										while ( $wp_query->have_posts() ) {
											$wp_query->the_post();
											$reportedCount = listing_get_metabox_by_ID('listing_reported', get_the_ID());
											echo '<tr>';
												echo '<td>'.get_the_title().'</td>';
												echo '<td>'.get_the_author().'</td>';
												echo '<td>'.$reportedCount. ' '.esc_html__('Time', 'listingpro-plugin').'</td>';
												echo '<td><form class="wp-core-ui" method="post">
												<input type="submit" name="lp_listing_report_submit" class="button action" value="'.esc_html__('Confirm', 'listingpro-plugin').'">
												<input type="hidden" name="listing_id" value="'.get_the_ID().'">
												</form></td>';
											echo '</tr>';
											wp_reset_postdata();
										}
										
							
							echo listingpro_pagination();							
						}
						
				}
				else{
					?>
					<p>
					<?php esc_html_e('Sorry! There is no report found', 'listingpro-plugin');?>
					</p>
					<?php
				}
			?>
			
		</div>

<?php
	}
}
?>
