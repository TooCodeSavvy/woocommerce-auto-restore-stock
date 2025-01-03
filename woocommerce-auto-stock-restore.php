<?php
/**
 * Plugin Name: WooCommerce Auto Restore Stock
 * Description: Automatically restores stock for products when orders are cancelled or refunded in WooCommerce.
 * Version: 1.0.2
 * Author: Anouar
 * License: GPL2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WC_Auto_Stock_Restore' ) ) {

    /**
     * Class WC_Auto_Stock_Restore
     * 
     * This class handles the automatic restoration of stock levels when orders are cancelled
     * or refunded in WooCommerce. It listens for specific order status changes and updates
     * product stock levels accordingly.
     */
    class WC_Auto_Stock_Restore {

        /**
         * Constructor for WC_Auto_Stock_Restore.
         * 
         * Initializes the plugin by adding hooks for relevant WooCommerce order status transitions.
         */
        public function __construct() {
            add_action( 'woocommerce_order_status_processing_to_cancelled', array( $this, 'restore_order_stock' ), 10, 1 );
            add_action( 'woocommerce_order_status_completed_to_cancelled', array( $this, 'restore_order_stock' ), 10, 1 );
            add_action( 'woocommerce_order_status_on-hold_to_cancelled', array( $this, 'restore_order_stock' ), 10, 1 );
            add_action( 'woocommerce_order_status_processing_to_refunded', array( $this, 'restore_order_stock' ), 10, 1 );
            add_action( 'woocommerce_order_status_completed_to_refunded', array( $this, 'restore_order_stock' ), 10, 1 );
            add_action( 'woocommerce_order_status_on-hold_to_refunded', array( $this, 'restore_order_stock' ), 10, 1 );
        }

        /**
         * Restore stock for all items in an order.
         * 
         * This method is triggered when an order transitions to a "cancelled" or "refunded" status.
         * It restores stock levels for all products in the order, including variations.
         * 
         * @param int $order_id The ID of the order being updated.
         */
        public function restore_order_stock( $order_id ) {
			$order = wc_get_order( $order_id ); // Retrieve the order object.
		
			// Ensure stock management is enabled and the order has items.
			if ( ! get_option('woocommerce_manage_stock') == 'yes' || empty( $order->get_items() ) ) {
				return;
			}
		
			// Loop through each item in the order.
			foreach ( $order->get_items() as $item_id => $item ) {
				$product = $item->get_product(); // Get the product object (simple or variation).

				// Check if the product manages stock.
				if ( $product && $product->managing_stock() ) {
					$current_stock = $product->get_stock_quantity(); // Get the current stock level before update
					$qty = $item->get_quantity(); // Get the quantity of the product in the order

					// Correct the stock by adjusting based on the original stock level.
					$new_stock = $current_stock + $qty;

					// Update the stock with the correct value.
					$product->set_stock_quantity( $new_stock );
					$product->save();

					// Reload the product to ensure the stock value is updated.
					$product = wc_get_product( $product->get_id() );

					// Add a note to the order for logging purposes.
					$order->add_order_note( sprintf(
						__( 'Stock for item #%s restored to %s.', 'woocommerce' ),
						$product->get_id(),
						$product->get_stock_quantity() // Use updated stock value from product object
					));
				}
			}
		}		
    }

    // Initialize the plugin by creating an instance of the class.
    $GLOBALS['wc_auto_stock_restore'] = new WC_Auto_Stock_Restore();
}
