<?php
/**
 * Admin new order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/admin-new-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails/HTML
 * @version 4.0.0
 */

 if ( ! defined( 'ABSPATH' ) ) {
 	exit;
 }

 /**
  * @hooked WC_Emails::email_header() Output the email header
  */
 do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
<tr>
  <td valign="top" id="templateBody">
    <div>
        <h4><?php printf( __( 'You have received an order from %s. The order is as follows:', 'woocommerce' ), $order->get_formatted_billing_full_name() ); ?></h4>
        <div class="spacer 50px"></div>
        <h2 style="margin-bottom:20px;">Here's order details</h2>
        <p style="font-weight:bold;">Order #<?php echo $order->get_order_number();?></p>
        <?php
            /** Add the field to order emails */                                                                            
            add_filter('woocommerce_email_order_meta_keys', 'my_woocommerce_email_order_meta_keys');
                                                    
            function my_woocommerce_email_order_meta_keys( $keys ) {                        
                $keys['Delivery Suburb'] = 'shipping_suburbs_limited';                        
                $keys['Delivery Date'] = 'Delivery Date';                                     
                return $keys;                                                                 
            }                                                                               

            /** @hooked WC_Emails::order_meta() Shows order meta data */
            do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );                                                                                 

            /** show delivery suburb */
            $keys['Delivery Suburb'] = 'shipping_suburbs_limited';                          

            /** show delivery date */
            $keys['Delivery Date'] = 'Delivery Date'; 
        ?>
        <?php do_action('woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email ); ?>
        <?php do_action('woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email ); ?>
    </div>
    <div class="spacer 20px"></div>
  </td>
</tr>
<?php do_action( 'woocommerce_email_footer', $email ); ?>
