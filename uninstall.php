<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package		Woo_Default_Attributes
 * @author		Felipe Paul Martins <fpm@opusmagnum.ch>
 * @license		GPL-2.0+
 * @link			http://opusmagnum.ch
 */

	// If uninstall not called from WordPress, then exit.
	if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
		exit;
	}

	// Delete options
	delete_option( 'wdat_attributes' );
