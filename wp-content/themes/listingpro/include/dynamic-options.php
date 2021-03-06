<?php

function listingpro_dynamic_options() {
	
	global $listingpro_options; 
	$lp_page_header = $listingpro_options['page_header']['url'];
	$lp_home_banner = $listingpro_options['home_banner']['url'];
	$lp_page_banner = '';
	if(class_exists('ListingproPlugin')){
		$lp_page_banner = listing_get_metabox('lp_page_banner');
	}
	

	/* Header Color Options*/
	$lp_top_bar = $listingpro_options['top_bar_enable'];
	$headerBgcolor = $listingpro_options['header_bgcolor'];
	$top_bar_bgcolor = $listingpro_options['top_bar_bgcolor'];
	$topBannerView = $listingpro_options['top_banner_styles'];

// Body 
$bodyff = $listingpro_options['typography-body']['font-family'];
$bodyfz = $listingpro_options['typography-body']['font-size'];
$bodyfw = $listingpro_options['typography-body']['font-weight'];
$bodycol = $listingpro_options['typography-body']['color'];
$bodylh = $listingpro_options['typography-body']['line-height'];

// H1 Styles
$h1ff = $listingpro_options['h1_typo']['font-family'];
$h1fz = $listingpro_options['h1_typo']['font-size'];
$h1fw = $listingpro_options['h1_typo']['font-weight'];
$h1col = $listingpro_options['h1_typo']['color'];
$h1lh = $listingpro_options['h1_typo']['line-height'];

// H2 Styles
$h2ff = $listingpro_options['h2_typo']['font-family'];
$h2fz = $listingpro_options['h2_typo']['font-size'];
$h2fw = $listingpro_options['h2_typo']['font-weight'];
$h2col = $listingpro_options['h2_typo']['color'];
$h2lh = $listingpro_options['h2_typo']['line-height'];

// H3 Styles
$h3ff = $listingpro_options['h3_typo']['font-family'];
$h3fz = $listingpro_options['h3_typo']['font-size'];
$h3fw = $listingpro_options['h3_typo']['font-weight'];
$h3col = $listingpro_options['h3_typo']['color'];
$h3lh = $listingpro_options['h3_typo']['line-height'];

// H4 Styles
$h4ff = $listingpro_options['h4_typo']['font-family'];
$h4fz = $listingpro_options['h4_typo']['font-size'];
$h4fw = $listingpro_options['h4_typo']['font-weight'];
$h4col = $listingpro_options['h4_typo']['color'];
$h4lh = $listingpro_options['h4_typo']['line-height'];

// H5 Styles
$h5ff = $listingpro_options['h5_typo']['font-family'];
$h5fz = $listingpro_options['h5_typo']['font-size'];
$h5fw = $listingpro_options['h5_typo']['font-weight'];
$h5col = $listingpro_options['h5_typo']['color'];
$h5lh = $listingpro_options['h5_typo']['line-height'];

// H6 Styles
$h6ff = $listingpro_options['h6_typo']['font-family'];
$h6fz = $listingpro_options['h6_typo']['font-size'];
$h6fw = $listingpro_options['h6_typo']['font-weight'];
$h6col = $listingpro_options['h6_typo']['color'];
$h6lh = $listingpro_options['h6_typo']['line-height'];

// p Styles
$pff = $listingpro_options['paragraph_typo']['font-family'];
$pfz = $listingpro_options['paragraph_typo']['font-size'];
$pfw = $listingpro_options['paragraph_typo']['font-weight'];
$pcol = $listingpro_options['paragraph_typo']['color'];
$plh = $listingpro_options['paragraph_typo']['line-height'];

// Navigation Styles
$nav_ff = $listingpro_options['nav_typo']['font-family'];
$nav_fz = $listingpro_options['nav_typo']['font-size'];
$nav_fw = $listingpro_options['nav_typo']['font-weight'];
$nav_col = $listingpro_options['nav_typo']['color'];

$themeClr = $listingpro_options['theme_color'];
$secThemeClr = $listingpro_options['sec_theme_color'];

$footer_top_bgcolor = $listingpro_options['footer_top_bgcolor'];
$footer_bgcolor = $listingpro_options['footer_bgcolor'];
$banner_opacity = $listingpro_options['banner_opacity'];
$banner_height = $listingpro_options['banner_height'];
$header_textcolor = $listingpro_options['header_textcolor'];


?>

<?php
if(is_admin_bar_showing()){
	?>
	<style>
	div.lp-top-notification-bar{
		 top: 32px !important;
	}
	</style>
<?php	
}
?>
	

    <!-- Custom CSS -->
    <style>
    	.footer-upper-bar {
    		background-color: <?php echo esc_html($footer_top_bgcolor); ?>
    	}
    	footer {
    		background-color: <?php echo esc_html($footer_bgcolor); ?>
    	}
		<?php
		if(!is_front_page()){
			if(!empty($headerBgcolor)) { ?>
				.lp-menu-bar, .header-normal .lp-menu-bar.lp-header-full-width {
					background-color: <?php echo esc_html($headerBgcolor); ?>
				}
				.header-filter .input-group.width-49-percent.margin-right-15.hide-where,
				.header-filter .input-group.width-49-percent,
				.header-filter .input-group.width-49-percent.margin-right-15 {
					border:1px solid <?php echo esc_html($header_textcolor); ?>;
				}
				.header-right-panel .lp-menu ul li a,
				.lp-menu ul li.page_item_has_children::after, .lp-menu ul li.menu-item-has-children::after,
				.lp-join-now a, .lp-add-listing-btn li a {
					color: <?php echo esc_html($header_textcolor); ?>;
				}
				.lp-header-bg-black .navbar-toggle,
				.lp-header-bg-black.header-fixed .navbar-toggle,
				
				.fullwidth-header .lp-add-listing-btn ul li a {
					color: <?php echo esc_html($header_textcolor); ?>;
					border-color: <?php echo esc_html($header_textcolor); ?>;
				}			
			<?php } ?>
		<?php }elseif ( $topBannerView == 'map_view' && is_front_page() ) {
			if(!empty($headerBgcolor)) { ?>
				.lp-menu-bar, .header-normal .lp-menu-bar.lp-header-full-width {
					background-color: <?php echo esc_html($headerBgcolor); ?>
				}
				.header-right-panel .lp-menu ul li a,
      	.lp-menu ul li.page_item_has_children::after, .lp-menu ul li.menu-item-has-children::after,
        .lp-join-now a, .lp-add-listing-btn li a {
					color: <?php echo esc_html($header_textcolor); ?>;
				}
			<?php } ?>
		<?php }
		if(!empty($top_bar_bgcolor)) { ?>
			.lp-topbar {
				background-color: <?php echo esc_html($top_bar_bgcolor); ?>
			}
		<?php } ?>

		<?php if(!empty($lp_page_banner)){ ?>
				.listing-page{
					background-image:url(<?php echo esc_url($lp_page_banner); ?>);
				}
		<?php } elseif(!empty($lp_page_header)){ ?>
				.listing-page{
					background-image:url(<?php echo esc_url($lp_page_header); ?>);
				}
		<?php } ?>

		<?php
			$videoBanner = '';
			$videoBanner = $listingpro_options['lp_video_banner_on'];
			if($videoBanner!="video_banner"){
			if(!empty($lp_home_banner)){ ?>
			.header-container.lp-header-bg{
					background-image:url(<?php echo esc_url($lp_home_banner); ?>);
					background-repeat:no-repeat;
					background-position:center top;
				}
			<?php }
			}
		?>
		<!--cod by shebi-->
			.call-to-action2 h1{
			background-image:url(<?php echo get_template_directory_uri(); ?>/assets/images/new/hb.png);
			background-repeat:no-repeat;
			background-position:center center;
			  }
			 .listing-app-view .admin-top-section .user-details .user-portfolio,.listing-app-view .user-detail-wrap{
			background-image:url(<?php echo get_template_directory_uri(); ?>/assets/images/admin/adminbg.jpg);
			background-repeat:no-repeat;
			background-position:center center;
			  }
			 .lp-blog-style2-inner .lp-blog-grid-author li .fa,.lp-blog-grid-author2 li .fa,
			 .listing-app-view .footer-app-menu ul li a:hover,.listing-app-view .small-scrren-app-view .sign-login-wrap a,
			 .listing-app-view .small-scrren-app-view .add-listing-btn,
			 .googledroppin,.googledroppin:hover{
			  color: <?php echo $themeClr; ?>;
			 }
			 .city-girds2 .city-thumb2  .category-style3-title-outer,.single-tabber2 ul .active a:after,.waycheckoutModal .btn-default:hover,
			 .list_view .lp-grid-box-bottom .lp-nearest-distance,.grid_view2 .lp-grid-box-bottom .lp-nearest-distance{
			  background: <?php echo $themeClr; ?>;
			 }
			 .single-tabber2 ul li a:hover,.single-tabber2 ul .active a,#sidebar aside ul li a:hover,#sidebar .jw-recent-posts-widget ul li .jw-recent-content a:hover,
			 .blog-read-more-style2 a,.blog-read-more a{
			  color: <?php echo $themeClr; ?>;
			  
			 }
			 .waycheckoutModal .btn-default:hover{
			  border-color:<?php echo $themeClr; ?> !important;
			  
			 }
			 .blog-detail-link,.listing-app-view .footer-app-menu ul li:hover{
			  color: <?php echo $themeClr; ?> !important;
			  border-color:<?php echo $themeClr; ?> !important;
			 }
			 .blog-detail-link:hover,.video-bottom-search-content,.listing-app-view.login-form-pop-tabs{
			  background-color: <?php echo $themeClr; ?> !important;
			  
			 }
			 #sidebar aside h2.widget-title:after{
			  background: <?php echo $themeClr; ?>;
			  
			 }
			 .app-view-header .lp-menu-bar,.slider-handle,.tooltip-inner{
			  background: <?php echo $themeClr; ?>;
			  
			 }
			 .review-secondary-btn,.blog-read-more a:hover,
			 .lp-tooltip-outer .lp-tool-tip-content .sortbyrated-outer ul li .active{
			  background: <?php echo $themeClr; ?> !important;
			  border-color: <?php echo $themeClr; ?> !important;
			 }
			 .location-filters-wrapper #distance_range_div input[type=range]::-webkit-slider-thumb,#distance_range_div_btn a:hover,.location-filters-wrapper #distance_range_div input[type=range]::-moz-range-thumb,.location-filters-wrapper #distance_range_div input[type=range]::-ms-thumb{
			  
			  background:<?php echo $themeClr; ?> !important;
			 } 
			 .tooltip.top .tooltip-arrow{
			  
			  border-top-color: <?php echo $themeClr; ?>;
			 }
			 input:checked + .slider{
     
				 background-color: <?php echo $themeClr; ?>;
			}
			 .listing-app-view .app-view-filters .close{
			border-color: <?php echo $themeClr; ?> !important; 
			 color: <?php echo $themeClr; ?>; 
			}
			 .listing-app-view .app-view-filters .close:hover{
			  background: <?php echo $themeClr; ?>;
			 }
			 .listing-app-view .small-scrren-app-view .mm-listview a:hover,.listing-app-view .small-scrren-app-view .mm-listview a:focus{
			  
				color: <?php echo $themeClr; ?> !important;
			  
			 }
			<!--end bycody by shebi-->
		<?php
			if(!empty($banner_opacity)){ ?>
			.lp-home-banner-contianer::before, .lp-header-overlay,.page-header-overlay, .lp-home-banner-contianer-inner-video-outer{
					background-color: rgba(0, 0, 0, <?php echo esc_html($banner_opacity);?>);
				}
			<?php }
		?>
		
		<?php
			if(!empty($banner_height)){ ?>
			.lp-home-banner-contianer {
					height: <?php echo esc_html($banner_height);?>px;
				}
			<?php }
		?>
	
		/* ===============================
				Theme Color Settings
		================================== */

		.lp-list-view-edit li a:hover, .review-post p i, .lp-header-full-width.lp-header-bg-grey .lp-add-listing-btn li a:hover,
		.lp-header-full-width.lp-header-bg-grey .lp-add-listing-btn li a, .lp-header-bg-grey .navbar-toggle, .lp-search-bar-all-demo .add-more,
		.lp-bg-grey .lp-search-bar-left .border-dropdown .chosen-container-single span::after, .lp-right-grid .add-more,
		.lp-search-bar-all-demo .add-more, .lp-right-grid .add-more, .video-option > h2 > span:first-of-type i, .count-text.all-listing,
		.lp-bg-grey .lp-search-bar-left .border-dropdown .chosen-container-single span::after, a.watch-video.popup-youtube,
		.dashboard-content .tab-content.dashboard-contnt h4 a, .campaign-options ul li i.fa-bar-chart, .email-address,
		body .grid_view2 a.add-to-fav.lp-add-to-fav.simptip-position-top.simptip-movable:hover > i, .wpb_wrapper > ul > li::before,
		body .grid_view2 a.add-to-fav.lp-add-to-fav.simptip-position-top.simptip-movable:hover > span, .lp-h4 a:hover,
		.promote-listing-box .texual-area > ul li i, .row.invoices-company-details a:hover, .checkout-bottom-area ul.clearfix > li > a:hover,
		.lp-all-listing span.count > p, .lp-all-listing span.count, h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover,
		.lp-h1 a:hover, .lp-h2 a:hover, .lp-h3 a:hover, .lp-h5 a:hover, .lp-h6 a:hover, .lp-blog-grid-category a:hover,
		.lp-blog-grid-title h4 a:hover, .footer-menu li a:hover, .post-rice, .tags-container li a label, .tags-container li a:hover span,
		.ui-accordion .ui-accordion-header span, .post-stat .fa-star, .listing-page-result-row p a:hover, p a.achor-color,
		.blog-tags ul li a:hover, .post-meta-left-box .breadcrumbs li a:hover, .post-meta-right-box .post-stat li a:hover,
		.parimary-link:hover, .secodary-link, blockquote::after, .lp-blockquote::after, .colored, .lp-add-listing-btn ul li a:hover,
		.listing-second-view .post-meta-right-box .post-stat a.add-to-fav:hover, .lp-list-view-paypal-inner h4:hover,
		.listing-second-view .post-meta-right-box .post-stat a.add-to-fav:hover span, .overlay-video-thumb:hover i,
		body .lp-grid-box-contianer a.add-to-fav.lp-add-to-fav.simptip-position-top.simptip-movable:hover i,
		.bottom-links a,.lp-list-view-content-upper h4:hover, .lp-blog-grid-author li a:hover, .lp-blog-grid-author li:hover,
		.dashboard-content .lp-pay-options .lp-promotebtn:hover, .dashboard-content .lp-pay-options .lp-promotebtn,
		.tags-container li a span.tag-icon, .lp-grid-box-price li > a:hover, .lp-grid-box-bottom .pull-left a:hover,
		.tags-container li a:hover span, .menu ul.sub-menu li:hover > a, .menu ul.children li:hover > a,
		.post-stat li a:hover, .lp-tabs .lp-list-view .lp-list-view-content-upper h4:hover, .lp-tabs .lp-list-view .lp-list-view-paypal-inner h4:hover,
		.post-reviews .fa-star, .listing-second-view .map-area .listing-detail-infos ul li a:hover > span,
		.widget-contact-info .list-st-img li a:hover, .get-directions > a:hover, body .grid_view2 a.add-to-fav.lp-add-to-fav:hover span,
		ul.post-stat li > a:hover > span i, .lp-grid-box-left.pull-left > ul > li > a:hover,
		.grid_view2 .lp-post-quick-links > li a:hover, .list_view .lp-post-quick-links > li a:hover,
		.lp-grid-box-description h4.lp-h4 > a:hover, body .list_view a.add-to-fav.lp-add-to-fav:hover span,
		body .list_view a.add-to-fav.lp-add-to-fav:hover, .grid_view2 .lp-post-quick-links > li a:hover > i,
		.list_view .lp-post-quick-links > li a:hover > i, .list_view .lp-post-quick-links > li a > i:hover,
		.listing-second-view .features.list-style-none > li a:hover > i, .listing-second-view .features li > a:hover span i,
		 .lp-join-now ul.lp-user-menu > li:hover > a, .listing-second-view .claim-area a.phone-number.md-trigger.claimformtrigger2:hover,
		 .listing-view-layout > ul li a.active, .listing-view-layout > ul li a:hover {
			color: <?php echo $themeClr; ?>;
		}

		.dashboard-tabs ul li ul li.active a {
			color: <?php echo esc_html($themeClr); ?> !important;
		}

		.ui-tooltip, .md-closer, .post-submit .ui-tabs .ui-tabs-nav li a, #success span p, .lp-list-view-paypal,
		.lp-listing-form input[type=radio]:checked + label::before, .lp-listing-form input[type=submit], .lp-invoice-table tr td a,
		.lp-modal-list .lp-print-list, .lp-tabs .lp-pay-publsh, .lp-dropdown-menu ul li a:hover,
		.listing-second-view .online-booking-form > a.onlineform.active, .listing-second-view .online-booking-form > a.onlineform:hover,
		.listing-second-view .listing-post article figure figcaption .bottom-area .listing-cats, .top-heading-area,
		.lp-dropdown-menu ul li a:hover,
		.listing-second-view .online-booking-form .booking-form input[type="submit"], .lp-price-main .lp-title,
		.ui-datepicker-header.ui-widget-header.ui-helper-clearfix.ui-corner-all, .calendar-month-header,
		.lp-search-bar-all-demo .lp-search-btn:hover, .lp-bg-grey .input-group-addon, .lp-search-bar-all-demo .lp-search-btn:hover,
		.lp-bg-grey .input-group-addon, .hours-select > li > button.add-hours, .typeahead__container .typeahead__button > button,
		.form-group .lp-search-bar-right, a.watch-video.popup-youtube:hover, .active-packages-area .table-responsive .top-area,
		.lp-grid-box-contianer .md-close i:hover, .listing-second-view a.secondary-btn.make-reservation,
		.list-st-img.list-style-none li a.edit-list:hover, .mm-menu .mm-navbar.mm-navbar-top, .lp-user-menu li a:hover,
		.fc-widget-content .fc-content-skeleton .fc-day-grid-event.fc-h-event.fc-event.fc-start.fc-end:hover,
		.lp-primary-btn:hover, .lp-search-btn, .lp-home-categoires li a:hover, .lp-post-quick-links li a.icon-quick-eye,
		.md-close i, .menu ul.sub-menu li a:hover, .menu ul.children li a:hover, .user-portfolio-stat ul li i,
		.lp-submit-btn:hover, .secondary-btn, .list-st-img li a:hover, .price-plan-box, .btn-first-hover, .btn-second-hover:hover,
		.ui-autocomplete li:hover, .tes-icon i, .menu ul.sub-menu li:hover > a, .menu ul.children li:hover > a,	.mm-listview .mm-next,
		.mm-navbar-size-1 a, .mm-listview a:hover, .active-tag:hover, .dashboard-content .lp-pay-options .lp-promotebtn:hover,
		.double-bounce1, .double-bounce2, .lpmap-icon-shape.cardHighlight, [data-tooltip].simptip-position-top::after,
		[data-tooltip].simptip-position-top::after, [data-tooltip].simptip-position-bottom::after,
		[data-tooltip].simptip-position-left::after, [data-tooltip].simptip-position-right::after,
		.menu ul.children li > a::before, .menu ul.sub-menu li > a::before, .lp-user-menu li > a::before,
		.currency-signs > ul > li > a.active, .search-filters > ul > li > a.active,div#lp-find-near-me ul li a.active,
		.select2-container--default .select2-results__option--highlighted[aria-selected], .bookingjs-form .bookingjs-form-button:hover, a.googleAddressbtn:hover, a.googleAddressbtn.active, .lp-recurring-button-wrap input[type=checkbox]:checked + label::before {
			background-color: <?php echo esc_html($themeClr); ?>;
		}
		a.lp-change-plan-btn:hover {
			background-color: <?php echo esc_html($themeClr); ?> !important;
			border-color: <?php echo esc_html($themeClr); ?> !important;
		}
		
		.lp-tabs .panel-heading li.active a, .ui-state-default.ui-state-highlight {
			background-color: <?php echo esc_html($themeClr); ?> !important;
		}

		.lp-grid-box-price .category-cion a, .ui-state-default.ui-state-highlight, .lp-header-full-width.lp-header-bg-grey .lp-add-listing-btn li a:hover,
		.lp-header-full-width.lp-header-bg-grey .lp-add-listing-btn li a, .lp-header-bg-grey .navbar-toggle, .lp-bg-grey .lp-interest-bar input[type="text"],
		.lp-bg-grey .chosen-container .chosen-single, .lp-bg-grey .lp-interest-bar input[type="text"], .lp-bg-grey .chosen-container .chosen-single,
		a.watch-video.popup-youtube, .listing-second-view a.secondary-btn.make-reservation,
		.fc-widget-content .fc-content-skeleton .fc-day-grid-event.fc-h-event.fc-event.fc-start.fc-end,
		.lpmap-icon-contianer, .dashboard-content .lp-pay-options .lp-promotebtn,.currency-signs > ul > li > a.active,
		.listing-view-layout > ul li a.active, .listing-view-layout > ul li a:hover, .search-filters > ul > li > a.active, div#lp-find-near-me ul li a.active {
			border-color: <?php echo esc_html($themeClr); ?>;
		}

		.ui-autocomplete li:hover {
			border-color: <?php echo esc_html($themeClr); ?> !important;
		}
		a.googleAddressbtn.active::after,
		.ui-tooltip::after {
			border-top-color: <?php echo esc_html($themeClr); ?>;
		}
		.dashboard-content .lp-main-tabs .nav-tabs > li.active > a, [data-tooltip].simptip-position-left::before,
		.dashboard-content .lp-main-tabs .nav-tabs > li a:hover, .dashboard-tabs.lp-main-tabs.text-center  ul  li  a.active-dash-menu {
			border-left-color: <?php echo esc_html($themeClr); ?>;
		}

		.lpmap-icon-shape.cardHighlight::after, [data-tooltip].simptip-position-top::before {
			border-top-color: <?php echo esc_html($themeClr); ?> !important;
		}

		.dashboard-tabs.lp-main-tabs.text-center > ul > li.opened:hover > a,
		.dashboard-tabs.lp-main-tabs.text-center > ul > li:hover > a,
		.dashboard-tabs.lp-main-tabs.text-center ul li a.active-dash-menu {
			border-left-color: <?php echo esc_html($themeClr); ?> !important;
		}

		[data-tooltip].simptip-position-right::before, [data-tooltip].simptip-position-top.half-arrow::before,
		[data-tooltip].simptip-position-bottom.half-arrow::before {
			border-right-color: <?php echo esc_html($themeClr); ?> !important;
		}

		[data-tooltip].simptip-position-top::before {
			border-top-color: <?php echo esc_html($themeClr); ?> !important;
		}
		[data-tooltip].simptip-position-bottom::before {
			border-bottom-color: <?php echo esc_html($themeClr); ?> !important;
		}

		/* ===================================
				Secondary Theme Color
		====================================== */
		.lp-primary-btn, .lp-search-btn:hover, .dashboard-tabs, .nav-tabs > li > a:hover, 
		.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus, .lp-submit-btn, .secondary-btn:hover,
		.list-st-img li a, .btn-first-hover:hover, .btn-second-hover, .about-box-icon, .upload-btn:hover, .chosen-container .chosen-results li.highlighted,
		.secondary-btn:active, .lp_confirmation .list-st-img li a.edit-list, .secondary-btn:focus, .resurva-booking .hidden-items input.lp-review-btn,
		input.lp-review-btn:hover, .dashboard-content .lp-list-page-list .lp-list-view .lp-rigt-icons .remove-fav i:hover,
		.lp-topbar, .lp-home-categoires li a, .lp-grid-box-bottom,  .form-group .lp-search-bar-right:hover,
		.post-submit .ui-tabs .ui-tabs-nav li.ui-state-active a, .lp-list-pay-btn a:hover, .lp-modal-list .lp-print-list:hover,
		.listing-second-view .online-booking-form > a.onlineform, .listing-second-view .contact-form ul li input[type="submit"],
		.listing-second-view .online-booking-form .booking-form, .listing-second-view .ask-question-area > a.ask_question_popup,
		.widget-box.business-contact .contact-form.quickform form.form-horizontal .form-group.pos-relative:hover input.lp-review-btn,
		.listing-second-view a.secondary-btn:hover, .submit-images:hover > a.browse-imgs, .lp-price-main .lp-upgrade-color,
		.lp-price-main .lp-upgrade-color:hover, .lp-price-main .lp-without-prc:hover, .featured-plan .lp-price-free.lp-without-prc.btn,
		.hours-select > li > button.add-hours:hover, .dashboard-content .postbox table.widefat a.see_more_btn:hover,
		#input-dropdown li:hover span, #input-dropdown li:hover a, #input-dropdown li:hover, .thankyou-panel ul li a:hover,
		.dashboard-content .promotional-section a.lp-submit-btn:hover, .widget-box.reservation-form a.make-reservation,
		.dashboard-content .lp-pay-options .promote-btn.pull-right:hover, .lp-dashboard-right-panel-listing ul li a.reply:hover,
		.dashboard-content .lp-list-view-content-bottom ul.lp-list-view-edit > li > a:hover, 
		.dashboard-content .lp-list-view-content-bottom ul.lp-list-view-edit > li > a:hover > span, .form-group.mr-bottom-0 > a.md-close:hover,
		.lp-rigt-icons.lp-list-view-content-bottom .list-st-img li input.lp-review-btn:hover, .lp-contact-support .secondary-btn:hover,
		.lp-rigt-icons.lp-list-view-content-bottom .list-st-img li a.edit-list:hover,
		.dashboard-content .user-recent-listings-inner .lp-list-page-list .remove-fav.md-close:hover,
		.resurva-booking .lp-list-view-inner-contianer ul li form:hover > span, .listing-second-view a.secondary-btn.make-reservation:hover,
		.dashboard-content .lp-pay-options .promotebtn:hover,
		#select2-searchlocation-results .select2-results__option.select2-results__option--highlighted, .bookingjs-form .bookingjs-form-button, a.googleAddressbtn {
		    background-color: <?php echo esc_html($secThemeClr); ?>;
		}

		.lp-tabs .lp-pay-publsh:hover {
		    background-color: <?php echo esc_html($secThemeClr); ?> !important;
		}

		input, .form-group label, .post-stat  li,
		.post-stat  li a, .listing-page-result-row p a, p a.achor-color:hover,
		.form-group label, .blog-tags ul li a, .post-meta-left-box .breadcrumbs li a, .post-meta-left-box .breadcrumbs li span,
		.tags-container li a span, .price-plan-content ul li span, .paragraph-form, .form-review-stars li i, .form-review-stars li a ,
		.post-meta-right-box .post-stat li a, .parimary-link, .secodary-link:hover, blockquote, .upload-btn, input.lp-review-btn,
		.lp-blockquote, .listing-second-view a.secondary-btn i, .bottom-links a:hover, .resurva-booking .hidden-items input.lp-review-btn:hover,
		.lp-menu .has-menu > a::after, .listing-second-view .post-meta-right-box .post-stat a.secondary-btn i, a.browse-imgs,
		.listing-second-view a.secondary-btn, .listing-second-view .contact-form ul li input[type="submit"]:hover,
		.listing-second-view .features li span i, .listing-second-view .post-meta-right-box .post-stat > li > a span.email-icon,
		.lp-price-free, .dashboard-content .tab-content.dashboard-contnt .ui-sortable-handle, .thankyou-panel ul li a,
		.dashboard-content .postbox table.widefat a.see_more_btn, .dashboard-content .promotiona-text > h3,
		.dashboard-content .lp-face.lp-front.lp-pay-options > h3, .dashboard-content .lp-face.lp-dash-sec > h4,
		.dashboard-content .lp-pay-options .lp-promotebtn, .dashboard-content .promote-btn.pull-right::before,
		.dashboard-content .lp-list-view-content-bottom ul.lp-list-view-edit > li > a, .lp-dashboard-right-panel-listing ul li a.reply,
		.dashboard-content .lp-list-view-content-bottom ul.lp-list-view-edit > li > a > span,
		.lp-rigt-icons.lp-list-view-content-bottom .list-st-img li input.lp-review-btn,
		.lp-rigt-icons.lp-list-view-content-bottom .list-st-img li a.edit-list, 
		.lp-rigt-icons.lp-list-view-content-bottom .list-st-img li input.lp-review-btn::before,
		.lp-rigt-icons.lp-list-view-content-bottom .list-st-img li a.edit-list::before, .form-group.mr-bottom-0 > a.md-close,
		.lp-rigt-icons.lp-list-view-content-bottom .list-st-img li a.edit-list > span, .lp-contact-support .secondary-btn i,
		.widget-box.business-contact .contact-form.quickform form.form-horizontal .form-group.pos-relative i.lp-search-icon,
		.dashboard-content .user-recent-listings-inner .lp-list-page-list .remove-fav.md-close > span,
		.dashboard-content .lp-list-page-list .lp-list-view .remove-fav i,
		.resurva-booking ul li.clearfix > form#booking > span, .dashboard-content .lp-pay-options .promotebtn {
			color: <?php echo esc_html($secThemeClr); ?>;
		}

		.nav-tabs > li > a::after{
			border-bottom-color: <?php echo esc_html($secThemeClr); ?>;
		}
		.upload-btn, .listing-second-view a.secondary-btn, .listing-second-view .contact-form ul li input[type="submit"],
		input.lp-review-btn, a.browse-imgs, .lp-price-free, .dashboard-content .postbox table.widefat a.see_more_btn,
		.dashboard-content .lp-pay-options .promote-btn.pull-right, .widget-box.reservation-form a.make-reservation,
		.thankyou-panel ul li a, .dashboard-content .lp-list-view-content-bottom ul.lp-list-view-edit > li > a,
		.lp-dashboard-right-panel-listing ul li a.reply, .lp-rigt-icons.lp-list-view-content-bottom .list-st-img li input.lp-review-btn,
		.lp-rigt-icons.lp-list-view-content-bottom .list-st-img li a.edit-list,
		.dashboard-content .user-recent-listings-inner .lp-list-page-list .remove-fav.md-close, .form-group.mr-bottom-0 > a.md-close,
		.lp-contact-support .secondary-btn:hover, .resurva-booking .lp-list-view-inner-contianer ul li form > span,
		.listing-second-view a.secondary-btn.make-reservation:hover, .dashboard-content .lp-pay-options .promotebtn {
			border-color: <?php echo esc_html($secThemeClr); ?>;
		}






		.menu ul.children li:hover > a, .menu ul.sub-menu li:hover > a, .lp-user-menu li:hover > a,
		.grid_view2 .lp-post-quick-links > li a, .list_view .lp-post-quick-links > li a {
		    background-color: transparent !important;
		}
		
		
		<?php if( $nav_ff != '' || $nav_fz != '' || $nav_fw != '' || $nav_col != '' ) { ?>
			 .lp-menu-container .lp-menu > div > ul > li > a{
				 
				<?php if($nav_ff != '') { ?>
					font-family: <?php echo esc_attr($nav_ff); ?>;
				<?php } ?>
				<?php if($nav_fz != '') { ?>
					font-size:<?php echo esc_attr($nav_fz); ?>;
				<?php } ?>
				<?php if($nav_fw != '') { ?>
					font-weight:<?php echo esc_attr($nav_fw); ?>;
				<?php } ?>
				<?php if($nav_col != '') { ?>
					color:<?php echo esc_attr($nav_col); ?>;
				<?php } ?>
				
			}
		<?php } ?>

		<?php if( $bodyff != '' || $bodyfz != '' || $bodyfw != '' || $bodycol != '' || $bodylh != '' ) { ?>
			body{
				<?php if($bodyff != '') { ?>
					font-family: <?php echo esc_attr($bodyff); ?>;
				<?php } ?>
				<?php if($bodyfz != '') { ?>
					font-size:<?php echo esc_attr($bodyfz); ?>;
				<?php } ?>
				<?php if($bodyfw != '') { ?>
					font-weight:<?php echo esc_attr($bodyfw); ?>;
				<?php } ?>
				<?php if($bodycol != '') { ?>
					color:<?php echo esc_attr($bodycol); ?>;
				<?php } ?>
				<?php if($bodylh != '') { ?>
					line-height:<?php echo esc_attr($bodylh); ?>;
				<?php } ?>
			}
		<?php } ?>

		<?php if( $h1ff != '' || $h1fz != '' || $h1fw != '' || $h1col != '' || $h1lh != '' ) { ?>
			h1, h1 a, .lp-h1, .lp-h1 a {
				<?php if($h1ff != '') { ?>
					font-family: <?php echo esc_attr($h1ff); ?>;
				<?php } ?>
				<?php if($h1fz != '') { ?>
					font-size:<?php echo esc_attr($h1fz); ?>;
				<?php } ?>
				<?php if($h1fw != '') { ?>
					font-weight:<?php echo esc_attr($h1fw); ?>;
				<?php } ?>
				<?php if($h1col != '') { ?>
					color:<?php echo esc_attr($h1col); ?>;
				<?php } ?>
				<?php if($h1lh != '') { ?>
					line-height:<?php echo esc_attr($h1lh); ?>;
				<?php } ?>
			}
		<?php } ?>

		<?php if( $h2ff != '' || $h2fz != '' || $h2fw != '' || $h2col != '' || $h2lh != '' ) { ?>
			h2, h2 a, .lp-h2, .lp-h2 a {
				<?php if($h2ff != '') { ?>
					font-family: <?php echo esc_attr($h2ff); ?>;
				<?php } ?>
				<?php if($h2fz != '') { ?>
					font-size:<?php echo esc_attr($h2fz); ?>;
				<?php } ?>
				<?php if($h2fw != '') { ?>
					font-weight:<?php echo esc_attr($h2fw); ?>;
				<?php } ?>
				<?php if($h2col != '') { ?>
					color:<?php echo esc_attr($h2col); ?>;
				<?php } ?>
				<?php if($h2lh != '') { ?>
					line-height:<?php echo esc_attr($h2lh); ?>;
				<?php } ?>
			}
		<?php } ?>

		<?php if( $h3ff != '' || $h3fz != '' || $h3fw != '' || $h3col != '' || $h3lh != '' ) { ?>
			h3, h3 a, .lp-h3, .lp-h3 a {
				<?php if($h3ff != '') { ?>
					font-family: <?php echo esc_attr($h3ff); ?>;
				<?php } ?>
				<?php if($h3fz != '') { ?>
					font-size:<?php echo esc_attr($h3fz); ?>;
				<?php } ?>
				<?php if($h3fw != '') { ?>
					font-weight:<?php echo esc_attr($h3fw); ?>;
				<?php } ?>
				<?php if($h3col != '') { ?>
					color:<?php echo esc_attr($h3col); ?>;
				<?php } ?>
				<?php if($h3lh != '') { ?>
					line-height:<?php echo esc_attr($h3lh); ?>;
				<?php } ?>
			}
		<?php } ?>

		<?php if( $h4ff != '' || $h4fz != '' || $h4fw != '' || $h4col != '' || $h4lh != '' ) { ?>
			h4, .lp-h4, h4 a, .lp-h4 a {
				<?php if($h4ff != '') { ?>
					font-family: <?php echo esc_attr($h4ff); ?>;
				<?php } ?>
				<?php if($h4fz != '') { ?>
					font-size:<?php echo esc_attr($h4fz); ?>;
				<?php } ?>
				<?php if($h4fw != '') { ?>
					font-weight:<?php echo esc_attr($h4fw); ?>;
				<?php } ?>
				<?php if($h4col != '') { ?>
					color:<?php echo esc_attr($h4col); ?>;
				<?php } ?>
				<?php if($h4lh != '') { ?>
					line-height:<?php echo esc_attr($h4lh); ?>;
				<?php } ?>
			}
		<?php } ?>

		<?php if( $h5ff != '' || $h5fz != '' || $h5fw != '' || $h5col != '' || $h5lh != '' ) { ?>
			h5, .lp-h5, h5 a, .lp-h5 a {
				<?php if($h5ff != '') { ?>
					font-family: <?php echo esc_attr($h5ff); ?>;
				<?php } ?>
				<?php if($h5fz != '') { ?>
					font-size:<?php echo esc_attr($h5fz); ?>;
				<?php } ?>
				<?php if($h5fw != '') { ?>
					font-weight:<?php echo esc_attr($h5fw); ?>;
				<?php } ?>
				<?php if($h5col != '') { ?>
					color:<?php echo esc_attr($h5col); ?>;
				<?php } ?>
				<?php if($h5lh != '') { ?>
					line-height:<?php echo esc_attr($bodylh); ?>;
				<?php } ?>
			}
		<?php } ?>
		
		<?php if( $h6ff != '' || $h6fz != '' || $h6fw != '' || $h6col != '' || $h6lh != '' ) { ?>
			h6, .lp-h6, h6 a, .lp-h6 a {
				<?php if($h6ff != '') { ?>
					font-family: <?php echo esc_attr($h6ff); ?>;
				<?php } ?>
				<?php if($h6fz != '') { ?>
					font-size:<?php echo esc_attr($h6fz); ?>;
				<?php } ?>
				<?php if($h6fw != '') { ?>
					font-weight:<?php echo esc_attr($h6fw); ?>;
				<?php } ?>
				<?php if($h6col != '') { ?>
					color:<?php echo esc_attr($h6col); ?>;
				<?php } ?>
				<?php if($h6lh != '') { ?>
					line-height:<?php echo esc_attr($h6lh); ?>;
				<?php } ?>
			}
		<?php } ?>
		
		<?php if( $pff != '' || $pfz != '' || $pfw != '' || $pcol != '' || $plh != '' ) { ?>
			p,span,input,.post-detail-content,li a,.show a,.lp-grid-box-description ul,.chosen-container,.accordion-title,.lp-grid-box-bottom a,time,label,#input-dropdown li a,#input-dropdown span, .lpdoubltimes em {
				<?php if($pff != '') { ?>
					font-family: <?php echo esc_attr($pff); ?>;
				<?php } ?>
				<?php if($pfz != '') { ?>
					font-size:<?php echo esc_attr($pfz); ?>;
				<?php } ?>
				<?php if($pfw != '') { ?>
					font-weight:<?php echo esc_attr($pfw); ?>;
				<?php } ?>
				<?php if($pcol != '') { ?>
					color:<?php echo esc_attr($pcol); ?>;
				<?php } ?>
				<?php if($plh != '') { ?>
					line-height:<?php echo esc_attr($plh); ?>;
				<?php } ?>
			}
		<?php } ?>

    </style>

    <?php
}
add_action('wp_head', 'listingpro_dynamic_options', 100);


function listingpro_dynamic_css_options() {
	global $listingpro_options;
	$css_editor = $listingpro_options['css_editor'];
	?>

    <!-- Custom CSS -->
    <style>
		<?php echo $css_editor; ?>
    </style>
	<?php
}
add_action('wp_head', 'listingpro_dynamic_css_options', 100);


function listingpro_dynamic_js_options() {
	global $listingpro_options;
	$script_editor = $listingpro_options['script_editor'];
	?>

    <!-- Custom CSS -->
    <script type="text/javascript">
		<?php echo $script_editor; ?>
    </script>
	<?php
}
add_action('wp_head', 'listingpro_dynamic_js_options', 100);
?>