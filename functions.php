<?php

/** Add Javascript to Checkout page */
add_action( 'woocommerce_after_checkout_form', 'add_checkout_page_js');
function add_checkout_page_js() {
  ?>
  <script type="text/javascript">window.jQuery(function ($) {
    function createAccountTrue () {
      window.jQuery('#createaccount').prop('checked', true)
    }

    function alterHTML () {
      $('#e_deliverydate_field').prepend('<h3>Delivery details</h3>')
    }

    function hideShippingAddressInput () {
      var inputAddress = jQuery('#shipping_address_1_field, #shipping_address_2_field, #shipping_city_field, #shipping_state_field, #shipping_postcode_field')
      var searchAddress = jQuery('#gac_auto_complete_shipping_address')
      var labelOptional = jQuery('#gac_auto_complete_shipping_address_field label span.optional')

      // hide by default
      inputAddress.hide()
      labelOptional.hide()

      // show on blur (if not empty)
      searchAddress.blur(function () {
        var text = jQuery(this).val()
        console.log(text)
        if (text === '') return
        inputAddress.show()
      })
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

    $(document).ready(function () {
      alterHTML()
      hideShippingAddressInput()
      createAccountTrue()
      reduceCheckoutAbandonment()
      rejectInvalidMessageLength()
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


/* Convert Revenue Tracking */
add_action( 'woocommerce_thankyou', 'cf_conversion_tracking_thank_you_page' );
function cf_conversion_tracking_thank_you_page($order_id) {
	if(!isset($_COOKIE['cfconversioncounted'])){
		if ( $order_id > 0 ) {
			$order = wc_get_order( $order_id );
			if ( $order instanceof WC_Order ) {
				$order_total = $order->get_subtotal();
				$item_count = $order->get_item_count();
				?>
                <script type="text/javascript">
                    let subTotal = '<?php echo $order_total ?>';
					let prodCount = '<?php echo $item_count ?>';
					
					subTotal = subTotal.replace(/,/, '');
					
					window._conv_q = window._conv_q || [];
    				window._conv_q.push(["pushRevenue", subTotal, prodCount, 100312454]);
                </script>
				<?php
				setcookie('cfconversioncounted', 'true');
			}
		}
	}
}