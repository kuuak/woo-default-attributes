=== Woo Default Attributes ===
Contributors: Kuuak
Tags: woocommerce, attribute, attributes, admin, administration
Requires at least: 4.4
Tested up to: 4.9.4
Stable tag: 1.0.3
Requires at least WooCommerce: 2.5
Tested up to WooCommerce: 3.3.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Define default attributes to be automatically added in WooCommerce new product page.

== Description ==

After setting up WooCommerce and defining product attributes, you can define the default attributes, as well as there order, to be automatically added to new product.

It will make the creation of new product more efficient and fast as you won't need
to add manually the attributes, and remembering the same order for each new product.

**Tested with WooCommerce version 3.3.3**

== Installation ==

1. Upload `woo-default-attributes.zip` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure the default attributes through the Menu `Product -> Default Attributes`

== Frequently Asked Questions ==

= Why does the default attributes do not show in an already created product ? =

This is a WooCommerce limitation.

= Is this plugin kept up to date =

I unfortunately didn't have much time to keep this plugin up to date in the past year (2017), but will now find the time to keep this updated.

== Contribute ==

Don't hesitate to fork this plugin and submit pull requests in the [github repo](https://github.com/Kuuak/woo-default-attributes).

== Screenshots ==

1. Default attributes set for a new product
2. Configuration of the default attributes

== Changelog ==

= 1.0.3 =
* Fix a 500 server error on ajax request. Thanks @aminta, @walpap and @zluke for the bug report
* Do no init the plugin if WooCommerce is not enabled. Thanks @adryyy for the pull request

= 1.0.2 =
* Tested plugin with WordPress 4.9.4 and WooCommerce 3.3.1

= 1.0.1 =
* Fix default attributes order. thanks to @Spinal for the fix.
* Tested plugin with WordPress 4.9.2 and WooCommerce 3.3.0

= 1.0.0 =
* Initial release
