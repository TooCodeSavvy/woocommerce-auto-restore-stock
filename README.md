=== WooCommerce Auto Restore Stock ===
Tags: WooCommerce, stock, inventory, restore, cancelled, refunded
Requires at least: 3.7
Stable tag: 1.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Automatically restores WooCommerce inventory/stock for orders that are cancelled or refunded.

== Description ==

WooCommerce Auto Restore Stock automatically restores your WooCommerce inventory/stock for orders that are cancelled or refunded.

The stock restoration process is triggered when an order transitions from **On-Hold**, **Processing**, or **Completed** to either **Cancelled** or **Refunded** status.

When stock is restored, the plugin also adds an order note to provide transparency about the changes. These notes indicate the adjusted stock values and confirm that the inventory has been restored.

Key Features:
* Automatically restores stock for simple and variable products.
* Adds detailed order notes for transparency and tracking.
* Seamlessly integrates with WooCommerce's stock management system.

== Installation ==

1. Upload the `woocommerce-auto-stock-restore` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the **Plugins** menu in WordPress.
3. Test by cancelling or refunding an **On-Hold**, **Processing**, or **Completed** order to see the inventory/stock restored.

== Frequently Asked Questions ==

= Does this work with variable products? =
Yes, the plugin supports both simple and variable products.

= What happens if WooCommerce stock management is disabled? =
The plugin will not take any action if stock management is disabled in WooCommerce settings.

= Can I see the stock changes in the order? =
Yes, the plugin adds order notes detailing the restored stock levels for full transparency.

== Changelog ==

= 1.0.2 =
* Improved code for compatibility with modern WooCommerce methods.
* Enhanced support for variable products.
* Updated documentation and added comprehensive comments to the code.

= 1.0.1 =
* Added `woocommerce_auto_stock_restored` action.

= 1.0.0 =
* Initial release.
