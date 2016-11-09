<?php
/**
 * The Settings page of the plugin.
 *
 * @link       http://opusmagnum.ch
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
 * @author     Felipe Paul Martins <fpm@opusmagnum.ch>
 */
if ( !class_exists( 'WADT_Settings' ) ) {

	/**
	 * Class Woo_Default_Attributes_Admin
	 * @since	1.0.0
	 */
	class WADT_Settings {

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
		 * WooCommerce user defined attributes.
		 *
		 * @since		1.0.0
		 * @access	private
		 * @var			string	$wc_attrs	WooCommerce user defined attributes.
		 */
		private $wc_attrs;

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

			$this->register_hooks();
		}

		/**
		 * Register the actions and filters specific for the settings page.
		 *
		 * @since		1.0.0
		 */
		private function register_hooks() {
			add_action( 'admin_init', array( $this, 'register_settings' ) );
			add_action( 'admin_menu', array( $this, 'register_settings_menu' ), 99 );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_files' ) );
			add_action( 'admin_footer', array( $this, 'render_js_template' ) );
			add_action( 'admin_notices', array( $this, 'settings_updated_notice' ) );
		}

		/**
		 * Register setting, section and field.
		 *
		 * @since		1.0.0
		 */
		public function register_settings(){

			register_setting('wdat', 'wdat_attributes');

			add_settings_section(
				'wdat_default_attributes',
				__( "Settings", 'pbtt' ),
				array( $this,  'render_desc' ),
				'wdat'
			);

			add_settings_field(
				'wdat_product',
				'',
				array( $this, 'render_field' ),
				'wdat',
				'wdat_default_attributes'
			);

		}

		/**
		 * Register the settings page in WP menu.
		 *
		 * @since		1.0.0
		 */
		public function register_settings_menu(){

			$this->wc_attrs = wc_get_attribute_taxonomies();

			// Do not register menu if there are no attributes defined
			if ( empty($this->wc_attrs) ) {
				return;
			}

			add_submenu_page(
				'edit.php?post_type=product',
				__( "Woo Default Attributes", 'wdat' ),
				__( "Default attributes", 'wdat' ),
				'manage_options',
				'wdat',
				array( $this, 'render_page' )
			);

		}

		/**
		 * Prints HTML.
		 *
		 * @since		1.0.0
		 */
		public function render_desc() {
			_e( "Add, sort or remove attributes to define new product default attributes", 'wdat' );
		}
		public function render_field() {

			$attrs = get_option( 'wdat_attributes' );
			?>
			<div class="wdat-settings-wrapper">
				<div class="wdat-settings-head">
					<label for="wdat_attrs"><?php _e( "Select an attribute to add", 'wdat' ); ?></label>
					<select id="wdat_attrs" name="wdat-select-attr">
						<?php
							$attrs_names = array();
							foreach ( $this->wc_attrs as $attr ) {
								$attr_name = wc_attribute_taxonomy_name( $attr->attribute_name );
								printf( '<option value="%s"%s>%s</option>', $attr_name, ( (is_array($attrs) && in_array($attr_name, $attrs)) ? ' disabled="disabled"' : '' ), $attr->attribute_label );

								if ( is_array($attrs) && in_array($attr_name, $attrs) ) {
									$attrs_names[$attr_name] = $attr->attribute_label;
								}
							}
						?>
					</select>
					<button id="wdat_add_attr" type="button" name="button"><?php _e( "Add", 'wdat' ); ?></button>
				</div>
				<div class="wdat-settings-list">
					<ul id="wdat_attr_list">
						<?php if ( !empty($attrs) ) :
							foreach ( $attrs as $attr_name ) :
								if ( array_key_exists($attr_name, $attrs_names) ) : ?>
									<li>
										<h3><?php echo $attrs_names[$attr_name]; ?></h3>
										<input type="hidden" name="wdat_attributes[]" value="<?php echo $attr_name; ?>">
										<button class="wdat-remove-attribute" type="button"><?php _e( "Remove", 'wdat' ); ?></button>
									</li>
								<?php endif;
							endforeach;
						endif; ?>
					</ul>
				</div>
			</div>
			<?php
		}
		public function render_page() {
			if (!current_user_can('manage_options')) {
				return;
			}

			?>
			<div class="wrap wdat-wrap">
				<h1><?= esc_html(get_admin_page_title()); ?></h1>
				<form action="options.php" method="post">
					<?php
					settings_fields('wdat'); // security fields for the registered setting "wdat"
					do_settings_sections('wdat'); // setting sections and their fields
					submit_button(); // save settings button
					?>
				</form>
			</div>
			<?php
		}
		public function render_js_template() {

			$screen = get_current_screen();
			if ( 'product_page_wdat' !== $screen->base ) {
				return;
			}

			$tple  =	'<script type="text/html" id="tmpl-wdat">';
			$tple .=		'<li>';
			$tple .=			'<h3><%%= label %%></h3>';
			$tple .=			'<input type="hidden" name="wdat_attributes[]" value="<%%= name %%>">';
			$tple .=			'<button class="wdat-remove-attribute" type="button">%s</button>';
			$tple .=		'</li>';
			$tple .=	'</script>';

			printf( $tple, __( "Remove", 'wdat' ) );
		}

		/**
		 * Display a success notice if settings are successfully saved.
		 *
		 * @since		1.0.0
		 */
		public function settings_updated_notice() {

			$screen = get_current_screen();
			if ( 'product_page_wdat' !== $screen->base ) {
				return;
			}

			if ( ! (isset($_GET['settings-updated']) && $_GET['settings-updated']) ) {
				return;
			}

			$notice  =	'<div class="notice notice-success is-dismissible">';
			$notice .=		'<p><strong>%s</strong>, %s';
			$notice .=	'</div>';

			printf( $notice,
				__( 'Success', 'wdat' ),
				__( 'the default attributes have been saved!', 'wdat' )
			);
		}

		/**
		 * Enqueue style and javascript files
		 *
		 * @since	1.0.0
		 * @param	string	$hook_suffix	The current admin page.
		 */
		public function enqueue_files( $hook ) {

			if ( 'product_page_wdat' !== $hook ) {
				return;
			}

			wp_enqueue_script( 'wdat', trailingslashit(plugin_dir_url(__FILE__)).'js/wdat-settings.js', array('jquery', 'jquery-ui-sortable', 'underscore'), $this->version );
			wp_enqueue_style( 'wdat', trailingslashit(plugin_dir_url(__FILE__)). 'css/wdat-settings.css', false, $this->version );
		}
	}
}
