<?php

/**
 * Class WC_Auto_Stock_Restore
 *
 * This class manages the auto restoration of stock when orders are cancelled or refunded.
 * It also adds stock-related notes when new orders are created.
 * Dependencies include the WC_Stock_Restoration and WC_Stock_Update_On_New_Order classes.
 */
class WC_Auto_Stock_Restore {
    private $stock_restoration;
    private $stock_update_on_new_order;

    /**
     * Constructor to initialize the plugin with required dependencies
     *
     * @param WC_Stock_Restoration $stock_restoration
     * @param WC_Stock_Update_On_New_Order $stock_update_on_new_order
     */
    public function __construct( WC_Stock_Restoration $stock_restoration, WC_Stock_Update_On_New_Order $stock_update_on_new_order ) {
        $this->stock_restoration = $stock_restoration;
        $this->stock_update_on_new_order = $stock_update_on_new_order;
        
        // Register hooks
        $this->register_hooks();
    }

    /**
     * Register necessary hooks for order statuses and new order
     */
    public function register_hooks() {
        // Hook for stock restoration when order status changes to cancelled or refunded
        add_action( 'woocommerce_order_status_processing_to_cancelled', [ $this->stock_restoration, 'restore_order_stock' ], 10, 1 );
        add_action( 'woocommerce_order_status_completed_to_cancelled', [ $this->stock_restoration, 'restore_order_stock' ], 10, 1 );
        add_action( 'woocommerce_order_status_on-hold_to_cancelled', [ $this->stock_restoration, 'restore_order_stock' ], 10, 1 );
        add_action( 'woocommerce_order_status_processing_to_refunded', [ $this->stock_restoration, 'restore_order_stock' ], 10, 1 );
        add_action( 'woocommerce_order_status_completed_to_refunded', [ $this->stock_restoration, 'restore_order_stock' ], 10, 1 );
        add_action( 'woocommerce_order_status_on-hold_to_refunded', [ $this->stock_restoration, 'restore_order_stock' ], 10, 1 );

        // Hook for adding stock note when a new order is created
        add_action( 'woocommerce_new_order', [ $this->stock_update_on_new_order, 'add_stock_on_new_order' ], 10, 1 );
    }
}
