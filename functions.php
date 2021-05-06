<?php

/** Add momentJS to footer */
add_action('wp_footer', 'add_moment_js_to_footer');
function add_moment_js_to_footer() {
  ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
  <?php
}


/** Add Javascript to Checkout page */
add_action( 'woocommerce_after_checkout_form', 'add_checkout_page_js');
function add_checkout_page_js() {
  ?>
  <script type="text/javascript">window.jQuery(function ($) {
    function isPastOrderDeadline () {
      var dateString = window.jQuery('#delivery_date').val()
      var date = window.moment(dateString, 'MMMM DD, YYYY')
      var isSameDate = window.moment().isSame(date, 'day')
      var isPastHour = window.moment().hour() >= 13
      var isPastMinute = window.moment().minute() > 10
      return isSameDate && isPastHour && isPastMinute
    }

    function isInThePast () {
      var userInput = window.jQuery('#delivery_date').val()
      var dateDelivery = window.moment(userInput, 'MMMM DD, YYYY').hour(12).minute(0)
      var dateToday = window.moment().hour(12).minute(0)
      return dateDelivery.diff(dateToday, 'minutes') <= -1440
    }

    function createAccountTrue () {
      window.jQuery('#createaccount').prop('checked', true)
    }

    function alterHTML () {
      $('.woocommerce-shipping-fields__field-wrapper').prepend('<h3>Delivery details</h3>')
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

    function rejectInvalidDeliveryDate () {
      function getDeliveryCity () {
        // input must exist
        var el = window.jQuery('#shipping_postcode')
        if (!el.val()) return

        // input must be 4 characters
        var input = el.val().trim()
        if (input.length < 4) {
          throw new Error('Invalid postcode. Length must be 4.')
        }

        var firstChar = input.slice(0, 1)
        switch (firstChar) {
          case '2': {
            return 'Sydney'
          }
          case '3': {
            return 'Melbourne'
          }
          default: {
      return 'Other'
            //return null
          }
        }
      }

      function checkIsClosedForHoliday (city, date) {
        console.log('Checking for holiday closure', city, date)
        var message = ''
        var closures = [
          {
            city: ['Melbourne', 'Sydney'],
            date: 'May 6, 2021',
            message: "Sorry, we have reached capacity for deliveries today. Please choose another day."
          },
          {
            city: ['Sydney'],
            date: 'May 7, 2021',
            message: "Sorry, we have reached capacity for deliveries today. Please choose another day."
          },
          {
            city: ['Melbourne', 'Sydney'],
            date: 'May 9, 2021',
            message: "Sorry, we have reached capacity for deliveries today. Please choose another day."
          },
          {
            city: ['Melbourne', 'Sydney'],
            date: 'May 16, 2021',
            message: "Sorry, we are closed on Sunday (except Mother's Day)."
          },
          {
            city: ['Melbourne', 'Sydney'],
            date: 'May 23, 2021',
            message: "Sorry, we are closed on Sunday (except Mother's Day)."
          },
          {
            city: ['Melbourne', 'Sydney'],
            date: 'May 30, 2021',
            message: "Sorry, we are closed on Sunday (except Mother's Day)."
          }
        ]

        for (var i = 0; i < closures.length; i++) {
          var closure = closures[i]
          if (closure.date === date) {
            for (var j = 0; j < closure.city.length; j++) {
              if (closure.city[j] === city) {
                message = closure.message
              }
            }
          }
        }

        return message
      }

      function checkIsClosedWeekday (day) {
        if (!(day >= 0 && day <= 6)) {
          console.error('Range error. Expect number between 0-6')
          return 'Unexpected error. Please check postcode is valid.'
        }
        // alert on invalid postcode
        var city = getDeliveryCity()
        if (!city) {
          return 'Please enter valid postcode before choosing delivery date.'
        }
        // alert on store closure
        var messages = {
          'Sydney': [
            /* Sunday */
            '',
            /* Monday */
            '',
            /* Tuesday */
            '',
            /* Wednesday */
            '',
            /* Thursday */
            '',
            /* Friday */
            '',
            /* Saturday */
            ''
          ],
          'Melbourne': [
            /* Sunday */
            '',
            /* Monday */
            '',
            /* Tuesday */
            '',
            /* Wednesday */
            '',
            /* Thursday */
            '',
            /* Friday */
            '',
            /* Saturday */
            ''
          ]
        }
        return messages[city][day]
      }

      window.jQuery('#delivery_date').change(function (event) {
        // Only run of moment library is available
        if (!window.moment) return

        // Sanitize string input and convert to integer
        var input = window.jQuery(this).val().trim()
        if (input === '') return

        // Transform text input to integer with range 0 - 6
        var dayInt = window.moment(input, 'MMMM D, YYYY').weekday()

        // Log error if shop is closed
        try {
          var city = getDeliveryCity()

          var rejectSameDayDelivery = isPastOrderDeadline()
          if (rejectSameDayDelivery) {
            window.alert('You missed our 1 pm cut-off for delivery today. Please choose a different date.')
            window.jQuery(this).val('')
            return
          }

          var rejectTimeTravel = isInThePast()
          if (rejectTimeTravel) {
            window.alert('Selected date is the past. Please choose a different date.')
            window.jQuery(this).val('')
            return
          }

          var holidayClosureMessage = checkIsClosedForHoliday(city, input)
          if (holidayClosureMessage) {
            window.alert(holidayClosureMessage)
            window.jQuery(this).val('')
            return
          }

          var weekdayClosureMessage = checkIsClosedWeekday(dayInt)
          if (weekdayClosureMessage) {
            window.alert(weekdayClosureMessage)
            window.jQuery(this).val('')
            return
          }
        } catch (e) {
          console.error(e)
        }
      })
    }

    /***
     * rejectInvalidMessageLength :: limit the length of gift card messages to 200 characters
     */
    function rejectInvalidMessageLength () {
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

    function showCountdownTimer () {
      if (window.moment().hour() === 12) {
        var element = '<div style="width:100%; padding: 20px 0; background-color:#ff7675; ' +
          'position: fixed; bottom:0px; z-index:1000; color:white; text-align:center; ' +
          'font-weight: bold;">Order before 1 pm for same day delivery.</div>'

        window.jQuery('body').append(element)
      }
    }

    $(document).ready(function () {
      alterHTML()
      createAccountTrue()
      reduceCheckoutAbandonment()
      rejectInvalidDeliveryDate()
      rejectInvalidMessageLength()
      showCountdownTimer()
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