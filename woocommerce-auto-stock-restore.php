<?php
/**
 * Plugin Name: WooCommerce Auto Restore Stock
 * Description: Automatically restores stock for products when orders are cancelled or refunded in WooCommerce.
 * Version: 1.0.3
 * Author: Anouar
 * License: GPL2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Include necessary files
require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc-auto-stock-restore.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc-stock-restoration.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc-stock-update-on-new-order.php';

// Initialize the plugin
function wc_auto_stock_restore_init() {
    $restore = new WC_Stock_Restoration();
    $update_on_new_order = new WC_Stock_Update_On_New_Order();
    
    // Initialize plugin logic
    new WC_Auto_Stock_Restore( $restore, $update_on_new_order );
}

add_action( 'plugins_loaded', 'wc_auto_stock_restore_init' );
