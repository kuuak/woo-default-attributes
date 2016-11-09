<?php
/**
 * Plugin Name:		Woo Default Attributes
 * Description: 	Define default attributes to be automatically added in WooCommerce new product page.
 * Author: 				Felipe Paul Martins - Opus Magnum
 * Version: 			1.0.0
 * Author URI:		https://opusmagnum.ch
 * License:				GPL-2.0+
 * License URI:		http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:		wdat
 * Domain Path:		/languages
 *
 * Woo Default Attributes is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume
 * that you can use any other version of the GPL.
 *
 * Woo Default Attributes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package		Woo_Default_Attributes
 * @author		Felipe Paul Martins <fpm@opusmagnum.ch>
 * @license		GPL-2.0+
 * @link			https://opusmagnum.ch
 */

/* Prevent loading this file directly */
defined( 'ABSPATH' ) || exit;

/**
 * Add default options on plugin activation.
 * @since 1.1
 */
function woo_default_attributes_activate() {}
register_activation_hook( __FILE__, 'woo_default_attributes_activate' );


if ( !class_exists( 'Woo_Default_Attributes' ) ) {

	/**
	 * Class Woo_Default_Attributes
	 * @since 1.0.0
	 */
	class Woo_Default_Attributes {

		/**
		 * The current version of the plugin.
		 *
		 * @since		1.0.0
		 * @access	protected
		 * @var			string	$version	The current version of the plugin.
		 */
		protected $version;

		/**
		 * The directory path of the plugin.
		 *
		 * @since		1.0.0
		 * @access	protected
		 * @var			string	$dir_path	The directory path of the plugin.
		 */
		protected $dir_path;

		/**
		 * The directory URI of the plugin.
		 *
		 * @since		1.0.0
		 * @access	protected
		 * @var			string	$dir_uri	The directory URI of the plugin.
		 */
		protected $dir_uri;

		/**
		 * Class Constructor.
		 *
		 * @since		1.0.0
		 */
		public function __construct() {

			$this->version			= '1.0.0';
			$this->plugin_name	= 'woo-default-attributes';
			$this->dir_path			= trailingslashit( plugin_dir_path( __FILE__ ) );
			$this->dir_uri			= trailingslashit( plugin_dir_url(  __FILE__ ) );

			$this->load_dependencies();
			$this->load_textdomain();
		}

		/**
		 * Init the plugin functions
		 *
		 * @since		1.0.0
		 */
		private function load_dependencies() {

			/**
			 * The class responsible for defining all actions that occur in the admin area.
			 */
			require_once $this->dir_path .'admin/class-wdat-admin.php';
			require_once $this->dir_path .'admin/class-wdat-settings.php';

			// Create instance of Admin plugin functionnalities
			$plugin_admin = new WDAT_Admin( $this->get_plugin_name(), $this->get_version() );
		}

		/**
		 * Load Localisation files.
		 *
		 * @since		1.0.0
		 */
		public function load_textdomain() {

			load_theme_textdomain( 'wdat', $this->dir_path .'/languages' );
		}

		/**
		 * The name of the plugin used to uniquely identify it within the context of
		 * WordPress and to define internationalization functionality.
		 *
		 * @since		1.0.0
		 * @return	string	The name of the plugin.
		 */
		public function get_plugin_name() {
			return $this->plugin_name;
		}

		/**
		 * Retrieve the version number of the plugin.
		 *
		 * @since		1.0.0
		 * @return	string	The version number of the plugin.
		 */
		public function get_version() {
			return $this->version;
		}
	}
}

new Woo_Default_Attributes();
