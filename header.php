<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<script src="https://www.googleoptimize.com/optimize.js?id=GTM-TNV6NPT"></script>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<link rel="stylesheet" href="https://use.typekit.net/afz8uqm.css">
	<script src="https://kit.fontawesome.com/57dce5af35.js" crossorigin="anonymous"></script>
	<script>
		(function(w, d, t, r, u) {
			var f, n, i;
			w[u] = w[u] || [], f = function() {
				var o = {
					ti: "56340856"
				};
				o.q = w[u], w[u] = new UET(o), w[u].push("pageLoad")
			}, n = d.createElement(t), n.src = r, n.async = 1, n.onload = n.onreadystatechange = function() {
				var s = this.readyState;
				s && s !== "loaded" && s !== "complete" || (f(), n.onload = n.onreadystatechange = null)
			}, i = d.getElementsByTagName(t)[0], i.parentNode.insertBefore(n, i)
		})(window, document, "script", "//bat.bing.com/bat.js", "uetq");
	</script>
	<?php wp_site_icon(); ?>
	<script>
		window.__productReviewSettings = {
			brandId: '63ff9589-2d85-46ff-a083-e83b5d7007a1'
		};
	</script>
	<script src="https://cdn.productreview.com.au/assets/widgets/loader.js" async></script>
	<?php
	/* 	Always have wp_head() just before the closing </head>
		 ** 	tag of your theme, or you will break many plugins, which
		 ** 	generally use this hook to add elements to <head> such
		 ** 	as styles, scripts, and meta and tags.
		**/
	wp_head();
	?>
</head>

<body <?php body_class(); ?>>
	<?php if (function_exists('gtm4wp_the_gtm_tag')) {
		gtm4wp_the_gtm_tag();
	} ?>
	<div id="wrapper" class="open">
		<?php get_template_part('inc/templates/header/mobile-menu'); ?>

		<!-- Start Side Cart -->
		<?php do_action('thb_side_cart'); ?>
		<!-- End Side Cart -->

		<!-- Start Shop Filters -->
		<?php do_action('thb_shop_filters'); ?>
		<!-- End Shop Filters -->

		<!-- Start Content Click Capture -->
		<div class="click-capture"></div>
		<!-- End Content Click Capture -->

		<!-- Start Global Notification -->
		<?php get_template_part('inc/templates/header/global-notification'); ?>
		<!-- End Global Notification -->

		<!-- Start Header -->
		<?php get_template_part('inc/templates/header/header-' . ot_get_option('header_style', 'style1')); ?>
		<!-- End Header -->
		<div class="my_new_popup" style="display:none">

			<div class="my-overlay">
				<div class="my-overlay-mask"></div>
				<div class="my-overlay-container">

					<div class="my-overlay-content">
						<h2 id="popup_head_ing">Where are we</br>delivering?</h2>
						<div style="z-index: 999991;" class="ui-widget">
							<input style="z-index: 999991;" id="location" placeholder="Start typing...">
							<ul style="z-index: 999991;" id="locations"></ul>
						</div>
						<button disabled type="submit" id="confirm-location" name="confirm-location" value="203444" class="button alt">Confirm</button>
					</div>
				</div>
				<div class="close_popup_btn" style="display:none">

				</div>

			</div>
		</div>
		<div class="my_new_trigger_popup" style="display:none">
			<div class="my-overlay">
				<div class="my-overlay-mask"></div>
				<div class="my-overlay-container">
					<div class="my-overlay-content">
						<h2 id="popup_head_ing">Where are we</br>delivering?</h2>
						<div style="z-index: 999991;" class="ui-widget">
							<input style="z-index: 999991;" id="location" placeholder="Start typing...">
							<ul style="z-index: 999991;" id="locations"></ul>
						</div>
						<button disabled type="submit" id="confirm-location" name="confirm-location" value="203444" class="button alt">Confirm</button>
					</div>
				</div>
				<div class="close_popup_btn">
				</div>
			</div>
		</div>