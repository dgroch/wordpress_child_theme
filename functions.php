<?php

/** Bundle Up-Sells UX **/
add_action( 'wp_footer', 'bundle_upsells' );
function bundle_upsells() {
	?>
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
	<?php
}

/** Manage Delivery Location State **/
add_action( 'wp_footer', 'manage_delivery_location_state' );
function manage_delivery_location_state() {
	?>
	<script>
		var pageUrl = window.location.href
		
    var isMelbourne = RegExp('city=melbourne').test(pageUrl) || RegExp('/flower-delivery/melbourne').test(pageUrl)
		var isSydney = RegExp('city=sydney').test(pageUrl) || RegExp('/flower-delivery/sydney').test(pageUrl)
		var isBrisbane = RegExp('city=brisbane').test(pageUrl) || RegExp('/qld/brisbane').test(pageUrl)
		var isRestOfAustralia = RegExp('city=rest-of-australia').test(pageUrl)
    
		var productTag = RegExp('/product-tag/')
		var productCategory = RegExp('/product-category/')
		var shopLink = RegExp('/shop')
		
		function append (city) {
			jQuery('a').each(function (i) {
				var url = jQuery(this).attr('href')
				
				if (productTag.test(url) || productCategory.test(url)) {
					if (RegExp('city=').test(url)) return
					jQuery(this).attr('href', url + '?filter_city=' + city)
				}
				
				if (shopLink.test(url) ||
				    url === 'https://www.figandbloom.com.au' ||
				    url === 'https://www.figandbloom.com.au/') {
				  if (RegExp('city=').test(url)) return
				  jQuery(this).attr('href', url + '?attribute_pa_city=' + city)
				}					
			}) 
		}
		
		jQuery(document).ready(function () {
			if (isMelbourne) append('melbourne')
			if (isSydney) append('sydney')
			if (isBrisbane) append('brisbane')
    		if (isRestOfAustralia) append('rest-of-australia')	
		})
	</script>
	<?php
}

/** Add Javascript to Checkout page */
add_action( 'woocommerce_after_checkout_form', 'add_checkout_page_js');
function add_checkout_page_js() {
  ?>
  <script type="text/javascript">window.jQuery(function ($) {
    function createAccountTrue () {
      window.jQuery('#createaccount').prop('checked', true)
    }

    function alterHTML () {
      jQuery('.shipping_address').prepend('<h3 style="margin-top: 0; margin-bottom: 15px;">Delivery details</h3>')
    }

    function reduceCheckoutAbandonment () {
      var pattern = RegExp('/checkout/')
      if (pattern.test(window.location.href)) {
        // disable logo link
        window.jQuery('.logolink').prop('href', '/cart/')
        // hide header on desktop
        window.jQuery('.menu-holder').children().hide()
        window.jQuery('.menu-holder').prepend('<li style="list-style-type:none;" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-9330"><a href="javascript:history.back()">🠐 Back to Cart</a></li>')
        // hide header on mobile
        jQuery('header').children().hide()
        jQuery('header').prepend('<a style="padding-left:1rem; font-size: 1.2rem;" href="javascript:history.back()">🠐 Back to Cart</a>')
        // hide the footer
        window.jQuery('footer').css('background', '#fff').children().hide()
      }
    }

    /***
     * rejectInvalidMessageLength :: limit the length of gift card messages to 200 characters
     */
    function rejectInvalidMessageLength () {

      // Message limit doesn't apply to premium Greeting Cards
      const cartContainsGreetingCard = jQuery('.product-name')
        .filter(function (idx, item) {
          return jQuery(this).html().toLowerCase().includes('card')
        }).length > 0

      if (cartContainsGreetingCard) return

      var id = 'id="char_count_container"'
      var style = 'style="margin-left:10px;color:#2ecc71;font-weight:bold"'
      var limit = 200
      var curr = 0

      window.jQuery('#order_comments_field > label')
        .append('<span  ' + id + style + '>(<span id="char_count_val">' + limit + '</span> chars remaining)</span>')

      window.jQuery('#order_comments').keyup(function (evt) {
        curr = evt.target.value.length
        if (curr >= limit) {
          window.jQuery('#char_count_val').text(0)
          window.jQuery('#char_count_container').css('color', '#e74c3c')
          window.jQuery('#order_comments').css('border', '1px solid #e74c3c')
          window.jQuery('#order_comments').val(evt.target.value.slice(0, limit))
        } else {
          window.jQuery('#char_count_val').text(limit - curr)
          window.jQuery('#char_count_container').css('color', '#2ecc71')
          window.jQuery('#order_comments').css('border', '1px solid #e5e5e5')
        }
      })
    }
		  
   function hideDeliveryDateWhenPostcodeEmpty () {
     	window.setInterval(function () {
		jQuery("#shipping_postcode").val() === ""
			? jQuery("#e_deliverydate_field").hide()
			: jQuery("#e_deliverydate_field").show();
	}, 1000)
   }

    $(document).ready(function () {
	    alterHTML()
	    createAccountTrue()
	    reduceCheckoutAbandonment()
	    rejectInvalidMessageLength()
	    hideDeliveryDateWhenPostcodeEmpty()
    })
  })
  </script>
  <?php

}


