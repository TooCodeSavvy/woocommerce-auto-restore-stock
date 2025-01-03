<?php

/**
 * Class WC_Stock_Update_On_New_Order
 *
 * This class handles the functionality of adding an order note with the current stock level
 * of each product in the order when a new order is created.
 * It checks if WooCommerce's stock management is enabled, and for each item in the order,
 * it records the initial stock quantity.
 */
class WC_Stock_Update_On_New_Order {

    /**
     * Add stock note to the order when it is created
     *
     * @param int $order_id The ID of the new order
     */
    public function add_stock_on_new_order( $order_id ) {
        $order = wc_get_order( $order_id ); // Get the order object

        // Ensure stock management is enabled and the order has items
        if ( ! get_option( 'woocommerce_manage_stock' ) == 'yes' || empty( $order->get_items() ) ) {
            return;
        }

        $initial_stock_data = []; // Initialize an array to store stock data

        foreach ( $order->get_items() as $item_id => $item ) {
            $product = $item->get_product();
            
            if ( $product && $product->managing_stock() ) {
                $variation_id = $product->get_id(); // For variations, this is the variation ID
                
                // Add the current stock level to an array with variation or product ID as the key
                $initial_stock_data[ $variation_id ] = $product->get_stock_quantity(); 
            }
        }
        
        // Save the stock data as order meta
        $order->update_meta_data( '_initial_stock_levels', json_encode( $initial_stock_data ) );
        $order->save(); 
    }
}
