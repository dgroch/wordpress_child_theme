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
