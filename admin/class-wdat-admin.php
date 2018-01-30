<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/Kuuak/woo-default-attributes
 * @since      1.0.0
 *
 * @package    Woo_Default_Attributes
 * @subpackage Woo_Default_Attributes/admin
 */

/* Prevent loading this file directly */
defined( 'ABSPATH' ) || exit;

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    Woo_Default_Attributes
 * @subpackage Woo_Default_Attributes/admin
 * @author     Kuuak
 */
if ( !class_exists( 'WDAT_Admin' ) ) {

	/**
	 * Class WDAT_Admin
	 * @since	1.0.0
	 */
	class WDAT_Admin {

		/**
		 * The ID of this plugin.
		 *
		 * @since		1.0.0
		 * @access	private
		 * @var			string	$plugin_name	The ID of this plugin.
		 */
		private $plugin_name;

		/**
		 * The version of this plugin.
		 *
		 * @since		1.0.0
		 * @access	private
		 * @var			string	$version	The current version of this plugin.
		 */
		private $version;

		/**
		 * Initialize the class and set its properties.
		 *
		 * @since		1.0.0
		 * @param		string	$plugin_name	The name of this plugin.
		 * @param		string	$version			The version of this plugin.
		 */
		public function __construct( $plugin_name, $version ) {
			$this->plugin_name = $plugin_name;
			$this->version = $version;

			$this->load_settings();
			$this->register_hooks();
		}

		/**
		 * Create instance of plugin's settings page functionnalities
		 *
		 * @since		1.0.0
		 */
		private function load_settings() {
			$settings = new WADT_Settings( $this->get_plugin_name(), $this->get_version() );
		}

		/**
		 * Register the actions and filters related to the admin area functionality.
		 *
		 * @since		1.0.0
		 */
		private function register_hooks() {

			add_action( 'get_post_metadata', array( $this, 'get_post_metadata'), 10, 3 );
			add_action( 'plugin_action_links_woo-default-attributes/woo-default-attributes.php', array( $this, 'settings_action_link'), 1 );
		}

		/**
		 * Filters whether to retrieve metadata of a specific type.
		 *
		 * @since 1.0.0
		 *
		 * @param		null|array|string	$value			The value get_metadata() should return - a single metadata value, or an array of values.
		 * @param		int								$object_id	Object ID.
		 * @param		string						$meta_key		Meta key.
		 * @param		bool							$single			Whether to return only the first value of the specified $meta_key.
		 * @return	array													The value get_metadata() should return - a single metadata value,
		 */
		public function get_post_metadata( $value, $object_id, $meta_key ) {

			if ( '_product_attributes' == $meta_key && is_admin() ) {

				$screen = get_current_screen();
				if ( 'add' === $screen->action ) {

					$attrs = get_option( 'wdat_attributes' );
					if ( !empty( $attrs ) ) {

						$return = array();
						foreach ( $attrs as  $i => $attr_name ) {

							$return[ $attr_name ] = array(
								'name'					=> $attr_name,
								'value'					=> "",
								'position'			=> $i,
								'is_visible'		=> 1,
								'is_variation'	=> 0,
								'is_taxonomy'		=> 1,
							);
						}

						$value = array($return);
					}
				}
			}

			return $value;
		}

		/**
		 * Add settings action link on plugin page
		 *
		 * @since		1.0.0
		 *
		 * @param		array	$links	An array of plugin action links
		 * @return	array					Array with extra setting link
		 */
		public function settings_action_link( $links ) {

			$action_links = array(
				'settings' => sprintf( '<a href="%s" title="%s">%s</a>',
					admin_url( 'edit.php?post_type=product&page=wdat' ),
					__( 'View Woo Default Attributes Settings', 'wdat' ),
					__( 'Settings', 'wdat' )
				)
			);

			return array_merge( $action_links, $links );
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
