<?php
 
	function load_plans_scripts(){
			$screen = get_current_screen();
			$pageTitle = '';
			$pageTitle = $screen->id;
			if(!empty($pageTitle) && $pageTitle=="price_plan"){
				wp_register_script( 'plans', plugins_url( '/assets/js/plans.js', plugin_dir_path( __FILE__ ) ), array( 'jquery' ) );
				wp_enqueue_script( 'plans' );
			}
		}
	add_action( 'admin_enqueue_scripts', 'load_plans_scripts' );
		
	add_action( 'add_meta_boxes', 'plan_package_type' );
	function plan_package_type() {
	    add_meta_box( 
	        'plan_package_type',
	        __( 'Select Package Type', 'listingpro-plugin' ),
	        'plan_type_package',
	        'price_plan'
	    );
	}

	function plan_type_package( $post ) {

		$plan_package_type = get_post_meta( $post->ID, 'plan_package_type', true );

		echo '<label for="plan_package_type"></label>';
		
		echo '<select name="plan_package_type" id="plan_package_type">';
		
		if( !empty ( $plan_package_type ) ){
			
			if( $plan_package_type=="Pay Per Listing" ){
				
				echo '<option value="Package">'.esc_html__('Package', 'listingpro-plugin').'</option>';
				echo '<option value="Pay Per Listing" selected>'.esc_html__('Pay Per Listing', 'listingpro-plugin').'</option>';
				
			}
			else if( $plan_package_type=="Package" ){
				echo '<option value="Package" selected>'.esc_html__('Package', 'listingpro-plugin').'</option>';
				echo '<option value="Pay Per Listing">'.esc_html__('Pay Per Listing', 'listingpro-plugin').'</option>';
			}
			
		}
		else{
			echo '<option value="Pay Per Listing">'.esc_html__('Pay Per Listing', 'listingpro-plugin').'</option>';
			echo '<option value="Package">'.esc_html__('Package', 'listingpro-plugin').'</option>';
		}
		
		echo '</select>';
		
	}


	add_action( 'save_post', 'plan_package_type_save' );
	function plan_package_type_save( $post_id ) {		
		
		$post_type = get_post_type($post_id);
		if ( "price_plan" != $post_type ){
			return;
		}
		else{
			global $plan_package_type;

			if(isset($_POST["plan_package_type"]))
			$plan_package_type = $_POST['plan_package_type'];
			update_post_meta( $post_id, 'plan_package_type', $plan_package_type );
		}

	}
	
	
		
	
	add_action( 'add_meta_boxes', 'plan_text_box' );
	function plan_text_box() {
	    add_meta_box( 
	        'plan_text_box',
	        __( 'Enter no. of post in the package', 'listingpro-plugin' ),
	        'plan_text_content',
	        'price_plan'
	    );
	}

	function plan_text_content( $post ) {

		$plan_text = get_post_meta( $post->ID, 'plan_text', true );

		echo '<label for="plan_text"></label>';
		echo '<input type="text" id="plan_text" name="plan_text" placeholder="'.esc_html__('Total Posts in Package', 'listingpro-plugin' ).'" value="';
		echo $plan_text; 
		echo '">';
		
	}


	add_action( 'save_post', 'plan_text_save' );
	function plan_text_save( $post_id ) {		
		$post_type = get_post_type($post_id);
		if ( "price_plan" != $post_type ){
			return;
		}
		else{
			global $plan_text;

			if(isset($_POST["plan_text"]))
			$plan_text = $_POST['plan_text'];
			update_post_meta( $post_id, 'plan_text', $plan_text );
		}

	}
	
	//Title color option for meta boxs starts
	add_action( 'add_meta_boxes', 'plan_color_box' );
	function plan_color_box() {
	    add_meta_box( 
	        'plan_color_box',
	        __( 'Select color for the title background box', 'listingpro-plugin' ),
	        'plan_title_content_color',
	        'price_plan'
	    );
	}
	function plan_title_content_color( $post ) {

		$plan_title_color = get_post_meta( $post->ID, 'plan_title_color', true );

		echo '<label for="plan_title_color"></label>';
		echo '<input type="color" id="plan_title_color" name="plan_title_color"  value="';
		echo $plan_title_color; 
		echo '">';
		
	}
	add_action( 'save_post', 'plan_text_save_color' );
	function plan_text_save_color( $post_id ) {		
		$post_type = get_post_type($post_id);
		if ( "price_plan" != $post_type ){
			return;
		}
		else{
			global $plan_title_color;

			if(isset($_POST["plan_title_color"]))
			$plan_title_color = $_POST['plan_title_color'];
			update_post_meta( $post_id, 'plan_title_color', $plan_title_color );
		}
	}
	//Title color option for meta boxs endeds

	
		
	add_action( 'add_meta_boxes', 'plan_price_box' );
	function plan_price_box() {
	    add_meta_box( 
	        'plan_price_box',
	        __( 'Price (Do not use currency sign)(Empty field will be considered as free plan. Free plan option only works in "Pay per Listing" )', 'listingpro-plugin' ),
	        'plan_price_content',
	        'price_plan'
	    );
	}

	function plan_price_content( $post ) {

		$plan_price = get_post_meta( $post->ID, 'plan_price', true );

		echo '<label for="plan_price"></label>';
		echo '<input type="text" id="plan_price" name="plan_price" placeholder="" value="';
		echo $plan_price; 
		echo '">';
		
	}


	add_action( 'save_post', 'plan_price_save' );
	function plan_price_save( $post_id ) {		
		$post_type = get_post_type($post_id);
		if ( "price_plan" != $post_type ){
			return;
		}
		else{
			global $plan_price;

			if(isset($_POST["plan_price"]))
			$plan_price = $_POST['plan_price'];
			update_post_meta( $post_id, 'plan_price', $plan_price );
		}

	}



	add_action( 'add_meta_boxes', 'plan_time_box' );
	function plan_time_box() {
	    add_meta_box( 
	        'plan_time_box',
	        __( 'Duration( in days )', 'listingpro-plugin' ),
	        'plan_time_content',
	        'price_plan'
	    );
	}

	function plan_time_content( $post ) {

		$plan_time = get_post_meta( $post->ID, 'plan_time', true );

		echo '<label for="plan_time"></label>';
		echo '<input type="text" id="plan_time" name="plan_time" placeholder="Leave empty for unlimited" value="';
		echo $plan_time; 
		echo '">';
		
	}


	add_action( 'save_post', 'plan_time_save' );
	function plan_time_save( $post_id ) {		
		
		$post_type = get_post_type($post_id);
		if ( "price_plan" != $post_type ){
			return;
		}
		else{
			global $plan_time;

			if(isset($_POST["plan_time"]))
			$plan_time = $_POST['plan_time'];
			update_post_meta( $post_id, 'plan_time', $plan_time );
		}

	}	
	

	add_action( 'add_meta_boxes', 'plan_free_continue' );
	function plan_free_continue() {
	    add_meta_box( 
	        'plan_free_continue',
	        __( 'Continue free plan after expire', 'listingpro-plugin' ),
	        'free_plan_continue_content',
	        'price_plan'
	    );
	}

	function free_plan_continue_content( $post ) {

		$f_plan_continue = get_post_meta( $post->ID, 'f_plan_continue', true );
		$checked = '';
		if($f_plan_continue == 'true'){
			$checked = 'checked';
		}
		
		echo '<input '.$checked.' type="checkbox" id="f_plan_continue" name="f_plan_continue" value="';
		echo wp_kses_post($f_plan_continue); 
		echo '">';
		echo '<label for="f_plan_continue">  Check if you want users to continue with free plan after "Expire". This option only works with free plan</label><br/>';
		
	}

	add_action( 'save_post', 'plan_free_save' );
	function plan_free_save( $post_id ) {

		$post_type = get_post_type($post_id);
		if ( "price_plan" != $post_type ){
			return;
		}
		else{

			if(isset($_POST["f_plan_continue"])){
				update_post_meta( $post_id, 'f_plan_continue', 'true' );
			}
			else{
				update_post_meta( $post_id, 'f_plan_continue', 'false' );
			}
		}
	}
	
	add_action( 'add_meta_boxes', 'plan_hot_box' );
	function plan_hot_box() {
	    add_meta_box( 
	        'plan_hot_box',
	        __( 'Hot Plan', 'listingpro-plugin' ),
	        'plan_hot_content',
	        'price_plan'
	    );
	}

	function plan_hot_content( $post ) {

		$plan_hot = get_post_meta( $post->ID, 'plan_hot', true );
		$checked = '';
		if($plan_hot == 'true'){
			$checked = 'checked';
		}
		
		echo '<input '.$checked.' type="checkbox" id="plan_hot" name="plan_hot" value="';
		echo wp_kses_post($plan_hot); 
		echo '">';
		echo '<label for="plan_hot">  Check if you want to make this plan "Hot"</label><br/>';
		
	}


	add_action( 'save_post', 'plan_hot_save' );
	function plan_hot_save( $post_id ) {

		$post_type = get_post_type($post_id);
		if ( "price_plan" != $post_type ){
			return;
		}
		else{

			if(isset($_POST["plan_hot"])){
				update_post_meta( $post_id, 'plan_hot', 'true' );
			}
			else{
				update_post_meta( $post_id, 'plan_hot', 'false' );
			}
		}
	}	
		
		
		
		
		
	add_action( 'add_meta_boxes', 'plan_contact_box' );
	function plan_contact_box() {
		$screens = array( 'price_plan');
		foreach ( $screens as $screen ) {
			add_meta_box( 
				'plan_contact_box',
				__( 'Ad Posting options', 'listingpro-plugin' ),
				'plan_contact_content',
				$screen,
				 'normal',
				'high'
			);
		}
	}
	
	
		function plan_contact_content( $post ) {

		$contact_show = get_post_meta( $post->ID, 'contact_show', true );
		$checked = '';
		if($contact_show == 'true'){
			$checked = 'checked';
		}
		
		echo '<input '.$checked.' type="checkbox" id="contact_show" name="contact_show" value="';
		echo wp_kses_post($contact_show); 
		echo '">';
		echo '<label for="contact_show">  Check it if you want to allow user to show his <b>contact information</b></label><br/>';
		
		$map_show = get_post_meta( $post->ID, 'map_show', true );
		$checked = '';
		if($map_show == 'true'){
			$checked = 'checked';
		}
		echo '<input '.$checked.' type="checkbox" id="map_show" name="map_show" value="';
		echo wp_kses_post($map_show); 
		echo '">';
		echo '<label for="map_show">  Check it if you want to allow user to show his <b>Google map</b></label><br/>';
		
		$video_show = get_post_meta( $post->ID, 'video_show', true );
		$checked = '';
		if($video_show == 'true'){
			$checked = 'checked';
		}
		echo '<input '.$checked.' type="checkbox" id="video_show" name="video_show" value="';
		echo wp_kses_post($video_show); 
		echo '">';
		echo '<label for="video_show">  Check it if you want to allow user to show his Ad <b>video</b></label><br/>';
		
		$gallery_show = get_post_meta( $post->ID, 'gallery_show', true );
		$checked = '';
		if($gallery_show == 'true'){
			$checked = 'checked';
		}
		echo '<input '.$checked.' type="checkbox" id="gallery_show" name="gallery_show" value="';
		echo wp_kses_post($gallery_show); 
		echo '">';
		echo '<label for="gallery_show">  Check it if you want to allow user to show his <b>Gallery</b></label><br/>';
		
		$meta_value_tagline = get_post_meta( $post->ID, 'listingproc_tagline', true );
		$checked = '';
		if($meta_value_tagline == 'true'){
			$checked = 'checked';
		}
		?>
		<input <?php echo $checked; ?> type="checkbox" name="listingproc_tagline" value="<?php echo wp_kses_post($meta_value_tagline); ?>" />
		<label> Check it if you want to allow user to add <b>Tagline</b></label>
		<br/>

		<?php
		$meta_value_location = get_post_meta( $post->ID, 'listingproc_location', true ); 
		$checked = '';
		if($meta_value_location == 'true'){
			$checked = 'checked';
		}
		?>
		<input <?php echo $checked ?> type="checkbox" name="listingproc_location" value="<?php echo wp_kses_post($meta_value_location) ?>" />
		<label> Check it if you want to allow user to add <b>Location.</b></label>
		<br/>

		<?php
		$meta_value_web = get_post_meta( $post->ID, 'listingproc_website', true ); 
		$checked = '';
		if($meta_value_web == 'true'){
			$checked = 'checked';
		}
		?>
		<input <?php echo $checked ?> type="checkbox" name="listingproc_website" value="<?php echo wp_kses_post($meta_value_web); ?>"/>
		<label>Check it if you want to allow user to add <b>Website.</b></label>
		<br />

		<?php
		$meta_value_social     = get_post_meta( $post->ID, 'listingproc_social', true );
		$checked = '';
		if($meta_value_social == 'true'){
			$checked = 'checked';
		}
		?>
		<input <?php echo $checked ?> type="checkbox" name="listingproc_social" value="<?php echo wp_kses_post($meta_value_social); ?>" />
		<label>Check it if you want to allow user to add <b>Social Media links.</b></label>
		<br />

		<?php
		$meta_value_faq     = get_post_meta( $post->ID, 'listingproc_faq', true );
		$checked = '';
		if($meta_value_faq == 'true'){
			$checked = 'checked';
		}
		?>
		<input <?php echo $checked ?> type="checkbox" name="listingproc_faq" value="<?php echo wp_kses_post($meta_value_faq); ?>" />
		<label>Check it if you want to allow user to add <b>FAQs list.</b></label>
		<br />

		<?php
		$meta_value_price     = get_post_meta( $post->ID, 'listingproc_price', true );
		$checked = '';
		if($meta_value_price == 'true'){
			$checked = 'checked';
		}
		?>
		<input <?php echo $checked ?> type="checkbox" name="listingproc_price" value="<?php echo wp_kses_post($meta_value_price); ?>" />
		<label>Check it if you want to allow user to add <b>Price Range.</b></label>
		<br />

		<?php
		$meta_value_tag_key     = get_post_meta( $post->ID, 'listingproc_tag_key', true );
		$checked = '';
		if($meta_value_tag_key == 'true'){
			$checked = 'checked';
		}
		?>
		<input <?php echo $checked ?> type="checkbox" name="listingproc_tag_key" value="<?php echo wp_kses_post($meta_value_tag_key); ?>"/>
		<label>Check it if you want to allow user to add <b>Tags or Keywords.</b></label>
		<br />

		<?php
		$meta_value_bhours     = get_post_meta( $post->ID, 'listingproc_bhours', true );
		$checked = '';
		if($meta_value_bhours == 'true'){
			$checked = 'checked';
		}
		?>
		<input <?php echo $checked ?> type="checkbox" name="listingproc_bhours" value="<?php echo wp_kses_post($meta_value_bhours); ?>" />
		<label>Check it if you want to allow user to add <b>Business Hours.</b></label>
		
		<?php
		
	}

	add_action( 'save_post', 'plan_contact_box_save' );
	function plan_contact_box_save( $post_id ) {

		$post_type = get_post_type($post_id);
		if ( "price_plan" != $post_type ){
			return;
		}
		else{
		
			if(isset($_POST["contact_show"])){
			update_post_meta( $post_id, 'contact_show', 'true' );
			}else{
			update_post_meta( $post_id, 'contact_show', 'false' );
			}
			
			if(isset($_POST["map_show"])){
			update_post_meta( $post_id, 'map_show', 'true' );
			}else{
			update_post_meta( $post_id, 'map_show', 'false' );
			}
			
			if(isset($_POST["video_show"])){
			update_post_meta( $post_id, 'video_show', 'true' );
			}else{
			update_post_meta( $post_id, 'video_show', 'false' );
			}
			
			if(isset($_POST["gallery_show"])){
			update_post_meta( $post_id, 'gallery_show', 'true' );
			}else{
			update_post_meta( $post_id, 'gallery_show', 'false' );
			}
			
			if(isset($_POST["gallery_show"])){
			update_post_meta( $post_id, 'gallery_show', 'true' );
			}else{
			update_post_meta( $post_id, 'gallery_show', 'false' );
			}
			
			
			if(isset($_POST["listingproc_tagline"])){
			update_post_meta( $post_id, 'listingproc_tagline', 'true' );
			}else{
			update_post_meta( $post_id, 'listingproc_tagline', 'false' );
			}
			
			if(isset($_POST["listingproc_location"])){
			update_post_meta( $post_id, 'listingproc_location', 'true' );
			}else{
			update_post_meta( $post_id, 'listingproc_location', 'false' );
			}
			
			if(isset($_POST["listingproc_website"])){
			update_post_meta( $post_id, 'listingproc_website', 'true' );
			}else{
			update_post_meta( $post_id, 'listingproc_website', 'false' );
			}
			
			if(isset($_POST["listingproc_social"])){
			update_post_meta( $post_id, 'listingproc_social', 'true' );
			}else{
			update_post_meta( $post_id, 'listingproc_social', 'false' );
			}
			
			if(isset($_POST["listingproc_faq"])){
			update_post_meta( $post_id, 'listingproc_faq', 'true' );
			}else{
			update_post_meta( $post_id, 'listingproc_faq', 'false' );
			}
			
			if(isset($_POST["listingproc_price"])){
			update_post_meta( $post_id, 'listingproc_price', 'true' );
			}else{
			update_post_meta( $post_id, 'listingproc_price', 'false' );
			}
			
			if(isset($_POST["listingproc_tag_key"])){
			update_post_meta( $post_id, 'listingproc_tag_key', 'true' );
			}else{
			update_post_meta( $post_id, 'listingproc_tag_key', 'false' );
			}
			
			if(isset($_POST["listingproc_bhours"])){
			update_post_meta( $post_id, 'listingproc_bhours', 'true' );
			}else{
			update_post_meta( $post_id, 'listingproc_bhours', 'false' );
			}
			
		}
	}	