/** Add Javascript to Cart page */
add_action('woocommerce_after_cart', 'add_cart_page_js');
function add_cart_page_js() {
  ?>
  <script type="text/javascript">window.jQuery(function ($) {
    /** Hide Coupon Input */
    function hideCouponFromCart () {
      var isViewingCart = RegExp("cart").test(window.location.href)
      if (!isViewingCart) return
      window.setInterval(function () {
        window.jQuery(".coupon").hide()
      }, 250)
    }

    $(document).ready(function () {
      hideCouponFromCart()
    })
  })
  </script>
  <?php
}


/* MSFT Conversion Event Tracking */
add_action( 'woocommerce_thankyou', 'msft_tracking_thank_you_page' );
function msft_tracking_thank_you_page($order_id) {
		if ( $order_id > 0 ) {
			$order = wc_get_order( $order_id );
			if ( $order instanceof WC_Order ) {
				$order_total = $order->get_subtotal();
				?>
                <script type="text/javascript">
			let subTotal = '<?php echo $order_total ?>';
			subTotal = subTotal.replace(/,/, '');
			window.uetq = window.uetq || [];window.uetq.push('event', '', {"revenue_value":subTotal,"currency":"AUD"});
                </script>
				<?php
			}
		}
}


/*** Create User Account on Guest Checkout ***/
function wc_register_guests( $order_id ) {
  // get all the order data
  $order = new WC_Order($order_id);
  
  //get the user email from the order
  $order_email = $order->billing_email;
    
  // check if there are any users with the billing email as user or email
  $email = email_exists( $order_email );  
  $user = username_exists( $order_email );
  
  // if the UID is null, then it's a guest checkout
  if( $user == false && $email == false ){
    
    // random password with 12 chars
    $random_password = wp_generate_password();
    
    // create new user with email as username & newly created pw
    $user_id = wp_create_user( $order_email, $random_password, $order_email );
    
    //WC guest customer identification
    update_user_meta( $user_id, 'guest', 'yes' );
 
    //user's billing data
    update_user_meta( $user_id, 'first_name', $order->billing_first_name );
    update_user_meta( $user_id, 'last_name', $order->billing_last_name );
    update_user_meta( $user_id, 'billing_company', $order->billing_company );
    update_user_meta( $user_id, 'billing_email', $order->billing_email );
    update_user_meta( $user_id, 'billing_first_name', $order->billing_first_name );
    update_user_meta( $user_id, 'billing_last_name', $order->billing_last_name );
    update_user_meta( $user_id, 'billing_phone', $order->billing_phone );
    //update_user_meta( $user_id, 'billing_postcode', $order->billing_postcode );
    //update_user_meta( $user_id, 'billing_state', $order->billing_state );
    //update_user_meta( $user_id, 'billing_address_1', $order->billing_address_1 );
    //update_user_meta( $user_id, 'billing_address_2', $order->billing_address_2 );
    //update_user_meta( $user_id, 'billing_city', $order->billing_city );
    //update_user_meta( $user_id, 'billing_country', $order->billing_country );
    
    // user's shipping data
    // update_user_meta( $user_id, 'shipping_address_1', $order->shipping_address_1 );
    // update_user_meta( $user_id, 'shipping_address_2', $order->shipping_address_2 );
    // update_user_meta( $user_id, 'shipping_city', $order->shipping_city );
    // update_user_meta( $user_id, 'shipping_company', $order->shipping_company );
    // update_user_meta( $user_id, 'shipping_country', $order->shipping_country );
    // update_user_meta( $user_id, 'shipping_first_name', $order->shipping_first_name );
    // update_user_meta( $user_id, 'shipping_last_name', $order->shipping_last_name );
    // update_user_meta( $user_id, 'shipping_method', $order->shipping_method );
    // update_user_meta( $user_id, 'shipping_postcode', $order->shipping_postcode );
    // update_user_meta( $user_id, 'shipping_state', $order->shipping_state );
    
    // link past orders to this newly created customer
    wc_update_new_customer_past_orders( $user_id );
  }
  
}
 
//add this newly created function to the thank you page
add_action( 'woocommerce_thankyou', 'wc_register_guests', 10, 1 );

add_filter( 'woocommerce_loop_add_to_cart_link', 'replacing_add_to_cart_button', 10, 2 );
function replacing_add_to_cart_button( $button, $product  ) {
    $button_text = __("View product", "woocommerce");
    $button = '<a class="button" href="' . $product->get_permalink() . '">' . $button_text . '</a>';

    return $button;
}
