<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<!-- begin Convert Experiences code -->
	<script type="text/javascript" src="https://cdn-3.convertexperiments.com/js/10035135-10033102.js"></script>
	<!-- end Convert Experiences code -->
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="stylesheet" href="https://use.typekit.net/afz8uqm.css">
	<?php wp_site_icon(); ?>
	<?php 
		/* 	Always have wp_head() just before the closing </head>
		 ** 	tag of your theme, or you will break many plugins, which
		 ** 	generally use this hook to add elements to <head> such
		 ** 	as styles, scripts, and meta and tags.
		**/
		wp_head(); 
	?>
  
	<!-- Hotjar Tracking Code for https://www.figandbloom.com.au/ -->
	<script>
    	(function(h,o,t,j,a,r){
        	h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        	h._hjSettings={hjid:2276363,hjsv:6};
       		a=o.getElementsByTagName('head')[0];
        	r=o.createElement('script');r.async=1;
        	r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        	a.appendChild(r);
    	})(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
	</script>
	<script>
		jQuery(document).ready(function () {
			var pattern = RegExp('/product/')
			if (pattern.test(window.location.href)) {
				// Append DOM elements
				var bundledProduct = jQuery('.bundled_product')
				bundledProduct.append('<img class="round_tick inactive" src="/wp-content/uploads/2021/05/round-tick-f8f8f8.png">')
				bundledProduct.append('<img class="round_tick active" src="/wp-content/uploads/2021/05/round-tick-0fbd4e.png">')

				// Automatically select in-stock items
				bundledProduct.each(function (index, element) {
					var int = index + 1
					var el = jQuery(this)
					var el_2 = jQuery('.bundled_item_' + int)
					var isInStock = el.find('.details > .out-of-stock').length == 0
					
					el.append('<div id="cta_' + int + '" class="bundled_cta">Save 10% when you bundle.</div>')

					if (isInStock) {
						el.addClass('selected')
						el.find('.bundled_product_checkbox').prop({checked: true})
						
						jQuery('.bundled_item_' + int + ' .round_tick.active').click(function () {
							el_2.removeClass('selected')
							el_2.find('.bundled_product_checkbox').prop({checked: false})
						})
						
						jQuery('.bundled_item_' + int + ' .round_tick.inactive').click(function () {
							el_2.addClass('selected')
							el_2.find('.bundled_product_checkbox').prop({checked: true})
						})						
						
						jQuery('#cta_' + int).click(function () {
							var isSelected = el_2.find('.bundled_product_checkbox').prop('checked')
							console.log(isSelected + int)
							if (isSelected) {
								el_2.removeClass('selected')
								el_2.find('.bundled_product_checkbox').prop({checked: false})
							} else {
								el_2.addClass('selected')
								el_2.find('.bundled_product_checkbox').prop({checked: true})
							}
						})
					} else {
						el.addClass('deselected')
					}
				})
			}
		})
	</script>
	<script type="text/javascript" src="https://cdn-3.convertexperiments.com/js/10035135-10033102.js"></script>
</head>
<body <?php body_class(); ?>>
	<?php if ( function_exists( 'gtm4wp_the_gtm_tag' ) ) { gtm4wp_the_gtm_tag(); } ?>
	<div id="wrapper" class="open">
	<?php get_template_part( 'inc/templates/header/mobile-menu' ); ?>
	
			<!-- Start Side Cart -->
					<?php do_action( 'thb_side_cart' ); ?>
			<!-- End Side Cart -->
					
	<!-- Start Shop Filters -->
	<?php do_action( 'thb_shop_filters' ); ?>
	<!-- End Shop Filters -->
	
	<!-- Start Content Click Capture -->
	<div class="click-capture"></div>
	<!-- End Content Click Capture -->
	
	<!-- Start Global Notification -->
	<?php get_template_part( 'inc/templates/header/global-notification' ); ?>
	<!-- End Global Notification -->
	
	<!-- Start Header --> 
	<?php get_template_part( 'inc/templates/header/header-'.ot_get_option('header_style','style1') ); ?>
	<!-- End Header -->

	<div role="main">
