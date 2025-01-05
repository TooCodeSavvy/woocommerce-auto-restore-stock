### WooCommerce Auto Restore Stock

**Tags:** WooCommerce, stock, inventory, restore, cancelled\
**Requires at least:** 3.7\
**Stable tag:** 1.0.4\
**License:** GPLv2 or later\
**License URI:** <http://www.gnu.org/licenses/gpl-2.0.html>

Automatically restores WooCommerce inventory/stock for orders that are cancelled.

---

### Description

WooCommerce Auto Restore Stock automatically restores your WooCommerce inventory/stock for orders that are cancelled.

The stock restoration process is triggered when an order transitions from **On-Hold**, **Processing**, or **Completed** to **Cancelled** status.

When stock is restored, the plugin also adds an order note to provide transparency about the changes. These notes indicate the adjusted stock values and confirm that the inventory has been restored. Additionally, stock information is added to new orders, ensuring that the stock value is logged for transparency from the start.

---

### File Structure:

```
/woocommerce-auto-stock-restore
├── /includes
│   ├── class-wc-auto-stock-restore.php         // Main Plugin Class (Plugin initialization and hooks)
│   ├── class-wc-stock-restoration.php          // Stock restoration logic (for cancelled orders)
│   ├── class-wc-stock-update-on-new-order.php  // Logic to add stock note on new orders
└── woocommerce-auto-stock-restore.php          // Main plugin entry file      
```

---

#### Key Features:

-   Automatically restores stock for simple and variable products.
-   Adds detailed order notes for transparency and tracking.
-   Seamlessly integrates with WooCommerce's stock management system.

---

### Installation

1.  Upload the `woocommerce-auto-stock-restore` folder to the `/wp-content/plugins/` directory.
2.  Activate the plugin through the **Plugins** menu in WordPress.
3.  Test by cancelling an **On-Hold**, **Processing**, or **Completed** order to see the inventory/stock restored.

---

### Frequently Asked Questions

**Q: Does this work with variable products?**\
A: Yes, the plugin supports both simple and variable products.

**Q: What happens if WooCommerce stock management is disabled?**\
A: The plugin will not take any action if stock management is disabled in WooCommerce settings.

**Q: Can I see the stock changes in the order?**\
A: Yes, the plugin adds order notes detailing the restored stock levels for full transparency.

---

### Changelog

**1.0.4**

-   Fixed issue with restoring stock for orders with multiple products, including both simple and variable products.
-   Added functionality to restore individual stock for each product, including variations, when an order is cancelled.
-   Ensured compatibility with existing plugins and external stock sync systems, like **Lightspeed**.

#### 1.0.3

-   Added functionality to log stock values on new orders.
-   Updated code structure to comply with OOP principles.
-   Improved documentation and added class-level comments.

#### 1.0.2

-   Improved code for compatibility with modern WooCommerce methods.
-   Enhanced support for variable products.
-   Updated documentation and added comprehensive comments to the code.

#### 1.0.1

-   Added `woocommerce_auto_stock_restored` action.

#### 1.0.0

-   Initial release.
