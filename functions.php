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

    function hideShippingAddressInput () {
      var inputAddress = jQuery('#shipping_address_1_field, #shipping_address_2_field, #shipping_city_field, #shipping_state_field, #shipping_postcode_field')
      var searchAddress = jQuery('#gac_auto_complete_shipping_address')
      var labelOptional = jQuery('#gac_auto_complete_shipping_address_field label span.optional')

      // hide "(optional") label
      labelOptional.hide()

      // hide address input (when empty)
      if (jQuery('#shipping_address_1').val() === '') inputAddress.hide()

      // show address input on autocomplete blur (when not empty)
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
      
      function focusApartmentField () {
		    jQuery('#gac_auto_complete_shipping_address').focusout(function() {
          window.setTimeout(function () {
            jQuery('#shipping_address_2').focus();
          }, 1000)
        });
      }

    $(document).ready(function () {
      alterHTML()
      focusApartmentField()
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

/** Hide out of stock items **/
add_action( 'pre_get_posts', 'hide_out_of_stock_products' );
function hide_out_of_stock_products( $q ) {
    if ( ! $q->is_main_query() || is_admin() ) {
        return;
    }
    if ( $outofstock_term = get_term_by( 'name', 'outofstock', 'product_visibility' ) ) {
        $tax_query = (array) $q->get('tax_query');
        $tax_query[] = array(
            'taxonomy' => 'product_visibility',
            'field' => 'term_taxonomy_id',
            'terms' => array( $outofstock_term->term_taxonomy_id ),
            'operator' => 'NOT IN'
        );
        $q->set( 'tax_query', $tax_query );
    }
    remove_action( 'pre_get_posts', 'iconic_hide_out_of_stock_products' );
}
