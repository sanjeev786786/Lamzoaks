/*-----------------------------------------------------------------------------------*/
/*	Custom Script for admin
/*-----------------------------------------------------------------------------------*/
	jQuery(function($) {
		if(jQuery("tr").is('#field_faqs')){
			var tabs = jQuery("#field_faqs").find("#tabs").tabs();
		}
	jQuery('#tabsbtn').click(function(){
		var qstring = jQuery('div#tabs').data('qstring');
		var ansstring = jQuery('div#tabs').data('ansstring');
		var faqtitle = jQuery('div#tabs').data('faqtitle');
		var ul = tabs.find( "ul" );
		var list = Number(ul.find( "li" ).length) + 1;
		jQuery( "<li><a href='#tab"+list+"'>"+qstring+" "+list+"</a></li>" ).appendTo( ul );
		
		var content = "<div class='form-group'><label for='faq-"+list+"'>"+faqtitle+" "+list+"</label><input type='text' class='form-control' name='faqs[faq]["+list+"]' id='faq-"+list+"' placeholder='"+qstring+" "+list+"'></div><div class='form-group'><label for='faq-ans-"+list+"'>Answer "+list+"</label><textarea class='form-control' name='faqs[faqans]["+list+"]' rows='8' id='faq-ans-"+list+"'></textarea></div>";
		
		jQuery( "<div id='tab"+list+"'><p>"+content+"</p></div>" ).appendTo( tabs );
		tabs.tabs( "refresh" );
	});
	
	
	
	
// Add hours
	jQuery('button.add-hours').on('click', function(event) {
		event.preventDefault();
		var $this = jQuery(this);
		var lp2times = $this.closest('#day-hours-BusinessHours').data('lpenabletwotimes');
		var error = false;
		var fullday = '';
		var fullhoursclass = '';
		
		var lpdash = "-";
		
		if(lp2times=="disable"){
		
			var weekday = jQuery('select.weekday').val();
			if(jQuery(".fulldayopen").is(":checked")){
				jQuery('.fulldayopen').attr('checked', false);
				jQuery('select.hours-start').prop("disabled", false);
				jQuery('select.hours-end').prop("disabled", false);
				var startVal ='';
				var endVal ='';
				var hrstart ='';
				var hrend ='';
				fullday = $this.data('fullday');
				fullhoursclass = 'fullhours';
				lpdash = "";
			}
			else{
				var startVal = jQuery('select.hours-start').val();
				var endVal = jQuery('select.hours-end').val();
				var hrstart = jQuery('select.hours-start').find('option:selected').text();
				var hrend = jQuery('select.hours-end').find('option:selected').text();
				
				var startVal_digit = hrstart.replace(':', '');
				var endVal_digit = hrend.replace(':', '');
				
				if(startVal_digit > endVal_digit){
					nextWeekday = jQuery("select.weekday option:selected+option").val();
					if(typeof nextWeekday === "undefined"){
						nextWeekday = jQuery("select.weekday").find("option:first-child").val();
					}
					
					weekday = weekday+"-"+nextWeekday;
				}
				
				
			}
			
			
			var sorryMsg = jQuery(this).data('sorrymsg');
			var alreadyadded = jQuery(this).data('alreadyadded');
			var remove = jQuery(this).data('remove');
			jQuery('.hours-display .hours').each(function(index, element) { 
				var weekdayTExt = jQuery(element).children('.weekday').text();
				if(weekdayTExt == weekday){
					alert(sorryMsg+'! '+weekday+' '+alreadyadded);
					error = true;
				}
			});
			if(error != true){
				jQuery('.hours-display').append("<div class='hours "+fullhoursclass+"'><span class='weekday'>"+ weekday +"</span><span class='start-end fullday'>"+fullday+"</span><span class='start'>"+ hrstart +"</span><span>"+lpdash+"</span><span class='end'>"+ hrend +"</span><a class='remove-hours' href='#'>"+remove+"</a><input name='business_hours["+weekday+"][open]' value='"+startVal+"' type='hidden'><input name='business_hours["+weekday+"][close]' value='"+endVal+"' type='hidden'></div>");
				var current = jQuery('select.weekday').find('option:selected');
				var nextval = current.next();
				current.removeAttr('selected');
				nextval.attr('selected','selected');
				jQuery('select.weekday').trigger('change.select2');
			}
		}
		else{
			var lptwentlyfourisopen = '';
			/* 2times */
			var weekday = jQuery('select.weekday').val();
			var weekday1 = weekday;
			var weekday2 = weekday;
			if(jQuery(".fulldayopen").is(":checked")){
				
				lptwentlyfourisopen = 'yes';
				
				jQuery('.fulldayopen').attr('checked', false);
				jQuery('select.hours-start').prop("disabled", false);
				jQuery('select.hours-end').prop("disabled", false);
				
				jQuery('select.hours-start2').prop("disabled", false);
				jQuery('select.hours-end2').prop("disabled", false);
				
				var startVal1 ='';
				var endVal1 ='';
				var hrstart1 ='';
				var hrend1 ='';
				
				var startVal2 ='';
				var endVal2 ='';
				var hrstart2 ='';
				var hrend2 ='';
				
				
				
				fullday = $this.data('fullday');
				fullhoursclass = 'fullhours';
				
				lpdash = "";
			}
			else{
				var startVal1 = jQuery('select.hours-start').val();
				var endVal1 = jQuery('select.hours-end').val();
				var hrstart1 = jQuery('select.hours-start').find('option:selected').text();
				var hrend1 = jQuery('select.hours-end').find('option:selected').text();
				
				var startVal1_digit = hrstart1.replace(':', '');
				var endVal1_digit = hrend1.replace(':', '');
				
				
				
				if(startVal1_digit > endVal1_digit){
					
					nextWeekday = jQuery("select.weekday option:selected+option").val();
					if(typeof nextWeekday === "undefined"){
						nextWeekday = jQuery("select.weekday").find("option:first-child").val();
						
					}
					
					weekday1 = weekday+"-"+nextWeekday;
					
				}
				
				
				var startVal2 = jQuery('select.hours-start2').val();
				var endVal2 = jQuery('select.hours-end2').val();
				var hrstart2 = jQuery('select.hours-start2').find('option:selected').text();
				var hrend2 = jQuery('select.hours-end2').find('option:selected').text();
				
				var startVal2_digit = hrstart2.replace(':', '');
				var endVal2_digit = hrend2.replace(':', '');
				
				if(startVal2_digit > endVal2_digit){
					nextWeekday = jQuery("select.weekday option:selected+option").val();
					if(typeof nextWeekday === "undefined"){
						nextWeekday = jQuery("select.weekday").find("option:first-child").val();
					}
					
					weekday2 = weekday+"-"+nextWeekday;
				}
				
				
			}
			
			var sorryMsg = jQuery(this).data('sorrymsg');
			var alreadyadded = jQuery(this).data('alreadyadded');
			var remove = jQuery(this).data('remove');
			jQuery('.hours-display .hours').each(function(index, element) { 
				var weekdayTExt = jQuery(element).children('.weekday').text();
				if(weekdayTExt == weekday){
					alert(sorryMsg+'! '+weekday+' '+alreadyadded);
					error = true;
				}
			});
			
			if(error != true){
				
				if( (jQuery(".lp-check-doubletime .enable2ndday").is(":checked")) && (lptwentlyfourisopen==="") ){
					
					jQuery('.hours-display').append("<div class='hours "+fullhoursclass+"'><span class='weekday'>"+ weekday +"</span><span class='start-end fullday'>"+fullday+"</span><span class='start'>"+ hrstart1 +"</span><span>"+lpdash+"</span><span class='end'>"+ hrend1 +"</span><a class='remove-hours' href='#'>"+remove+"</a><br><span class='weekday'>&nbsp;</span><span class='start'>"+ hrstart2 +"</span><span>"+lpdash+"</span><span class='end'>"+ hrend2 +"</span><input name='business_hours["+weekday1+"][open][0]' value='"+startVal1+"' type='hidden'><input name='business_hours["+weekday1+"][close][0]' value='"+endVal1+"' type='hidden'><input name='business_hours["+weekday2+"][open][1]' value='"+startVal2+"' type='hidden'><input name='business_hours["+weekday2+"][close][1]' value='"+endVal2+"' type='hidden'></div>");
				}else{
					
					jQuery('.hours-display').append("<div class='hours "+fullhoursclass+"'><span class='weekday'>"+ weekday1 +"</span><span class='start-end fullday'>"+fullday+"</span><span class='start'>"+ hrstart1 +"</span><span>"+lpdash+"</span><span class='end'>"+ hrend1 +"</span><a class='remove-hours' href='#'>"+remove+"</a><input name='business_hours["+weekday1+"][open]' value='"+startVal1+"' type='hidden'><input name='business_hours["+weekday1+"][close]' value='"+endVal1+"' type='hidden'></div>");
				}
				var current = jQuery('select.weekday').find('option:selected');
				var nextval = current.next();
				current.removeAttr('selected');
				nextval.attr('selected','selected');
				jQuery('select.weekday').trigger('change.select2');
			}
			
			/* 2times */
		}
	});
	
	jQuery(document).ready(function(){
		jQuery('select.hours-start2').prop("disabled", true);
		jQuery('select.hours-end2').prop("disabled", true);
		jQuery(".lp-check-doubletime .enable2ndday").change(function() {
			if(this.checked) {
				jQuery('select.hours-start2').prop("disabled", false);
				jQuery('select.hours-end2').prop("disabled", false);
				jQuery('.hours-select.lp-slot2-time').slideToggle(300);
			}
			else{
				jQuery('select.hours-start2').prop("disabled", true);
				jQuery('select.hours-end2').prop("disabled", true);
				jQuery('.hours-select.lp-slot2-time').slideToggle(300);
			}
		});	
	});	
	

	// Remove Hours Script
	
	jQuery(document).on('click','a.remove-hours',function(event){
		event.preventDefault();
		jQuery(this).parent('.hours').remove();
	});
	
	/* for increament metabox */
	jQuery('.metaincbtn').click(function(){
		var remText = jQuery(this).data('remove');
		var div = jQuery( this ).closest( '.type_inrement' );				
		var dataID = div.data( "id" );	
		var list = Number(jQuery('.'+dataID ).find( "input" ).length) + 1;		
	
		var tdContent = '<div class="lp-addmore-wrap">';
		tdContent += "<input type='text' name='"+dataID+"["+list+"]' id='"+dataID+"' value='' />";
		tdContent += '<a href="" class="lp-remove-more">'+remText+'</a>';
		tdContent += '</div>';
		
		jQuery(tdContent).appendTo( '.'+dataID );

	});

	jQuery(document).on('click','.lp_price_plan_addmore a.lp-remove-more', function(e){
		e.preventDefault();
		var $target = jQuery(this).closest('.lp-addmore-wrap');
		$target.slideToggle('slow', function(){ $target.remove(); });
	});
	
	/* end for increament metabox */
	
	
	
  });
  
  jQuery(function() {
		var div = jQuery( '.type_inrement' );
		var th = div.find( "th" );		
		var td = div.find( "td" );
		var dataID = div.data( "id" );
		var dataVALUE= div.data( "value" );
		var dataNAME = div.data( "name" );		
		var listfirst = Number(td.find( "input" ).length);
		div.find( "th" ).find('strong').text(dataNAME+" "+listfirst);
	jQuery('#metaincbtn').click(function(){			
		var list = Number(td.find( "input" ).length) + 1;		
		var thContent = "<label for='"+dataID+"["+list+"]'><strong>"+dataNAME+" "+list+"</strong><span></span></label>";
		var tdContent = "<input type='text' name='"+dataID+"["+list+"]' id='"+dataID+"' value='"+dataVALUE+"' />";
		jQuery(thContent).appendTo( th );
		jQuery(tdContent).appendTo( td );

	});				
	
	
  jQuery(window).load(function($){
	 
		var listID = jQuery('#post_ID').val();	
		var termID = jQuery('#listing-categorychecklist input:checked').map(function () {
				return this.value;
			}).get();
		if(termID != undefined && termID != ''){
			 jQuery('.extrafieldsdiv').remove();
		jQuery.ajax({
				type: 'POST',
				dataType: 'json',
				url: ajaxurl,
				data: { 
					'action': 'lp_get_fields', 
					'term_id': termID, 
					'list_id': listID, 
					},
				success: function(data){
					if(data){
						$output1 = "<div id='commentstatusdiv12' class='lp-metaboxes postbox extrafieldsdiv'><h2 class='hndle ui-sortable-handle'><span>Extra Fields</span></h2><div class='inside'><table class='form-table lp-metaboxes'><tbody>";
						$outputf = "<div id='commentstatusdiv' class='lp-metaboxes postbox extrafieldsdiv'><h2 class='hndle ui-sortable-handle'><span>Please select Features</span></h2><div class='inside'><table class='form-table lp-metaboxes'><tbody>";
						
						$output2 = "</tbody></table></div></div>";
						
						if(data.features != null){
							jQuery('#postbox-container-2').append($outputf+data.features+$output2);
						}else{
							jQuery('#postbox-container-2').append($output1+'<p>No Fields Associated</p>'+$output2);
						}
						
						if(data.fields != null){
							jQuery('#postbox-container-2').append($output1+data.fields+$output2);
						}else{
							jQuery('#postbox-container-2').append($output1+'<p>No Fields Associated</p>'+$output2);
						}
					}
					
				}
			});
		}else{
			jQuery('.extrafieldsdiv').remove();
		}
	});
	
	/* on change  */
	jQuery(document).on('change', '#listing-categorychecklist input', function() {
      var listID = jQuery('#post_ID').val();    
         //if(this.checked) {
			var termID = jQuery('#listing-categorychecklist input:checked').map(function () {
				return this.value;
			}).get();
           if(termID != undefined && termID != ''){
			   jQuery('.extrafieldsdiv').remove();
			   jQuery("#listing-categorychecklist input").attr("disabled", true);
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajaxurl,
                data: { 
                  'action': 'lp_get_fields', 
                  'term_id': termID, 
                  'list_id': listID, 
                  },
                success: function(data){
				jQuery("#listing-categorychecklist input").removeAttr("disabled");
                  if(data){
                    $output1 = "<div id='commentstatusdiv12' class='lp-metaboxes postbox extrafieldsdiv'><h2 class='hndle ui-sortable-handle'><span>Extra Fields</span></h2><div class='inside'><table class='form-table lp-metaboxes'><tbody>";
                    $outputf = "<div id='commentstatusdiv' class='lp-metaboxes postbox extrafieldsdiv'><h2 class='hndle ui-sortable-handle'><span>Please select Features</span></h2><div class='inside'><table class='form-table lp-metaboxes'><tbody>";
                    $output2 = "</tbody></table></div></div>";
                    if(data.features != null){
                      jQuery('#postbox-container-2').append($outputf+data.features+$output2);
                    }else{
                      jQuery('#postbox-container-2').append($output1+'<p>No Fields Associated</p>'+$output2);
                    }
                    if(data.fields != null){
                      jQuery('#postbox-container-2').append($output1+data.fields+$output2);
                    }else{
                      jQuery('#postbox-container-2').append($output1+'<p>No Fields Associated</p>'+$output2);
                    }
                  }
                }
              });
            }else{
				jQuery('.extrafieldsdiv').remove();
			}
       //}
    });
	
	
	/* ajax call for category excluded form fields on backend */
	jQuery(window).load(function($){
		var checkposttype = jQuery('input#post_type').val();
		lplistingid = jQuery('input#post_ID').val();
		if(checkposttype==="listing"){
			jQuery.ajax({
					type: 'POST',
					dataType: 'json',
					url: ajaxurl,
					data: { 
						'action': 'lp_get_excluded_fields', 
						'lplistingid': lplistingid, 
						},
					success: function(data){
						if(data){
							$output1 = "<div id='lpcommentstatusdiv' class='lp-metaboxes postbox extrafieldsdivva'><h2 class='hndle ui-sortable-handle'><span>Extra Fields</span></h2><div class='inside'><table class='form-table lp-metaboxes'><tbody>";
							$output2 = "</tbody></table></div></div>";
							
							if(data.fields != null){
								jQuery('#postbox-container-2').append($output1+data.fields+$output2);
							}
						}
						
					}
				});
		}
		
	});
	/* end excluded form fields on backend */
	
	jQuery(document).ready(function(){
		jQuery(".fulldayopen").change(function() {
			if(this.checked) {
				jQuery('select.hours-start').prop("disabled", true);
				jQuery('select.hours-end').prop("disabled", true);
				jQuery('select.hours-start2').prop("disabled", true);
				jQuery('select.hours-end2').prop("disabled", true);
			}
			else{
				jQuery('select.hours-start').prop("disabled", false);
				jQuery('select.hours-end').prop("disabled", false);
				jQuery('select.hours-start2').prop("disabled", false);
				jQuery('select.hours-end2').prop("disabled", false);
			}
		});	
		
		jQuery('.type_listing select').on('click', function(){
			var $this = jQuery(this);
			if(jQuery(this).find('option').length<=1){
				jQuery('.lp-listing-sping').show();
				jQuery.ajax({
					type: "POST",
					url: ajaxurl,
					data: {
						'action': 'lp_get_all_p_listings',
					},
					dataType: 'json',
					success : function(response){
						$this.remove('option');
						jQuery('.lp-listing-sping').hide();
						$this.append(response);
					}
				});
			}
		});
	});
	
	
	
  });
  
  jQuery(document).ready(function($){
	  if(jQuery("#field_exclusive_field #exclusive_field").is(':checked')){
		  /* uncheck the cats and disable */
		  jQuery("#field-cat .check-all-btn").prop( "disabled", true );
		  jQuery('#field-cat .single-check input[type=checkbox]').attr('checked', false);
		  jQuery('#field-cat .single-check input[type=checkbox]').prop( "disabled", true );
		  jQuery("#field-cat").toggle("slow");
	  }
	  else{
		  jQuery("#field-cat .check-all-btn").prop( "disabled", false );
		  jQuery('#field-cat .single-check input[type=checkbox]').prop( "disabled", false );
	  }
	  
	  jQuery("#field_exclusive_field #exclusive_field").on('click', function(){
		  if(jQuery("#field_exclusive_field #exclusive_field").is(':checked')){
			  /* uncheck the cats and disable */
			  jQuery("#field-cat .check-all-btn").prop( "disabled", true );
			  jQuery('#field-cat .single-check input[type=checkbox]').attr('checked', false);
			  jQuery('#field-cat .single-check input[type=checkbox]').prop( "disabled", true );
			  jQuery("#field-cat").toggle("slow");			  
		  }
		  else{
			  jQuery("#field-cat .check-all-btn").prop( "disabled", false );
			  jQuery('#field-cat .single-check input[type=checkbox]').prop( "disabled", false );
			  jQuery("#field-cat").toggle("slow");
		  }
	  });
	 
	  
  });