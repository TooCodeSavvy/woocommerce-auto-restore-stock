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

        // Loop through each item in the order
        foreach ( $order->get_items() as $item_id => $item ) {
            $product = $item->get_product(); // Get the product object (simple or variation)

            // Check if the product manages stock
            if ( $product && $product->managing_stock() ) {
                $current_stock = $product->get_stock_quantity(); // Get the current stock value

                // Add a note to the order about the current stock level
                $order->add_order_note( sprintf(
                    __( 'Initial stock for item #%s is %s.', 'woocommerce' ),
                    $product->get_id(),
                    $current_stock // Display the current stock value
                ));
            }
        }
    }
}
