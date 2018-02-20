/*-----------------------------------------------------------------------------------*/
/*	Custom Script
/*-----------------------------------------------------------------------------------*/

  jQuery(function() {
	  
	var tabs = jQuery("#tabs").tabs();
	
	jQuery('#tabsbtn').click(function(){
		var ul = tabs.find( "ul" );
		var list = Number(ul.find( "li" ).length) + 1;
		var place1 = jQuery('#tabs-1').find('input').attr('placeholder');
		var place2 = jQuery('#tabs-1').find('textarea').attr('placeholder');
		var FAQMain = jQuery('div#tabs').data('faqtitle');
		var FaqTItle = jQuery('.faq-btns').find('li').children('a').data('faq-text');
		var FaqTItle = FaqTItle.replace(/[^A-Za-z]+/g, '');
		jQuery( "<li><a href='#tab"+list+"'>"+FaqTItle+" "+list+"</a></li>" ).appendTo( ul );
		
		var content = "<div class='form-group'><label for='faq-"+list+"'>"+FAQMain+" "+list+"</label><input type='text' class='form-control' name='faq["+list+"]' id='faq-"+list+"' placeholder='"+place1+"'></div><div class='form-group'><textarea class='form-control' name='faqans["+list+"]' rows='8' id='faq-ans-"+list+"' placeholder='"+place2+"'></textarea></div>";
		
		jQuery( "<div id='tab"+list+"'>"+content+"</div>" ).appendTo( tabs );
		tabs.tabs( "refresh" );
	});
	jQuery(".jFiler-input-dragDrop").click(function(){
	   jQuery("#filer_input").click();
	});
	jQuery(document).on('click','.jFiler-item-trash-action', function() {

		jQuery(this).parent().find('.jFiler-item-container').fadeOut();
		jQuery(this).closest('ul.jFiler-items-grid').fadeOut();
		jQuery(this).fadeOut();
		jQuery(this).next('input').attr('name', 'listImg_remove[]' );

    });
	
	jQuery(document).on('change', 'input#already-account', function(e){
		if( jQuery(this).is(':checked') ){
			jQuery('.lp-submit-no-account').fadeOut(500, function(e){
			jQuery('.lp-submit-have-account').fadeIn(500);
		})
		}else{
				jQuery('.lp-submit-have-account').fadeOut(500, function(e){
					jQuery('.lp-submit-no-account').fadeIn(500);
				})
		}
	});
	
  });
  

  