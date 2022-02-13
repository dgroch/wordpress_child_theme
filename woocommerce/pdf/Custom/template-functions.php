<?php
/**
 * Use this file for all your template filters and actions.
 * Requires WooCommerce PDF Invoices & Packing Slips 1.4.13 or higher
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


add_action( 'wpo_wcpdf_after_order_data', 'wpo_wcpdf_delivery_date', 10, 2 );
function wpo_wcpdf_delivery_date ($document_type, $order) {
    $document = wcpdf_get_document( $document_type, $order );
    if ($document_type == 'invoice') {
        ?>
        <tr class="delivery-date">            
            <td><?php $document->custom_field('order-delivery-date'); ?></td>
        </tr>
        <?php
    }
}
