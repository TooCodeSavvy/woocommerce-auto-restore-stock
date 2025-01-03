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
        $order = wc_get_order( $order_id ); // Retrieve the order object

        // Ensure stock management is enabled and the order has items
        if ( ! get_option( 'woocommerce_manage_stock' ) == 'yes' || empty( $order->get_items() ) ) {
            return;
        }

        // Loop through each item in the order
        foreach ( $order->get_items() as $item_id => $item ) {
            $product = $item->get_product(); // Get the product object (simple or variation)

            // Check if the product manages stock
            if ( $product && $product->managing_stock() ) {
                $current_stock = $product->get_stock_quantity(); // Get the current stock level before update
                $qty = $item->get_quantity(); // Get the quantity of the product in the order

                // Correct the stock by adjusting based on the original stock level
                $new_stock = $current_stock + $qty;

                // Update the stock with the correct value
                $product->set_stock_quantity( $new_stock );
                $product->save();

                // Reload the product to ensure the stock value is updated
                $product = wc_get_product( $product->get_id() );

                // Add a note to the order for logging purposes
                $order->add_order_note( sprintf(
                    __( 'Stock for item #%s restored to %s.', 'woocommerce' ),
                    $product->get_id(),
                    $product->get_stock_quantity() // Use updated stock value from product object
                ));
            }
        }
    }
}
