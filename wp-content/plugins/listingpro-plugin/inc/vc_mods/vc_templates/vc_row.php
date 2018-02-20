<?php
extract(shortcode_atts(array(
	'row_id'                => '',
	'class'                 => '',
	'row_title'                 => '',
	'row_desc'                 => '',
	'row_type'              => 'row_center_content',
	'title_color'              => '',
	'desc_color'              => '',
	'bg_color'              => '',
	'bg_image'              => '',
	'bg_repeat'             => '',
	'bg_attatch'             => '',
	'disable_element'             => 'no',
	
), $atts));

wp_enqueue_style( 'js_composer_front' );
wp_enqueue_script( 'wpb_composer_front_js' );
wp_enqueue_style('js_composer_custom_css');

// Row ID
$custom_row_id    = (!empty($row_id)) ? $row_id : uniqid("lp_");
$custom_row_class = (!empty($class)) ? $class : '';

// Row Type

$row_center_content = null;

if ( !empty($row_type) && $row_type == 'row_center_content' ) {
	$row_center_content = 'container';
} else {
	$row_center_content = '';
}


$row_css = array();
 
		if ( $bg_color ) {
			$row_css[] = 'background-color: '. $bg_color .';';
		}

		if ( $bg_image ) {
			$img_url = wp_get_attachment_url($bg_image);
			$row_css[] = 'background-image: url('. $img_url .');';
		}


		if ( $bg_repeat ) {
			$row_css[] = 'background-repeat: '. $bg_repeat .';';
		}
		if ( $bg_attatch ) {
			$row_css[] = 'background-attachment: '. $bg_attatch .';';
		}

$row_css = implode('', $row_css);

if ( $row_css ) {
	$row_css = wp_kses( $row_css, array() );
	$row_css = ' style="' . esc_attr($row_css) . '"';
}


$rowHeading = '';

$DisplayRow = '';
if($disable_element == 'yes'){
	$DisplayRow = 'style="display:none"';
}
	
// Start VC Row
echo '
<div '.$DisplayRow.' id="'.$custom_row_id.'" class="lp-section-row '. $class .'">';	

		// Row Wrapper
		echo '
		<div class="lp_section_inner  clearfix '. $row_center_content .'" '. $row_css.'>';
		
		if($row_center_content == ''){
			echo '<div class="container">';
		}

			// Row Inner
			echo '<div class="row lp-section-content clearfix">';
			
			if(!empty($row_title) || !empty($row_desc)){
				echo '<div class="lp-section-title-container text-center ">';
				
				if(!empty($row_title)){
					echo '<h1 style="color:'.$title_color.'">'.$row_title.'</h1>';
				}
				if(!empty($row_desc)){
					echo '<div style="color:'.$desc_color.'" class="lp-sub-title">'.$row_desc.'</div>';
				}
						
				echo '</div>';
			}
				echo do_shortcode($content);

			echo '</div>';
			
			if($row_center_content == ''){
				echo '</div>';
			}

		echo '
		</div>';

echo '
</div>';
