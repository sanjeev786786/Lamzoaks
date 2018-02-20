jQuery(document).ready(function($){
	
	jQuery("#inputCategory").change(function() {
		$this = jQuery(this);
		
			jQuery('.lp-nested').hide();
			jQuery('#inputCategory').attr("disabled", true);
			jQuery('#tags-by-cat').html(' ');
			jQuery('label.featuresBycat').remove();
			 jQuery('form#lp-submit-form  div.pre-load:first').addClass('loader');
			 jQuery('#features-by-cat').html(' ');
			 jQuery(".chosen-select").prop('disabled', true).trigger('chosen:updated');

				jQuery.ajax({
					type: 'POST',
					dataType: 'json',
					url: ajax_term_object.ajaxurl,
					data: { 
						'action': 'ajax_term', 
						'term_id': jQuery('form#lp-submit-form #inputCategory').val(), 
						'listing_id': jQuery('input[name=lp_post]').val(), 
						},
					success: function(data){
						
						jQuery('#inputCategory').removeAttr("disabled");
						if(data){
							
							if(data.hasfeatues==true){
								jQuery('.labelforfeatures.lp-nested').show();
								jQuery('#tags-by-cat').show();
							}
							if(data.hasfields==true){
								jQuery('#features-by-cat').show();
							}
							$('form#lp-submit-form div.pre-load').removeClass('loader');
							jQuery(".chosen-select").prop('disabled', false).trigger('chosen:updated');
							
							if(data.tags != null){
								jQuery('.lpfeatures_fields').prepend('<label for="inputTags" class="featuresBycat">'+data.featuretitle+'</label>');
								jQuery.each(data.tags, function(i,v) {
									var lpchecked = '';
									if(data.lpselectedtags != null){
										jQuery.each(data.lpselectedtags, function(lk,ls) {
											if(i.trim()==lk){
												lpchecked = 'checked';
											}
										});
									}
									
									jQuery('#tags-by-cat')
									.append('<div class="col-md-2 col-sm-4 col-xs-6"><div class="checkbox pad-bottom-10"><input id="check_'+v+'" type="checkbox" name="lp_form_fields_inn[lp_feature][]" value="'+i+'" '+lpchecked+'><label for="check_'+v+'">'+v+'</label></div></div>'); 
								});							
								
							}
							//var num = 0;
						
								jQuery('#features-by-cat')
								.append(data.fields); 
								//num++;

							
						}
					}
				});
		
	});

});