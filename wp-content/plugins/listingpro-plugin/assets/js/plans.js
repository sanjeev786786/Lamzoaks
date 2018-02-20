/*-----------------------------------------------------------------------------------*/
/*	Plans Script
/*-----------------------------------------------------------------------------------*/

  jQuery(function() {
	  
	jQuery('#plan_package_type').change(function(){
		var selected = jQuery('#plan_package_type option:selected').text();
		if(selected==="Pay Per Listing"){
			jQuery('#plan_text_box').hide();
		}
		else{
			jQuery('#plan_text_box').show();
		}
		
	});
	
	
  });
  
  jQuery(document).ready(function($){
		var selected = jQuery('#plan_package_type option:selected').text();
		if(selected==="Pay Per Listing"){
			jQuery('#plan_text_box').hide();
		}
		else{
			jQuery('#plan_text_box').show();
		}
	
  });
  

  