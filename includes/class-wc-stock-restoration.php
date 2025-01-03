<?php

/**
 * Class WC_Stock_Restoration
 *
 * This class is responsible for restoring the stock quantity of products when an order is cancelled or refunded.
 * It listens for order status changes and adjusts the stock levels of all items in the order accordingly.
 * Additionally, it adds order notes detailing the stock restoration for transparency.
 */
class WC_Stock_Restoration {

    /**
     * Restore stock for all items in an order.
     *
     * @param int $order_id The ID of the order being updated.
     */
    public function restore_order_stock( $order_id ) {
        $order = wc_get_order( $order_id );
    
        // Check if stock management is enabled and the order has items
        if ( ! get_option( 'woocommerce_manage_stock' ) == 'yes' || empty( $order->get_items() ) ) {
            return;
        }
    
        // Retrieve saved initial stock levels
        $initial_stock_levels = json_decode( $order->get_meta( '_initial_stock_levels' ), true );
    
        foreach ( $order->get_items() as $item_id => $item ) {
            $product = $item->get_product();
    
            if ( $product && $product->managing_stock() ) {
                $variation_id = $product->get_id();
    
                // Check if initial stock data is available
                if ( isset( $initial_stock_levels[ $variation_id ] ) ) {
                    $original_stock = $initial_stock_levels[ $variation_id ];
                    $current_stock = $product->get_stock_quantity(); // Retrieve current stock value

                    // Restore stock to the original value
                    $product->set_stock_quantity( $original_stock );
                    $product->save();
    
                    // Add an order note with more details
                    $order->add_order_note( sprintf(
                        __( 'Stock for item #%s restored from %s to %s.', 'woocommerce' ),
                        $variation_id,
                        $current_stock,
                        $original_stock
                    ));
                }
            }
        }
    } 
}
